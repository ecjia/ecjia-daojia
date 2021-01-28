<?php

if (!function_exists('clean')) {
    /**
     * @param $dirty
     * @param null $config
     * @return mixed
     */
    function clean($dirty, $config = null)
    {
        return royalcms('purifier')->clean($dirty, $config);
    }
}

if ( ! function_exists('remove_xss'))
{
    /**
     * xss过滤函数
     *
     * @param string $string
     * @return string
     */
    function remove_xss($string)
    {
        if (empty($string)) {
            return $string;
        }

        $string = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S', '', $string);

        return trim(clean($string, 'input'));
    }
}