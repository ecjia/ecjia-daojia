<?php

namespace Ecjia\App\Theme\ThemeFramework\Fields\Heading;

use Ecjia\App\Theme\ThemeFramework\Foundation\Options;


/**
 *
 * Field: Heading
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class Heading extends Options
{
    protected $type = 'heading';

    protected $default_field = [
        'content' => null, //content of field
    ];

    public function output()
    {

        echo $this->element_before();
        echo $this->field['content'];
        echo $this->element_after();

    }

}
