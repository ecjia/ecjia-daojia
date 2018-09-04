<?php namespace Royalcms\Component\Foundation;

use Royalcms\Component\Support\Facades\Config;
use RC_Hook;
use Royalcms\Component\Support\Facades\Cache as RC_Cache;
use Royalcms\Component\Support\Format;
use Royalcms\Component\Support\Facades\File as RC_File;
use RC_Locale;

class Theme extends RoyalcmsObject
{
    
    /**
     * Parse the theme contents to retrieve theme's metadata.
     *
     * The metadata of the theme's data searches for the following in the theme's
     * header. All theme data must be on its own line. For theme description, it
     * must not have any newlines or only parts of the description will be displayed
     * and the same goes for the theme data. The below is formatted for printing.
     *
     * <code>
     * /*
     * Template Name: Name of Plugin
     * Template URI: Link to theme information
     * Description: Theme Description
     * Author: Theme author's name
     * Author URI: Link to the author's web site
     * Version: Must be set in the theme for Royalcms 3.2+
     * Text Domain: Optional. Unique identifier, should be same as the one used in
     *		theme_text_domain()
     * Domain Path: Optional. Only useful if the translations are located in a
     *		folder above the plugin's base path. For example, if .mo files are
     *		located in the locale folder then Domain Path will be "/locale/" and
     *		must have the first slash. Defaults to the base folder the plugin is
     *		located in.
     * Network: Optional. Specify "Network: true" to require that a plugin is activated
     *		across all sites in an installation. This will prevent a plugin from being
     *		activated on a single site when Multisite is enabled.
     *  * / # Remove the space to close comment
     * </code>
     *
     * Theme data returned array contains the following:
     *		'Name' - Name of the plugin, must be unique.
     *		'Title' - Title of the plugin and the link to the plugin's web site.
     *		'Description' - Description of what the plugin does and/or notes
     *		from the author.
     *		'Author' - The author's name
     *		'AuthorURI' - The authors web site address.
     *		'Version' - The theme version number.
     *		'TemplateURI' - Theme web site address.
     *		'TextDomain' - Theme's text domain for localization.
     *		'DomainPath' - Theme's relative directory path to .mo files.
     *		'Logo' - The theme is Logo filename.
     *      'TemplateType' - The theme type.
     *      'Color' - The theme color.
     *
     * Some users have issues with opening large files and manipulating the contents
     * for want is usually the first 1kiB or 2kiB. This function stops pulling in
     * the plugin contents when it has all of the required plugin data.
     *
     * The first 8kiB of the file will be pulled in and if the plugin data is not
     * within that first 8kiB, then the plugin author should correct their plugin
     * and move the theme data headers to the top.
     *
     * The plugin file is assumed to have permissions to allow for scripts to read
     * the file. This is not checked however and the file is only opened for
     * reading.
     *
     * @since 3.2.0
     *
     * @param string $theme_file Path to the theme file
     * @param bool $markup Optional. If the returned data should have HTML markup applied. Defaults to true.
     * @param bool $translate Optional. If the returned data should be translated. Defaults to true.
     * @return array See above for description.
     */
    public static function get_theme_data( $theme_file, $markup = true, $translate = true ) {
    
        $default_headers = array(
            'Name' => 'Template Name',
            'TemplateURI' => 'Template URI',
            'Description' => 'Description',
            'Version' => 'Version',
            'Author' => 'Author',
            'AuthorURI' => 'Author URI',
            'TextDomain' => 'Text Domain',
            'DomainPath' => 'Domain Path',
            'Logo'=> 'Logo filename',
            'TemplateType'=> 'Template Type',
            'Color'=> 'Color',
        );
    
        $theme_data = RC_File::get_file_data( $theme_file, $default_headers, 'theme' );
    
        if ( $markup || $translate ) {
            $theme_data = self::_get_theme_data_markup_translate( $theme_file, $theme_data, $markup, $translate );
        } else {
            $theme_data['Title']      = $theme_data['Name'];
            $theme_data['AuthorName'] = $theme_data['Author'];
        }
    
        return $theme_data;
    }
    
    
    /**
     * Sanitizes theme data, optionally adds markup, optionally translates.
     *
     * @since 3.2.0
     * @access private
     * @see get_theme_data()
     */
    public static function _get_theme_data_markup_translate( $theme_file, $theme_data, $markup = true, $translate = true ) {
        // Translate fields
        if ( $translate ) {
            if ( ($textdomain = $theme_data['TextDomain']) == true ) {
                if ( $theme_data['DomainPath'] ) {
                    RC_Locale::load_plugin_textdomain( $textdomain, false, dirname( $theme_file ) . $theme_data['DomainPath'] );
                } else {
                    RC_Locale::load_plugin_textdomain( $textdomain, false, dirname( $theme_file ) );
                }
            } 
            if ( $textdomain ) {
                foreach ( array( 'Name', 'TemplateURI', 'Description', 'Author', 'AuthorURI', 'Version' ) as $field ) {
                    $theme_data[ $field ] = RC_Locale::translate( $theme_data[ $field ], $textdomain );
                }
            }
        }
    
        // Sanitize fields
        $allowed_tags = $allowed_tags_in_links = array(
            'abbr'    => array( 'title' => true ),
            'acronym' => array( 'title' => true ),
            'code'    => true,
            'em'      => true,
            'strong'  => true,
        );
        $allowed_tags['a'] = array( 'href' => true, 'title' => true );
    
        // Name is marked up inside <a> tags. Don't allow these.
        // Author is too, but some plugins have used <a> here (omitting Author URI).
        $theme_data['Name']        = Kses::kses( $theme_data['Name'],        $allowed_tags_in_links );
        $theme_data['Author']      = Kses::kses( $theme_data['Author'],      $allowed_tags );
    
        $theme_data['Description'] = Kses::kses( $theme_data['Description'], $allowed_tags );
        $theme_data['Version']     = Kses::kses( $theme_data['Version'],     $allowed_tags );
    
        $theme_data['TemplateURI']   = Format::esc_url( $theme_data['TemplateURI'] );
        $theme_data['AuthorURI']   = Format::esc_url( $theme_data['AuthorURI'] );
    
        $theme_data['Title']      = $theme_data['Name'];
        $theme_data['AuthorName'] = $theme_data['Author'];
    
        // Apply markup
        if ( $markup ) {
            if ( $theme_data['TemplateURI'] && $theme_data['Name'] ) {
                $theme_data['Title'] = '<a href="' . $theme_data['TemplateURI'] . '" title="' . esc_attr__( 'Visit theme homepage' ) . '">' . $theme_data['Name'] . '</a>';
            }
    
            if ( $theme_data['AuthorURI'] && $theme_data['Author'] ) {
                $theme_data['Author'] = '<a href="' . $theme_data['AuthorURI'] . '" title="' . esc_attr__( 'Visit author homepage' ) . '">' . $theme_data['Author'] . '</a>';
            }
    
    
            $theme_data['Description'] = Format::texturize( $theme_data['Description'] );
    
            if ( $theme_data['Author'] ) {
                $theme_data['Description'] .= ' <cite>' . sprintf( __('By %s.'), $theme_data['Author'] ) . '</cite>';
            }
        }
    
        return $theme_data;
    }

