<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-22
 * Time: 15:23
 */

namespace Ecjia\App\Mobile;

use RC_Hook;

class ApplicationConfigOptions
{

    /**
     * @var ApplicationPlatform
     */
    protected $platform;

    /**
     * @var int
     */
    protected $app_id;

    public function __construct(ApplicationPlatform $platform, $app_id)
    {
        $this->platform = $platform;
        $this->app_id = $app_id;
    }

    public function getPlatform()
    {
        return $this->platform;
    }

    public function getAppId()
    {
        return $this->app_id;
    }

    public function getConfigGroups()
    {

        $allowKeys = $this->platform->getMobileOptionKeys();
        $optionKeys = (new \Ecjia\App\Mobile\ApplicationConfigFactory)->getOptionKeys();

        $options = $this;
        $defaults = collect($optionKeys)->filter(function($item) use ($allowKeys) {

            if (in_array($item->getCode(), $allowKeys)) {
                return true;
            }

            return false;

        })->map(function($item) use ($options) {

            $item->setApplicationConfigOptions($options);

            return $item->toArray();
        })->all();

        return $defaults;
    }

    public function getOptionKey($code)
    {
        return (new \Ecjia\App\Mobile\ApplicationConfigFactory)->getOptionKey($code)->setApplicationConfigOptions($this);
    }


    public function handleConfigMenus($current_group)
    {
        RC_Hook::add_action('mobile_platform_config_menus', function() use ($current_group) {
            echo $this->displayPlatformConfigMenus($current_group);
        });
    }

    /**
     * 获取客户端菜单
     */
    public function displayPlatformConfigMenus($current_group)
    {

        $groups = $this->getConfigGroups();

        $outHtml = '<div class="setting-group m_b20">' . PHP_EOL;
        $outHtml .= '    <span class="setting-group-title"><i class="fontello-icon-cog"></i>' .__('应用配置', 'mobile'). '</span>' . PHP_EOL;
        $outHtml .= '    <ul class="nav nav-list m_t10">' . PHP_EOL;

        foreach ($groups as $group) {
            $outHtml .= '<li>' . PHP_EOL;

            if ($group['code'] == $current_group) {
                $outHtml .= '<a class="setting-group-item llv-active" href="' .$group['link']. '">' .$group['name']. '</a>' . PHP_EOL;
            } else {
                $outHtml .= '<a class="setting-group-item" href="' .$group['link']. '">' .$group['name']. '</a>' . PHP_EOL;
            }

            $outHtml .= '</li>' . PHP_EOL;
        }

        $outHtml .= '    </ul>' . PHP_EOL;
        $outHtml .= '</div>' . PHP_EOL;

        return $outHtml;
    }


}