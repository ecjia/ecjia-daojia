<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-25
 * Time: 09:45
 */

namespace Ecjia\App\Cart\Middleware;

use Closure;

class AfterMiddleware
{

    public function handle($request, Closure $next)
    {
        // 运行动作

        return $next($request);
    }

}