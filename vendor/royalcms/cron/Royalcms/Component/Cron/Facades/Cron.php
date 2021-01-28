<?php

namespace Royalcms\Component\Cron\Facades;

use Royalcms\Component\Support\Facades\Facade;

/**
 * Class Cron
 * @package Royalcms\Component\Cron\Facades
 */
class Cron extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'cron';
    }

}