<?php
namespace Ecjia\Component\Upgrade\Upgrader;

use RC_Format;
use RC_Hook;
use ecjia_error;
use Ecjia\Component\Upgrade\Upgrader;

/**
 * Plugin Upgrader class for ECJia Plugins, It is designed to upgrade/install plugins from a local zip, remote zip URL, or uploaded zip file.
 *
 * @package WordPress
 * @subpackage Upgrader
 * @since 2.8.0
 */
class PluginUpgrader extends Upgrader
{
    protected $bulk = false;
    
    public function upgrade_strings()
    {
        $this->strings['up_to_date'] = __('The plugin is at the latest version.', 'ecjia');
        $this->strings['no_package'] = __('Update package not available.', 'ecjia');
        $this->strings['downloading_package'] = __('Downloading update from <span class="code">%s</span>&#8230;', 'ecjia');
        $this->strings['unpack_package'] = __('Unpacking the update&#8230;', 'ecjia');
        $this->strings['remove_old'] = __('Removing the old version of the plugin&#8230;', 'ecjia');
        $this->strings['remove_old_failed'] = __('Could not remove the old plugin.', 'ecjia');
        $this->strings['process_failed'] = __('Plugin update failed.', 'ecjia');
        $this->strings['process_success'] = __('Plugin updated successfully.', 'ecjia');
    }
    
    public function install_strings()
    {
        $this->strings['no_package'] = __('Install package not available.', 'ecjia');
        $this->strings['downloading_package'] = __('Downloading install package from <span class="code">%s</span>&#8230;', 'ecjia');
        $this->strings['unpack_package'] = __('Unpacking the package&#8230;', 'ecjia');
        $this->strings['installing_package'] = __('Installing the plugin&#8230;', 'ecjia');
        $this->strings['no_files'] = __('The plugin contains no files.', 'ecjia');
        $this->strings['process_failed'] = __('Plugin install failed.', 'ecjia');
        $this->strings['process_success'] = __('Plugin installed successfully.', 'ecjia');
    }
    
    public function install( $package, $args = array() )
    {
    
        $defaults = array(
            'clear_update_cache' => true,
        );
        $parsed_args = rc_parse_args( $args, $defaults );
    
        $this->init();
        $this->install_strings();
    
        RC_Hook::add_filter('upgrader_source_selection', array($this, 'check_package') );
    
        $this->run( array(
            'package' => $package,
            'destination' => WP_PLUGIN_DIR,
            'clear_destination' => false, // Do not overwrite files.
            'clear_working' => true,
            'hook_extra' => array(
                'type' => 'plugin',
                'action' => 'install',
            )
        ) );
    
        RC_Hook::remove_filter('upgrader_source_selection', array($this, 'check_package') );
    
        if ( ! $this->result || is_ecjia_error($this->result) )
            return $this->result;
    
        // Force refresh of plugin update information
        wp_clean_plugins_cache( $parsed_args['clear_update_cache'] );
    
        return true;
    }
    
