<?php


namespace Ecjia\App\Installer\InstallChecker\Checkers;


use Ecjia\App\Installer\InstallChecker\InstallChecker;

/**
 * 检查PHP扩展 fileinfo
 *
 * Class ExtensionFileinfoCheck
 * @package Ecjia\App\Installer\Checkers
 */
class ExtensionFileinfoCheck
{

    public function handle(InstallChecker $checker)
    {
        if (extension_loaded('fileinfo')) {
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
            'name' => __('Fileinfo扩展', 'installer'),
            'suggest_label' => __('必须开启', 'installer'),
        ];

    }
}