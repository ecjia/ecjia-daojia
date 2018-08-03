<?php

namespace Royalcms\Component\Cache\SpecialStores;

use Royalcms\Component\Support\Facades\Config as RC_Config;

trait QueryCache
{
    /**
     * 设置查询缓存
     *
     * @since 3.10
     *
     * @param string $name
     * @param string $value
     * @param string $expire
     * @return boolean
     */
    public static function query_cache_set($name, $data, $expire = null)
    {
        $config = RC_Config::get('cache.stores.query_cache');
        $expire = $expire ?: $config['expire'];
        $key = 'query_cache:'.  $name;
        return static::driver('query_cache')->put($key, $data, $expire);
    }
    
    /**
     * 获取查询缓存
     *
     * @since 3.10
     *
     * @param string $name
     * @param string $value
     * @param string $expire
     * @return boolean
     */
    public static function query_cache_get($name)
    {
        $key = 'query_cache:'.  $name;
        return static::driver('query_cache')->get($key);
    }
    
    /**
     * 删除查询缓存
     *
     * @since 3.10
     *
     * @param string $name
     * @param string $value
     * @param string $expire
     * @return boolean
     */
    public static function query_cache_delete($name)
    {
        $key = 'query_cache:'.  $name;
        return static::driver('query_cache')->forget($key);
    }
    
}