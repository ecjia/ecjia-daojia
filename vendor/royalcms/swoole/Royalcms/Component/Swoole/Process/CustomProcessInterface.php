<?php

namespace Royalcms\Component\Swoole\Process;

use Swoole\Server;

interface CustomProcessInterface
{
    /**
     * The name of process
     * @return string
     */
    public static function getName();

    /**
     * The run callback of process
     * @param \Swoole\Server $swoole
     * @return void
     */
    public static function callback(Server $swoole);

    /**
     * Whether redirect stdin/stdout
     * @return bool
     */
    public static function isRedirectStdinStdout();

    /**
     * The type of pipeline
     * 0: no pipeline
     * 1: \SOCK_STREAM
     * 2: \SOCK_DGRAM
     * @return int
     */
    public static function getPipeType();
}