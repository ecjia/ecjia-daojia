<?php

namespace Royalcms\Component\Widget;

use RC_Hook;

/**
 * Singleton that registers and instantiates RC_Widget classes.
 *
 * @package Royalcms
 * @subpackage Widgets
 * @since 5.0.0
 */
class Factory
{
    /**
     * Widgets array.
     *
     * @since 5.0.0
     * @access public
     * @var array
     */
    protected $widgets = [];

    /**
     * Memory for the number of times unique class instances have been hashed.
     *
     * This can be eliminated in favor of straight spl_object_hash() when 5.3
     * is the minimum requirement for PHP.
     *
     * @since 5.0.0
     * @access private
     * @var array
     *
     * @see Factory::hash_object()
     */
    private $hashed_class_counts = [];

    public function __construct()
    {
        RC_Hook::add_action( 'widgets_init', array( $this, '_register_widgets' ), 100 );
    }

    public function getWidget($widget = null)
    {
        if (is_null($widget)) {
            return $this->widgets;
        } else {
            if (isset($this->widgets[$widget])) {
                return $this->widgets[$widget];
            } else {
                return null;
            }
        }
    }

    /**
     * Hashes an object, doing fallback of `spl_object_hash()` if not available.
     *
     * This can be eliminated in favor of straight spl_object_hash() when 5.3
     * is the minimum requirement for PHP.
     *
     * @since 5.0.0
     * @access private
     *
     * @param Widget $widget Widget.
     * @return string Object hash.
     */
    private function hash_object( $widget )
    {
        if ( function_exists( 'spl_object_hash' ) ) {
            return spl_object_hash( $widget );
        } else {
            $class_name = get_class( $widget );
            $hash = $class_name;
            if ( ! isset( $widget->_widget_factory_hash_id ) ) {
                if ( ! isset( $this->hashed_class_counts[ $class_name ] ) ) {
                    $this->hashed_class_counts[ $class_name ] = 0;
                }
                $this->hashed_class_counts[ $class_name ] += 1;
                $widget->_widget_factory_hash_id = $this->hashed_class_counts[ $class_name ];
            }
            $hash .= ':' . $widget->_widget_factory_hash_id;
            return $hash;
        }
    }

    /**
     * Registers a widget subclass.
     *
     * @since 5.0.0 Updated the `$widget` parameter to also accept a Widget instance object
     *              instead of simply a `Widget` subclass name.
     * @access public
     *
     * @param string|Widget $widget Either the name of a `Widget` subclass or an instance of a `Widget` subclass.
     */
    public function register($widget)
    {
        if ( $widget instanceof Widget ) {
            $this->widgets[ $this->hash_object( $widget ) ] = $widget;
        } else {
            $this->widgets[ $widget ] = new $widget();
        }
    }

    /**
     * Un-registers a widget subclass.
     *
     * @since 5.0.0 Updated the `$widget` parameter to also accept a Widget instance object
     *              instead of simply a `Widget` subclass name.
     * @access public
     *
     * @param string|Widget $widget Either the name of a `Widget` subclass or an instance of a `Widget` subclass.
     */
    public function unregister($widget)
    {
        if ( $widget instanceof Widget ) {
            unset( $this->widgets[ $this->hash_object( $widget ) ] );
        } else {
            unset( $this->widgets[ $widget ] );
        }
    }


    /**
     * Serves as a utility method for adding widgets to the registered widgets global.
     *
     * @since 2.8.0
     * @access public
     *
     * @global array $registered_widgets
     */
    public function _registerWidgets()
    {
        $widgetManager = royalcms('widget');

        $registered = array_keys($widgetManager->getRegisteredWidgets());
        $registered = array_map(array($widgetManager, 'getWidgetIdBase'), $registered);

        $keys = array_keys($this->widgets);
        foreach ( $keys as $key ) {
            // don't register new widget if old widget with the same id is already registered
            if ( in_array($this->widgets[$key]->getIdBase(), $registered, true) ) {
                unset($this->widgets[$key]);
                continue;
            }

            $this->widgets[$key]->_register();
        }
    }
}


// end