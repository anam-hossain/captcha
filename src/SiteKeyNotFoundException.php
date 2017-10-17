<?php

namespace Anam\Captcha;

use Exception;

class SiteKeyNotFoundException extends Exception
{
    public function __construct() {
        parent::__construct("The reCaptcha site key not found. Have you passed it?");
    }
}