<?php

namespace OmnesViae;

class Tabula
{
    private array $data;
    private array $routeNetwork;

    public function __construct()
    {
        $this->data = json_decode(file_get_contents('../public/data/omnesviae.json'), true);
        foreach ($this->data['@graph'] as $value) {
            if ($value['@type'] === 'TravelAction') {
                if (preg_match('@^.*#(.*)_(.*)$@', $value['@id'], $matches)) {
                    $this->routeNetwork[$matches[1]][$matches[2]] = (int) $value['distance'];
                    $this->routeNetwork[$matches[2]][$matches[1]] = (int) $value['distance'];
                }
            }
        }
    }

    public function getRouteNetwork() : array
    {
        return $this->routeNetwork;
    }



}