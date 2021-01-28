<?php


namespace Royalcms\Component\Cache\Traits;


trait CustomCacheScreenTrait
{
    /**
     * @return \Royalcms\Component\Cache\Stores\AppCache
     */
    public static function app()
    {
        static $cache;

        if (!empty($cache)) {
            return $cache;
        }

        $cache = (new \Royalcms\Component\Cache\Stores\AppCache);

        return $cache;
    }

    /**
     * 快速设置APP缓存数据
     *
     * @since 3.4
     *
     * @param string $key
     * @param string|array $data
     * @param string $app
     */
    public static function app_cache_set($key, $data, $app, $expire = null)
    {
        return static::app()->setApp($app)->set($key, $data, $expire);
    }

    /**
     * 快速添加APP缓存数据，如果name已经存在，则返回false
     *
     * @since 3.4
     *
     * @param string $key
     * @param string|array $data
     * @param string $app
     */
    public static function app_cache_add($key, $data, $app, $expire = null)
    {
        return static::app()->setApp($app)->add($key, $data, $expire);
    }

    /**
     * 快速获取APP缓存数据
     *
     * @since 3.4
     *
     * @param string $key
     * @param string $app
     */
    public static function app_cache_get($key, $app)
    {
        return static::app()->setApp($app)->get($key);
    }

    /**
     * 快速删除APP缓存数据
     *
     * @since 3.4
     *
     * @param string $name
     * @param string $app
     */
    public static function app_cache_delete($key, $app)
    {
        return static::app()->setApp($app)->delete($key);
    }

    //===============================================================

    /**
     * @return \Royalcms\Component\Cache\Stores\QueryCache
     */
    public static function query()
    {
        static $cache;

        if (!empty($cache)) {
            return $cache;
        }

        $cache = (new \Royalcms\Component\Cache\Stores\QueryCache());

        return $cache;
    }

    /**
     * 设置查询缓存
     *
     * @since 3.10
     *
     * @param string $key
     * @param string $value
     * @param string $expire
     * @return boolean
     */
    public static function query_cache_set($key, $data, $expire = null)
    {
        return static::query()->set($key, $data, $expire);
    }

    /**
     * 获取查询缓存
     *
     * @since 3.10
     *
     * @param string $key
     * @return mixed
     */
    public static function query_cache_get($key)
    {
        return static::query()->get($key);
    }

    /**
     * 删除查询缓存
     *
     * @since 3.10
     *
     * @param string $key
     * @return boolean
     */
    public static function query_cache_delete($key)
    {
        return static::query()->delete($key);
    }

    //===============================================================

    /**
     * @return \Royalcms\Component\Cache\Stores\TableCache
     */
    public static function table()
    {
        static $cache;

        if (!empty($cache)) {
            return $cache;
        }

        $cache = (new \Royalcms\Component\Cache\Stores\TableCache());

        return $cache;
    }

    /**
     * 设置数据表缓存
     *
     * @since 3.10
     *
     * @param string $key
     * @param string $value
     * @param string $expire
     * @return boolean
     */
    public static function table_cache_set($key, $data, $expire = null)
    {
        return static::table()->set($key, $data, $expire);
    }

    /**
     * 获取数据表缓存
     *
     * @since 3.10
     *
     * @param string $key
     * @return mixed
     */
    public static function table_cache_get($key)
    {
        return static::table()->get($key);
    }

    /**
     * 删除数据表缓存
     *
     * @since 3.10
     *
     * @param string $key
     * @return boolean
     */
    public static function table_cache_delete($key)
    {
        return static::table()->delete($key);
    }

    //===============================================================

    /**
     * @return \Royalcms\Component\Cache\Stores\UserdataCache
     */
    public static function userdata()
    {
        static $cache;

        if (!empty($cache)) {
            return $cache;
        }

        $cache = (new \Royalcms\Component\Cache\Stores\UserdataCache());

        return $cache;
    }

    /**
     * 快速存储用户个人数据
     *
     * @since 3.4
     *
     * @param string $key
     * @param string $data
     * @param string $user_id
     * @param boolean $user_type
     */
    public static function userdata_cache_set($key, $data, $user_id, $user_type = 'user', $expire = null)
    {
        return static::userdata()->setUserId($user_id)->setUserType($user_type)->set($key, $data, $expire);
    }

    /**
     * 快速读取用户个人数据
     *
     * @since 3.4
     *
     * @param string $key
     * @param string $user_id
     * @param boolean $user_type
     */
    public static function userdata_cache_get($key, $userid, $user_type = 'user', $expire = null)
    {
        return static::userdata()->setUserId($user_id)->setUserType($user_type)->get($key);
    }

    /**
     * 快速删除用户个人数据
     *
     * @since 3.4
     *
     * @param string $key
     * @param string $user_id
     * @param boolean $user_type
     */
    public static function userdata_cache_delete($key, $userid, $user_type = 'user', $expire = null)
    {
        return static::userdata()->setUserId($user_id)->setUserType($user_type)->delete($key);
    }

}