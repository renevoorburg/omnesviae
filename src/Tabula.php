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

    public function getRouteNetwork() : array
    {
        if (!isset($this->routeNetwork)) {
            foreach ($this->data['@graph'] as $value) {
                if ($value['@type'] === 'TravelAction') {
                    if (preg_match('@^.*#(.*)_(.*)$@', $value['@id'], $matches)) {
                        $this->routeNetwork[$matches[1]][$matches[2]] = (int)$value['dist'];
                        $this->routeNetwork[$matches[2]][$matches[1]] = (int)$value['dist'];
                    }
                }
            }
        }
        return $this->routeNetwork;
    }

    public function getGeofeatures() : array
    {
        $placesIndexed = array();
        $geoFeatures = array();
        $geoFeatures['type'] = 'FeatureCollection';
        $geoFeatures['features'] = array();
        foreach ($this->data['@graph'] as $value) {
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
            } elseif ($value['@type'] === 'TravelAction'
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