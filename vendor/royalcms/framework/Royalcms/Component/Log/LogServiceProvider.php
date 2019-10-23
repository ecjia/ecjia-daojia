<?php

namespace Royalcms\Component\Log;

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
		$this->royalcms->bind('log.store', function($royalcms) {
		    return new FileStore(
                $royalcms['files'], storage_path().'/logs/'
            );
        });

		// If the setup Closure has been bound in the container, we will resolve it
		// and pass in the logger instance. This allows this to defer all of the
		// logger class setup until the last possible second, improving speed.
		if (isset($this->royalcms['log.setup']))
		{
			call_user_func($this->royalcms['log.setup'], $this->royalcms['log']);
		}
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('log.store');
	}

}
