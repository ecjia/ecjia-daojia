<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/9/6
 * Time: 1:22 PM
 */

namespace Royalcms\Component\Widget;

use RC_Hook;
use RC_Format;

class WidgetManager
{
    /**
     * @var Factory
     */
    protected $widgetFactory;

    /**
     * @var array
     */
    protected $registeredWidgets = [];

    /**
     * @var array
     */
    protected $_deprecatedWidgetsCallbacks = [];

    /**
     * @var array
     */
    protected $registeredWidgetControls = [];

    /**
     * @var array
     */
    protected $registeredWidgetUpdates = [];

    /**
     * @var array
     */
    protected $registeredSidebars = [];

    /**
     * @var array
     */
    protected $sidebarsWidgets = [];


    public function __construct()
    {
        if ($this->widgetFactory == null) {
            $this->widgetFactory = new Factory();
        }
    }

    /**
     * 返回当前终级类对象的实例
     *
     * @return Factory
     */
    public function getWidgetFactory()
    {
        return $this->widgetFactory;
    }


    /**
     * Retrieve description for widget.
     *
     * When registering widgets, the options can also include 'description' that
     * describes the widget for display on the widget administration panel or
     * in the theme.
     *
     * @since 5.0.0
     *
     * @param int|string $id Widget ID.
     * @return string Widget description, if available. Null on failure to retrieve description.
     */
    public function widgetDescription($id)
    {
        if ( !is_scalar($id) ) {
            return null;
        }

        if ( isset( $this->registeredWidgets[$id]['description'] ) ) {
            return RC_Format::esc_html( $this->registeredWidgets[$id]['description'] );
        }
    }

    /**
     * Register a widget
     *
     * Registers a RC_Widget widget
     *
     * @since 5.0.0
     *
     * @param string $widget_class The name of a class that extends RC_Widget
     */
    public function registerWidget($widgetClass)
    {
        $this->getWidgetFactory()->register($widgetClass);
    }

    /**
     * Unregister a widget
     *
     * Unregisters a RC_Widget widget. Useful for unregistering default widgets.
     * Run within a function hooked to the widgets_init action.
     *
     * @since 5.0.0
     *
     * @param string $widget_class The name of a class that extends RC_Widget
     */
    public function unregisterWidget($widgetClass)
    {
        $this->getWidgetFactory()->unregister($widgetClass);
    }


    /**
     * Whether widget is displayed on the front end.
     *
     * Either $callback or $id_base can be used
     * $id_base is the first argument when extending WP_Widget class
     * Without the optional $widget_id parameter, returns the ID of the first sidebar
     * in which the first instance of the widget with the given callback or $id_base is found.
     * With the $widget_id parameter, returns the ID of the sidebar where
     * the widget with that callback/$id_base AND that ID is found.
     *
     * NOTE: $widget_id and $id_base are the same for single widgets. To be effective
     * this function has to run after widgets have initialized, at action {@see 'init'} or later.
     *
     * @since 5.0.0
     *
     * @param string|false $callback      Optional, Widget callback to check. Default false.
     * @param int|false    $widget_id     Optional. Widget ID. Optional, but needed for checking. Default false.
     * @param string|false $id_base       Optional. The base ID of a widget created by extending WP_Widget. Default false.
     * @param bool         $skip_inactive Optional. Whether to check in 'wp_inactive_widgets'. Default true.
     * @return string|false False if widget is not active or id of sidebar in which the widget is active.
     */
    public function isActiveWidget($callback = false, $widget_id = false, $id_base = false, $skip_inactive = true)
    {
        $sidebars_widgets = $this->getSidebarsWidgets();

        if ( is_array($sidebars_widgets) ) {
            foreach ( $sidebars_widgets as $sidebar => $widgets ) {
                if ( $skip_inactive && ( 'inactive_widgets' === $sidebar || 'orphaned_widgets' === substr( $sidebar, 0, 16 ) ) ) {
                    continue;
                }

                if ( is_array($widgets) ) {
                    foreach ( $widgets as $widget ) {
                        if ( ( $callback && isset($this->registeredWidgets[$widget]['callback']) && $this->registeredWidgets[$widget]['callback'] == $callback ) || ( $id_base && $this->getWidgetIdBase($widget) == $id_base ) ) {
                            if ( !$widget_id || $widget_id == $this->registeredWidgets[$widget]['id'] )
                                return $sidebar;
                        }
                    }
                }
            }
        }
        return false;
    }


