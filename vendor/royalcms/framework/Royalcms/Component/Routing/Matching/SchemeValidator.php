<?php

namespace Royalcms\Component\Routing\Matching;

use Royalcms\Component\Http\Request;
use Royalcms\Component\Routing\Route;

class SchemeValidator implements ValidatorInterface
{
    /**
     * Validate a given rule against a route and request.
     *
     * @param  \Royalcms\Component\Routing\Route  $route
     * @param  \Royalcms\Component\Http\Request  $request
     * @return bool
     */
    public function matches(Route $route, Request $request)
    {
        if ($route->httpOnly()) {
            return ! $request->secure();
        } elseif ($route->secure()) {
            return $request->secure();
        }

        return true;
    }
}
