<?php namespace Royalcms\Component\Foundation;

use Royalcms\Component\Support\Facades\Hook;
use Royalcms\Component\Support\Format;

class Widget extends Object
{

    private static $widget_factory_instance = null;
    
    public function __construct()
    {
        self::instance();
    }
    
    /**
     * 返回当前终级类对象的实例
     *
     * @param $cache_config 缓存配置
     * @return object
     */
    public static function instance()
    {
        if (self::$widget_factory_instance === null) {
            self::$widget_factory_instance = new \Component_Widget_Factory();
        }
        return self::$widget_factory_instance;
    }

    /**
     * Register a widget
     *
     * Registers a RC_Widget widget
     *
     * @since 3.0.0
     *
     * @see RC_Widget
     * @see RC_Widget_Factory
     * @uses RC_Widget_Factory
     *
     * @param string $widget_class The name of a class that extends WP_Widget
     */
    public static function register_widget($widget_class) {
        self::instance()->register($widget_class);
    }
    
    /**
     * Unregister a widget
     *
     * Unregisters a RC_Widget widget. Useful for unregistering default widgets.
     * Run within a function hooked to the widgets_init action.
     *
     * @since 3.0.0
     *
     * @see RC_Widget
     * @see RC_Widget_Factory
     * @uses RC_Widget_Factory
     *
     * @param string $widget_class The name of a class that extends RC_Widget
     */
    public static function unregister_widget($widget_class) {
        self::instance()->unregister($widget_class);
    }
    
    
    public static $registered_widgets = array();
    
    public static $_deprecated_widgets_callbacks = array();
    
    /**
     * Register widget for use in sidebars.
     *
     * The default widget option is 'classname' that can be override.
     *
     * The function can also be used to unregister widgets when $output_callback
     * parameter is an empty string.
     *
     * @since 3.0.0
     *
     * @uses RC_Widget::$registered_widgets Uses stored registered widgets.
     * @uses RC_Widget::$register_widget_defaults Retrieves widget defaults.
     *
     * @param int|string $id Widget ID.
     * @param string $name Widget display title.
     * @param callback $output_callback Run when widget is called.
     * @param array|string $options Optional. Widget Options.
     * @param mixed $params,... Widget parameters to add to widget.
     * @return null Will return if $output_callback is empty after removing widget.
     */
    public static function register_sidebar_widget($id, $name, $output_callback, $options = array()) {
        $id = strtolower($id);
    
        if ( empty($output_callback) ) {
            unset(self::$registered_widgets[$id]);
            return;
        }
    
        $id_base = self::_get_widget_id_base($id);
        if ( in_array($output_callback, self::$_deprecated_widgets_callbacks, true) && !is_callable($output_callback) ) {
            if ( isset(self::$registered_widget_controls[$id]) ) {
                unset(self::$registered_widget_controls[$id]);
            }
    
            if ( isset(self::$registered_widget_updates[$id_base]) ) {
                unset(self::$registered_widget_updates[$id_base]);
            }  
    
            return;
        }
    
        $defaults = array('classname' => $output_callback);
        $options = rc_parse_args($options, $defaults);
        $widget = array(
            'name' => $name,
            'id' => $id,
            'callback' => $output_callback,
            'params' => array_slice(func_get_args(), 4)
        );
        $widget = array_merge($widget, $options);
    
        if ( is_callable($output_callback) && ( !isset(self::$registered_widgets[$id]) || Hook::did_action( 'widgets_init' ) ) ) {
    
            /**
             * Fires once for each registered widget.
             *
             * @since 3.0.0
             *
             * @param array $widget An array of default widget arguments.
             */
            Hook::do_action( 'register_sidebar_widget', $widget );
            self::$registered_widgets[$id] = $widget;
        }
    }
    
    
    /**
     * Private
     */
    public static function _get_widget_id_base($id) {
        return preg_replace( '/-[0-9]+$/', '', $id );
    }
    
    
    public static $registered_widget_updates = array();
    
    public static function _register_widget_update_callback($id_base, $update_callback, $options = array()) {
        if ( isset(self::$registered_widget_updates[$id_base]) ) {
            if ( empty($update_callback) ) {
                unset(self::$registered_widget_updates[$id_base]);
            }
                
            return;
        }
    
        $widget = array(
            'callback' => $update_callback,
            'params' => array_slice(func_get_args(), 3)
        );
    
        $widget = array_merge($widget, $options);
        self::$registered_widget_updates[$id_base] = $widget;
    }
    
    
    public static $registered_widget_controls = array();
    