    public function getRegisteredWidgets()
    {
        return $this->registeredWidgets;
    }


    /**
     * Creates multiple sidebars.
     *
     * If you wanted to quickly create multiple sidebars for a theme or internally.
     * This function will allow you to do so. If you don't pass the 'name' and/or
     * 'id' in `$args`, then they will be built for you.
     *
     * @since 5.0.0
     *
     * @see register_sidebar() The second parameter is documented by register_sidebar() and is the same here.
     *
     * @global array $wp_registered_sidebars
     *
     * @param int          $number Optional. Number of sidebars to create. Default 1.
     * @param array|string $args {
     *     Optional. Array or string of arguments for building a sidebar.
     *
     *     @type string $id   The base string of the unique identifier for each sidebar. If provided, and multiple
     *                        sidebars are being defined, the id will have "-2" appended, and so on.
     *                        Default 'sidebar-' followed by the number the sidebar creation is currently at.
     *     @type string $name The name or title for the sidebars displayed in the admin dashboard. If registering
     *                        more than one sidebar, include '%d' in the string as a placeholder for the uniquely
     *                        assigned number for each sidebar.
     *                        Default 'Sidebar' for the first sidebar, otherwise 'Sidebar %d'.
     * }
     */
    public function registerSidebars($number = 1, $args = array())
    {
        $number = (int) $number;

        if ( is_string($args) ) {
            parse_str($args, $args);
        }

        for ( $i = 1; $i <= $number; $i++ ) {
            $_args = $args;

            if ( $number > 1 )
                $_args['name'] = isset($args['name']) ? sprintf($args['name'], $i) : sprintf(__('Sidebar %d'), $i);
            else
                $_args['name'] = isset($args['name']) ? $args['name'] : __('Sidebar');


            // Custom specified ID's are suffixed if they exist already.
            // Automatically generated sidebar names need to be suffixed regardless starting at -0
            if ( isset($args['id']) ) {
                $_args['id'] = $args['id'];
                $n = 2; // Start at -2 for conflicting custom ID's
                while ( $this->isRegisteredSidebar( $_args['id'] ) ) {
                    $_args['id'] = $args['id'] . '-' . $n++;
                }
            } else {
                $n = count( $this->registeredSidebars );
                do {
                    $_args['id'] = 'sidebar-' . ++$n;
                } while ( $this->isRegisteredSidebar( $_args['id'] ) );
            }

            $this->registerSidebar($_args);

        }

    }


