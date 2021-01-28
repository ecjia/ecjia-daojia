<?php

namespace Royalcms\Component\Image\Facades;

use Royalcms\Component\Support\Facades\Facade;

class Image extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'image';
    }
}
