<?php

namespace Royalcms\Component\Widget;

/**
 * This class must be extended for each widget and RC_Widget::widget(), RC_Widget::update()
 * and RC_Widget::form() need to be over-ridden.
 *
 * @package Royalcms
 * @subpackage Widgets
 * @since 2.8.0
 */
abstract class Widget
{

    /**
     * Root ID for all widgets of this type.
     *
     * @since 5.0.0
     * @access public
     * @var mixed|string
     */
    protected $id_base;

    /**
     * Name for this widget type.
     *
     * @since 5.0.0
     * @access public
     * @var string
     */
    protected $name;

    /**
     * Option name for this widget type.
     *
     * @since 5.0.0
     * @access public
     * @var string
     */
    public $option_name;

    /**
     * Alt option name for this widget type.
     *
     * @since 5.0.0
     * @access public
     * @var string
     */
    public $alt_option_name;

    /**
     * Option array passed to register_sidebar_widget().
     *
     * @since 5.0.0
     * @access public
     * @var array
     */
    protected $widget_options;

    /**
     * Option array passed to register_widget_control().
     *
     * @since 5.0.0
     * @access public
     * @var array
     */
    protected $control_options;

    /**
     * Unique ID number of the current instance.
     *
     * @since 5.0.0
     * @access public
     * @var bool|int
     */
    protected $number = false;

    /**
     * Unique ID string of the current instance (id_base-number).
     *
     * @since 5.0.0
     * @access public
     * @var bool|string
     */
    protected $id = false;

    /**
     * Whether the widget data has been updated.
     *
     * Set to true when the data is updated after a POST submit - ensures it does
     * not happen twice.
     *
     * @since 5.0.0
     * @access public
     * @var bool
     */
    protected $updated = false;

    // Member functions that you must over-ride.

    /** Echo the widget content.
     *
     * Subclasses should over-ride this function to generate their widget code.
     *
     * @param array $args Display arguments including before_title, after_title, before_widget, and after_widget.
     * @param array $instance The settings for the particular instance of the widget
     */
    public abstract function widget($args, $instance);

    /** Update a particular instance.
     *
     * This function should check that $new_instance is set correctly.
     * The newly calculated value of $instance should be returned.
     * If "false" is returned, the instance won't be saved/updated.
     *
     * @param array $new_instance New settings for this instance as input by the user via form()
     * @param array $old_instance Old settings for this instance
     * @return array Settings to save or bool false to cancel saving
     */
    public function update($new_instance, $old_instance)
    {
        return $new_instance;
    }

    /** Echo the settings update form
     *
     * @param array $instance Current settings
     */
    public function form($instance)
    {
        echo '<p class="no-options-widget">' . __('There are no options for this widget.') . '</p>';
        return 'noform';
    }

    // Functions you'll need to call.

    /**
     * PHP5 constructor
     *
     * @param string $id_base Optional Base ID for the widget, lower case,
     * if left empty a portion of the widget's class name will be used. Has to be unique.
     * @param string $name Name for the widget displayed on the configuration page.
     * @param array $widget_options Optional Passed to wp_register_sidebar_widget()
     *	 - description: shown on the configuration page
     *	 - classname
     * @param array $control_options Optional Passed to wp_register_widget_control()
     *	 - width: required if more than 250px
     *	 - height: currently not used but may be needed in the future
     */
    public function __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
    {
        $this->id_base = empty($id_base) ? preg_replace( '/(wp_)?widget_/', '', strtolower(get_class($this)) ) : strtolower($id_base);
        $this->name = $name;
        $this->option_name = 'widget_' . $this->id_base;
        $this->widget_options = rc_parse_args( $widget_options, array('classname' => $this->option_name) );
        $this->control_options = rc_parse_args( $control_options, array('id_base' => $this->id_base) );
    }

    public function getWidgetOptions($name)
    {
        return $this->widget_options[$name];
    }

    /**
     * Constructs name attributes for use in form() fields
     *
     * This function should be used in form() methods to create name attributes for fields to be saved by update()
     *
     * @param string $field_name Field name
     * @return string Name attribute for $field_name
     */
    public function get_field_name($field_name)
    {
        return 'widget-' . $this->id_base . '[' . $this->number . '][' . $field_name . ']';
    }

