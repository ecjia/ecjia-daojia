<?php


namespace Ecjia\App\Rpc;


class AccountGenerate
{

    /**
     * 生成 app id
     */
    public static function generate_app_id(): string
    {
        $key = rc_random(11, 'abcdefghijklmnopqrstuvwxyz0123456789');
        $key = 'ecjia' . $key;
        return $key;
    }

    /**
     * 生成 app secret
     */
    public static function generate_app_secret(): string
    {
        $key = rc_random(32, 'abcdefghijklmnopqrstuvwxyz0123456789');
        return $key;
    }


}