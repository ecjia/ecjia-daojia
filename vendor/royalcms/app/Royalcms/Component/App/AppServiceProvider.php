<?php

namespace Royalcms\Component\App;

use Royalcms\Component\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        
        $this->royalcms['app'] = $this->royalcms->share(function($royalcms)
        {
            return new AppManager($royalcms);
        });
        
    }
    
    
}
