<?php


namespace Ecjia\Component\HealthCheck\Checkers;


use Ecjia\Component\HealthCheck\Contracts\CheckerInterface;

/**
 * 检测域名和端口
 *
 * Class DomainCheck
 * @package Ecjia\App\Installer\Checkers
 */
class DomainCheck
{

    public function handle(CheckerInterface $checker)
    {
        $domain = $_SERVER['SERVER_NAME'];

        $position = strpos($domain, ':'); //查找域名是否带端口号
        if ($position !== false) {
            $domain = substr($domain, 0, $position);
        }

        $domain = strtolower($domain);

        $checked_label = $checker->getOk();
        $checked_status = true;

        return [
            'value' => $domain,
            'checked_label' => $checked_label,
            'checked_status' => $checked_status,
        ];

    }

}