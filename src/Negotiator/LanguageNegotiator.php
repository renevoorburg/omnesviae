<?php

namespace OmnesViae\Negotiator;

class LanguageNegotiator extends Negotiator {
    protected $headerName = 'HTTP_ACCEPT_LANGUAGE';
    protected $urlParamName = 'lang';
}