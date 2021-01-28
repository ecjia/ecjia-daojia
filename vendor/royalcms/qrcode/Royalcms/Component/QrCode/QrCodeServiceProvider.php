<?php namespace Royalcms\Component\QrCode;

/**
 * Simple QrCode Generator
 * A simple wrapper for the popular BaconQrCode made for Royalcms.
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
        
        // Load the alias
        $this->loadAlias();
	}
	
	/**
	 * Load the alias = One less install step for the user
	 */
	protected function loadAlias()
	{
	    $this->royalcms->booting(function()
	    {
	        $loader = \Royalcms\Component\Foundation\AliasLoader::getInstance();
	        $loader->alias('RC_QrCode', 'Royalcms\Component\QrCode\Facades\QrCode');
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
