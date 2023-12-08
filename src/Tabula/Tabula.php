<?php

namespace OmnesViae\Tabula;

use Exception;

/**
 * Class Tabula
 *
 * Represents the Tabula Peutingeriana (map) with places and routes.
 * Reads the schema.org JSON-LD file and stores it in $data.
 * Provides methods to extract places and routes from $data.
 */
class Tabula
{
    public array $tabula; 
    protected Places $places;

    /**
     * Tabula constructor.
     * Reads the schema.org JSON-LD file in $this->tabula
     * Sets up the Places object
     */
    public function __construct(string $source = '../public/data/omnesviae.json')
    {
        try {
            if (filter_var($source, FILTER_VALIDATE_URL)) {
                $jsonData = file_get_contents($source);
            } else {
                $jsonData = file_get_contents($source);
            }
            $this->tabula = json_decode($jsonData, true);
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
            exit;
        }
        $this->places = new Places($this->tabula);
    }

    /**
     * Return the local name of a URI
     * @param string $uri the URI, assuming the local name is a fragment
     * @return string
     */
    public static function getLocalId(string $uri) : string
    {
        $parsedUri = parse_url($uri);
        return $parsedUri['fragment'] ?? '';
    }

}