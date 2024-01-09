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
    case "":
        $page = new \OmnesViae\Templating\Page('/', $language);
//        $page->assign('currentPage', '/');
        $page->display('home.tpl');
        break;
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
    case "test":
//        phpinfo();
        $lang = new \OmnesViae\LanguageSelector();
        echo $lang->getSelectedLanguage();
        break;
    default:
        echo "default";
        break;
}






