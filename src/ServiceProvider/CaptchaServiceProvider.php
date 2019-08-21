<?php
namespace Anam\Captcha\ServiceProvider;

use Anam\Captcha\Captcha;
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
		$this->publishes([
              __DIR__.'/../../config/captcha.php' => config_path('captcha.php'),
        ]);
		
        Blade::directive('captcha', function ($siteKey = null) {

            $siteKey = $this->loadSiteKey($siteKey);

            return  "<script src='https://www.google.com/recaptcha/api.js' async defer></script>".
                    "<div class='g-recaptcha' data-sitekey='{$siteKey}'></div>";
        });

        Blade::directive('invisiblecaptcha', function ($siteKey = null) {

            $siteKey = $this->loadSiteKey($siteKey);

            return  "<script src='https://www.google.com/recaptcha/api.js'></script>".
                    "<script>
                        function onSubmit(token) {
                            document.forms[0].submit();
                        }
                    </script>".
                    "<button
                        class='g-recaptcha'
                        data-sitekey='{$siteKey}'
                        data-callback='onSubmit'>
                        Submit
                    </button>";
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

        if (config('captcha.site_key')) {
            return config('captcha.site_key');
        }

        throw new SiteKeyNotFoundException;
    }
}
