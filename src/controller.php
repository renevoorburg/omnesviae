<?php

require __DIR__ . '/../vendor/autoload.php';

$data = new OmnesViae\Tabula();


$route = new OmnesViae\Route($data->getRouteNetwork(), 'TPPlace558', 'TPPlace1203');
$route->getResults();

