<?php

namespace Royalcms\Component\Hashids;

use Royalcms\Component\Support\Facades\Facade;

class Hashids extends Facade
{
    /**
     * Get the registered component.
     *
     * @return object
     */
    protected static function getFacadeAccessor()
    {
        return 'hashids';
    }
}