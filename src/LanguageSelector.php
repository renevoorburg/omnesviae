<?php

namespace OmnesViae;

class LanguageSelector
{
    const AVAILABLE_LANGUAGES = array("en", "de", "el", "es", "fr", "it", "la", "nl");
    const GET_PARAMETER = 'lang';
    private string $selectedLanguage;

    public function __construct()
    {
        // language from GET parameter? :
        if (!empty($_GET[self::GET_PARAMETER]) && in_array($_GET[self::GET_PARAMETER], self::AVAILABLE_LANGUAGES, true)) {
            $this->selectedLanguage = $_GET[self::GET_PARAMETER];
        }

        // language from HTTP_ACCEPT_LANGUAGE? :
        if (empty($this->selectedLanguage)) {
            $acceptLanguages = (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
                ? explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE'])
                : self::AVAILABLE_LANGUAGES;
            for ($i = 0; $i < count($acceptLanguages); $i++) {
                $l = explode(';', $acceptLanguages[$i]);
                $lang = trim(explode('-', trim($l[0]))[0]);
                if (in_array($lang, self::AVAILABLE_LANGUAGES)) {
                    $this->selectedLanguage = $lang;
                    break;
                }
            }
        }

        // default language:
        if (empty($this->selectedLanguage)) {
            $this->selectedLanguage = $this->getDefaultLanguage();
        }
    }

    public function getSelectedLanguage() : string
    {
        return $this->selectedLanguage;
    }

    public function getDefaultLanguage() : string
    {
        return self::AVAILABLE_LANGUAGES[0];
    }

}

