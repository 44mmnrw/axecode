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

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'yandex_wordstat' => [
        'client_id' => env('YANDEX_WORDSTAT_CLIENT_ID'),
        'client_secret' => env('YANDEX_WORDSTAT_CLIENT_SECRET'),
        'redirect_uri' => env('YANDEX_WORDSTAT_REDIRECT_URI', env('APP_URL') . '/admin/wordstat/oauth/callback'),
        'scope' => env('YANDEX_WORDSTAT_SCOPE', ''),
        'oauth_authorize_url' => env('YANDEX_OAUTH_AUTHORIZE_URL', 'https://oauth.yandex.ru/authorize'),
        'oauth_token_url' => env('YANDEX_OAUTH_TOKEN_URL', 'https://oauth.yandex.ru/token'),
        'api_base_url' => env('YANDEX_WORDSTAT_API_BASE_URL', ''),
    ],

    'yandex_metrika' => [
        'client_id' => env('YANDEX_METRIKA_CLIENT_ID'),
        'client_secret' => env('YANDEX_METRIKA_CLIENT_SECRET'),
        'access_token' => env('YANDEX_METRIKA_ACCESS_TOKEN'),
    ],

];
