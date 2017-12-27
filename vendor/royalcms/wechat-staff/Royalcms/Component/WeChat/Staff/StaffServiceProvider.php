<?php

namespace Royalcms\Component\WeChat\Staff;

use Royalcms\Component\Support\ServiceProvider;

/**
 * Class StaffServiceProvider.
 */
class StaffServiceProvider extends ServiceProvider
{
    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $wechat A container instance
     */
    public function register()
    {
        $wechat = $this->royalcms['wechat'];
        
        $wechat->bindShared('staff', function($wechat)
        {
            return new Staff($wechat['access_token']);
        });
        
        $wechat->bindShared('staff_session', function($wechat)
        {
            return new Session($wechat['access_token']);
        });
    }
}