    /**
     * Constructs id attributes for use in form() fields
     *
     * This function should be used in form() methods to create id attributes for fields to be saved by update()
     *
     * @param string $field_name Field name
     * @return string ID attribute for $field_name
     */
    public function get_field_id($field_name)
    {
        return 'widget-' . $this->id_base . '-' . $this->number . '-' . $field_name;
    }

    // Private Functions. Don't worry about these.

    public function _register()
    {
        $settings = $this->get_settings();
        $empty = true;

        if ( is_array($settings) ) {
            foreach ( array_keys($settings) as $number ) {
                if ( is_numeric($number) ) {
                    $this->_set($number);
                    $this->_register_one($number);
                    $empty = false;
                }
            }
        }

        if ( $empty ) {
            // If there are none, we register the widget's existence with a
            // generic template
            $this->_set(1);
            $this->_register_one();
        }
    }

    public function _set($number)
    {
        $this->number = $number;
        $this->id = $this->id_base . '-' . $number;
    }

    private function _get_display_callback()
    {
        return array($this, 'display_callback');
    }

    private function _get_update_callback()
    {
        return array($this, 'update_callback');
    }

    private function _get_form_callback()
    {
        return array($this, 'form_callback');
    }

    /**
     * Determine if we're in the Customizer; if true, then the object cache gets
     * suspended and widgets should check this to decide whether they should
     * store anything persistently to the object cache, to transients, or
     * anywhere else.
     *
     * @since 3.9.0
     *
     * @return bool True if Customizer is on, false if not.
     */
    public function is_preview()
    {
        global $wp_customize;
        return ( isset( $wp_customize ) && $wp_customize->is_preview() ) ;
    }

    /** Generate the actual widget content.
     *	Just finds the instance and calls widget().
     *	Do NOT over-ride this function. */
    public function display_callback( $args, $widget_args = 1 )
    {
        if ( is_numeric($widget_args) )
            $widget_args = array( 'number' => $widget_args );

        $widget_args = rc_parse_args( $widget_args, array( 'number' => -1 ) );
        $this->_set( $widget_args['number'] );
        $instance = $this->get_settings();

        if ( array_key_exists( $this->number, $instance ) ) {
            $instance = $instance[$this->number];

            /**
             * Filter the settings for a particular widget instance.
             *
             * Returning false will effectively short-circuit display of the widget.
             *
             * @since 2.8.0
             *
             * @param array     $instance The current widget instance's settings.
             * @param WP_Widget $this     The current widget instance.
             * @param array     $args     An array of default widget arguments.
             */
            $instance = RC_Hook::apply_filters( 'widget_display_callback', $instance, $this, $args );

            if ( false === $instance ) {
                return;
            }

            $was_cache_addition_suspended = wp_suspend_cache_addition();
            if ( $this->is_preview() && ! $was_cache_addition_suspended ) {
                wp_suspend_cache_addition( true );
            }

            $this->widget( $args, $instance );

            if ( $this->is_preview() ) {
                wp_suspend_cache_addition( $was_cache_addition_suspended );
            }
        }
    }

