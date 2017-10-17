<?php
namespace Anam\Captcha\ServiceProvider;

use Anam\Captcha\SiteKeyNotFoundException;
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
        Blade::directive('captcha', function ($siteKey = null) {

            $siteKey = $this->loadSiteKey($siteKey);

            return  "<script src='https://www.google.com/recaptcha/api.js'></script>".
                    "<div class='g-recaptcha' data-sitekey='{$siteKey}'></div>";
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

    /**
     * load reCAPTCHA Site key
     * 
     * @param  string  $siteKey
     * @return string
     */
    public function loadSiteKey($siteKey = null)
    {
        if ($siteKey) return $siteKey;

        if (env('RECAPTCHA_SITE_KEY')) {
            return env('RECAPTCHA_SITE_KEY');
        }

        throw new SiteKeyNotFoundException;
    }
}