    public function upgrade( $plugin, $args = array() )
    {
    
        $defaults = array(
            'clear_update_cache' => true,
        );
        $parsed_args = rc_parse_args( $args, $defaults );
    
        $this->init();
        $this->upgrade_strings();
    
        $current = get_site_transient( 'update_plugins' );
        if ( !isset( $current->response[ $plugin ] ) ) {
            $this->skin->before();
            $this->skin->set_result(false);
            $this->skin->error('up_to_date');
            $this->skin->after();
            return false;
        }
    
        // Get the URL to the zip file
        $r = $current->response[ $plugin ];
    
        RC_Hook::add_filter('upgrader_pre_install', array($this, 'deactivate_plugin_before_upgrade'), 10, 2);
        RC_Hook::add_filter('upgrader_clear_destination', array($this, 'delete_old_plugin'), 10, 4);
        //'source_selection' => array($this, 'source_selection'), //there's a trac ticket to move up the directory for zip's which are made a bit differently, useful for non-.org plugins.
    
        $this->run( array(
        'package' => $r->package,
        'destination' => WP_PLUGIN_DIR,
        'clear_destination' => true,
        'clear_working' => true,
        'hook_extra' => array(
            'plugin' => $plugin,
            'type' => 'plugin',
            'action' => 'update',
        ),
        ) );
    
        // Cleanup our hooks, in case something else does a upgrade on this connection.
        RC_Hook::remove_filter('upgrader_pre_install', array($this, 'deactivate_plugin_before_upgrade'));
        RC_Hook::remove_filter('upgrader_clear_destination', array($this, 'delete_old_plugin'));
    
        if ( ! $this->result || is_ecjia_error($this->result) )
            return $this->result;
    
        // Force refresh of plugin update information
        wp_clean_plugins_cache( $parsed_args['clear_update_cache'] );
    
        return true;
    }
    
    
    public function bulk_upgrade( $plugins, $args = array() )
    {
    
        $defaults = array(
            'clear_update_cache' => true,
        );
        $parsed_args = rc_parse_args( $args, $defaults );
    
        $this->init();
        $this->bulk = true;
        $this->upgrade_strings();
    
        $current = get_site_transient( 'update_plugins' );
    
        RC_Hook::add_filter('upgrader_clear_destination', array($this, 'delete_old_plugin'), 10, 4);
    
        $this->skin->header();
    
        // Connect to the Filesystem first.
        $res = $this->fs_connect( array(WP_CONTENT_DIR, WP_PLUGIN_DIR) );
        if ( ! $res ) {
            $this->skin->footer();
            return false;
        }
    
        $this->skin->bulk_header();
    
        // Only start maintenance mode if:
        // - running Multisite and there are one or more plugins specified, OR
        // - a plugin with an update available is currently active.
        // @TODO: For multisite, maintenance mode should only kick in for individual sites if at all possible.
        $maintenance = ( is_multisite() && ! empty( $plugins ) );
        foreach ( $plugins as $plugin )
            $maintenance = $maintenance || ( is_plugin_active( $plugin ) && isset( $current->response[ $plugin] ) );
        if ( $maintenance )
            $this->maintenance_mode(true);
    
        $results = array();
    
        $this->update_count = count($plugins);
        $this->update_current = 0;
        foreach ( $plugins as $plugin ) {
            $this->update_current++;
            $this->skin->plugin_info = get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin, false, true);
    
            if ( !isset( $current->response[ $plugin ] ) ) {
                $this->skin->set_result('up_to_date');
                $this->skin->before();
                $this->skin->feedback('up_to_date');
                $this->skin->after();
                $results[$plugin] = true;
                continue;
            }
    
            // Get the URL to the zip file
            $r = $current->response[ $plugin ];
    
            $this->skin->plugin_active = is_plugin_active($plugin);
    
            $result = $this->run( array(
                'package' => $r->package,
                'destination' => WP_PLUGIN_DIR,
                'clear_destination' => true,
                'clear_working' => true,
                'is_multi' => true,
                'hook_extra' => array(
                    'plugin' => $plugin
                )
            ) );
    
            $results[$plugin] = $this->result;
    
            // Prevent credentials auth screen from displaying multiple times
            if ( false === $result )
                break;
        } //end foreach $plugins
    
        $this->maintenance_mode(false);
    
        /**
         * Fires when the bulk upgrader process is complete.
         *
         * @since 3.6.0
         *
         * @param Plugin_Upgrader $this Plugin_Upgrader instance. In other contexts, $this, might
         *                              be a Theme_Upgrader or Core_Upgrade instance.
         * @param array           $data {
         *     Array of bulk item update data.
         *
         *     @type string $action   Type of action. Default 'update'.
         *     @type string $type     Type of update process. Accepts 'plugin', 'theme', or 'core'.
         *     @type bool   $bulk     Whether the update process is a bulk update. Default true.
         *     @type array  $packages Array of plugin, theme, or core packages to update.
         * }
        */
        RC_Hook::do_action( 'upgrader_process_complete', $this, array(
        'action' => 'update',
        'type' => 'plugin',
        'bulk' => true,
        'plugins' => $plugins,
        ) );
    
