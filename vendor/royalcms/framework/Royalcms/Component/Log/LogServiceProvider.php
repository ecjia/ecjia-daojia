<?php namespace Royalcms\Component\Log;

use Monolog\Logger;
use Royalcms\Component\Support\ServiceProvider;

class LogServiceProvider extends ServiceProvider {

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
		$logger = new Writer(
			new Logger($this->royalcms['env']), $this->royalcms['events']
		);

		$this->royalcms->instance('log', $logger);
		
		$store = new FileStore(
		    $this->royalcms['files'], storage_path().'/logs/'
		);
		
		$this->royalcms->instance('log.store', $store);

		// If the setup Closure has been bound in the container, we will resolve it
		// and pass in the logger instance. This allows this to defer all of the
		// logger class setup until the last possible second, improving speed.
		if (isset($this->royalcms['log.setup']))
		{
			call_user_func($this->royalcms['log.setup'], $logger);
		}
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('log', 'log.store');
	}

}
