<?php

namespace Royalcms\Component\Support\Facades;

use Royalcms\Component\Support\Traits\Macroable;

/**
 * @see \Royalcms\Component\Contracts\Routing\ResponseFactory
 */
class Response extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Royalcms\Component\Contracts\Routing\ResponseFactory';
    }
}
