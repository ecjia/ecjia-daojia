<?php namespace Royalcms\Component\Foundation;

use Royalcms\Component\Support\Facades\Hook;
use Royalcms\Component\Support\Format;

/**
 * Royalcms Translation API
 *
 * @package Royalcms
 * @subpackage i18n
 */
class Locale extends Object
{

    private static $locale;

    /**
     * Get the current locale.
     *
     * If the locale is set, then it will filter the locale in the 'locale' filter
     * hook and return the value.
     *
     * If the locale is not set already, then the RC_LANG constant is used if it is
     * defined. Then it is filtered through the 'locale' filter hook and the value
     * for the locale global set and the locale is returned.
     *
     * The process to get the locale should only be done once, but the locale will
     * always be filtered using the 'locale' hook.
     *
     * @since 3.2.0
     *       
     * @return string The locale of the blog or from the 'locale' hook.
     */
    public static function get_locale()
    {
        if (isset(self::$locale)) {
            /**
             * Filter WordPress install's locale ID.
             *
             * @since 3.2.0
             *
             * @param string $locale
             *            The locale ID.
             */
            return Hook::apply_filters('locale', self::$locale);
        }   
 
        if (royalcms('config')->has('system.locale')) {
            self::$locale = royalcms('config')->get('system.locale');
        } 
        
        if (empty(self::$locale)) {
            self::$locale = 'zh_CN';
        }
        
        /**
         * This filter is documented in l10n.php
         */
        return Hook::apply_filters('locale', self::$locale);
    }

    /**
     * Retrieve the translation of $text.
     *
     * If there is no translation, or the text domain isn't loaded, the original text is returned.
     *
     * <strong>Note:</strong> Don't use translate() directly, use __() or related functions.
     *
     * @since 3.2.0
     *       
     * @param string $text
     *            Text to translate.
     * @param string $domain
     *            Optional. Text domain. Unique identifier for retrieving translated strings.
     * @return string Translated text
     */
    public static function translate($text, $domain = 'default')
    {
        $translations = self::get_translations_for_domain($domain);
        $translations = $translations->translate($text);
        /**
         * Filter text with its translation.
         *
         * @since 3.2.0
         *       
         * @param string $translations
         *            Translated text.
         * @param string $text
         *            Text to translate.
         * @param string $domain
         *            Text domain. Unique identifier for retrieving translated strings.
         */
        return Hook::apply_filters('gettext', $translations, $text, $domain);
    }

    /**
     * Remove last item on a pipe-delimited string.
     *
     * Meant for removing the last item in a string, such as 'Role name|User role'. The original
     * string will be returned if no pipe '|' characters are found in the string.
     *
     * @since 3.2.0
     *       
     * @param string $string
     *            A pipe-delimited string.
     * @return string Either $string or everything before the last pipe.
     */
    public static function before_last_bar($string)
    {
        $last_bar = strrpos($string, '|');
        if (false == $last_bar) {
            return $string;
        } else {
            return substr($string, 0, $last_bar);
        }   
    }

    /**
     * Retrieve the translation of $text in the context defined in $context.
     *
     * If there is no translation, or the text domain isn't loaded the original
     * text is returned.
     *
     * @since 3.2.0
     *       
     * @param string $text
     *            Text to translate.
     * @param string $context
     *            Context information for the translators.
     * @param string $domain
     *            Optional. Text domain. Unique identifier for retrieving translated strings.
     * @return string Translated text on success, original text on failure.
     */
    public static function translate_with_gettext_context($text, $context, $domain = 'default')
    {
        $translations = self::get_translations_for_domain($domain);
        $translations = $translations->translate($text, $context);
        /**
         * Filter text with its translation based on context information.
         *
         * @since 3.2.0
         *       
         * @param string $translations
         *            Translated text.
         * @param string $text
         *            Text to translate.
         * @param string $context
         *            Context information for the translators.
         * @param string $domain
         *            Text domain. Unique identifier for retrieving translated strings.
         */
        return Hook::apply_filters('gettext_with_context', $translations, $text, $context, $domain);
    }
    
