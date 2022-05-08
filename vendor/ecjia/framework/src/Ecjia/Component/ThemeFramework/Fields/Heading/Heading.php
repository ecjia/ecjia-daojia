<?php

namespace Ecjia\Component\ThemeFramework\Fields\Heading;

use Ecjia\Component\ThemeFramework\Foundation\Options;


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