    /**
     * Builds the definition for a single sidebar and returns the ID.
     *
     * Accepts either a string or an array and then parses that against a set
     * of default arguments for the new sidebar. WordPress will automatically
     * generate a sidebar ID and name based on the current number of registered
     * sidebars if those arguments are not included.
     *
     * When allowing for automatic generation of the name and ID parameters, keep
     * in mind that the incrementor for your sidebar can change over time depending
     * on what other plugins and themes are installed.
     *
     * If theme support for 'widgets' has not yet been added when this function is
     * called, it will be automatically enabled through the use of add_theme_support()
     *
     * @since 5.0.0
     *
     * @global array $wp_registered_sidebars Stores the new sidebar in this array by sidebar ID.
     *
     * @param array|string $args {
     *     Optional. Array or string of arguments for the sidebar being registered.
     *
     *     @type string $name          The name or title of the sidebar displayed in the Widgets
     *                                 interface. Default 'Sidebar $instance'.
     *     @type string $id            The unique identifier by which the sidebar will be called.
     *                                 Default 'sidebar-$instance'.
     *     @type string $description   Description of the sidebar, displayed in the Widgets interface.
     *                                 Default empty string.
     *     @type string $class         Extra CSS class to assign to the sidebar in the Widgets interface.
     *                                 Default empty.
     *     @type string $before_widget HTML content to prepend to each widget's HTML output when
     *                                 assigned to this sidebar. Default is an opening list item element.
     *     @type string $after_widget  HTML content to append to each widget's HTML output when
     *                                 assigned to this sidebar. Default is a closing list item element.
     *     @type string $before_title  HTML content to prepend to the sidebar title when displayed.
     *                                 Default is an opening h2 element.
     *     @type string $after_title   HTML content to append to the sidebar title when displayed.
     *                                 Default is a closing h2 element.
     * }
     * @return string Sidebar ID added to $wp_registered_sidebars global.
     */
    public function registerSidebar($args = array())
    {
        $i = count($this->registeredSidebars) + 1;

        $id_is_empty = empty( $args['id'] );

        $defaults = array(
            'name' => sprintf(__('Sidebar %d'), $i ),
            'id' => "sidebar-$i",
            'description' => '',
            'class' => '',
            'before_widget' => '<li id="%1$s" class="widget %2$s">',
            'after_widget' => "</li>\n",
            'before_title' => '<h2 class="widgettitle">',
            'after_title' => "</h2>\n",
        );

        $sidebar = rc_parse_args( $args, $defaults );

        if ( $id_is_empty ) {
            /* translators: 1: the id argument, 2: sidebar name, 3: recommended id value */
            _doing_it_wrong( __FUNCTION__, sprintf( __( 'No %1$s was set in the arguments array for the "%2$s" sidebar. Defaulting to "%3$s". Manually set the %1$s to "%3$s" to silence this notice and keep existing sidebar content.' ), '<code>id</code>', $sidebar['name'], $sidebar['id'] ), '5.0.0' );
        }

        $this->registeredSidebars[$sidebar['id']] = $sidebar;

        /**
         * Fires once a sidebar has been registered.
         *
         * @since 3.0.0
         *
         * @param array $sidebar Parsed arguments for the registered sidebar.
         */
        RC_Hook::do_action( 'register_sidebar', $sidebar );

        return $sidebar['id'];
    }

    /**
     * Removes a sidebar from the list.
     *
     * @since 5.0.0
     *
     * @global array $wp_registered_sidebars Stores the new sidebar in this array by sidebar ID.
     *
     * @param string $name The ID of the sidebar when it was added.
     */
    public function unregisterSidebar($name)
    {
        unset($this->registeredSidebars[$name]);
    }

    /**
     * Checks if a sidebar is registered.
     *
     * @since 5.0.0
     *
     * @global array $registered_sidebars Registered sidebars.
     *
     * @param string|int $sidebar_id The ID of the sidebar when it was registered.
     * @return bool True if the sidebar is registered, false otherwise.
     */
    public function isRegisteredSidebar($sidebar_id)
    {
        return isset($this->registeredSidebars[$sidebar_id]);
    }


    /**
     * Whether a sidebar is in use.
     *
     * @since 5.0.0
     *
     * @param string|int $index Sidebar name, id or number to check.
     * @return bool true if the sidebar is in use, false otherwise.
     */
    public function isActiveSidebar($index)
    {
        $index = ( is_int($index) ) ? "sidebar-$index" : RC_Format::sanitize_title($index);
        $sidebars_widgets = $this->getSidebarsWidgets();
        $is_active_sidebar = ! empty( $sidebars_widgets[$index] );

        /**
         * Filters whether a dynamic sidebar is considered "active".
         *
         * @since 3.9.0
         *
         * @param bool       $is_active_sidebar Whether or not the sidebar should be considered "active".
         *                                      In other words, whether the sidebar contains any widgets.
         * @param int|string $index             Index, name, or ID of the dynamic sidebar.
         */
        return RC_Hook::apply_filters( 'is_active_sidebar', $is_active_sidebar, $index );
    }


    /**
     * Retrieve description for a sidebar.
     *
     * When registering sidebars a 'description' parameter can be included that
     * describes the sidebar for display on the widget administration panel.
     *
     * @since 5.0.0
     *
     * @param int|string $id sidebar ID.
     * @return string Sidebar description, if available. Null on failure to retrieve description.
     */
    public function sidebarDescription($id)
    {
        if ( !is_scalar($id) ) {
            return null;
        }

        if ( isset($this->registeredSidebars[$id]['description']) ) {
            return RC_Format::esc_html( $this->registeredSidebars[$id]['description'] );
        }

    }


