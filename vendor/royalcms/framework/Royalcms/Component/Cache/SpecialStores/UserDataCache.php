<?php

namespace Royalcms\Component\Cache\SpecialStores;

use Royalcms\Component\Support\Facades\Config as RC_Config;

trait UserDataCache
{
    /**
     * 快速存储用户个人数据
     *
     * @since 3.4
     *
     * @param string $name
     * @param string $data
     * @param string $userid
     * @param boolean $isadmin
     */
    public static function userdata_cache_set($name, $data, $userid, $isadmin = false, $expire = null)
    {
        $config = RC_Config::get('cache.stores.userdata_cache');
        $expire = $expire ?: $config['expire'];
        $key = 'userdata_cache:' . $name . $userid . $isadmin;
        return static::driver('userdata_cache')->put($key, $data, $expire);
    }
    
    /**
     * 快速读取用户个人数据
     *
     * @since 3.4
     *
     * @param string $name
     * @param string $userid
     * @param boolean $isadmin
     */
    public static function userdata_cache_get($name, $userid, $isadmin = false, $expire = null)
    {
        $key = 'userdata_cache:' . $name . $userid . $isadmin;
        return static::driver('userdata_cache')->get($key);
    }
    
    /**
     * 快速删除用户个人数据
     *
     * @since 3.4
     *
     * @param string $name
     * @param string $userid
     * @param boolean $isadmin
     */
    public static function userdata_cache_delete($name, $userid, $isadmin = false, $expire = null)
    {
        $key = 'userdata_cache:' . $name . $userid . $isadmin;
        return static::driver('userdata_cache')->forget($key);
    }
    
}