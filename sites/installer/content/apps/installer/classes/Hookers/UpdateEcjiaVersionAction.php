<?php


namespace Ecjia\App\Installer\Hookers;


use ecjia_config;
use ecjia_error;
use Royalcms\Component\Database\QueryException;

/**
 * 更新 ECJIA 版本
 *
 * Class UpdateEcjiaVersionAction
 * @package Ecjia\App\Installer\Hookers
 */
class UpdateEcjiaVersionAction
{

    /**
     * Handle the event.
     * @return ecjia_error|bool
     */
    public function handle()
    {
        try {
            $version = config('release.version', '3.0.0');
            return ecjia_config::add('hidden', 'ecjia_version', $version);
        } catch (QueryException $e) {
            return new ecjia_error($e->getCode(), $e->getMessage());
        }


    }

}