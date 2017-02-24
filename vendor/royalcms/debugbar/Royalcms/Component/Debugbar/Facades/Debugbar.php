<?php namespace Royalcms\Component\Debugbar\Facades;

/**
 * @see \Royalcms\Component\Debugbar\RoyalcmsDebugbar
 */
class Debugbar extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'debugbar'; }

}
