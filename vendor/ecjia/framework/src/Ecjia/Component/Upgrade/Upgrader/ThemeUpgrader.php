<?php
namespace Ecjia\Component\Upgrade\Upgrader;

use RC_Format;
use RC_Hook;
use Ecjia\Component\Upgrade\Upgrader;

/**
 * Theme Upgrader class for ECJia Themes, It is designed to upgrade/install themes from a local zip, remote zip URL, or uploaded zip file.
 *
 * @package ECJia
 * @subpackage Upgrader
 * @since 2.8.0
 */
class ThemeUpgrader extends Upgrader
{
    protected $bulk = false;

    /**
     * Upgrade strings
     */
    public function upgrade_strings()
    {
        $this->strings['up_to_date'] = __('The theme is at the latest version.', 'ecjia');
        $this->strings['no_package'] = __('Update package not available.', 'ecjia');
        $this->strings['downloading_package'] = __('Downloading update from <span class="code">%s</span>&#8230;', 'ecjia');
        $this->strings['unpack_package'] = __('Unpacking the update&#8230;', 'ecjia');
        $this->strings['remove_old'] = __('Removing the old version of the theme&#8230;', 'ecjia');
        $this->strings['remove_old_failed'] = __('Could not remove the old theme.', 'ecjia');
        $this->strings['process_failed'] = __('Theme update failed.', 'ecjia');
        $this->strings['process_success'] = __('Theme updated successfully.', 'ecjia');
    }

    /**
     * Install strings
     */
    public function install_strings()
    {
        $this->strings['no_package'] = __('Install package not available.', 'ecjia');
        $this->strings['downloading_package'] = __('Downloading install package from <span class="code">%s</span>&#8230;', 'ecjia');
        $this->strings['unpack_package'] = __('Unpacking the package&#8230;', 'ecjia');
        $this->strings['installing_package'] = __('Installing the theme&#8230;', 'ecjia');
        $this->strings['no_files'] = __('The theme contains no files.', 'ecjia');
        $this->strings['process_failed'] = __('Theme install failed.', 'ecjia');
        $this->strings['process_success'] = __('Theme installed successfully.', 'ecjia');
        /* translators: 1: theme name, 2: version */
        $this->strings['process_success_specific'] = __('Successfully installed the theme <strong>%1$s %2$s</strong>.', 'ecjia');
        $this->strings['parent_theme_search'] = __('This theme requires a parent theme. Checking if it is installed&#8230;', 'ecjia');
        /* translators: 1: theme name, 2: version */
        $this->strings['parent_theme_prepare_install'] = __('Preparing to install <strong>%1$s %2$s</strong>&#8230;', 'ecjia');
        /* translators: 1: theme name, 2: version */
        $this->strings['parent_theme_currently_installed'] = __('The parent theme, <strong>%1$s %2$s</strong>, is currently installed.', 'ecjia');
        /* translators: 1: theme name, 2: version */
        $this->strings['parent_theme_install_success'] = __('Successfully installed the parent theme, <strong>%1$s %2$s</strong>.', 'ecjia');
        $this->strings['parent_theme_not_found'] = __('<strong>The parent theme could not be found.</strong> You will need to install the parent theme, <strong>%s</strong>, before you can use this child theme.', 'ecjia');
    }
    
    
    public function check_parent_theme_filter($install_result, $hook_extra, $child_result)
    {
        // Check to see if we need to install a parent theme
        $theme_info = $this->theme_info();
    
        if ( ! $theme_info->parent() )
            return $install_result;
    
        $this->skin->feedback( 'parent_theme_search' );
    
        if ( ! $theme_info->parent()->errors() ) {
            $this->skin->feedback( 'parent_theme_currently_installed', $theme_info->parent()->display('Name'), $theme_info->parent()->display('Version') );
            // We already have the theme, fall through.
            return $install_result;
        }
    
        // We don't have the parent theme, lets install it
        $api = themes_api('theme_information', array('slug' => $theme_info->get('Template'), 'fields' => array('sections' => false, 'tags' => false) ) ); //Save on a bit of bandwidth.
    
        if ( ! $api || is_ecjia_error($api) ) {
            $this->skin->feedback( 'parent_theme_not_found', $theme_info->get('Template') );
            // Don't show activate or preview actions after install
            RC_Hook::add_filter('install_theme_complete_actions', array($this, 'hide_activate_preview_actions') );
            return $install_result;
        }
    
        // Backup required data we're going to override:
        $child_api = $this->skin->api;
        $child_success_message = $this->strings['process_success'];
    
        // Override them
        $this->skin->api = $api;
        $this->strings['process_success_specific'] = $this->strings['parent_theme_install_success'];//, $api->name, $api->version);
    
        $this->skin->feedback('parent_theme_prepare_install', $api->name, $api->version);
    
        RC_Hook::add_filter('install_theme_complete_actions', '__return_false', 999); // Don't show any actions after installing the theme.
    
        // Install the parent theme
        $parent_result = $this->run( array(
            'package' => $api->download_link,
            'destination' => get_theme_root(),
            'clear_destination' => false, //Do not overwrite files.
            'clear_working' => true
        ) );
    
        if ( is_ecjia_error($parent_result) )
            RC_Hook::add_filter('install_theme_complete_actions', array($this, 'hide_activate_preview_actions') );
    
        // Start cleaning up after the parents installation
        RC_Hook::remove_filter('install_theme_complete_actions', '__return_false', 999);
    
        // Reset child's result and data
        $this->result = $child_result;
        $this->skin->api = $child_api;
        $this->strings['process_success'] = $child_success_message;
    
        return $install_result;
    }
    
