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
use RC_Hook;
use RC_Uri;

class MobileDevice extends ApplicationConfig
{

    protected $code = 'mobile_device';

    protected $name;

    protected $link;

    protected $clients = [
        'all',
        'iphone',
        'android',
        'weapp',
        'h5',
    ];

    /**
     * @var ApplicationConfigOptions
     */
    protected $options;

    public function __construct()
    {
        $this->name = __('移动设备', 'client');
    }


    public function getLink()
    {
        return RC_Uri::url('client/admin_device/init', [
            'code' => $this->options->getPlatform()->getCode(),
            'app_id' => $this->options->getAppId(),
        ]);
    }

    public function handleClientMenus()
    {
        RC_Hook::add_action('client_platform_client_menus', function() {
            echo $this->displayMobilePlatformClientMenus('client/admin_device/init');
        });
    }


}