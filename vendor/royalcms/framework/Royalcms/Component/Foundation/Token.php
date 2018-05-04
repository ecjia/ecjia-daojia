<?php namespace Royalcms\Component\Foundation;

use Royalcms\Component\Support\Facades\Config;

class Token extends RoyalcmsObject
{

    public static $key = "royalcms";

    /**
     * 创建令牌
     */
    public static function create()
    {
        $token_name = Config::get('system.token_name');
        if (! is_null(RC_Session::get($token_name))) {
            return RC_Session::get($token_name);
        }
        $k = self::$key . mt_rand(1, 10000) . SYS_TIME . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'];

        $_SESSION[$token_name] = md5($k);
    }

    /**
     * 验证令牌
     */
    public static function check()
    {
        $token_name = Config::get('system.token_name');

        $key = $_SESSION[$token_name];
        $cli_token = isset($_POST[$token_name]) ? $_POST[$token_name] : (isset($_GET[$token_name]) ? $_GET[$token_name] : null);
        return ! is_null($key) && ! is_null($cli_token) && ($key === $cli_token);
    }
}

// end