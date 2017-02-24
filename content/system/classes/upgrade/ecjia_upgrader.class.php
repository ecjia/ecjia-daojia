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
 * A File upgrader class for ECJia.
 *
 * This set of classes are designed to be used to upgrade/install a local set of files on the filesystem via the Filesystem Abstraction classes.
 *
 * @package ECJia
 * @subpackage Upgrader
 * @since 1.4.0
 */
/**
 * ECJia Upgrader class for Upgrading/Installing a local set of files via the Filesystem Abstraction classes from a Zip file.
 *
 * @package ecjia
 * @subpackage Upgrader
 * @since 1.3.0
 */
class ecjia_upgrader {
    public $strings     = array();
    public $skin        = null;
    public $result      = array();
    
    public function __construct($skin = null) {
        if ( null == $skin ) {
            $this->skin = new ecjia_upgrader_skin();
        } else {
            $this->skin = $skin;
        }
    }
    
    public function init() {
        $this->skin->set_upgrader($this);
        $this->generic_strings();
    }
    
    
    public function generic_strings() {
        $this->strings['bad_request'] = __('Invalid Data provided.');
        $this->strings['fs_unavailable'] = __('Could not access filesystem.');
        $this->strings['fs_error'] = __('Filesystem error.');
        $this->strings['fs_no_root_dir'] = __('Unable to locate WordPress Root directory.');
        $this->strings['fs_no_content_dir'] = __('Unable to locate WordPress Content directory (wp-content).');
        $this->strings['fs_no_plugins_dir'] = __('Unable to locate WordPress Plugin directory.');
        $this->strings['fs_no_themes_dir'] = __('Unable to locate WordPress Theme directory.');
        /* translators: %s: directory name */
        $this->strings['fs_no_folder'] = __('Unable to locate needed folder (%s).');
    
        $this->strings['download_failed'] = __('Download failed.');
        $this->strings['installing_package'] = __('Installing the latest version&#8230;');
        $this->strings['no_files'] = __('The package contains no files.');
        $this->strings['folder_exists'] = __('Destination folder already exists.');
        $this->strings['mkdir_failed'] = __('Could not create directory.');
        $this->strings['incompatible_archive'] = __('The package could not be installed.');
    
        $this->strings['maintenance_start'] = __('Enabling Maintenance mode&#8230;');
        $this->strings['maintenance_end'] = __('Disabling Maintenance mode&#8230;');
    }
    
    public function fs_connect( $directories = array() ) {
        global $wp_filesystem;
    
        if ( false === ($credentials = $this->skin->request_filesystem_credentials()) )
            return false;
    
        if ( ! WP_Filesystem($credentials) ) {
            $error = true;
            if ( is_object($wp_filesystem) && $wp_filesystem->errors->get_error_code() )
                $error = $wp_filesystem->errors;
            $this->skin->request_filesystem_credentials($error); //Failed to connect, Error and request again
            return false;
        }
    
        if ( ! is_object($wp_filesystem) )
            return new ecjia_error('fs_unavailable', $this->strings['fs_unavailable'] );
    
        if ( is_ecjia_error($wp_filesystem->errors) && $wp_filesystem->errors->get_error_code() )
            return new ecjia_error('fs_error', $this->strings['fs_error'], $wp_filesystem->errors);
    
        foreach ( (array)$directories as $dir ) {
            switch ( $dir ) {
                case ABSPATH:
                    if ( ! $wp_filesystem->abspath() )
                        return new ecjia_error('fs_no_root_dir', $this->strings['fs_no_root_dir']);
                        break;
                case WP_CONTENT_DIR:
                    if ( ! $wp_filesystem->wp_content_dir() )
                        return new ecjia_error('fs_no_content_dir', $this->strings['fs_no_content_dir']);
                        break;
                case WP_PLUGIN_DIR:
                    if ( ! $wp_filesystem->wp_plugins_dir() )
                        return new ecjia_error('fs_no_plugins_dir', $this->strings['fs_no_plugins_dir']);
                        break;
                case get_theme_root():
                    if ( ! $wp_filesystem->wp_themes_dir() )
                        return new ecjia_error('fs_no_themes_dir', $this->strings['fs_no_themes_dir']);
                        break;
                default:
                    if ( ! $wp_filesystem->find_folder($dir) )
                        return new ecjia_error( 'fs_no_folder', sprintf( $this->strings['fs_no_folder'], esc_html( basename( $dir ) ) ) );
                        break;
            }
        }
        return true;
    } //end fs_connect();
    
