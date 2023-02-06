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
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    //是否记录sql
    'sql_log' => env('SQL_LOG', true),
    //sql慢查询 大于 多少 ms 的需记录
    'slow_sql' => env('SLOW_SQL', 200),
    //H5 地址
    'h5_url' => env('H5_URL', 200),
    //APi 域名
    'api_domain' => env('API_DOMAIN', 20),

    //默认最低时薪
    'low_price' => env('DEFAULT_LOW_PRICE', 24),

    //1 小时内时薪
    'first_hour_price' => env('FIRST_HOUR_PRICE', 24),
    //2 小时内时薪
    'second_hour_price' => env('SECOND_HOUR_PRICE', 24),
    //3小时内时薪
    'third_hour_price' => env('THIRD_HOUR_PRICE', 24),

];
