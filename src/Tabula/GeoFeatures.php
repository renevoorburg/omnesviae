<?php

namespace OmnesViae\Tabula;

class GeoFeatures extends Roads
{
    private array $geoFeatures;

    /**
     * Build a GeoJSON FeatureCollection of places and roads
     * @return void
     */
    public function setupGeofeatures() : void
    {
        $this->geoFeatures = array();
        $this->geoFeatures['type'] = 'FeatureCollection';
        $this->geoFeatures['features'] = array();
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
                $this->geoFeatures['features'][] = $feature;
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
                        $this->geoFeatures['features'][] = $feature;
                    }
                }
            }
        }
    }

    /**
     * Return the GeoJSON FeatureCollection of places and roads
     * as a JSON string
     * @return void
     */
    public function render() : void
    {
        if (!isset($this->geoFeatures)) {
            $this->setupGeofeatures();
        }
        echo json_encode($this->geoFeatures, true);
    }

}