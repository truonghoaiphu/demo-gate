<?php

namespace Katniss\Everdeen\Validators;

use GuzzleHttp\Client;

class ReCaptcha
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        $client = new Client();

        $response = $client->post(
            config('services.google_re_captcha.url'),
            [
                'form_params' =>
                [
                    'secret' => config('services.google_re_captcha.secret'),
                    'response' => $value
                ]
            ]
        );
        
        $body = json_decode((string)$response->getBody());
        return $body ? $body->success : false;
    }
}