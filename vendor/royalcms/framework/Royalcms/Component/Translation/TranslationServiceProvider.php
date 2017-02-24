<?php namespace Royalcms\Component\Translation;

use Royalcms\Component\Support\ServiceProvider;

class TranslationServiceProvider extends ServiceProvider {

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
		$this->registerLoader();

		$this->royalcms->bindShared('translator', function($royalcms)
		{
			$loader = $royalcms['translation.loader'];

			// When registering the translator component, we'll need to set the default
			// locale as well as the fallback locale. So, we'll grab the application
			// configuration so we can easily get both of these values from there.
			$locale = $royalcms['config']['system.locale'];

			$trans = new Translator($loader, $locale);

			$trans->setFallback($royalcms['config']['system.fallback_locale']);

			return $trans;
		});
	}

	/**
	 * Register the translation line loader.
	 *
	 * @return void
	 */
	protected function registerLoader()
	{
		$this->royalcms->bindShared('translation.loader', function($royalcms)
		{
			return new FileLoader($royalcms['files'], $royalcms['path.system'].'/languages');
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('translator', 'translation.loader');
	}

}
