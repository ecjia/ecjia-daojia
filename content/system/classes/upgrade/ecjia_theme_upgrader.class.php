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
 * Theme Upgrader class for ECJia Themes, It is designed to upgrade/install themes from a local zip, remote zip URL, or uploaded zip file.
 *
 * @package ECJia
 * @subpackage Upgrader
 * @since 2.8.0
 */
class ecjia_theme_upgrader extends ecjia_upgrader {
    public $result;
    public $bulk = false;
    
    function upgrade_strings() {
        $this->strings['up_to_date'] = __('The theme is at the latest version.');
        $this->strings['no_package'] = __('Update package not available.');
        $this->strings['downloading_package'] = __('Downloading update from <span class="code">%s</span>&#8230;');
        $this->strings['unpack_package'] = __('Unpacking the update&#8230;');
        $this->strings['remove_old'] = __('Removing the old version of the theme&#8230;');
        $this->strings['remove_old_failed'] = __('Could not remove the old theme.');
        $this->strings['process_failed'] = __('Theme update failed.');
        $this->strings['process_success'] = __('Theme updated successfully.');
    }
    
    
    function install_strings() {
        $this->strings['no_package'] = __('Install package not available.');
        $this->strings['downloading_package'] = __('Downloading install package from <span class="code">%s</span>&#8230;');
        $this->strings['unpack_package'] = __('Unpacking the package&#8230;');
        $this->strings['installing_package'] = __('Installing the theme&#8230;');
        $this->strings['no_files'] = __('The theme contains no files.');
        $this->strings['process_failed'] = __('Theme install failed.');
        $this->strings['process_success'] = __('Theme installed successfully.');
        /* translators: 1: theme name, 2: version */
        $this->strings['process_success_specific'] = __('Successfully installed the theme <strong>%1$s %2$s</strong>.');
        $this->strings['parent_theme_search'] = __('This theme requires a parent theme. Checking if it is installed&#8230;');
        /* translators: 1: theme name, 2: version */
        $this->strings['parent_theme_prepare_install'] = __('Preparing to install <strong>%1$s %2$s</strong>&#8230;');
        /* translators: 1: theme name, 2: version */
        $this->strings['parent_theme_currently_installed'] = __('The parent theme, <strong>%1$s %2$s</strong>, is currently installed.');
        /* translators: 1: theme name, 2: version */
        $this->strings['parent_theme_install_success'] = __('Successfully installed the parent theme, <strong>%1$s %2$s</strong>.');
        $this->strings['parent_theme_not_found'] = __('<strong>The parent theme could not be found.</strong> You will need to install the parent theme, <strong>%s</strong>, before you can use this child theme.');
    }
    
    
    function check_parent_theme_filter($install_result, $hook_extra, $child_result) {
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
    
    function hide_activate_preview_actions($actions) {
        unset($actions['activate'], $actions['preview']);
        return $actions;
    }
    
    function install( $package, $args = array() ) {
    
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
    
    function upgrade( $theme, $args = array() ) {
    
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
    
    function bulk_upgrade( $themes, $args = array() ) {
    
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
    
    function check_package($source) {
        global $wp_filesystem;
    
        if ( is_ecjia_error($source) )
            return $source;
    
        // Check the folder contains a valid theme
        $working_directory = str_replace( $wp_filesystem->wp_content_dir(), trailingslashit(WP_CONTENT_DIR), $source);
        if ( ! is_dir($working_directory) ) // Sanity check, if the above fails, lets not prevent installation.
            return $source;
    
        // A proper archive should have a style.css file in the single subdirectory
        if ( ! file_exists( $working_directory . 'style.css' ) )
            return new ecjia_error( 'incompatible_archive_theme_no_style', $this->strings['incompatible_archive'], __( 'The theme is missing the <code>style.css</code> stylesheet.' ) );
    
        $info = get_file_data( $working_directory . 'style.css', array( 'Name' => 'Theme Name', 'Template' => 'Template' ) );
    
        if ( empty( $info['Name'] ) )
            return new ecjia_error( 'incompatible_archive_theme_no_name', $this->strings['incompatible_archive'], __( "The <code>style.css</code> stylesheet doesn't contain a valid theme header." ) );
    
        // If it's not a child theme, it must have at least an index.php to be legit.
        if ( empty( $info['Template'] ) && ! file_exists( $working_directory . 'index.php' ) )
            return new ecjia_error( 'incompatible_archive_theme_no_index', $this->strings['incompatible_archive'], __( 'The theme is missing the <code>index.php</code> file.' ) );
    
        return $source;
    }
    
    function current_before($return, $theme) {
    
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
    
    function current_after($return, $theme) {
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
    
    function delete_old_theme( $removed, $local_destination, $remote_destination, $theme ) {
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
    
    
    function theme_info($theme = null) {
    
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