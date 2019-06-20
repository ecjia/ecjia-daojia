<?php

namespace Royalcms\Component\ShoppingCart;

use Royalcms\Component\Support\ServiceProvider;

class ShoppingCartServiceProvider extends ServiceProvider
{
    
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot() {
        $this->package('royalcms/shopping-cart');
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
