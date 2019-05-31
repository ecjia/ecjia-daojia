<?php

namespace Royalcms\Component\DefaultRoute;

use Royalcms\Component\Http\Request;
use Royalcms\Component\Rewrite\Facades\Rewrite;

class HttpQueryRoute
{
    
    use DefaultRouteTrait;
    
    
    protected $module;
    
    
    protected $controller;
    
    
    protected $action;
    
    /**
     * 
     * @var \Royalcms\Component\Http\Request  $request
     */
    protected $request;
    
    
    protected $defaultRoute;
    
    
    public function __construct()
    {
        $this->request = royalcms('request');
        
        $this->defaultRoute = config('route.'.SITE_HOST, config('route.default'));

        $this->match($this->request);
        
    }
    
    /**
     * Find the first route matching a given request.
     *
     * @param  \Royalcms\Component\Http\Request  $request
     * @return \Royalcms\Component\Routing\Route
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function match(Request $request)
    {
        $moduleName = config('route.module', 'm');
        $controllerName = config('route.controller', 'c');
        $actionName = config('route.action', 'a');
        $routeName = config('route.route', 'r');
        
        /**
         * @todo
         * Rewrite规则路由支持
         */
        Rewrite::instance()->set_permalink_structure(true);
        $rewrite = royalcms('rewrite');
        $rewrite->add_query_vars(array_keys($_GET));
        $rewrite->parse_request();
        $params = $rewrite->get_query_var();
        $request->merge($params);
        
        /**
         * 参数路由兼容
         * index.php?r=admin/index/init
         */
        if (($route = $request->input($routeName)) != false) {
            list($module, $controller, $action) = explode('/', $route);
            
            $this->module = $module ?: $this->matchDefaultRoute($moduleName);
            $this->controller = $controller ?: $this->matchDefaultRoute($controllerName);
            $this->action = $action ?: $this->matchDefaultRoute($actionName);
        }
        /**
         * 默认query_string参数路由支持
         * index.php?m=admincp&c=index&a=init
         */
        else if ($request->input($moduleName)) {
            $this->module = $request->input($moduleName, $this->matchDefaultRoute($moduleName));
            $this->controller = $request->input($controllerName, $this->matchDefaultRoute($controllerName));
            $this->action = $request->input($actionName, $this->matchDefaultRoute($actionName));
        }
        /**
         * path_info 路由支持
         * index.php/admin/index/init
         */
        elseif (($route = ltrim($request->getPathInfo(), '/')) != false) {
            list($module, $controller, $action) = explode('/', $route);
            
            $this->module = $module ?: $this->matchDefaultRoute($moduleName);
            $this->controller = $controller ?: $this->matchDefaultRoute($controllerName);
            $this->action = $action ?: $this->matchDefaultRoute($actionName);
        }
        /**
         * 默认route.php配置路由支持
         * index.php?m=admincp&c=index&a=init
         */
        else {
            $this->module = $this->matchDefaultRoute($moduleName);
            $this->controller = $this->matchDefaultRoute($controllerName);
            $this->action = $this->matchDefaultRoute($actionName);
        }

        $this->module = $this->ksesString($this->module);
        $this->controller = $this->ksesString($this->controller);
        $this->action = $this->ksesString($this->action);
    }

    /**
     * 过滤路由参数中的非法字符
     * @param $route
     * @return string
     */
    protected function ksesString($route)
    {
        return safe_remove($route);
    }
    
    public function matchDefaultRoute($key)
    {
        return array_get($this->defaultRoute, $key);
    }
    
    
    public function getModule()
    {
        $moduleName = config('route.module', 'm');
        return $this->module ?: $this->matchDefaultRoute($moduleName);
    }
    
    public function getController()
    {
        $controllerName = config('route.controller', 'c');
        return $this->controller ?: $this->matchDefaultRoute($controllerName);
    }
    
    public function getAction()
    {
        $actionName = config('route.action', 'a');
        return $this->action ?: $this->matchDefaultRoute($actionName);
    }

    /**
     * 获取路由规则
     *
     * @return array
     */
    public function getRule()
    {
        return $rules = config('route.rules', []);
    }

    public function justCurrentRoute($route)
    {
        $route = trim($route, '/');
        $current = $this->module . '/' . $this->controller . '/' . $this->action;
        if ($route == $current) {
            return true;
        } else {
            return false;
        }
    }
    
}
