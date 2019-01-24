<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/23
 * Time: 09:43
 */

namespace Ecjia\App\Theme\ThemeOption;

use RC_Hook;
use RC_Format;
use ecjia_theme_option;
use ecjia_theme_transient;

class ThemeSetting
{

    /**
     * @var array
     */
    protected $registered_settings = [];

    /**
     * @var array
     */
    protected $new_whitelist_options = [];

    /**
     * @var array
     */
    protected $settings_sections = [];

    /**
     * @var
     */
    protected $settings_fields = [];

    /**
     * @var array
     */
    protected $settings_errors = [];


    public function __construct()
    {
        //
    }

    /**
     * Register a setting and its data.
     *
     * @since 2.7.0
     * @since 4.7.0 `$args` can be passed to set flags on the setting, similar to `register_meta()`.
     *
     * @global array $new_whitelist_options
     * @global array $wp_registered_settings
     *
     * @param string $option_group A settings group name. Should correspond to a whitelisted option key name.
     * 	Default whitelisted option key names include "general," "discussion," and "reading," among others.
     * @param string $option_name The name of an option to sanitize and save.
     * @param array  $args {
     *     Data used to describe the setting when registered.
     *
     *     @type string   $type              The type of data associated with this setting.
     *                                       Valid values are 'string', 'boolean', 'integer', and 'number'.
     *     @type string   $description       A description of the data attached to this setting.
     *     @type callable $sanitize_callback A callback function that sanitizes the option's value.
     *     @type bool     $show_in_rest      Whether data associated with this setting should be included in the REST API.
     *     @type mixed    $default           Default value when calling `get_option()`.
     * }
     */
    public function register_setting( $option_group, $option_name, $args = array() )
    {
        $defaults = array(
            'type'              => 'string',
            'group'             => $option_group,
            'description'       => '',
            'sanitize_callback' => null,
            'show_in_rest'      => false,
        );

        // Back-compat: old sanitize callback is added.
        if ( is_callable( $args ) ) {
            $args = array(
                'sanitize_callback' => $args,
            );
        }

        /**
         * Filters the registration arguments when registering a setting.
         *
         * @since 4.7.0
         *
         * @param array  $args         Array of setting registration arguments.
         * @param array  $defaults     Array of default arguments.
         * @param string $option_group Setting group.
         * @param string $option_name  Setting name.
         */
        $args = RC_Hook::apply_filters( 'ecjia_theme_register_setting_args', $args, $defaults, $option_group, $option_name );
        $args = rc_parse_args( $args, $defaults );

        if ( 'misc' == $option_group ) {
            _deprecated_argument( __FUNCTION__, '3.0.0',
                /* translators: %s: misc */
                sprintf( __( 'The "%s" options group has been removed. Use another settings group.' ),
                    'misc'
                )
            );
            $option_group = 'general';
        }

        if ( 'privacy' == $option_group ) {
            _deprecated_argument( __FUNCTION__, '3.5.0',
                /* translators: %s: privacy */
                sprintf( __( 'The "%s" options group has been removed. Use another settings group.' ),
                    'privacy'
                )
            );
            $option_group = 'reading';
        }

        $this->new_whitelist_options[ $option_group ][] = $option_name;
        if ( ! empty( $args['sanitize_callback'] ) ) {
            RC_Hook::add_filter( "ecjia_theme_sanitize_option_{$option_name}", $args['sanitize_callback'] );
        }
        if ( array_key_exists( 'default', $args ) ) {
            RC_Hook::add_filter( "ecjia_theme_default_option_{$option_name}", 'filter_default_option', 10, 3 );
        }

        $this->registered_settings[ $option_name ] = $args;
    }


