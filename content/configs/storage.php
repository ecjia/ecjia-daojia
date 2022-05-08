<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. A "local" driver, as well as a variety of cloud
    | based drivers are available for your choosing. Just store away!
    |
    | Supported: "local", "direct", "aliyunoss"
    |
    */

    'default' => env('STORAGE_DEFAULT_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    | Supported: "local", "direct", "aliyunoss"
    |
    */

    'cloud' => env('STORAGE_CLOUD_DRIVER', 'aliyunoss'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    */

    'disks'  => array(

        'local' => array(
            'driver' => 'local',
            'root'   => SITE_UPLOAD_PATH,
            'url'    => '',
        ),

        'direct' => array(
            'driver' => 'direct',
            'root'   => SITE_UPLOAD_PATH,
            'url'    => '',
        ),

        'aliyunoss' => array(
            'driver'          => 'aliyunoss',
            'key'             => env('STORAGE_ALIYUNOSS_APPKEY', ''),
            'secret'          => env('STORAGE_ALIYUNOSS_APPSECRET', ''),
            'bucket'          => env('STORAGE_ALIYUNOSS_BUCKET', ''),
            'server'          => env('STORAGE_ALIYUNOSS_SERVER', 'https://oss-cn-hangzhou.aliyuncs.com'),
            'server_internal' => env('STORAGE_ALIYUNOSS_SERVER_INTERNAL', 'https://oss-cn-hangzhou-internal.aliyuncs.com'),
            'is_internal'     => env('STORAGE_ALIYUNOSS_IS_INTERNAL', false),
            'url'             => '',
        ),

    ),

);
