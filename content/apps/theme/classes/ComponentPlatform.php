<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-18
 * Time: 15:58
 */

namespace Ecjia\App\Theme;


use Ecjia\App\Mobile\ApplicationFactory;
use Ecjia\App\Mobile\Contracts\HomeComponentInterface;

class ComponentPlatform
{

    /**
     * @var \Ecjia\App\Mobile\ApplicationFactory
     */
    protected static $factory;

    /**
     * @return \Ecjia\App\Mobile\ApplicationFactory
     */
    public static function getApplicationFactory()
    {
        if (is_null(self::$factory)) {
            self::$factory = new ApplicationFactory();
        }

        return self::$factory;
    }

    /**
     * 获取支持平台菜单组
     * @return array
     */
    public static function getPlatformGroups()
    {
        $defaults = [

            [
                'platform' => 'default',
                'label' => '默认全局',
            ],

        ];

        $platforms = self::getHomeComponentPlatform();

        foreach ($platforms as $platform) {
            $defaults[] = [
                'platform' => $platform->getCode(),
                'label' => $platform->getName(),
            ];
        }

        return $defaults;
    }

    /**
     * 获取支持首页模块化的平台产品
     * @return array
     */
    public static function getHomeComponentPlatform()
    {
        $platforms = self::getApplicationFactory()->getPlatformsByContracts(HomeComponentInterface::class);

        return $platforms;
    }

    /**
     * 获取支持首页模块化的产品多客户端
     * @param $platform
     * @return array
     */
    public static function getPlatformClents($platform)
    {
        if ($platform == 'default') {
            return [];
        }

        $clients = self::getApplicationFactory()->platform($platform)->getClients();

        return $clients;
    }

    /**
     * 获取指定平台，指定客户端的首页模块化组件设置数据
     * @param $device_code
     */
    public static function getUseingHomeComponentWithData($device_code)
    {
        $client = self::getApplicationFactory()->client($device_code);

        $components = $client->getApplicationClientOption()->getOption('home_visual_page');

        //第一层数据存在判断
        if (empty($components)) {
            $components = self::getApplicationFactory()->platform($client->getPlatformCode())
                ->getApplicationPlatformOption()
                ->getOption('home_visual_page');
        }

        //第二层数据存在判断
        if (empty($components)) {
            $components = self::getUseingDefaultHomeComponentPlatform();
        }

        //第三层数据存在判断
        if (empty($components)) {
            $components = self::getApplicationFactory()->platform($client->getPlatformCode())->getHomeComponent();
        }

        $components = (new \Ecjia\App\Theme\Factory())->getComponentsByFilter($components);

        $components = collect($components)->map(function($item) {
            return $item->handleData();
        });

        return $components;
    }

    /**
     * 获取指定平台，指定客户端的首页模块化组件设置数据
     * @param $platform
     */
    public static function getUseingHomeComponentByPlatform($platform, $client = null)
    {
        if ($platform == 'default') {
            return self::getUseingDefaultHomeComponentPlatform();
        }

        if (is_null($client) || $client == 'all') {
            $components = self::getApplicationFactory()->platform($platform)
                ->getApplicationPlatformOption()
                ->getOption('home_visual_page');
        } else {

            $clients = $components = self::getApplicationFactory()->platform($platform)->getClients();
            $device_code = collect($clients)->where('device_client', $client)->pluck('device_code')->get(0);

            $components = self::getApplicationFactory()->client($device_code)
                ->getApplicationClientOption()
                ->getOption('home_visual_page');
        }

        return $components;
    }

    /**
     * 获取默认的全局在使用的首页模块化组件设置数据
     * @return \ArrayObject|mixed|string
     */
    public static function getUseingDefaultHomeComponentPlatform()
    {
        $useing_group_code = \ecjia::config('home_visual_page');
        $useing_group_code = unserialize($useing_group_code);
        return $useing_group_code;
    }

    /**
     * 获取指定平台下可用的首页模块组件
     * @param $platform
     * @return array
     */
    public static function getAvaliableHomeComponentByPlatform($platform)
    {
        if ($platform == 'default') {
            return self::getDefaultHomeComponentPlatform();
        }

        $components = self::getApplicationFactory()->platform($platform)->getDefinedHomeComponent();

        $components = (new \Ecjia\App\Theme\Factory())->getComponentsByFilter($components);

        return $components;
    }

    /**
     * 获取默认全部可用的首页模块组件
     * @return array
     */
    public static function getDefaultHomeComponentPlatform()
    {

        $components = (new \Ecjia\App\Theme\Factory())->getComponents();

        return $components;
    }

    /**
     * 保存产品模块化存储数据
     * @param $vaule
     * @param $platform
     * @param $client
     * @return mixed
     */
    public static function saveHomeComponentByPlatform($vaule, $platform, $client)
    {

        if ($platform == 'default') {
            return self::saveDefaultHomeComponentPlatform($vaule);
        }

        if ($client == 'all') {
            $saved = self::getApplicationFactory()->platform($platform)
                ->getApplicationPlatformOption()
                ->saveOption('home_visual_page', $vaule);
        } else {
            $clients = $components = self::getApplicationFactory()->platform($platform)->getClients();
            $device_code = collect($clients)->where('device_client', $client)->pluck('device_code')->get(0);

            try {
                $saved = self::getApplicationFactory()->client($device_code)
                    ->getApplicationClientOption()
                    ->saveOption('home_visual_page', $vaule);
            } catch (\Exception $e) {
                return new \ecjia_error('save_error', $e->getMessage());
            }

        }

        return $saved;
    }

    /**
     * 保存全局默认的模块化存储数据
     * @param $vaule
     * @return mixed
     */
    public static function saveDefaultHomeComponentPlatform($vaule)
    {
        $vaule = serialize($vaule);
        return \ecjia_config::write_config('home_visual_page', $vaule);
    }

}