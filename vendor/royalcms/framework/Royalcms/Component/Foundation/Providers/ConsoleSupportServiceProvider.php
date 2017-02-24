<?php namespace Royalcms\Component\Foundation\Providers;

use Royalcms\Component\Support\ServiceProvider;

class ConsoleSupportServiceProvider extends ServiceProvider {

	/**
	 * The provider class names.
	 *
	 * @var array
	 */
	protected $providers = array(
		'Royalcms\Component\Foundation\Providers\CommandCreatorServiceProvider',
		'Royalcms\Component\Foundation\Providers\ComposerServiceProvider',
		'Royalcms\Component\Foundation\Providers\KeyGeneratorServiceProvider',
		'Royalcms\Component\Foundation\Providers\MaintenanceServiceProvider',
		'Royalcms\Component\Foundation\Providers\OptimizeServiceProvider',
		'Royalcms\Component\Foundation\Providers\RouteListServiceProvider',
		'Royalcms\Component\Foundation\Providers\ServerServiceProvider',
		'Royalcms\Component\Foundation\Providers\TinkerServiceProvider',
	    'Royalcms\Component\Console\ScheduleServiceProvider',
// 		'Royalcms\Component\Queue\FailConsoleServiceProvider',
// 		'Royalcms\Component\Foundation\Providers\PublisherServiceProvider',
	);

	/**
	 * An array of the service provider instances.
	 *
	 * @var array
	 */
	protected $instances = array();

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
		$this->instances = array();

		foreach ($this->providers as $provider)
		{
			$this->instances[] = $this->royalcms->register($provider);
		}
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		$provides = array();

		foreach ($this->providers as $provider)
		{
			$instance = $this->royalcms->resolveProviderClass($provider);

			$provides = array_merge($provides, $instance->provides());
		}

		return $provides;
	}

}
