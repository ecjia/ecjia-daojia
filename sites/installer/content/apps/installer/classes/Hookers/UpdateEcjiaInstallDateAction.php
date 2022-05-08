<?php


namespace Ecjia\App\Installer\Hookers;


use ecjia_config;
use ecjia_error;
use RC_Time;
use Royalcms\Component\Database\QueryException;

/**
 * 更新 ECJIA 安装日期
 *
 * Class UpdateEcjiaInstallDateAction
 * @package Ecjia\App\Installer\Hookers
 */
class UpdateEcjiaInstallDateAction
{

    /**
     * Handle the event.
     * @return ecjia_error|bool
     */
    public function handle()
    {
        try {
            return ecjia_config::add('hidden', 'install_date', RC_Time::gmtime());
        } catch (QueryException $e) {
            return new ecjia_error($e->getCode(), $e->getMessage());
        }
    }

}