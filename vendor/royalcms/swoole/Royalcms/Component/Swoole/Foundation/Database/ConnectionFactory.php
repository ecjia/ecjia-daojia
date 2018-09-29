<?php

namespace Royalcms\Component\Swoole\Foundation\Database;

use Royalcms\Component\Database\Connection;
use Royalcms\Component\Swoole\Foundation\Database\Connectors\CoroutineMySQLConnector;
use Royalcms\Component\Database\Connectors\ConnectionFactory as RoyalcmsConnectionFactory;

class ConnectionFactory extends RoyalcmsConnectionFactory
{
    public function createConnector(array $config)
    {
        if (!isset($config['driver'])) {
            throw new \InvalidArgumentException('A driver must be specified.');
        }

        if ($this->container->bound($key = "db.connector.{$config['driver']}")) {
            return $this->container->make($key);
        }

        switch ($config['driver']) {
            case 'sw-co-mysql':
                return new CoroutineMySQLConnector();
        }
        return parent::createConnector($config);
    }

    protected function createSingleConnection(array $config)
    {
        if (method_exists($this, 'createPdoResolver')) {
            $pdo = $this->createPdoResolver($config);
        } else {
            $pdo = $this->createConnector($config)->connect($config);
        }
        return $this->createSwooleConnection($config['driver'], $pdo, $config['database'], $config['prefix'], $config);
    }

    protected function createSwooleConnection($driver, $connection, $database, $prefix = '', array $config = [])
    {
        if (method_exists(Connection::class, 'getResolver')) {
            if ($resolver = Connection::getResolver($driver)) {
                return $resolver($connection, $database, $prefix, $config);
            }
        } else {
            if ($this->container->bound($key = "db.connection.{$driver}")) {
                return $this->container->make($key, [$connection, $database, $prefix, $config]);
            }
        }

        switch ($driver) {
            case 'sw-co-mysql':
                return new SwooleMySQLConnection($connection, $database, $prefix, $config);
        }
        return parent::createConnection($driver, $connection, $database, $prefix, $config);
    }
}