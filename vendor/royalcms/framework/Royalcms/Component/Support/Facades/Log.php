<?php

namespace Royalcms\Component\Support\Facades;

/**
 * @see \Royalcms\Component\Log\Writer
 */
class Log extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'log';
    }
}
