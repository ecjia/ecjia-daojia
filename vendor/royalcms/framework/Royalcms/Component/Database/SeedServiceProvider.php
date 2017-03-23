<?php namespace Royalcms\Component\Database;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Database\Console\SeedCommand;

class SeedServiceProvider extends ServiceProvider {

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
		$this->registerSeedCommand();

		$this->royalcms->bindShared('seeder', function($royalcms)
		{
			return new Seeder;
		});

		$this->commands('command.seed');
	}

	/**
	 * Register the seed console command.
	 *
	 * @return void
	 */
	protected function registerSeedCommand()
	{
		$this->royalcms->bindShared('command.seed', function($royalcms)
		{
			return new SeedCommand($royalcms['db']);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('seeder', 'command.seed');
	}

}
