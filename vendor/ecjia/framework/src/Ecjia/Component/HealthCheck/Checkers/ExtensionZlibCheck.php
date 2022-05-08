<?php


namespace Ecjia\Component\HealthCheck\Checkers;


use Ecjia\Component\HealthCheck\Contracts\CheckerInterface;

class ExtensionZlibCheck
{

    public function handle(CheckerInterface $checker)
    {
        if (extension_loaded('zlib')) {
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
            'name' => __('ZLIB扩展', 'ecjia'),
            'suggest_label' => __('必须开启', 'ecjia'),
        ];

    }
}