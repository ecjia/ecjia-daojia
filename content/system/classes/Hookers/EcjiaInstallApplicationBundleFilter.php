<?php


namespace Ecjia\System\Hookers;


use ecjia_config;

/**
 * ECJia 安装应用注册进AppManager
 * Class EcjiaInitLoadAction
 * @package Ecjia\System\Hookers
 */
class EcjiaInstallApplicationBundleFilter
{

    /**
     * Handle the event.
     * @param $bundles
     * @return void
     */
    public function handle($bundles)
    {
        // 只获取已经安装的扩展应用
        $currents = ecjia_config::getAddonConfig('active_applications', true);

        array_unshift($currents, 'ecjia.system');

        $app = royalcms('app');

        $applications = $app->getApplicationLoader()->loadAppsWithIdentifier();
        
        collect($currents)->each(function ($app_id) use ($app, $applications, & $bundles) {

            if (isset($applications[$app_id])) {

                $bundle = $applications->get($app_id);

                if (!empty($bundle)) {
                    $bundles[$bundle->getAlias()] = $bundle->getDirectory();
                }
            }
        });

        return $bundles;
    }

}