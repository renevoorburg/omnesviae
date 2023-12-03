<?php

namespace OmnesViae;

class RouteList
{
    private array $route;

    public function __construct(array $places)
    {
//        print_r($places);
//        exit;

//        $this->route = array();
//        foreach ($places as $place) {
//            $this->route[$place['@id']] = array();
//            foreach ($place['routes'] as $place) {
//                $this->route[$place['@id']][] = array('route' => $place, 'distance' => $place['distance']);
//            }
//        }

        $routeParts = array();
        foreach ($places as $place) {
            $routeParts[] = array('to' => $place, 'dist' => 0);

        }

        $this->route['route'] = $routeParts;

    }

    public function render(): void
    {
        echo json_encode($this->route);
    }

}

/*

{
    "route": [
        {
            "to": "TPPlace717",
            "dist": {
                "numeral": 56,
                "guessedUnit": "MP",
                "estimatedMP": 8
            }
        },
        {
            "to": "TPPlace718",
            "dist": {
                "numeral": 56,
                "guessedUnit": "L",
                "estimatedMP": 8
            }
        }
    ]
}



 *
 */

/*
$data = array(
"route" => array(
array(
"to" => "TPPlace717",
"dist" => array(
"numeral" => 56,
"guessedUnit" => "MP",
"estimatedMP" => 8
)
),
array(
"to" => "TPPlace718",
"dist" => array(
"numeral" => 56,
"guessedUnit" => "L",
"estimatedMP" => 8
)
)
)
);



}

*/