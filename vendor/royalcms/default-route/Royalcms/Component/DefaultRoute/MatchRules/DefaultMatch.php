<?php

namespace Royalcms\Component\DefaultRoute\MatchRules;


use Royalcms\Component\DefaultRoute\RouteMatchInterface;

/**
 * Class DefaultMatch
 * @package Royalcms\Component\DefaultRoute\MatchRules
 */
class DefaultMatch implements RouteMatchInterface
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
     * 默认route.php配置路由支持
     * index.php?m=admincp&c=index&a=init
     */
    public function handle()
    {
        $moduleName     = config('route.module', 'm');
        $controllerName = config('route.controller', 'c');
        $actionName     = config('route.action', 'a');

        $module = $this->route->matchDefaultRoute($moduleName);
        $controller = $this->route->matchDefaultRoute($controllerName);
        $action = $this->route->matchDefaultRoute($actionName);

        $this->route->setModule($module);
        $this->route->setController($controller);
        $this->route->setAction($action);

        return true;
    }
}