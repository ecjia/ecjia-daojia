<?php
/**
 *
 * Deprecated framework functions from past framework versions. You shouldn't use these
 * functions and look for the alternatives instead. The functions will be removed in a later version.
 *
 */

/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/26
 * Time: 09:42
 */

if ( ! function_exists('price_format'))
{
    /**
     * ecjia_price_format 方法的别名
     */
    function price_format($price, $change_price = true)
    {
        _deprecated_function( __FUNCTION__, '1.36.0', 'ecjia_price_format' );

        return ecjia_price_format($price, $change_price);
    }
}

if ( ! function_exists('mysql_like_quote'))
{
    /**
     * ecjia_mysql_like_quote 方法别名
     */
    function mysql_like_quote($str)
    {
        _deprecated_function( __FUNCTION__, '1.20', 'ecjia_mysql_like_quote()' );

        return ecjia_mysql_like_quote($str);
    }
}