<?php

namespace Ecjia\Component\Notification;

use Royalcms\Component\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{

    public function boot()
    {

    }

    public function register()
    {
        $this->registerNotifiableTypeManager();
    }

    /**
     * 注册
     */
    protected function registerNotifiableTypeManager()
    {
        $this->royalcms->singleton('ecjia.notification.notifiable_type', function($royalcms) {
            return new NotifiableTypeManager();
        });
    }

}
