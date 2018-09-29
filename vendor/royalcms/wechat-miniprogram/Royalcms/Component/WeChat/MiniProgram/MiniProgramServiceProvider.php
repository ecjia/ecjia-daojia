<?php

namespace Royalcms\Component\WeChat\MiniProgram;

use Royalcms\Component\Support\ServiceProvider;

/**
 * Class MiniProgramServiceProvider.
 */
class MiniProgramServiceProvider extends ServiceProvider
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
        
        $wechat->bindShared('weapp', function($wechat)
        {
            return new MiniProgram($wechat);
        });
        
        
    }
}
