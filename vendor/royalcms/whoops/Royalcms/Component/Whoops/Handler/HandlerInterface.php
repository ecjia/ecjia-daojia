<?php namespace Royalcms\Component\Whoops\Handler;

use Royalcms\Component\Whoops\Exception\Inspector;
use Royalcms\Component\Whoops\Run;
use Exception;

interface HandlerInterface
{
    /**
     * @return int|null  A handler may return nothing, or a Handler::HANDLE_* constant
     */
    public function handle();

    /**
     * @param Run $run
     */
    public function setRun(Run $run);

    /**
     * @param Exception $exception
     */
    public function setException(Exception $exception);

    /**
     * @param Inspector $inspector
     */
    public function setInspector(Inspector $inspector);
}
