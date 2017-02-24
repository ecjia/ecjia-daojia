<?php namespace Royalcms\Component\Foundation\Bootstrap;

use Royalcms\Component\Config\Dotenv;
use InvalidArgumentException;
use Royalcms\Component\Foundation\Contracts\Royalcms;

class DetectEnvironment {

	/**
	 * Bootstrap the given application.
	 *
	 * @param  \Royalcms\Component\Foundation\Contracts\Royalcms  $royalcms
	 * @return void
	 */
	public function bootstrap(Royalcms $royalcms)
	{
		try
		{
			Dotenv::load($royalcms->basePath(), $royalcms->environmentFile());
		}
		catch (InvalidArgumentException $e)
		{
			//
		}

		$royalcms->detectEnvironment(function()
		{
			return env('ROYALCMS_ENV', 'production');
		});
	}

}
