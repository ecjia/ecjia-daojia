<?php


namespace Ecjia\System\Hookers;


class Handle500ErrorAction
{

    /**
     * Handle the event.
     *
     * @param \Exception $exception
     * @return void
     */
    public function handle($exception)
    {
        rc_die($exception->getMessage());
    }

}