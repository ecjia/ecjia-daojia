<?php

namespace Ecjia\App\Theme\ThemeFramework\Fields\Wysiwyg;

use Ecjia\App\Theme\ThemeFramework\Foundation\Options;

/**
 *
 * Field: Wysiwyg
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class Wysiwyg extends Options
{
    protected $type = 'wysiwyg';

    protected $default_field = [
        'settings' => [], //An array of arguments.
    ];

    public function output()
    {

        echo $this->element_before();

        $defaults = array(
            'textarea_rows' => 10,
            'textarea_name' => $this->element_name()
        );

        $settings    = ( ! empty( $this->field['settings'] ) ) ? $this->field['settings'] : array();
        $settings    = rc_parse_args( $settings, $defaults );

        $field_id    = ( ! empty( $this->field['id'] ) ) ? $this->field['id'] : '';
        $field_value = $this->element_value();

        wp_editor( $field_value, $field_id, $settings );

        echo $this->element_after();

    }

}
