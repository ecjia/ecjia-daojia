<?php

namespace Ecjia\App\Theme\ThemeFramework\Fields\Switcher;

use Ecjia\App\Theme\ThemeFramework\Foundation\Options;

/**
 *
 * Field: Switcher
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class Switcher extends Options
{
    protected $type = 'switcher';

    protected $default_field = [
        'label' => '', //label of a checkbox
        'default' => false, //default value of field
    ];

    public function output()
    {

        echo $this->element_before();
        $label = ( isset( $this->field['label'] ) ) ? '<div class="cs-text-desc">'. $this->field['label'] . '</div>' : '';
        echo '<label><input type="checkbox" name="'. $this->element_name() .'" value="1"'. $this->element_class() . $this->element_attributes() . checked( $this->element_value(), 1, false ) .'/><em data-on="'. __( 'on', 'cs-framework' ) .'" data-off="'. __( 'off', 'cs-framework' ) .'"></em><span></span></label>' . $label;
        echo $this->element_after();

    }

}
