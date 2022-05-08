<?php


namespace Ecjia\App\Installer\InstallChecker\Checkers;


use Ecjia\App\Installer\InstallChecker\InstallChecker;

/**
 * 检测PHP扩展 pdo, pdo_mysql
 *
 * Class ExtensionPdoMysqlCheck
 * @package Ecjia\App\Installer\Checkers
 */
class ExtensionPdoMysqlCheck
{

    public function handle(InstallChecker $checker)
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
            'value' => $checked_status ? __('开启', 'installer') : __('关闭', 'installer'),
            'checked_label' => $checked_label,
            'checked_status' => $checked_status,
            'name' => __('PDO扩展', 'installer'),
            'suggest_label' => __('必须开启，请使用MySQL5.5以上版本', 'installer'),
        ];

    }

}