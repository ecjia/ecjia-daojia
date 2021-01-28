<?php


namespace Ecjia\Component\ViewPlugin\Facades;

use Ecjia\Component\ViewPlugin\SmartyPluginAbstract;
use Royalcms\Component\Support\Facades\Facade;

/**
 * Class ViewPluginManager
 * @package Ecjia\Component\ViewPlugin\Facades
 * 
 * @method static \Ecjia\Component\ViewPlugin\ViewPluginManager addPlugin(SmartyPluginAbstract $plugin)
 * @method static \Ecjia\Component\ViewPlugin\ViewPluginManager removePlugin(SmartyPluginAbstract $plugin)
 * @method static \Smarty|\Smarty_Internal_Template register_view_plugin($type, $tag, $callback, $cacheable = true, $cache_attr = null)
 * @method static \Smarty|\Smarty_Internal_Template unregister_view_plugin($type, $tag)
 */
class ViewPluginManager extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'ecjia.view.plugin';
    }

}