<?php namespace Royalcms\Component\Event;

use Royalcms\Component\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->royalcms['events'] = $this->royalcms->share(function($royalcms)
		{
			return new Dispatcher($royalcms);
		});
	}

}