    /**
     * Unregister a setting.
     *
     * @since 2.7.0
     * @since 4.7.0 `$sanitize_callback` was deprecated. The callback from `register_setting()` is now used instead.
     *
     * @global array $new_whitelist_options
     *
     * @param string   $option_group      The settings group name used during registration.
     * @param string   $option_name       The name of the option to unregister.
     * @param callable $deprecated        Deprecated.
     */
    public function unregister_setting( $option_group, $option_name, $deprecated = '' )
    {
        if ( 'misc' == $option_group ) {
            _deprecated_argument( __FUNCTION__, '3.0.0',
                /* translators: %s: misc */
                sprintf( __( 'The "%s" options group has been removed. Use another settings group.' ),
                    'misc'
                )
            );
            $option_group = 'general';
        }

        if ( 'privacy' == $option_group ) {
            _deprecated_argument( __FUNCTION__, '3.5.0',
                /* translators: %s: privacy */
                sprintf( __( 'The "%s" options group has been removed. Use another settings group.' ),
                    'privacy'
                )
            );
            $option_group = 'reading';
        }

        $pos = array_search( $option_name, (array) $this->new_whitelist_options[ $option_group ] );
        if ( $pos !== false ) {
            unset( $this->new_whitelist_options[ $option_group ][ $pos ] );
        }
        if ( '' !== $deprecated ) {
            _deprecated_argument( __FUNCTION__, '4.7.0',
                /* translators: 1: $sanitize_callback, 2: register_setting() */
                sprintf( __( '%1$s is deprecated. The callback from %2$s is used instead.' ),
                    '<code>$sanitize_callback</code>',
                    '<code>register_setting()</code>'
                )
            );
            RC_Hook::remove_filter( "ecjia_theme_sanitize_option_{$option_name}", $deprecated );
        }

        if ( isset( $this->registered_settings[ $option_name ] ) ) {
            // Remove the sanitize callback if one was set during registration.
            if ( ! empty( $this->registered_settings[ $option_name ]['sanitize_callback'] ) ) {
                RC_Hook::remove_filter( "ecjia_theme_sanitize_option_{$option_name}", $this->registered_settings[ $option_name ]['sanitize_callback'] );
            }

            unset( $this->registered_settings[ $option_name ] );
        }
    }


    /**
     * Retrieves an array of registered settings.
     *
     * @since 4.7.0
     *
     * @return array List of registered settings, keyed by option name.
     */
    public function get_registered_settings()
    {
        return $this->registered_settings;
    }


    /**
     * Filter the default value for the option.
     *
     * For settings which register a default setting in `register_setting()`, this
     * function is added as a filter to `default_option_{$option}`.
     *
     * @since 4.7.0
     *
     * @param mixed $default Existing default value to return.
     * @param string $option Option name.
     * @param bool $passed_default Was `get_option()` passed a default value?
     * @return mixed Filtered default value.
     */
    public function filter_default_option( $default, $option, $passed_default )
    {
        if ( $passed_default ) {
            return $default;
        }

        $registered = $this->get_registered_settings();
        if ( empty( $registered[ $option ] ) ) {
            return $default;
        }

        return $registered[ $option ]['default'];
    }


    /**
     * Add a new section to a settings page.
     *
     * Part of the Settings API. Use this to define new settings sections for an admin page.
     * Show settings sections in your admin page callback function with do_settings_sections().
     * Add settings fields to your section with add_settings_field()
     *
     * The $callback argument should be the name of a function that echoes out any
     * content you want to show at the top of the settings section before the actual
     * fields. It can output nothing if you want.
     *
     * @since 2.7.0
     *
     * @global $wp_settings_sections Storage array of all settings sections added to admin pages
     *
     * @param string   $id       Slug-name to identify the section. Used in the 'id' attribute of tags.
     * @param string   $title    Formatted title of the section. Shown as the heading for the section.
     * @param callable $callback Function that echos out any content at the top of the section (between heading and fields).
     * @param string   $page     The slug-name of the settings page on which to show the section. Built-in pages include
     *                           'general', 'reading', 'writing', 'discussion', 'media', etc. Create your own using
     *                           add_options_page();
     */
    public function add_settings_section($id, $title, $callback, $page)
    {
        if ( 'misc' == $page ) {
            _deprecated_argument( __FUNCTION__, '3.0.0',
                /* translators: %s: misc */
                sprintf( __( 'The "%s" options group has been removed. Use another settings group.' ),
                    'misc'
                )
            );
            $page = 'general';
        }

        if ( 'privacy' == $page ) {
            _deprecated_argument( __FUNCTION__, '3.5.0',
                /* translators: %s: privacy */
                sprintf( __( 'The "%s" options group has been removed. Use another settings group.' ),
                    'privacy'
                )
            );
            $page = 'reading';
        }

        $this->settings_sections[$page][$id] = array('id' => $id, 'title' => $title, 'callback' => $callback);
    }


