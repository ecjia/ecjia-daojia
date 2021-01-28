<?php


namespace Ecjia\App\Installer;


class Timezone
{

    /**
     * 获得服务器所在时区
     *
     * @access  public
     * @return  string     返回时区串，形如Asia/Shanghai
     */
    public static function getLocalTimezone()
    {
        return date_default_timezone_get();
    }

    /**
     * 获得时区列表，如有重复值，只保留第一个
     *
     * @access  public
     * @return  array
     */
    public static function getTimezones()
    {
        $timezones = config('app-installer::timezones');
        return array_unique($timezones);
    }

}