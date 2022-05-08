<?php


namespace Ecjia\App\Installer\InstallChecker\Checkers;


use Ecjia\App\Installer\InstallChecker\InstallChecker;

class TimezoneCheck
{

    public function handle(InstallChecker $checker)
    {
        $result = function_exists("date_default_timezone_get") ? date_default_timezone_get() : __('无需设置', 'installer');

        return [
            'value' => $result,
            'checked_label' => $checker->getOk(),
            'checked_status' => true,
            'name' => __('时区检查', 'installer'),
            'suggest_label' => __('建议设置正确', 'installer'),
        ];

    }
}