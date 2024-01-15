<?php

namespace OmnesViae;

class Util
{
    public static function showErrorPage($code = "404", $message = "page not found") : void
    {
        header("HTTP/1.0 $code");
        echo "<html lang='en'><head><title>$code</title></head><body><h1>Error $code</h1><p>Error $code: $message</p></body></html>";
        exit;
    }

}