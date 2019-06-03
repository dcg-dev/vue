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

    'facebook' => [
        'redirect' => env('FACEBOOK_REDIRECT'),
        'client_id' => env('FACEBOOK_ID'),
        'client_secret' => env('FACEBOOK_SECRET'),
    ],
    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],
    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],
    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],
    'stripe' => [
        'model' => App\Models\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'client_id' => env('STRIPE_CLIENT_ID'),
        'client_secret' => env('STRIPE_CLIENT_SECRET'),
        'redirect' => env('STRIPE_REDIRECT'),
    ],
    'paypal' => [
        'sandbox' => env('PAYPAL_SANDBOX'),
        'username' => env('PAYPAL_USERNAME'),
        'password' => env('PAYPAL_PASSWORD'),
        'signature' => env('PAYPAL_SIGNATURE'),
        'app_id' => env('PAYPAL_APP_ID'),
        'email' => env('PAYPAL_EMAIL'),
    ],
];
