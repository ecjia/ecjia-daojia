<?php

namespace Royalcms\Component\Support\Facades;

/**
 * @see \Royalcms\Component\Cookie\CookieJar
 */
class Cookie extends Facade
{
    /**
     * Determine if a cookie exists on the request.
     *
     * @param  string  $key
     * @return bool
     */
    public static function has($key)
    {
        $prefix = config('cookie.prefix');

        $key = $prefix . $key;

        return ! is_null(static::$royalcms['request']->cookie($key, null));
    }

    /**
     * Retrieve a cookie from the request.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return string
     */
    public static function get($key = null, $default = null)
    {
        $prefix = config('cookie.prefix');

        $key = $prefix . $key;

        return static::$royalcms['request']->cookie($key, $default);
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'cookie';
    }

    /**
     * 设置cookie
     */
    public static function set($name, $value, $option = array())
    {
        $config = array(
            'prefix'   => Config::get('cookie.prefix'), /* cookie 名称前缀 */
            'expire'   => Config::get('cookie.lifetime'), /* cookie 保存时间 */
            'path'     => Config::get('cookie.path'), /* cookie 保存路径 */
            'domain'   => Config::get('cookie.domain'),  /* cookie 有效域名 */
            'secure'   => Config::get('cookie.secure'),
            'httponly' => Config::get('cookie.httponly'),
        );

        $config = array_merge($config, $option);
        $expire = intval($config['expire']);

        $minutes   = $expire;
        $path      = $config['path'];
        $domain    = $config['domain'];
        $secure    = $config['secure'];
        $httpOnly  = $config['httponly'];

        $cookie = static::$royalcms['cookie']->make($name, $value, $minutes, $path, $domain, $secure, $httpOnly);
        Response::withCookie($cookie);
        return $cookie;
    }

    /**
     * 删除指定cookie
     */
    public static function delete($name)
    {
        $cookie = static::$royalcms['cookie']->forget($name, config('cookie.path'), config('cookie.domain'));
        Response::withCookie($cookie);
        return $cookie;
    }

    /**
     * 清除指定前缀的所有cookie
     */
    public static function clear()
    {
        if (empty($_COOKIE)) {
            return;
        }
        /* 要删除的cookie前缀，不指定则删除config设置的指定前缀 */
        $prefix = $prefix = config('cookie.prefix');

        /* 如果前缀为空字符串将不作处理直接返回 */
        if (! empty($prefix)) {
            foreach ($_COOKIE as $key => $val) {
                if (0 === stripos($key, $prefix)) {
                    self::delete(str_replace($prefix, '', $key));
                }
            }
        }
    }
}
