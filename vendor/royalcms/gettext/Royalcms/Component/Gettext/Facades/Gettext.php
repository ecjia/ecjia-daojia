<?php 

namespace Royalcms\Component\Gettext\Facades;

use Royalcms\Component\Support\Facades\Facade;

class Gettext extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'gettext';
    }

}