<?php

namespace Ecjia\App\Theme\ThemeFramework\Fields\Select;

use Ecjia\App\Theme\ThemeFramework\Foundation\Options;

/**
 *
 * Field: Select
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class Select extends Options
{
    protected $type = 'select';

    protected $default_field = [
        'options' => [], //options of radios
        'query_args' => [], //query args for wordpress core radios
        'default' => [], //default value of field
        'default_option' => [], //default option for first select option
    ];

    public function output()
    {

        echo $this->element_before();

        if ( isset( $this->field['options'] ) ) {

            $options    = $this->field['options'];
            $class      = $this->element_class();
            $options    = ( is_array( $options ) ) ? $options : array_filter( $this->element_data( $options ) );
            $extra_name = ( isset( $this->field['attributes']['multiple'] ) ) ? '[]' : '';
            $chosen_rtl = ( is_rtl() && strpos( $class, 'chosen' ) ) ? 'chosen-rtl' : '';

            echo '<select name="'. $this->element_name( $extra_name ) .'"'. $this->element_class( $chosen_rtl ) . $this->element_attributes() .'>';

            echo ( isset( $this->field['default_option'] ) ) ? '<option value="">'.$this->field['default_option'].'</option>' : '';

            if ( !empty( $options ) ){
            foreach ( $options as $key => $value ) {
              echo '<option value="'. $key .'" '. $this->checked( $this->element_value(), $key, 'selected' ) .'>'. $value .'</option>';
            }
            }

            echo '</select>';

        }

        echo $this->element_after();

    }

}
