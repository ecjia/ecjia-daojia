<?php

namespace Ecjia\App\Theme\ThemeFramework\Fields\Group;

use Ecjia\App\Theme\ThemeFramework\Foundation\Options;
use Ecjia\App\Theme\ThemeFramework\Support\Helpers;

/**
 *
 * Field: Group
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class Group extends Options
{
    protected $type = 'group';

    protected $default_field = [
        'default' => [], //default value for group field
        'button_title' => '', //button title of group field
        'accordion_title' => '', //accordion title of group field or use ID of the field
        'default' => [], //fields of group field this is inside fields of field
    ];

    public function output()
    {

        echo $this->element_before();

        $last_id     = ( is_array( $this->value ) ) ? max( array_keys( $this->value ) ) : 0;
        $acc_title   = ( isset( $this->field['accordion_title'] ) ) ? $this->field['accordion_title'] : __( 'Adding', 'cs-framework' );
        $field_title = ( isset( $this->field['fields'][0]['title'] ) ) ? $this->field['fields'][0]['title'] : $this->field['fields'][1]['title'];
        $field_id    = ( isset( $this->field['fields'][0]['id'] ) ) ? $this->field['fields'][0]['id'] : $this->field['fields'][1]['id'];
        $search_id   = cs_array_search( $this->field['fields'], 'id', $acc_title );

        if( ! empty( $search_id ) ) {

            $acc_title = ( isset( $search_id[0]['title'] ) ) ? $search_id[0]['title'] : $acc_title;
            $field_id  = ( isset( $search_id[0]['id'] ) ) ? $search_id[0]['id'] : $field_id;

        }

        echo '<div class="cs-group hidden">';

        echo '<h4 class="cs-group-title">'. $acc_title .'</h4>';
        echo '<div class="cs-group-content">';
        foreach ( $this->field['fields'] as $field_key => $field ) {
            $field['sub']   = true;
            $unique         = $this->unique .'[_nonce]['. $this->field['id'] .']['. $last_id .']';
            $field_default  = ( isset( $field['default'] ) ) ? $field['default'] : '';
            echo Helpers::cs_add_element( $field, $field_default, $unique );
        }
        echo '<div class="cs-element cs-text-right"><a href="#" class="button cs-warning-primary cs-remove-group">'. __( 'Remove', 'cs-framework' ) .'</a></div>';
        echo '</div>';

        echo '</div>';

        echo '<div class="cs-groups cs-accordion">';

        if ( ! empty( $this->value ) ) {

            foreach ( $this->value as $key => $value ) {

                $title = ( isset( $this->value[$key][$field_id] ) ) ? $this->value[$key][$field_id] : '';

                if ( is_array( $title ) && isset( $this->multilang ) ) {
                    $lang  = cs_language_defaults();
                    $title = $title[$lang['current']];
                    $title = is_array( $title ) ? $title[0] : $title;
                }

                $field_title = ( ! empty( $search_id ) ) ? $acc_title : $field_title;

                echo '<div class="cs-group">';
                echo '<h4 class="cs-group-title">'. $field_title .': '. $title .'</h4>';
                echo '<div class="cs-group-content">';

                foreach ( $this->field['fields'] as $field_key => $field ) {
                    $field['sub'] = true;
                    $unique = $this->unique . '[' . $this->field['id'] . ']['.$key.']';
                    $value  = ( isset( $field['id'] ) && isset( $this->value[$key][$field['id']] ) ) ? $this->value[$key][$field['id']] : '';
                    echo Helpers::cs_add_element( $field, $value, $unique );
                }

                echo '<div class="cs-element cs-text-right"><a href="#" class="button cs-warning-primary cs-remove-group">'. __( 'Remove', 'cs-framework' ) .'</a></div>';
                echo '</div>';
                echo '</div>';

            }

        }

        echo '</div>';

        echo '<a href="#" class="button button-primary cs-add-group">'. $this->field['button_title'] .'</a>';

        echo $this->element_after();

    }

}
