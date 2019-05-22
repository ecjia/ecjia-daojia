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

	'default' => 'direct',

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

	'disks' => array(

		'local' => array(
			'driver' => 'local',
			'root'   => SITE_UPLOAD_PATH,
		),
	    
	    'direct' => array(
	        'driver' => 'direct',
	        'root'   => SITE_UPLOAD_PATH,
	    ),

        'data-export' => array(
            'driver' => 'local',
            'root'   => storage_path('app/data-exports'),
        ),

		'aliyunoss' => array(
			'driver' => 'aliyunoss',
			'key'    => '',
			'secret' => '',
			'bucket' => '',
		    'server' => 'http://oss-cn-hangzhou.aliyuncs.com',
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
    | file_ext 允许上传的文件类型（不包含图片扩展）
    */
    'upload' => array(
        'path'                  => '',
        'url_path'              => '',
        'use_yearmonth_folders' => false,
        'max_size'              => '2097152',
        'file_ext'              => array('swf', 'rar', 'zip', 'doc', 'pdf', 'txt', 'xls'),
        'file_mime'             => array(),
    ),

);
