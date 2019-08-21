<?php

namespace Anam\Captcha;

use Anam\Captcha\SecretNotFoundException;
use ReCaptcha\ReCaptcha;
use Illuminate\Http\Request;

class Captcha extends ReCaptcha
{
    /**
     * @var \ReCaptcha\Response
     */
    public $response;

    /**
     * Create a configured instance to use the reCAPTCHA service.
     *
     * @param string $secret.
     */
    public function __construct(string $secret = '')
    {
        parent::__construct($this->retrieveSecret($secret));
    }

    /**
     * Retrieve reCaptcha secret
     * 
     * @param  string  $secret
     * @return mixed
     */
    protected function retrieveSecret(string $secret)
    {
        if ($secret) return $secret;

        if (config('captcha.secret')) return config('captcha.secret');

        throw new SecretNotFoundException;
    }

    /**
     * Verify captcha
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return $this
     */
    public function check(Request $request)
    {
        $this->response = $this->verify($request->input('g-recaptcha-response'), $request->ip());

        return $this;
    }

    /**
     * Check captcha is verified
     * 
     * @return boolean
     */
    public function isVerified()
    {
        return $this->response->isSuccess();
    }

    /**
     * Get reCaptcha errors
     * 
     * @return \Illuminate\Support\Collection
     */
    public function errors()
    {
        return collect($this->response->getErrorCodes());
    }

    /**
     * Get the request hostname
     * 
     * @return string
     */
    public function hostname()
    {
        return $this->response->getHostName();
    }

    /**
     * Get reCaptcha response object
     * 
     * @return \ReCaptcha\Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}