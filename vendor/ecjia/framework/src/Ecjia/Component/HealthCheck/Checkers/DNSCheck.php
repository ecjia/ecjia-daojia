<?php


namespace Ecjia\Component\HealthCheck\Checkers;


use Ecjia\Component\HealthCheck\Contracts\CheckerInterface;

/**
 * 检查DNS
 *
 * Class DNSCheck
 * @package Ecjia\App\Installer\Checkers
 */
class DNSCheck
{

    public function handle(CheckerInterface $checker)
    {

        $domain = $_SERVER['SERVER_NAME'];

        $position = strpos($domain, ':'); //查找域名是否带端口号
        if ($position !== false) {
            $domain = substr($domain, 0, $position);
        }

        $domain = strtolower($domain);

        $host = gethostbyname($domain);

        if (preg_match("/^[0-9.]{7,15}$/", $host)) {
            $checked_label = $checker->getOk();
            $checked_status = true;
        }
        else {
            $checked_label = $checker->getCancel();
            $checked_status = false;
        }

        return [
            'value' => $host,
            'checked_label' => $checked_label,
            'checked_status' => $checked_status,
            'name' => __('DNS解析', 'ecjia'),
            'suggest_label' => __('建议设置正确', 'ecjia'),
        ];
    }

}