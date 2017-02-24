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
defined('IN_ECJIA') or exit('No permission resources.');

class ecjia_plugin {
    /**
     * Validate the plugin path.
     *
     * Checks that the file exists and {@link validate_file() is valid file}.
     *
     * @since 1.0.0
     *
     * @param string $plugin Plugin Path
     * @return ecjia_error|int 0 on success, ecjia_error on failure.
     */
    public static function validate_plugin($plugin) {
        if ( RC_File::validate_file($plugin) )
            return new ecjia_error('plugin_invalid', __('Invalid plugin path.'));
        if ( ! file_exists(SITE_PLUGIN_PATH . '/' . $plugin) && ! file_exists(RC_PLUGIN_PATH . '/' . $plugin) )
            return new ecjia_error('plugin_not_found', __('Plugin file does not exist.'));
    
        $installed_plugins = RC_Plugin::get_plugins();
        if ( ! isset($installed_plugins[$plugin]) )
            return new ecjia_error('no_plugin_header', __('The plugin does not have a valid header.'));
        return 0;
    }
    
    /**
     * Attempts activation of plugin in a "sandbox" and redirects on success.
     *
     * A plugin that is already activated will not attempt to be activated again.
     *
     * The way it works is by setting the redirection to the error before trying to
     * include the plugin file. If the plugin fails, then the redirection will not
     * be overwritten with the success message. Also, the options will not be
     * updated and the activation hook will not be called on plugin error.
     *
     * It should be noted that in no way the below code will actually prevent errors
     * within the file. The code should not be used elsewhere to replicate the
     * "sandbox", which uses redirection to work.
     * {@source 13 1}
     *
     * If any errors are found or text is outputted, then it will be captured to
     * ensure that the success redirection will update the error redirection.
     *
     * @since 1.0.0
     *
     * @param string $plugin Plugin path to main plugin file with plugin data.
     * @param bool $silent Prevent calling activation hooks. Optional, default is false.
     * @return WP_Error|null WP_Error on invalid file or null on success.
     */
    public static function activate_plugin( $plugin, $silent = false ) {
        $plugin = RC_Plugin::plugin_basename( trim( $plugin ) );
    
        $current = ecjia_config::instance()->get_addon_config('active_plugins', true);
        $valid = self::validate_plugin($plugin);
        if ( is_ecjia_error($valid) )
            return $valid;
        
        if ( !in_array($plugin, $current) ) {
            ob_start();
            RC_Plugin::load_files($plugin);
            
            if ( ! $silent ) {
                $all_plugins = RC_Plugin::get_plugins();
                if ($all_plugins[$plugin]['PluginApp'] == 'system') {
                    $plugin_dir = dirname($plugin);
                    $system_plugins = ecjia_config::instance()->get_addon_config('system_plugins', true);
                    $system_plugins[$plugin_dir] = $plugin;
                    ecjia_config::instance()->set_addon_config('system_plugins', $system_plugins, true);
                }
                
                /**
                 * Fires before a plugin is activated.
                 *
                 * If a plugin is silently activated (such as during an update),
                 * this hook does not fire.
                 *
                 * @since 1.0.0
                 *
                 * @param string $plugin       Plugin path to main plugin file with plugin data.
                 * @param bool   $network_wide Whether to enable the plugin for all sites in the network
                 *                             or just the current site. Multisite only. Default is false.
                 */
                RC_Hook::do_action( 'activate_plugin', $plugin );
    
                /**
                 * Fires as a specific plugin is being deactivated.
                 *
                 * This hook is the "deactivation" hook used internally by
                 * register_deactivation_hook(). The dynamic portion of the
                 * hook name, $plugin. refers to the plugin basename.
                 *
                 * If a plugin is silently activated (such as during an update),
                 * this hook does not fire.
                 *
                 * @since 1.0.0
                 *
                 * @param bool $network_wide Whether to enable the plugin for all sites in the network
                 *                           or just the current site. Multisite only. Default is false.
                */
                RC_Hook::do_action( 'activate_' . $plugin );
                
                if (is_ecjia_error(self::$error)) {
                    return self::$error;
                }
            }
    
            //插件安装完成后，更新数据库
            $current[] = $plugin;
            sort($current);
            
            ecjia_config::instance()->set_addon_config('active_plugins', $current, true);
    
            if ( ! $silent ) {
                /**
                 * Fires after a plugin has been activated.
                 *
                 * If a plugin is silently activated (such as during an update),
                 * this hook does not fire.
                 *
                 * @since 1.0.0
                 *
                 * @param string $plugin       Plugin path to main plugin file with plugin data.
                 * @param bool   $network_wide Whether to enable the plugin for all sites in the network
                 *                             or just the current site. Multisite only. Default is false.
                 */
                RC_Hook::do_action( 'activated_plugin', $plugin );
            }
    
            if ( ob_get_length() > 0 ) {
                $output = ob_get_clean();
                return new ecjia_error('unexpected_output', __('The plugin generated unexpected output.'), $output);
            }
            ob_end_clean();
        }
    
        return null;
    }
    
