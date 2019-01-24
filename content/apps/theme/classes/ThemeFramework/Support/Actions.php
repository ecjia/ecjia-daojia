<?php

namespace Ecjia\App\Theme\ThemeFramework\Support;

use RC_Hook;
use ecjia_theme_option;

class Actions
{
    /**
     *
     * Get icons from admin ajax
     *
     * @since 1.0.0
     * @version 1.0.0
     *
     */
    public static function cs_get_icons()
    {

        RC_Hook::do_action( 'cs_add_icons_before' );

        $jsons = glob( CS_DIR . '/fields/icon/*.json' );

        if( ! empty( $jsons ) ) {

            foreach ( $jsons as $path ) {

                $object = cs_get_icon_fonts( 'fields/icon/'. basename( $path ) );

                if( is_object( $object ) ) {

                    echo ( count( $jsons ) >= 2 ) ? '<h4 class="cs-icon-title">'. $object->name .'</h4>' : '';

                    foreach ( $object->icons as $icon ) {
                        echo '<a class="cs-icon-tooltip" data-icon="'. $icon .'" data-title="'. $icon .'"><span class="cs-icon cs-selector"><i class="'. $icon .'"></i></span></a>';
                    }

                } else {
                    echo '<h4 class="cs-icon-title">'. __( 'Error! Can not load json file.', 'cs-framework' ) .'</h4>';
                }

            }

        }

        RC_Hook::do_action( 'cs_add_icons' );
        RC_Hook::do_action( 'cs_add_icons_after' );

        die();
    }

    /**
     *
     * Set icons for wp dialog
     *
     * @since 1.0.0
     * @version 1.0.0
     *
     */
    public static function cs_set_icons() {

        echo '<div id="cs-icon-dialog" class="cs-dialog" title="'. __( 'Add Icon', 'cs-framework' ) .'">';
        echo '<div class="cs-dialog-header cs-text-center"><input type="text" placeholder="'. __( 'Search a Icon...', 'cs-framework' ) .'" class="cs-icon-search" /></div>';
        echo '<div class="cs-dialog-load"><div class="cs-icon-loading">'. __( 'Loading...', 'cs-framework' ) .'</div></div>';
        echo '</div>';

    }

    /**
     *
     * Export options
     *
     * @since 1.0.0
     * @version 1.0.0
     *
     */
    public static function cs_export_options()
    {

        header('Content-Type: plain/text');
        header('Content-disposition: attachment; filename=backup-options-'. gmdate( 'd-m-Y' ) .'.txt');
        header('Content-Transfer-Encoding: binary');
        header('Pragma: no-cache');
        header('Expires: 0');

        echo Helpers::cs_encode_string( ecjia_theme_option::get_option( CS_OPTION ) );

        die();
    }

}

RC_Hook::add_action( 'ecjia_admin_ajax_cs-get-icons', 'cs_get_icons' );
RC_Hook::add_action( 'ecjia_admin_ajax_cs-export-options', 'cs_export_options' );
RC_Hook::add_action( 'admin_footer', 'cs_set_icons' );
RC_Hook::add_action( 'customize_controls_print_footer_scripts', 'cs_set_icons' );


