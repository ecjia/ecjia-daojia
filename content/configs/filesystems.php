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
        ),

        'direct' => array(
            'driver' => 'direct',
            'root'   => SITE_UPLOAD_PATH,
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

    /*
    |--------------------------------------------------------------------------
    | Filesystem Upload Options
    |--------------------------------------------------------------------------
    |
    | path  附件本地保存相对位置，相对于上传目录的位置
    | url_path 附件访问url
    | use_yearmonth_folders 上传使用年/月文件夹
    | max_size 允许上传大小限制Bytes 2M 
    */
    'upload' => array(
        'path'                  => '',
        'url_path'              => '',
        'use_yearmonth_folders' => false,
        'max_size'              => '2097152',

        //默认上传文件类型
        'default_file_types'    => array(
            'rar'  => 'application/x-rar-compressed',
            'zip'  => 'application/zip',
            'txt'  => 'text/plain',
            'pdf'  => 'application/pdf',
            'doc'  => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls'  => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'ppt'  => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'jpg'  => 'image/jpg',
            'jpeg' => 'image/jpeg',
            'png'  => 'image/png',
            'gif'  => 'image/x-png',
            'bmp'  => 'image/pjpeg',
        ),
    ),

);
