<?php

namespace Ecjia\Component\ThemeFramework\Fields\Icon;

use Ecjia\Component\ThemeFramework\Foundation\Options;

/**
 *
 * Field: Icon
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class Icon extends Options
{
    protected $type = 'icon';

    public function output()
    {

        echo $this->element_before();

        $value  = $this->element_value();
        $hidden = ( empty( $value ) ) ? ' hidden' : '';

        echo '<div class="cs-icon-select">';
        echo '<span class="cs-icon-preview'. $hidden .'"><i class="'. $value .'"></i></span>';
        echo '<a href="#" class="button button-primary cs-icon-add">'. __( 'Add Icon', 'ecjia' ) .'</a>';
        echo '<a href="#" class="button cs-warning-primary cs-icon-remove'. $hidden .'">'. __( 'Remove Icon', 'ecjia' ) .'</a>';
        echo '<input type="text" name="'. $this->element_name() .'" value="'. $value .'"'. $this->element_class( 'cs-icon-value' ) . $this->element_attributes() .' />';
        echo '</div>';

        echo $this->element_after();

    }

}