    /**
     * Retrieve the plural or single form based on the supplied amount.
     *
     * If the text domain is not set in the $l10n list, then a comparison will be made
     * and either $plural or $single parameters returned.
     *
     * If the text domain does exist, then the parameters $single, $plural, and $number
     * will first be passed to the text domain's ngettext method. Then it will be passed
     * to the 'ngettext' filter hook along with the same parameters. The expected
     * type will be a string.
     *
     * @since 3.2.0
     *       
     * @param string $single
     *            The text that will be used if $number is 1.
     * @param string $plural
     *            The text that will be used if $number is not 1.
     * @param int $number
     *            The number to compare against to use either $single or $plural.
     * @param string $domain
     *            Optional. Text domain. Unique identifier for retrieving translated strings.
     * @return string Either $single or $plural translated text.
     */
    public static function _n($single, $plural, $number, $domain = 'default')
    {
        $translations = self::get_translations_for_domain($domain);
        $translation = $translations->translate_plural($single, $plural, $number);
        /**
         * Filter text with its translation when plural option is available.
         *
         * @since 3.2.0
         *       
         * @param string $translation
         *            Translated text.
         * @param string $single
         *            The text that will be used if $number is 1.
         * @param string $plural
         *            The text that will be used if $number is not 1.
         * @param string $number
         *            The number to compare against to use either $single or $plural.
         * @param string $domain
         *            Text domain. Unique identifier for retrieving translated strings.
         */
        return Hook::apply_filters('ngettext', $translation, $single, $plural, $number, $domain);
    }

    /**
     * Retrieve the plural or single form based on the supplied amount with gettext context.
     *
     * This is a hybrid of _n() and _x(). It supports contexts and plurals.
     *
     * @since 3.2.0
     *       
     * @param string $single
     *            The text that will be used if $number is 1.
     * @param string $plural
     *            The text that will be used if $number is not 1.
     * @param int $number
     *            The number to compare against to use either $single or $plural.
     * @param string $context
     *            Context information for the translators.
     * @param string $domain
     *            Optional. Text domain. Unique identifier for retrieving translated strings.
     * @return string Either $single or $plural translated text with context.
     */
    public static function _nx($single, $plural, $number, $context, $domain = 'default')
    {
        $translations = self::get_translations_for_domain($domain);
        $translation = $translations->translate_plural($single, $plural, $number, $context);
        /**
         * Filter text with its translation while plural option and context are available.
         *
         * @since 3.2.0
         *       
         * @param string $translation
         *            Translated text.
         * @param string $single
         *            The text that will be used if $number is 1.
         * @param string $plural
         *            The text that will be used if $number is not 1.
         * @param string $number
         *            The number to compare against to use either $single or $plural.
         * @param string $context
         *            Context information for the translators.
         * @param string $domain
         *            Text domain. Unique identifier for retrieving translated strings.
         */
        return Hook::apply_filters('ngettext_with_context', $translation, $single, $plural, $number, $context, $domain);
    }

    /**
     * Register plural strings in POT file, but don't translate them.
     *
     * Used when you want to keep structures with translatable plural
     * strings and use them later.
     *
     * Example:
     * <code>
     * $messages = array(
     * 'post' => _n_noop('%s post', '%s posts'),
     * 'page' => _n_noop('%s pages', '%s pages')
     * );
     * ...
     * $message = $messages[$type];
     * $usable_text = sprintf( translate_nooped_plural( $message, $count ), $count );
     * </code>
     *
     * @since 3.2.0
     *       
     * @param string $singular
     *            Single form to be i18ned.
     * @param string $plural
     *            Plural form to be i18ned.
     * @param string $domain
     *            Optional. Text domain. Unique identifier for retrieving translated strings.
     * @return array array($singular, $plural)
     */
    public static function _n_noop($singular, $plural, $domain = null)
    {
        return array(
            0 => $singular,
            1 => $plural,
            'singular' => $singular,
            'plural' => $plural,
            'context' => null,
            'domain' => $domain
        );
    }

    /**
     * Register plural strings with context in POT file, but don't translate them.
     *
     * @since 3.2.0
     */
    public static function _nx_noop($singular, $plural, $context, $domain = null)
    {
        return array(
            0 => $singular,
            1 => $plural,
            2 => $context,
            'singular' => $singular,
            'plural' => $plural,
            'context' => $context,
            'domain' => $domain
        );
    }

