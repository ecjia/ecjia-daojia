<?php

namespace Royalcms\Component\Widget\Facades;

use Royalcms\Component\Support\Facades\Facade;

class Widget extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'widget';
    }
    
}

// end