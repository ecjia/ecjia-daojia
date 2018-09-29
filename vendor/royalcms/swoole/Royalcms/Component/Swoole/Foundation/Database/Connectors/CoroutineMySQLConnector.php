<?php

namespace Royalcms\Component\Swoole\Foundation\Database\Connectors;

use Royalcms\Component\Support\Arr;
use Royalcms\Component\Database\Connectors\Connector;
use Royalcms\Component\Database\Connectors\ConnectorInterface;
use Royalcms\Component\Swoole\Foundation\Database\SwoolePDO;

class CoroutineMySQLConnector extends Connector implements ConnectorInterface
{
    /**
     * @param string $dsn
     * @param array $config
     * @param array $options
     * @return SwoolePDO
     * @throws \Throwable
     */
    public function createConnection($dsn, array $config, array $options)
    {
        try {
            $mysql = $this->connect($config);
        } catch (\Exception $e) {
            $mysql = $this->tryAgainIfCausedByLostConnectionForCoroutineMySQL($e, $config);
        }

        return $mysql;
    }

    /**
     * @param \Throwable $e
     * @param array $config
     * @return SwoolePDO
     * @throws \Throwable
     */
    protected function tryAgainIfCausedByLostConnectionForCoroutineMySQL($e, array $config)
    {
        if (parent::causedByLostConnection($e) || Str::contains($e->getMessage(), ['is closed', 'is not established'])) {
            return $this->connect($config);
        }
        throw $e;
    }

    /**
     * @param array $config
     * @return SwoolePDO
     */
    public function connect(array $config)
    {
        $connection = new SwoolePDO();
        $connection->connect([
            'host'        => Arr::get($config, 'host', '127.0.0.1'),
            'port'        => Arr::get($config, 'port', 3306),
            'user'        => Arr::get($config, 'username', ''),
            'password'    => Arr::get($config, 'password', ''),
            'database'    => Arr::get($config, 'database', ''),
            'timeout'     => Arr::get($config, 'timeout', 5),
            'charset'     => Arr::get($config, 'charset', 'utf8mb4'),
            'strict_type' => Arr::get($config, 'strict', false),
        ]);
        if (isset($config['timezone'])) {
            $connection->query('set time_zone="' . $config['timezone'] . '"');
        }
        if (isset($config['strict'])) {
            if ($config['strict']) {
                $connection->query("set session sql_mode='STRICT_ALL_TABLES,ANSI_QUOTES'");
            } else {
                $connection->query("set session sql_mode='ANSI_QUOTES'");
            }
        }
        return $connection;
    }
}