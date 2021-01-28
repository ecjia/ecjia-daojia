<?php

namespace Ecjia\App\Maintain\Installer;

use Ecjia\Component\Plugin\Storages\MaintainPluginStorage;
use ecjia_plugin;
use RC_Plugin;

class PluginInstaller extends \Ecjia\Component\Plugin\Installer\PluginInstaller
{

    /**
     * 安装插件
     */
    public function install()
    {
        $plugin_file = RC_Plugin::plugin_basename( $this->plugin_file );

        (new MaintainPluginStorage())->addPlugin($plugin_file);

        $code = $this->getConfigByKey('maintain_code');

        /* 检查输入 */
        if (empty($code)) {
            return ecjia_plugin::add_error('plugin_install_error', __('运维工具CODE不能为空', 'maintain'));
        }

        $this->installByCode($code);

        return true;
    }

    /**
     * @param $code
     */
    protected function installByCode($code)
    {

    }

    /**
     * 卸载插件
     */
    public function uninstall()
    {
        $code = $this->getConfigByKey('maintain_code');

        /* 检查输入 */
        if (empty($code)) {
            return ecjia_plugin::add_error('plugin_uninstall_error', __('运维工具CODE不能为空', 'maintain'));
        }

        (new PluginUninstaller($code, new MaintainPluginStorage()))->uninstall();

        return true;
    }


}