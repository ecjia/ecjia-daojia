<?php


namespace Ecjia\App\Api\Middleware;


use Closure;
use Ecjia\Component\ApiServer\Responses\ApiResponse;
use Ecjia\Component\ApiSignature\ApiSignatureManager;

class ApiSignatureCheckMiddleware
{

    public function handle($request, Closure $next)
    {
        $url = $request->get('url');

        // Api signature checking...
        $error = (new ApiSignatureManager())->checkSignature($url);
        if (is_ecjia_error($error)) {
            $response = new ApiResponse($error);
            royalcms()->instance('response', $response);
            return $response;
        }

        $response = $next($request);

        return $response;
    }

}