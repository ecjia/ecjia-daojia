<?php namespace Royalcms\Component\LogViewer;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Foundation\Royalcms;

class LogViewerServiceProvider extends ServiceProvider {

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
		$this->royalcms->singleton('log.viewer', function (Royalcms $royalcms) {
            return new LogViewer();
        });
		
	    $this->royalcms->alias('log.viewer', 'Royalcms\Component\LogViewer\LogViewer');
		
	    // Load the alias
	    $this->loadAlias();
	}
	
	/**
	 * Load the alias = One less install step for the user
	 * @todo This setting is not available when using deferred
	 */
	protected function loadAlias()
	{
	    $this->royalcms->booting(function()
	    {
	        $loader = \Royalcms\Component\Foundation\AliasLoader::getInstance();
	        $loader->alias('RC_LogViewer', 'Royalcms\Component\LogViewer\Facades\LogViewer');
	    });
	}
	
	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
	    return array('log.viewer');
	}

}
