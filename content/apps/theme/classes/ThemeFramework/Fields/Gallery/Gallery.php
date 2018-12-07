<?php

namespace Ecjia\App\Theme\ThemeFramework\Fields\Gallery;

use Ecjia\App\Theme\ThemeFramework\Foundation\Options;


/**
 *
 * Field: Gallery
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class Gallery extends Options
{
    protected $type = 'gallery';

    protected $default_field = [
        'add_title' => null, //Add Gallery text change
        'edit_title' => null, //Edit Gallery text change
        'clear_title' => null, //Clear text change
    ];

    public function output()
    {

        echo $this->element_before();

        $value  = $this->element_value();
        $add    = ( ! empty( $this->field['add_title'] ) ) ? $this->field['add_title'] : __( 'Add Gallery', 'cs-framework' );
        $edit   = ( ! empty( $this->field['edit_title'] ) ) ? $this->field['edit_title'] : __( 'Edit Gallery', 'cs-framework' );
        $clear  = ( ! empty( $this->field['clear_title'] ) ) ? $this->field['clear_title'] : __( 'Clear', 'cs-framework' );
        $hidden = ( empty( $value ) ) ? ' hidden' : '';

        echo '<ul>';

        if ( ! empty( $value ) ) {

            $values = explode( ',', $value );

            foreach ( $values as $id ) {
                $attachment = wp_get_attachment_image_src( $id, 'thumbnail' );
                echo '<li><img src="'. $attachment[0] .'" alt="" /></li>';
            }

        }

        echo '</ul>';
        echo '<a href="#" class="button button-primary cs-add">'. $add .'</a>';
        echo '<a href="#" class="button cs-edit'. $hidden .'">'. $edit .'</a>';
        echo '<a href="#" class="button cs-warning-primary cs-remove'. $hidden .'">'. $clear .'</a>';
        echo '<input type="text" name="'. $this->element_name() .'" value="'. $value .'"'. $this->element_class() . $this->element_attributes() .'/>';

        echo $this->element_after();

    }

}
