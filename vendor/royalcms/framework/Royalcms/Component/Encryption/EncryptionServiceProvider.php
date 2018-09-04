<?php

namespace Royalcms\Component\Encryption;

use RuntimeException;
use Royalcms\Component\Support\ServiceProvider;

class EncryptionServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->royalcms->singleton('encrypter', function ($royalcms) {
            $config = $royalcms->make('config')->get('system');

            $key = $config['auth_key'];

            $cipher = $config['cipher'];

            if (Encrypter::supported($key, $cipher)) {
                return new Encrypter($key, $cipher);
            } elseif (McryptEncrypter::supported($key, $cipher)) {
                return new McryptEncrypter($key, $cipher);
            } else {
                throw new RuntimeException('No supported encrypter found. The cipher and / or key length are invalid.');
            }
        });
    }
}
