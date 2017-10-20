<?php

namespace Anam\Captcha\Tests;

use Anam\Captcha\Captcha;

class CaptchaTest extends TestCase
{
    /**
     * @expectedException \Anam\Captcha\SecretNotFoundException
     */
    public function testExceptionThrownOnInvalidSecret($secret = '')
    {
        $captcha = new Captcha($secret);
    }
}