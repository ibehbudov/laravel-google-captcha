##Google Captcha for Laravel

### Installation

```php
composer require ibehbudov/laravel-google-captcha`
```

### Publish vendor files

```php
php artisan vendor:publish --tag=google-captcha`
```

### Secret key
Open `config/google-captcha.php` file and edit 

```php
return [
    'secret_key'   =>  'google_secret_key'
];
```
### Usage
#### Inside controller
```php
$request->validate([
    'g-recaptcha-response'  =>  new GoogleCaptchaRule()
]);
```

#### Inside rule
```php
public function rules()
{
    return [
        'g-recaptcha-response'  =>  new GoogleCaptchaRule()
    ];
}
```

#### In somewhere as you want

```php
$googleCaptcha = app(GoogleCaptcha::class);

$googleCaptcha->validate($request->post('g-recaptcha-response'));

if($googleCaptcha->fail()) {
    return $googleCaptcha->getErrorMessage();
}
else {
    // code goes here
}
```

