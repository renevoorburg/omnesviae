<?php

namespace OmnesViae;

class LabelList
{
    const LABEL_FILTER_KEYS = ['label', 'classic', 'modern', 'alt'];
    private array $labels;

    public function __construct(Tabula $model)
    {
        foreach ($model->data['@graph'] as $value) {
            foreach (self::LABEL_FILTER_KEYS as $key) {
                if (!empty($value[$key])) {
                    $this->labels[self::simplifyString($value[$key])] = array('@id' => Tabula::getLocalName($value['@id']), 'display' => $value[$key]);
                }
            }
        }
        ksort($this->labels);
    }

    public function render(string $chars) : void
    {
        $chars = self::simplifyString($chars);
        $filteredArray = array();
        $found = false;
        foreach ($this->labels as $key => $value) {
            if (strpos($key, $chars) === 0) {
                $filteredArray[] = array('label' => $value['display'], 'value' => $value['@id']);
                $found = true;
            } elseif ($found === true) { break; }
        }
        echo json_encode($filteredArray);
    }

    private static function simplifyString(string $name) : string
    {
        $name = strtolower($name);
        $name = mb_ereg_replace("'", '', $name);
        $name = mb_ereg_replace('u', 'v', $name);
        $name = mb_ereg_replace('j', 'i', $name);
        return mb_ereg_replace('v̄', 'v', $name);
    }

}