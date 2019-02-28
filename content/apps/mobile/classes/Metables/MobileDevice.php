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
        $this->name = __('移动设备', 'mobile');
    }


    public function getLink()
    {
        return RC_Uri::url('mobile/admin_device/init', [
            'code' => $this->options->getPlatform()->getCode(),
            'app_id' => $this->options->getAppId(),
        ]);
    }

    public function handleClientMenus()
    {
        RC_Hook::add_action('mobile_platform_client_menus', function() {
            echo $this->displayMobilePlatformClientMenus('mobile/admin_device/init');
        });
    }


}