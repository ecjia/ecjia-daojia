<?php


namespace Ecjia\App\Api\Middleware;


use Closure;
use Ecjia\Component\ApiServer\Responses\ApiResponse;
use RC_Hook;
use Symfony\Component\HttpFoundation\Response;

class ApiHasFilterHookMiddleware
{

    public function handle($request, Closure $next)
    {
        $url = $request->get('url');

        if (RC_Hook::has_filter($url)) {
            $response = response();
            $response = RC_Hook::apply_filters($url, $response);
            if ($response instanceof Response) {
                $response = new ApiResponse($response->getOriginalContent());
            }
            elseif (is_array($response)) {
                $response = new ApiResponse($response);
            }
            return $response;
        }

        $response = $next($request);

        return $response;
    }

}