<?php


namespace Ecjia\System\Hookers;


use ecjia_cloud;
use ecjia_config;
use ecjia_utility;

class ShopConfigUpdatedAfterAction
{

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle()
    {
        /* 清除缓存 */
        ecjia_config::instance()->clear_cache();

        ecjia_cloud::instance()->api('product/analysis/record')->data(ecjia_utility::get_site_info())->run();
    }

}