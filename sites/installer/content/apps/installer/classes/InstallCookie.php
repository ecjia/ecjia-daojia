<?php


namespace Ecjia\App\Installer;


use RC_Cookie;

class InstallCookie
{

    protected $cookies = [
        'install_agree',
        'install_step',
        'install_config',
        'install_offset',
    ];

    public function setInstallStep($value)
    {
        RC_Cookie::queue(RC_Cookie::make('install_step', $value, 30));
    }

    public function getInstallStep()
    {
        return RC_Cookie::get('install_step');
    }

    public function setInstallOffset($value)
    {
        RC_Cookie::queue(RC_Cookie::make('install_offset', $value, 30));
    }

    public function getInstallOffset()
    {
        return intval(RC_Cookie::get('install_offset'));
    }

    /**
     * 清空安装用到的cookie
     */
    public function clear()
    {
        foreach ($this->cookies as $cookie) {
            RC_Cookie::queue(RC_Cookie::forget($cookie));
        }
    }

}