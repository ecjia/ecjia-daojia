<?php

namespace Royalcms\Component\Queue\Connectors;

use Royalcms\Component\Support\Arr;
use Royalcms\Component\Redis\Database;
use Royalcms\Component\Queue\RedisQueue;

class RedisConnector implements ConnectorInterface
{
    /**
     * The Redis database instance.
     *
     * @var \Royalcms\Component\Redis\Database
     */
    protected $redis;

    /**
     * The connection name.
     *
     * @var string
     */
    protected $connection;

    /**
     * Create a new Redis queue connector instance.
     *
     * @param  \Royalcms\Component\Redis\Database  $redis
     * @param  string|null  $connection
     * @return void
     */
    public function __construct(Database $redis, $connection = null)
    {
        $this->redis = $redis;
        $this->connection = $connection;
    }

    /**
     * Establish a queue connection.
     *
     * @param  array  $config
     * @return \Royalcms\Component\Contracts\Queue\Queue
     */
    public function connect(array $config)
    {
        $queue = new RedisQueue(
            $this->redis, $config['queue'], Arr::get($config, 'connection', $this->connection)
        );

        $queue->setExpire(Arr::get($config, 'expire', 60));

        return $queue;
    }
}
