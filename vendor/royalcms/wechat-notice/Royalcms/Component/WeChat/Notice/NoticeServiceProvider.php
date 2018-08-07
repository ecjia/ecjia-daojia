<?php

namespace Royalcms\Component\WeChat\Notice;

use Royalcms\Component\Support\ServiceProvider;

/**
 * Class NoticeServiceProvider.
 */
class NoticeServiceProvider extends ServiceProvider
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
        
        $wechat->bindShared('notice', function($wechat)
        {
            return new Notice($wechat['access_token']);
        });
    }
}
