<?php

namespace Royalcms\Component\LogViewer\Facades;

use Royalcms\Component\Support\Facades\Facade;

/**
 * @see \Royalcms\Component\LogViewer\LogViewer
 */
class LogViewer extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'log.viewer';
    }
}
