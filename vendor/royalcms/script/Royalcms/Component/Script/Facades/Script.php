<?php

namespace Royalcms\Component\Script\Facades;

use Royalcms\Component\Script\HandleScripts;
use Royalcms\Component\Support\Facades\Facade;
use RC_Hook;

/**
 * Class Script
 * @package Royalcms\Component\Script\Facades
 *
 * @method static do_items($handles = false, $group = false) Processes the items and dependencies.
 * @method static do_item($handle, $group = false) Processes a dependency.
 * @method static all_deps($handles, $recursion = false, $group = false) Determines dependencies.
 * @method static add($handle, $src, $deps = array(), $ver = false, $args = null) Register an item.
 * @method static add_data($handle, $key, $value) Add extra item data.
 * @method static get_data($handle, $key) Get extra item data.
 * @method static remove($handles) Un-register an item or items.
 * @method static enqueue($handles) Queue an item or items.
 * @method static dequeue($handles) Dequeue an item or items.
 * @method static query($handle, $list = 'registered') Query list for an item.
 * @method static set_group($handle, $recursion, $group) Set item group, unless already in a lower group.
 *
 * @method static localize($handle, $object_name, $l10n) Localizes a script, only if the script has already been added.
 */
class Script extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'script';
    }

    /**
     * Print scripts in document head that are in the $handles queue.
     *
     * Called by admin-header.php and wp_head hook. Since it is called by admin_head on every page load,
     * the function does not instantiate the WP_Scripts object unless script names are explicitly passed.
     * Makes use of already-instantiated $rc_scripts global if present. Use provided admin_print_scripts
     * hook to register/enqueue new scripts.
     *
     * @see \Royalcms\Component\Script\HandleScripts::do_items()
     * @global \Royalcms\Component\Script\HandleScripts $rc_scripts The \Royalcms\Component\Script\HandleScripts object for printing scripts.
     *
     * @since 3.0.0
     *
     * @param array|bool $handles
     *            Optional. Scripts to be printed. Default 'false'.
     * @return array On success, a processed array of Component_Hook_Dependencies items; otherwise, an empty array.
     */
    public static function print_scripts($handles = false)
    {
        /**
         * Fires before scripts in the $handles queue are printed.
         *
         * @since 3.0.0
         */
        RC_Hook::do_action('rc_print_scripts');

        // for rc_head
        if ('' === $handles) {
            $handles = false;
        }

        // No need to instantiate if nothing is there.
        if (! $handles) {
            return array();
        } else {
            return self::instance()->do_items($handles);
        }
    }

    /**
     * Register a new script.
     *
     * Registers a script to be linked later using the RC_script::enqueue_script() function.
     *
     * @see Component_Hook_Dependencies::add(), Component_Hook_Dependencies::add_data()
     * @global \Royalcms\Component\Script\HandleScripts $rc_scripts The \Royalcms\Component\Script\HandleScripts object for printing scripts.
     *
     * @since 3.0.0
     *
     * @param string $handle Name of the script. Should be unique.
     * @param string $src Path to the script from the Royalcms system root directory. Example: '/js/myscript.js'.
     * @param array $deps Optional. An array of registered script handles this script depends on. Set to false if there
     *            are no dependencies. Default empty array.
     * @param string|bool $ver Optional. String specifying script version number, if it has one, which is concatenated
     *            to end of path as a query string. If no version is specified or set to false, a version
     *            number is automatically added equal to current installed WordPress version.
     *            If set to null, no version is added. Default 'false'. Accepts 'false', 'null', or 'string'.
     * @param bool $in_footer Optional. Whether to enqueue the script before </head> or before </body>.
     *            Default 'false'. Accepts 'false' or 'true'.
     */
    public static function register_script($handle, $src, $deps = array(), $ver = false, $in_footer = false)
    {
        self::instance()->add($handle, $src, $deps, $ver);
        if ($in_footer) {
            self::instance()->add_data($handle, 'group', 1);
        }
    }

    /**
     * Localize a script.
     *
     * Works only if the script has already been added.
     *
     * Accepts an associative array $l10n and creates a JavaScript object:
     * <code>
     * "$object_name" = {
     * key: value,
     * key: value,
     * ...
     * }
     * </code>
     *
     * @see Component_Hook_Dependencies::localize()
     * @global \Royalcms\Component\Script\HandleScripts $rc_scripts The \Royalcms\Component\Script\HandleScripts object for printing scripts.
     *
     * @since 3.0.0
     *
     * @param string $handle Script handle the data will be attached to.
     * @param string $object_name Name for the JavaScript object. Passed directly, so it should be qualified JS variable.
     *            Example: '/[a-zA-Z0-9_]+/'.
     * @param array $l10n The data itself. The data can be either a single or multi-dimensional array.
     * @return bool True if the script was successfully localized, false otherwise.
     */
    public static function localize_script($handle, $object_name, $l10n)
    {
        return self::instance()->localize($handle, $object_name, $l10n);
    }

    /**
     * Remove a registered script.
     *
     * Note: there are intentional safeguards in place to prevent critical admin scripts,
     * such as jQuery core, from being unregistered.
     *
     * @see Component_Hook_Dependencies::remove()
     * @global \Royalcms\Component\Script\HandleScripts $rc_scripts The \Royalcms\Component\Script\HandleScripts object for printing scripts.
     *
     * @since 3.0.0
     *
     * @param string $handle Name of the script to be removed.
     */
    public static function deregister_script($handle)
    {
        self::instance()->remove($handle);
    }

    /**
     * Enqueue a script.
     *
     * Registers the script if $src provided (does NOT overwrite), and enqueues it.
     *
     * @see Component_Hook_Dependencies::add(), Component_Hook_Dependencies::add_data(), Component_Hook_Dependencies::enqueue()
     * @global \Royalcms\Component\Script\HandleScripts $rc_scripts The \Royalcms\Component\Script\HandleScripts object for printing scripts.
     *
     * @since 3.0.0
     *
     * @param string $handle Name of the script.
     * @param string|bool $src Path to the script from the system root directory of Royalcms. Example: '/js/myscript.js'.
     * @param array $deps An array of registered handles this script depends on. Default empty array.
     * @param string|bool $ver Optional. String specifying the script version number, if it has one. This parameter
     *            is used to ensure that the correct version is sent to the client regardless of caching,
     *            and so should be included if a version number is available and makes sense for the script.
     * @param bool $in_footer Optional. Whether to enqueue the script before </head> or before </body>.
     *            Default 'false'. Accepts 'false' or 'true'.
     */
    public static function enqueue_script($handle, $src = false, $deps = array(), $ver = false, $in_footer = false)
    {
        if ($src) {
            $_handle = explode('?', $handle);
            self::instance()->add($_handle[0], $src, $deps, $ver);
            if ($in_footer) {
                self::instance()->add_data($_handle[0], 'group', 1);
            }
        }
        self::instance()->enqueue($handle);
    }

    /**
     * Remove a previously enqueued script.
     *
     * @see Component_Hook_Dependencies::dequeue()
     * @global \Royalcms\Component\Script\HandleScripts $rc_scripts The \Royalcms\Component\Script\HandleScripts object for printing scripts.
     *
     * @since 3.0.0
     *
     * @param string|array $handle Name of the script to be removed.
     */
    public static function dequeue_script($handle)
    {
        self::instance()->dequeue($handle);
    }

    /**
     * Check whether a script has been added to the queue.
     *
     * @global \Royalcms\Component\Script\HandleScripts $rc_scripts The \Royalcms\Component\Script\HandleScripts object for printing scripts.
     * @since 3.0.0 'enqueued' added as an alias of the 'queue' list.
     *
     * @param string $handle Name of the script.
     * @param string $list Optional. Status of the script to check. Default 'enqueued'.
     *            Accepts 'enqueued', 'registered', 'queue', 'to_do', and 'done'.
     * @return bool Whether the script script is queued.
     */
    public static function script_is($handle, $list = 'enqueued')
    {
        return (bool) self::instance()->query($handle, $list);
    }

    /**
     * Returns an instance of the current final class object
     *
     * @return HandleScripts
     */
    public static function instance()
    {
        $instance = static::getFacadeRoot();
        return $instance;
    }

}
