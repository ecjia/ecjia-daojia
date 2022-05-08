<?php


namespace Ecjia\App\Installer\InstallChecker\Checkers;


use Ecjia\App\Installer\InstallChecker\InstallChecker;

/**
 * PHP禁用函数检测
 * Class DisableFunctionsCheck
 * @package Ecjia\App\Installer\InstallChecker\Checkers
 */
class DisableFunctionsCheck
{

    public function handle(InstallChecker $checker)
    {
        //禁用函数检测
        $functions = $this->getCheckDisableFunctions();

        $open_disable_functions = config('app-installer::open_disable_functions');

        $checked = collect($functions)->map(function ($item) use ($open_disable_functions, $checker) {
            $checked_label  = $checker->getCancel() . __('禁用', 'installer');
            $checked_status = in_array($item, $open_disable_functions) ? false : true;

            return [
                'value'          => $item,
                'checked_label'  => $checked_label,
                'checked_status' => $checked_status,
                'name'           => $item,
                'suggest_label'  => in_array($item, $open_disable_functions) ? __('开启', 'installer') : '',
            ];
        })->all();

        return $checked;
    }

    /**
     * 获取禁用函数列表
     * @return []
     */
    public function getCheckDisableFunctions()
    {
        $disable_functions = ini_get('disable_functions');
        if (!empty($disable_functions)) {
            $disabled = explode(',', $disable_functions);
            return $disabled;
        }
        return [];
    }

}