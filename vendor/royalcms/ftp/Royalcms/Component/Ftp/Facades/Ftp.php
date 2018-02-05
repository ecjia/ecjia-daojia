<?php 

namespace Royalcms\Component\Ftp\Facades;

use Royalcms\Component\Support\Facades\Facade;

class Ftp extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'ftp'; }

}