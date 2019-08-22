# reCAPTCHA V2 and invisible reCAPTCHA for Laravel

reCAPTCHA protects your app against spam and bot. This package is tested with Laravel 5.5.

![recaptcha](https://developers.google.com/recaptcha/images/newCaptchaAnchor.gif "reCAPTCHA V2")



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

#### Laravel 5.5+ integrations

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

## Configuration
First, register keys for your site at https://www.google.com/recaptcha/admin

Add `RECAPTCHA_SITE_KEY` and `RECAPTCHA_SECRET` in `.env` file :

```
RECAPTCHA_SITE_KEY=site_key
RECAPTCHA_SECRET=secret
```

Run vendor publish to add the captcha.php file to config:

```
php artisan vendor:publish --provider=Anam\Captcha\ServiceProvider\CaptchaServiceProvider
```

By default, The package will try to load keys from environment. However, you can set them manually:

```php
$captcha = new \Anam\Captcha\Captcha('recaptcha_secret');
```
Blade directives:

```php
// reCAPTCHA v2
@captcha(site_key)

// Invisible reCAPTCHA
@invisiblecaptcha(site_key)
```

## Usage

### Client side

#### reCAPTCHA V2:

Just add `@captcha()` blade directive to the form.

```html
<form method="POST" action="/captcha" id="captcha-form">
  {{ csrf_field() }}
  <label>Name</label>
  <input type="text" name="name">
  <label>Your message</label>
  <textarea name="message" rows="5"></textarea>
  <br>
  @captcha()
  <br>
  <input type="submit" value="Submit">
</form>
```

For more advanced integration, Please visit the following link:
https://developers.google.com/recaptcha/docs/display

#### Invisible reCAPTCHA:

Add `@invisiblecaptcha()` directive to the form where you want to appear the submit button. Please note, The `@invisiblecaptcha` directive will inject the submit button for you. If you want to style the submit button, `.g-recaptcha` class available for you.

```html
<form method="POST" action="/captcha" id="captcha-form">
  {{ csrf_field() }}
  <label>Name</label>
  <input type="text" name="name">
  <label>Your message</label>
  <textarea name="message" rows="5"></textarea>
  <br>
  @invisiblecaptcha()
</form>
```

Caveat: If view has more than one forms, the `@invisiblecaptcha()` might not work as it will submit the first form. In these cases, you have to integrate the reCAPTCHA manually.

Please visit the following link:
https://developers.google.com/recaptcha/docs/invisible


### Server side

**Handling the request:**

```php
use Anam\Captcha\Captcha;
use Illuminate\Http\Request;

class CaptchaController extends Controller
{
/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Anam\Captcha\Captcha  $captcha
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Captcha $captcha)
    {
        $response = $captcha->check($request);

        if (! $response->isVerified()) {
            dd($response->errors());
        }
        
        dd($response->hostname());
    }
}
```

### Laravel User Registration Controller

**app\Http\Controllers\Auth\RegisterController.php**

Replace 'App\User' below with 'App\Models\User' if your user model class is stored in the Models folder.

```php
<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\Rules\GoogleRecaptcha;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $messages = [
        	'g-recaptcha-response.required' => 'You must verify that you are not a robot.',
        ];
		
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
			'g-recaptcha-response' => ['required', new GoogleRecaptcha]
        ], $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
```

**app\Rules\GoogleRecaptcha.php**

```php
<?php

namespace App\Rules;

use Anam\Captcha\Captcha;
use Illuminate\Contracts\Validation\Rule;

class GoogleRecaptcha implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
		$captcha = new Captcha();
		$response = $captcha->check(request());
		return $response->isVerified();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Are you a robot?';
    }
}
```


## Credits

- [Anam Hossain](https://github.com/anam-hossain)
- [All Contributors](https://github.com/anam-hossain/captcha/graphs/contributors)

## License

The MIT License (MIT). Please see [LICENSE](http://opensource.org/licenses/MIT) for more information.
