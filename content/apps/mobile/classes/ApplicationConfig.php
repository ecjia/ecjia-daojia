<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-22
 * Time: 11:24
 */

namespace Ecjia\App\Mobile;

use Ecjia\App\Mobile\Models\MobileManageModel;
use RC_Uri;

abstract class ApplicationConfig
{

    /**
     * @var string 配置项名字 key
     */
    protected $code;

    /**
     * @var string 配置项显示名字
     */
    protected $name;

    /**
     * @var string 配置项链接
     */
    protected $link;

    /**
     * @var array 配置项支付客户端类型
     */
    protected $clients = [];

    /**
     * @var ApplicationConfigOptions
     */
    protected $options;

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

    public function getCode()
    {
        return $this->code;
    }


    public function getName()
    {
        return $this->name;
    }

    abstract public function getLink();

    public function toArray()
    {
        return [
            'code' => $this->code,
            'name' => $this->name,
            'link' => $this->getLink(),
        ];
    }

    public function setApplicationConfigOptions(ApplicationConfigOptions $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * 获取支持首页模块化的产品多客户端
     * @param $platform
     * @return array
     */
    public function getMobilePlatformClients()
    {
        $collection = MobileManageModel::platform($this->options->getPlatform()->getCode())->get();

        $clients = $collection->filter(function ($item) {

            if (in_array($item->device_client, $this->clients)) {
                return true;
            }

            return false;

        })->map(function ($item) {

            return [
                'app_id' => $item->app_id,
                'app_name' => $item->app_name,
                'platform' => $this->options->getPlatform()->getCode(),
                'device_client' => $item->device_client,
                'device_code' => $item->device_code,
            ];

        });

        $clients = $clients->all();

        if (in_array('all', $this->clients)) {
            if (count($collection)) {
                array_unshift($clients, [
                    'app_id' => 0,
                    'app_name' => __('统一设置', 'mobile'),
                    'platform' => $this->options->getPlatform()->getCode(),
                    'device_client' => 'all',
                    'device_code' => 0,
                ]);
            }
        }

        return $clients;
    }


    public function getMobilePlatformClient(array $clients = null)
    {
        if (is_null($clients)) {
            $clients = $this->getMobilePlatformClients();
        }
        
        $data = collect($clients)->where('app_id', $this->options->getAppId())->first();
        if (empty($data)) {
            $data = collect($clients)->first();
        }

        return $data;
    }

    /**
     * 获取客户端菜单
     */
    public function displayMobilePlatformClientMenus($route)
    {

        $platform_clients = $this->getMobilePlatformClients();
        $current_client = $this->getMobilePlatformClient();

        $outHtml = '';

        if (count($platform_clients)) {

            $outHtml = '<ul class="nav nav-tabs">' . PHP_EOL;

            foreach ($platform_clients as $client) {

                if ($client['device_client'] == $current_client['device_client']) {

                    $outHtml .= '<li class="active"><a href="javascript:;">' . $client['app_name'] . '</a></li>' . PHP_EOL;

                } else {

                    $url = RC_Uri::url($route, [
                        'code' => $client['platform'],
                        'app_id' => $client['app_id'],
                    ]);
                    $outHtml .= '<li><a class="data-pjax" href="' . $url . '">' . $client['app_name'] . '</a></li>' . PHP_EOL;
                }

            }

            $outHtml .= '</ul>' . PHP_EOL;

        }

        return $outHtml;
    }

}