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
 * Plugin Upgrader class for ECJia Plugins, It is designed to upgrade/install plugins from a local zip, remote zip URL, or uploaded zip file.
 *
 * @package WordPress
 * @subpackage Upgrader
 * @since 2.8.0
 */
class ecjia_plugin_upgrader extends ecjia_upgrader {
    public $result;
    public $bulk = false;
    
    function upgrade_strings() {
        $this->strings['up_to_date'] = __('The plugin is at the latest version.');
        $this->strings['no_package'] = __('Update package not available.');
        $this->strings['downloading_package'] = __('Downloading update from <span class="code">%s</span>&#8230;');
        $this->strings['unpack_package'] = __('Unpacking the update&#8230;');
        $this->strings['remove_old'] = __('Removing the old version of the plugin&#8230;');
        $this->strings['remove_old_failed'] = __('Could not remove the old plugin.');
        $this->strings['process_failed'] = __('Plugin update failed.');
        $this->strings['process_success'] = __('Plugin updated successfully.');
    }
    
    function install_strings() {
        $this->strings['no_package'] = __('Install package not available.');
        $this->strings['downloading_package'] = __('Downloading install package from <span class="code">%s</span>&#8230;');
        $this->strings['unpack_package'] = __('Unpacking the package&#8230;');
        $this->strings['installing_package'] = __('Installing the plugin&#8230;');
        $this->strings['no_files'] = __('The plugin contains no files.');
        $this->strings['process_failed'] = __('Plugin install failed.');
        $this->strings['process_success'] = __('Plugin installed successfully.');
    }
    
    function install( $package, $args = array() ) {
    
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
    
    function upgrade( $plugin, $args = array() ) {
    
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
    
    
    function bulk_upgrade( $plugins, $args = array() ) {
    
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
    
    function check_package($source) {
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
            return new ecjia_error( 'incompatible_archive_no_plugins', $this->strings['incompatible_archive'], __( 'No valid plugins were found.' ) );
        }
        
        return $source;
    }
    
    //return plugin info.
    function plugin_info() {
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
    function deactivate_plugin_before_upgrade($return, $plugin) {
    
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
    function delete_old_plugin($removed, $local_destination, $remote_destination, $plugin) {
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