<?php

namespace Royalcms\Component\WeChat\QrCode;

use Royalcms\Component\Support\ServiceProvider;

/**
 * Class QrCodeServiceProvider.
 */
class QrCodeServiceProvider extends ServiceProvider
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
        
        $wechat->bindShared('qrcode', function($wechat)
        {
            return new QrCode($wechat['access_token']);
        });
    }
}
