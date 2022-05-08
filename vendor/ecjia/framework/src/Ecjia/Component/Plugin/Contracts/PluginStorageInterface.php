<?php


namespace Ecjia\Component\Plugin\Contracts;


interface PluginStorageInterface
{

    /**
     * Get all installed plugins
     */
    public function getPlugins();


    /**
     * Check whether the plugin is active by checking the active_plugins list.
     *
     * @since 1.0.0
     *
     * @param string $plugin Base plugin path from plugins directory.
     * @return bool True, if in the active plugins list. False, not in the list.
     */
    public function isActived($plugin);


    public function addPlugin($plugin);


    public function removePlugin($plugin);


}