<?php namespace Royalcms\Component\QrCode;

/**
 * Simple QrCode Generator
 * A simple wrapper for the popular BaconQrCode made for Laravel.
 *
 */

use Royalcms\Component\Support\ServiceProvider;

class QrCodeServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->royalcms->singleton('qrcode', function()
        {
            return new BaconQrCodeGenerator();
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('qrcode');
	}

}
