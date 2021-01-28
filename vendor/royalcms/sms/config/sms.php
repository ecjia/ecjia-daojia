<?php

return [

    /*
    |--------------------------------------------------------------------------
    | 第三方短信服务商
    |--------------------------------------------------------------------------
    |
    | 支持：互亿无线
    |
    | 其它短信服务商，如需要可自行扩展。
    | IHuYiAgent 可提供开发参考。
    |
    */
    'default' => env('SMS_DEFAULT', 'ihuyi'),

    'fallback' => env('SMS_FALLBACK'),

    'signName' => env('SMS_SIGNNAME'),

    'agents' => [
        /*
         * 互亿无线
         */
        'ihuyi' => [
            'credentials' => [
                'appKey' => env('IHUYI_APPKEY'),
                'appSecret' => env('IHUIYI_APPSECRET')
            ],
            'executableFile' => 'IHuYiAgent',
        ],

    ],

];
