<?php

namespace Royalcms\Component\Support\Facades;

/**
 * @method static \Illuminate\Database\Schema\Builder create(string $table, \Closure $callback)
 * @method static \Illuminate\Database\Schema\Builder drop(string $table)
 * @method static \Illuminate\Database\Schema\Builder dropIfExists(string $table)
 * @method static \Illuminate\Database\Schema\Builder table(string $table, \Closure $callback)
 * @method static \Illuminate\Database\Schema\Builder rename(string $from, string $to)
 * @method static void defaultStringLength(int $length)
 * @method static bool hasTable(string $table)
 * @method static bool hasColumn(string $table, string $column)
 * @method static bool hasColumns(string $table, array $columns)
 * @method static \Illuminate\Database\Schema\Builder disableForeignKeyConstraints()
 * @method static \Illuminate\Database\Schema\Builder enableForeignKeyConstraints()
 * @method static void registerCustomDoctrineType(string $class, string $name, string $type)
 * 
 * @see \Royalcms\Component\Database\Schema\Builder
 */
class Schema extends Facade
{
    /**
     * Get a schema builder instance for a connection.
     *
     * @param  string  $name
     * @return \Royalcms\Component\Database\Schema\MySqlBuilder
     */
    public static function connection($name)
    {
        return static::$royalcms['db']->connection($name)->getSchemaBuilder();
    }

    /**
     * Get a schema builder instance for the default connection.
     *
     * @return \Royalcms\Component\Database\Schema\MySqlBuilder
     */
    protected static function getFacadeAccessor()
    {
        return static::$royalcms['db']->connection()->getSchemaBuilder();
    }
}
