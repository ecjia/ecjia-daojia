<?php namespace Royalcms\Component\Foundation\Bootstrap;

use Royalcms\Component\HttpKernel\Request;
use Royalcms\Component\Foundation\Contracts\Royalcms;

class SetRequestForConsole {

	/**
	 * Bootstrap the given application.
	 *
	 * @param  \Royalcms\Component\Foundation\Contracts\Royalcms  $royalcms
	 * @return void
	 */
	public function bootstrap(Royalcms $royalcms)
	{
		$url = $royalcms['config']->get('app.url', 'http://localhost');

		$royalcms->instance('request', Request::create($url, 'GET', [], [], [], $_SERVER));
	}

}
