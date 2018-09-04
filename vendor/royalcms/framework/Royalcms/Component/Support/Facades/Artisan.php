<?php

namespace Royalcms\Component\Support\Facades;

/**
 * @see \Royalcms\Component\Contracts\Console\Kernel
 */
class Artisan extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Royalcms\Component\Contracts\Console\Kernel';
    }
}
