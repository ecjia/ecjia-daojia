<?php

namespace Royalcms\Component\Queue\Connectors;

use Royalcms\Component\Support\Arr;
use Royalcms\Component\Queue\DatabaseQueue;
use Royalcms\Component\Database\ConnectionResolverInterface;

class DatabaseConnector implements ConnectorInterface
{
    /**
     * Database connections.
     *
     * @var \Royalcms\Component\Database\ConnectionResolverInterface
     */
    protected $connections;

    /**
     * Create a new connector instance.
     *
     * @param  \Royalcms\Component\Database\ConnectionResolverInterface  $connections
     * @return void
     */
    public function __construct(ConnectionResolverInterface $connections)
    {
        $this->connections = $connections;
    }

    /**
     * Establish a queue connection.
     *
     * @param  array  $config
     * @return \Royalcms\Component\Contracts\Queue\Queue
     */
    public function connect(array $config)
    {
        return new DatabaseQueue(
            $this->connections->connection(Arr::get($config, 'connection')),
            $config['table'],
            $config['queue'],
            Arr::get($config, 'expire', 60)
        );
    }
}
