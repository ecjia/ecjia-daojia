<?php namespace Royalcms\Component\Html;

use Royalcms\Component\Support\ServiceProvider;

class HtmlServiceProvider extends ServiceProvider {

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
		$this->registerHtmlBuilder();

		$this->registerFormBuilder();
	}

	/**
	 * Register the HTML builder instance.
	 *
	 * @return void
	 */
	protected function registerHtmlBuilder()
	{
		$this->royalcms->bindShared('html', function($royalcms)
		{
			return new HtmlBuilder($royalcms['url']);
		});
	}

	/**
	 * Register the form builder instance.
	 *
	 * @return void
	 */
	protected function registerFormBuilder()
	{
		$this->royalcms->bindShared('form', function($royalcms)
		{
			$form = new FormBuilder($royalcms['html'], $royalcms['url'], $royalcms['session.store']->getToken());

			return $form->setSessionStore($royalcms['session.store']);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('html', 'form');
	}

}