    /**
     * Registers widget control callback for customizing options.
     *
     * The options contains the 'height', 'width', and 'id_base' keys. The 'height'
     * option is never used. The 'width' option is the width of the fully expanded
     * control form, but try hard to use the default width. The 'id_base' is for
     * multi-widgets (widgets which allow multiple instances such as the text
     * widget), an id_base must be provided. The widget id will end up looking like
     * {$id_base}-{$unique_number}.
     *
     * @since 3.0.0
     *
     * @param int|string $id Sidebar ID.
     * @param string $name Sidebar display name.
     * @param callback $control_callback Run when sidebar is displayed.
     * @param array|string $options Optional. Widget options. See above long description.
     * @param mixed $params,... Optional. Additional parameters to add to widget.
     */
    public static function register_widget_control($id, $name, $control_callback, $options = array()) {   
        $id = strtolower($id);
        $id_base = self::_get_widget_id_base($id);
    
        if ( empty($control_callback) ) {
            unset(self::$registered_widget_controls[$id]);
            unset(self::$registered_widget_updates[$id_base]);
            return;
        }
    
        if ( in_array($control_callback, self::$_deprecated_widgets_callbacks, true) && !is_callable($control_callback) ) {
            if ( isset(self::$registered_widgets[$id]) ) {
                unset(self::$registered_widgets[$id]);
            }
    
            return;
        }
    
        if ( isset(self::$registered_widget_controls[$id]) && !Hook::did_action( 'widgets_init' ) ) {
            return;
        }
    
        $defaults = array('width' => 250, 'height' => 200 ); // height is never used
        $options = rc_parse_args($options, $defaults);
        $options['width'] = (int) $options['width'];
        $options['height'] = (int) $options['height'];
    
        $widget = array(
            'name' => $name,
            'id' => $id,
            'callback' => $control_callback,
            'params' => array_slice(func_get_args(), 4)
        );
        $widget = array_merge($widget, $options);
    
        self::$registered_widget_controls[$id] = $widget;
    
        if ( isset(self::$registered_widget_updates[$id_base]) ) {
            return;
        }
    
        if ( isset($widget['params'][0]['number']) ) {
            $widget['params'][0]['number'] = -1;
        }  
    
        unset($widget['width'], $widget['height'], $widget['name'], $widget['id']);
        self::$registered_widget_updates[$id_base] = $widget;
    }
    
    public static function _register_widget_form_callback($id, $name, $form_callback, $options = array()) {
        $id = strtolower($id);
    
        if ( empty($form_callback) ) {
            unset(self::$registered_widget_controls[$id]);
            return;
        }
    
        if ( isset(self::$registered_widget_controls[$id]) && !Hook::did_action( 'widgets_init' ) ) {
            return;
        } 
    
        $defaults = array('width' => 250, 'height' => 200 );
        $options = rc_parse_args($options, $defaults);
        $options['width'] = (int) $options['width'];
        $options['height'] = (int) $options['height'];
    
        $widget = array(
            'name' => $name,
            'id' => $id,
            'callback' => $form_callback,
            'params' => array_slice(func_get_args(), 4)
        );
        $widget = array_merge($widget, $options);
    
        self::$registered_widget_controls[$id] = $widget;
    }
    
    
    
    /**
     * Retrieve description for widget.
     *
     * When registering widgets, the options can also include 'description' that
     * describes the widget for display on the widget administration panel or
     * in the theme.
     *
     * @since 3.0.0
     *
     * @param int|string $id Widget ID.
     * @return string Widget description, if available. Null on failure to retrieve description.
     */
    public static function widget_description( $id ) {
        if ( !is_scalar($id) ) {
            return;
        } 
    
        if ( isset(self::$registered_widgets[$id]['description']) ) {
            return Format::esc_html( self::$registered_widgets[$id]['description'] );
        }    
    }
    
    public static $registered_sidebars = array();
    
    /**
     * Retrieve description for a sidebar.
     *
     * When registering sidebars a 'description' parameter can be included that
     * describes the sidebar for display on the widget administration panel.
     *
     * @since 3.0.0
     *
     * @param int|string $id sidebar ID.
     * @return string Sidebar description, if available. Null on failure to retrieve description.
     */
    public static function sidebar_description( $id ) {
        if ( !is_scalar($id) ) {
            return;
        } 
    
        if ( isset(self::$registered_sidebars[$id]['description']) ) {
            return Format::esc_html( self::$registered_sidebars[$id]['description'] );
        }   
    }
    
    
    /**
     * Remove widget from sidebar.
     *
     * @since 3.0.0
     *
     * @param int|string $id Widget ID.
     */
    public static function unregister_sidebar_widget($id) {
    
        /**
         * Fires just before a widget is removed from a sidebar.
         *
         * @since 3.0.0
         *
         * @param int $id The widget ID.
         */
        Hook::do_action( 'unregister_sidebar_widget', $id );
    
        self::register_sidebar_widget($id, '', '');
        self::unregister_widget_control($id);
    }
    
    
    /**
     * Remove control callback for widget.
     *
     * @since 3.0.0
     * @uses wp_register_widget_control() Unregisters by using empty callback.
     *
     * @param int|string $id Widget ID.
     */
    public static function unregister_widget_control($id) {
        return self::register_widget_control($id, '', '');
    }
    
}

// end