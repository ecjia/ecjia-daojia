<?php

namespace Royalcms\Component\WeChat\Js;

use Royalcms\Component\Support\ServiceProvider;

/**
 * Class JsServiceProvider.
 */
class JsServiceProvider extends ServiceProvider
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
        
        $wechat->bindShared('js', function($wechat)
        {
            $js = new Js($wechat['access_token']);
            $js->setCache($wechat['cache']);

            return $js;
        });
    }
}
