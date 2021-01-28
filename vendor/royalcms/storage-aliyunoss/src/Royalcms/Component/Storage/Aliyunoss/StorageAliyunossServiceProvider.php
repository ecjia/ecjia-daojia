<?php

namespace Royalcms\Component\Storage\Aliyunoss;

use Illuminate\Contracts\Support\DeferrableProvider;
use Royalcms\Component\Storage\StorageServiceProvider;
use Royalcms\Component\Support\ServiceProvider;

class StorageAliyunossServiceProvider extends ServiceProvider implements DeferrableProvider
{
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        /**
         * Create an instance of the Aliyun oss driver.
         *
         * @param  array  $config
         * @return \Royalcms\Component\Contracts\Filesystem\Filesystem
         */
        $this->royalcms['storage']->extend('aliyunoss', function ($royalcms, array $config) {
            $ossConfig = array_only($config, array('key', 'secret', 'bucket', 'server', 'server_internal', 'is_internal', 'url'));

            return $royalcms['storage']->adapt(
                $royalcms['storage']->createFilesystem(
                    new Aliyunoss($ossConfig),
                    $ossConfig
                )
            );
        });

	}

    /**
     * Get the events that trigger this service provider to register.
     *
     * @return array
     */
    public function when()
    {
        return [StorageServiceProvider::class];
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

}
