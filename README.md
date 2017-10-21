# reCAPTCHA and invisible reCAPTCHA for Laravel

reCAPTCHA protects your app against spam and bot. This package is tested with Laravel 5.5.

## Requirements

- PHP 7.0+

## Installation

`Captcha` is available via Composer:

```bash
$ composer require anam/captcha
```

Alternatively, add the dependency directly to your composer.json file:

```json
"require": {
    "anam/captcha": "~1.0"
}
```

## Integrations

#### Laravel 5.5 integrations

##### Package Discovery
`Anam\Captcha` utilize the Laravel's package auto discovery feature. So, you don't need to add manually Service provider and Facade in Laravel application's config/app.php. Laravel will automatically register the service provider and facades for you.

#### Laravel < 5.5 integrations

Captcha comes with a Service provider and Facade for easy integration.

After you have installed the `anam/captcha`, open the `config/app.php` file which is included with Laravel and add the following lines.

In the `$providers` array add the following service provider.

```php
'Anam\Captcha\ServiceProvider\CaptchaServiceProvider'
```

Add the facade of this package to the `$aliases` array.

```php
'Captcha' => 'Anam\Captcha\Facade\Captcha'
```

You can now use this facade in place of instantiating the converter yourself in the following examples.

## Usage

```php
$captcha = new \Anam\Captcha\Captcha();

$captcha->check($request);
```

## Credits

- [Anam Hossain](https://github.com/anam-hossain)
- [All Contributors](https://github.com/anam-hossain/captcha/graphs/contributors)

## License

The MIT License (MIT). Please see [LICENSE](http://opensource.org/licenses/MIT) for more information.
