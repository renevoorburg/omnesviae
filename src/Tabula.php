<?php

namespace OmnesViae;

/**
 * Class Tabula
 *
 * Represents the Tabula Peutingeriana (map) with places and routes.
 * Reads the schema.org JSON-LD file and stores it in $data.
 * Provides methods to extract places and routes from $data.
 */
class Tabula
{
    const PLACE_KEYS = ['label', 'classic', 'modern', 'alt', 'lat', 'lng', 'symbol'];

    public array $data;
    private array $routeNetwork;
    private array $places;

    /**
     * Tabula constructor.
     * Reads the schema.org JSON-LD file and stores it in $data
     */
    public function __construct()
    {
        try {
            $this->data = json_decode(file_get_contents('../public/data/omnesviae.json'), true);
        } catch (\Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }

    }

    /**
     * Build an indexed array of places
     * @return void
     */
    public function setupPlaces(): void
    {
        $this->places = array();
        foreach ($this->data['@graph'] as $value) {
            if ($value['@type'] === 'Place') {
                $localName = self::getLocalName($value['@id']);
                foreach (self::PLACE_KEYS as $key) {
                    if (isset($value[$key])) {
                        $this->places[$localName][$key] = $value[$key];
                    }
                }
            }
        }
    }

    /**
     * Build a two-dimensional array of places and distances in between
     * @return void
     */
    public function setupRouteNetwork(): void
    {
        $this->routeNetwork = array();
        foreach ($this->data['@graph'] as $value) {
            if ($value['@type'] === 'TravelAction') {
                if (preg_match('@^.*#(.*)_(.*)$@', $value['@id'], $matches)) {
                    $this->routeNetwork[$matches[1]][$matches[2]] = (int)$value['dist'];
                    $this->routeNetwork[$matches[2]][$matches[1]] = (int)$value['dist'];
                }
            }
        }
    }

    /**
     * Return the two-dimensional array of places and distances
     * @return array
     */
    public function getRouteNetwork() : array
    {
        if (!isset($this->routeNetwork)) {
            $this->setupRouteNetwork();
        }
        return $this->routeNetwork;
    }

    /**
     * Return the neighbouring place on the road, coming from $previousPlace
     * @param string $previousPlace
     * @param string $currentPlace
     * @return string the neighbouring place on the road, may be empty string when road diverges or ends.
     */
    private function nextPlaceOnRoad(string $previousPlace, string $currentPlace) : string
    {
        $routeNetwork = $this->getRouteNetwork();
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
            if (isset($this->places[$nextPlace]['lat']) && isset($this->places[$nextPlace]['lng'])) {
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
        $placesIndexed = array();
        $geoFeatures = array();
        $geoFeatures['type'] = 'FeatureCollection';
        $geoFeatures['features'] = array();
        foreach ($this->data['@graph'] as $value) {
            // process places first:
            if ($value['@type'] === 'Place' && isset($value['lat']) && isset($value['lng'])) {
                $localName = self::getLocalName($value['@id']);
                $placesIndexed[$localName]['lat'] = $value['lat'];
                $placesIndexed[$localName]['lng'] = $value['lng'];
                $feature = array();
                $feature['type'] = 'Feature';
                $feature['geometry'] = array();
                $feature['geometry']['type'] = 'Point';
                $feature['geometry']['coordinates'] = array();
                $feature['geometry']['coordinates'][] = $value['lng'];
                $feature['geometry']['coordinates'][] = $value['lat'];
                $feature['properties'] = array();
                $feature['properties']['name'] = $value['label'];
                $feature['properties']['description'] = $value['modern'];
                $feature['properties']['id'] = $localName;
                if (isset($value['symbol'])) {
                    $feature['properties']['symbol'] = $value['symbol'];
                }
                $geoFeatures['features'][] = $feature;
            }
        }
        foreach ($this->data['@graph'] as $value) {
            // process roads:
            if ($value['@type'] === 'TravelAction'
                && isset($placesIndexed[self::getLocalName($value['from'][0]['@id'])])
            ) {
                if (!isset($placesIndexed[self::getLocalName($value['to'][0]['@id'])])) {
                    $nextPlace = $this->nextLocatedPlaceOnRoad(self::getLocalName($value['from'][0]['@id']), self::getLocalName($value['to'][0]['@id']));
                    $extrapolated = true;
                } else {
                    $nextPlace = self::getLocalName($value['to'][0]['@id']);
                    $extrapolated = false;
                }
                if (!empty($nextPlace)) {
                    $feature = array();
                    $feature['type'] = 'Feature';
                    $feature['geometry'] = array();
                    $feature['geometry']['type'] = 'LineString';
                    $feature['geometry']['coordinates'] = array();
                    $feature['geometry']['coordinates'][] =
                        array($placesIndexed[self::getLocalName($value['from'][0]['@id'])]['lng'], $placesIndexed[self::getLocalName($value['from'][0]['@id'])]['lat']);
                    $feature['geometry']['coordinates'][] =
                        array($placesIndexed[$nextPlace]['lng'], $placesIndexed[$nextPlace]['lat']);
                    $feature['properties'] = array();
                    $feature['properties']['id'] = self::getLocalName($value['@id']);
                    if ($extrapolated) {
                        $feature['properties']['extrapolated'] = true;
                    }
                    $geoFeatures['features'][] = $feature;
                }

            }
        }
        return $geoFeatures;
    }

    /**
     * Return the local name of a URI
     * @param string $uri the URI, assuming the local name is a fragment
     * @return string
     */
    public static function getLocalName(string $uri) : string
    {
        $parsedUri = parse_url($uri);
        return $parsedUri['fragment'] ?? '';
    }

}