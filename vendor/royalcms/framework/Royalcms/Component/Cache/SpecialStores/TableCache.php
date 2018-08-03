<?php

namespace Royalcms\Component\Cache\SpecialStores;

use Royalcms\Component\Support\Facades\Config as RC_Config;

trait TableCache
{
    /**
     * 设置数据表缓存
     *
     * @since 3.10
     *
     * @param string $name
     * @param string $value
     * @param string $expire
     * @return boolean
     */
    public static function table_cache_set($name, $data, $expire = null)
    {
        $config = RC_Config::get('cache.stores.table_cache');
        $expire = $expire ?: $config['expire'];
        $key = 'table_cache:'.  $name;
        return static::driver('table_cache')->put($key, $data, $expire);
    }
    
    /**
     * 获取数据表缓存
     *
     * @since 3.10
     *
     * @param string $name
     * @param string $value
     * @param string $expire
     * @return boolean
     */
    public static function table_cache_get($name)
    {
        $key = 'table_cache:'.  $name;
        return static::driver('table_cache')->get($key);
    }
    
    /**
     * 删除数据表缓存
     *
     * @since 3.10
     *
     * @param string $name
     * @param string $value
     * @param string $expire
     * @return boolean
     */
    public static function table_cache_delete($name)
    {
        $key = 'table_cache:'.  $name;
        return static::driver('table_cache')->forget($key);
    }
    
}