    /**
     * Translate the result of _n_noop() or _nx_noop().
     *
     * @since 3.1.0
     *       
     * @param array $nooped_plural
     *            Array with singular, plural and context keys, usually the result of _n_noop() or _nx_noop()
     * @param int $count
     *            Number of objects
     * @param string $domain
     *            Optional. Text domain. Unique identifier for retrieving translated strings. If $nooped_plural contains
     *            a text domain passed to _n_noop() or _nx_noop(), it will override this value.
     * @return string Either $single or $plural translated text.
     */
    public static function translate_nooped_plural($nooped_plural, $count, $domain = 'default')
    {
        if ($nooped_plural['domain']) {
            $domain = $nooped_plural['domain'];
        } 
        
        if ($nooped_plural['context']) {
            return self::_nx($nooped_plural['singular'], $nooped_plural['plural'], $count, $nooped_plural['context'], $domain);
        } else {
            return self::_n($nooped_plural['singular'], $nooped_plural['plural'], $count, $domain);
        }   
    }

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
     * @param string $domain
     *            Text domain. Unique identifier for retrieving translated strings.
     * @param string $mofile
     *            Path to the .mo file.
     * @return bool True on success, false on failure.
     */
    public static function load_textdomain($domain, $mofile)
    {
        /**
         * Filter text domain and/or MO file path for loading translations.
         *
         * @since 3.2.0
         *       
         * @param bool $override
         *            Whether to override the text domain. Default false.
         * @param string $domain
         *            Text domain. Unique identifier for retrieving translated strings.
         * @param string $mofile
         *            Path to the MO file.
         */
        $plugin_override = Hook::apply_filters('override_load_textdomain', false, $domain, $mofile);
        
        if (true == $plugin_override) {
            return true;
        }
        
        /**
         * Fires before the MO translation file is loaded.
         *
         * @since 2.9.0
         *       
         * @param string $domain
         *            Text domain. Unique identifier for retrieving translated strings.
         * @param string $mofile
         *            Path to the .mo file.
         */
        Hook::do_action('load_textdomain', $domain, $mofile);
        
        /**
         * Filter MO file path for loading translations for a specific text domain.
         *
         * @since 3.2.0
         *       
         * @param string $mofile
         *            Path to the MO file.
         * @param string $domain
         *            Text domain. Unique identifier for retrieving translated strings.
         */
        $mofile = Hook::apply_filters('load_textdomain_mofile', $mofile, $domain);
        
        if (! is_readable($mofile)) {
            return false;
        }
        
        $mo = new \Component_Translation_MO();
        if (! $mo->import_from_file($mofile)) {
            return false;
        } 
        
        if (isset($l10n[$domain])) {
            $mo->merge_with(self::$l10n[$domain]);
        }
        
        self::$l10n[$domain] = &$mo;
        
        return true;
    }

    /**
     * Unload translations for a text domain.
     *
     * @since 3.0.0
     *       
     * @param string $domain
     *            Text domain. Unique identifier for retrieving translated strings.
     * @return bool Whether textdomain was unloaded.
     */
    public static function unload_textdomain($domain)
    {
        /**
         * Filter the text domain for loading translation.
         *
         * @since 3.0.0
         *       
         * @param bool $override
         *            Whether to override unloading the text domain. Default false.
         * @param string $domain
         *            Text domain. Unique identifier for retrieving translated strings.
         */
        $plugin_override = Hook::apply_filters('override_unload_textdomain', false, $domain);
        
        if ($plugin_override) {
            return true;
        }
        
        /**
         * Fires before the text domain is unloaded.
         *
         * @since 3.0.0
         *       
         * @param string $domain
         *            Text domain. Unique identifier for retrieving translated strings.
         */
        Hook::do_action('unload_textdomain', $domain);
        
        if (isset(self::$l10n[$domain])) {
            unset(self::$l10n[$domain]);
            return true;
        }
        
        return false;
    }

    /**
     * Load default translated strings based on locale.
     *
     * Loads the .mo file in admin_path languages path from locale root.
     * The translated (.mo) file is named based on the locale.
     *
     * @see load_textdomain()
     *
     * @since 3.2.0
     */
    public static function load_default_textdomain()
    {
        $locale = self::get_locale();
       
        self::load_textdomain('default', \RC_Uri::admin_path() . "languages/$locale/system.mo");
    }

