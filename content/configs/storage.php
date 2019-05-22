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

    'default' => 'local',

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

    'cloud' => 'aliyunoss',

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
            'url'    => SITE_UPLOAD_URL,
        ),

        'direct' => array(
            'driver' => 'direct',
            'root'   => SITE_UPLOAD_PATH,
            'url'    => SITE_UPLOAD_URL,
        ),

        'aliyunoss' => array(
            'driver'          => 'aliyunoss',
            'key'             => '',
            'secret'          => '',
            'bucket'          => '',
            'server'          => 'http://oss-cn-hangzhou.aliyuncs.com',
            'server_internal' => 'http://oss-cn-hangzhou.aliyuncs.com',
            'is_internal'     => false,
        ),

    ),

);
