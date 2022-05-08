<?php


namespace Ecjia\System\Listeners;


use RC_Logger;
use RC_Request;

class WarningExceptionListener
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param $event
     * @return void
     */
    public function handle($exception)
    {
        if (config('system.debug')) {
            $err = array(
                'file'      => $exception->getFile(),
                'line'      => $exception->getLine(),
                'code'      => $exception->getPrevious(),
                'url'       => RC_Request::fullUrl(),
            );
            RC_Logger::getLogger(RC_Logger::LOG_WARNING)->info($exception->getMessage(), $err);
        }

    }


}