<?php

namespace Royalcms\Component\Support\Facades;

use Royalcms\Component\Filesystem\FileHelperTrait;

/**
 * @see \Royalcms\Component\Filesystem\Filesystem
 */
class File extends Facade
{
    use FileHelperTrait;

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'files';
    }
}
