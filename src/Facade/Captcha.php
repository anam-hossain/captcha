<?php
namespace Anam\Captcha\Facade;

use Illuminate\Support\Facades\Facade;

class Captcha extends Facade
{
    protected static function getFacadeAccessor() { return 'captcha'; }
}
