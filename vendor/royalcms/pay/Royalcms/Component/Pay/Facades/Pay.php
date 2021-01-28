<?php

namespace Royalcms\Component\Pay\Facades;

use Royalcms\Component\Support\Facades\Facade;

class Pay extends Facade
{
    /**
     * Return the facade accessor.
     *
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return 'pay';
    }
    
}