    private static $theme_directories = array();

    /**
     * Retrieve URI for themes directory.
     *
     * Does not have trailing slash.
     *
     * @since 3.0.0
     *       
     * @param string $stylesheet_or_template
     *            Optional. The stylesheet or template name of the theme.
     *            Default is to leverage the main theme root.
     * @param string $theme_root
     *            Optional. The theme root for which calculations will be based, preventing
     *            the need for a get_raw_theme_root() call.
     * @return string Themes URI.
     */
    public static function get_theme_root_uri($template = false, $theme_root = false)
    {
        if ($template && ! $theme_root) {
            $theme_roots = array();
        }
            
        $theme_roots = self::get_theme_roots();
        if (is_array($theme_roots) && ! empty($theme_roots[$template])) {
            $theme_root = $theme_roots[$template];
        }
        
        if ($template && $theme_root) {
            if (in_array($theme_root, self::$theme_directories)) {
                // Absolute path. Make an educated guess. YMMV -- but note the filter below.
                if (0 === strpos($theme_root, SITE_CONTENT_PATH)) {
                    $theme_root_uri = Uri::content_url(str_replace(SITE_CONTENT_PATH, '', $theme_root));
                } elseif (0 === strpos($theme_root, SITE_PATH)) {
                    $theme_root_uri = Uri::site_url(str_replace(SITE_PATH, '', $theme_root));
                } elseif (0 === strpos($theme_root, SITE_PLUGIN_PATH)) {
                    $theme_root_uri = Plugin::plugins_url(basename($theme_root), $theme_root);
                } else {
                    $theme_root_uri = $theme_root;
                } 
            } else {
                $theme_root_uri = Uri::content_url($theme_root);
            }
        } else {
            $theme_root_uri = Uri::content_url('themes');
        }
        
        /**
         * Filter the URI for themes directory. 
         *
         * @since 3.0.0
         *       
         * @param string $theme_root_uri
         *            The URI for themes directory.
         * @param string $siteurl
         *            Royalcms web address which is set in General Options.
         * @param string $stylesheet_or_template
         *            Stylesheet or template name of the theme.
         */
        return RC_Hook::apply_filters('theme_root_uri', $theme_root_uri, Uri::site_url(), $template);
    }

