<?php

namespace Royalcms\Component\Foundation\Http\Middleware;

use Closure;
use Royalcms\Component\Foundation\Contracts\Royalcms;
use Royalcms\Component\Foundation\Http\Exceptions\MaintenanceModeException;

class CheckForMaintenanceMode
{
    /**
     * The royalcms implementation.
     *
     * @var \Royalcms\Component\Foundation\Contracts\Royalcms
     */
    protected $royalcms;

    /**
     * Create a new middleware instance.
     *
     * @param  \Royalcms\Component\Foundation\Contracts\Royalcms  $royalcms
     * @return void
     */
    public function __construct(Royalcms $royalcms)
    {
        $this->royalcms = $royalcms;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Royalcms\Component\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function handle($request, Closure $next)
    {
        if ($this->royalcms->isDownForMaintenance()) {
            $data = json_decode(file_get_contents($this->royalcms->storagePath().'/framework/down'), true);

            throw new MaintenanceModeException($data['time'], $data['retry'], $data['message']);
        }

        return $next($request);
    }
}
