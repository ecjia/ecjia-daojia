<?php

if (!function_exists('clean')) {
    function clean($dirty, $config = null)
    {
        return royalcms('purifier')->clean($dirty, $config);
    }
}
