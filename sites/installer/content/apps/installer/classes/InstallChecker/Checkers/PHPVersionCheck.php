<?php


namespace Ecjia\App\Installer\InstallChecker\Checkers;


use Ecjia\App\Installer\InstallChecker\InstallChecker;
use Royalcms\Component\Foundation\RoyalcmsConstant;

/**
 * 检查PHP版本
 *
 * Class PHPVersionCheck
 * @package Ecjia\App\Installer\Checkers
 */
class PHPVersionCheck
{

    public function handle(InstallChecker $checker)
    {
        if (version_compare(PHP_VERSION, RoyalcmsConstant::PHP_REQUIRED, '>=')) {
            $checked_label = $checker->getOk();
            $checked_status = true;
        }
        else {
            $checked_label = $checker->getCancel();
            $checked_status = false;
        }

        return [
            'value' => PHP_VERSION,
            'checked_label' => $checked_label,
            'checked_status' => $checked_status,
            'name' => __('PHP版本', 'installer'),
            'suggest_label' => sprintf(__('%s及以上', 'installer'), RoyalcmsConstant::PHP_REQUIRED),
        ];

    }

}