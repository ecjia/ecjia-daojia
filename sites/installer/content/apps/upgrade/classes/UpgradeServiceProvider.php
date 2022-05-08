<?php

namespace Ecjia\App\Upgrade;

use Ecjia\App\Upgrade\Listeners\UpgradeAfterUpdateVersionListener;
use Ecjia\Component\Version\Events\UpgradeAfterEvent;
use RC_Event;
use Royalcms\Component\App\AppParentServiceProvider;

class UpgradeServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-upgrade');

        $this->bootEvent();
    }
    
    public function register()
    {
        
    }

    protected function bootEvent()
    {
        RC_Event::listen(UpgradeAfterEvent::class, UpgradeAfterUpdateVersionListener::class);
    }
    
}