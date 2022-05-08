<?php


namespace Ecjia\Component\HealthCheck\Checkers;


use Ecjia\Component\HealthCheck\Contracts\CheckerInterface;

/**
 * 检查操作系统
 *
 * Class PHPOSCheck
 * @package Ecjia\App\Installer\Checkers
 */
class PHPOSCheck
{

    public function handle(CheckerInterface $checker)
    {
        $os_array = array('Linux', 'FreeBSD', 'WINNT', 'Darwin');

        if (in_array(PHP_OS, $os_array)) {
            $checked_status = true;
            $checked_label = $checker->getOk();
        }
        else {
            $checked_status = false;
            $checked_label = $checker->getCancel();
        }

        return [
            'value' => PHP_OS,
            'checked_label' => $checked_label,
            'checked_status' => $checked_status,
            'name' => __('服务器操作系统', 'ecjia'),
            'suggest_label' => __('Windows_NT/Linux/Freebsd/Darwin', 'ecjia'),
        ];
    }

}