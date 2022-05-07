<?php

namespace Ibehbudov\LaravelGoogleCaptcha\Rules;

use Ibehbudov\LaravelGoogleCaptcha\GoogleCaptcha;
use Illuminate\Contracts\Validation\Rule;

class GoogleCaptchaRule implements Rule
{
    public GoogleCaptcha $googleCaptcha;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->googleCaptcha = app(GoogleCaptcha::class);
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
        $this->googleCaptcha->validate($value);

        dd($this->googleCaptcha->getErrorMessage());

        return $this->googleCaptcha->success();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('Please fill google captcha');
    }
}
