<?php

namespace OmnesViae;

class Tabula
{
    const PLACE_KEYS = ['label', 'classic', 'modern', 'alt', 'lat', 'lng', 'symbol'];

    public array $data;
    private array $routeNetwork;
    private array $places;

    public function __construct()
    {
        $this->data = json_decode(file_get_contents('../public/data/omnesviae.json'), true);
    }

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

    public function getRouteNetwork() : array
    {
        if (!isset($this->routeNetwork)) {
            $this->setupRouteNetwork();
        }
        return $this->routeNetwork;
    }


    public function nextPlaceOnRoad(string $previousPlace, string $currentPlace) : string
    {
        $routeNetwork = $this->getRouteNetwork();
        $nextPlace = '';
        if (count($routeNetwork[$currentPlace])===2) {
            $nextPlace = array_values(array_diff(array_keys($routeNetwork[$currentPlace]), [$previousPlace]))[0];
        }
        return $nextPlace;
    }

    public function nextLocatedPlaceOnRoad(string $previousPlace, string $currentPlace) : string
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
                $geoFeatures['features'][] = $feature;
            }
        }
        foreach ($this->data['@graph'] as $value) {
            // process roads:
            if ($value['@type'] === 'TravelAction'
                && isset($placesIndexed[self::getLocalName($value['from'][0]['@id'])])
                && isset($placesIndexed[self::getLocalName($value['to'][0]['@id'])])
            ) {
                $feature = array();
                $feature['type'] = 'Feature';
                $feature['geometry'] = array();
                $feature['geometry']['type'] = 'LineString';
                $feature['geometry']['coordinates'] = array();
                $feature['geometry']['coordinates'][] =
                    array($placesIndexed[self::getLocalName($value['from'][0]['@id'])]['lng'], $placesIndexed[self::getLocalName($value['from'][0]['@id'])]['lat']);
                $feature['geometry']['coordinates'][] =
                    array($placesIndexed[self::getLocalName($value['to'][0]['@id'])]['lng'], $placesIndexed[self::getLocalName($value['to'][0]['@id'])]['lat']);
                $feature['properties'] = array();
                $feature['properties']['id'] = $value['@id'];
                $geoFeatures['features'][] = $feature;
            } elseif  ($value['@type'] === 'TravelAction'
                && isset($placesIndexed[self::getLocalName($value['from'][0]['@id'])])
            ) {
//                echo "hiet\n";
                $nextPlace = $this->nextLocatedPlaceOnRoad(self::getLocalName($value['from'][0]['@id']), self::getLocalName($value['to'][0]['@id']));
                if (!empty($nextPlace)) {
//                    echo "nextPlace: $nextPlace\n";
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
                    $feature['properties']['id'] = $value['@id'];
                    $geoFeatures['features'][] = $feature;
                }
            }
        }
        return $geoFeatures;
    }

    public static function getLocalName(string $uri) : string
    {
        $parsedUri = parse_url($uri);
        return $parsedUri['fragment'] ?? '';
    }

}