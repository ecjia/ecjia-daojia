<?php

namespace Royalcms\Component\Swoole\Foundation\Database;

use Royalcms\Component\Support\Str;
use Royalcms\Component\Database\QueryException;
use Royalcms\Component\Database\MySqlConnection;

class SwooleMySQLConnection extends MySqlConnection
{
    /**
     * The active swoole mysql connection.
     *
     * @var SwoolePDO
     */
    protected $pdo;

    /**
     * The active swoole mysql used for reads.
     *
     * @var SwoolePDO
     */
    protected $readPdo;

    public function getDriverName()
    {
        return 'Swoole Coroutine MySQL';
    }

    protected function tryAgainIfCausedByLostConnection(QueryException $e, $query, $bindings, \Closure $callback)
    {
        if ($this->causedByLostConnection($e->getPrevious()) || Str::contains($e->getMessage(), ['is closed', 'is not established'])) {
            $this->reconnect();

            return $this->runQueryCallback($query, $bindings, $callback);
        }

        throw $e;
    }
}