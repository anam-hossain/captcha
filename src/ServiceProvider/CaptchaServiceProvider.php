<?php
namespace Anam\Captcha\ServiceProvider;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class CaptchaServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('captcha', function() {
            return new Captcha();
        });
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('captcha', function ($siteKey) {
            $this->loadViewsFrom(__DIR__.'/../views', 'captcha');
            
            return view('captcha::recaptcha', compact('siteKey'))->render();
        });
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Captcha::class];
    }
}