    /**
     * Deactivate a single plugin or multiple plugins.
     *
     * The deactivation hook is disabled by the plugin upgrader by using the $silent
     * parameter.
     *
     * @since 1.0.0
     *
     * @param string|array $plugins Single plugin or list of plugins to deactivate.
     * @param bool $silent Prevent calling deactivation hooks. Default is false.
     * @param mixed $network_wide Whether to deactivate the plugin for all sites in the network.
     * 	A value of null (the default) will deactivate plugins for both the site and the network.
     */
    public static function deactivate_plugins( $plugins, $silent = false ) {
        $current = ecjia_config::instance()->get_addon_config( 'active_plugins', true );
        
        foreach ( (array) $plugins as $plugin ) {
            $plugin = RC_Plugin::plugin_basename( trim( $plugin ) );
            if ( ! self::is_active($plugin) )
                continue;
            
            RC_Plugin::load_files($plugin);
    
            if ( ! $silent ) {
                $all_plugins = RC_Plugin::get_plugins();
                if ($all_plugins[$plugin]['PluginApp'] == 'system') {
                    $plugin_dir = dirname($plugin);
                    $system_plugins = ecjia_config::instance()->get_addon_config('system_plugins', true);
                    unset($system_plugins[$plugin_dir]);
                    ecjia_config::instance()->set_addon_config('system_plugins', $system_plugins, true);
                }
                
                /**
                 * Fires before a plugin is deactivated.
                 *
                 * If a plugin is silently deactivated (such as during an update),
                 * this hook does not fire.
                 *
                 * @since 1.0.0
                 *
                 * @param string $plugin               Plugin path to main plugin file with plugin data.
                 * @param bool   $network_deactivating Whether the plugin is deactivated for all sites in the network
                 *                                     or just the current site. Multisite only. Default is false.
                 */
                RC_Hook::do_action( 'deactivate_plugin', $plugin );
            }
    
            //从数据库中更新插件列表
            $key = array_search( $plugin, $current );
            if ( false !== $key ) {
                unset( $current[ $key ] );
            }
            
            if ( ! $silent ) {
                /**
                 * Fires as a specific plugin is being deactivated.
                 *
                 * This hook is the "deactivation" hook used internally by
                 * register_deactivation_hook(). The dynamic portion of the
                 * hook name, $plugin. refers to the plugin basename.
                 *
                 * If a plugin is silently deactivated (such as during an update),
                 * this hook does not fire.
                 *
                 * @since 1.0.0
                 *
                 * @param bool $network_deactivating Whether the plugin is deactivated for all sites in the network
                 *                                   or just the current site. Multisite only. Default is false.
                 */
                RC_Hook::do_action( 'deactivate_' . $plugin );
                
                if (is_ecjia_error(self::$error)) {
                    return self::$error;
                }
    
                /**
                 * Fires after a plugin is deactivated.
                 *
                 * If a plugin is silently deactivated (such as during an update),
                 * this hook does not fire.
                 *
                 * @since 1.0.0
                 *
                 * @param string $plugin               Plugin basename.
                 * @param bool   $network_deactivating Whether the plugin is deactivated for all sites in the network
                 *                                     or just the current site. Multisite only. Default false.
                */
                RC_Hook::do_action( 'deactivated_plugin', $plugin );
            }
        }
    
        ecjia_config::instance()->set_addon_config('active_plugins', $current, true);
    }
    
    
    /**
     * Check whether the plugin is active by checking the active_plugins list.
     *
     * @since 1.0.0
     *
     * @param string $plugin Base plugin path from plugins directory.
     * @return bool True, if in the active plugins list. False, not in the list.
     */
    public static function is_active( $plugin ) {
        $active_plugins = ecjia_config::instance()->get_addon_config('active_plugins', true);
        return in_array( $plugin, $active_plugins );
    }
    
    
    private static $error = null;
    
    public static function add_error($code = '', $message = '', $data = '') {
        if (is_null(self::$error)) {
            self::$error = new ecjia_error($code, $message, $data);
        } else {
            self::$error->add($code, $message, $data);
        }
        return self::$error;
    }
    
    public static function get_error() {
        return self::$error;
    }
    
    
    /**
     * 获取模板模板绝对路径
     */
    public static function get_plugin_template($path, $plugin) {
        if (RC_Loader::exists_site_plugin($plugin)) {
            $realdir = SITE_PLUGIN_PATH;
        } else {
            $realdir = RC_PLUGIN_PATH;
        }
    
        $tpl_path = $realdir . $plugin . DS . $path;
    
        return str_replace('/', DS, $tpl_path);
    }
    
}


// end