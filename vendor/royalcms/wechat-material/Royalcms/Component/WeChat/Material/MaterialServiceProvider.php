<?php

namespace Royalcms\Component\WeChat\Material;

use Royalcms\Component\Support\ServiceProvider;

/**
 * Class MaterialServiceProvider.
 */
class MaterialServiceProvider extends ServiceProvider
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
        
        $wechat->bindShared('material', function($wechat)
        {
            return new Material($wechat['access_token']);
        });
        
        $wechat->bindShared('material_temporary', function($wechat)
        {
            return new Temporary($wechat['access_token']);
        });
    }
}
