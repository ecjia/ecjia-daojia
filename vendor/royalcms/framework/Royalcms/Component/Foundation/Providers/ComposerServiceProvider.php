<?php namespace Royalcms\Component\Foundation\Providers;

use Royalcms\Component\Foundation\Composer;
use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Foundation\Console\AutoloadCommand;

class ComposerServiceProvider extends ServiceProvider {

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
		$this->royalcms->bindShared('composer', function($royalcms)
		{
			return new Composer($royalcms['files'], $royalcms['path.base']);
		});

		$this->royalcms->bindShared('command.dump-autoload', function($royalcms)
		{
			return new AutoloadCommand($royalcms['composer']);
		});

		$this->commands('command.dump-autoload');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('composer', 'command.dump-autoload');
	}

}
