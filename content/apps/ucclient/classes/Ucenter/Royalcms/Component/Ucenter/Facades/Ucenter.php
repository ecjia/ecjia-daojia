<?php 

namespace Royalcms\Component\Ucenter\Facades;

use Royalcms\Component\Support\Facades\Facade;

class Ucenter extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'ucenter';
    }
}
