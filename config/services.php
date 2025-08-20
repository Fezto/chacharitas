<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain'   => env('MAILGUN_DOMAIN'),
        'secret'   => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'fedex' => [
        'base_url' => env('FEDEX_BASE_URL'), // URL de la API de FedEx
        'key' => env('FEDEX_KEY'), // Tu clave API de FedEx - para FedExShippingService
        'api_key' => env('FEDEX_KEY'), // Tu clave API de FedEx - para FedexServiceProvider
        'secret' => env('FEDEX_SECRET'), // El Secret de FedEx
        'account_number' => env('FEDEX_ACCOUNT_NUMBER'), // Tu número de cuenta de FedEx
    ],


    /*

    'skydropx' => [
        'dev_base' => env('SKYDROPX_DEV_BASE'),
        'dev_api_key' => env('SKYDROPX_DEV_API_KEY'),
        'dev_api_secret' => env('SKYDROPX_DEV_API_SECRET'),
        'prod_base' => env('SKYDROPX_PROD_BASE'),
        'prod_api_key' => env('SKYDROPX_PROD_API_KEY'),
        'prod_api_secret' => env('SKYDROPX_PROD_API_SECRET'),
    ],

    */

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'google' => [
        'maps_key' => env('GOOGLE_MAPS_KEY'),
    ],

];
