<?php

namespace OmnesViae\Tabula;

class Places
{
    const PLACE_KEYS = ['label', 'classic', 'modern', 'alt', 'lat', 'lng', 'symbol'];
    private array $places;

    /**
     * Builds an indexed array of places in $this->places
     * @param array $data the Tabula data
     * @return void .
     */
    public function __construct(array $tabulaData)
    {
        $this->places = array();
        foreach ($tabulaData['@graph'] as $value) {
            if ($value['@type'] === 'Place') {
                $localName = Tabula::getLocalId($value['@id']);
                foreach (self::PLACE_KEYS as $key) {
                    if (isset($value[$key])) {
                        $this->places[$localName][$key] = $value[$key];
                    }
                }
            }
        }
    }

    /**
     * returns the place property for a given place
     * @param string $place
     * @param string $property
     * @return string|null
     */
    public function getProperty(string $place, string $property) : ?string
    {
        return $this->places[$place][$property] ?? null;
    }

    /**
     * returns true if the place has coordinates
     * @param string $place
     * @return bool
     */
    public function hasCoordinates(string $place) : bool
    {
        return isset($this->places[$place]['lng']) && isset($this->places[$place]['lat']);
    }

    /**
     * returns the coordinates of a place
     * @param string $place
     * @return array [lng, lat]
     */
    public function getCoordinates(string $place) : array
    {
        return $this->hasCoordinates($place) ? array($this->getProperty($place, 'lng'), $this->getProperty($place, 'lat')) : array(null, null);
    }


}