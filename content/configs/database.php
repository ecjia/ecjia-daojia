<?php
defined('IN_ECJIA') or exit('No permission resources.');
return array(

    'fetch'     => PDO::FETCH_ASSOC,
    'default'   => 'default',

    'connections' => array(
        'default' => array(
            'host'        => env('DB_HOST', 'localhost'),
            'driver'      => 'mysql',
            'database'    => env('DB_DATABASE', 'ecjia'),
            'username'    => env('DB_USERNAME', 'ecjia'),
            'password'    => env('DB_PASSWORD', ''),
            'charset'     => 'utf8mb4',
            'collation'   => 'utf8mb4_unicode_ci',
            'prefix'      => env('DB_PREFIX', 'ecjia_'),
            'port'        => env('DB_PORT', 3306),
            'strict'      => false,
            'unix_socket' => env('DB_SOCKET', ''),
        ),

        'ecjia' => array(
            'host'        => env('DB_ECJIA_HOST', 'localhost'),
            'driver'      => 'mysql',
            'database'    => env('DB_ECJIA_DATABASE', 'ecjia'),
            'username'    => env('DB_ECJIA_USERNAME', 'ecjia'),
            'password'    => env('DB_ECJIA_PASSWORD', ''),
            'charset'     => 'utf8mb4',
            'collation'   => 'utf8mb4_unicode_ci',
            'prefix'      => env('DB_ECJIA_PREFIX', 'ecjia_'),
            'port'        => env('DB_ECJIA_PORT', 3306),
            'strict'      => false,
            'unix_socket' => env('DB_ECJIA_SOCKET', ''),
        ),

        'cashier' => array(
            'host'        => env('DB_CASHIER_HOST', 'localhost'),
            'driver'      => 'mysql',
            'database'    => env('DB_CASHIER_DATABASE', 'ecjia'),
            'username'    => env('DB_CASHIER_USERNAME', 'ecjia'),
            'password'    => env('DB_CASHIER_PASSWORD', ''),
            'charset'     => 'utf8mb4',
            'collation'   => 'utf8mb4_unicode_ci',
            'prefix'      => env('DB_CASHIER_PREFIX', 'ecjia_'),
            'port'        => env('DB_CASHIER_PORT', 3306),
            'strict'      => false,
            'unix_socket' => env('DB_CASHIER_SOCKET', ''),
        ),

        'dscmall' => array(
            'host'        => env('DB_DSCMALL_HOST', 'localhost'),
            'driver'      => 'mysql',
            'database'    => env('DB_DSCMALL_DATABASE', 'ecjia'),
            'username'    => env('DB_DSCMALL_USERNAME', 'ecjia'),
            'password'    => env('DB_DSCMALL_PASSWORD', ''),
            'charset'     => 'utf8mb4',
            'collation'   => 'utf8mb4_unicode_ci',
            'prefix'      => env('DB_DSCMALL_PREFIX', 'dsc_'),
            'port'        => env('DB_DSCMALL_PORT', 3306),
            'strict'      => false,
            'unix_socket' => env('DB_DSCMALL_SOCKET', ''),
        ),

        'test' => array(
            'host'        => env('DB_TEST_HOST', 'localhost'),
            'driver'      => 'mysql',
            'database'    => env('DB_TEST_DATABASE', 'ecjia'),
            'username'    => env('DB_TEST_USERNAME', 'ecjia'),
            'password'    => env('DB_TEST_PASSWORD', ''),
            'charset'     => 'utf8mb4',
            'collation'   => 'utf8mb4_unicode_ci',
            'prefix'      => env('DB_TEST_PREFIX', 'ecjia_'),
            'port'        => env('DB_TEST_PORT', 3306),
            'strict'      => false,
            'unix_socket' => env('DB_TEST_SOCKET', ''),
        ),

    ),

    'redis' => array(

        'client' => 'predis', //phpredis, predis

        'cluster' => false,

        // 这是redis的默认连接，保留即可
        'default' => array(
            'host'     => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port'     => env('REDIS_PORT', 6379),
            'database' => env('REDIS_DEFAULT_DB', 0),
        ),

        // 新建名为cache的连接，用于保存缓存
        'cache' => array(
            'host'      => env('REDIS_HOST', '127.0.0.1'),
            'password'  => env('REDIS_PASSWORD', null),
            'port'      => env('REDIS_PORT', 6379),
            'database'  => env('REDIS_CACHE_DB', 1),
        ),

        // 新建名为session的连接，用于保存session
        'session' => array(
            'host'     => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port'     => env('REDIS_PORT', 6379),
            'database' => env('REDIS_SESSION_DB', 2),
        ),

        // 新建名为queue的连接，用于保存队列
        'queue' => array(
            'host'      => env('REDIS_HOST', '127.0.0.1'),
            'password'  => env('REDIS_PASSWORD', null),
            'port'      => env('REDIS_PORT', 6379),
            'database'  => env('REDIS_QUEUE_DB', 3),
        ),

    ),
);

// end