<?php

namespace Royalcms\Component\WeChat\Broadcast;

use Royalcms\Component\Support\ServiceProvider;

/**
 * Class BroadcastServiceProvider.
 */
class BroadcastServiceProvider extends ServiceProvider
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
        
        $wechat->bindShared('broadcast', function($wechat)
        {
            return new Broadcast($wechat['access_token']);
        });
    }
}
