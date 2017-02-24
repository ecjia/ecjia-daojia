<?php namespace Royalcms\Component\Foundation\Bootstrap;

use Royalcms\Component\Support\Facades\Facade;
use Royalcms\Component\Foundation\AliasLoader;
use Royalcms\Component\Foundation\Contracts\Royalcms;

class RegisterFacades {

	/**
	 * Bootstrap the given application.
	 *
	 * @param  \Royalcms\Component\Foundation\Contracts\Royalcms  $royalcms
	 * @return void
	 */
	public function bootstrap(Royalcms $royalcms)
	{
		Facade::clearResolvedInstances();

		Facade::setFacadeRoyalcms($royalcms);

		AliasLoader::getInstance($royalcms['config']['system.aliases'])->register();
	}

}
