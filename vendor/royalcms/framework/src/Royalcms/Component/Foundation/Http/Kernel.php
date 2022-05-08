<?php

namespace Royalcms\Component\Foundation\Http;

use Throwable;
use Royalcms\Component\Routing\Router;
use Royalcms\Component\Contracts\Foundation\Royalcms;
use Royalcms\Component\Contracts\Http\Kernel as KernelContract;

class Kernel extends \Illuminate\Foundation\Http\Kernel implements KernelContract
{
    /**
     * The royalcms application implementation.
     *
     * @var \Royalcms\Component\Contracts\Foundation\Royalcms
     */
    protected $royalcms;

    /**
     * The bootstrap classes for the application.
     *
     * @var array
     */
    protected $bootstrappers = [
        'Royalcms\Component\Foundation\Bootstrap\Starting',
        'Royalcms\Component\Foundation\Bootstrap\LoadEnvironmentVariables',
        'Royalcms\Component\Foundation\Bootstrap\LoadConfiguration',
        'Royalcms\Component\Foundation\Bootstrap\RegisterNamespaces',
//        'Royalcms\Component\Foundation\Bootstrap\ConfigureLogging',
        'Royalcms\Component\Foundation\Bootstrap\HandleExceptions',
        'Royalcms\Component\Foundation\Bootstrap\RegisterFacades',
        'Royalcms\Component\Foundation\Bootstrap\RegisterProviders',
        'Royalcms\Component\Foundation\Bootstrap\BootProviders',
        'Royalcms\Component\Foundation\Bootstrap\Booted',
    ];

    /**
     * Create a new HTTP kernel instance.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
     * @param  \Royalcms\Component\Routing\Router  $router
     * @return void
     */
    public function __construct(Royalcms $royalcms, Router $router)
    {
        $this->royalcms = $royalcms;

        parent::__construct($royalcms, $router);
    }

    /**
     * Report the exception to the exception handler.
     *
     * @param  \Throwable  $e
     * @return void
     */
    protected function reportException(Throwable $e)
    {
        $this->royalcms['Royalcms\Component\Contracts\Debug\ExceptionHandler']->report($e);
    }

    /**
     * Render the exception to a response.
     *
     * @param  \Royalcms\Component\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderException($request, Throwable $e)
    {
        return $this->royalcms['Royalcms\Component\Contracts\Debug\ExceptionHandler']->render($request, $e);
    }

    /**
     * Get the Royalcms application instance.
     *
     * @return \Royalcms\Component\Contracts\Foundation\Royalcms
     */
    public function getRoyalcms()
    {
        return $this->royalcms;
    }

    /**
     * Get the Royalcms application instance.
     *
     * @return \Royalcms\Component\Contracts\Foundation\Royalcms
     */
    public function getApplication()
    {
        return $this->royalcms;
    }
}
