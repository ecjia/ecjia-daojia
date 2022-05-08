<?php


namespace Ecjia\System\Hookers;


use ecjia;

/**
 * 设置当前时区
 * Class SetCurrentTimezoneFilter
 * @package Ecjia\System\Hookers
 */
class SetCurrentTimezoneFilter
{

    /**
     * Handle the event.
     *
     */
    public function handle($timezone)
    {
        return isset($_SESSION['timezone']) ? $_SESSION['timezone'] : ecjia::config('timezone');
    }

}