    /**
     * Retrieve path to themes directory.
     *
     * Does not have trailing slash.
     *
     * @since 3.0.0
     *       
     * @param string $stylesheet_or_template
     *            The stylesheet or template name of the theme
     * @return string Theme path.
     */
    public static function get_theme_root($template = false)
    {
        $theme_roots = self::get_theme_roots();
        if (is_array($theme_roots) && ! empty($theme_roots[$template])) {
            $theme_root = $theme_roots[$template];
        } else {
            $theme_root = null;
        }
        
        if ($template && $theme_root) {
            // Always prepend WP_CONTENT_DIR unless the root currently registered as a theme directory.
            // This gives relative theme roots the benefit of the doubt when things go haywire.
            if (! in_array($theme_root, self::$theme_directories)) {
                $theme_root = SITE_CONTENT_PATH . $theme_root;
            }
        } else {
            $theme_root = SITE_CONTENT_PATH . 'themes';
        }
        
        /**
         * Filter the absolute path to the themes directory.
         *
         * @since 3.0.0
         *       
         * @param string $theme_root
         *            Absolute path to themes directory.
         */
        return RC_Hook::apply_filters('theme_root', $theme_root);
    }

    /**
     * Retrieve theme roots.
     *
     * @since 3.0.0
     *       
     * @return array string array of theme roots keyed by template/stylesheet or a single theme root if all themes have the same root.
     */
    public static function get_theme_roots()
    {
        if (count(self::$theme_directories) <= 1) {
            return '/themes';
        }  
        
        $theme_roots = RC_Cache::app_cache_get('theme_roots', 'system');
        if (false === $theme_roots) {
            self::search_theme_directories(true); // Regenerate the transient.
            $theme_roots = RC_Cache::app_cache_get('theme_roots', 'system');
        }
        
        return $theme_roots;
    }

    /**
     * Retrieve theme directory URI.
     *
     * @since 3.0.0
     *       
     * @return string Template directory URI.
     */
    public static function get_template_directory_uri()
    {
        $template = str_replace('%2F', '/', rawurlencode(self::get_template()));
        $theme_root_uri = self::get_theme_root_uri($template);
        $template_dir_uri = "$theme_root_uri/$template";
        
        /**
         * Filter the current theme directory URI.
         *
         * @since 3.0.0
         *       
         * @param string $template_dir_uri
         *            The URI of the current theme directory.
         * @param string $template
         *            Directory name of the current theme.
         * @param string $theme_root_uri
         *            The themes root URI.
         */
        return RC_Hook::apply_filters('template_directory_uri', $template_dir_uri, $template, $theme_root_uri);
    }

    /**
     * Retrieve current theme directory.
     *
     * @since 3.0.0
     *       
     * @return string Template directory path.
     */
    public static function get_template_directory()
    {
        $template = self::get_template();
        $theme_root = self::get_theme_root($template);
        $template_dir = $theme_root . DIRECTORY_SEPARATOR . $template;
        
        /**
         * Filter the current theme directory path.
         *
         * @since 3.0.0
         *       
         * @param string $template_dir
         *            The URI of the current theme directory.
         * @param string $template
         *            Directory name of the current theme.
         * @param string $theme_root
         *            Absolute path to the themes directory.
         */
        return RC_Hook::apply_filters('template_directory', $template_dir, $template, $theme_root);
    }

    /**
     * Retrieve name of the current theme.
     *
     * @since 3.0.0
     * @uses apply_filters() Calls 'template' filter on template option.
     *      
     * @return string Template name.
     */
    public static function get_template()
    {
        /**
         * Filter the name of the current theme.
         *
         * @since 3.0.0
         *       
         * @param string $template
         *            Current theme's directory name.
         */
        return RC_Hook::apply_filters('template', Config::get('system.tpl_style'));
    }

