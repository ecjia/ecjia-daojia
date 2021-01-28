<?php


namespace Ecjia\Component\Plugin;


use Ecjia\Component\Plugin\Facades\PluginManager as Ecjia_PluginManager;

trait AddonPluginTrait
{
    /**
     * 存储安装插件的列表
     * @var string
     */
    protected $addon_plugin_name;

    /**
     * 获取当前类型的已经安装激活插件
     */
    public function getInstalledPlugins()
    {
        return ecjia_config::getAddonConfig($this->addon_plugin_name, true, false);
    }

    /**
     * 添加安装插件
     * @param $plugin_file
     */
    public function addInstallPlugin($plugin_file)
    {
        $plugin_file = RC_Plugin::plugin_basename( $plugin_file );
        $plugin_dir = dirname($plugin_file);

        $plugins = $this->getInstalledPlugins();
        $plugins[$plugin_dir] = $plugin_file;

        ecjia_config::writeAddonConfig($this->addon_plugin_name, $plugins, true, true);
    }

    /**
     * 移除安装插件
     * @param $plugin_file
     */
    public function removeInstallPlugin($plugin_file)
    {
        $plugin_file = RC_Plugin::plugin_basename( $plugin_file );
        $plugin_dir = dirname($plugin_file);

        $plugins = $this->getInstalledPlugins();
        unset($plugins[$plugin_dir]);

        ecjia_config::writeAddonConfig($this->addon_plugin_name, $plugins, true, true);
    }

    /**
     * 获取指定插件的实例
     * @param string $code
     * @param array $config
     * @return \Ecjia\System\Plugin\AbstractPlugin
     */
    public function pluginInstance($code, array $config = array())
    {
        if (empty($config)) {
            $config = $this->configData($code);
        }

        $plugins = $this->getInstalledPlugins();
        Ecjia_PluginManager::addPlugins($plugins);

        $handler = Ecjia_PluginManager::driver($code);
        $handler->setConfig($config);

        return $handler;
    }

    /**
     * 获取数据中的Config配置数据，并处理
     */
    abstract public function configData($code);


}