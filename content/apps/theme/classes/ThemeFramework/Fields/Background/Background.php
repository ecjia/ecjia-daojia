<?php

namespace Ecjia\App\Theme\ThemeFramework\Fields\Background;

use Ecjia\App\Theme\ThemeFramework\Foundation\Options;
use Ecjia\App\Theme\ThemeFramework\Support\Helpers;

/**
 *
 * Field: Background
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class Background extends Options
{
    protected $type = 'background';

    protected $default_field = [
        'default' => [], //default value of field
        'image' => '', //default image value of field
        'repeat' => null, //default repeat value of field
        'attachment' => null, //default attachment value of field
        'size' => null, //default size value of field
        'color' => null, //default color value of field
    ];

    public function output()
    {

        echo $this->element_before();

        $value_defaults = array(
            'image'       => '',
            'repeat'      => '',
            'position'    => '',
            'attachment'  => '',
            'size'        => '',
            'color'       => '',
        );

        $this->value  = rc_parse_args( $this->element_value(), $value_defaults );

        if ( isset( $this->field['settings'] ) ) {
            extract( $this->field['settings'] );
        }

        $upload_type  = ( isset( $upload_type  ) ) ? $upload_type  : 'image';
        $button_title = ( isset( $button_title ) ) ? $button_title : __( 'Upload', 'cs-framework' );
        $frame_title  = ( isset( $frame_title  ) ) ? $frame_title  : __( 'Upload', 'cs-framework' );
        $insert_title = ( isset( $insert_title ) ) ? $insert_title : __( 'Use Image', 'cs-framework' );

        echo '<div class="cs-field-upload">';
        echo '<input type="text" name="'. $this->element_name( '[image]' ) .'" value="'. $this->value['image'] .'"'. $this->element_class() . $this->element_attributes() .'/>';
        echo '<a href="#" class="button cs-add" data-frame-title="'. $frame_title .'" data-upload-type="'. $upload_type .'" data-insert-title="'. $insert_title .'">'. $button_title .'</a>';
        echo '</div>';

        // background attributes
        echo '<fieldset>';
        echo Helpers::cs_add_element( array(
            'pseudo'          => true,
            'type'            => 'select',
            'name'            => $this->element_name( '[repeat]' ),
            'options'         => array(
              ''              => 'repeat',
              'repeat-x'      => 'repeat-x',
              'repeat-y'      => 'repeat-y',
              'no-repeat'     => 'no-repeat',
              'inherit'       => 'inherit',
            ),
            'attributes'      => array(
              'data-atts'     => 'repeat',
            ),
            'value'           => $this->value['repeat']
        ) );
        echo Helpers::cs_add_element( array(
            'pseudo'          => true,
            'type'            => 'select',
            'name'            => $this->element_name( '[position]' ),
            'options'         => array(
              ''              => 'left top',
              'left center'   => 'left center',
              'left bottom'   => 'left bottom',
              'right top'     => 'right top',
              'right center'  => 'right center',
              'right bottom'  => 'right bottom',
              'center top'    => 'center top',
              'center center' => 'center center',
              'center bottom' => 'center bottom'
            ),
            'attributes'      => array(
              'data-atts'     => 'position',
            ),
            'value'           => $this->value['position']
        ) );
        echo Helpers::cs_add_element( array(
            'pseudo'          => true,
            'type'            => 'select',
            'name'            => $this->element_name( '[attachment]' ),
            'options'         => array(
              ''              => 'scroll',
              'fixed'         => 'fixed',
            ),
            'attributes'      => array(
              'data-atts'     => 'attachment',
            ),
            'value'           => $this->value['attachment']
        ) );
        echo Helpers::cs_add_element( array(
            'pseudo'          => true,
            'type'            => 'select',
            'name'            => $this->element_name( '[size]' ),
            'options'         => array(
              ''              => 'size',
              'cover'         => 'cover',
              'contain'       => 'contain',
              'inherit'       => 'inherit',
              'initial'       => 'initial',
            ),
            'attributes'      => array(
              'data-atts'     => 'size',
            ),
            'value'           => $this->value['size']
        ) );
        echo Helpers::cs_add_element( array(
            'pseudo'          => true,
            'id'              => $this->field['id'].'_color',
            'type'            => 'color_picker',
            'name'            => $this->element_name('[color]'),
            'attributes'      => array(
              'data-atts'     => 'bgcolor',
            ),
            'value'           => $this->value['color'],
            'default'         => ( isset( $this->field['default']['color'] ) ) ? $this->field['default']['color'] : '',
            'rgba'            => ( isset( $this->field['rgba'] ) && $this->field['rgba'] === false ) ? false : '',
        ) );
        echo '</fieldset>';

        echo $this->element_after();

    }
}
