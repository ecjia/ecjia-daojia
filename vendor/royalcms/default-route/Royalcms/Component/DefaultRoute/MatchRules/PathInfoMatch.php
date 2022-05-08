<?php

namespace Royalcms\Component\DefaultRoute\MatchRules;


use Royalcms\Component\DefaultRoute\RouteMatchInterface;

/**
 * Class PathInfoMatch
 * @package Royalcms\Component\DefaultRoute\MatchRules
 */
class PathInfoMatch implements RouteMatchInterface
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
     * path_info 路由支持
     * index.php/admin/index/init
     */
    public function handle()
    {
        if (($route = ltrim($this->route->getRequest()->getPathInfo(), '/')) !== false) {

            $moduleName     = config('route.module', 'm');
            $controllerName = config('route.controller', 'c');
            $actionName     = config('route.action', 'a');

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