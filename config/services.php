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
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'facebook' => [
        'client_id'     => env('CLIENT_ID_FB', '584814145322201'),
        'client_secret' => env('CLIENT_SECRET_FB', '7670b7f49da96db481c42213d62000a8'),
        'redirect'      => env('REDIRECT_FB', 'https://onthiez.com/facebook/callback'),
    ],

    'google' => [
        'client_id'     =>  env('CLIENT_ID_GG', '497329216350-158al82b15mcr88c1gp02jf3hde50tal.apps.googleusercontent.com'),
        'client_secret' =>  env('CLIENT_SECRET_GG', 'otKWs3DNbCbPLKaAzY7EhFge'),
        'redirect'      =>  env('REDIRECT_GG', 'https://2aef6546.ngrok.io/google/callback')
    ],

];
