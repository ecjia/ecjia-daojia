<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/9/29
 * Time: 2:13 PM
 */

namespace Ecjia\App\Platform\Plugin;


class PluginManager
{

    protected $account;

    public function __construct($account)
    {
        $this->account = $account;

    }


    /**
     * 获取公众号下已经启用的插件
     */
    public function getEnabledPlugins(\Closure $callback = null)
    {
        $PlatformPlugin = new PlatformPlugin();
        $plugins = $PlatformPlugin->getEnableList();

        if (! empty($plugins)) {
            foreach ($plugins as $key => & $plugin) {

                $extend_handle = $PlatformPlugin->channel($plugin['ext_code']);
                if (is_ecjia_error($extend_handle)) {
                    unset($plugins[$key]);
                    continue;
                }

                if (! $extend_handle->hasPlatform($this->account->getPlatform())) {
                    unset($plugins[$key]);
                    continue;
                }

                $extend_handle->setPlatformTypeCode($this->account->getTypeCode());
                if (! $extend_handle->hasSupport($this->account->getPlatformAccountType()))
                {
                    unset($plugins[$key]);
                }
                else
                {
                    if (is_callable($callback)) {
                        $plugin = $callback($extend_handle, $plugin);
                    }
                }

            }
        }

        return $plugins;
    }

    /**
     * 获取公众号下可用插件数量
     */
    public function getCount()
    {

    }


}