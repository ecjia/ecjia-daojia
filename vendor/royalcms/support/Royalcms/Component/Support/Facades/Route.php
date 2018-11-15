<?php

namespace Royalcms\Component\Support\Facades;

/**
 * @see \Royalcms\Component\Routing\Router
 */
class Route extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'router';
    }

    /**
     * Determine if the current route matches a given name.
     *
     * @param  string  $name
     * @return bool
     */
    public static function is($name)
    {
        return static::$royalcms['router']->currentRouteNamed($name);
    }

    /**
     * Determine if the current route uses a given controller action.
     *
     * @param  string  $action
     * @return bool
     */
    public static function uses($action)
    {
        return static::$royalcms['router']->currentRouteUses($action);
    }
}