    /**
     * Search all registered theme directories for complete and valid themes.
     *
     * @since 3.0.0
     *       
     * @param bool $force
     *            Optional. Whether to force a new directory scan. Defaults to false.
     * @return array Valid themes found
     */
    private static function search_theme_directories($force = false)
    {
        if (empty(self::$theme_directories)) {
            return false;
        } 
        
        static $found_themes;
        if (! $force && isset($found_themes)) {
            return $found_themes;
        }  
        
        $found_themes = array();
        
        // Set up maybe-relative, maybe-absolute array of theme directories.
        // We always want to return absolute, but we need to cache relative
        // to use in get_theme_root().
        foreach (self::$theme_directories as $theme_root) {
            if (0 === strpos($theme_root, SITE_CONTENT_PATH)) {
                $relative_theme_roots[str_replace(SITE_CONTENT_PATH, '', $theme_root)] = $theme_root;
            } else {
                $relative_theme_roots[$theme_root] = $theme_root;
            }   
        }
        
        /* Loop the registered theme directories and extract all themes */
        foreach (self::$theme_directories as $theme_root) {
            // Start with directories in the root of the current theme directory.
            $dirs = scandir($theme_root);
            if (! $dirs) {
                trigger_error("$theme_root is not readable", E_USER_NOTICE);
                continue;
            }
            foreach ($dirs as $dir) {
                if (! is_dir($theme_root . '/' . $dir) || $dir[0] == '.' || $dir == 'CVS') {
                    continue;
                }
                    
                if (file_exists($theme_root . '/' . $dir . '/style.css')) {
                    // content/themes/a-single-theme
                    // content/themes is $theme_root, a-single-theme is $dir
                    $found_themes[$dir] = array(
                        'theme_file' => $dir . '/style.css',
                        'theme_root' => $theme_root
                    );
                } else {
                    $found_theme = false;
                    // wp-content/themes/a-folder-of-themes/*
                    // wp-content/themes is $theme_root, a-folder-of-themes is $dir, then themes are $sub_dirs
                    $sub_dirs = scandir($theme_root . '/' . $dir);
                    if (! $sub_dirs) {
                        trigger_error("$theme_root/$dir is not readable", E_USER_NOTICE);
                        continue;
                    }
                    foreach ($sub_dirs as $sub_dir) {
                        if (! is_dir($theme_root . '/' . $dir . '/' . $sub_dir) || $dir[0] == '.' || $dir == 'CVS') {
                            continue;
                        }
                            
                        if (! file_exists($theme_root . '/' . $dir . '/' . $sub_dir . '/style.css')) {
                            continue;
                        }
                            
                        $found_themes[$dir . '/' . $sub_dir] = array(
                            'theme_file' => $dir . '/' . $sub_dir . '/style.css',
                            'theme_root' => $theme_root
                        );
                        $found_theme = true;
                    }
                    // Never mind the above, it's just a theme missing a style.css.
                    // Return it; WP_Theme will catch the error.
                    if (! $found_theme) {
                        $found_themes[$dir] = array(
                            'theme_file' => $dir . '/style.css',
                            'theme_root' => $theme_root
                        );
                    }
                        
                }
            }
        }
        
        asort($found_themes);
        
        $theme_roots = array();
        $relative_theme_roots = array_flip($relative_theme_roots);
        
        foreach ($found_themes as $theme_dir => $theme_data) {
            $theme_roots[$theme_dir] = $relative_theme_roots[$theme_data['theme_root']]; // Convert absolute to relative.
        }
        
        RC_Cache::app_cache_set('theme_roots', $theme_roots, 'system');
        
        return $found_themes;
    }

    /**
     * Register a directory that contains themes.
     *
     * @since 3.0.0
     *       
     * @param string $directory
     *            Either the full filesystem path to a theme folder or a folder within WP_CONTENT_DIR
     * @return bool
     */
    public static function register_theme_directory($directory)
    {
        if (! file_exists($directory)) {
            // Try prepending as the theme directory could be relative to the content directory
            $directory = SITE_CONTENT_PATH . $directory;
            // If this directory does not exist, return and do not register
            if (! file_exists($directory)) {
                return false;
            }    
        }
        
        self::$theme_directories[] = $directory;
        
        return true;
    }
}

// end