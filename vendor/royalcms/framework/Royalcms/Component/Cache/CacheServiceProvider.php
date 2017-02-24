<?php namespace Royalcms\Component\Cache;

use Royalcms\Component\Support\ServiceProvider;

class CacheServiceProvider extends ServiceProvider {

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
		$this->royalcms->bindShared('cache', function($royalcms)
		{
			return new CacheManager($royalcms);
		});

		$this->royalcms->bindShared('cache.store', function($royalcms)
		{
			return $royalcms['cache']->driver();
		});

		$this->royalcms->bindShared('memcached.connector', function()
		{
			return new MemcachedConnector;
		});

		$this->registerCommands();
	}

	/**
	 * Register the cache related console commands.
	 *
	 * @return void
	 */
	public function registerCommands()
	{
		$this->royalcms->bindShared('command.cache.clear', function($royalcms)
		{
			return new Console\ClearCommand($royalcms['cache'], $royalcms['files']);
		});

		$this->commands('command.cache.clear');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('cache', 'cache.store', 'memcached.connector', 'command.cache.clear');
	}

}
