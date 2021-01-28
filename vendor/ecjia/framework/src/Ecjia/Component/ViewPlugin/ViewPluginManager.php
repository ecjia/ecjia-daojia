<?php


namespace Ecjia\Component\ViewPlugin;


class ViewPluginManager
{

    /**
     * @var \Smarty
     */
    protected $smarty;

    protected $plugins = [];

    public function __construct()
    {
        $this->smarty = royalcms('view')->getSmarty();
    }

    /**
     * @param SmartyPluginAbstract $plugin
     */
    public function addPlugin(SmartyPluginAbstract $plugin)
    {
        $this->register_view_plugin($plugin->getType(), $plugin->getTag(), $plugin->handle());

        $this->plugins[] = $plugin;

        return $this;
    }

    /**
     * @param SmartyPluginAbstract $plugin
     */
    public function removePlugin(SmartyPluginAbstract $plugin)
    {
        $this->plugins = collect($this->plugins)->filter(function (SmartyPluginAbstract $item) use ($plugin) {
            return ! ($item->getType() === $plugin->getType() && $item->getTag() === $plugin->getTag());
        })->toArray();

        $this->unregister_view_plugin($plugin->getType(), $plugin->getTag());

        return $this;
    }

    /**
     * Registers plugin to be used in templates
     * @param string $type plugin type
     * @param string $tag name of template tag
     * @param callback $callback PHP callback to register
     * @param boolean $cacheable if true (default) this fuction is cachable
     * @param array $cache_attr caching attributes if any
     * @return Smarty_Internal_Templatebase current Smarty_Internal_Templatebase (or Smarty or Smarty_Internal_Template) instance for chaining
     * @throws SmartyException              when the plugin tag is invalid
     */
    public function register_view_plugin($type, $tag, $callback, $cacheable = true, $cache_attr = null)
    {
        return $this->smarty->registerPlugin($type, $tag, $callback, $cacheable, $cache_attr);
    }

    /**
     * Unregister Plugin
     * @param string $type of plugin
     * @param string $tag name of plugin
     * @return Smarty_Internal_Templatebase current Smarty_Internal_Templatebase (or Smarty or Smarty_Internal_Template) instance for chaining
     */
    public function unregister_view_plugin($type, $tag)
    {
        return $this->smarty->unregisterPlugin($type, $tag);
    }

}