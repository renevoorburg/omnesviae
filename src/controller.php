<?php

require __DIR__ . '/../vendor/autoload.php';

$urlParts = explode('/', $_SERVER['DOCUMENT_URI']);
$action = $urlParts[1];
if ($action == "api" && isset($urlParts[2])) {
    $action = "api/" . $urlParts[2];
}

$datasource = $_GET['datasource'] ?? null;

$languageNegotiator = new \OmnesViae\Negotiator\LanguageNegotiator(['en', 'de', 'el', 'es', 'fr', 'it', 'la', 'nl']);
$language = $languageNegotiator->negotiate();

switch ($action) {
    case "api/labels":
        // returns matching place labels as json  for form autocomplete:
        // example: /api/labels/forum
        $model = new \OmnesViae\Tabula\Tabula($datasource);
        $view = new \OmnesViae\Tabula\LabelList($model);
        $view->render($urlParts[3] ?? '');
        break;
    case "api/route":
        // return the shortest route as json:
        // example: /api/route/TPPlace558/TPPlace1203
        $model = new \OmnesViae\Tabula\Routing($datasource);
        $model->setRoute($urlParts[3] ?? '', $urlParts[4] ?? '');
        $model->render();
        break;
    case "api/geofeatures":
        // example: /api/geofeatures
        $geoFeatures = new \OmnesViae\Tabula\GeoFeatures($datasource);
        $geoFeatures->render();
        break;
    case "":
        $mimeTypeNegotiator = new \OmnesViae\Negotiator\MimeTypeNegotiator(['text/html', 'application/ld+json', 'text/turtle', 'application/rdf+xml', 'application/n-triples', 'text/n3', 'application/json']);
        $mimeType = $mimeTypeNegotiator->negotiate();
        if ($mimeType === 'text/html') {
            $page = new \OmnesViae\Templating\Page('/', $language);
            $page->display('home.tpl');
        } else if (!empty($mimeType)) {
            $expanded = \ML\JsonLD\JsonLD::expand(file_get_contents(\OmnesViae\Tabula\Tabula::getDataSource()), true);
            $expandedJson = json_encode($expanded, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            $graph = new \EasyRdf\Graph();
            $graph->parse($expandedJson, 'jsonld');
            header('Content-Type: '.$mimeType.'; charset=UTF-8');
            echo $graph->serialise($mimeType);
        }
        break;
    case "tabula":
        $page = new \OmnesViae\Templating\Page('/tabula', $language);
        $page->assign('title', 'OmnesViae: Tabula Peutingeriana');
        $page->assign('name', 'Tabula Peutingeriana');

        $page->display('tabula.tpl');
        break;
    case "nobis":
        $page = new \OmnesViae\Templating\Page('/nobis', $language);
        $page->assign('name', 'OmnesViae');
        $page->display('nobis.tpl');
        break;
    default:
        echo "default";
        break;
}