    /**
     * Load a plugin's translated strings.
     *
     * If the path is not given then it will be the root of the plugin directory.
     *
     * The .mo file should be named based on the text domain with a dash, and then the locale exactly.
     *
     * @since 3.2.0
     *       
     * @param string $domain
     *            Unique identifier for retrieving translated strings
     * @param string $deprecated
     *            Use the $plugin_rel_path parameter instead.
     * @param string $plugin_rel_path
     *            Optional. Relative path to WP_PLUGIN_DIR where the .mo file resides.
     */
    public static function load_plugin_textdomain($domain, $deprecated = false, $plugin_rel_path = false)
    {
        $locale = self::get_locale();
        /**
         * Filter a plugin's locale.
         *
         * @since 3.2.0
         *       
         * @param string $locale
         *            The plugin's current locale.
         * @param string $domain
         *            Text domain. Unique identifier for retrieving translated strings.
         */
        $locale = Hook::apply_filters('plugin_locale', $locale, $domain);
        
        if (false !== $plugin_rel_path) {
            $path = WP_PLUGIN_DIR . '/' . trim($plugin_rel_path, '/');
        } else 
            if (false !== $deprecated) {
                // _deprecated_argument( __FUNCTION__, '2.7' );
                $path = ABSPATH . trim($deprecated, '/');
            } else {
                $path = WP_PLUGIN_DIR;
            }
        
        // Load the textdomain according to the plugin first
        $mofile = $domain . '-' . $locale . '.mo';
        $loaded = self::load_textdomain($domain, $path . '/' . $mofile);
        if ($loaded) {
            return $loaded;
        }

        // Otherwise, load from the languages directory
        // $mofile = WP_LANG_DIR . '/plugins/' . $mofile;
        return self::load_textdomain($domain, $mofile);
    }

    /**
     * Load the translated strings for a plugin residing in the mu-plugins directory.
     *
     * @since 3.0.0
     *       
     * @param string $domain
     *            Text domain. Unique identifier for retrieving translated strings.
     * @param string $mu_plugin_rel_path
     *            Relative to WPMU_PLUGIN_DIR directory in which the .mo file resides.
     *            Default empty string.
     * @return bool True when textdomain is successfully loaded, false otherwise.
     */
    public static function load_muplugin_textdomain($domain, $mu_plugin_rel_path = '')
    {
        /**
         * This filter is documented in wp-includes/l10n.php
         */
        $locale = Hook::apply_filters('plugin_locale', self::get_locale(), $domain);
        $path = Format::trailingslashit(WPMU_PLUGIN_DIR . '/' . ltrim($mu_plugin_rel_path, '/'));
        
        // Load the textdomain according to the plugin first
        $mofile = $domain . '-' . $locale . '.mo';
        $loaded = self::load_textdomain($domain, $path . $mofile);
        if ($loaded) {
            return $loaded;
        }
            
        // Otherwise, load from the languages directory
        $mofile = WP_LANG_DIR . '/plugins/' . $mofile;
        return self::load_textdomain($domain, $mofile);
    }

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
     * @param string $domain
     *            Text domain. Unique identifier for retrieving translated strings.
     * @param string $path
     *            Optional. Path to the directory containing the .mo file.
     *            Default false.
     * @return bool True when textdomain is successfully loaded, false otherwise.
     */
    public static function load_theme_textdomain($domain, $path = false)
    {
        $locale = self::get_locale();
        /**
         * Filter a theme's locale.
         *
         * @since 3.2.0
         *       
         * @param string $locale
         *            The theme's current locale.
         * @param string $domain
         *            Text domain. Unique identifier for retrieving translated strings.
         */
        $locale = Hook::apply_filters('theme_locale', $locale, $domain);
        
        if (! $path) {
            $path = Theme::get_template_directory();
        }  
            
        // Load the textdomain according to the theme
        $mofile = "{$path}/{$locale}.mo";
        $loaded = self::load_textdomain($domain, $mofile);
        if ($loaded) {
            return $loaded;
        }   
            
        // Otherwise, load from the languages directory
        $mofile = WP_LANG_DIR . "/themes/{$domain}-{$locale}.mo";
        return self::load_textdomain($domain, $mofile);
    }

    /**
     * Load the child themes translated strings.
     *
     * If the current locale exists as a .mo file in the child themes
     * root directory, it will be included in the translated strings by the $domain.
     *
     * The .mo files must be named based on the locale exactly.
     *
     * @since 3.2.0
     *       
     * @param string $domain
     *            Text domain. Unique identifier for retrieving translated strings.
     * @return bool True when the theme textdomain is successfully loaded, false otherwise.
     */
    public static function load_child_theme_textdomain($domain, $path = false)
    {
        if (! $path) {
            $path = Theme::get_template_directory();
        }
            
        return self::load_theme_textdomain($domain, $path);
    }

    private static $l10n = array();

