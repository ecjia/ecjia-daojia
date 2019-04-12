<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/7/16
 * Time: 10:23 AM
 */

class RC_Locale extends Royalcms\Component\Gettext\Facades\Gettext
{

    /**
     * Load a .
     *
     * mo file into the text domain $domain.
     *
     * If the text domain already exists, the translations will be merged. If both
     * sets have the same string, the translation from the original value will be taken.
     *
     * On success, the .mo file will be placed in the $l10n global by $domain
     * and will be a MO object.
     *
     * @since 3.2.0
     *
     * @param string $domain Text domain. Unique identifier for retrieving translated strings.
     * @param string $mofile Path to the .mo file.
     * @return bool True on success, false on failure.
     */
    public static function loadTextdomain($domain, $mofile) {}


    /**
     * Unload translations for a text domain.
     *
     * @since 3.0.0
     *
     * @param string $domain Text domain. Unique identifier for retrieving translated strings.
     * @return bool Whether textdomain was unloaded.
     */
    public static function unloadTextdomain($domain) {}

    /**
     * Load the theme's translated strings.
     *
     * If the current locale exists as a .mo file in the theme's root directory, it
     * will be included in the translated strings by the $domain.
     *
     * The .mo files must be named based on the locale exactly.
     *
     * @since 3.2.0
     *
     * @param string $domain Text domain. Unique identifier for retrieving translated strings.
     * @param string $path   Optional. Path to the directory containing the .mo file.
     *            Default false.
     * @return bool          True when textdomain is successfully loaded, false otherwise.
     */
    public static function loadThemeTextdomain($domain, $path = false) {}

    /**
     * Load a plugin's translated strings.
     *
     * If the path is not given then it will be the root of the plugin directory.
     *
     * The .mo file should be named based on the text domain with a dash, and then the locale exactly.
     *
     * @since 3.2.0
     *
     * @param string $domain Unique identifier for retrieving translated strings
     * @param string $plugin_rel_path Optional. Relative path to SITE_PLUGIN_PATH where the .mo file resides.
     */
    public static function loadPluginTextdomain($domain, $plugin_rel_path = false) {}

}