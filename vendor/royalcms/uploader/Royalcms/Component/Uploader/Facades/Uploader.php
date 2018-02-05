<?php

namespace Royalcms\Component\Uploader\Facades;

use Royalcms\Component\Support\Facades\Facade;

/**
 * @see \Royalcms\Component\Uploader\UploaderManager
 * @see \Royalcms\Component\Uploader\Uploader
 */
class Uploader extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'uploader';
    }
}
