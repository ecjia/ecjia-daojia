<?php


namespace Ecjia\App\Api\Middleware;


use Closure;

class ApiErrorTextDisplayMiddleware
{

    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $data       = $response->getOriginalContent();
        $error_code = array_get($data, 'status.error_code');

        if (in_array($error_code, [
            'url_param_not_exists',
            'api_not_exists',
            'api_not_handle',
            'api_not_instanceof',
        ])) {
            $error_desc = array_get($data, 'status.error_desc');
            $response->setOriginalContent($error_desc);
        }

        return $response;
    }

}