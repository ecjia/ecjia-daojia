<?php


namespace Ecjia\Component\Plugin;

use Ecjia\Component\Plugin\Contracts\PluginStorageInterface;
use ecjia_config;

class ActivePluginStorage implements PluginStorageInterface
{
    private $active_plugins;

    public function __construct()
    {
        $this->active_plugins = ecjia_config::addon()->get('active_plugins', true);
    }

    /**
     * Get all installed plugins
     */
    public function getPlugins()
    {
        return $this->active_plugins;
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
        return in_array( $plugin, $this->active_plugins );
    }


    public function addPlugin($plugin)
    {
        $this->active_plugins[] = $plugin;

        sort($this->active_plugins);

        ecjia_config::addon()->write('active_plugins', $this->active_plugins, true);
    }


    public function removePlugin($plugin)
    {
        $key = array_search($plugin, $this->active_plugins);
        if (false !== $key) {
            unset($this->active_plugins[$key]);
        }

        ecjia_config::addon()->write('active_plugins', $this->active_plugins, true);
    }


}