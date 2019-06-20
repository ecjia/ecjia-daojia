<?php
namespace Royalcms\Component\ShoppingCart\Facades;

use Royalcms\Component\Support\Facades\Facade;

class Cart extends Facade {
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'cart';
    }
}
