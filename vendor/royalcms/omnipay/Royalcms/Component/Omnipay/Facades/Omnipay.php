<?php 

namespace Royalcms\Component\Omnipay\Facades;

use Royalcms\Component\Support\Facades\Facade;

class Omnipay extends Facade {

    protected static function getFacadeAccessor() { 
        return 'omnipay'; 
    }

}