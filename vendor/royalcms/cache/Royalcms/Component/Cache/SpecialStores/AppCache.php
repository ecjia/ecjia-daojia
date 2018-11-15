<?php

namespace Royalcms\Component\Cache\SpecialStores;

use Royalcms\Component\Support\Facades\Config as RC_Config;

trait AppCache
{
    
    /**
     * 快速设置APP缓存数据
     *
     * @since 3.4
     *
     * @param string $name
     * @param string $data
     * @param string $app
     */
    public static function app_cache_set($name, $data, $app, $expire = null)
    {
        $config = RC_Config::get('cache.stores.file');
        $expire = $expire ?: $config['expire'];
        $key = $app . ':' . $name;
        return static::put($key, $data, $expire);
    }
    
    /**
     * 快速添加APP缓存数据，如果name已经存在，则返回false
     *
     * @since 3.4
     *
     * @param string $name
     * @param string $data
     * @param string $app
     */
    public static function app_cache_add($name, $data, $app, $expire = null)
    {
        $config = RC_Config::get('cache.stores.file');
        $expire = $expire ?: $config['expire'];
        $key = $app . ':' . $name;
        return static::add($key, $data, $expire);
    }
    
    /**
     * 快速获取APP缓存数据
     *
     * @since 3.4
     *
     * @param string $name
     * @param string $app
     */
    public static function app_cache_get($name, $app)
    {
        $key = $app . ':' . $name;
        return static::get($key);
    }
    
    /**
     * 快速删除APP缓存数据
     *
     * @since 3.4
     *
     * @param string $name
     * @param string $app
     */
    public static function app_cache_delete($name, $app)
    {
        $key = $app . ':' . $name;
        return static::forget($key);
    }
    
}