    public function download_package($package) {
    
        /**
         * Filter whether to return the package.
         *
         * @since 3.7.0
         *
         * @param bool        $reply   Whether to bail without returning the package.
         *                             Default false.
         * @param string      $package The package file name.
         * @param WP_Upgrader $this    The WP_Upgrader instance.
         */
        $reply = RC_Hook::apply_filters( 'upgrader_pre_download', false, $package, $this );
        if ( false !== $reply )
            return $reply;
    
        if ( ! preg_match('!^(http|https|ftp)://!i', $package) && file_exists($package) ) //Local file or remote?
            return $package; //must be a local file..
    
        if ( empty($package) )
            return new ecjia_error('no_package', $this->strings['no_package']);
    
        $this->skin->feedback('downloading_package', $package);
    
        $download_file = download_url($package);
    
        if ( is_ecjia_error($download_file) )
            return new ecjia_error('download_failed', $this->strings['download_failed'], $download_file->get_error_message());
    
        return $download_file;
    }
    
    public function unpack_package($package, $delete_package = true) {
        global $wp_filesystem;
    
        $this->skin->feedback('unpack_package');
    
        $upgrade_folder = $wp_filesystem->wp_content_dir() . 'upgrade/';
    
        //Clean up contents of upgrade directory beforehand.
        $upgrade_files = $wp_filesystem->dirlist($upgrade_folder);
        if ( !empty($upgrade_files) ) {
            foreach ( $upgrade_files as $file )
                $wp_filesystem->delete($upgrade_folder . $file['name'], true);
        }
    
        //We need a working directory
        $working_dir = $upgrade_folder . basename($package, '.zip');
    
        // Clean up working directory
        if ( $wp_filesystem->is_dir($working_dir) )
            $wp_filesystem->delete($working_dir, true);
    
        // Unzip package to working directory
        $result = unzip_file( $package, $working_dir );
    
        // Once extracted, delete the package if required.
        if ( $delete_package )
            unlink($package);
    
        if ( is_ecjia_error($result) ) {
            $wp_filesystem->delete($working_dir, true);
            if ( 'incompatible_archive' == $result->get_error_code() ) {
                return new ecjia_error( 'incompatible_archive', $this->strings['incompatible_archive'], $result->get_error_data() );
            }
            return $result;
        }
    
        return $working_dir;
    }
    
    
    public function install_package( $args = array() ) {
        global $wp_filesystem, $wp_theme_directories;
    
        $defaults = array(
            'source' => '', // Please always pass this
            'destination' => '', // and this
            'clear_destination' => false,
            'clear_working' => false,
            'abort_if_destination_exists' => true,
            'hook_extra' => array()
        );
    
        $args = rc_parse_args($args, $defaults);
        extract($args);
    
        @set_time_limit( 300 );
    
        if ( empty($source) || empty($destination) )
            return new ecjia_error('bad_request', $this->strings['bad_request']);
    
        $this->skin->feedback('installing_package');
    
        /**
         * Filter the install response before the installation has started.
         *
         * Returning a truthy value, or one that could be evaluated as a WP_Error
         * will effectively short-circuit the installation, returning that value
         * instead.
         *
         * @since 2.8.0
         *
         * @param bool|WP_Error $response   Response.
         * @param array         $hook_extra Extra arguments passed to hooked filters.
        */
        $res = RC_Hook::apply_filters( 'upgrader_pre_install', true, $hook_extra );
        if ( is_ecjia_error($res) )
            return $res;
    
        //Retain the Original source and destinations
        $remote_source = $source;
        $local_destination = $destination;
    
        $source_files = array_keys( $wp_filesystem->dirlist($remote_source) );
        $remote_destination = $wp_filesystem->find_folder($local_destination);
    
        //Locate which directory to copy to the new folder, This is based on the actual folder holding the files.
        if ( 1 == count($source_files) && $wp_filesystem->is_dir( trailingslashit($source) . $source_files[0] . '/') ) {
            //Only one folder? Then we want its contents.
            $source = trailingslashit($source) . trailingslashit($source_files[0]);
        } elseif ( count($source_files) == 0 ) {
            return new ecjia_error( 'incompatible_archive_empty', $this->strings['incompatible_archive'], $this->strings['no_files'] ); // There are no files?
        } else {
            //It's only a single file, the upgrader will use the foldername of this file as the destination folder. foldername is based on zip filename.
            $source = trailingslashit($source);
        }  
    
        /**
         * Filter the source file location for the upgrade package.
         *
         * @since 2.8.0
         *
         * @param string      $source        File source location.
         * @param string      $remote_source Remove file source location.
         * @param WP_Upgrader $this          WP_Upgrader instance.
        */
        $source = RC_Hook::apply_filters( 'upgrader_source_selection', $source, $remote_source, $this );
        if ( is_ecjia_error($source) ) {
            return $source;
        }
    
        //Has the source location changed? If so, we need a new source_files list.
        if ( $source !== $remote_source ) {
            $source_files = array_keys( $wp_filesystem->dirlist($source) );
        }
    
        // Protection against deleting files in any important base directories.
        // Theme_Upgrader & Plugin_Upgrader also trigger this, as they pass the destination directory (WP_PLUGIN_DIR / wp-content/themes)
        // intending to copy the directory into the directory, whilst they pass the source as the actual files to copy.
        $protected_directories = array( ABSPATH, WP_CONTENT_DIR, WP_PLUGIN_DIR, WP_CONTENT_DIR . '/themes' );
        if ( is_array( $wp_theme_directories ) ) {
            $protected_directories = array_merge( $protected_directories, $wp_theme_directories );
        }
        if ( in_array( $destination, $protected_directories ) ) {
            $remote_destination = trailingslashit($remote_destination) . trailingslashit(basename($source));
            $destination = trailingslashit($destination) . trailingslashit(basename($source));
        }
    
        if ( $clear_destination ) {
            //We're going to clear the destination if there's something there
            $this->skin->feedback('remove_old');
            $removed = true;
            if ( $wp_filesystem->exists($remote_destination) )
                $removed = $wp_filesystem->delete($remote_destination, true);
    
            /**
             * Filter whether the upgrader cleared the destination.
             *
             * @since 2.8.0
             *
             * @param bool   $removed            Whether the destination was cleared.
             * @param string $local_destination  The local package destination.
             * @param string $remote_destination The remote package destination.
             * @param array  $hook_extra         Extra arguments passed to hooked filters.
            */
            $removed = RC_Hook::apply_filters( 'upgrader_clear_destination', $removed, $local_destination, $remote_destination, $hook_extra );
    
            if ( is_ecjia_error($removed) ) {
                return $removed;
            } elseif ( ! $removed ) {
                return new ecjia_error('remove_old_failed', $this->strings['remove_old_failed']);
            }
        } elseif ( $abort_if_destination_exists && $wp_filesystem->exists($remote_destination) ) {
            //If we're not clearing the destination folder and something exists there already, Bail.
            //But first check to see if there are actually any files in the folder.
            $_files = $wp_filesystem->dirlist($remote_destination);
            if ( ! empty($_files) ) {
                $wp_filesystem->delete($remote_source, true); //Clear out the source files.
                return new ecjia_error('folder_exists', $this->strings['folder_exists'], $remote_destination );
            }
        }
    
        //Create destination if needed
        if ( !$wp_filesystem->exists($remote_destination) )
            if ( !$wp_filesystem->mkdir($remote_destination, FS_CHMOD_DIR) )
                return new ecjia_error( 'mkdir_failed_destination', $this->strings['mkdir_failed'], $remote_destination );
    
            // Copy new version of item into place.
            $result = copy_dir($source, $remote_destination);
            if ( is_ecjia_error($result) ) {
                if ( $clear_working )
                    $wp_filesystem->delete($remote_source, true);
                return $result;
            }
    
            //Clear the Working folder?
            if ( $clear_working )
                $wp_filesystem->delete($remote_source, true);
    
            $destination_name = basename( str_replace($local_destination, '', $destination) );
            if ( '.' == $destination_name )
                $destination_name = '';
    
            $this->result = compact('local_source', 'source', 'source_name', 'source_files', 'destination', 'destination_name', 'local_destination', 'remote_destination', 'clear_destination', 'delete_source_dir');
    
            /**
             * Filter the install response after the installation has finished.
             *
             * @since 2.8.0
             *
             * @param bool  $response   Install response.
             * @param array $hook_extra Extra arguments passed to hooked filters.
             * @param array $result     Installation result data.
            */
            $res = RC_Hook::apply_filters( 'upgrader_post_install', true, $hook_extra, $this->result );
    
            if ( is_ecjia_error($res) ) {
                $this->result = $res;
                return $res;
            }
    
            //Bombard the calling function will all the info which we've just used.
            return $this->result;
    }
    