    public function hide_activate_preview_actions($actions)
    {
        unset($actions['activate'], $actions['preview']);
        return $actions;
    }

    /**
     * Install theme.
     *
     * @param $package
     * @param array $args
     * @return array|bool
     */
    public function install( $package, $args = array() )
    {
    
        $defaults = array(
            'clear_update_cache' => true,
        );
        $parsed_args = rc_parse_args( $args, $defaults );
    
        $this->init();
        $this->install_strings();
    
        RC_Hook::add_filter('upgrader_source_selection', array($this, 'check_package') );
        RC_Hook::add_filter('upgrader_post_install', array($this, 'check_parent_theme_filter'), 10, 3);
    
        $this->run( array(
            'package' => $package,
            'destination' => get_theme_root(),
            'clear_destination' => false, //Do not overwrite files.
            'clear_working' => true,
            'hook_extra' => array(
                'type' => 'theme',
                'action' => 'install',
            ),
        ) );
    
        RC_Hook::remove_filter('upgrader_source_selection', array($this, 'check_package') );
        RC_Hook::remove_filter('upgrader_post_install', array($this, 'check_parent_theme_filter'));
    
        if ( ! $this->result || is_ecjia_error($this->result) )
            return $this->result;
    
        // Refresh the Theme Update information
        wp_clean_themes_cache( $parsed_args['clear_update_cache'] );
    
        return true;
    }

    /**
     * Upgrade theme.
     *
     * @param $theme
     * @param array $args
     * @return array|bool
     */
    public function upgrade( $theme, $args = array() )
    {
    
        $defaults = array(
            'clear_update_cache' => true,
        );
        $parsed_args = rc_parse_args( $args, $defaults );
    
        $this->init();
        $this->upgrade_strings();
    
        // Is an update available?
        $current = get_site_transient( 'update_themes' );
        if ( !isset( $current->response[ $theme ] ) ) {
            $this->skin->before();
            $this->skin->set_result(false);
            $this->skin->error( 'up_to_date' );
            $this->skin->after();
            return false;
        }
    
        $r = $current->response[ $theme ];
    
        RC_Hook::add_filter('upgrader_pre_install', array($this, 'current_before'), 10, 2);
        RC_Hook::add_filter('upgrader_post_install', array($this, 'current_after'), 10, 2);
        RC_Hook::add_filter('upgrader_clear_destination', array($this, 'delete_old_theme'), 10, 4);
    
        $this->run( array(
            'package' => $r['package'],
            'destination' => get_theme_root( $theme ),
            'clear_destination' => true,
            'clear_working' => true,
            'hook_extra' => array(
                'theme' => $theme,
                'type' => 'theme',
                'action' => 'update',
            ),
        ) );
    
        RC_Hook::remove_filter('upgrader_pre_install', array($this, 'current_before'));
        RC_Hook::remove_filter('upgrader_post_install', array($this, 'current_after'));
        RC_Hook::remove_filter('upgrader_clear_destination', array($this, 'delete_old_theme'));
    
        if ( ! $this->result || is_ecjia_error($this->result) )
            return $this->result;
    
        wp_clean_themes_cache( $parsed_args['clear_update_cache'] );
    
        return true;
    }

