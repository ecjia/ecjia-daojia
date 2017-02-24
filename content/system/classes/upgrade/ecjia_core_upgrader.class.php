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
 * Core Upgrader class for ECJia. It allows for ECJia to upgrade itself in combination with the wp-admin/includes/update-core.php file
 *
 * @package ECJia
 * @subpackage Upgrader
 * @since 1.4.0
 */
class ecjia_core_upgrader extends ecjia_upgrader {
    function upgrade_strings() {
        $this->strings['up_to_date'] = __('WordPress is at the latest version.');
        $this->strings['no_package'] = __('Update package not available.');
        $this->strings['downloading_package'] = __('Downloading update from <span class="code">%s</span>&#8230;');
        $this->strings['unpack_package'] = __('Unpacking the update&#8230;');
        $this->strings['copy_failed'] = __('Could not copy files.');
        $this->strings['copy_failed_space'] = __('Could not copy files. You may have run out of disk space.' );
        $this->strings['start_rollback'] = __( 'Attempting to roll back to previous version.' );
        $this->strings['rollback_was_required'] = __( 'Due to an error during updating, WordPress has rolled back to your previous version.' );
    }
    
    function upgrade( $current, $args = array() ) {
        global $wp_filesystem;
    
        include ABSPATH . WPINC . '/version.php'; // $wp_version;
    
        $start_time = time();
    
        $defaults = array(
            'pre_check_md5'    => true,
            'attempt_rollback' => false,
            'do_rollback'      => false,
        );
        $parsed_args = rc_parse_args( $args, $defaults );
    
        $this->init();
        $this->upgrade_strings();
    
        // Is an update available?
        if ( !isset( $current->response ) || $current->response == 'latest' )
            return new ecjia_error('up_to_date', $this->strings['up_to_date']);
    
        $res = $this->fs_connect( array(ABSPATH, WP_CONTENT_DIR) );
        if ( ! $res || is_ecjia_error( $res ) ) {
            return $res;
        }
    
        $wp_dir = RC_Format::trailingslashit($wp_filesystem->abspath());
    
        $partial = true;
        if ( $parsed_args['do_rollback'] )
            $partial = false;
        elseif ( $parsed_args['pre_check_md5'] && ! $this->check_files() )
        $partial = false;
    
        /*
         * If partial update is returned from the API, use that, unless we're doing
         * a reinstall. If we cross the new_bundled version number, then use
         * the new_bundled zip. Don't though if the constant is set to skip bundled items.
         * If the API returns a no_content zip, go with it. Finally, default to the full zip.
         */
        if ( $parsed_args['do_rollback'] && $current->packages->rollback ) {
            $to_download = 'rollback';
        } elseif ( $current->packages->partial && 'reinstall' != $current->response && $wp_version == $current->partial_version && $partial ) {
            $to_download = 'partial';
        } elseif ( $current->packages->new_bundled && version_compare( $wp_version, $current->new_bundled, '<' )
            && ( ! defined( 'CORE_UPGRADE_SKIP_NEW_BUNDLED' ) || ! CORE_UPGRADE_SKIP_NEW_BUNDLED ) ) {
            $to_download = 'new_bundled';
        } elseif ( $current->packages->no_content ) {
            $to_download = 'no_content';
        } else {
            $to_download = 'full';
        }
    
        $download = $this->download_package( $current->packages->$to_download );
        if ( is_ecjia_error($download) ) {
            return $download;
        }
    
        $working_dir = $this->unpack_package( $download );
        if ( is_ecjia_error($working_dir) ) {
            return $working_dir;
        }
    
        // Copy update-core.php from the new version into place.
        if ( !$wp_filesystem->copy($working_dir . '/wordpress/wp-admin/includes/update-core.php', $wp_dir . 'wp-admin/includes/update-core.php', true) ) {
            $wp_filesystem->delete($working_dir, true);
            return new ecjia_error( 'copy_failed_for_update_core_file', __( 'The update cannot be installed because we will be unable to copy some files. This is usually due to inconsistent file permissions.' ), 'wp-admin/includes/update-core.php' );
        }
        $wp_filesystem->chmod($wp_dir . 'wp-admin/includes/update-core.php', FS_CHMOD_FILE);
    
        require_once( ABSPATH . 'wp-admin/includes/update-core.php' );
    
        if ( ! function_exists( 'update_core' ) )
            return new ecjia_error( 'copy_failed_space', $this->strings['copy_failed_space'] );
    
        $result = update_core( $working_dir, $wp_dir );
    
        // In the event of an issue, we may be able to roll back.
        if ( $parsed_args['attempt_rollback'] && $current->packages->rollback && ! $parsed_args['do_rollback'] ) {
            $try_rollback = false;
            if ( is_ecjia_error( $result ) ) {
                $error_code = $result->get_error_code();
                // Not all errors are equal. These codes are critical: copy_failed__copy_dir,
                // mkdir_failed__copy_dir, copy_failed__copy_dir_retry, and disk_full.
                // do_rollback allows for update_core() to trigger a rollback if needed.
                if ( false !== strpos( $error_code, 'do_rollback' ) )
                    $try_rollback = true;
                elseif ( false !== strpos( $error_code, '__copy_dir' ) )
                $try_rollback = true;
                elseif ( 'disk_full' === $error_code )
                $try_rollback = true;
            }
    
            if ( $try_rollback ) {
                /** This filter is documented in wp-admin/includes/update-core.php */
                RC_Hook::apply_filters( 'update_feedback', $result );
    
                /** This filter is documented in wp-admin/includes/update-core.php */
                RC_Hook::apply_filters( 'update_feedback', $this->strings['start_rollback'] );
    
                $rollback_result = $this->upgrade( $current, array_merge( $parsed_args, array( 'do_rollback' => true ) ) );
    
                $original_result = $result;
                $result = new ecjia_error( 'rollback_was_required', $this->strings['rollback_was_required'], (object) array( 'update' => $original_result, 'rollback' => $rollback_result ) );
            }
        }
    
        /** This action is documented in wp-admin/includes/class-wp-upgrader.php */
        RC_Hook::do_action( 'upgrader_process_complete', $this, array( 'action' => 'update', 'type' => 'core' ) );
    
        // Clear the current updates
        delete_site_transient( 'update_core' );
    
        if ( ! $parsed_args['do_rollback'] ) {
            $stats = array(
                'update_type'      => $current->response,
                'success'          => true,
                'fs_method'        => $wp_filesystem->method,
                'fs_method_forced' => defined( 'FS_METHOD' ) || RC_Hook::has_filter( 'filesystem_method' ),
                'time_taken'       => time() - $start_time,
                'reported'         => $wp_version,
                'attempted'        => $current->version,
            );
    
            if ( is_ecjia_error( $result ) ) {
                $stats['success'] = false;
                // Did a rollback occur?
                if ( ! empty( $try_rollback ) ) {
                    $stats['error_code'] = $original_result->get_error_code();
                    $stats['error_data'] = $original_result->get_error_data();
                    // Was the rollback successful? If not, collect its error too.
                    $stats['rollback'] = ! is_ecjia_error( $rollback_result );
                    if ( is_ecjia_error( $rollback_result ) ) {
                        $stats['rollback_code'] = $rollback_result->get_error_code();
                        $stats['rollback_data'] = $rollback_result->get_error_data();
                    }
                } else {
                    $stats['error_code'] = $result->get_error_code();
                    $stats['error_data'] = $result->get_error_data();
                }
            }
    
            wp_version_check( $stats );
        }
    
        return $result;
    }
    
