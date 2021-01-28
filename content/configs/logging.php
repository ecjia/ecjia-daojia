<?php

use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'ecjia'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        'ecjia' => [
            'driver' => 'custom',
            'via' => \Royalcms\Component\Log\CreateCustomLogger::class,
        ],
//        'elastic' => [
//            'driver' => 'monolog',
//            'level' => 'debug',
//            'name' => 'elastic',
//            'tap' => [],
//            'handler' => \Monolog\Handler\ElasticsearchHandler::class,
//            'formatter' => \Monolog\Formatter\ElasticsearchFormatter::class,
//            'formatter_with' => [
//                'index' => 'api_request_log',
//                'type' => '_doc'
//            ],
//            'handler_with' => [
//                'client' => \Elasticsearch\ClientBuilder::create()->setHosts([env('LOGGING_CHANNEL_ELASTIC_HOST', 'http://localhost:9200')])->build(),
//            ],
//        ],
    ],

];
