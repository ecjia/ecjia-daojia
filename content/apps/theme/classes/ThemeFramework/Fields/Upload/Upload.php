<?php

namespace Ecjia\App\Theme\ThemeFramework\Fields\Upload;

use Ecjia\App\Theme\ThemeFramework\Foundation\Options;

/**
 *
 * Field: Upload
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class Upload extends Options
{
    protected $type = 'upload';

    protected $default_field = [
        'settings' => [], //settings of field
        'upload_type' => '', //upload type of field. you can use image or video type
        'button_title' => 'Upload', //button title of field
        'frame_title' => 'Upload', //frame title of field
        'insert_title' => 'Use Image', //insert title of field
    ];

    public function output()
    {

        echo $this->element_before();

        if ( isset( $this->field['settings'] ) ) {
            extract( $this->field['settings'] );
        }

        $upload_type  = ( isset( $upload_type  ) ) ? $upload_type  : 'image';
        $button_title = ( isset( $button_title ) ) ? $button_title : __( 'Upload', 'cs-framework' );
        $frame_title  = ( isset( $frame_title  ) ) ? $frame_title  : __( 'Upload', 'cs-framework' );
        $insert_title = ( isset( $insert_title ) ) ? $insert_title : __( 'Use Image', 'cs-framework' );

        echo '<input type="text" name="'. $this->element_name() .'" value="'. $this->element_value() .'"'. $this->element_class() . $this->element_attributes() .'/>';
        echo '<a href="#" class="button cs-add" data-frame-title="'. $frame_title .'" data-upload-type="'. $upload_type .'" data-insert-title="'. $insert_title .'">'. $button_title .'</a>';

        echo $this->element_after();

    }
}
