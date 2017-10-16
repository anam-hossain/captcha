<?php

namespace Anam\Captcha;

use Exception;

class SecretNotFoundException extends Exception
{
    public function __construct() {
        parent::__construct("The reCaptcha secret not found. Have you passed it?");
    }
}