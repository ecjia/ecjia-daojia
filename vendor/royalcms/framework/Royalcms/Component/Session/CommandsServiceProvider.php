<?php namespace Royalcms\Component\Session;

use Royalcms\Component\Support\ServiceProvider;

class CommandsServiceProvider extends ServiceProvider {

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
		$this->royalcms->bindShared('command.session.database', function($royalcms)
		{
			return new Console\SessionTableCommand($royalcms['files']); 
		});

		$this->commands('command.session.database');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('command.session.database');
	}

}