    /**
     * Bulk upgrade theme.
     *
     * @param $themes
     * @param array $args
     * @return array
     */
    public function bulk_upgrade( $themes, $args = array() )
    {
    
        $defaults = array(
            'clear_update_cache' => true,
        );
        $parsed_args = rc_parse_args( $args, $defaults );
    
        $this->init();
        $this->bulk = true;
        $this->upgrade_strings();
    
        $current = get_site_transient( 'update_themes' );
    
        RC_Hook::add_filter('upgrader_pre_install', array($this, 'current_before'), 10, 2);
        RC_Hook::add_filter('upgrader_post_install', array($this, 'current_after'), 10, 2);
        RC_Hook::add_filter('upgrader_clear_destination', array($this, 'delete_old_theme'), 10, 4);
    
        $this->skin->header();
    
        // Connect to the Filesystem first.
        $res = $this->fs_connect( array(WP_CONTENT_DIR) );
        if ( ! $res ) {
            $this->skin->footer();
            return false;
        }
    
        $this->skin->bulk_header();
    
        // Only start maintenance mode if:
        // - running Multisite and there are one or more themes specified, OR
        // - a theme with an update available is currently in use.
        // @TODO: For multisite, maintenance mode should only kick in for individual sites if at all possible.
        $maintenance = ( is_multisite() && ! empty( $themes ) );
        foreach ( $themes as $theme )
            $maintenance = $maintenance || $theme == get_stylesheet() || $theme == get_template();
        if ( $maintenance )
            $this->maintenance_mode(true);
    
        $results = array();
    
        $this->update_count = count($themes);
        $this->update_current = 0;
        foreach ( $themes as $theme ) {
            $this->update_current++;
    
            $this->skin->theme_info = $this->theme_info($theme);
    
            if ( !isset( $current->response[ $theme ] ) ) {
                $this->skin->set_result(true);
                $this->skin->before();
                $this->skin->feedback( 'up_to_date' );
                $this->skin->after();
                $results[$theme] = true;
                continue;
            }
    
            // Get the URL to the zip file
            $r = $current->response[ $theme ];
    
            $result = $this->run( array(
                'package' => $r['package'],
                'destination' => get_theme_root( $theme ),
                'clear_destination' => true,
                'clear_working' => true,
                'hook_extra' => array(
                    'theme' => $theme
                ),
            ) );
    
            $results[$theme] = $this->result;
    
            // Prevent credentials auth screen from displaying multiple times
            if ( false === $result )
                break;
        } //end foreach $plugins
    
        $this->maintenance_mode(false);
    
        /** This action is documented in wp-admin/includes/class-wp-upgrader.php */
        RC_Hook::do_action( 'upgrader_process_complete', $this, array(
        'action' => 'update',
        'type' => 'theme',
        'bulk' => true,
        'themes' => $themes,
        ) );
    
        $this->skin->bulk_footer();
    
        $this->skin->footer();
    
        // Cleanup our hooks, in case something else does a upgrade on this connection.
        RC_Hook::remove_filter('upgrader_pre_install', array($this, 'current_before'));
        RC_Hook::remove_filter('upgrader_post_install', array($this, 'current_after'));
        RC_Hook::remove_filter('upgrader_clear_destination', array($this, 'delete_old_theme'));
    
        // Refresh the Theme Update information
        wp_clean_themes_cache( $parsed_args['clear_update_cache'] );
    
        return $results;
    }

