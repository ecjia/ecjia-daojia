<?php

namespace Ecjia\App\Theme\ThemeFramework\Fields\Text;

use Ecjia\App\Theme\ThemeFramework\Foundation\Options;

/**
 *
 * Field: Text
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class Text extends Options
{
    protected $type = 'text';

    public function output()
    {

        echo $this->element_before();
        echo '<input type="'. $this->element_type() .'" name="'. $this->element_name() .'" value="'. $this->element_value() .'"'. $this->element_class() . $this->element_attributes() .'/>';
        echo $this->element_after();

    }

}
