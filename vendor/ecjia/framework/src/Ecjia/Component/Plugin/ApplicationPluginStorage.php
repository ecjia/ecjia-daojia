<?php


namespace Ecjia\Component\Plugin;


use Ecjia\Component\Plugin\Contracts\PluginStorageInterface;
use ecjia_config;

class ApplicationPluginStorage implements PluginStorageInterface
{

    private $active_plugins;

    /**
     * @var array
     */
    protected $storage_code;

    public function __construct()
    {
        $this->active_plugins = ecjia_config::addon()->get($this->storage_code, true);
    }

    /**
     * Get all installed plugins
     * @return array
     */
    public function getPlugins()
    {
        return $this->active_plugins ?: [];
    }

    /**
     * Check whether the plugin is active by checking the active_plugins list.
     *
     * @since 1.0.0
     *
     * @param string $plugin Base plugin path from plugins directory.
     * @return bool True, if in the active plugins list. False, not in the list.
     */
    public function isActived($plugin)
    {
        $plugin_dir     = dirname($plugin);

        return in_array( $plugin_dir, array_keys($this->active_plugins) );
    }


    public function addPlugin($plugin)
    {
        $plugin_dir     = dirname($plugin);

        $this->active_plugins[$plugin_dir] = $plugin;

        ecjia_config::addon()->write($this->storage_code, $this->active_plugins, true);
    }


    public function removePlugin($plugin)
    {
        $plugin_dir     = dirname($plugin);

        unset($this->active_plugins[$plugin_dir]);

        ecjia_config::addon()->write($this->storage_code, $this->active_plugins, true);
    }

}