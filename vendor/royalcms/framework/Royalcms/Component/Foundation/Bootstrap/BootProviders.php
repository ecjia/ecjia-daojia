<?php namespace Royalcms\Component\Foundation\Bootstrap;

use Royalcms\Component\Foundation\Contracts\Royalcms;

class BootProviders {

	/**
	 * Bootstrap the given application.
	 *
	 * @param  \Royalcms\Component\Foundation\Contracts\Royalcms  $royalcms
	 * @return void
	 */
	public function bootstrap(Royalcms $royalcms)
	{
		$royalcms->boot();
	}

}
