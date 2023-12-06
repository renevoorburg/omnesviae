<?php

namespace OmnesViae;

class GeoFeatures
{
    private array $geo_features;
    public function __construct(Tabula $data)
    {
        echo json_encode($data->getGeofeatures(), true);
    }


}