<?php namespace Royalcms\Component\Script;

use RC_Hook;

final class Style
{

    private static $instance = null;

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
        if (self::$instance === null) {
            self::$instance = new HandleStyles();
        }
        return self::$instance;
    }

    /**
     * Display styles that are in the $handles queue.
     *
     * Passing an empty array to $handles prints the queue,
     * passing an array with one string prints that style,
     * and passing an array of strings prints those styles.
     *
     * @global Component_Hook__Styles $rc_styles The Component_Hook__Styles object for printing styles.
     *        
     * @since 3.0.0
     *       
     * @param array|bool $handles
     *            Styles to be printed. Default 'false'.
     * @return array On success, a processed array of Component_Hook_Dependencies items; otherwise, an empty array.
     */
    public static function print_styles($handles = false)
    {
        // for wp_head
        if ('' === $handles) {
            $handles = false;
        }
            
        /**
         * Fires before styles in the $handles queue are printed.
         *
         * @since 3.0.0
         */
        if (! $handles) {
            RC_Hook::do_action('rc_print_styles');
        }
            
        // No need to instantiate if nothing is there.
        if (! $handles) {
            return array();
        } else {
            return self::$instance->do_items($handles);
        }   
    }

    /**
     * Add extra CSS styles to a registered stylesheet.
     *
     * Styles will only be added if the stylesheet in already in the queue.
     * Accepts a string $data containing the CSS. If two or more CSS code blocks
     * are added to the same stylesheet $handle, they will be printed in the order
     * they were added, i.e. the latter added styles can redeclare the previous.
     *
     * @see Component_Hook_Styles::add_inline_style()
     * @global Component_Hook_Styles $rc_styles The Component_Hook_Styles object for printing styles.
     *        
     * @since 3.0.0
     *       
     * @param string $handle
     *            Name of the stylesheet to add the extra styles to. Must be lowercase.
     * @param string $data
     *            String containing the CSS styles to be added.
     * @return bool True on success, false on failure.
     */
    public static function add_inline_style($handle, $data)
    {
        if (false !== stripos($data, '</style>')) {
            $data = trim(preg_replace('#<style[^>]*>(.*)</style>#is', '$1', $data));
        }
        
        return self::$instance->add_inline_style($handle, $data);
    }

    /**
     * Register a CSS stylesheet.
     *
     * @see Component_Hook_Dependencies::add()
     * @link http://www.w3.org/TR/CSS2/media.html#media-types List of CSS media types.
     * @global Component_Hook_Styles $rc_styles The Component_Hook_Styles object for printing styles.
     *        
     * @since 3.0.0
     *       
     * @param string $handle
     *            Name of the stylesheet.
     * @param string|bool $src
     *            Path to the stylesheet from the Royalcms system root directory. Example: '/css/mystyle.css'.
     * @param array $deps
     *            An array of registered style handles this stylesheet depends on. Default empty array.
     * @param string|bool $ver
     *            String specifying the stylesheet version number. Used to ensure that the correct version
     *            is sent to the client regardless of caching. Default 'false'. Accepts 'false', 'null', or 'string'.
     * @param string $media
     *            Optional. The media for which this stylesheet has been defined.
     *            Default 'all'. Accepts 'all', 'aural', 'braille', 'handheld', 'projection', 'print',
     *            'screen', 'tty', or 'tv'.
     */
    public static function register_style($handle, $src, $deps = array(), $ver = false, $media = 'all')
    {
        self::$instance->add($handle, $src, $deps, $ver, $media);
    }

    /**
     * Remove a registered stylesheet.
     *
     * @see Component_Hook_Dependencies::remove()
     * @global Component_Hook_Styles $rc_styles The Component_Hook_Styles object for printing styles.
     *        
     * @since 3.0.0
     *       
     * @param string $handle
     *            Name of the stylesheet to be removed.
     */
    public static function deregister_style($handle)
    {
        self::$instance->remove($handle);
    }

    /**
     * Enqueue a CSS stylesheet.
     *
     * Registers the style if source provided (does NOT overwrite) and enqueues.
     *
     * @see Component_Hook_Dependencies::add(), Component_Hook_Dependencies::enqueue()
     * @link http://www.w3.org/TR/CSS2/media.html#media-types List of CSS media types.
     * @global Component_Hook_Styles $rc_styles The Component_Hook_Styles object for printing styles.
     *        
     * @since 3.0.0
     *       
     * @param string $handle
     *            Name of the stylesheet.
     * @param string|bool $src
     *            Path to the stylesheet from the system root directory of Royalcms. Example: '/css/mystyle.css'.
     * @param array $deps
     *            An array of registered style handles this stylesheet depends on. Default empty array.
     * @param string|bool $ver
     *            String specifying the stylesheet version number, if it has one. This parameter is used
     *            to ensure that the correct version is sent to the client regardless of caching, and so
     *            should be included if a version number is available and makes sense for the stylesheet.
     * @param string $media
     *            Optional. The media for which this stylesheet has been defined.
     *            Default 'all'. Accepts 'all', 'aural', 'braille', 'handheld', 'projection', 'print',
     *            'screen', 'tty', or 'tv'.
     */
    public static function enqueue_style($handle, $src = false, $deps = array(), $ver = false, $media = 'all')
    {
        if ($src) {
            $_handle = explode('?', $handle);
            self::$instance->add($_handle[0], $src, $deps, $ver, $media);
        }
        self::$instance->enqueue($handle);
    }

    /**
     * Remove a previously enqueued CSS stylesheet.
     *
     * @see Component_Hook_Dependencies::dequeue()
     * @global Component_Hook_Styles $rc_styles The Component_Hook_Styles object for printing styles.
     *        
     * @since 3.0.0
     *       
     * @param string $handle
     *            Name of the stylesheet to be removed.
     */
    public static function dequeue_style($handle)
    {
        self::$instance->dequeue($handle);
    }

    /**
     * Check whether a CSS stylesheet has been added to the queue.
     *
     * @global Component_Hook_Styles $rc_styles The Component_Hook_Styles object for printing styles.
     *        
     * @since 3.0.0
     *       
     * @param string $handle
     *            Name of the stylesheet.
     * @param string $list
     *            Optional. Status of the stylesheet to check. Default 'enqueued'.
     *            Accepts 'enqueued', 'registered', 'queue', 'to_do', and 'done'.
     * @return bool Whether style is queued.
     */
    public static function style_is($handle, $list = 'enqueued')
    {
        return (bool) self::$instance->query($handle, $list);
    }

    /**
     * Add metadata to a CSS stylesheet.
     *
     * Works only if the stylesheet has already been added.
     *
     * Possible values for $key and $value:
     * 'conditional' string Comments for IE 6, lte IE 7 etc.
     * 'rtl' bool|string To declare an RTL stylesheet.
     * 'suffix' string Optional suffix, used in combination with RTL.
     * 'alt' bool For rel="alternate stylesheet".
     * 'title' string For preferred/alternate stylesheets.
     *
     * @see Component_Hook_Dependency::add_data()
     *
     * @since 3.0.0
     *       
     * @param string $handle
     *            Name of the stylesheet.
     * @param string $key
     *            Name of data point for which we're storing a value.
     *            Accepts 'conditional', 'rtl' and 'suffix', 'alt' and 'title'.
     * @param mixed $data
     *            String containing the CSS data to be added.
     * @return bool True on success, false on failure.
     */
    public static function style_add_data($handle, $key, $value)
    {
        return self::$instance->add_data($handle, $key, $value);
    }
}

// end