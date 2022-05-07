<?php

namespace Ibehbudov\LaravelGoogleCaptcha\Providers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;

class GoogleCaptchaServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/google-captcha.php'   =>  config_path('google-captcha.php'),
            __DIR__ . '/../lang/google-captcha.php'     =>  lang_path('en/google-captcha.php')
        ], 'google-captcha');
    }

}
