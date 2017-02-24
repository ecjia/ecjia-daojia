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
 * Language pack upgrader, for updating translations of plugins, themes, and core.
 *
 * @package ECJia
 * @subpackage Upgrader
 * @since 3.7.0
 */
class ecjia_language_pack_upgrader extends ecjia_upgrader {
    public $result;
    public $bulk = true;
    
    static function async_upgrade( $upgrader = false ) {
        // Avoid recursion.
        if ( $upgrader && $upgrader instanceof ecjia_language_pack_upgrader )
            return;
    
        // Nothing to do?
        $language_updates = wp_get_translation_updates();
        if ( ! $language_updates )
            return;
    
        $skin = new ecjia_language_pack_upgrader_skin( array(
            'skip_header_footer' => true,
        ) );
    
        $lp_upgrader = new ecjia_language_pack_upgrader( $skin );
        $lp_upgrader->upgrade();
    }
    
    function upgrade_strings() {
        $this->strings['starting_upgrade'] = __( 'Some of your translations need updating. Sit tight for a few more seconds while we update them as well.' );
        $this->strings['up_to_date'] = __( 'The translation is up to date.' ); // We need to silently skip this case
        $this->strings['no_package'] = __( 'Update package not available.' );
        $this->strings['downloading_package'] = __( 'Downloading translation from <span class="code">%s</span>&#8230;' );
        $this->strings['unpack_package'] = __( 'Unpacking the update&#8230;' );
        $this->strings['process_failed'] = __( 'Translation update failed.' );
        $this->strings['process_success'] = __( 'Translation updated successfully.' );
    }
    
    function upgrade( $update = false, $args = array() ) {
        if ( $update )
            $update = array( $update );
        $results = $this->bulk_upgrade( $update, $args );
        return $results[0];
    }
    
    function bulk_upgrade( $language_updates = array(), $args = array() ) {
        global $wp_filesystem;
    
        $defaults = array(
            'clear_update_cache' => true,
        );
        $parsed_args = rc_parse_args( $args, $defaults );
    
        $this->init();
        $this->upgrade_strings();
    
        if ( ! $language_updates )
            $language_updates = wp_get_translation_updates();
    
        if ( empty( $language_updates ) ) {
            $this->skin->header();
            $this->skin->before();
            $this->skin->set_result( true );
            $this->skin->feedback( 'up_to_date' );
            $this->skin->after();
            $this->skin->bulk_footer();
            $this->skin->footer();
            return true;
        }
    
        if ( 'upgrader_process_complete' == RC_Hook::current_filter() ) {
            $this->skin->feedback( 'starting_upgrade' );
        }
    
        RC_Hook::add_filter( 'upgrader_source_selection', array( &$this, 'check_package' ), 10, 3 );
    
        $this->skin->header();
    
        // Connect to the Filesystem first.
        $res = $this->fs_connect( array( WP_CONTENT_DIR, WP_LANG_DIR ) );
        if ( ! $res ) {
            $this->skin->footer();
            return false;
        }
    
        $results = array();
    
        $this->update_count = count( $language_updates );
        $this->update_current = 0;
    
        // The filesystem's mkdir() is not recursive. Make sure WP_LANG_DIR exists,
        // as we then may need to create a /plugins or /themes directory inside of it.
        $remote_destination = $wp_filesystem->find_folder( WP_LANG_DIR );
        if ( ! $wp_filesystem->exists( $remote_destination ) )
            if ( ! $wp_filesystem->mkdir( $remote_destination, FS_CHMOD_DIR ) )
                return new ecjia_error( 'mkdir_failed_lang_dir', $this->strings['mkdir_failed'], $remote_destination );
    
            foreach ( $language_updates as $language_update ) {
    
                $this->skin->language_update = $language_update;
    
                $destination = WP_LANG_DIR;
                if ( 'plugin' == $language_update->type )
                    $destination .= '/plugins';
                elseif ( 'theme' == $language_update->type )
                $destination .= '/themes';
    
                $this->update_current++;
    
                $options = array(
                    'package' => $language_update->package,
                    'destination' => $destination,
                    'clear_destination' => false,
                    'abort_if_destination_exists' => false, // We expect the destination to exist.
                    'clear_working' => true,
                    'is_multi' => true,
                    'hook_extra' => array(
                        'language_update_type' => $language_update->type,
                        'language_update' => $language_update,
                    )
                );
    
                $result = $this->run( $options );
    
                $results[] = $this->result;
    
                // Prevent credentials auth screen from displaying multiple times.
                if ( false === $result )
                    break;
            }
    
            $this->skin->bulk_footer();
    
            $this->skin->footer();
    
            // Clean up our hooks, in case something else does an upgrade on this connection.
            RC_Hook::remove_filter( 'upgrader_source_selection', array( &$this, 'check_package' ), 10, 2 );
    
            if ( $parsed_args['clear_update_cache'] ) {
                wp_clean_themes_cache( true );
                wp_clean_plugins_cache( true );
                delete_site_transient( 'update_core' );
            }
    
            return $results;
    }
    
    function check_package( $source, $remote_source ) {
        global $wp_filesystem;
    
        if ( is_ecjia_error( $source ) )
            return $source;
    
        // Check that the folder contains a valid language.
        $files = $wp_filesystem->dirlist( $remote_source );
    
        // Check to see if a .po and .mo exist in the folder.
        $po = $mo = false;
        foreach ( (array) $files as $file => $filedata ) {
            if ( '.po' == substr( $file, -3 ) )
                $po = true;
            elseif ( '.mo' == substr( $file, -3 ) )
            $mo = true;
        }
    
        if ( ! $mo || ! $po )
            return new ecjia_error( 'incompatible_archive_pomo', $this->strings['incompatible_archive'],
                __( 'The language pack is missing either the <code>.po</code> or <code>.mo</code> files.' ) );
    
            return $source;
    }
    
    function get_name_for_update( $update ) {
        switch ( $update->type ) {
            case 'core':
                return 'WordPress'; // Not translated
                break;
            case 'theme':
                $theme = wp_get_theme( $update->slug );
                if ( $theme->exists() )
                    return $theme->Get( 'Name' );
                break;
            case 'plugin':
                $plugin_data = get_plugins( '/' . $update->slug );
                $plugin_data = array_shift( $plugin_data );
                if ( $plugin_data )
                    return $plugin_data['Name'];
                break;
        }
        return '';
    }
}

// end