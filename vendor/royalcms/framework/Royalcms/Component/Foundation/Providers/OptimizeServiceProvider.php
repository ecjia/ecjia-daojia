<?php namespace Royalcms\Component\Foundation\Providers;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Foundation\Console\OptimizeCommand;
use Royalcms\Component\Foundation\Console\ClearCompiledCommand;

class OptimizeServiceProvider extends ServiceProvider {

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
		$this->registerOptimizeCommand();

		$this->registerClearCompiledCommand();

		$this->commands('command.optimize', 'command.clear-compiled');
	}

	/**
	 * Register the optimize command.
	 *
	 * @return void
	 */
	protected function registerOptimizeCommand()
	{
		$this->royalcms->bindShared('command.optimize', function($royalcms)
		{
			return new OptimizeCommand($royalcms['composer']);
		});
	}

	/**
	 * Register the compiled file remover command.
	 *
	 * @return void
	 */
	protected function registerClearCompiledCommand()
	{
		$this->royalcms->bindShared('command.clear-compiled', function()
		{
			return new ClearCompiledCommand;
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('command.optimize', 'command.clear-compiled');
	}

}
