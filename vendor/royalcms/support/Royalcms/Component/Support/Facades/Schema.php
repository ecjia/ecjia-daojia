<?php

namespace Royalcms\Component\Support\Facades;

/**
 * @see \Royalcms\Component\Database\Schema\Builder
 */
class Schema extends Facade
{
    /**
     * Get a schema builder instance for a connection.
     *
     * @param  string  $name
     * @return \Royalcms\Component\Database\Schema\Builder
     */
    public static function connection($name)
    {
        return static::$royalcms['db']->connection($name)->getSchemaBuilder();
    }

    /**
     * Get a schema builder instance for the default connection.
     *
     * @return \Royalcms\Component\Database\Schema\Builder
     */
    protected static function getFacadeAccessor()
    {
        return static::$royalcms['db']->connection()->getSchemaBuilder();
    }
}
