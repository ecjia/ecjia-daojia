<?php


namespace Ecjia\System\Hookers;


use ecjia_config;
use RC_Loader;
use RC_Plugin;

class EcjiaLoadGlobalPluginsAction
{

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle()
    {
        if (! is_installed_ecjia()) {
            return ;
        }

        $global_plugins = ecjia_config::instance()->get_addon_config('global_plugins', true);
        if (is_array($global_plugins)) {
            foreach ($global_plugins as $plugin_file) {
                RC_Plugin::load_files($plugin_file);
            }
        }

    }
}