<?php


namespace Ecjia\Component\HealthCheck\Checkers;


use DemeterChain\C;
use Ecjia\Component\HealthCheck\Contracts\CheckerInterface;

/**
 * 检查PHP扩展 curl
 *
 * Class ExtensionCurlCheck
 * @package Ecjia\App\Installer\Checkers
 */
class ExtensionCurlCheck
{

    public function handle(CheckerInterface $checker)
    {
        if (extension_loaded('curl')) {
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
            'name' => __('CURL扩展', 'ecjia'),
            'suggest_label' => __('必须开启', 'ecjia'),
        ];

    }
}