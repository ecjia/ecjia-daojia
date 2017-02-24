<?php

return array(
    /*
    |--------------------------------------------------------------------------
    | Default Cache Driver Pool
    |--------------------------------------------------------------------------
    |
	| This option controls the default cache "driver" that will be used when
	| using the Caching library. Of course, you may use other drivers any
	| time you wish. This is the default when another is not specified.
    |
    | Supported: "file", "database", "apc", "memcached", "redis", "array"
    |
    */
    
    'default' => 'file',

	/*
	|--------------------------------------------------------------------------
	| Database Cache Connection
	|--------------------------------------------------------------------------
	|
	| When using the "database" cache driver you may specify the connection
	| that should be used to store the cached items. When this option is
	| null the default database connection will be utilized for cache.
	|
	*/

	'connection' => null,

	/*
	|--------------------------------------------------------------------------
	| Database Cache Table
	|--------------------------------------------------------------------------
	|
	| When using the "database" cache driver we need to know the table that
	| should be used to store the cached items. A default table name has
	| been provided but you're free to change it however you deem fit.
	|
	*/

	'table' => 'cache',

	/*
	|--------------------------------------------------------------------------
	| Memcached Servers
	|--------------------------------------------------------------------------
	|
	| Now you may specify an array of your Memcached servers that should be
	| used when utilizing the Memcached cache driver. All of the servers
	| should contain a value for "host", "port", and "weight" options.
	|
	*/

	'memcached' => array(

		array('host' => '127.0.0.1', 'port' => 11211, 'weight' => 100),

	),

	/*
	|--------------------------------------------------------------------------
	| Cache Key Prefix
	|--------------------------------------------------------------------------
	|
	| When utilizing a RAM based store such as APC or Memcached, there might
	| be other applications utilizing the same cache. So, we'll specify a
	| value to get prefixed to all our keys so we can avoid collisions.
	|
	*/

	'prefix' => 'royalcms',
    
    
    /*
    |--------------------------------------------------------------------------
    | Cache Drivers
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "drivers" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    */
    'drivers' => array(
    	'file' => array(
    	    'driver'   => 'file',
    	    'path'     => storage_path().'/cache',
    	    'expire'   => 60, //分钟
    	),
        
        /**
         * 数据表缓存
         */
        'table_cache' => array(
            'driver'    => 'file',
            'path'      => storage_path().'/temp/table_caches',
            'expire'    => 1200, //分钟
        ),
        
        /**
         * 用户数据缓存
         */
        'userdata_cache' => array(
            'driver'    => 'file',
            'path'      => storage_path().'/userdata',
            'expire'    => 60, //分钟
        ),
        
        /**
         * 查询缓存
         */
        'query_cache' => array(
            'driver'    => 'file',
            'path'      => storage_path().'/temp/query_caches',
            'expire'    => 60, //分钟
        ),
    ),
    
    
    
    /**
     * Memcache缓存配置参考
     *
     * @param
     *            expire 有效期(单位为秒)
     * @param
     *            server 多个服务器设置二维数组
     *            hostname 主机
     *            port 端口
     *            timeout 超时时间(单位为秒)
     *            pconnect 持久连接
     *            weight 权重
     */
    'memcache' => array(
            'driver' => 'memcache',
            'expire' => 3600,
            'server' => array(
                'hostname' => '127.0.0.1',
                'port' => 11211,
                'timeout' => 0,
                'pconnect' => 0,
                'weight' => 1
            ),
            'debug' => true
        ),
    
    /**
     * Redis缓存配置参考
     *
     * @param
     *            expire 有效期(单位为秒)
     * @param
     *            server 多个服务器设置二维数组
     *            host 主机
     *            port 端口
     *            password 密码
     *            timeout 超时时间
     *            db 数据库
     *            pconnect 持久连接
     */
    'redis' => array(
            'driver' => 'redis',
            'expire' => 3600,
            'server' => array(
                'host' => '127.0.0.1',
                'port' => 6379,
                'password' => '',
                'timeout' => 0,
                'db' => 0,
                'pconnect' => 0
            ),
            'debug' => true
        ),

);
