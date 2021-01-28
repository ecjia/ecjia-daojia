<?php

return [

    /*
    |--------------------------------------------------------------------------
    | HTTP Basic Auth Credentials
    |--------------------------------------------------------------------------
    |
    | The user credentials which are used when logging in with HTTP basic
    | authentication.
    |
    */

    'users' => [
        'default' => [
            env('HTTP_BASIC_AUTH_USER'),
            env('HTTP_BASIC_AUTH_PASSWORD'),
        ],
    ],

];