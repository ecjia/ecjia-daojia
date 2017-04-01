<?php namespace Royalcms\Component\Foundation\Providers;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Foundation\Console\UpCommand;
use Royalcms\Component\Foundation\Console\DownCommand;

class MaintenanceServiceProvider extends ServiceProvider {

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
		$this->royalcms->bindShared('command.up', function($royalcms)
		{
			return new UpCommand;
		});

		$this->royalcms->bindShared('command.down', function($royalcms)
		{
			return new DownCommand;
		});

		$this->commands('command.up', 'command.down');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('command.up', 'command.down');
	}

}
