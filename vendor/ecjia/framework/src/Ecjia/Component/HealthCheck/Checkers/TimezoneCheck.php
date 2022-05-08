<?php


namespace Ecjia\Component\HealthCheck\Checkers;


use Ecjia\Component\HealthCheck\Contracts\CheckerInterface;

class TimezoneCheck
{

    public function handle(CheckerInterface $checker)
    {
        $result = function_exists("date_default_timezone_get") ? date_default_timezone_get() : __('无需设置', 'ecjia');

        return [
            'value' => $result,
            'checked_label' => $checker->getOk(),
            'checked_status' => true,
            'name' => __('时区检查', 'ecjia'),
            'suggest_label' => __('建议设置正确', 'ecjia'),
        ];

    }
}