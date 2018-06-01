<?php

namespace Royalcms\Component\Remote;

use Closure;

class MultiConnection implements ConnectionInterface
{
    /**
     * All of the active server connections.
     *
     * @var array
     */
    protected $connections;

    /**
     * The array of connections.
     *
     * @param array $connections
     */
    public function __construct(array $connections)
    {
        $this->connections = $connections;
    }

    /**
     * Define a set of commands as a task.
     *
     * @param string       $task
     * @param string|array $commands
     *
     * @return void
     */
    public function define($task, $commands)
    {
        foreach ($this->connections as $connection) {
            $connection->define($task, $commands);
        }
    }

    /**
     * Run a task against the connection.
     *
     * @param string   $task
     * @param \Closure $callback
     *
     * @return void
     */
    public function task($task, Closure $callback = null)
    {
        foreach ($this->connections as $connection) {
            $connection->task($task, $callback);
        }
    }

    /**
     * Run a set of commands against the connection.
     *
     * @param string|array $commands
     * @param \Closure     $callback
     *
     * @return void
     */
    public function run($commands, Closure $callback = null)
    {
        foreach ($this->connections as $connection) {
            $connection->run($commands, $callback);
        }
    }

    /**
     * Download the contents of a remote file.
     *
     * @param string $remote
     * @param string $local
     *
     * @return void
     */
    public function get($remote, $local)
    {
        foreach ($this->connections as $connection) {
            $connection->get($remote, $local);
        }
    }

    /**
     * Get the contents of a remote file.
     *
     * @param string $remote
     *
     * @return string
     */
    public function getString($remote)
    {
        foreach ($this->connections as $connection) {
            $connection->getString($remote);
        }
    }

    /**
     * Upload a local file to the server.
     *
     * @param string $local
     * @param string $remote
     *
     * @return void
     */
    public function put($local, $remote)
    {
        foreach ($this->connections as $connection) {
            $connection->put($local, $remote);
        }
    }

    /**
     * Upload a string to to the given file on the server.
     *
     * @param string $remote
     * @param string $contents
     *
     * @return void
     */
    public function putString($remote, $contents)
    {
        foreach ($this->connections as $connection) {
            $connection->putString($remote, $contents);
        }
    }

    /**
     * Check whether a given file exists on the server.
     *
     * @param string $remote
     *
     * @return bool
     */
    public function exists($remote)
    {
        foreach ($this->connections as $connection) {
            $connection->exists($remote);
        }
    }

    /**
     * Rename a remote file.
     *
     * @param string $remote
     * @param string $newRemote
     *
     * @return bool
     */
    public function rename($remote, $newRemote)
    {
        foreach ($this->connections as $connection) {
            $connection->rename($remote, $newRemote);
        }
    }

    /**
     * Delete a remote file from the server.
     *
     * @param string $remote
     *
     * @return bool
     */
    public function delete($remote)
    {
        foreach ($this->connections as $connection) {
            $connection->delete($remote);
        }
    }
}
