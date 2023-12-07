<?php

require __DIR__ . '/../vendor/autoload.php';

$urlParts = explode('/', $_SERVER['DOCUMENT_URI']);
$action = $urlParts[1];
if ($action == "api" && isset($urlParts[2])) {
    $action = "api/" . $urlParts[2];
}

switch ($action) {
    case "api/labels":
        // returns matching place labels as json  for form autocomplete:
        // example /api/labels/forum
        $model = new OmnesViae\Tabula();
        $view = new OmnesViae\LabelList($model);
        $view->render($urlParts[3] ?? '');
        break;
    case "api/route":
        // return the shortest route as json:
        // example: /api/route/TPPlace558/TPPlace1203
        $model = new OmnesViae\Tabula();
        $route = new OmnesViae\Dijkstra($model->getRoutingMatrix(), $urlParts[3] ?? '', $urlParts[4] ?? '');
        echo json_encode($model->getRouteList($route->getShortestPath()));
        break;
    case "api/geofeatures":
        $geoFeatures = new OmnesViae\GeoFeatures();
        $geoFeatures->render();
        break;
    case "test":
        echo "test";

        //echo $model->nextLocatedPlaceOnRoad('TPPlace997', 'TPPlace998');
//        echo count($network['TPPlace558']);
//        print_r($network['TPPlace558']);
//        $view->render();
        break;
    default:
        echo "default";
        break;
}






