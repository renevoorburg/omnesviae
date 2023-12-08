<?php

namespace OmnesViae\Tabula;

use OmnesViae\Dijkstra;

class Routing extends Roads
{
    private array $route;

    public function setRoute(string $from, string $to) : void
    {
        $dijkstra = new Dijkstra($this->routingMatrix, $from, $to);
        $this->route = $dijkstra->getShortestPath();
    }

    /**
     * Render the route as JSON
     * @return void
     */
    public function render() : void
    {
        echo json_encode($this->getRouteList($this->route));
    }

    /**
     * Return an enriched route list with distances and road data
     * @param array $places
     * @return array|null
     */
    private function getRouteList(array $places) : ?array
    {
        $routeList = array();
        $routeParts = array();
        $previousPlace = '';
        foreach ($places as $place) {
            $dist = array();
            $numeral = $this->getRoutingDistance($previousPlace, $place);
            if ($numeral) {
                $dist['numeral'] = $numeral;
            }
            if (isset($this->roads[self::constructRoadId($previousPlace, $place)]['isReconstructed'])) {
                $dist['isReconstructed'] = true;
            }
            foreach (self::ROAD_KEYS as $key) {
                if (isset($this->roads[self::constructRoadId($previousPlace, $place)][$key])) {
                    $dist[$key] = $this->roads[self::constructRoadId($previousPlace, $place)][$key];
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
     * Return a distance from the routing matrix
     * @param string $from
     * @param string $to
     * @return int
     */
    private function getRoutingDistance(string $from, string $to) : int
    {
        return $this->routingMatrix[$from][$to] ?? 0;
    }

    /**
     * Create a local road id from two place names
     * @param string $from
     * @param string $to
     * @return string
     */
    private static function constructRoadId(string $from, string $to) : string
    {
        if ($from > $to) {
            return self::constructRoadId($to, $from);
        }
        return $from . '_' . $to;
    }

}