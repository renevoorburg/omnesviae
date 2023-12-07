<?php

namespace OmnesViae;

use Exception;

/**
 * Class Tabula
 *
 * Represents the Tabula Peutingeriana (map) with places and routes.
 * Reads the schema.org JSON-LD file and stores it in $data.
 * Provides methods to extract places and routes from $data.
 */
class Tabula
{

    const ROAD_KEYS = ['overWater', 'isReconstructed', 'crossesMountains', 'crossesRiver'];

    public array $tabula;
    private array $roads;
    private array $routingMatrix;
    private Places $places;


    /**
     * Tabula constructor.
     * Reads the schema.org JSON-LD file in $this->tabula
     */
    public function __construct()
    {
        try {
            $this->tabula = json_decode(file_get_contents('../public/data/omnesviae.json'), true);
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
            exit;
        }
        $this->places = new Places($this->tabula);
    }

    /**
     * Build a two-dimensional routing matrix with distances in $this->routingMatrix
     * Builds an indexed array of roads in $this->roads, only for roads with specific data.
     * @return void
     */
    public function setupRouting(): void
    {
        $this->routingMatrix = array();
        foreach ($this->tabula['@graph'] as $value) {
            if ($value['@type'] === 'TravelAction') {
                if (preg_match('@^.*#(.*)_(.*)$@', $value['@id'], $matches)) {
                    $distance = (int)$value['dist'];
                    if ($distance === 0) {
                        $distanceMeters = $this->getEstimatedRoadDistanceMeters(
                            [$this->places->getProperty($matches[1], 'lng'), $this->places->getProperty($matches[1], 'lat')],
                            [$this->places->getProperty($matches[2], 'lng'), $this->places->getProperty($matches[2], 'lat')]
                        );
                        if (!is_null($distanceMeters)) {
                            $this->roads[self::getLocalId($value['@id'])]['isReconstructed'] = true;
                            $distance = $this->metersToRomanMiles($distanceMeters);
                        }
                    }
                    foreach (self::ROAD_KEYS as $key) {
                        if (isset($value[$key])) {
                            $this->roads[self::getLocalId($value['@id'])][$key] = $value[$key];
                        }
                    }
                    $this->routingMatrix[$matches[1]][$matches[2]] = $distance;
                    $this->routingMatrix[$matches[2]][$matches[1]] = $distance;
                }
            }
        }
    }


    /**
     * Return the two-dimensional routing matrix of places and distances
     * @return array
     */
    public function getRoutingMatrix() : array
    {
        if (!isset($this->routingMatrix)) {
            $this->setupRouting();
        }
        return $this->routingMatrix;
    }

    /**
     * Return a distance from the routing matrix
     * @param string $from
     * @param string $to
     * @return int
     */
    private function getDistance(string $from, string $to) : int
    {
        $routeNetwork = $this->getRoutingMatrix();
        return $routeNetwork[$from][$to] ?? 0;
    }

    private function metersToRomanMiles(int $meters) : int
    {
        $MILE_FACTOR = 1.5;
        return ceil($meters / 1000 / $MILE_FACTOR);
    }

    /*
     * Return the estimated road distance in meters
     * @param array $place1 [lng, lat]
     * @param array $place2 [lng, lat]
     * @return int
     */
    private function getEstimatedRoadDistanceMeters(array $lnglat1, array $lnglat2) : ?int
    {
        $MEANDER_FACTOR = 1.2;

        if ($lnglat1[0] && $lnglat2[0] && $lnglat1[1] && $lnglat2[1] && $lnglat1[0] !== $lnglat2[0] && $lnglat1[1] !== $lnglat2[1]) {
            $distance = GeoTools::distanceBetweenPoints($lnglat1, $lnglat2);
            return ceil($MEANDER_FACTOR * $distance);
        }
        return null;
    }

    /**
     * Return the neighbouring place on the road, coming from $previousPlace
     * @param string $previousPlace
     * @param string $currentPlace
     * @return string the neighbouring place on the road, may be empty string when road diverges or ends.
     */
    private function nextPlaceOnRoad(string $previousPlace, string $currentPlace) : string
    {
        $routeNetwork = $this->getRoutingMatrix();
        $nextPlace = '';
        if (count($routeNetwork[$currentPlace])===2) {
            $nextPlace = array_values(array_diff(array_keys($routeNetwork[$currentPlace]), [$previousPlace]))[0];
        }
        return $nextPlace;
    }

