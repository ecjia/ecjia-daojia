<?php namespace Royalcms\Component\Routing\Matching;

use Royalcms\Component\HttpKernel\Request;
use Royalcms\Component\Routing\Route;

class MethodValidator implements ValidatorInterface {

	/**
	 * Validate a given rule against a route and request.
	 *
	 * @param  \Royalcms\Component\Routing\Route  $route
	 * @param  \Royalcms\Component\HttpKernel\Request  $request
	 * @return bool
	 */
	public function matches(Route $route, Request $request)
	{
		return in_array($request->getMethod(), $route->methods());
	}

}
