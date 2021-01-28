<?php

namespace Ecjia\Component\ThemeFramework\Fields\Backup;

use Ecjia\Component\ThemeFramework\Foundation\Options;
use Ecjia\Component\ThemeFramework\Support\Helpers;
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
        submit_button( __( 'Import a Backup', 'ecjia' ), 'primary cs-import-backup', 'backup', false );
        echo '<small>( '. __( 'copy-paste your backup string here', 'ecjia' ).' )</small>';

        echo '<hr />';

        echo '<textarea name="_nonce"'. $this->element_class() . $this->element_attributes() .' disabled="disabled">'. Helpers::cs_encode_string( ecjia_theme_option::get_option( $this->unique ) ) .'</textarea>';
        echo '<a href="'. admin_url( 'admin-ajax.php?action=cs-export-options' ) .'" class="button button-primary" target="_blank">'. __( 'Export and Download Backup', 'ecjia' ) .'</a>';
        echo '<small>-( '. __( 'or', 'ecjia' ) .' )-</small>';
        submit_button( __( 'Reset All Options', 'ecjia' ), 'cs-warning-primary cs-reset-confirm', $this->unique . '[resetall]', false );
        echo '<small class="cs-text-warning">'. __( 'Please be sure for reset all of framework options.', 'ecjia' ) .'</small>';

        echo $this->element_after();

    }

}