    /**
     * Add a new field to a section of a settings page
     *
     * Part of the Settings API. Use this to define a settings field that will show
     * as part of a settings section inside a settings page. The fields are shown using
     * do_settings_fields() in do_settings-sections()
     *
     * The $callback argument should be the name of a function that echoes out the
     * html input tags for this setting field. Use get_option() to retrieve existing
     * values to show.
     *
     * @since 2.7.0
     * @since 4.2.0 The `$class` argument was added.
     *
     * @global $wp_settings_fields Storage array of settings fields and info about their pages/sections
     *
     * @param string   $id       Slug-name to identify the field. Used in the 'id' attribute of tags.
     * @param string   $title    Formatted title of the field. Shown as the label for the field
     *                           during output.
     * @param callable $callback Function that fills the field with the desired form inputs. The
     *                           function should echo its output.
     * @param string   $page     The slug-name of the settings page on which to show the section
     *                           (general, reading, writing, ...).
     * @param string   $section  Optional. The slug-name of the section of the settings page
     *                           in which to show the box. Default 'default'.
     * @param array    $args {
     *     Optional. Extra arguments used when outputting the field.
     *
     *     @type string $label_for When supplied, the setting title will be wrapped
     *                             in a `<label>` element, its `for` attribute populated
     *                             with this value.
     *     @type string $class     CSS Class to be added to the `<tr>` element when the
     *                             field is output.
     * }
     */
    public function add_settings_field($id, $title, $callback, $page, $section = 'default', $args = array())
    {
        if ( 'misc' == $page ) {
            _deprecated_argument( __FUNCTION__, '3.0.0',
                /* translators: %s: misc */
                sprintf( __( 'The "%s" options group has been removed. Use another settings group.' ),
                    'misc'
                )
            );
            $page = 'general';
        }

        if ( 'privacy' == $page ) {
            _deprecated_argument( __FUNCTION__, '3.5.0',
                /* translators: %s: privacy */
                sprintf( __( 'The "%s" options group has been removed. Use another settings group.' ),
                    'privacy'
                )
            );
            $page = 'reading';
        }

        $this->settings_fields[$page][$section][$id] = array('id' => $id, 'title' => $title, 'callback' => $callback, 'args' => $args);
    }

    public function get_settings_sections($page = null)
    {
        if (is_null($page)) {
            return $this->settings_sections;
        }

        if ( ! isset( $this->settings_sections[$page] ) )
        {
            return [];
        }

        return $this->settings_sections[$page];
    }

    /**
     * Prints out all settings sections added to a particular settings page
     *
     * Part of the Settings API. Use this in a settings page callback function
     * to output all the sections and fields that were added to that $page with
     * add_settings_section() and add_settings_field()
     *
     * @global $wp_settings_sections Storage array of all settings sections added to admin pages
     * @global $wp_settings_fields Storage array of settings fields and info about their pages/sections
     * @since 2.7.0
     *
     * @param string $page The slug name of the page whose settings sections you want to output
     */
    public function do_settings_sections( $page )
    {
        if ( ! isset( $this->settings_sections[$page] ) )
        {
            return;
        }

        foreach ( (array) $this->settings_sections[$page] as $section ) {
            if ( $section['title'] )
            {
                echo "<h2>{$section['title']}</h2>\n";
            }

            if ( $section['callback'] )
            {
                call_user_func( $section['callback'], $section );
            }

            if ( ! isset( $this->settings_fields ) || !isset( $this->settings_fields[$page] ) || !isset( $this->settings_fields[$page][$section['id']] ) )
            {
                continue;
            }

            echo '<table class="form-table">';
            $this->do_settings_fields( $page, $section['id'] );
            echo '</table>';
        }
    }

    public function get_settings_fields($page = null, $section = null)
    {
        if (is_null($page)) {
            return $this->settings_fields;
        }

        if (is_null($section))
        {
            return $this->settings_fields[$page];
        }

        if ( ! isset( $this->settings_fields[$page][$section] ) )
        {
            return [];
        }

        return $this->settings_fields[$page][$section];
    }

    /**
     * Print out the settings fields for a particular settings section
     *
     * Part of the Settings API. Use this in a settings page to output
     * a specific section. Should normally be called by do_settings_sections()
     * rather than directly.
     *
     * @global $wp_settings_fields Storage array of settings fields and their pages/sections
     *
     * @since 2.7.0
     *
     * @param string $page Slug title of the admin page who's settings fields you want to show.
     * @param string $section Slug title of the settings section who's fields you want to show.
     */
    public function do_settings_fields($page, $section)
    {
        if ( ! isset( $this->settings_fields[$page][$section] ) )
        {
            return;
        }

        foreach ( (array) $this->settings_fields[$page][$section] as $field ) {
            $class = '';

            if ( ! empty( $field['args']['class'] ) ) {
                $class = ' class="' . RC_Format::esc_attr( $field['args']['class'] ) . '"';
            }

            echo "<tr{$class}>";

            if ( ! empty( $field['args']['label_for'] ) ) {
                echo '<th scope="row"><label for="' . RC_Format::esc_attr( $field['args']['label_for'] ) . '">' . $field['title'] . '</label></th>';
            } else {
                echo '<th scope="row">' . $field['title'] . '</th>';
            }

            echo '<td>';
            call_user_func($field['callback'], $field['args']);
            echo '</td>';
            echo '</tr>';
        }
    }


