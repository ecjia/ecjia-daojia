<?php

namespace Royalcms\Component\WeChat\Server;

use Royalcms\Component\WeChat\Encryption\Encryptor;
use Royalcms\Component\Support\ServiceProvider;

/**
 * Class ServerServiceProvider.
 */
class ServerServiceProvider extends ServiceProvider
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
        
        $wechat->bindShared('encryptor', function($wechat)
        {
            return new Encryptor(
                $wechat['config']['app_id'],
                $wechat['config']['token'],
                $wechat['config']['aes_key']
            );
        });
        
        $wechat->bindShared('server', function($wechat)
        {
            $server = new Guard($wechat['config']['token']);

            $server->debug($wechat['config']['debug']);

            $server->setEncryptor($wechat['encryptor']);

            return $server;
        });
    }
}
