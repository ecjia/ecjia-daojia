<?php

namespace Royalcms\Component\WeChat\User;

use Royalcms\Component\WeChat\User\MiniAppUser;
use Royalcms\Component\Support\ServiceProvider;

/**
 * Class MiniAppUserServiceProvider.
 */
class MiniAppUserServiceProvider extends ServiceProvider
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
        
        $wechat->bindShared('mini_app_user', function($wechat)
        {
            return new MiniAppUser($wechat['config']);
        });
    }
}
