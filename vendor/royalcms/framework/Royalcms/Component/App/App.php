<?php
namespace Royalcms\Component\App;

defined('IN_ROYALCMS') or exit('No permission resources.');

/**
 * ROYALCMS应用程序创建类
 */
class App
{
    
    private $route;

    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->route = new \RC_Route();
        define('ROUTE_M', $this->route->app);
        define('ROUTE_C', $this->route->control);
        define('ROUTE_A', $this->route->method);
        // 扫描应用列表
        \RC_App::scan_bundles();
    }
    
    
    public function route() {
        return $this->route;
    }

    /**
     * 应用初始化
     */
    public function init()
    {
        $bundle = $this->load_bundle();
        $controller = $bundle->load_controller($this->route->control);
        if (\RC_Error::is_error($controller)) {
            $arg = $this->route->app . '/' . $this->route->control . '/' . $this->route->method;
            if (\RC_Hook::has_action('ecjia_controller')) {
                \RC_Hook::do_action('ecjia_controller', $arg);
            }
            
            $tag = $this->route->app . '/' . $this->route->control . '/' . $this->route->method;
            if (\RC_Hook::has_action($tag)) {
                \RC_Hook::do_action($tag);
            } else {
                _404($controller->get_error_message());
            }
        } elseif (method_exists($controller, $this->route->method)) {
            if (preg_match('/^[_]/i', $this->route->method)) {
                exit('You are visiting the action is to protect the private action');
            } else {
                call_user_func(array(
                    $controller,
                    $this->route->method
                ));
            }
        } else {
            $tag = $this->route->app . '/' . $this->route->control . '/' . $this->route->method;
            if (\RC_Hook::has_action($tag)) {
                \RC_Hook::do_action($tag);
            } else {
                _404('Action does not exist.');
            }
        }
        \RC_Response::send();
    }
    
    /**
     * 加载App Bundle
     */
    public function load_bundle() {
        $bundle = \RC_App::get_bundle($this->route->app);
        /**
         * load the Route app to the applications bundle info.
         *
         * @since 3.1.0
         *
         * @param array $bundle
         *                  array('identifier' => '', 'directory' => '', 'alias' => '')
         */
        $bundle = \RC_Hook::apply_filters('app_load_bundle', $bundle);
        return new Bundle($bundle['identifier'], $bundle['directory'], $bundle['alias']);;
    }
    
}

// end