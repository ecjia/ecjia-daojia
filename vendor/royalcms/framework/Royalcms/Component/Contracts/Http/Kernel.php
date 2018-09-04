<?php

namespace Royalcms\Component\Contracts\Http;

interface Kernel
{
    /**
     * Bootstrap the application for HTTP requests.
     *
     * @return void
     */
    public function bootstrap();

    /**
     * Handle an incoming HTTP request.
     *
     * @param  \Symfony\Component\HttpFoundation\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle($request);

    /**
     * Perform any final actions for the request lifecycle.
     *
     * @param  \Symfony\Component\HttpFoundation\Request  $request
     * @param  \Symfony\Component\HttpFoundation\Response  $response
     * @return void
     */
    public function terminate($request, $response);

    /**
     * Get the Royalcms application instance.
     *
     * @return \Royalcms\Component\Contracts\Foundation\Royalcms
     */
    public function getRoyalcms();

    /**
     * Get the Royalcms application instance.
     *
     * @return \Royalcms\Component\Contracts\Foundation\Application
     */
    public function getApplication();
}
