<?php

namespace Ecjia\App\Theme\ThemeFramework\Fields\Subheading;

use Ecjia\App\Theme\ThemeFramework\Foundation\Options;

/**
 *
 * Field: Sub Heading
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class Subheading extends Options
{
    protected $type = 'subheading';

    protected $default_field = [
        'content' => null,
    ];

    public function output()
    {

        echo $this->element_before();
        echo $this->field['content'];
        echo $this->element_after();

    }

}
