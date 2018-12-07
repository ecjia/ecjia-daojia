<?php

namespace Ecjia\App\Theme\ThemeFramework\Fields\Number;

use Ecjia\App\Theme\ThemeFramework\Foundation\Options;

/**
 *
 * Field: Number
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class Number extends Options
{
    protected $type = 'number';

    public function output()
    {

        echo $this->element_before();
        $unit = ( isset( $this->field['unit'] ) ) ? '<em>'. $this->field['unit'] .'</em>' : '';
        echo '<input type="number" name="'. $this->element_name() .'" value="'. $this->element_value().'"'. $this->element_class() . $this->element_attributes() .'/>'. $unit;
        echo $this->element_after();

    }

}
