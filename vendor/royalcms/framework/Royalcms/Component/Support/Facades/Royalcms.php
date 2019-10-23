<?php

namespace Royalcms\Component\Support\Facades;

/**
 * @see \Royalcms\Component\Foundation\Royalcms
 */
class Royalcms extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'royalcms';
    }
}
