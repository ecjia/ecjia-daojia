<?php

namespace Ecjia\App\Theme\ThemeFramework\Fields\Backup;

use Ecjia\App\Theme\ThemeFramework\Foundation\Options;
use Ecjia\App\Theme\ThemeFramework\Support\Helpers;
use ecjia_theme_option;

/**
 *
 * Field: Backup
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class Backup extends Options
{
    protected $type = 'backup';

    public function output()
    {

        echo $this->element_before();

        echo '<textarea name="'. $this->unique .'[import]"'. $this->element_class() . $this->element_attributes() .'></textarea>';
        submit_button( __( 'Import a Backup', 'cs-framework' ), 'primary cs-import-backup', 'backup', false );
        echo '<small>( '. __( 'copy-paste your backup string here', 'cs-framework' ).' )</small>';

        echo '<hr />';

        echo '<textarea name="_nonce"'. $this->element_class() . $this->element_attributes() .' disabled="disabled">'. Helpers::cs_encode_string( ecjia_theme_option::get_option( $this->unique ) ) .'</textarea>';
        echo '<a href="'. admin_url( 'admin-ajax.php?action=cs-export-options' ) .'" class="button button-primary" target="_blank">'. __( 'Export and Download Backup', 'cs-framework' ) .'</a>';
        echo '<small>-( '. __( 'or', 'cs-framework' ) .' )-</small>';
        submit_button( __( 'Reset All Options', 'cs-framework' ), 'cs-warning-primary cs-reset-confirm', $this->unique . '[resetall]', false );
        echo '<small class="cs-text-warning">'. __( 'Please be sure for reset all of framework options.', 'cs-framework' ) .'</small>';

        echo $this->element_after();

    }

}
