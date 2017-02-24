<?php namespace Royalcms\Component\Routing;

interface RouteFiltererInterface {

	/**
	 * Register a new filter with the router.
	 *
	 * @param  string  $name
	 * @param  mixed  $callback
	 * @return void
	 */
	public function filter($name, $callback);

	/**
	 * Call the given route filter.
	 *
	 * @param  string  $filter
	 * @param  array  $parameters
	 * @param  \Royalcms\Component\Routing\Route  $route
	 * @param  \Royalcms\Component\HttpKernel\Request  $request
	 * @param  \Royalcms\Component\HttpKernel\Response|null $response
	 * @return mixed
	 */
	public function callRouteFilter($filter, $parameters, $route, $request, $response = null);

}
