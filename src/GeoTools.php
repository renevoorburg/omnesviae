<?php

namespace OmnesViae;

class GeoTools
{

    /**
     * Calculate the distance between two points on the earth's surface
     * @param array $point1 [lng, lat]
     * @param array $point2 [lng, lat]
     * @return float in meters
     */
    public static function distanceBetweenPoints(array $point1, array $point2) : float
    {
        $earthRadius = 6371000;
        $lat1 = deg2rad($point1[1]);
        $lng1 = deg2rad($point1[0]);
        $lat2 = deg2rad($point2[1]);
        $lng2 = deg2rad($point2[0]);
        $latDelta = $lat2 - $lat1;
        $lngDelta = $lng2 - $lng1;
        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                cos($lat1) * cos($lat2) * pow(sin($lngDelta / 2), 2)));
        return $angle * $earthRadius;
    }

}