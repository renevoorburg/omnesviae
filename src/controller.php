<?php

require __DIR__ . '/../vendor/autoload.php';


$data = new OmnesViae\Tabula();

//$route = new OmnesViae\Route($data->getRouteNetwork(), 'TPPlace558', 'TPPlace1203');
//$route->getResults();

function normalize(string $name) : string
{
    $name = strtolower($name);
    $name = mb_ereg_replace("'", '', $name);
    $name = mb_ereg_replace('u', 'v', $name);
    $name = mb_ereg_replace('j', 'i', $name);
    $name = mb_ereg_replace('v̄', 'v', $name);

    return $name;
}


foreach ($data->data['@graph'] as $value) {
    if ($value['@type'] === 'Place') {
        if (!empty($value['label'])) {
            $arr[normalize($value['label'])] = array('@id' => $value['@id'], 'display' => $value['label']);
        }
        if (!empty($value['classic'])) {
            $arr[normalize($value['classic'])] = array('@id' => $value['@id'], 'display' => $value['classic']);
        }
        if (!empty($value['modern'])) {
            $arr[normalize($value['modern'])] = array('@id' => $value['@id'], 'display' => $value['modern']);
        }
        if (!empty($value['alt'])) {
            $arr[normalize($value['alt'])] = array('@id' => $value['@id'], 'display' => $value['alt']);
        }

    }
}

ksort($arr);
//print_r($arr);
$chars="aba";

$filteredArray = array();
$found = false;
foreach ($arr as $key => $value) {
    if (strpos($key, $chars) === 0) {
        // Key starts with the given sequence of characters
        $filteredArray[$key] = $value;
        $found = true;
    } elseif ($found === true) { break; }
}

echo "[";
$sep = "";
foreach ($filteredArray as $key => $value) {
    echo $sep . '{ "label": "' . $value['display'] . ', "value": "' . $value['@id'] . '" }';
    $sep = ",";
}
echo "]";