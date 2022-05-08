<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-05-05
 * Time: 09:50
 */

namespace Ecjia\Kernel\Http\Middleware;

use Closure;

class EventStreamHeader
{

    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->header('Content-Type', 'text/event-stream');
        $response->header('Cache-Control', 'no-cache');

        return $response;
    }

}