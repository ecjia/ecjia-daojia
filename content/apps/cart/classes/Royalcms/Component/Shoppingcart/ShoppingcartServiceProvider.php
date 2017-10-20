<?php

namespace Royalcms\Component\Shoppingcart;

use Royalcms\Component\Support\ServiceProvider;

class ShoppingcartServiceProvider extends ServiceProvider
{
    
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot() {
        $this->package('royalcms/shoppingcart');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->royalcms->bind('cart', function($royalcms) {
        	return new Cart;
        });
        
    }
    
}
