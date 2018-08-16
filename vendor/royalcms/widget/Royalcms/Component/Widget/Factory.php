<?php

namespace Royalcms\Component\Widget;

/**
 * Singleton that registers and instantiates RC_Widget classes.
 *
 * @package Royalcms
 * @subpackage Widgets
 * @since 2.8.0
 */
class Factory
{
    var $widgets = array();

    function __construct() {
        RC_Hook::add_action( 'widgets_init', array( $this, '_register_widgets' ), 100 );
    }

    function register($widget_class) {
        $this->widgets[$widget_class] = new $widget_class();
    }

    function unregister($widget_class) {
        if ( isset($this->widgets[$widget_class]) )
            unset($this->widgets[$widget_class]);
    }

    function _register_widgets() {
//         global $wp_registered_widgets;
        $keys = array_keys($this->widgets);
        $registered = array_keys(RC_Widget::$registered_widgets);
        $registered = array_map(array('RC_Widget', '_get_widget_id_base'), $registered);

        foreach ( $keys as $key ) {
            // don't register new widget if old widget with the same id is already registered
            if ( in_array($this->widgets[$key]->id_base, $registered, true) ) {
                unset($this->widgets[$key]);
                continue;
            }

            $this->widgets[$key]->_register();
        }
    }
}


// end