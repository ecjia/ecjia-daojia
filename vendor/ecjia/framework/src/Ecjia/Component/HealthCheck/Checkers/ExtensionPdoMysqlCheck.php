<?php


namespace Ecjia\Component\HealthCheck\Checkers;


use Ecjia\Component\HealthCheck\Contracts\CheckerInterface;

/**
 * 检测PHP扩展 pdo, pdo_mysql
 *
 * Class ExtensionPdoMysqlCheck
 * @package Ecjia\App\Installer\Checkers
 */
class ExtensionPdoMysqlCheck
{

    public function handle(CheckerInterface $checker)
    {
        if (extension_loaded('PDO') && extension_loaded('pdo_mysql')) {
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
            'name' => __('PDO扩展', 'ecjia'),
            'suggest_label' => __('必须开启，请使用MySQL5.5以上版本', 'ecjia'),
        ];

    }

}