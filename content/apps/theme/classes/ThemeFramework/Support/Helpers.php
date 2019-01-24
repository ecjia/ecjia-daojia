<?php

namespace Ecjia\App\Theme\ThemeFramework\Support;

class Helpers
{

    /**
     *
     * Add framework element
     *
     * @since 1.0.0
     * @version 1.0.0
     *
     */
    public static function cs_add_element( $field = array(), $value = '', $unique = '' )
    {
        return royalcms('ecjia.theme.framework')->getOptionField()->addElement( $field, $value, $unique );
    }

    /**
     *
     * Encode string for backup options
     *
     * @since 1.0.0
     * @version 1.0.0
     *
     */
    public static function cs_encode_string( $string )
    {
        return rtrim( strtr( call_user_func( 'base'. '64' .'_encode', addslashes( gzcompress( serialize( $string ), 9 ) ) ), '+/', '-_' ), '=' );
    }

    /**
     *
     * Decode string for backup options
     *
     * @since 1.0.0
     * @version 1.0.0
     *
     */
    public static function cs_decode_string( $string )
    {
        return unserialize( gzuncompress( stripslashes( call_user_func( 'base'. '64' .'_decode', rtrim( strtr( $string, '-_', '+/' ), '=' ) ) ) ) );
    }

    /**
     *
     * Array search key & value
     *
     * @since 1.0.0
     * @version 1.0.0
     *
     */
    public static function cs_array_search( $array, $key, $value )
    {

        $results = array();

        if ( is_array( $array ) ) {
            if ( isset( $array[$key] ) && $array[$key] == $value ) {
                $results[] = $array;
            }

            foreach ( $array as $sub_array ) {
                $results = array_merge( $results, self::cs_array_search( $sub_array, $key, $value ) );
            }

        }

        return $results;

    }


    /**
     *
     * Getting POST Var
     *
     * @since 1.0.0
     * @version 1.0.0
     *
     */
    public static function cs_get_var( $name, $default = null )
    {

        return royalcms('request')->input($name, $default);

    }


    /**
     *
     * Getting POST Vars
     *
     * @since 1.0.0
     * @version 1.0.0
     *
     */
    public static function cs_get_vars( $name, $depth, $default = null )
    {

        $name = $name . '.' . $depth;

        return royalcms('request')->input($name, $default);

    }


}
