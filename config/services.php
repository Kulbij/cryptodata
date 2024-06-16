<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => '',
        'secret' => '',
    ],

    'mandrill' => [
        'secret' => '',
    ],

    'ses' => [
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => 'User',
        'secret' => '',
    ],

    'vatlayer' => [
        'access_key' => env('VATLAYER_ACCESS_KEY'),
    ],

    'slack' => [
        'hooks_url' => env('SLACK_HOOKS_URL'),
        'enabled' => env('SLACK_HOOKS_ENABLED'),
    ],

    'dhl' => [
        'id' => env('DHL_ID'),
        'pass' => env('DHL_PASS'),
    ],
];