    /**
     * Check package theme.
     *
     * @param $source
     * @return ecjia_error
     */
    public function check_package($source)
    {
        global $wp_filesystem;
    
        if ( is_ecjia_error($source) )
            return $source;
    
        // Check the folder contains a valid theme
        $working_directory = str_replace( $wp_filesystem->wp_content_dir(), trailingslashit(WP_CONTENT_DIR), $source);
        if ( ! is_dir($working_directory) ) // Sanity check, if the above fails, lets not prevent installation.
            return $source;
    
        // A proper archive should have a style.css file in the single subdirectory
        if ( ! file_exists( $working_directory . 'style.css' ) )
            return new ecjia_error( 'incompatible_archive_theme_no_style', $this->strings['incompatible_archive'], __( 'The theme is missing the <code>style.css</code> stylesheet.', 'ecjia') );
    
        $info = get_file_data( $working_directory . 'style.css', array( 'Name' => 'Theme Name', 'Template' => 'Template' ) );
    
        if ( empty( $info['Name'] ) )
            return new ecjia_error( 'incompatible_archive_theme_no_name', $this->strings['incompatible_archive'], __( "The <code>style.css</code> stylesheet doesn't contain a valid theme header.", 'ecjia') );
    
        // If it's not a child theme, it must have at least an index.php to be legit.
        if ( empty( $info['Template'] ) && ! file_exists( $working_directory . 'index.php' ) )
            return new ecjia_error( 'incompatible_archive_theme_no_index', $this->strings['incompatible_archive'], __( 'The theme is missing the <code>index.php</code> file.', 'ecjia') );
    
        return $source;
    }
    
    public function current_before($return, $theme)
    {
    
        if ( is_ecjia_error($return) )
            return $return;
    
        $theme = isset($theme['theme']) ? $theme['theme'] : '';
    
        if ( $theme != get_stylesheet() ) //If not current
            return $return;
        //Change to maintenance mode now.
        if ( ! $this->bulk )
            $this->maintenance_mode(true);
    
        return $return;
    }
    
    public function current_after($return, $theme)
    {
        if ( is_ecjia_error($return) )
            return $return;
    
        $theme = isset($theme['theme']) ? $theme['theme'] : '';
    
        if ( $theme != get_stylesheet() ) // If not current
            return $return;
    
        // Ensure stylesheet name hasn't changed after the upgrade:
        if ( $theme == get_stylesheet() && $theme != $this->result['destination_name'] ) {
            wp_clean_themes_cache();
            $stylesheet = $this->result['destination_name'];
            switch_theme( $stylesheet );
        }
    
        //Time to remove maintenance mode
        if ( ! $this->bulk )
            $this->maintenance_mode(false);
        return $return;
    }

    /**
     * Delete old theme.
     *
     * @param $removed
     * @param $local_destination
     * @param $remote_destination
     * @param $theme
     * @return bool
     */
    public function delete_old_theme( $removed, $local_destination, $remote_destination, $theme )
    {
        global $wp_filesystem;
    
        if ( is_ecjia_error( $removed ) )
            return $removed; // Pass errors through.
    
        if ( ! isset( $theme['theme'] ) )
            return $removed;
    
        $theme = $theme['theme'];
        $themes_dir = RC_Format::trailingslashit( $wp_filesystem->wp_themes_dir( $theme ) );
        if ( $wp_filesystem->exists( $themes_dir . $theme ) ) {
            if ( ! $wp_filesystem->delete( $themes_dir . $theme, true ) )
                return false;
        }
    
        return true;
    }
    
    
    public function theme_info($theme = null)
    {
    
        if ( empty($theme) ) {
            if ( !empty($this->result['destination_name']) )
                $theme = $this->result['destination_name'];
            else
                return false;
        }
        return wp_get_theme( $theme );
    }
    
}

// end