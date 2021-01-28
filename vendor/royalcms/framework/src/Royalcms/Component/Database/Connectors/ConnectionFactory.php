<?php

namespace Royalcms\Component\Database\Connectors;


use InvalidArgumentException;
use Illuminate\Database\Connection;
use Illuminate\Database\SQLiteConnection;
use Illuminate\Database\PostgresConnection;
use Illuminate\Database\SqlServerConnection;
use Illuminate\Database\Connectors\ConnectionFactory as LaravelConnectionFactory;
use Royalcms\Component\Database\MySqlConnection;

class ConnectionFactory extends LaravelConnectionFactory
{

    /**
     * Create a new connection instance.
     *
     * @param  string   $driver
     * @param  \PDO|\Closure     $connection
     * @param  string   $database
     * @param  string   $prefix
     * @param  array    $config
     * @return \Illuminate\Database\Connection
     *
     * @throws \InvalidArgumentException
     */
    protected function createConnection($driver, $connection, $database, $prefix = '', array $config = [])
    {
        if ($resolver = Connection::getResolver($driver)) {
            return $resolver($connection, $database, $prefix, $config);
        }

        switch ($driver) {
            case 'mysql':
                return new MySqlConnection($connection, $database, $prefix, $config);
            case 'pgsql':
                return new PostgresConnection($connection, $database, $prefix, $config);
            case 'sqlite':
                return new SQLiteConnection($connection, $database, $prefix, $config);
            case 'sqlsrv':
                return new SqlServerConnection($connection, $database, $prefix, $config);
        }

        throw new InvalidArgumentException("Unsupported driver [{$driver}]");
    }
}