    /**
     * Return the next place on the road that has a lat/lng, coming from $previousPlace
     * @param string $previousPlace
     * @param string $currentPlace
     * @return string the next place on the road that has a lat/lng , may be empty string when road diverges or ends.
     */
    private function nextLocatedPlaceOnRoad(string $previousPlace, string $currentPlace) : string
    {
        $foundLocatedPlace = '';
        while (true) {
            $nextPlace = $this->nextPlaceOnRoad($previousPlace, $currentPlace);
            if (empty($nextPlace)) {
                break;
            }
            if ($this->places->hasCoordinates($nextPlace)) {
                $foundLocatedPlace = $nextPlace;
                break;
            }
            $previousPlace = $currentPlace;
            $currentPlace = $nextPlace;
        }
        return $foundLocatedPlace;
    }

    /**
     * Build a GeoJSON FeatureCollection of places and roads
     * @return array
     */
    public function getGeofeatures() : array
    {
        $geoFeatures = array();
        $geoFeatures['type'] = 'FeatureCollection';
        $geoFeatures['features'] = array();
        foreach ($this->tabula['@graph'] as $value) {
            // process places first:
            if ($value['@type'] === 'Place' && isset($value['lat']) && isset($value['lng'])) {
                $feature = array();
                $feature['type'] = 'Feature';
                $feature['geometry'] = array();
                $feature['geometry']['type'] = 'Point';
                $feature['geometry']['coordinates'] = array();
                $feature['geometry']['coordinates'][] = $value['lng'];
                $feature['geometry']['coordinates'][] = $value['lat'];
                $feature['properties'] = array();
                $feature['properties']['name'] = $value['label'];
                $feature['properties']['id'] = self::getLocalId($value['@id']);
                if (isset($value['modern'])) {
                    $feature['properties']['description'] = $value['modern'];
                }
                if (isset($value['symbol'])) {
                    $feature['properties']['symbol'] = $value['symbol'];
                }
                $geoFeatures['features'][] = $feature;
            }
        }
        foreach ($this->tabula['@graph'] as $value) {
            // process roads:
            if ($value['@type'] === 'TravelAction') {
                $from = self::getLocalId($value['from'][0]['@id']);
                $to = self::getLocalId($value['to'][0]['@id']);
                if ( $this->places->hasCoordinates($from)) {
                    if (!$this->places->hasCoordinates($to)) {
                        $nextPlace = $this->nextLocatedPlaceOnRoad($from, $to);
                        $extrapolated = true;
                    } else {
                        $nextPlace = $to;
                        $extrapolated = false;
                    }
                    if (!empty($nextPlace)) {
                        $feature = array();
                        $feature['type'] = 'Feature';
                        $feature['geometry'] = array();
                        $feature['geometry']['type'] = 'LineString';
                        $feature['geometry']['coordinates'] = array();
                        $feature['geometry']['coordinates'][] = $this->places->getCoordinates($from);
                        $feature['geometry']['coordinates'][] = $this->places->getCoordinates($nextPlace);
                        $feature['properties'] = array();
                        $feature['properties']['id'] = self::getLocalId($value['@id']);
                        if ($extrapolated) {
                            $feature['properties']['extrapolated'] = true;
                        }
                        if (isset($value['overWater'])) {
                            $feature['properties']['overWater'] = true;
                        }
                        $geoFeatures['features'][] = $feature;
                    }
                }
            }
        }
        return $geoFeatures;
    }

    public function getRouteList(array $places) : ?array
    {
        $routeList = array();
        $routeParts = array();
        $previousPlace = '';
        foreach ($places as $place) {
            $dist = array();
            $numeral = $this->getDistance($previousPlace, $place);
            if ($numeral) {
                $dist['numeral'] = $numeral;
            }
            if (isset($this->roads[self::getRoadId($previousPlace, $place)]['isReconstructed'])) {
                $dist['isReconstructed'] = true;
            }
            foreach (self::ROAD_KEYS as $key) {
                if (isset($this->roads[self::getRoadId($previousPlace, $place)][$key])) {
                    $dist[$key] = $this->roads[self::getRoadId($previousPlace, $place)][$key];
                }
            }
            $routeParts[] = array(
                'to' => $place,
                'dist' => $dist
            );
            $previousPlace = $place;
        }
        $routeList['route'] = $routeParts;
        return $routeList;
    }

    /**
     * Return the local name of a URI
     * @param string $uri the URI, assuming the local name is a fragment
     * @return string
     */
    public static function getLocalId(string $uri) : string
    {
        $parsedUri = parse_url($uri);
        return $parsedUri['fragment'] ?? '';
    }

    private static function getRoadId(string $from, string $to) : string
    {
        if ($from > $to) {
            return self::getRoadId($to, $from);
        }
        return $from . '_' . $to;
    }

}