    public function run($options) {
    
        $defaults = array(
            'package' => '', // Please always pass this.
            'destination' => '', // And this
            'clear_destination' => false,
            'abort_if_destination_exists' => true, // Abort if the Destination directory exists, Pass clear_destination as false please
            'clear_working' => true,
            'is_multi' => false,
            'hook_extra' => array() // Pass any extra $hook_extra args here, this will be passed to any hooked filters.
        );
    
        $options = rc_parse_args($options, $defaults);
        extract($options);
    
        if ( ! $is_multi ) // call $this->header separately if running multiple times
            $this->skin->header();
    
        // Connect to the Filesystem first.
        $res = $this->fs_connect( array(WP_CONTENT_DIR, $destination) );
        // Mainly for non-connected filesystem.
        if ( ! $res ) {
            if ( ! $is_multi )
                $this->skin->footer();
            return false;
        }
    
        $this->skin->before();
    
        if ( is_ecjia_error($res) ) {
            $this->skin->error($res);
            $this->skin->after();
            if ( ! $is_multi )
                $this->skin->footer();
            return $res;
        }
    
        //Download the package (Note, This just returns the filename of the file if the package is a local file)
        $download = $this->download_package( $package );
        if ( is_ecjia_error($download) ) {
            $this->skin->error($download);
            $this->skin->after();
            if ( ! $is_multi ) {
                $this->skin->footer();
            }
            return $download;
        }
    
        $delete_package = ($download != $package); // Do not delete a "local" file
    
        //Unzips the file into a temporary directory
        $working_dir = $this->unpack_package( $download, $delete_package );
        if ( is_ecjia_error($working_dir) ) {
            $this->skin->error($working_dir);
            $this->skin->after();
            if ( ! $is_multi ) {
                $this->skin->footer();
            }
            return $working_dir;
        }
    
        //With the given options, this installs it to the destination directory.
        $result = $this->install_package( array(
            'source' => $working_dir,
            'destination' => $destination,
            'clear_destination' => $clear_destination,
            'abort_if_destination_exists' => $abort_if_destination_exists,
            'clear_working' => $clear_working,
            'hook_extra' => $hook_extra
        ) );
    
        $this->skin->set_result($result);
        if ( is_ecjia_error($result) ) {
            $this->skin->error($result);
            $this->skin->feedback('process_failed');
        } else {
            //Install Succeeded
            $this->skin->feedback('process_success');
        }
    
        $this->skin->after();
    
        if ( ! $is_multi ) {
    
            /** This action is documented in wp-admin/includes/class-wp-upgrader.php */
            RC_Hook::do_action( 'upgrader_process_complete', $this, $hook_extra );
            $this->skin->footer();
        }
    
        return $result;
    }
    
    public function maintenance_mode($enable = false) {
        global $wp_filesystem;
        $file = $wp_filesystem->abspath() . '.maintenance';
        if ( $enable ) {
            $this->skin->feedback('maintenance_start');
            // Create maintenance file to signal that we are upgrading
            $maintenance_string = '<?php $upgrading = ' . time() . '; ?>';
            $wp_filesystem->delete($file);
            $wp_filesystem->put_contents($file, $maintenance_string, FS_CHMOD_FILE);
        } else if ( !$enable && $wp_filesystem->exists($file) ) {
            $this->skin->feedback('maintenance_end');
            $wp_filesystem->delete($file);
        }
    }
}

// end