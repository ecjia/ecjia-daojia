<?php


namespace Ecjia\App\Installer\InstallChecker\Checkers;


use Ecjia\App\Installer\InstallChecker\InstallChecker;

class SafeModeCheck
{

    public function handle(InstallChecker $checker)
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
            'value'          => $checked_status ? __('否', 'installer') : __('是', 'installer'),
            'checked_label'  => $label,
            'checked_status' => $checked_status,
            'name'           => __('安全模式', 'installer'),
            'suggest_label'  => __('否，建议关闭', 'installer'),
        ];

    }

}