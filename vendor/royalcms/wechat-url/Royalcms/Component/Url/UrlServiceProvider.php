<?php

namespace Royalcms\Component\WeChat\Url;

use Royalcms\Component\Support\ServiceProvider;

/**
 * Class UrlServiceProvider.
 */
class UrlServiceProvider extends ServiceProvider
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
        
        $wechat->bindShared('url', function($wechat)
        {
            return new Url($wechat['access_token']);
        });
    }
}
