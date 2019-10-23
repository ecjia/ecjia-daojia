<?php

namespace Royalcms\Component\Support\Facades;

/**
 * @see \Royalcms\Component\Database\DatabaseManager
 * @see \Royalcms\Component\Database\Connection
 */
class DB extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'db';
    }
}
