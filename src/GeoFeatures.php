<?php

namespace OmnesViae;

class GeoFeatures
{
    private array $geo_features;
    public function __construct(Tabula $data)
    {
//        print_r(geojson(file_get_contents('../public/data/geojsonjson'), true);
//            print_r(json_decode(file_get_contents('../public/data/geojson.json'), true));
        echo json_encode($data->getGeofeatures(), true);
    }


//    public function render() : void
//    {
//        echo json_encode($this->geo_features);
//    }


}