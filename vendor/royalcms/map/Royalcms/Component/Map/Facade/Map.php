<?php

namespace Royalcms\Component\Map\Facade;

use Royalcms\Component\Support\Facades\Facade;

class Map extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'map';
    }
}