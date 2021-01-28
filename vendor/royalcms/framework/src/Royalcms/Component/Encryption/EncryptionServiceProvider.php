<?php

namespace Royalcms\Component\Encryption;

use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Str;
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

            // If the key starts with "base64:", we will need to decode the key before handing
            // it off to the encrypter. Keys may be base-64 encoded for presentation and we
            // want to make sure to convert them back to the raw bytes before encrypting.
            if (Str::startsWith($key = $this->key($config), 'base64:')) {
                $key = base64_decode(substr($key, 7));
            }

            return new Encrypter($key, $config['cipher']);
        });
    }

    /**
     * Extract the encryption key from the given configuration.
     *
     * @param  array  $config
     * @return string
     *
     * @throws \RuntimeException
     */
    protected function key(array $config)
    {
        return tap($config['auth_key'], function ($key) {
            if (empty($key)) {
                throw new RuntimeException(
                    'No application encryption key has been specified.'
                );
            }
        });
    }
}
