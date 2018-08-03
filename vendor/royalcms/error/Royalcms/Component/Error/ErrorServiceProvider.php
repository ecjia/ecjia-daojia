<?php namespace Royalcms\Component\Error;

use Royalcms\Component\Support\ServiceProvider;

class ErrorServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
	    $this->royalcms->bindShared('error', function($royalcms)
	    {
	        return new Error();
	    });
	}

}
