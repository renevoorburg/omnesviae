<?php

namespace OmnesViae;

class GeoFeatures extends Tabula
{
    protected array $geoFeatures;

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

}