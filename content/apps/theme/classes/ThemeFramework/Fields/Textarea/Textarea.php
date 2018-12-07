<?php

namespace Ecjia\App\Theme\ThemeFramework\Fields\Textarea;

use Ecjia\App\Theme\ThemeFramework\Foundation\Options;

/**
 *
 * Field: Textarea
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class Textarea extends Options
{
    protected $type = 'textarea';

    protected $default_field = [
        'shortcode' => false, //shortcode support of field
    ];

    public function output()
    {

        echo $this->element_before();
        echo $this->shortcode_generator();
        echo '<textarea name="'. $this->element_name() .'"'. $this->element_class() . $this->element_attributes() .'>'. $this->element_value() .'</textarea>';
        echo $this->element_after();

    }

    public function shortcode_generator()
    {
        if( isset( $this->field['shortcode'] ) && CS_ACTIVE_SHORTCODE ) {
            echo '<a href="#" class="button button-primary cs-shortcode cs-shortcode-textarea">'. __( 'Add Shortcode', 'cs-framework' ) .'</a>';
        }
    }
}
