<?php

namespace Royalcms\Component\Remote;

interface GatewayInterface
{
    /**
     * Connect to the SSH server.
     *
     * @param string $username
     *
     * @return void
     */
    public function connect($username);

    /**
     * Determine if the gateway is connected.
     *
     * @return bool
     */
    public function connected();

    /**
     * Run a command against the server (non-blocking).
     *
     * @param string $command
     *
     * @return void
     */
    public function run($command);

    /**
     * Download the contents of a remote file.
     *
     * @param string $remote
     * @param string $local
     *
     * @return void
     */
    public function get($remote, $local);

    /**
     * Get the contents of a remote file.
     *
     * @param string $remote
     *
     * @return string
     */
    public function getString($remote);

    /**
     * Upload a local file to the server.
     *
     * @param string $local
     * @param string $remote
     *
     * @return void
     */
    public function put($local, $remote);

    /**
     * Upload a string to to the given file on the server.
     *
     * @param string $remote
     * @param string $contents
     *
     * @return void
     */
    public function putString($remote, $contents);

    /**
     * Check whether a given file exists on the server.
     *
     * @param string $remote
     *
     * @return bool
     */
    public function exists($remote);

    /**
     * Rename a remote file.
     *
     * @param string $remote
     * @param string $newRemote
     *
     * @return bool
     */
    public function rename($remote, $newRemote);

    /**
     * Delete a remote file from the server.
     *
     * @param string $remote
     *
     * @return bool
     */
    public function delete($remote);

    /**
     * Get the next line of output from the server.
     *
     * @return string|null
     */
    public function nextLine();

    /**
     * Get the exit status of the last command.
     *
     * @return int|bool
     */
    public function status();
}
