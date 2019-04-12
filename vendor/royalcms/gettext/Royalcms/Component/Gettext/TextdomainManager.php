<?php

namespace Royalcms\Component\Gettext;

use RC_Hook;
use Royalcms\Component\Foundation\Theme;
use Royalcms\Component\Support\Facades\File;
use Royalcms\Component\Gettext\Translations\NoopTranslations;

class TextdomainManager
{
    /**
     * The active l10n instances.
     *
     * @var array
     */
    protected $l10n = array();
    
    
    protected $locale;

    /**
     * @var \Royalcms\Component\Foundation\Royalcms
     */
    protected $royalcms;
    
    /**
     * Create a new TextdomainManager instance.
     *
     * @param  \Royalcms\Component\Gettext\Locale  $locale
     * @return void
     */
    public function __construct(Locale $locale)
    {
        $this->locale = $locale;

        $this->royalcms = royalcms();
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
    public function loadDefaultTextdomain()
    {
        $locale = $this->locale->getLocale();
         
        $this->loadTextdomain('default', \RC_Uri::admin_path() . "languages/$locale/system.mo");
    }
    
    /**
     * Whether there are translations for the text domain.
     *
     * @since 3.0.0
     * @param string $domain Text domain. Unique identifier for retrieving translated strings.
     * @return bool Whether there are translations.
     */
    public function isTextdomainLoaded($domain)
    {
        return isset($this->l10n[$domain]);
    }
    
    
    /**
     * Return the Translations instance for a text domain.
     *
     * If there isn't one, returns empty Translations instance.
     *
     * @param string $domain Text domain. Unique identifier for retrieving translated strings.
     * @return \Royalcms\Component\Gettext\Translations\Translations A Translations instance.
     */
    public function getTranslationsForDomain($domain)
    {
        if (! isset($this->l10n[$domain])) {
            $this->l10n[$domain] = new NoopTranslations();
        }
        return $this->l10n[$domain];
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
     * @param string $domain Text domain. Unique identifier for retrieving translated strings.
     * @param string $mofile Path to the .mo file.
     * @return bool True on success, false on failure.
     */
    public function loadTextdomain($domain, $mofile)
    {
        /**
         * Filter text domain and/or MO file path for loading translations.
         *
         * @since 3.2.0
         *
         * @param bool $override Whether to override the text domain. Default false.
         * @param string $domain Text domain. Unique identifier for retrieving translated strings.
         * @param string $mofile Path to the MO file.
         */
        $plugin_override = RC_Hook::apply_filters('override_load_textdomain', false, $domain, $mofile);
    
        if (true == $plugin_override) {
            return true;
        }
    
        /**
         * Fires before the MO translation file is loaded.
         *
         * @since 2.9.0
         *
         * @param string $domain Text domain. Unique identifier for retrieving translated strings.
         * @param string $mofile Path to the .mo file.
         */
        RC_Hook::do_action('load_textdomain', $domain, $mofile);
    
        /**
         * Filter MO file path for loading translations for a specific text domain.
         *
         * @since 3.2.0
         *
         * @param string $mofile Path to the MO file.
         * @param string $domain Text domain. Unique identifier for retrieving translated strings.
        */
        $mofile = RC_Hook::apply_filters('load_textdomain_mofile', $mofile, $domain);

        if (! is_readable($mofile)) {
            return false;
        }
    
        $mo = new MachineObject();
        if (! $mo->import_from_file($mofile)) {
            return false;
        }
    
        if (isset($l10n[$domain])) {
            $mo->merge_with($this->l10n[$domain]);
        }
    
        $this->l10n[$domain] = &$mo;
    
        return true;
    }
    
    /**
     * Unload translations for a text domain.
     *
     * @since 3.0.0
     *
     * @param string $domain Text domain. Unique identifier for retrieving translated strings.
     * @return bool Whether textdomain was unloaded.
     */
    public function unloadTextdomain($domain)
    {
        /**
         * Filter the text domain for loading translation.
         *
         * @since 3.0.0
         *
         * @param bool $override Whether to override unloading the text domain. Default false.
         * @param string $domain Text domain. Unique identifier for retrieving translated strings.
         */
        $plugin_override = RC_Hook::apply_filters('override_unload_textdomain', false, $domain);
    
        if ($plugin_override) {
            return true;
        }
    
        /**
         * Fires before the text domain is unloaded.
         *
         * @since 3.0.0
         *
         * @param string $domain Text domain. Unique identifier for retrieving translated strings.
         */
        RC_Hook::do_action('unload_textdomain', $domain);
    
        if (isset($this->l10n[$domain])) {
            unset($this->l10n[$domain]);
            return true;
        }
    
        return false;
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
     * @param string $domain Text domain. Unique identifier for retrieving translated strings.
     * @param string $path   Optional. Path to the directory containing the .mo file.
     *            Default false.
     * @return bool          True when textdomain is successfully loaded, false otherwise.
     */
    public function loadThemeTextdomain($domain, $path = false)
    {
        $locale = $this->locale->getLocale();
        /**
         * Filter a theme's locale.
         *
         * @since 3.2.0
         *
         * @param string $locale The theme's current locale.
         * @param string $domain Text domain. Unique identifier for retrieving translated strings.
        */
        $locale = RC_Hook::apply_filters('theme_locale', $locale, $domain);
    
        if (! $path) {
            $path = Theme::get_template_directory();
        }
    
        $path = rtrim($path, '/');
        // Load the textdomain according to the theme
        $mofile = "{$path}/languages/{$locale}/{$domain}.mo";
        $loaded = $this->loadTextdomain($domain, $mofile);
        if ($loaded) {
            return $loaded;
        }
    
        // Otherwise, load from the languages directory
        $mofile = $this->royalcms->langPath() . "themes/{$domain}-{$locale}.mo";
        return $this->loadTextdomain($domain, $mofile);
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
     * @param string $domain    Text domain. Unique identifier for retrieving translated strings.
     * @return bool             True when the theme textdomain is successfully loaded, false otherwise.
     */
    public function loadChildThemeTextdomain($domain, $path = false)
    {
        if (! $path) {
            $path = Theme::get_template_directory();
        }
    
        return $this->loadThemeTextdomain($domain, $path);
    }
    
    /**
     * Load a app's translated strings.
     *
     * If the path is not given then it will be the root of the app directory.
     *
     * The .mo file should be named based on the text domain with a dash, and then the locale exactly.
     *
     * @since 3.2.0
     *
     * @param string $domain            Unique identifier for retrieving translated strings
     * @param string $app_rel_path      Optional. Relative path to SITE_APP_PATH where the .mo file resides.
     */
    public function loadAppTextdomain($domain, $app_rel_path = false)
    {
        $locale = $this->locale->getLocale();
        /**
         * Filter a plugin's locale.
         *
         * @since 3.2.0
         *
         * @param string $locale The plugin's current locale.
         * @param string $domain Text domain. Unique identifier for retrieving translated strings.
        */
        $locale = RC_Hook::apply_filters('app_locale', $locale, $domain);
    
        if (false !== $app_rel_path) {
            $path = $this->royalcms->appPath() . trim($app_rel_path, '/');
        } else {
            $path = rtrim($this->royalcms->appPath(), '/');
        }

        // Load the textdomain according to the app first
        $mofile = "{$domain}/languages/{$locale}/{$domain}.mo";
        $loaded = $this->loadTextdomain($domain, $path . '/' . $mofile);
        if ($loaded) {
            return $loaded;
        }

        // Otherwise, load from the languages directory
        $mofile = $this->royalcms->langPath() . '/apps/' . $domain . '-' . $locale . '.mo';
        return $this->loadTextdomain($domain, $mofile);
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
     * @param string $domain Unique identifier for retrieving translated strings
     * @param string $plugin_rel_path Optional. Relative path to SITE_PLUGIN_PATH where the .mo file resides.
     */
    public function loadPluginTextdomain($domain, $plugin_rel_path = false)
    {
        $locale = $this->locale->getLocale();
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
        $locale = RC_Hook::apply_filters('plugin_locale', $locale, $domain);

        if (false !== $plugin_rel_path) {
            $path = $this->royalcms->pluginPath() . trim($plugin_rel_path, '/');
        } else {
            $path = rtrim($this->royalcms->pluginPath(), '/');
        }

        // Load the textdomain according to the plugin first
        $mofile = "{$domain}/languages/{$locale}/{$domain}.mo";
        $loaded = $this->loadTextdomain($domain, $path . '/' . $mofile);
        if ($loaded) {
            return $loaded;
        }

        // Otherwise, load from the languages directory
        $mofile = $this->royalcms->langPath() . '/plugins/' . $domain . '-' . $locale . '.mo';
        return $this->loadTextdomain($domain, $mofile);
    }
    
    
    /**
     * Get all available languages based on the presence of *.mo files in a given directory.
     *
     * The default directory is SITE_LANG_PATH.
     *
     * @since 3.0.0
     *
     * @param string $dir A directory to search for language files.
     *            Default SITE_LANG_PATH.
     * @return array An array of language codes or an empty array if no languages are present. Language codes are formed by stripping the .mo extension from the language file names.
     */
    public function getAvailableLanguages($dir = null)
    {
        $languages = array();
    
        foreach ((array) glob((is_null($dir) ? SITE_LANG_PATH : $dir) . '/*.mo') as $lang_file) {
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
     * Looks in the content/languages directory for translations of
     * plugins or themes.
     *
     * @since 3.2.0
     *
     * @param string $type  What to search for. Accepts 'plugins', 'themes', 'core'.
     * @return array        Array of language data.
     */
    public function getInstalledTranslations($type)
    {
        if ($type !== 'themes' && $type !== 'plugins' && $type !== 'core') {
            return array();
        }
    
        $dir = 'core' === $type ? '' : "/$type";
    
        if (! is_dir(SITE_LANG_PATH)) {
            return array();
        }
    
        if ($dir && ! is_dir(SITE_LANG_PATH . $dir)) {
            return array();
        }
    
        $files = scandir(SITE_LANG_PATH . $dir);
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
    
            $language_data[$textdomain][$language] = $this->getPomoFileData(SITE_LANG_PATH . "$dir/$file");
        }
        return $language_data;
    }
    
    /**
     * Extract headers from a PO file.
     *
     * @since 3.2.0
     *
     * @param string $po_file   Path to PO file.
     * @return array            PO file headers.
     */
    public function getPomoFileData($po_file)
    {
        $headers = File::get_file_data($po_file, array(
            'POT-Creation-Date'     => '"POT-Creation-Date',
            'PO-Revision-Date'      => '"PO-Revision-Date',
            'Project-Id-Version'    => '"Project-Id-Version',
            'X-Generator'           => '"X-Generator'
        ));
        foreach ($headers as $header => $value) {
            // Remove possible contextual '\n' and closing double quote.
            $headers[$header] = preg_replace('~(\\\n)?"$~', '', $value);
        }
        return $headers;
    }
}

// end