<?php


namespace Ecjia\Component\HealthCheck\Checkers;


use Ecjia\Component\HealthCheck\Contracts\CheckerInterface;
use Royalcms\Component\Foundation\RoyalcmsConstant;

/**
 * 检查PHP版本
 *
 * Class PHPVersionCheck
 * @package Ecjia\App\Installer\Checkers
 */
class PHPVersionCheck
{

    public function handle(CheckerInterface $checker)
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
            'name' => __('PHP版本', 'ecjia'),
            'suggest_label' => sprintf(__('%s及以上', 'ecjia'), RoyalcmsConstant::PHP_REQUIRED),
        ];

    }

}