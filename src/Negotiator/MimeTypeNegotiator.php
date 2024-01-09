<?php

namespace OmnesViae\Negotiator;

class MimeTypeNegotiator extends Negotiator {
    protected $headerName = 'HTTP_ACCEPT';
    protected $urlParamName = 'format';
}
