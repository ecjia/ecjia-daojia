<?php


namespace Ecjia\Component\HealthCheck\Checkers;


use Ecjia\Component\HealthCheck\Contracts\CheckerInterface;

class SafeModeCheck
{

    public function handle(CheckerInterface $checker)
    {
        $safe_mode     = ini_get('safe_mode');
        $safe_mode_gid = ini_get('safe_mode_gid');

        if ($safe_mode && $safe_mode_gid) {
            $label          = $checker->getCancel();
            $checked_status = false;
        } else {
            $label          = $checker->getOk();
            $checked_status = true;
        }

        return [
            'value'          => $checked_status ? __('否', 'ecjia') : __('是', 'ecjia'),
            'checked_label'  => $label,
            'checked_status' => $checked_status,
            'name'           => __('安全模式', 'ecjia'),
            'suggest_label'  => __('否，建议关闭', 'ecjia'),
        ];

    }

}