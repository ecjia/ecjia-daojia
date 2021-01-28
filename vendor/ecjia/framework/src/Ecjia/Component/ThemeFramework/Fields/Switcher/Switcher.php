<?php

namespace Ecjia\Component\ThemeFramework\Fields\Switcher;

use Ecjia\Component\ThemeFramework\Foundation\Options;

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
        echo '<label><input type="checkbox" name="'. $this->element_name() .'" value="1"'. $this->element_class() . $this->element_attributes() . checked( $this->element_value(), 1, false ) .'/><em data-on="'. __( 'on', 'ecjia' ) .'" data-off="'. __( 'off', 'ecjia' ) .'"></em><span></span></label>' . $label;
        echo $this->element_after();

    }

}
