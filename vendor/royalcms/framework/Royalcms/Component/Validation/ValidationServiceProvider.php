<?php namespace Royalcms\Component\Validation;

use Royalcms\Component\Support\ServiceProvider;

class ValidationServiceProvider extends ServiceProvider {

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
		$this->registerPresenceVerifier();

		$this->royalcms->bindShared('validator', function($royalcms)
		{
			$validator = new Factory($royalcms['translator'], $royalcms);

			// The validation presence verifier is responsible for determining the existence
			// of values in a given data collection, typically a relational database or
			// other persistent data stores. And it is used to check for uniqueness.
			if (isset($royalcms['validation.presence']))
			{
				$validator->setPresenceVerifier($royalcms['validation.presence']);
			}

			return $validator;
		});
	}

	/**
	 * Register the database presence verifier.
	 *
	 * @return void
	 */
	protected function registerPresenceVerifier()
	{
		$this->royalcms->bindShared('validation.presence', function($royalcms)
		{
			return new DatabasePresenceVerifier($royalcms['db']);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('validator', 'validation.presence');
	}

}
