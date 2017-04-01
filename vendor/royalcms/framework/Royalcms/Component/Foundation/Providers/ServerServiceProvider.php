<?php namespace Royalcms\Component\Foundation\Providers;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Foundation\Console\ServeCommand;

class ServerServiceProvider extends ServiceProvider {

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
		$this->royalcms->bindShared('command.serve', function()
		{
			return new ServeCommand;
		});

		$this->commands('command.serve');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('command.serve');
	}

}
