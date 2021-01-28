<?php

namespace Royalcms\Component\DefaultRoute;

use Royalcms\Component\DefaultRoute\MatchRules\DefaultMatch;
use Royalcms\Component\DefaultRoute\MatchRules\QueryRMatch;
use Royalcms\Component\DefaultRoute\MatchRules\QueryStringMatch;
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

    /**
     * 路由匹配优先级
     * @var array
     */
    protected $matchRules = [
        QueryRMatch::class,
        QueryStringMatch::class,
        DefaultMatch::class
    ];
    
    public function __construct()
    {
        $this->request = royalcms('request');

        $this->defaultRoute = config('route.'.SITE_HOST, config('route.default'));
    }
    
    /**
     * Find the first route matching a given request.
     */
    public function parser()
    {
        //匹配路由
        collect($this->matchRules)->each(function ($item) {
            $match = new $item($this);
            if ($match instanceof RouteMatchInterface) {
                return ! $match->handle();
            }

            //继续下一个匹配
            return true;
        });
        
        //安全过滤
        $this->module = $this->ksesString($this->module);
        $this->controller = $this->ksesString($this->controller);
        $this->action = $this->ksesString($this->action);

        // define ROUTE_M ROUTE_C ROUTE_A
        define('ROUTE_M', $this->getModule());
        define('ROUTE_C', $this->getController());
        define('ROUTE_A', $this->getAction());
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
        if (empty($this->module)) {
            $moduleName = config('route.module', 'm');
            $this->module = $this->matchDefaultRoute($moduleName);
        }

        return $this->module;
    }
    
    public function getController()
    {
        if (empty($this->controller)) {
            $controllerName = config('route.controller', 'c');
            $this->controller = $this->matchDefaultRoute($controllerName);
        }

        return $this->controller;
    }
    
    public function getAction()
    {
        if (empty($this->action)) {
            $actionName = config('route.action', 'a');
            $this->action = $this->matchDefaultRoute($actionName);
        }

        return $this->action;
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

    /**
     * @param mixed $module
     */
    public function setModule($module): void
    {
        $this->module = $module;
    }

    /**
     * @param mixed $controller
     */
    public function setController($controller): void
    {
        $this->controller = $controller;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action): void
    {
        $this->action = $action;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }



}
