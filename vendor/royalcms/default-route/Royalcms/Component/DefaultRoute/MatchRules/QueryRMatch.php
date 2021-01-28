<?php

namespace Royalcms\Component\DefaultRoute\MatchRules;


use Royalcms\Component\DefaultRoute\RouteMatchInterface;

/**
 * Class QueryRMatch
 * @package Royalcms\Component\DefaultRoute\MatchRules
 */
class QueryRMatch implements RouteMatchInterface
{

    /**
     * @var \Royalcms\Component\DefaultRoute\HttpQueryRoute
     */
    protected $route;

    public function __construct($route)
    {
        $this->route = $route;
    }

    /**
     * 参数路由兼容
     * index.php?r=admin/index/init
     */
    public function handle()
    {
        $moduleName     = config('route.module', 'm');
        $controllerName = config('route.controller', 'c');
        $actionName     = config('route.action', 'a');
        $routeName      = config('route.route', 'r');

        if (($route = $this->route->getRequest()->input($routeName))) {

            list($module, $controller, $action) = explode('/', $route);

            $module = $module ?: $this->route->matchDefaultRoute($moduleName);
            $controller = $controller ?: $this->route->matchDefaultRoute($controllerName);
            $action = $action ?: $this->route->matchDefaultRoute($actionName);

            $this->route->setModule($module);
            $this->route->setController($controller);
            $this->route->setAction($action);

            return true;
        }

        return false;
    }
}