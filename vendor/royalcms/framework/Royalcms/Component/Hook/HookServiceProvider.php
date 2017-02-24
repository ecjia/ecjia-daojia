<?php namespace Royalcms\Component\Hook;

use Royalcms\Component\Support\ServiceProvider;

class HookServiceProvider extends ServiceProvider {
    
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
		$this->registerHooks();
	}

	/**
	 * Register the session manager instance.
	 *
	 * @return void
	 */
	protected function registerHooks()
	{
		$this->royalcms->bindShared('hook', function($royalcms)
		{
			return new Hooks();
		});
	}
	
	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
	    return array('hook');
	}

}
