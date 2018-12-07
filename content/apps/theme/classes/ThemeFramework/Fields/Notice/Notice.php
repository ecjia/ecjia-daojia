<?php

namespace Ecjia\App\Theme\ThemeFramework\Fields\Notice;

use Ecjia\App\Theme\ThemeFramework\Foundation\Options;


/**
 *
 * Field: Notice
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class Notice extends Options
{
    protected $type = 'notice';

    protected $default_field = [
        'content' => null, //content of field
    ];

    public function output()
    {

        echo $this->element_before();
        echo '<div class="cs-notice cs-'. $this->field['class'] .'">'. $this->field['content'] .'</div>';
        echo $this->element_after();

    }

}
