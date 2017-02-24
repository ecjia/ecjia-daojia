<?php namespace Royalcms\Component\Foundation\Providers;

use Royalcms\Component\Foundation\Royalcmd;
use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Foundation\Console\TailCommand;
use Royalcms\Component\Foundation\Console\ChangesCommand;
use Royalcms\Component\Foundation\Console\EnvironmentCommand;

class RoyalcmdServiceProvider extends ServiceProvider {

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
		$this->royalcms->bindShared('royalcmd', function($royalcms)
		{
			return new Royalcmd($royalcms);
		});

		$this->royalcms->bindShared('command.tail', function($royalcms)
		{
			return new TailCommand;
		});

		$this->royalcms->bindShared('command.changes', function($royalcms)
		{
			return new ChangesCommand;
		});

		$this->royalcms->bindShared('command.environment', function($royalcms)
		{
			return new EnvironmentCommand;
		});

		$this->commands('command.tail', 'command.changes', 'command.environment');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('royalcmd', 'command.changes', 'command.environment');
	}

}
