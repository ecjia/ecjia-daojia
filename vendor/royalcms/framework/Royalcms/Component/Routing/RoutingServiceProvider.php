<?php namespace Royalcms\Component\Routing;

use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\Support\Facades\Response;

class RoutingServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerRouter();
		
		$this->registerResponse();

		$this->registerUrlGenerator();

		$this->registerRedirector();
	}

	/**
	 * Register the router instance.
	 *
	 * @return void
	 */
	protected function registerRouter()
	{
		$this->royalcms['router'] = $this->royalcms->share(function($royalcms)
		{
			$router = new Router($royalcms['events'], $royalcms);

			// If the current application environment is "testing", we will disable the
			// routing filters, since they can be tested independently of the routes
			// and just get in the way of our typical controller testing concerns.
			if ($royalcms['env'] == 'testing')
			{
				$router->disableFilters();
			}

			return $router;
		});
	}
	
	/**
	 * Register the router instance.
	 *
	 * @return void
	 */
	protected function registerResponse()
	{
	    $this->royalcms['response'] = $this->royalcms->share(function($royalcms)
	    {
	        $response = Response::make();
	        return $response;
	    });
	}

	/**
	 * Register the URL generator service.
	 *
	 * @return void
	 */
	protected function registerUrlGenerator()
	{
		$this->royalcms['url'] = $this->royalcms->share(function($royalcms)
		{
			// The URL generator needs the route collection that exists on the router.
			// Keep in mind this is an object, so we're passing by references here
			// and all the registered routes will be available to the generator.
			$routes = $royalcms['router']->getRoutes();

			return new UrlGenerator($routes, $royalcms->rebinding('request', function($royalcms, $request)
			{
				$royalcms['url']->setRequest($request);
			}));
		});
	}

	/**
	 * Register the Redirector service.
	 *
	 * @return void
	 */
	protected function registerRedirector()
	{
		$this->royalcms['redirect'] = $this->royalcms->share(function($royalcms)
		{
			$redirector = new Redirector($royalcms['url']);

			// If the session is set on the application instance, we'll inject it into
			// the redirector instance. This allows the redirect responses to allow
			// for the quite convenient "with" methods that flash to the session.
			if (isset($royalcms['session.store']))
			{
				$redirector->setSession($royalcms['session.store']);
			}

			return $redirector;
		});
	}

}
