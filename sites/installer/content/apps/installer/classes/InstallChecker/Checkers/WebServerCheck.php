<?php


namespace Ecjia\App\Installer\InstallChecker\Checkers;


use Ecjia\App\Installer\InstallChecker\InstallChecker;

/**
 * 检查WEB服务器
 *
 * Class WebServerCheck
 * @package Ecjia\App\Installer\Checkers
 */
class WebServerCheck
{

    public function handle(InstallChecker $checker)
    {
        $web_server = $_SERVER['SERVER_SOFTWARE'];

        //WEB服务器
        if (stristr($web_server, 'nginx') ||
            stristr($web_server, 'apache') ||
            stristr($web_server, 'iis')) {
            $checked_label = $checker->getOk();
            $checked_status = true;
        } else {
            $checked_label = $checker->getInfo();
            $checked_status = false;
        }

        return [
            'value' => $web_server,
            'checked_label' => $checked_label,
            'checked_status' => $checked_status,
            'name' => __('WEB服务器', 'installer'),
            'suggest_label' => __('推荐Apache/Nginx/IIS', 'installer'),
        ];
    }

}