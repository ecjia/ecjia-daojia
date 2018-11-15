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
	 | Cache Stores
	 |--------------------------------------------------------------------------
	 |
	 | Here you may define all of the cache "stores" for your application as
	 | well as their drivers. You may even define multiple stores for the
	 | same cache driver to group types of items stored in your caches.
	 |
	 */
    
    'stores' => [
        
        'apc' => [
            'driver' => 'apc'
        ],
        
        'array' => [
            'driver' => 'array'
        ],
        
        'database' => [
            'driver' => 'database',
            'table'  => 'cache',
            'connection' => null,
        ],
        
        'file' => [
            'driver' => 'file',
            'path'   => storage_path().'/cache',
            'expire'   => 60, //分钟
        ],
        
        'memcached' => [
            'driver'  => 'memcached',
            'servers' => [
                [
                    'host' => '127.0.0.1', 'port' => 11211, 'weight' => 100
                ],
            ],
        ],
        
        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
        ],
        
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
        
    ],
    
);
