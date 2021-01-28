<?php


namespace Ecjia\Component\HealthCheck\Checkers;


use Ecjia\Component\HealthCheck\Contracts\CheckerInterface;

/**
 * 检查程序所在子目录位置
 *
 * Class WebPathCheck
 * @package Ecjia\App\Installer\Checkers
 */
class WebPathCheck
{

    public function handle(CheckerInterface $checker)
    {
        $name = $_SERVER['SCRIPT_NAME'];

        if ($name != '/index.php') {
            $path_name = substr($name, 0, -9);
            $checker->getEcjiaError()->add('path_error', sprintf(__('抱歉，当前程序运行在 %s 目录下，ECJia到家程序必须运行在网站根目录下/，请您更换目录后再重新运行安装程序。', 'ecjia'), $path_name));
            $checked_status = false;
            $checked_label = $checker->getCancel();
        }
        else {
            $checked_status = true;
            $checked_label = $checker->getOk();
        }

        return [
            'value' => PHP_OS,
            'checked_label' => $checked_label,
            'checked_status' => $checked_status,
        ];
    }

}