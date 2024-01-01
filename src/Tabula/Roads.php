<?php

namespace OmnesViae\Tabula;

use OmnesViae\GeoTools;

class Roads extends Tabula
{
    const MILE_FACTOR = 1.5;
    const MEANDER_FACTOR = 1.2;
    const ROAD_KEYS = ['overWater', 'isReconstructed', 'crossesMountains', 'crossesRiver'];

    protected array $routingMatrix;
    protected array $roads;


    public function __construct(?string $datasource = null)
    {
        parent::__construct($datasource);
        $this->setup();
    }

    /**
     * Build a two-dimensional routing matrix with distances in $this->routingMatrix
     * Builds an indexed array of roads in $this->roads, only for roads with specific data.
     * @return void
     */
    private function setup()
    {
        $this->routingMatrix = array();
        $this->roads = array();
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
                            $this->roads[Tabula::getLocalId($value['@id'])]['isReconstructed'] = true;
                            $distance = $this->metersToRomanMiles($distanceMeters);
                        }
                    }
                    foreach (self::ROAD_KEYS as $key) {
                        if (isset($value[$key])) {
                            $this->roads[Tabula::getLocalId($value['@id'])][$key] = $value[$key];
                        }
                    }
                    $this->routingMatrix[$matches[1]][$matches[2]] = $distance;
                    $this->routingMatrix[$matches[2]][$matches[1]] = $distance;
                }
            }
        }
    }

    /**
     * Return the estimated road distance in meters
     * @param array $lnglat1 [lng, lat]
     * @param array $lnglat2 [lng, lat]
     * @return int|null
     */
    private function getEstimatedRoadDistanceMeters(array $lnglat1, array $lnglat2) : ?int
    {
        if ($lnglat1[0] && $lnglat2[0] && $lnglat1[1] && $lnglat2[1] && $lnglat1[0] !== $lnglat2[0] && $lnglat1[1] !== $lnglat2[1]) {
            $distance = GeoTools::distanceBetweenPoints($lnglat1, $lnglat2);
            return ceil(self::MEANDER_FACTOR * $distance);
        }
        return null;
    }

    /**
     * Return the number of Roman miles for a distance in meters
     * @param int $meters
     * @return int
     */
    private function metersToRomanMiles(int $meters) : int
    {
        return ceil($meters / 1000 / self::MILE_FACTOR);
    }

    /**
     * Return the next place on the road that has a lat/lng, coming from $previousPlace
     * @param string $previousPlace
     * @param string $currentPlace
     * @return string the next place on the road that has a lat/lng , may be empty string when road diverges or ends.
     */
    public function nextLocatedPlaceOnRoad(string $previousPlace, string $currentPlace) : string
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
    public function nextPlaceOnRoad(string $previousPlace, string $currentPlace) : string
    {
        $nextPlace = '';
        if (count($this->routingMatrix[$currentPlace])===2) {
            $nextPlace = array_values(array_diff(array_keys($this->routingMatrix[$currentPlace]), [$previousPlace]))[0];
        }
        return $nextPlace;
    }

}