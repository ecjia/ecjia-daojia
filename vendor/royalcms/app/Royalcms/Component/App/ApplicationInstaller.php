<?php


namespace Royalcms\Component\App;


use ecjia_error;

class ApplicationInstaller
{

    protected $bundle;

    public function __construct(BundleAbstract $bundle)
    {
        $this->bundle = $bundle;
    }

    /**
     * Attempts activation of plugin in a "sandbox" and redirects on success.
     *
     * A plugin that is already activated will not attempt to be activated again.
     *
     * The way it works is by setting the redirection to the error before trying to
     * include the plugin file. If the plugin fails, then the redirection will not
     * be overwritten with the success message. Also, the options will not be
     * updated and the activation hook will not be called on plugin error.
     *
     * It should be noted that in no way the below code will actually prevent errors
     * within the file. The code should not be used elsewhere to replicate the
     * "sandbox", which uses redirection to work.
     * {@source 13 1}
     *
     * If any errors are found or text is outputted, then it will be captured to
     * ensure that the success redirection will update the error redirection.
     *
     * @since 1.0.0
     *
     * @param string $app_id Application ID to main application file with application data.
     * @param bool $silent Prevent calling activation hooks. Optional, default is false.
     * @return ecjia_error|null ecjia_error on invalid file or null on success.
     */
    public function install()
    {



    }

    /**
     * Deactivate a single plugin or multiple plugins.
     *
     * The deactivation hook is disabled by the plugin upgrader by using the $silent
     * parameter.
     *
     * @since 1.0.0
     *
     * @param string|array $plugins Single plugin or list of plugins to deactivate.
     * @param bool $silent Prevent calling deactivation hooks. Default is false.
     * @param mixed $network_wide Whether to deactivate the plugin for all sites in the network.
     * 	A value of null (the default) will deactivate plugins for both the site and the network.
     */
    public function uninstall()
    {




    }

}