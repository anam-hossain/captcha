<?php

namespace Anam\Captcha\Tests;

use Mockery;
use ReCaptcha\ReCaptcha;
use ReCaptcha\Response;
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

    public function testSuccessfulResponseRequest()
    {
        $request = Mockery::mock(Request::class);
        $request->allows()->input('g-recaptcha-response')->andReturn('xyz');

        $request->allows()->ip()->andReturn('127.0.0.1');

        $captcha = Mockery::mock(Captcha::class)->makePartial();
        $captcha->allows()->verify($request->input('g-recaptcha-response'), $request->ip())
            ->andReturn(new Response(true));

        $captcha->check($request);

        $this->assertTrue($captcha->isVerified());

    }

    public function testUnsuccessfulResponseRequest()
    {
        $request = Mockery::mock(Request::class);
        $request->allows()->input('g-recaptcha-response')->andReturn('xyz');

        $request->allows()->ip()->andReturn('127.0.0.1');

        $captcha = Mockery::mock(Captcha::class)->makePartial();
        $captcha->allows()->verify($request->input('g-recaptcha-response'), $request->ip())
            ->andReturn(new Response(false));

        $captcha->check($request);

        $this->assertFalse($captcha->isVerified());

    }

    public function testHostname()
    {
        $request = Mockery::mock(Request::class);
        $request->allows()->input('g-recaptcha-response')->andReturn('xyz');

        $request->allows()->ip()->andReturn('127.0.0.1');

        $captcha = Mockery::mock(Captcha::class)->makePartial();
        $captcha->allows()->verify($request->input('g-recaptcha-response'), $request->ip())
            ->andReturn(new Response(true, [], $request->ip()));

        $captcha->check($request);

        $this->assertEquals('127.0.0.1', $captcha->hostname());

    }
}