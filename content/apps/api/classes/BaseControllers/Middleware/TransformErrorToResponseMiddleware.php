<?php


namespace Ecjia\App\Api\BaseControllers\Middleware;


use Closure;
use Ecjia\Component\ApiServer\Responses\ApiError;
use Ecjia\Component\ApiServer\Responses\ApiResponse;

class TransformErrorToResponseMiddleware
{

    public function handle($request, Closure $next)
    {
        try {
            $response = $next($request);

            if (is_ecjia_error($response)) {
                return new ApiResponse(new ApiError($response));
            }

            return $response;
        } catch (\Exception $exception) {
            return new ApiResponse(new ApiError($exception->getCode(), $exception->getMessage()));
        }
    }
}