    /**
     * Register a settings error to be displayed to the user
     *
     * Part of the Settings API. Use this to show messages to users about settings validation
     * problems, missing settings or anything else.
     *
     * Settings errors should be added inside the $sanitize_callback function defined in
     * register_setting() for a given setting to give feedback about the submission.
     *
     * By default messages will show immediately after the submission that generated the error.
     * Additional calls to settings_errors() can be used to show errors even when the settings
     * page is first accessed.
     *
     * @since 3.0.0
     *
     * @global array $wp_settings_errors Storage array of errors registered during this pageload
     *
     * @param string $setting Slug title of the setting to which this error applies
     * @param string $code    Slug-name to identify the error. Used as part of 'id' attribute in HTML output.
     * @param string $message The formatted message text to display to the user (will be shown inside styled
     *                        `<div>` and `<p>` tags).
     * @param string $type    Optional. Message type, controls HTML class. Accepts 'error' or 'updated'.
     *                        Default 'error'.
     */
    public function add_settings_error( $setting, $code, $message, $type = 'error' )
    {
        $this->settings_errors[] = array(
            'setting' => $setting,
            'code'    => $code,
            'message' => $message,
            'type'    => $type
        );
    }


    /**
     * Fetch settings errors registered by add_settings_error()
     *
     * Checks the $wp_settings_errors array for any errors declared during the current
     * pageload and returns them.
     *
     * If changes were just submitted ($_GET['settings-updated']) and settings errors were saved
     * to the 'settings_errors' transient then those errors will be returned instead. This
     * is used to pass errors back across pageloads.
     *
     * Use the $sanitize argument to manually re-sanitize the option before returning errors.
     * This is useful if you have errors or notices you want to show even when the user
     * hasn't submitted data (i.e. when they first load an options page, or in the {@see 'admin_notices'}
     * action hook).
     *
     * @since 3.0.0
     *
     * @global array $wp_settings_errors Storage array of errors registered during this pageload
     *
     * @param string $setting Optional slug title of a specific setting who's errors you want.
     * @param boolean $sanitize Whether to re-sanitize the setting value before returning errors.
     * @return array Array of settings errors
     */
    public function get_settings_errors( $setting = '', $sanitize = false )
    {
        /*
         * If $sanitize is true, manually re-run the sanitization for this option
         * This allows the $sanitize_callback from register_setting() to run, adding
         * any settings errors you want to show by default.
         */
        if ( $sanitize )
        {
            ecjia_theme_option::sanitize_option( $setting, ecjia_theme_option::get_option( $setting ) );
        }

        // If settings were passed back from options.php then use them.
        if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] && ecjia_theme_transient::get_transient( 'settings_errors' ) ) {
            $this->settings_errors = array_merge( (array) $this->settings_errors, ecjia_theme_transient::get_transient( 'settings_errors' ) );
            ecjia_theme_transient::delete_transient( 'settings_errors' );
        }

        // Check global in case errors have been added on this pageload.
        if ( empty( $this->settings_errors ) ) {
            return array();
        }

        // Filter the results to those of a specific setting if one was set.
        if ( $setting ) {
            $setting_errors = array();
            foreach ( (array) $this->settings_errors as $key => $details ) {
                if ( $setting == $details['setting'] )
                {
                    $setting_errors[] = $this->settings_errors[$key];
                }
            }
            return $setting_errors;
        }

        return $this->settings_errors;
    }

    /**
     * Display settings errors registered by add_settings_error().
     *
     * Part of the Settings API. Outputs a div for each error retrieved by
     * get_settings_errors().
     *
     * This is called automatically after a settings page based on the
     * Settings API is submitted. Errors should be added during the validation
     * callback function for a setting defined in register_setting().
     *
     * The $sanitize option is passed into get_settings_errors() and will
     * re-run the setting sanitization
     * on its current value.
     *
     * The $hide_on_update option will cause errors to only show when the settings
     * page is first loaded. if the user has already saved new values it will be
     * hidden to avoid repeating messages already shown in the default error
     * reporting after submission. This is useful to show general errors like
     * missing settings when the user arrives at the settings page.
     *
     * @since 3.0.0
     *
     * @param string $setting        Optional slug title of a specific setting who's errors you want.
     * @param bool   $sanitize       Whether to re-sanitize the setting value before returning errors.
     * @param bool   $hide_on_update If set to true errors will not be shown if the settings page has
     *                               already been submitted.
     */
    public function settings_errors( $setting = '', $sanitize = false, $hide_on_update = false )
    {

        if ( $hide_on_update && ! empty( $_GET['settings-updated'] ) )
        {
            return;
        }

        $settings_errors = $this->get_settings_errors( $setting, $sanitize );

        if ( empty( $settings_errors ) )
        {
            return;
        }

        $output = '';
        foreach ( $settings_errors as $key => $details ) {
            $css_id = 'setting-error-' . $details['code'];
            $css_class = $details['type'] . ' settings-error notice is-dismissible';
            $output .= "<div id='$css_id' class='$css_class'> \n";
            $output .= "<p><strong>{$details['message']}</strong></p>";
            $output .= "</div> \n";
        }
        echo $output;
    }


}