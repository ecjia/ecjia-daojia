<?php


namespace Ecjia\System\Hookers;


use RC_Time;

class UploadDefaultRandomFilenameFilter
{

    /**
     * Handle the event.
     *
     * @return string
     */
    public function handle($filename)
    {
        $str = '';
        for($i = 0; $i < 9; $i++) {
            $str .= mt_rand(0, 9);
        }

        return RC_Time::gmtime() . $str;
    }

}