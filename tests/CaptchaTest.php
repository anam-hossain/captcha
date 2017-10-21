<?php

namespace Anam\Captcha\Tests;

use Anam\Captcha\Captcha;
use Illuminate\Http\Request;

class CaptchaTest extends TestCase
{
    /**
     * @expectedException \Anam\Captcha\SecretNotFoundException
     */
    public function testExceptionThrownOnInvalidSecret()
    {
        $captcha = new Captcha();
    }

    public function testVerifyReturnsErrorOnMissingInputResponse()
    {
        $captcha = new Captcha('secret');

        $response = $captcha->check(new Request);

        $this->assertFalse($response->isVerified());

        $this->assertEquals('missing-input-response', $response->errors()->first());
    }
}