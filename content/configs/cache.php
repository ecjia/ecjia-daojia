<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Default Cache Store
	|--------------------------------------------------------------------------
	|
	| This option controls the default cache connection that gets used while
	| using this caching library. This connection is used when another is
	| not explicitly specified when executing a given caching function.
	|
	*/

	'default' => env('CACHE_DRIVER', 'file'),

	

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

	'prefix' => 'b2b2c',

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

        /**
         * 应用缓存
         */
        'app_cache' => [
            'driver' => 'redis',
            'connection' => 'cache',
            'expire'   => 60, //分钟
        ],

        /**
         * 数据表缓存
         */
        'table_cache' => array(
            'driver' => 'redis',
            'connection' => 'cache',
            'expire'    => 1200, //分钟
        ),

        /**
         * 用户数据缓存
         */
        'userdata_cache' => array(
            'driver' => 'redis',
            'connection' => 'cache',
            'expire'    => 60, //分钟
        ),

        /**
         * 查询缓存
         */
        'query_cache' => array(
            'driver' => 'redis',
            'connection' => 'cache',
            'expire'    => 60, //分钟
        ),

    ],

];
