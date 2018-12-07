<?php

namespace Ecjia\App\Theme\ThemeFramework\Fields\ImageSelect;

use Ecjia\App\Theme\ThemeFramework\Foundation\Options;


/**
 *
 * Field: Image Select
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class ImageSelect extends Options
{
    protected $type = 'image_select';

    protected $default_field = [
        'default' => [], //default value of field
        'radio' => true, //use as radio
    ];

    public function output()
    {

        $input_type  = ( ! empty( $this->field['radio'] ) ) ? 'radio' : 'checkbox';
        $input_attr  = ( ! empty( $this->field['multi_select'] ) ) ? '[]' : '';

        echo $this->element_before();
        echo ( empty( $input_attr ) ) ? '<div class="cs-field-image-select">' : '';

        if ( isset( $this->field['options'] ) ) {
            $options  = $this->field['options'];
            foreach ( $options as $key => $value ) {
                echo '<label><input type="'. $input_type .'" name="'. $this->element_name( $input_attr ) .'" value="'. $key .'"'. $this->element_class() . $this->element_attributes( $key ) . $this->checked( $this->element_value(), $key ) .'/><img src="'. $value .'" alt="'. $key .'" /></label>';
            }
        }

        echo ( empty( $input_attr ) ) ? '</div>' : '';
        echo $this->element_after();

    }

}