        $this->skin->bulk_footer();
    
        $this->skin->footer();
    
        // Cleanup our hooks, in case something else does a upgrade on this connection.
        RC_Hook::remove_filter('upgrader_clear_destination', array($this, 'delete_old_plugin'));
    
        // Force refresh of plugin update information
        wp_clean_plugins_cache( $parsed_args['clear_update_cache'] );
    
        return $results;
    }
    
    public function check_package($source)
    {
        global $wp_filesystem;
    
        if ( is_ecjia_error($source) )
            return $source;
    
        $working_directory = str_replace( $wp_filesystem->wp_content_dir(), trailingslashit(WP_CONTENT_DIR), $source);
        if ( ! is_dir($working_directory) ) // Sanity check, if the above fails, lets not prevent installation.
            return $source;
    
        // Check the folder contains at least 1 valid plugin.
        $plugins_found = false;
        foreach ( glob( $working_directory . '*.php' ) as $file ) {
            $info = get_plugin_data($file, false, false);
            if ( !empty( $info['Name'] ) ) {
                $plugins_found = true;
                break;
            }
        }
    
        if ( ! $plugins_found ) {
            return new ecjia_error( 'incompatible_archive_no_plugins', $this->strings['incompatible_archive'], __( 'No valid plugins were found.', 'ecjia') );
        }
        
        return $source;
    }
    
    //return plugin info.
    public function plugin_info()
    {
        if ( ! is_array($this->result) )
            return false;
        if ( empty($this->result['destination_name']) )
            return false;
    
        $plugin = get_plugins('/' . $this->result['destination_name']); //Ensure to pass with leading slash
        if ( empty($plugin) )
            return false;
    
        $pluginfiles = array_keys($plugin); //Assume the requested plugin is the first in the list
    
        return $this->result['destination_name'] . '/' . $pluginfiles[0];
    }
    
    
    //Hooked to pre_install
    public function deactivate_plugin_before_upgrade($return, $plugin)
    {
    
        if ( is_ecjia_error($return) ) //Bypass.
            return $return;
    
        // When in cron (background updates) don't deactivate the plugin, as we require a browser to reactivate it
        if ( defined( 'DOING_CRON' ) && DOING_CRON )
            return $return;
    
        $plugin = isset($plugin['plugin']) ? $plugin['plugin'] : '';
        if ( empty($plugin) )
            return new ecjia_error('bad_request', $this->strings['bad_request']);
    
        if ( is_plugin_active($plugin) ) {
            //Deactivate the plugin silently, Prevent deactivation hooks from running.
            deactivate_plugins($plugin, true);
        }
    }
    
    //Hooked to upgrade_clear_destination
    public function delete_old_plugin($removed, $local_destination, $remote_destination, $plugin)
    {
        global $wp_filesystem;
    
        if ( is_ecjia_error($removed) )
            return $removed; //Pass errors through.
    
        $plugin = isset($plugin['plugin']) ? $plugin['plugin'] : '';
        if ( empty($plugin) )
            return new ecjia_error('bad_request', $this->strings['bad_request']);
    
        $plugins_dir = $wp_filesystem->wp_plugins_dir();
        $this_plugin_dir = RC_Format::trailingslashit( dirname($plugins_dir . $plugin) );
    
        if ( ! $wp_filesystem->exists($this_plugin_dir) ) //If it's already vanished.
            return $removed;
    
        // If plugin is in its own directory, recursively delete the directory.
        if ( strpos($plugin, '/') && $this_plugin_dir != $plugins_dir ) //base check on if plugin includes directory separator AND that it's not the root plugin folder
            $deleted = $wp_filesystem->delete($this_plugin_dir, true);
        else
            $deleted = $wp_filesystem->delete($plugins_dir . $plugin);
    
        if ( ! $deleted )
            return new ecjia_error('remove_old_failed', $this->strings['remove_old_failed']);
    
        return true;
    }
    
}

// end