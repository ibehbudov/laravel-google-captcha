<?php

namespace Ibehbudov\LaravelGoogleCaptcha;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Psr\Http\Message\ResponseInterface;

class GoogleCaptcha {

    /**
     * @var string $verifyUrl
     */
    public $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';

    /**
     * @var string|null
     */
    public ?string $errorMessage;

    /**
     * @var array
     */
    public array $errorMessages = [];

    /**
     * @var ResponseInterface $endpointResponse
     */
    protected ResponseInterface $endpointResponse;

    /**
     * @param Client $httpClient
     * @param Request $request
     */
    public function __construct(
        public Client $httpClient,
        public Request $request
    ){}

    /**
     * @param string $response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function validate(?string $response): void
    {
        $this->endpointResponse = $this->httpClient->post($this->verifyUrl, [
            'form_params'   =>  [
                'secret'    =>  Config::get('google-captcha.secret_key'),
                'response'  =>  $response,
                'remoteip'  =>  $this->request->ip()
            ]
        ]);

        if($this->fail()) {
            $this->validateErrorMessages();
        }
    }

    /**
     * Validate form
     */
    private function validateErrorMessages(): void
    {
        $responseArray = $this->responseArray();

        if(! empty($responseArray['error-codes'])) {

            foreach ($responseArray['error-codes'] as $errorCode) {

                $this->errorMessages[] =
                    __('google-captcha.' . $errorCode) ??
                    __('google-captcha.unknown');
            }
        }
    }

    /**
     * @return bool
     */
    public function success(): bool
    {
        return
            isset($this->responseArray()['success']) &&
            $this->responseArray()['success'] === true;
    }

    /**
     * @return bool
     */
    public function fail(): bool
    {
        return ! $this->success();
    }

    /**
     * @return array|null
     */
    public function responseArray(): array|null
    {
        return json_decode("" . $this->endpointResponse->getBody(), true);
    }

    /**
     * @return array
     */
    public function getErrorMessages(): array
    {
        return $this->errorMessages;
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return current($this->errorMessages);
    }
}
