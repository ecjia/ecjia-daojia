<?php namespace Royalcms\Component\Foundation\Providers;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Foundation\Console\RoutesCommand;

class RouteListServiceProvider extends ServiceProvider {

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
		$this->royalcms->bindShared('command.routes', function($royalcms)
		{
			return new RoutesCommand($royalcms['router']);
		});

		$this->commands('command.routes');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('command.routes');
	}

}