    /**
     * Register widget for use in sidebars.
     *
     * The default widget option is 'classname' that can be override.
     *
     * The function can also be used to unregister widgets when $output_callback
     * parameter is an empty string.
     *
     * @since 5.0.0
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
    public function registerSidebarWidget($id, $name, $output_callback, $options = [])
    {
        $id = strtolower($id);

        if ( empty($output_callback) ) {
            unset($this->registeredWidgets[$id]);
            return null;
        }

        $id_base = $this->getWidgetIdBase($id);

        if (in_array($output_callback, $this->_deprecatedWidgetsCallbacks, true)
            && ! is_callable($output_callback) ) {
            if (isset($this->registeredWidgetControls[$id])) {
                unset($this->registeredWidgetControls[$id]);
            }

            if (isset($this->registeredWidgetUpdates[$id_base])) {
                unset($this->registeredWidgetUpdates[$id_base]);
            }

            return null;
        }

        $defaults = [
            'classname' => $output_callback,
        ];

        $options = rc_parse_args($options, $defaults);

        $widget = [
            'name' => $name,
            'id' => $id,
            'callback' => $output_callback,
            'params' => array_slice(func_get_args(), 4),
        ];
        $widget = array_merge($widget, $options);

        if ( is_callable($output_callback)
            && ( ! isset($this->registeredWidgets[$id]) || RC_Hook::did_action('widgets_init') ) ) {
            /**
             * Fires once for each registered widget.
             *
             * @since 3.0.0
             *
             * @param array $widget An array of default widget arguments.
             */
            RC_Hook::do_action( 'register_sidebar_widget', $widget );

