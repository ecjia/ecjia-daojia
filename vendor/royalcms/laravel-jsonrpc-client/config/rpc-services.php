<?php

return [
    'services' => [
        [
            'services' => [
                'CalculatorService',
                'ProductService',
            ],
            'nodes' => [
                'http://127.0.0.1/rpc',
                'http://127.0.0.1:9503/rpc',
                ['host' => '127.0.0.1', 'port' => 9503, 'path' => '/rpc'],
                ['host' => '127.0.0.1', 'port' => 9503, 'path' => '/rpc']
            ]
        ]
    ],

    // auth user
    'auth_user' => env('RPC_AUTH_USER'),

    // auth password
    'auth_password' => env('RPC_AUTH_PASSWORD'),

];
