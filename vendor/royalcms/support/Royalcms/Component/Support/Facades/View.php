<?php

namespace Royalcms\Component\Support\Facades;

/**
 * @see \Royalcms\Component\View\Factory
 */
class View extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'view';
    }
}
