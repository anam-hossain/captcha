<?php
namespace Anam\Captcha\ServiceProvider;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class CaptchaServiceProvider extends ServiceProvider
{
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
            return  "<script src='https://www.google.com/recaptcha/api.js'></script>".
                    "<div class='g-recaptcha' data-sitekey='{{ $siteKey }}'></div>";
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
