<?php namespace Royalcms\Component\Routing;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Routing\Console\MakeControllerCommand;
use Royalcms\Component\Routing\Generators\ControllerGenerator;

class ControllerServiceProvider extends ServiceProvider {

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
		$this->registerGenerator();

		$this->commands('command.controller.make');
	}

	/**
	 * Register the controller generator command.
	 *
	 * @return void
	 */
	protected function registerGenerator()
	{
		$this->royalcms->bindShared('command.controller.make', function($royalcms)
		{
			// The controller generator is responsible for building resourceful controllers
			// quickly and easily for the developers via the Artisan CLI. We'll go ahead
			// and register this command instances in this container for registration.
			// @TODO
			$path = $royalcms['path'].'/controllers';

			$generator = new ControllerGenerator($royalcms['files']);

			return new MakeControllerCommand($generator, $path);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array(
			'command.controller.make'
		);
	}

}
