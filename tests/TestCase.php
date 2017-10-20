<?php

namespace Anam\Captcha\Tests;

use Anam\Captcha\Facade\Captcha;
use Anam\Captcha\ServiceProvider\CaptchaServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    /**
     * Load package service provider
     * 
     * @param  \Illuminate\Foundation\Application  $app
     * @return \Anam\Captcha\ServiceProvider\CaptchaServiceProvider
     */
    protected function getPackageProviders($app)
    {
        return [CaptchaServiceProvider::class];
    }
    /**
     * Load package alias
     * 
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'Captcha' => Captcha::class,
        ];
    }
}