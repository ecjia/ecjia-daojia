<?php

namespace Royalcms\Component\Purifier\Facades;

use Royalcms\Component\Support\Facades\Facade;

/**
 * @see \Royalcms\Component\Purifier
 */
class Purifier extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'purifier';
    }
}