    /**
     * Deal with changed settings.
     *
     * Do NOT over-ride this function.
     *
     * @param mixed $deprecated Not used.
     */
    public function update_callback( $deprecated = 1 )
    {
        global $wp_registered_widgets;

        $all_instances = $this->get_settings();

        // We need to update the data
        if ( $this->updated )
            return;

        $sidebars_widgets = wp_get_sidebars_widgets();

        if ( isset($_POST['delete_widget']) && $_POST['delete_widget'] ) {
            // Delete the settings for this instance of the widget
            if ( isset($_POST['the-widget-id']) )
                $del_id = $_POST['the-widget-id'];
            else
                return;

            if ( isset($wp_registered_widgets[$del_id]['params'][0]['number']) ) {
                $number = $wp_registered_widgets[$del_id]['params'][0]['number'];

                if ( $this->id_base . '-' . $number == $del_id )
                    unset($all_instances[$number]);
            }
        } else {
            if ( isset($_POST['widget-' . $this->id_base]) && is_array($_POST['widget-' . $this->id_base]) ) {
                $settings = $_POST['widget-' . $this->id_base];
            } elseif ( isset($_POST['id_base']) && $_POST['id_base'] == $this->id_base ) {
                $num = $_POST['multi_number'] ? (int) $_POST['multi_number'] : (int) $_POST['widget_number'];
                $settings = array( $num => array() );
            } else {
                return;
            }

            foreach ( $settings as $number => $new_instance ) {
                $new_instance = stripslashes_deep($new_instance);
                $this->_set($number);

                $old_instance = isset($all_instances[$number]) ? $all_instances[$number] : array();

                $was_cache_addition_suspended = wp_suspend_cache_addition();
                if ( $this->is_preview() && ! $was_cache_addition_suspended ) {
                    wp_suspend_cache_addition( true );
                }

                $instance = $this->update( $new_instance, $old_instance );

                if ( $this->is_preview() ) {
                    wp_suspend_cache_addition( $was_cache_addition_suspended );
                }

                /**
                 * Filter a widget's settings before saving.
                 *
                 * Returning false will effectively short-circuit the widget's ability
                 * to update settings.
                 *
                 * @since 2.8.0
                 *
                 * @param array     $instance     The current widget instance's settings.
                 * @param array     $new_instance Array of new widget settings.
                 * @param array     $old_instance Array of old widget settings.
                 * @param WP_Widget $this         The current widget instance.
                 */
                $instance = RC_Hook::apply_filters( 'widget_update_callback', $instance, $new_instance, $old_instance, $this );
                if ( false !== $instance ) {
                    $all_instances[$number] = $instance;
                }

                break; // run only once
            }
        }

        $this->save_settings($all_instances);
        $this->updated = true;
    }

    /**
     * Generate the control form.
     *
     * Do NOT over-ride this function.
     */
    final public function form_callback( $widget_args = 1 )
    {
        if ( is_numeric($widget_args) )
            $widget_args = array( 'number' => $widget_args );

        $widget_args = rc_parse_args( $widget_args, array( 'number' => -1 ) );
        $all_instances = $this->get_settings();

        if ( -1 == $widget_args['number'] ) {
            // We echo out a form where 'number' can be set later
            $this->_set('__i__');
            $instance = array();
        } else {
            $this->_set($widget_args['number']);
            $instance = $all_instances[ $widget_args['number'] ];
        }

        /**
         * Filter the widget instance's settings before displaying the control form.
         *
         * Returning false effectively short-circuits display of the control form.
         *
         * @since 2.8.0
         *
         * @param array     $instance The current widget instance's settings.
         * @param WP_Widget $this     The current widget instance.
         */
        $instance = RC_Hook::apply_filters( 'widget_form_callback', $instance, $this );

        $return = null;
        if ( false !== $instance ) {
            $return = $this->form($instance);

            /**
             * Fires at the end of the widget control form.
             *
             * Use this hook to add extra fields to the widget form. The hook
             * is only fired if the value passed to the 'widget_form_callback'
             * hook is not false.
             *
             * Note: If the widget has no form, the text echoed from the default
             * form method can be hidden using CSS.
             *
             * @since 2.8.0
             *
             * @param WP_Widget $this     The widget instance, passed by reference.
             * @param null      $return   Return null if new fields are added.
             * @param array     $instance An array of the widget's settings.
            */
            RC_Hook::do_action_ref_array( 'in_widget_form', array( &$this, &$return, $instance ) );
        }
        return $return;
    }

    /** Helper function: Registers a single instance. */
    public function _register_one($number = -1)
    {
        RC_Widget::register_sidebar_widget(	$this->id, $this->name,	$this->_get_display_callback(), $this->widget_options, array( 'number' => $number ) );
        RC_Widget::_register_widget_update_callback( $this->id_base, $this->_get_update_callback(), $this->control_options, array( 'number' => -1 ) );
        RC_Widget::_register_widget_form_callback(	$this->id, $this->name,	$this->_get_form_callback(), $this->control_options, array( 'number' => $number ) );
    }


    public function getIdBase()
    {
        return $this->id_base;
    }

    public abstract function save_settings($settings);

    public abstract function get_settings();
}


// end