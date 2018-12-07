<?php

namespace Ecjia\App\Theme\ThemeFramework\Fields\Image;

use Ecjia\App\Theme\ThemeFramework\Foundation\Options;


/**
 *
 * Field: Image
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class Image extends Options
{
    protected $type = 'image';

    protected $default_field = [
        'add_title' => null, //Add Image text change
    ];

    public function output()
    {

        echo $this->element_before();

        $preview = '';
        $value   = $this->element_value();
        $add     = ( ! empty( $this->field['add_title'] ) ) ? $this->field['add_title'] : __( 'Add Image', 'cs-framework' );
        $hidden  = ( empty( $value ) ) ? ' hidden' : '';

        if ( ! empty( $value ) ) {
            $attachment = wp_get_attachment_image_src( $value, 'thumbnail' );
            $preview    = $attachment[0];
        }

        echo '<div class="cs-image-preview'. $hidden .'"><div class="cs-preview"><i class="fa fa-times cs-remove"></i><img src="'. $preview .'" alt="preview" /></div></div>';
        echo '<a href="#" class="button button-primary cs-add">'. $add .'</a>';
        echo '<input type="text" name="'. $this->element_name() .'" value="'. $this->element_value() .'"'. $this->element_class() . $this->element_attributes() .'/>';

        echo $this->element_after();

    }

}
