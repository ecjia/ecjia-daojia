<?php


namespace Ecjia\App\Installer;


use RC_Cache;
use RC_Session;

class AdminPasswordStorage
{

    public static function save($admin_name, $admin_password)
    {
        $admin = [$admin_name, $admin_password];
        RC_Cache::put('install_create_admin', $admin);
    }

    /**
     * @return array|null[]
     */
    public static function get()
    {
        $admin = RC_Cache::get('install_create_admin');
        if (is_array($admin)) {
            return $admin;
        }
        return [null, null];
    }


}