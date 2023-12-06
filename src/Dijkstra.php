<?php

namespace OmnesViae;

class Dijkstra {

    protected array $visited;
    protected array $distance;
    protected array $previousNode;

    protected $startnode ;
    protected $to;

    protected array $map;
    protected $bestPath = 0;



    public function __construct($map, $start, $to) {
        $this->map = $map;
        $this->startnode = $start;
        $this->to = $to;
        $this->findShortestPath();
    }

    public function getShortestPath() :array
    {
        $ourShortestPath = array();

        foreach (array_keys($this->map) as $i) {
            if ($this->to !== null && $this->to !== $i) {
                continue;
            }
            $ourShortestPath[$i] = array();
            $endNode = null;
            $currNode = $i;
            $ourShortestPath[$i][] = $i;
            while ($endNode === null || $endNode != $this->startnode) {
                $ourShortestPath[$i][] = $this->previousNode[$currNode];
                $endNode = $this->previousNode[$currNode];
                $currNode = $this->previousNode[$currNode];
            }
            $ourShortestPath[$i] = array_reverse($ourShortestPath[$i]);

            if ($this->distance[$i] >= INF || $this->startnode === $this->to) {
                return [];
            }
            return $ourShortestPath[$i];
        }
        return [];
    }

    private function findShortestPath() : void
    {
        // initialize $visited, $distance and $previousNode arrays
        foreach (array_keys($this->map) as $i) {
            if ($i == $this->startnode) {
                $this->visited[$i] = true;
                $this->distance[$i] = 0;
            } else {
                $this->visited[$i] = false;
                $this->distance[$i] = $this->map[$this->startnode][$i] ?? INF;
            }
            $this->previousNode[$i] = $this->startnode;
        }
        $maxTries = count($this->map);
        for ($tries = 0; in_array(false, $this -> visited,true) && $tries <= $maxTries; $tries++) {
            $this->bestPath = $this->findBestPath($this->distance, array_keys($this->visited,false,true));
            if ($this->to !== null && $this->bestPath === $this->to) {
                break;
            }
            $this->updateDistanceAndPrevious($this->bestPath);
            $this->visited[$this->bestPath] = true;
        }
    }

    private function findBestPath($ourDistance, $ourNodesLeft)
    {
        $bestPath = INF;
        $bestNode = 0;
        foreach ($ourNodesLeft as $node) {
            if($ourDistance[$node] < $bestPath) {
                $bestPath = $ourDistance[$node];
                $bestNode = $node;
            }
        }
        return $bestNode;
    }

    private function updateDistanceAndPrevious($obp) : void
    {
        foreach (array_keys($this->map) as $i) {
            if ( 	isset($this->map[$obp][$i])
                &&	($this->map[$obp][$i] != INF || $this->map[$obp][$i] == 0 )
                &&	($this->distance[$obp] + $this->map[$obp][$i] < $this->distance[$i])
            )
            {
                $this->distance[$i] = $this->distance[$obp] + $this->map[$obp][$i];
                $this->previousNode[$i] = $obp;
            }
        }
    }

}


