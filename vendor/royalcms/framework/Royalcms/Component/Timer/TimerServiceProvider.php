<?php namespace Royalcms\Component\Timer;

use Royalcms\Component\Support\ServiceProvider;

class TimerServiceProvider extends ServiceProvider
{
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->royalcms->singleton('timer', function()
		{
			// Let's use the Royalcms start time if it is defined.
			$startTime = defined('ROYALCMS_START') ? ROYALCMS_START : null;
			
			return new Timer($startTime);
		});
	}
}
