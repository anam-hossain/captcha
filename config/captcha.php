<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Site Key for google's recaptcha 
    |--------------------------------------------------------------------------
    |
    | Here you may provide the site key for google's recaptcha. 
    | A default option is provided that is given for testing purposes by google.
    |
    */

    'site_key' => env('RECAPTCHA_SITE_KEY', '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI'),

    /*
    |--------------------------------------------------------------------------
    | Secret Key for google's recaptcha 
    |--------------------------------------------------------------------------
    |
    | Here you may provide the secret key for google's recaptcha. 
    | A default option is provided that is given for testing purposes by google.
    |
    */
 
    'secret' => env('RECAPTCHA_SECRET', '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe'),

];
