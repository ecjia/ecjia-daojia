<?php namespace Royalcms\Component\Encryption;

use Royalcms\Component\Support\ServiceProvider;

class EncryptionServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->royalcms->bindShared('encrypter', function($royalcms)
		{
			return new Encrypter($royalcms['config']['system.auth_key']);
		});
	}

}
