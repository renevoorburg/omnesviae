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
        // example: /api/labels/forum
        $model = new \OmnesViae\Tabula\Tabula();
        $view = new \OmnesViae\Tabula\LabelList($model);
        $view->render($urlParts[3] ?? '');
        break;
    case "api/route":
        // return the shortest route as json:
        // example: /api/route/TPPlace558/TPPlace1203
        $model = new \OmnesViae\Tabula\Routing();
        $model->setRoute($urlParts[3] ?? '', $urlParts[4] ?? '');
        $model->render();
        break;
    case "api/geofeatures":
        // example: /api/geofeatures
        $geoFeatures = new \OmnesViae\Tabula\GeoFeatures();
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






