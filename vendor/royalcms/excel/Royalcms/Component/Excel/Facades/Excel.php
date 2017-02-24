<?php namespace Royalcms\Component\Excel\Facades;

use Royalcms\Component\Support\Facades\Facade;

/**
 *
 * Royalcms Excel Facade
 *
 */
class Excel extends Facade {

    /**
     * Return facade accessor
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'excel';
    }
}