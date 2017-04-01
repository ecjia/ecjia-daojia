<?php namespace Royalcms\Component\Memcache\Facades;

use Royalcms\Component\Support\Facades\Facade;

class Memcache extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'memcache';
    }
    
}