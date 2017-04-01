<?php namespace Royalcms\Component\Foundation\Providers;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Foundation\Console\TinkerCommand;

class TinkerServiceProvider extends ServiceProvider {

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
		$this->royalcms->bindShared('command.tinker', function()
		{
			return new TinkerCommand;
		});

		$this->commands('command.tinker');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('command.tinker');
	}

}
