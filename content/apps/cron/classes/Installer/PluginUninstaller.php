<?php


namespace Ecjia\App\Cron\Installer;


use RC_DB;

class PluginUninstaller extends \Ecjia\Component\Plugin\Installer\PluginUninstaller
{

    public function uninstallByCode($code)
    {
        /* 从数据库中删除支付方式 */
        RC_DB::connection('ecjia')->table('crons')->where('cron_code', $code)->delete();
    }

}