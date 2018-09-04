<?php

namespace Royalcms\Component\Foundation\Bootstrap;

use Royalcms\Component\Contracts\Foundation\Royalcms;
use Royalcms\Component\Exception\ExceptionServiceProvider;

class HandleExceptions
{
    /**
     * The application instance.
     *
     * @var \Royalcms\Component\Contracts\Foundation\Royalcms
     */
    protected $royalcms;

    /**
     * Bootstrap the given application.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
     * @return void
     */
    public function bootstrap(Royalcms $royalcms)
    {
        $this->royalcms = $royalcms;

        $this->royalcms->register(new ExceptionServiceProvider($royalcms));

        $this->startExceptionHandling();
    }

    /**
     * Start the exception handling for the request.
     *
     * @return void
     */
    public function startExceptionHandling()
    {
        $this->royalcms['exception']->register($this->royalcms->environment());

        $this->royalcms['exception.display']->setDebug($this->royalcms['config']['system.debug']);

    }

}
