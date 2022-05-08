<?php


namespace Ecjia\Component\HealthCheck\Checkers;


use Ecjia\Component\HealthCheck\Contracts\CheckerInterface;

/**
 * 检测PHP扩展MySQLi
 *
 * Class ExtensionMysqliCheck
 * @package Ecjia\App\Installer\Checkers
 */
class ExtensionMysqliCheck
{

    public function handle(CheckerInterface $checker)
    {
        if (extension_loaded('mysqli')) {
            $checked_label = $checker->getOk();
            $checked_status = true;
        }
        else {
            $checked_label = $checker->getCancel();
            $checked_status = false;
        }

        return [
            'value' => $checked_status ? __('开启', 'ecjia') : __('关闭', 'ecjia'),
            'checked_label' => $checked_label,
            'checked_status' => $checked_status,
            'name' => __('MySQLi扩展', 'ecjia'),
            'suggest_label' => __('必须开启，请使用MySQL5.5以上版本', 'ecjia'),
        ];

    }

}