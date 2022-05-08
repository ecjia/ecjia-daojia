<?php

namespace Ecjia\Component\Plugin\Installer;

use Ecjia\Component\Plugin\Storages\PaymentPluginStorage;
use ecjia_plugin;
use RC_Plugin;

abstract class PluginInstaller
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var string
     */
    protected $plugin_file;

    /**
     * @var array
     */
    protected $plugin_data;

    /**
     * PluginInstaller constructor.
     * @param $plugin_file
     * @param array $config
     */
    public function __construct($plugin_file, $config = [])
    {
        $this->plugin_file = $plugin_file;
        $this->config = $config;
        $this->plugin_data = RC_Plugin::get_plugin_data($plugin_file);
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function getConfigByKey($key, $default = null)
    {
        return array_get($this->config, $key, $default);
    }

    /**
     * @param mixed $config
     * @return PluginInstaller
     */
    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPluginFile()
    {
        return $this->plugin_file;
    }

    /**
     * @param mixed $plugin_file
     * @return PluginInstaller
     */
    public function setPluginFile($plugin_file)
    {
        $this->plugin_file = $plugin_file;
        return $this;
    }

    /**
     * @return array
     */
    public function getPluginData(): array
    {
        return $this->plugin_data;
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function getPluginDataByKey($key, $default = null)
    {
        return array_get($this->plugin_data, $key, $default);
    }

    /**
     * @param array $plugin_data
     * @return PluginInstaller
     */
    public function setPluginData(array $plugin_data): PluginInstaller
    {
        $this->plugin_data = $plugin_data;
        return $this;
    }



    /**
     * 安装插件
     */
    abstract public function install();

    /**
     * 卸载插件
     */
    abstract public function uninstall();


}