    /**
     * Return the Translations instance for a text domain.
     *
     * If there isn't one, returns empty Translations instance.
     *
     * @param string $domain
     *            Text domain. Unique identifier for retrieving translated strings.
     * @return Translations A Translations instance.
     */
    public static function get_translations_for_domain($domain)
    {
        if (! isset(self::$l10n[$domain])) {
            self::$l10n[$domain] = new \Component_Translation_NoopTranslations();
        } 
        return self::$l10n[$domain];
    }

    /**
     * Whether there are translations for the text domain.
     *
     * @since 3.0.0
     * @param string $domain
     *            Text domain. Unique identifier for retrieving translated strings.
     * @return bool Whether there are translations.
     */
    public static function is_textdomain_loaded($domain)
    {
        return isset(self::$l10n[$domain]);
    }

    /**
     * Translates role name.
     *
     * Since the role names are in the database and not in the source there
     * are dummy gettext calls to get them into the POT file and this function
     * properly translates them back.
     *
     * The before_last_bar() call is needed, because older installs keep the roles
     * using the old context format: 'Role name|User role' and just skipping the
     * content after the last bar is easier than fixing them in the DB. New installs
     * won't suffer from that problem.
     *
     * @since 3.2.0
     *       
     * @param string $name
     *            The role name.
     * @return string Translated role name on success, original name on failure.
     */
    public static function translate_user_role($name)
    {
        return self::translate_with_gettext_context(self::before_last_bar($name), 'User role');
    }

    /**
     * Get all available languages based on the presence of *.mo files in a given directory.
     *
     * The default directory is WP_LANG_DIR.
     *
     * @since 3.0.0
     *       
     * @param string $dir
     *            A directory to search for language files.
     *            Default WP_LANG_DIR.
     * @return array An array of language codes or an empty array if no languages are present. Language codes are formed by stripping the .mo extension from the language file names.
     */
    public static function get_available_languages($dir = null)
    {
        $languages = array();
        
        foreach ((array) glob((is_null($dir) ? WP_LANG_DIR : $dir) . '/*.mo') as $lang_file) {
            $lang_file = basename($lang_file, '.mo');
            if (0 !== strpos($lang_file, 'continents-cities') && 0 !== strpos($lang_file, 'ms-') && 0 !== strpos($lang_file, 'admin-')) {
                $languages[] = $lang_file;
            }   
        }
        
        return $languages;
    }

    /**
     * Get installed translations.
     *
     * Looks in the wp-content/languages directory for translations of
     * plugins or themes.
     *
     * @since 3.2.0
     *       
     * @param string $type
     *            What to search for. Accepts 'plugins', 'themes', 'core'.
     * @return array Array of language data.
     */
    public static function get_installed_translations($type)
    {
        if ($type !== 'themes' && $type !== 'plugins' && $type !== 'core') {
            return array();
        } 
        
        $dir = 'core' === $type ? '' : "/$type";
        
        if (! is_dir(WP_LANG_DIR)) {
            return array();
        } 
        
        if ($dir && ! is_dir(WP_LANG_DIR . $dir)) {
            return array();
        }  
        
        $files = scandir(WP_LANG_DIR . $dir);
        if (! $files) {
            return array();
        }
        
        $language_data = array();
        
        foreach ($files as $file) {
            if ('.' === $file[0] || is_dir($file)) {
                continue;
            }
                
            if (substr($file, - 3) !== '.po') {
                continue;
            }
                
            if (! preg_match('/(?:(.+)-)?([A-Za-z_]{2,6}).po/', $file, $match)) {
                continue;
            }
            
            list (, $textdomain, $language) = $match;
            if ('' === $textdomain) {
                $textdomain = 'default';
            }
                
            $language_data[$textdomain][$language] = self::get_pomo_file_data(WP_LANG_DIR . "$dir/$file");
        }
        return $language_data;
    }

    /**
     * Extract headers from a PO file.
     *
     * @since 3.2.0
     *       
     * @param string $po_file
     *            Path to PO file.
     * @return array PO file headers.
     */
    public static function get_pomo_file_data($po_file)
    {
        $headers = File::get_file_data($po_file, array(
            'POT-Creation-Date' => '"POT-Creation-Date',
            'PO-Revision-Date' => '"PO-Revision-Date',
            'Project-Id-Version' => '"Project-Id-Version',
            'X-Generator' => '"X-Generator'
        ));
        foreach ($headers as $header => $value) {
            // Remove possible contextual '\n' and closing double quote.
            $headers[$header] = preg_replace('~(\\\n)?"$~', '', $value);
        }
        return $headers;
    }
}


// end