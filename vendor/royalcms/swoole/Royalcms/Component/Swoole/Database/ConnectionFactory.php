<?php

namespace Royalcms\Component\Database;

use Royalcms\Component\Database\Connectors\CoroutineMySQLConnector;
use Royalcms\Component\Database\Connectors\ConnectionFactory as RoyalcmsConnectionFactory;

class ConnectionFactory extends RoyalcmsConnectionFactory
{
    public function createConnector(array $config)
    {
        if (!isset($config['driver'])) {
            throw new \InvalidArgumentException('A driver must be specified.');
        }

        switch ($config['driver']) {
            case 'sw-co-mysql':
                return new CoroutineMySQLConnector();
        }
        return parent::createConnector($config);
    }

    protected function createConnection($driver, $connection, $database, $prefix = '', array $config = [])
    {
        switch ($driver) {
            case 'sw-co-mysql':
                return new CoroutineMySQLConnection($connection, $database, $prefix, $config);
        }
        return parent::createConnection($driver, $connection, $database, $prefix, $config);
    }
}