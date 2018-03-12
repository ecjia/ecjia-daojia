<?php 

namespace Royalcms\Component\Tcpdf\Facades;

use Royalcms\Component\Support\Facades\Facade;

class Tcpdf extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'tcpdf';
    }

}

// end