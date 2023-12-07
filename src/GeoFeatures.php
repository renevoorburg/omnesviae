<?php

namespace OmnesViae;

class GeoFeatures
{
    public function __construct(Tabula $data)
    {
        echo json_encode($data->getGeofeatures(), true);
    }


}