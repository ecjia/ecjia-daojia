<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-22
 * Time: 13:28
 */

namespace Ecjia\App\Mobile\Metables;

use Ecjia\App\Mobile\ApplicationConfig;
use Ecjia\App\Mobile\ApplicationConfigOptions;
use RC_Uri;
use RC_Hook;

class ConfigClient extends ApplicationConfig
{

    protected $code = 'config_client';

    protected $name;

    protected $link;

    protected $clients = [
        'iphone',
        'android',
        'local',
        'weapp',
        'h5',
    ];

    /**
     * @var ApplicationConfigOptions
     */
    protected $options;

    public function __construct()
    {
        $this->name = __('客户端信息', 'mobile');
    }


    public function getLink()
    {
        return RC_Uri::url('mobile/admin_mobile_manage/edit', [
            'code' => $this->options->getPlatform()->getCode(),
            'app_id' => $this->options->getAppId(),
        ]);
    }

    public function handleClientMenus()
    {
        RC_Hook::add_action('mobile_platform_client_menus', function() {
            echo $this->displayMobilePlatformClientMenus('mobile/admin_mobile_manage/edit');
        });
    }


}