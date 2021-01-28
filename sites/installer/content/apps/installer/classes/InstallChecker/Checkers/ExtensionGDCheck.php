<?php


namespace Ecjia\App\Installer\InstallChecker\Checkers;


use Ecjia\App\Installer\InstallChecker\InstallChecker;

/**
 * 检测PHP扩展 GD
 *
 * Class ExtensionGDCheck
 * @package Ecjia\App\Installer\Checkers
 */
class ExtensionGDCheck
{

    public function handle(InstallChecker $checker)
    {
        if (extension_loaded('gd')) {

            $gd_support = [];

            if (function_exists('imagepng')) {
                $gd_support[] = 'png';
            }
            if (function_exists('imagejpeg')) {
                $gd_support[] = 'jpg';
            }
            if (function_exists('imagegif')) {
                $gd_support[] = 'gif';
            }

            $label = sprintf(__("支持（%s）", 'installer'), implode(' / ', $gd_support));

            $checked_label = $checker->getOk();
            $checked_status = true;
        }
        else {
            $label = '';
            $checked_label = $checker->getCancel();
            $checked_status = false;
        }

        return [
            'value' => $checked_status ? $label : __('关闭', 'installer'),
            'checked_label' => $checked_label,
            'checked_status' => $checked_status,
            'name' => __('GD扩展', 'installer'),
            'suggest_label' => __('必须开启', 'installer'),
        ];

    }

}