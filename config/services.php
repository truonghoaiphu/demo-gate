<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => Katniss\Everdeen\Models\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'gate' => [
        'url' => env('GATE_URL'),
        'client_id' => env('GATE_CLIENT_ID'),
        'client_secret' => env('GATE_CLIENT_SECRET'),
        'pw_client_id'      =>  env('GATE_PW_CLIENT_ID'),
        'pw_client_secret'  =>  env('GATE_PW_CLIENT_SECRET'),
        'redirect' => '',
    ],
];
