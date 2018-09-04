<?php

namespace Royalcms\Component\Support\Facades;

/**
 * @see \Royalcms\Component\Config\Repository
 */
class Config extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'config';
    }
}
