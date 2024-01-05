<?php

namespace OmnesViae;

class Translations implements \Iterator {
    private $translations = [];
    private $position = 0;

    public function __construct($page, $lang) {
        $this->position = 0;

        $data = [];
        include (__DIR__ . '/../lang/'.$lang.'.php');
        $this->translations = $data[$page];

    }

    public function rewind() {
        $this->position = 0;
    }

    public function current() {
        return array_values($this->translations)[$this->position];
    }

    public function key() {
        return array_keys($this->translations)[$this->position];
    }

    public function next() {
        ++$this->position;
    }

    public function valid() {
        return isset(array_keys($this->translations)[$this->position]);
    }
}
