<?php

namespace Ecjia\App\Theme\ThemeFramework\Support;

use RC_Hook;

class Validate
{
    /**
     *
     * Email validate
     *
     * @since 1.0.0
     * @version 1.0.0
     *
     */
    public static function cs_validate_email( $value, $field )
    {

        if ( ! \RC_Format::sanitize_email( $value ) ) {
            return __( 'Please write a valid email address!', 'cs-framework' );
        }

    }


    /**
     *
     * Numeric validate
     *
     * @since 1.0.0
     * @version 1.0.0
     *
     */
    public static function cs_validate_numeric( $value, $field )
    {

        if ( ! is_numeric( $value ) ) {
            return __( 'Please write a numeric data!', 'cs-framework' );
        }

    }

    /**
     *
     * Required validate
     *
     * @since 1.0.0
     * @version 1.0.0
     *
     */
    public static function cs_validate_required( $value )
    {
        if ( empty( $value ) ) {
            return __( 'Fatal Error! This field is required!', 'cs-framework' );
        }
    }

}

RC_Hook::add_filter( 'cs_validate_email', 'cs_validate_email', 10, 2 );
RC_Hook::add_filter( 'cs_validate_numeric', 'cs_validate_numeric', 10, 2 );
RC_Hook::add_filter( 'cs_validate_required', 'cs_validate_required' );

