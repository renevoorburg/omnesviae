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
    const DATASOURCE = '../public/data/omnesviae.json';
    public array $tabula;
    protected Places $places;

    /**
     * Tabula constructor.
     * Reads the schema.org JSON-LD file in $this->tabula
     * Sets up the Places object
     */
    public function __construct(?string $datasource = null)
    {
        $datasource = $datasource ?? self::DATASOURCE;
        if ($datasource !== self::DATASOURCE && !filter_var($datasource, FILTER_VALIDATE_URL)) {
            fprintf(STDERR, 'Invalid source URL provided: %s' . PHP_EOL, $datasource);
            exit(1);
        }
        try {
            $this->tabula = json_decode(file_get_contents($datasource), true);
        } catch (Exception $e) {
            fprintf(STDERR, 'Caught exception: %s' . PHP_EOL, $e->getMessage());
            exit(1);
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

    public static function getDataSource() : string
    {
        return self::DATASOURCE;
    }

}