    // Determines if this WordPress Core version should update to $offered_ver or not
    static function should_update_to_version( $offered_ver /* x.y.z */ ) {
        include ABSPATH . WPINC . '/version.php'; // $wp_version; // x.y.z
    
        $current_branch = implode( '.', array_slice( preg_split( '/[.-]/', $wp_version  ), 0, 2 ) ); // x.y
        $new_branch     = implode( '.', array_slice( preg_split( '/[.-]/', $offered_ver ), 0, 2 ) ); // x.y
        $current_is_development_version = (bool) strpos( $wp_version, '-' );
    
        // Defaults:
        $upgrade_dev   = true;
        $upgrade_minor = true;
        $upgrade_major = false;
    
        // WP_AUTO_UPDATE_CORE = true (all), 'minor', false.
        if ( defined( 'WP_AUTO_UPDATE_CORE' ) ) {
            if ( false === WP_AUTO_UPDATE_CORE ) {
                // Defaults to turned off, unless a filter allows it
                $upgrade_dev = $upgrade_minor = $upgrade_major = false;
            } elseif ( true === WP_AUTO_UPDATE_CORE ) {
                // ALL updates for core
                $upgrade_dev = $upgrade_minor = $upgrade_major = true;
            } elseif ( 'minor' === WP_AUTO_UPDATE_CORE ) {
                // Only minor updates for core
                $upgrade_dev = $upgrade_major = false;
                $upgrade_minor = true;
            }
        }
    
        // 1: If we're already on that version, not much point in updating?
        if ( $offered_ver == $wp_version )
            return false;
    
        // 2: If we're running a newer version, that's a nope
        if ( version_compare( $wp_version, $offered_ver, '>' ) )
            return false;
    
        $failure_data = get_site_option( 'auto_core_update_failed' );
        if ( $failure_data ) {
            // If this was a critical update failure, cannot update.
            if ( ! empty( $failure_data['critical'] ) )
                return false;
    
            // Don't claim we can update on update-core.php if we have a non-critical failure logged.
            if ( $wp_version == $failure_data['current'] && false !== strpos( $offered_ver, '.1.next.minor' ) )
                return false;
    
            // Cannot update if we're retrying the same A to B update that caused a non-critical failure.
            // Some non-critical failures do allow retries, like download_failed.
            // 3.7.1 => 3.7.2 resulted in files_not_writable, if we are still on 3.7.1 and still trying to update to 3.7.2.
            if ( empty( $failure_data['retry'] ) && $wp_version == $failure_data['current'] && $offered_ver == $failure_data['attempted'] )
                return false;
        }
    
        // 3: 3.7-alpha-25000 -> 3.7-alpha-25678 -> 3.7-beta1 -> 3.7-beta2
        if ( $current_is_development_version ) {
    
            /**
             * Filter whether to enable automatic core updates for development versions.
             *
             * @since 3.7.0
             *
             * @param bool $upgrade_dev Whether to enable automatic updates for
             *                          development versions.
             */
            if ( ! RC_Hook::apply_filters( 'allow_dev_auto_core_updates', $upgrade_dev ) )
                return false;
            // else fall through to minor + major branches below
        }
    
        // 4: Minor In-branch updates (3.7.0 -> 3.7.1 -> 3.7.2 -> 3.7.4)
        if ( $current_branch == $new_branch ) {
    
            /**
             * Filter whether to enable minor automatic core updates.
             *
             * @since 3.7.0
             *
             * @param bool $upgrade_minor Whether to enable minor automatic core updates.
             */
            return RC_Hook::apply_filters( 'allow_minor_auto_core_updates', $upgrade_minor );
        }
    
        // 5: Major version updates (3.7.0 -> 3.8.0 -> 3.9.1)
        if ( version_compare( $new_branch, $current_branch, '>' ) ) {
    
            /**
             * Filter whether to enable major automatic core updates.
             *
             * @since 3.7.0
             *
             * @param bool $upgrade_major Whether to enable major automatic core updates.
             */
            return RC_Hook::apply_filters( 'allow_major_auto_core_updates', $upgrade_major );
        }
    
        // If we're not sure, we don't want it
        return false;
    }
    
    
    function check_files() {
        global $wp_version, $wp_local_package;
    
        $checksums = get_core_checksums( $wp_version, isset( $wp_local_package ) ? $wp_local_package : 'en_US' );
    
        if ( ! is_array( $checksums ) )
            return false;
    
        foreach ( $checksums as $file => $checksum ) {
            // Skip files which get updated
            if ( 'wp-content' == substr( $file, 0, 10 ) )
                continue;
            if ( ! file_exists( ABSPATH . $file ) || md5_file( ABSPATH . $file ) !== $checksum )
                return false;
        }
    
        return true;
    }
    
}

// end