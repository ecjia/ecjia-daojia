<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-22
 * Time: 13:28
 */

namespace Ecjia\Resources\Components\ClientApplicationMetables;

use Ecjia\App\Client\ApplicationConfigFactory\ApplicationConfig;
use Ecjia\App\Client\ApplicationConfigFactory\ApplicationConfigOptions;
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
        $this->name = __('客户端信息', 'client');
    }


    public function getLink()
    {
        return RC_Uri::url('client/admin_mobile_manage/edit', [
            'code' => $this->options->getPlatform()->getCode(),
            'app_id' => $this->options->getAppId(),
        ]);
    }

    public function handleClientMenus()
    {
        RC_Hook::add_action('client_platform_client_menus', function() {
            echo $this->displayMobilePlatformClientMenus('client/admin_mobile_manage/edit');
        });
    }


}