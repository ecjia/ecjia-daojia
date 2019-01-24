<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//

/**
 * Class ecjia_theme_setting
 * @see \Ecjia\App\Theme\ThemeOption\ThemeSetting
 */
class ecjia_theme_setting
{

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
    public static function register_setting( $option_group, $option_name, $args = array() ) {}

    /**
     * Unregister a setting.
     *
     * @since 2.7.0
     * @since 4.7.0 `$sanitize_callback` was deprecated. The callback from `register_setting()` is now used instead.
     * @uses \Ecjia\App\Theme\ThemeOption\ThemeSetting::unregister_setting
     * @global array $new_whitelist_options
     *
     * @param string   $option_group      The settings group name used during registration.
     * @param string   $option_name       The name of the option to unregister.
     * @param callable $deprecated        Deprecated.
     */
    public static function unregister_setting( $option_group, $option_name, $deprecated = '' ) {}


    /**
     * Retrieves an array of registered settings.
     *
     * @since 4.7.0
     *
     * @return array List of registered settings, keyed by option name.
     */
    public static function get_registered_settings() {}

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
    public static function filter_default_option( $default, $option, $passed_default ) {}


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
    public static function add_settings_section($id, $title, $callback, $page) {}

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
     * @see \Ecjia\App\Theme\ThemeOption\ThemeSetting::add_settings_field
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
    public static function add_settings_field($id, $title, $callback, $page, $section = 'default', $args = array()) {}

    /**
     * @param null $page
     * @return array
     */
    public static function get_settings_sections($page = null) {}


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
    public static function do_settings_sections( $page ) {}

    /**
     * @param null $page
     * @param null $section
     * @return array
     */
    public static function get_settings_fields($page = null, $section = null) {}


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
    public static function do_settings_fields($page, $section) {}


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
    public static function add_settings_error( $setting, $code, $message, $type = 'error' ) {}


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
    public static function get_settings_errors( $setting = '', $sanitize = false ) {}


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
    public static function settings_errors( $setting = '', $sanitize = false, $hide_on_update = false ) {}

}

// end