<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/23
 * Time: 14:08
 */

namespace Ecjia\App\Theme\ThemeFramework;


class OptionField
{

    protected $framework;

    protected $fields = [];

    protected $current;

    public function __construct($framework)
    {
        $this->framework = $framework;
        $this->fields = config('app-theme::fields');

    }


    public function getFeildClass($type)
    {
        return array_get($this->fields, $type);
    }


    /**
     *
     * Add framework element
     *
     * @since 1.0.0
     * @version 1.0.0
     *
     */
    public function addElement($field = array(), $value = '', $unique = '')
    {
        $output     = '';
        $depend     = '';
        $sub        = ( isset( $field['sub'] ) ) ? 'sub-': '';
        $unique     = ( isset( $unique ) ) ? $unique : '';
        $languages  = $this->framework->language_defaults();
        $class      = $this->getFeildClass($field['type']);
        $wrap_class = ( isset( $field['wrap_class'] ) ) ? ' ' . $field['wrap_class'] : '';
        $hidden     = ( isset( $field['show_only_language'] ) && ( $field['show_only_language'] != $languages['current'] ) ) ? ' hidden' : '';
        $is_pseudo  = ( isset( $field['pseudo'] ) ) ? ' cs-pseudo-field' : '';

        if ( isset( $field['dependency'] ) ) {
            $hidden  = ' hidden';
            $depend .= ' data-'. $sub .'controller="'. $field['dependency'][0] .'"';
            $depend .= ' data-'. $sub .'condition="'. $field['dependency'][1] .'"';
            $depend .= ' data-'. $sub .'value="'. $field['dependency'][2] .'"';
        }

        $output .= '<div class="cs-element cs-field-'. $field['type'] . $is_pseudo . $wrap_class . $hidden .'"'. $depend .'>';

        if ( isset( $field['title'] ) ) {
            $field_desc = ( isset( $field['desc'] ) ) ? '<p class="cs-text-desc">'. $field['desc'] .'</p>' : '';
            $output .= '<div class="cs-title"><h4>' . $field['title'] . '</h4>'. $field_desc .'</div>';
        }

        $output .= ( isset( $field['title'] ) ) ? '<div class="cs-fieldset">' : '';

        $value   = ( !isset( $value ) && isset( $field['default'] ) ) ? $field['default'] : $value;
        $value   = ( isset( $field['value'] ) ) ? $field['value'] : $value;

        if ( class_exists( $class ) ) {
            ob_start();
            $element = new $class( $field, $value, $unique );
            $element->output();
            $output .= ob_get_clean();
        } else {
            $output .= '<p>'. __( 'This field class is not available!', 'theme-framework' ) .'</p>';
        }

        $output .= ( isset( $field['title'] ) ) ? '</div>' : '';
        $output .= '<div class="clear"></div>';
        $output .= '</div>';

        return $output;

    }


}