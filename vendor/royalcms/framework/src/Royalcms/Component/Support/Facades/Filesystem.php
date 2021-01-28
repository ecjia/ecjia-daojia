<?php

namespace Royalcms\Component\Support\Facades;

/**
 * @see \Royalcms\Component\Filesystem\FilesystemManager
 */
class Filesystem extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'filesystem';
    }
}