            $this->registeredWidgets[$id] = $widget;
        }
    }

    /**
     * Remove widget from sidebar.
     *
     * @since 5.0.0
     *
     * @param int|string $id Widget ID.
     */
    public function unregisterSidebarWidget($id)
    {
        /**
         * Fires just before a widget is removed from a sidebar.
         *
         * @since 5.0.0
         *
         * @param int $id The widget ID.
         */
        RC_Hook::do_action( 'unregister_sidebar_widget', $id );

        $this->registerSidebarWidget($id, null, null);

        $this->unregisterWidgetControl($id);
    }

    public function getRegisteredSidebars()
    {
        return $this->registeredSidebars;
    }


    /**
     * Retrieve full list of sidebars and their widget instance IDs.
     *
     * Will upgrade sidebar widget list, if needed. Will also save updated list, if
     * needed.
     *
     * @since 5.0.0
     * @access private
     *
     * @return array Upgraded list of widgets to version 3 array format when called from the admin.
     */
    public function getSidebarsWidgets()
    {
        if ( is_array( $this->sidebarsWidgets ) && isset($this->sidebarsWidgets['array_version']) )
            unset($this->sidebarsWidgets['array_version']);

        /**
         * Filters the list of sidebars and their widgets.
         *
         * @since 2.7.0
         *
         * @param array $sidebars_widgets An associative array of sidebars and their widgets.
         */
        return apply_filters( 'sidebars_widgets', $this->sidebarsWidgets );
    }

    /**
     * Set the sidebar widget option to update sidebars.
     *
     * @since 5.0.0
     * @access private
     *
     * @param array $sidebars_widgets Sidebar widgets and their settings.
     */
    public function setSidebarsWidgets(array $sidebars_widgets = [])
    {
        if ( !isset( $sidebars_widgets['array_version'] ) )
            $sidebars_widgets['array_version'] = 3;

        $this->sidebarsWidgets = $sidebars_widgets;
    }


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
     * @since 5.0.0
     *
     * @param int|string $id Sidebar ID.
     * @param string $name Sidebar display name.
     * @param callback $control_callback Run when sidebar is displayed.
     * @param array|string $options Optional. Widget options. See above long description.
     * @param mixed $params,... Optional. Additional parameters to add to widget.
     */
    public function registerWidgetControl($id, $name, $control_callback, $options = [])
    {
        $id = strtolower($id);
        $id_base = $this->getWidgetIdBase($id);

        if ( empty($control_callback) ) {
            unset($this->registeredWidgetControls[$id]);
            unset($this->registeredWidgetUpdates[$id_base]);

            return null;
        }

        if (in_array($control_callback, $this->_deprecatedWidgetsCallbacks, true)
            && ! is_callable($control_callback) )
        {
            if (isset($this->registeredWidgets[$id])) {
                unset($this->registeredWidgets[$id]);
            }

            return null;
        }

        if (isset($this->registeredWidgetControls[$id])
            && ! RC_Hook::did_action('widgets_init')) {
            return null;
        }

        // height is never used
        $defaults = [
            'width' => 250,
            'height' => 200,
        ];

        $options = rc_parse_args($options, $defaults);
        $options['width'] = (int)$options['width'];
        $options['height'] = (int)$options['height'];

        $widget = [
            'name' => $name,
            'id' => $id,
            'callback' => $control_callback,
            'params' => array_slice(func_get_args(), 4),
        ];
        $widget = array_merge(func_get_args(), $options);

        $this->registeredWidgetControls[$id] = $widget;

        if (isset($this->registeredWidgetUpdates[$id_base])) {
            return null;
        }


        if (isset($widget['params'][0]['number'])) {
            $widget['params'][0]['number'] = -1;
        }

        unset($widget['width'], $widget['height'], $widget['name'], $widget['id']);

        $this->registeredWidgetUpdates[$id_base] = $widget;
    }

    /**
     * Remove control callback for widget.
     *
     * @since 5.0.0
     * @uses rc_register_widget_control() Unregisters by using empty callback.
     *
     * @param int|string $id Widget ID.
     */
    public function unregisterWidgetControl($id)
    {
        return $this->registerWidgetControl($id, null, null);
    }

    public function getRegisteredWidgetControls()
    {
        return $this->registeredWidgetControls;
    }


    public function getWidgetIdBase($id)
    {
        return preg_replace( '/-[0-9]+$/', '', $id );
    }

    private function _registerWidgetUpdateCallback($id_base, $update_callback, $options = [])
    {
        if ( isset($this->registeredWidgetUpdates[$id_base]) ) {
            if (empty($update_callback)) {
                unset($this->registeredWidgetUpdates[$id_base]);
            }

            return null;
        }

        $widget = [
            'callback' => $update_callback,
            'params' => array_slice(func_get_args(), 3),
        ];

        $widget = array_merge($widget, $options);

        $this->registeredWidgetUpdates[$id_base] = $widget;
    }

    /**
     * Registers the form callback for a widget.
     *
     * @since 5.0.0
     *
     * @global array $registered_widget_controls
     *
     * @param int|string $id            Widget ID.
     * @param string     $name          Name attribute for the widget.
     * @param callable   $form_callback Form callback.
     * @param array      $options       Optional. Widget control options. See register_widget_control().
     *                                  Default empty array.
     */
    private function _registerWidgetFormCallback($id, $name, $form_callback, $options = array())
    {
        $id = strtolower($id);

        if ( empty($form_callback) ) {
            unset($this->registeredWidgetControls[$id]);
            return;
        }

        if ( isset($this->registeredWidgetControls[$id])
            && ! RC_Hook::did_action( 'widgets_init' ) ) {
            return null;
        }

        $defaults = array(
            'width' => 250,
            'height' => 200
        );
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

        $this->registeredWidgetControls[$id] = $widget;
    }


    /**
     * Display dynamic sidebar.
     *
     * By default this displays the default sidebar or 'sidebar-1'. If your theme specifies the 'id' or
     * 'name' parameter for its registered sidebars you can pass an id or name as the $index parameter.
     * Otherwise, you can pass in a numerical index to display the sidebar at that index.
     *
     * @since 5.0.0
     *
     * @global array $registered_sidebars
     * @global array $registered_widgets
     *
     * @param int|string $index Optional, default is 1. Index, name or ID of dynamic sidebar.
     * @return bool True, if widget sidebar was found and called. False if not found or not called.
     */
    public function dynamicSidebar($index = 1)
    {
        if ( is_int( $index ) ) {
            $index = "sidebar-$index";
        } else {
            $index = RC_Format::sanitize_title( $index );
            foreach ( (array) $this->registeredSidebars as $key => $value ) {
                if ( RC_Format::sanitize_title( $value['name'] ) == $index ) {
                    $index = $key;
                    break;
                }
            }
        }

        $sidebars_widgets = $this->getSidebarsWidgets();
        if ( empty( $this->registeredSidebars[ $index ] ) || empty( $sidebars_widgets[ $index ] ) || ! is_array( $sidebars_widgets[ $index ] ) ) {
            /** This action is documented in wp-includes/widget.php */
            RC_Hook::do_action( 'dynamic_sidebar_before', $index, false );
            /** This action is documented in wp-includes/widget.php */
            RC_Hook::do_action( 'dynamic_sidebar_after',  $index, false );
            /** This filter is documented in wp-includes/widget.php */
            return RC_Hook::apply_filters( 'dynamic_sidebar_has_widgets', false, $index );
        }

        /**
         * Fires before widgets are rendered in a dynamic sidebar.
         *
         * Note: The action also fires for empty sidebars, and on both the front end
         * and back end, including the Inactive Widgets sidebar on the Widgets screen.
         *
         * @since 3.9.0
         *
         * @param int|string $index       Index, name, or ID of the dynamic sidebar.
         * @param bool       $has_widgets Whether the sidebar is populated with widgets.
         *                                Default true.
         */
        RC_Hook::do_action( 'dynamic_sidebar_before', $index, true );
        $sidebar = $this->registeredSidebars[$index];

        $did_one = false;
        foreach ( (array) $sidebars_widgets[$index] as $id ) {

            if ( !isset($wp_registered_widgets[$id]) ) continue;

            $params = array_merge(
                array( array_merge( $sidebar, array('widget_id' => $id, 'widget_name' => $this->registeredWidgets[$id]['name']) ) ),
                (array) $this->registeredWidgets[$id]['params']
            );

            // Substitute HTML id and class attributes into before_widget
            $classname_ = '';
            foreach ( (array) $this->registeredWidgets[$id]['classname'] as $cn ) {
                if ( is_string($cn) )
                    $classname_ .= '_' . $cn;
                elseif ( is_object($cn) )
                    $classname_ .= '_' . get_class($cn);
            }
            $classname_ = ltrim($classname_, '_');
            $params[0]['before_widget'] = sprintf($params[0]['before_widget'], $id, $classname_);

            /**
             * Filters the parameters passed to a widget's display callback.
             *
             * Note: The filter is evaluated on both the front end and back end,
             * including for the Inactive Widgets sidebar on the Widgets screen.
             *
             * @since 2.5.0
             *
             * @see register_sidebar()
             *
             * @param array $params {
             *     @type array $args  {
             *         An array of widget display arguments.
             *
             *         @type string $name          Name of the sidebar the widget is assigned to.
             *         @type string $id            ID of the sidebar the widget is assigned to.
             *         @type string $description   The sidebar description.
             *         @type string $class         CSS class applied to the sidebar container.
             *         @type string $before_widget HTML markup to prepend to each widget in the sidebar.
             *         @type string $after_widget  HTML markup to append to each widget in the sidebar.
             *         @type string $before_title  HTML markup to prepend to the widget title when displayed.
             *         @type string $after_title   HTML markup to append to the widget title when displayed.
             *         @type string $widget_id     ID of the widget.
             *         @type string $widget_name   Name of the widget.
             *     }
             *     @type array $widget_args {
             *         An array of multi-widget arguments.
             *
             *         @type int $number Number increment used for multiples of the same widget.
             *     }
             * }
             */
            $params = RC_Hook::apply_filters( 'dynamic_sidebar_params', $params );

            $callback = $this->registeredWidgets[$id]['callback'];

            /**
             * Fires before a widget's display callback is called.
             *
             * Note: The action fires on both the front end and back end, including
             * for widgets in the Inactive Widgets sidebar on the Widgets screen.
             *
             * The action is not fired for empty sidebars.
             *
             * @since 3.0.0
             *
             * @param array $widget_id {
             *     An associative array of widget arguments.
             *
             *     @type string $name                Name of the widget.
             *     @type string $id                  Widget ID.
             *     @type array|callable $callback    When the hook is fired on the front end, $callback is an array
             *                                       containing the widget object. Fired on the back end, $callback
             *                                       is 'wp_widget_control', see $_callback.
             *     @type array          $params      An associative array of multi-widget arguments.
             *     @type string         $classname   CSS class applied to the widget container.
             *     @type string         $description The widget description.
             *     @type array          $_callback   When the hook is fired on the back end, $_callback is populated
             *                                       with an array containing the widget object, see $callback.
             * }
             */
            RC_Hook::do_action( 'dynamic_sidebar', $this->registeredWidgets[ $id ] );

            if ( is_callable($callback) ) {
                call_user_func_array($callback, $params);
                $did_one = true;
            }
        }

        /**
         * Fires after widgets are rendered in a dynamic sidebar.
         *
         * Note: The action also fires for empty sidebars, and on both the front end
         * and back end, including the Inactive Widgets sidebar on the Widgets screen.
         *
         * @since 3.9.0
         *
         * @param int|string $index       Index, name, or ID of the dynamic sidebar.
         * @param bool       $has_widgets Whether the sidebar is populated with widgets.
         *                                Default true.
         */
        RC_Hook::do_action( 'dynamic_sidebar_after', $index, true );

        /**
         * Filters whether a sidebar has widgets.
         *
         * Note: The filter is also evaluated for empty sidebars, and on both the front end
         * and back end, including the Inactive Widgets sidebar on the Widgets screen.
         *
         * @since 3.9.0
         *
         * @param bool       $did_one Whether at least one widget was rendered in the sidebar.
         *                            Default false.
         * @param int|string $index   Index, name, or ID of the dynamic sidebar.
         */
        return RC_Hook::apply_filters( 'dynamic_sidebar_has_widgets', $did_one, $index );
    }


    /**
     * Whether the dynamic sidebar is enabled and used by theme.
     *
     * @since 5.0.0
     *
     * @return bool True, if using widgets. False, if not using widgets.
     */
    public function isDynamicSidebar()
    {
        $sidebars_widgets = $this->getSidebarsWidgets();
        foreach ( (array) $this->registeredSidebars as $index => $sidebar ) {
            if ( ! empty( $sidebars_widgets[ $index ] ) ) {
                foreach ( (array) $sidebars_widgets[$index] as $widget )
                    if ( array_key_exists($widget, $this->registeredWidgets) )
                        return true;
            }
        }
        return false;
    }


    /**
     * Retrieve default registered sidebars list.
     *
     * @since 5.0.0
     * @access private
     *
     * @global array $registered_sidebars
     *
     * @return array
     */
    public function getWidgetDefaults()
    {
        $defaults = array();

        foreach ( (array) $this->registeredSidebars as $index => $sidebar )
            $defaults[$index] = array();

        return $defaults;
    }

    /**
     * Output an arbitrary widget as a template tag.
     *
     * @since 2.8.0
     *
     * @global Factory $widget_factory
     *
     * @param string $widget   The widget's PHP class name (see Widget.php).
     * @param array  $instance Optional. The widget's instance settings. Default empty array.
     * @param array  $args {
     *     Optional. Array of arguments to configure the display of the widget.
     *
     *     @type string $before_widget HTML content that will be prepended to the widget's HTML output.
     *                                 Default `<div class="widget %s">`, where `%s` is the widget's class name.
     *     @type string $after_widget  HTML content that will be appended to the widget's HTML output.
     *                                 Default `</div>`.
     *     @type string $before_title  HTML content that will be prepended to the widget's title when displayed.
     *                                 Default `<h2 class="widgettitle">`.
     *     @type string $after_title   HTML content that will be appended to the widget's title when displayed.
     *                                 Default `</h2>`.
     * }
     */
    public function theWidget($widget, $instance = array(), $args = array())
    {

        $widget_obj = $this->widgetFactory->getWidget($widget);
        if ( ! ( $widget_obj instanceof Widget ) ) {
            return;
        }

        $default_args = array(
            'before_widget' => '<div class="widget %s">',
            'after_widget'  => "</div>",
            'before_title'  => '<h2 class="widgettitle">',
            'after_title'   => '</h2>',
        );
        $args = rc_parse_args( $args, $default_args );
        $args['before_widget'] = sprintf( $args['before_widget'], $widget_obj->getWidgetOptions('classname') );

        $instance = rc_parse_args($instance);

        /**
         * Fires before rendering the requested widget.
         *
         * @since 3.0.0
         *
         * @param string $widget   The widget's class name.
         * @param array  $instance The current widget instance's settings.
         * @param array  $args     An array of the widget's sidebar arguments.
         */
        RC_Hook::do_action( 'the_widget', $widget, $instance, $args );

        $widget_obj->_set(-1);
        $widget_obj->widget($args, $instance);
    }


}