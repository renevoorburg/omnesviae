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
        $route = new OmnesViae\Route($model->getRouteNetwork(), $urlParts[3] ?? '', $urlParts[4] ?? '');
        $route->getResults();
        break;
    case "api/geofeatures":
        $model = new OmnesViae\Tabula();
        $view = new OmnesViae\GeoFeatures($model);
//        $view->render();
        break;
    default:
        echo "default";
        break;
}






