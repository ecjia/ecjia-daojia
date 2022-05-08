<?php


namespace Ecjia\App\Api\Middleware;


use Closure;
use Ecjia\App\Api\Jobs\TestDumpJob;

class TestDumpJobMiddleware
{

    public function handle($request, Closure $next)
    {
        $response = $next($request);

        try {
            $server = $request->server(null, []);
            $header = $request->header(null, []);
            $query  = $request->query(null, []);
            $data   = array_merge($server, $header, $query);

            TestDumpJob::dispatch($data);
        } catch (\Exception $exception) {
            ecjia_log_error($exception);
        } finally {
            return $response;
        }
    }

}