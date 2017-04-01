<?php namespace Royalcms\Component\Foundation\Providers;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Foundation\Console\CommandMakeCommand;

class CommandCreatorServiceProvider extends ServiceProvider {

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
		$this->royalcms->bindShared('command.command.make', function($royalcms)
		{
			return new CommandMakeCommand($royalcms['files']);
		});

		$this->commands('command.command.make');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array(
			'command.command.make',
		);
	}

}
