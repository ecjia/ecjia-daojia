<?php namespace Royalcms\Component\Variable;

use Royalcms\Component\Support\ServiceProvider;

class VariableServiceProvider extends ServiceProvider {

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
		$this->royalcms->bindShared('variable', function($royalcms)
		{
			return new Variable;
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('variable');
	}

}
