<?php namespace Royalcms\Component\Pagination;

use Royalcms\Component\Support\ServiceProvider;

class PaginationServiceProvider extends ServiceProvider {

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
		$this->royalcms->bindShared('paginator', function($royalcms)
		{
			$paginator = new Environment($royalcms['request'], $royalcms['view'], $royalcms['translator']);

			$paginator->setViewName($royalcms['config']['view.pagination']);

			$royalcms->refresh('request', $paginator, 'setRequest');

			return $paginator;
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('paginator');
	}

}
