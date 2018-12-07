<?php

namespace Ecjia\App\Theme\ThemeFramework\Fields\ColorPicker;

use Ecjia\App\Theme\ThemeFramework\Foundation\Options;

/**
 *
 * Field: Color Picker
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class ColorPicker extends Options
{
    protected $type = 'color_picker';

    protected $default_field = [
        'rgba' => true, //rgba support of picker
    ];

    public function output()
    {

        echo $this->element_before();
        echo '<input type="text" name="'. $this->element_name() .'" value="'. $this->element_value() .'"'. $this->element_class( 'cs-field-color-picker' ) . $this->element_attributes( $this->extra_attributes() ) .'/>';
        echo $this->element_after();

    }

    public function extra_attributes()
    {

        $atts = array();

        if( isset( $this->field['id'] ) ) {
            $atts['data-depend-id'] = $this->field['id'];
        }

        if ( isset( $this->field['rgba'] ) &&  $this->field['rgba'] === false ) {
            $atts['data-rgba'] = 'false';
        }

        if( isset( $this->field['default'] ) ) {
            $atts['data-default-color'] = $this->field['default'];
        }

        return $atts;

    }

}
