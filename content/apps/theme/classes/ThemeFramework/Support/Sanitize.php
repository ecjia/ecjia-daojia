<?php

namespace Ecjia\App\Theme\ThemeFramework\Support;

use RC_Hook;
use RC_Kses;
use RC_Format;

class Sanitize
{
    /**
     *
     * Text sanitize
     *
     * @since 1.0.0
     * @version 1.0.0
     *
     */
    public static function cs_sanitize_text( $value, $field )
    {
        return RC_Kses::filter_nohtml_kses( $value );
    }

    /**
     *
     * Textarea sanitize
     *
     * @since 1.0.0
     * @version 1.0.0
     *
     */
    public static function cs_sanitize_textarea( $value )
    {
        return RC_Kses::kses( $value, RC_Kses::$allowedposttags );
    }

    /**
     *
     * Checkbox sanitize
     * Do not touch, or think twice.
     *
     * @since 1.0.0
     * @version 1.0.0
     *
     */
    public static function cs_sanitize_checkbox( $value )
    {

        if( ! empty( $value ) && $value == 1 ) {
            $value = true;
        }

        if( empty( $value ) ) {
            $value = false;
        }

        return $value;

    }

    /**
     *
     * Image select sanitize
     * Do not touch, or think twice.
     *
     *
     * @since 1.0.0
     * @version 1.0.0
     *
     */
    function cs_sanitize_image_select( $value )
    {
        if ( isset( $value ) && is_array( $value ) ) {
            if ( count( $value ) ) {
                //$value = $value;
            } else {
                $value = $value[0];
            }
        } else if ( empty( $value ) ) {
            $value = '';
        }

        return $value;
    }

    /**
     *
     * Group sanitize
     * Do not touch, or think twice.
     *
     * @since 1.0.0
     * @version 1.0.0
     *
     */
    public static function cs_sanitize_group( $value )
    {
        return ( empty( $value ) ) ? '' : $value;
    }

    /**
     *
     * Title sanitize
     *
     * @since 1.0.0
     * @version 1.0.0
     *
     */
    public static function cs_sanitize_title( $value )
    {
        return RC_Format::sanitize_title( $value );
    }

    /**
     *
     * Text clean
     *
     * @since 1.0.0
     * @version 1.0.0
     *
     */
    public static function cs_sanitize_clean( $value )
    {
        return $value;
    }

}

RC_Hook::add_filter( 'cs_sanitize_text', 'cs_sanitize_text', 10, 2 );
RC_Hook::add_filter( 'cs_sanitize_textarea', 'cs_sanitize_textarea' );
RC_Hook::add_filter( 'cs_sanitize_checkbox', 'cs_sanitize_checkbox' );
RC_Hook::add_filter( 'cs_sanitize_switcher', 'cs_sanitize_checkbox' );
RC_Hook::add_filter( 'cs_sanitize_image_select', 'cs_sanitize_image_select' );
RC_Hook::add_filter( 'cs_sanitize_group', 'cs_sanitize_group' );
RC_Hook::add_filter( 'cs_sanitize_title', 'cs_sanitize_title' );
RC_Hook::add_filter( 'cs_sanitize_clean', 'cs_sanitize_clean', 10, 2 );

