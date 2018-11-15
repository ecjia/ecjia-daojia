<?php namespace Royalcms\Component\Foundation;

use RC_Hook;
use Royalcms\Component\Support\Format;
use Royalcms\Component\Support\Facades\File;
use RC_Cache;
use RC_Locale;

class Plugin extends RoyalcmsObject
{
    
    /**
     * Check the plugins directory and retrieve all plugin files with plugin data.
     *
     * Royalcms only supports plugin files in the base plugins directory
     * (content/plugins) and in one directory above the plugins directory
     * (content/plugins/my-plugin). The file it looks for has the plugin data and
     * must be found in those two locations. It is recommended that do keep your
     * plugin files in directories.
     *
     * The file with the plugin data is the file that will be included and therefore
     * needs to have the main execution for the plugin. This does not mean
     * everything must be contained in the file and it is recommended that the file
     * be split for maintainability. Keep everything in one file for extreme
     * optimization purposes.
     *
     * @since 1.5.0
     *
     * @param string $plugin_folder Optional. Relative path to single plugin folder.
     * @return array Key is the plugin file path and the value is an array of the plugin data.
     */
    public static function get_plugins($plugin_folder = '') {
        if ( ! $cache_plugins = RC_Cache::app_cache_get('plugins', 'system') ) {
            $cache_plugins = array();
        }
    
        if ( isset($cache_plugins[ $plugin_folder ]) ) {
            return $cache_plugins[ $plugin_folder ];
        }
    
        $rc_plugins = array ();
        $plugin_roots = array(
            RC_PLUGIN_PATH,
            SITE_PLUGIN_PATH
        );
        
        foreach ($plugin_roots as $plugin_root) {
            if ( !empty($plugin_folder) ) {
                $plugin_root .= $plugin_folder;
            }
            
            // Files in content/plugins directory
            $plugins_dir = @ opendir( $plugin_root);
            $plugin_files = array();
            if ( $plugins_dir ) {
                while (($file = readdir( $plugins_dir ) ) !== false ) {
                    if ( substr($file, 0, 1) == '.' ) {
                        continue;
                    }
                        
                    if ( is_dir( $plugin_root.'/'.$file ) ) {
                        $plugins_subdir = @ opendir( $plugin_root.'/'.$file );
                        if ( $plugins_subdir ) {
                            while (($subfile = readdir( $plugins_subdir ) ) !== false ) {
                                if ( substr($subfile, 0, 1) == '.' ) {
                                    continue;
                                }
                                    
                                if ( substr($subfile, -4) == '.php' ) {
                                    $plugin_files[] = "$file/$subfile";
                                }    
                            }
                            closedir( $plugins_subdir );
                        }
                    } else {
                        if ( substr($file, -4) == '.php' )
                            $plugin_files[] = $file;
                    }
                }
                closedir( $plugins_dir );
            }
            
            if ( empty($plugin_files) ) {
                return $rc_plugins;
            }
            
            foreach ( $plugin_files as $plugin_file ) {
                if ( !is_readable( "$plugin_root/$plugin_file" ) ) {
                    continue;
                } 
            
                $plugin_data = self::get_plugin_data( "$plugin_root/$plugin_file", false, false ); //Do not apply markup/translate as it'll be cached.
            
                if ( empty ( $plugin_data['Name'] ) ) {
                    continue;
                }  
            
                $rc_plugins[self::plugin_basename( $plugin_file )] = $plugin_data;
            }
            
            uasort( $rc_plugins, array(__CLASS__, '_sort_uname_callback') );
        }
        
        $cache_plugins[ $plugin_folder ] = $rc_plugins;
        RC_Cache::app_cache_set('plugins', $cache_plugins, 'system');
    
        return $rc_plugins;
    }
    
    
    /**
     * Callback to sort array by a 'Name' key.
     *
     * @since 3.1.0
     * @access private
     */
    public static function _sort_uname_callback( $a, $b ) {
        return strnatcasecmp( $a['Name'], $b['Name'] );
    }
    
    
    /**
     * Parse the plugin contents to retrieve plugin's metadata.
     *
     * The metadata of the plugin's data searches for the following in the plugin's
     * header. All plugin data must be on its own line. For plugin description, it
     * must not have any newlines or only parts of the description will be displayed
     * and the same goes for the plugin data. The below is formatted for printing.
     *
     * <code>
     * /*
     * Plugin Name: Name of Plugin
     * Plugin URI: Link to plugin information
     * Description: Plugin Description
     * Author: Plugin author's name
     * Author URI: Link to the author's web site
     * Version: Must be set in the plugin for Royalcms 3.2+
     * Text Domain: Optional. Unique identifier, should be same as the one used in
     *		plugin_text_domain()
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
     * Plugin data returned array contains the following:
     *		'Name' - Name of the plugin, must be unique.
     *		'Title' - Title of the plugin and the link to the plugin's web site.
     *		'Description' - Description of what the plugin does and/or notes
     *		from the author.
     *		'Author' - The author's name
     *		'AuthorURI' - The authors web site address.
     *		'Version' - The plugin version number.
     *		'PluginURI' - Plugin web site address.
     *		'TextDomain' - Plugin's text domain for localization.
     *		'DomainPath' - Plugin's relative directory path to .mo files.
     *		'PluginApp' - The plugin is subjection APP.
     *
     * Some users have issues with opening large files and manipulating the contents
     * for want is usually the first 1kiB or 2kiB. This function stops pulling in
     * the plugin contents when it has all of the required plugin data.
     *
     * The first 8kiB of the file will be pulled in and if the plugin data is not
     * within that first 8kiB, then the plugin author should correct their plugin
     * and move the plugin data headers to the top.
     *
     * The plugin file is assumed to have permissions to allow for scripts to read
     * the file. This is not checked however and the file is only opened for
     * reading.
     * 
     * @since 3.2.0
     *
     * @param string $plugin_file Path to the plugin file
     * @param bool $markup Optional. If the returned data should have HTML markup applied. Defaults to true.
     * @param bool $translate Optional. If the returned data should be translated. Defaults to true.
     * @return array See above for description.
     */
    public static function get_plugin_data( $plugin_file, $markup = true, $translate = true ) {
    
        $default_headers = array(
            'Name' => 'Plugin Name',
            'PluginURI' => 'Plugin URI',
            'Version' => 'Version',
            'Description' => 'Description',
            'Author' => 'Author',
            'AuthorURI' => 'Author URI',
            'TextDomain' => 'Text Domain',
            'DomainPath' => 'Domain Path',
            'PluginApp'=> 'Plugin App',
        );
    
        $plugin_data = File::get_file_data( $plugin_file, $default_headers, 'plugin' );
        if (empty($plugin_data['PluginApp'])) {
            $plugin_data['PluginApp'] = 'system';
        }
    
        if ( $markup || $translate ) {
            $plugin_data = self::_get_plugin_data_markup_translate( $plugin_file, $plugin_data, $markup, $translate );
        } else {
            $plugin_data['Title']      = $plugin_data['Name'];
            $plugin_data['AuthorName'] = $plugin_data['Author'];
        }
    
        return $plugin_data;
    }
    
    
    /**
     * Sanitizes plugin data, optionally adds markup, optionally translates.
     *
     * @since 3.2.0
     * @access private
     * @see get_plugin_data()
     */
    public static function _get_plugin_data_markup_translate( $plugin_file, $plugin_data, $markup = true, $translate = true ) {
    
        // Sanitize the plugin filename to a WP_PLUGIN_DIR relative path
        $plugin_file = self::plugin_basename( $plugin_file );
    
        // Translate fields
        if ( $translate ) {
            if ( ($textdomain = $plugin_data['TextDomain']) == true ) {
                if ( $plugin_data['DomainPath'] ) {
                    RC_Locale::load_plugin_textdomain( $textdomain, false, dirname( $plugin_file ) . $plugin_data['DomainPath'] );
                } else {
                    RC_Locale::load_plugin_textdomain( $textdomain, false, dirname( $plugin_file ) );
                }
            } elseif ( in_array( basename( $plugin_file ), array( 'hello.php', 'akismet.php' ) ) ) {
                $textdomain = 'default';
            }
            if ( $textdomain ) {
                foreach ( array( 'Name', 'PluginURI', 'Description', 'Author', 'AuthorURI', 'Version' ) as $field ) {
                    $plugin_data[ $field ] = RC_Locale::translate( $plugin_data[ $field ], $textdomain );
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
        $plugin_data['Name']        = Kses::kses( $plugin_data['Name'],        $allowed_tags_in_links );
        $plugin_data['Author']      = Kses::kses( $plugin_data['Author'],      $allowed_tags );
    
        $plugin_data['Description'] = Kses::kses( $plugin_data['Description'], $allowed_tags );
        $plugin_data['Version']     = Kses::kses( $plugin_data['Version'],     $allowed_tags );
    
        $plugin_data['PluginURI']   = Format::esc_url( $plugin_data['PluginURI'] );
        $plugin_data['AuthorURI']   = Format::esc_url( $plugin_data['AuthorURI'] );
    
        $plugin_data['Title']      = $plugin_data['Name'];
        $plugin_data['AuthorName'] = $plugin_data['Author'];
    
        // Apply markup
        if ( $markup ) {
            if ( $plugin_data['PluginURI'] && $plugin_data['Name'] ) {
                $plugin_data['Title'] = '<a href="' . $plugin_data['PluginURI'] . '" title="' . esc_attr__( 'Visit plugin homepage' ) . '">' . $plugin_data['Name'] . '</a>';
            } 
    
            if ( $plugin_data['AuthorURI'] && $plugin_data['Author'] ) {
                $plugin_data['Author'] = '<a href="' . $plugin_data['AuthorURI'] . '" title="' . esc_attr__( 'Visit author homepage' ) . '">' . $plugin_data['Author'] . '</a>';
            }
                
    
            $plugin_data['Description'] = Format::texturize( $plugin_data['Description'] );
    
            if ( $plugin_data['Author'] ) {
                $plugin_data['Description'] .= ' <cite>' . sprintf( __('By %s.'), $plugin_data['Author'] ) . '</cite>';
            }
        }
    
        return $plugin_data;
    }
    
    
    
    /**
     * Clears the Plugins cache used by get_plugins() and by default, the Plugin Update cache.
     *
     * @since 3.0.0
     *
     * @param bool $clear_update_cache Whether to clear the Plugin updates cache
     */
    public static function clean_plugins_cache( $clear_update_cache = true ) {
        if ( $clear_update_cache ) {
        }
        
        RC_Cache::app_cache_delete('plugins', 'system');
    }
    


    /**
     * Retrieve the url to the plugins directory or to a specific file within that directory.
     * You can hardcode the plugin slug in $path or pass __FILE__ as a second argument to get the correct folder name.
     *
     * @since 1.0.0
     *       
     * @param string $path
     *            Optional. Path relative to the plugins url.
     * @param string $plugin
     *            Optional. The plugin file that you want to be relative to - i.e. pass in __FILE__
     * @return string Plugins url link with optional path appended.
     */
    public static function plugins_url($path = '', $plugin = '')
    {
        if (defined('RC_SITE') && strpos($plugin, 'sites' . DS . RC_SITE)) {
            $url = Uri::content_url() . '/plugins';
        } else {
            $url = Uri::home_content_url() . '/plugins';
        }
        
        $url = Uri::set_url_scheme($url);
        
        if (! empty($plugin) && is_string($plugin)) {
            $folder = dirname(self::plugin_basename($plugin));
            if ('.' != $folder) {
                $url .= '/' . ltrim($folder, '/');
            }  
        }
        
        if ($path && is_string($path))
            $url .= '/' . ltrim($path, '/');
        
        /**
         * Filter the URL to the plugins directory.
         *
         * @since 2.8.0
         *       
         * @param string $url
         *            The complete URL to the plugins directory including scheme and path.
         * @param string $path
         *            Path relative to the URL to the plugins directory. Blank string
         *            if no path is specified.
         * @param string $plugin
         *            The plugin file path to be relative to. Blank string if no plugin
         *            is specified.
         */
        return RC_Hook::apply_filters('plugins_url', $url, $path, $plugin);
    }

    /**
     * Gets the URL directory path (with trailing slash) for the plugin __FILE__ passed in
     *
     * @since 2.8.0
     *       
     * @param string $file
     *            The filename of the plugin (__FILE__)
     * @return string the URL path of the directory that contains the plugin
     */
    public static function plugin_dir_url($file)
    {
        return Format::trailingslashit(self::plugins_url('', $file));
    }

    /**
     * Gets the filesystem directory path (with trailing slash) for the plugin __FILE__ passed in
     *
     * @since 2.8.0
     *       
     * @param string $file
     *            The filename of the plugin (__FILE__)
     * @return string the filesystem path of the directory that contains the plugin
     */
    public static function plugin_dir_path($file)
    {
        return Format::trailingslashit(dirname($file));
    }

    /**
     * Gets the basename of a plugin.
     *
     * This method extracts the name of a plugin from its filename.
     *
     * @since 1.5.0
     *       
     * @access private
     *        
     * @param string $file
     *            The filename of plugin.
     * @return string The name of a plugin.
     * @uses WP_PLUGIN_DIR
     */
    public static function plugin_basename($file)
    {
        if (defined('RC_SITE') && strpos($file, 'sites' . DS . RC_SITE)) {
            $realdir = SITE_PLUGIN_PATH;
        } else {
            $realdir = RC_PLUGIN_PATH;
        }

        if (strpos($file, $realdir) === 0) {
            $file = substr($file, strlen($realdir));
        }

        $file = Format::normalize_path($file);
        $dir = Format::normalize_path(SITE_PLUGIN_PATH);

        $file = preg_replace('#^' . preg_quote($dir, '#') . '/#', '', $file); // get relative path from plugins dir
        $file = trim($file, '/');
        return $file;
    }
    
    
    /**
     * Set the activation hook for a plugin.
     *
     * When a plugin is activated, the action 'activate_PLUGINNAME' hook is
     * called. In the name of this hook, PLUGINNAME is replaced with the name
     * of the plugin, including the optional subdirectory. For example, when the
     * plugin is located in content/plugins/sampleplugin/sample.php, then
     * the name of this hook will become 'activate_sampleplugin/sample.php'.
     *
     * When the plugin consists of only one file and is (as by default) located at
     * content/plugins/sample.php the name of this hook will be
     * 'activate_sample.php'.
     *
     * @since 2.0.0
     *
     * @param string $file The filename of the plugin including the path.
     * @param callback $function the function hooked to the 'activate_PLUGIN' action.
     */
    public static function register_activation_hook($file, $function) {
        $file = self::plugin_basename($file);
        RC_Hook::add_action('activate_' . $file, $function);
    }
    
    
    /**
     * Set the deactivation hook for a plugin.
     *
     * When a plugin is deactivated, the action 'deactivate_PLUGINNAME' hook is
     * called. In the name of this hook, PLUGINNAME is replaced with the name
     * of the plugin, including the optional subdirectory. For example, when the
     * plugin is located in content/plugins/sampleplugin/sample.php, then
     * the name of this hook will become 'deactivate_sampleplugin/sample.php'.
     *
     * When the plugin consists of only one file and is (as by default) located at
     * content/plugins/sample.php the name of this hook will be
     * 'deactivate_sample.php'.
     *
     * @since 2.0.0
     *
     * @param string $file The filename of the plugin including the path.
     * @param callback $function the function hooked to the 'deactivate_PLUGIN' action.
     */
    public static function register_deactivation_hook($file, $function) {
        $file = self::plugin_basename($file);
        RC_Hook::add_action('deactivate_' . $file, $function);
    }
    
    
    
    /**
     * Get a list of a plugin's files.
     *
     * @since 2.8.0
     *
     * @param string $plugin Plugin ID
     * @return array List of files relative to the plugin root.
     */
    public static function get_plugin_files($plugin) {
        $plugin_file = SITE_PLUGIN_PATH . $plugin;
        $dir = dirname($plugin_file);
        $plugin_files = array($plugin);
        if ( is_dir($dir) && $dir != SITE_PLUGIN_PATH ) {
            $plugins_dir = @ opendir( $dir );
            if ( $plugins_dir ) {
                while (($file = readdir( $plugins_dir ) ) !== false ) {
                    if ( substr($file, 0, 1) == '.' ) {
                        continue;
                    }
                        
                    if ( is_dir( $dir . '/' . $file ) ) {
                        $plugins_subdir = @ opendir( $dir . '/' . $file );
                        if ( $plugins_subdir ) {
                            while (($subfile = readdir( $plugins_subdir ) ) !== false ) {
                                if ( substr($subfile, 0, 1) == '.' ) {
                                    continue;
                                }
                                    
                                $plugin_files[] = self::plugin_basename("$dir/$file/$subfile");
                            }
                            @closedir( $plugins_subdir );
                        }
                    } else {
                        if ( self::plugin_basename("$dir/$file") != $plugin ) {
                            $plugin_files[] = self::plugin_basename("$dir/$file");
                        }   
                    }
                }
                @closedir( $plugins_dir );
            }
        }
    
        return $plugin_files;
    }
    
    
    public static function load_files($path) {
        if (is_string($path)) {
            $files = array($path);
        } elseif (is_array($path)) {
            $files = $path;
        } else {
            $files = array();
        }
        
        foreach ($files as $file) {
            if (file_exists(SITE_PLUGIN_PATH . $file)) {
                return require_once SITE_PLUGIN_PATH . $file;
            } elseif (file_exists(RC_PLUGIN_PATH . $file)) {
                return require_once RC_PLUGIN_PATH . $file;
            }
        }

        return false;
    }
    
}

// end