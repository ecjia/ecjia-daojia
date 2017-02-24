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

use Royalcms\Component\Support\Facades\Hook as RC_Hook;
use Royalcms\Component\Foundation\Cache as RC_Cache;
use Royalcms\Component\Support\Format as RC_Format;

/**
 * Option API
 *
 * @package WordPress
 * @subpackage Option
 */

/**
 * Retrieve option value based on name of option.
 *
 * If the option does not exist or does not have a value, then the return value
 * will be false. This is useful to check whether you need to install an option
 * and is commonly used during installation of plugin options and to test
 * whether upgrading is required.
 *
 * If the option was serialized then it will be unserialized when it is returned.
 *
 * @since 1.5.0
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 *
 * @param string $option  Name of option to retrieve. Expected to not be SQL-escaped.
 * @param mixed  $default Optional. Default value to return if the option does not exist.
 * @return mixed Value set for the option.
 */
class ecjia_option
{
    
    public static function get_option( $option, $default = false ) {
//         global $wpdb;
    
        $option = trim( $option );
        if ( empty( $option ) )
            return false;
    
        /**
         * Filter the value of an existing option before it is retrieved.
         *
         * The dynamic portion of the hook name, `$option`, refers to the option name.
         *
         * Passing a truthy value to the filter will short-circuit retrieving
         * the option value, returning the passed value instead.
         *
         * @since 1.5.0
         * @since 4.4.0 The `$option` parameter was added.
         *
         * @param bool|mixed $pre_option Value to return instead of the option value.
         *                               Default false to skip it.
         * @param string     $option     Option name.
         */
        $pre = RC_Hook::apply_filters( 'pre_option_' . $option, false, $option );
        if ( false !== $pre )
            return $pre;
    
//         if ( defined( 'WP_SETUP_CONFIG' ) )
//             return false;
    
//         if ( ! wp_installing() ) {
            // prevent non-existent options from triggering multiple queries
            $notoptions = RC_Cache::app_cache_get( 'notoptions', 'options' );
            if ( isset( $notoptions[ $option ] ) ) {
                /**
                 * Filter the default value for an option.
                 *
                 * The dynamic portion of the hook name, `$option`, refers to the option name.
                 *
                 * @since 3.4.0
                 * @since 4.4.0 The `$option` parameter was added.
                 *
                 * @param mixed  $default The default value to return if the option does not exist
                 *                        in the database.
                 * @param string $option  Option name.
                 */
                return RC_Hook::apply_filters( 'default_option_' . $option, $default, $option );
            }
    
            $alloptions = self::load_alloptions();
    
            if ( isset( $alloptions[$option] ) ) {
                $value = $alloptions[$option];
            } else {
                $value = RC_Cache::app_cache_get( $option, 'options' );
    
                if ( false === $value ) {
                    $row = $wpdb->get_row( $wpdb->prepare( "SELECT option_value FROM $wpdb->options WHERE option_name = %s LIMIT 1", $option ) );
    
                    // Has to be get_row instead of get_var because of funkiness with 0, false, null values
                    if ( is_object( $row ) ) {
                        $value = $row->option_value;
                        RC_Cache::app_cache_add( $option, $value, 'options' );
                    } else { // option does not exist, so we must cache its non-existence
                        if ( ! is_array( $notoptions ) ) {
                            $notoptions = array();
                        }
                        $notoptions[$option] = true;
                        RC_Cache::app_cache_set( 'notoptions', $notoptions, 'options' );
    
                        /** This filter is documented in wp-includes/option.php */
                        return RC_Hook::apply_filters( 'default_option_' . $option, $default, $option );
                    }
                }
            }
//         } else {
//             $suppress = $wpdb->suppress_errors();
//             $row = $wpdb->get_row( $wpdb->prepare( "SELECT option_value FROM $wpdb->options WHERE option_name = %s LIMIT 1", $option ) );
//             $wpdb->suppress_errors( $suppress );
//             if ( is_object( $row ) ) {
//                 $value = $row->option_value;
//             } else {
//                 /** This filter is documented in wp-includes/option.php */
//                 return RC_Hook::apply_filters( 'default_option_' . $option, $default, $option );
//             }
//         }
    
//         // If home is not set use siteurl.
//         if ( 'home' == $option && '' == $value )
//             return RC_Hook::get_option( 'siteurl' );
    
        if ( in_array( $option, array('siteurl', 'home', 'category_base', 'tag_base') ) )
            $value = RC_Format::untrailingslashit( $value );
    
        /**
         * Filter the value of an existing option.
         *
         * The dynamic portion of the hook name, `$option`, refers to the option name.
         *
         * @since 1.5.0 As 'option_' . $setting
         * @since 3.0.0
         * @since 4.4.0 The `$option` parameter was added.
         *
         * @param mixed  $value  Value of the option. If stored serialized, it will be
         *                       unserialized prior to being returned.
         * @param string $option Option name. 
        */
        return RC_Hook::apply_filters( 'option_' . $option, RC_Format::maybe_unserialize( $value ), $option );
    }
    
    /**
     * Protect WordPress special option from being modified.
     *
     * Will die if $option is in protected list. Protected options are 'alloptions'
     * and 'notoptions' options.
     *
     * @since 2.2.0
     *
     * @param string $option Option name.
     */
    public static function protect_special_option( $option ) {
        if ( 'alloptions' === $option || 'notoptions' === $option )
            rc_die( sprintf( __( '%s is a protected WP option and may not be modified' ), RC_Format::esc_html( $option ) ) );
    }
    
    /**
     * Print option value after sanitizing for forms.
     *
     * @since 1.5.0
     *
     * @param string $option Option name.
     */
    public static function form_option( $option ) {
        echo RC_Format::esc_attr( self::get_option( $option ) );
    }
    
    /**
     * Loads and caches all autoloaded options, if available or all options.
     *
     * @since 2.2.0
     *
     * @global wpdb $wpdb WordPress database abstraction object.
     *
     * @return array List of all options.
     */
    public static function load_alloptions() {
        
        $alloptions = RC_Cache::app_cache_get( 'alloptions', 'options' );

        if ( !$alloptions ) {
            $alloptions_db = RC_DB::table('site_options')->select('option_name', 'option_value')
                                    ->where('site_id', 1)->where('autoload', 'yes')->get();
            
            if ( !$alloptions_db ) {
                $alloptions_db = RC_DB::table('site_options')->select('option_name', 'option_value')
                                    ->where('site_id', 1)->get();
            }

            $alloptions = array();
            foreach ( (array) $alloptions_db as $option ) {
                $alloptions[$option['option_name']] = $option['option_value'];
            }

            RC_Cache::app_cache_add( 'alloptions', $alloptions, 'options' );
        }
    
        return $alloptions;
    }
    
    /**
     * Loads and caches certain often requested site options if is_multisite() and a persistent cache is not being used.
     *
     * @since 3.0.0
     *
     * @global wpdb $wpdb WordPress database abstraction object.
     *
     * @param int $site_id Optional site ID for which to query the options. Defaults to the current site.
     */
    public static function load_core_site_options( $site_id = null ) {
//         global $wpdb;
    
        if ( ! is_multisite() || wp_installing() )
            return;
    
        if ( empty($site_id) )
            $site_id = $wpdb->siteid;
    
        $core_options = array('site_name', 'siteurl', 'active_sitewide_plugins', '_site_transient_timeout_theme_roots', '_site_transient_theme_roots', 'site_admins', 'can_compress_scripts', 'global_terms_enabled', 'ms_files_rewriting' );
    
        $core_options_in = "'" . implode("', '", $core_options) . "'";
        $options = $wpdb->get_results( $wpdb->prepare("SELECT meta_key, meta_value FROM $wpdb->sitemeta WHERE meta_key IN ($core_options_in) AND site_id = %d", $site_id) );
    
        foreach ( $options as $option ) {
            $key = $option->meta_key;
            $cache_key = "{$site_id}:$key";
            $option->meta_value = RC_Format::maybe_unserialize( $option->meta_value );
    
            RC_Cache::app_cache_set( $cache_key, $option->meta_value, 'site-options' );
        }
    }
    
    /**
     * Update the value of an option that was already added.
     *
     * You do not need to serialize values. If the value needs to be serialized, then
     * it will be serialized before it is inserted into the database. Remember,
     * resources can not be serialized or added as an option.
     *
     * If the option does not exist, then the option will be added with the option value,
     * with an `$autoload` value of 'yes'.
     *
     * @since 1.0.0
     * @since 4.2.0 The `$autoload` parameter was added.
     *
     * @global wpdb $wpdb WordPress database abstraction object.
     *
     * @param string      $option   Option name. Expected to not be SQL-escaped.
     * @param mixed       $value    Option value. Must be serializable if non-scalar. Expected to not be SQL-escaped.
     * @param string|bool $autoload Optional. Whether to load the option when WordPress starts up. For existing options,
     *                              `$autoload` can only be updated using `update_option()` if `$value` is also changed.
     *                              Accepts 'yes'|true to enable or 'no'|false to disable. For non-existent options,
     *                              the default value is 'yes'. Default null.
     * @return bool False if value was not updated and true if value was updated.
     */
    public static function update_option( $option, $value, $autoload = null ) {
//         global $wpdb;
    
        $option = trim($option);
        if ( empty($option) )
            return false;
    
        self::protect_special_option( $option );
    
        if ( is_object( $value ) )
            $value = clone $value;
    
        $value = self::sanitize_option( $option, $value );
        $old_value = self::get_option( $option );
    
        /**
         * Filter a specific option before its value is (maybe) serialized and updated.
         *
         * The dynamic portion of the hook name, `$option`, refers to the option name.
         *
         * @since 2.6.0
         * @since 4.4.0 The `$option` parameter was added.
         *
         * @param mixed  $value     The new, unserialized option value.
         * @param mixed  $old_value The old option value.
         * @param string $option    Option name.
        */
        $value = RC_Hook::apply_filters( 'pre_update_option_' . $option, $value, $old_value, $option );
    
        /**
         * Filter an option before its value is (maybe) serialized and updated.
         *
         * @since 3.9.0
         *
         * @param mixed  $value     The new, unserialized option value.
         * @param string $option    Name of the option.
         * @param mixed  $old_value The old option value.
        */
        $value = RC_Hook::apply_filters( 'pre_update_option', $value, $option, $old_value );
    
        // If the new and old values are the same, no need to update.
        if ( $value === $old_value )
            return false;
    
        /** This filter is documented in wp-includes/option.php */
        if ( RC_Hook::apply_filters( 'default_option_' . $option, false ) === $old_value ) {
            // Default setting for new options is 'yes'.
            if ( null === $autoload ) {
                $autoload = 'yes';
            }
    
            return RC_Hook::add_option( $option, $value, '', $autoload );
        }
    
        $serialized_value = RC_Format::maybe_serialize( $value );
    
        /**
         * Fires immediately before an option value is updated.
         *
         * @since 2.9.0
         *
         * @param string $option    Name of the option to update.
         * @param mixed  $old_value The old option value.
         * @param mixed  $value     The new option value.
        */
        RC_Hook::do_action( 'update_option', $option, $old_value, $value );
    
        $update_args = array(
            'option_value' => $serialized_value,
        );
    
        if ( null !== $autoload ) {
            $update_args['autoload'] = ( 'no' === $autoload || false === $autoload ) ? 'no' : 'yes';
        }
    
        $result = RC_DB::table('site_options')->where('option_name', $option)->update($update_args);
//         $wpdb->update( $wpdb->options, $update_args, array( 'option_name' => $option ) );
        if ( ! $result )
            return false;
    
        $notoptions = RC_Cache::app_cache_get( 'notoptions', 'options' );
        if ( is_array( $notoptions ) && isset( $notoptions[$option] ) ) {
            unset( $notoptions[$option] );
            RC_Cache::app_cache_set( 'notoptions', $notoptions, 'options' );
        }
    

        $alloptions = self::load_alloptions();
        if ( isset( $alloptions[$option] ) ) {
            $alloptions[ $option ] = $serialized_value;
            RC_Cache::app_cache_set( 'alloptions', $alloptions, 'options' );
        } else {
            RC_Cache::app_cache_set( $option, $serialized_value, 'options' );
        }

    
        /**
         * Fires after the value of a specific option has been successfully updated.
         *
         * The dynamic portion of the hook name, `$option`, refers to the option name.
         *
         * @since 2.0.1
         * @since 4.4.0 The `$option` parameter was added.
         *
         * @param mixed  $old_value The old option value.
         * @param mixed  $value     The new option value.
         * @param string $option    Option name.
         */
        RC_Hook::do_action( "update_option_{$option}", $old_value, $value, $option );
    
        /**
         * Fires after the value of an option has been successfully updated.
         *
         * @since 2.9.0
         *
         * @param string $option    Name of the updated option.
         * @param mixed  $old_value The old option value.
         * @param mixed  $value     The new option value.
        */
        RC_Hook::do_action( 'updated_option', $option, $old_value, $value );
        return true;
    }
    
    /**
     * Add a new option.
     *
     * You do not need to serialize values. If the value needs to be serialized, then
     * it will be serialized before it is inserted into the database. Remember,
     * resources can not be serialized or added as an option.
     *
     * You can create options without values and then update the values later.
     * Existing options will not be updated and checks are performed to ensure that you
     * aren't adding a protected WordPress option. Care should be taken to not name
     * options the same as the ones which are protected.
     *
     * @since 1.0.0
     *
     * @global wpdb $wpdb WordPress database abstraction object.
     *
     * @param string         $option      Name of option to add. Expected to not be SQL-escaped.
     * @param mixed          $value       Optional. Option value. Must be serializable if non-scalar. Expected to not be SQL-escaped.
     * @param string         $deprecated  Optional. Description. Not used anymore.
     * @param string|bool    $autoload    Optional. Whether to load the option when WordPress starts up.
     *                                    Default is enabled. Accepts 'no' to disable for legacy reasons.
     * @return bool False if option was not added and true if option was added.
     */
    public static function add_option( $option, $value = '', $autoload = 'yes' ) {

        $option = trim($option);
        if ( empty($option) )
            return false;
    
        self::protect_special_option( $option );
    
        if ( is_object($value) )
            $value = clone $value;
    
        $value = self::sanitize_option( $option, $value );
    
        // Make sure the option doesn't already exist. We can check the 'notoptions' cache before we ask for a db query
        $notoptions = RC_Cache::app_cache_get( 'notoptions', 'options' );
        if ( !is_array( $notoptions ) || !isset( $notoptions[$option] ) ) {
            /** This filter is documented in wp-includes/option.php */
            if ( RC_Hook::apply_filters( 'default_option_' . $option, false ) !== self::get_option( $option ) ) {
                return false;
            }
        }
        
        $serialized_value = RC_Format::maybe_serialize( $value );
        $autoload = ( 'no' === $autoload || false === $autoload ) ? 'no' : 'yes';
    
        /**
         * Fires before an option is added.
         *
         * @since 2.9.0
         *
         * @param string $option Name of the option to add.
         * @param mixed  $value  Value of the option.
         */
        RC_Hook::do_action( 'add_option', $option, $value );
    
        $result = $wpdb->query( $wpdb->prepare( "INSERT INTO `$wpdb->options` (`option_name`, `option_value`, `autoload`) VALUES (%s, %s, %s) ON DUPLICATE KEY UPDATE `option_name` = VALUES(`option_name`), `option_value` = VALUES(`option_value`), `autoload` = VALUES(`autoload`)", $option, $serialized_value, $autoload ) );
        if ( ! $result ) {
            return false;
        }

        if ( 'yes' == $autoload ) {
            $alloptions = self::load_alloptions();
            $alloptions[ $option ] = $serialized_value;
            RC_Cache::app_cache_set( 'alloptions', $alloptions, 'options' );
        } else {
            RC_Cache::app_cache_set( $option, $serialized_value, 'options' );
        }

    
        // This option exists now
        $notoptions = RC_Cache::app_cache_get( 'notoptions', 'options' ); // yes, again... we need it to be fresh
        if ( is_array( $notoptions ) && isset( $notoptions[$option] ) ) {
            unset( $notoptions[$option] );
            RC_Cache::app_cache_set( 'notoptions', $notoptions, 'options' );
        }
    
        /**
         * Fires after a specific option has been added.
         *
         * The dynamic portion of the hook name, `$option`, refers to the option name.
         *
         * @since 2.5.0 As "add_option_{$name}"
         * @since 3.0.0
         *
         * @param string $option Name of the option to add.
         * @param mixed  $value  Value of the option.
         */
        RC_Hook::do_action( "add_option_{$option}", $option, $value );
    
        /**
         * Fires after an option has been added.
         *
         * @since 2.9.0
         *
         * @param string $option Name of the added option.
         * @param mixed  $value  Value of the option.
         */
        RC_Hook::do_action( 'added_option', $option, $value );
        return true;
    }
    
    /**
     * Removes option by name. Prevents removal of protected WordPress options.
     *
     * @since 1.2.0
     *
     * @global wpdb $wpdb WordPress database abstraction object.
     *
     * @param string $option Name of option to remove. Expected to not be SQL-escaped.
     * @return bool True, if option is successfully deleted. False on failure.
     */
    public static function delete_option( $option ) {

        $option = trim( $option );
        if ( empty( $option ) ) {
            return false;
        }
        
        self::protect_special_option( $option );
    
        // Get the ID, if no ID then return
        $row = $wpdb->get_row( $wpdb->prepare( "SELECT autoload FROM $wpdb->options WHERE option_name = %s", $option ) );
        if ( is_null( $row ) ) {
            return false;
        }
        
        /**
         * Fires immediately before an option is deleted.
         *
         * @since 2.9.0
         *
         * @param string $option Name of the option to delete.
         */
        RC_Hook::do_action( 'delete_option', $option );
    
        $result = $wpdb->delete( $wpdb->options, array( 'option_name' => $option ) );

        if ( 'yes' == $row->autoload ) {
            $alloptions = self::load_alloptions();
            if ( is_array( $alloptions ) && isset( $alloptions[$option] ) ) {
                unset( $alloptions[$option] );
                RC_Cache::app_cache_set( 'alloptions', $alloptions, 'options' );
            }
        } else {
            RC_Cache::app_cache_delete( $option, 'options' );
        }

        if ( $result ) {
    
            /**
             * Fires after a specific option has been deleted.
             *
             * The dynamic portion of the hook name, `$option`, refers to the option name.
             *
             * @since 3.0.0
             *
             * @param string $option Name of the deleted option.
             */
            RC_Hook::do_action( "delete_option_$option", $option );
    
            /**
             * Fires after an option has been deleted.
             *
             * @since 2.9.0
             *
             * @param string $option Name of the deleted option.
            */
            RC_Hook::do_action( 'deleted_option', $option );
            return true;
        }
        return false;
    }
    
    /**
     * Sanitises various option values based on the nature of the option.
     *
     * This is basically a switch statement which will pass $value through a number
     * of functions depending on the $option.
     *
     * @since 2.0.5
     *
     * @global wpdb $wpdb WordPress database abstraction object.
     *
     * @param string $option The name of the option.
     * @param string $value  The unsanitised value.
     * @return string Sanitized value.
     */
    public static function sanitize_option( $option, $value ) {
//         global $wpdb;
    
        $original_value = $value;
        $error = '';
    
        switch ( $option ) {
        	case 'admin_email' :
        	case 'new_admin_email' :
        	    $value = $wpdb->strip_invalid_text_for_column( $wpdb->options, 'option_value', $value );
        	    if ( is_ecjia_error( $value ) ) {
        	        $error = $value->get_error_message();
        	    } else {
        	        $value = RC_Format::sanitize_email( $value );
        	        if ( ! is_email( $value ) ) {
        	            $error = __( 'The email address entered did not appear to be a valid email address. Please enter a valid email address.' );
        	        }
        	    }
        	    break;
    
        	case 'thumbnail_size_w':
        	case 'thumbnail_size_h':
        	case 'medium_size_w':
        	case 'medium_size_h':
        	case 'medium_large_size_w':
        	case 'medium_large_size_h':
        	case 'large_size_w':
        	case 'large_size_h':
        	case 'mailserver_port':
        	case 'comment_max_links':
        	case 'page_on_front':
        	case 'page_for_posts':
        	case 'rss_excerpt_length':
        	case 'default_category':
        	case 'default_email_category':
        	case 'default_link_category':
        	case 'close_comments_days_old':
        	case 'comments_per_page':
        	case 'thread_comments_depth':
        	case 'users_can_register':
        	case 'start_of_week':
        	case 'site_icon':
        	    $value = rc_absint( $value );
        	    break;
    
        	case 'posts_per_page':
        	case 'posts_per_rss':
        	    $value = (int) $value;
        	    if ( empty($value) )
        	        $value = 1;
        	    if ( $value < -1 )
        	        $value = abs($value);
        	    break;
    
        	case 'default_ping_status':
        	case 'default_comment_status':
        	    // Options that if not there have 0 value but need to be something like "closed"
        	    if ( $value == '0' || $value == '')
        	        $value = 'closed';
        	        break;
    
        	case 'blogdescription':
        	case 'blogname':
        	    $value = $wpdb->strip_invalid_text_for_column( $wpdb->options, 'option_value', $value );
        	    if ( is_ecjia_error( $value ) ) {
        	        $error = $value->get_error_message();
        	    } else {
        	        $value = wp_kses_post( $value );
        	        $value = RC_Format::esc_html( $value );
        	    }
        	    break;
    
        	case 'blog_charset':
        	    $value = preg_replace('/[^a-zA-Z0-9_-]/', '', $value); // strips slashes
        	    break;
    
        	case 'blog_public':
        	    // This is the value if the settings checkbox is not checked on POST. Don't rely on this.
        	    if ( null === $value )
        	        $value = 1;
        	        else
        	            $value = intval( $value );
        	        break;
    
        	case 'date_format':
        	case 'time_format':
        	case 'mailserver_url':
        	case 'mailserver_login':
        	case 'mailserver_pass':
        	case 'upload_path':
        	    $value = $wpdb->strip_invalid_text_for_column( $wpdb->options, 'option_value', $value );
        	    if ( is_ecjia_error( $value ) ) {
        	        $error = $value->get_error_message();
        	    } else {
        	        $value = strip_tags( $value );
        	        $value = wp_kses_data( $value );
        	    }
        	    break;
    
        	case 'ping_sites':
        	    $value = explode( "\n", $value );
        	    $value = array_filter( array_map( 'trim', $value ) );
        	    $value = array_filter( array_map( 'esc_url_raw', $value ) );
        	    $value = implode( "\n", $value );
        	    break;
    
        	case 'gmt_offset':
        	    $value = preg_replace('/[^0-9:.-]/', '', $value); // strips slashes
        	    break;
    
        	case 'siteurl':
        	    $value = $wpdb->strip_invalid_text_for_column( $wpdb->options, 'option_value', $value );
        	    if ( is_ecjia_error( $value ) ) {
        	        $error = $value->get_error_message();
        	    } else {
        	        if ( preg_match( '#http(s?)://(.+)#i', $value ) ) {
        	            $value = RC_Format::esc_url_raw( $value );
        	        } else {
        	            $error = __( 'The WordPress address you entered did not appear to be a valid URL. Please enter a valid URL.' );
        	        }
        	    }
        	    break;
    
        	case 'home':
        	    $value = $wpdb->strip_invalid_text_for_column( $wpdb->options, 'option_value', $value );
        	    if ( is_ecjia_error( $value ) ) {
        	        $error = $value->get_error_message();
        	    } else {
        	        if ( preg_match( '#http(s?)://(.+)#i', $value ) ) {
        	            $value = RC_Format::esc_url_raw( $value );
        	        } else {
        	            $error = __( 'The Site address you entered did not appear to be a valid URL. Please enter a valid URL.' );
        	        }
        	    }
        	    break;
    
        	case 'WPLANG':
        	    $allowed = get_available_languages();
        	    if ( ! is_multisite() && defined( 'WPLANG' ) && '' !== WPLANG && 'en_US' !== WPLANG ) {
        	        $allowed[] = WPLANG;
        	    }
        	    if ( ! in_array( $value, $allowed ) && ! empty( $value ) ) {
        	        $value = self::get_option( $option );
        	    }
        	    break;
    
        	case 'illegal_names':
        	    $value = $wpdb->strip_invalid_text_for_column( $wpdb->options, 'option_value', $value );
        	    if ( is_ecjia_error( $value ) ) {
        	        $error = $value->get_error_message();
        	    } else {
        	        if ( ! is_array( $value ) )
        	            $value = explode( ' ', $value );
    
        	        $value = array_values( array_filter( array_map( 'trim', $value ) ) );
    
        	        if ( ! $value )
        	            $value = '';
        	    }
        	    break;
    
        	case 'limited_email_domains':
        	case 'banned_email_domains':
        	    $value = $wpdb->strip_invalid_text_for_column( $wpdb->options, 'option_value', $value );
        	    if ( is_ecjia_error( $value ) ) {
        	        $error = $value->get_error_message();
        	    } else {
        	        if ( ! is_array( $value ) )
        	            $value = explode( "\n", $value );
    
        	        $domains = array_values( array_filter( array_map( 'trim', $value ) ) );
        	        $value = array();
    
        	        foreach ( $domains as $domain ) {
        	            if ( ! preg_match( '/(--|\.\.)/', $domain ) && preg_match( '|^([a-zA-Z0-9-\.])+$|', $domain ) ) {
        	                $value[] = $domain;
        	            }
        	        }
        	        if ( ! $value )
        	            $value = '';
        	    }
        	    break;
    
        	case 'timezone_string':
        	    $allowed_zones = timezone_identifiers_list();
        	    if ( ! in_array( $value, $allowed_zones ) && ! empty( $value ) ) {
        	        $error = __( 'The timezone you have entered is not valid. Please select a valid timezone.' );
        	    }
        	    break;
    
        	case 'permalink_structure':
        	case 'category_base':
        	case 'tag_base':
        	    $value = $wpdb->strip_invalid_text_for_column( $wpdb->options, 'option_value', $value );
        	    if ( is_ecjia_error( $value ) ) {
        	        $error = $value->get_error_message();
        	    } else {
        	        $value = RC_Format::esc_url_raw( $value );
        	        $value = str_replace( 'http://', '', $value );
        	    }
        	    break;
    
        	case 'default_role' :
        	    if ( ! get_role( $value ) && get_role( 'subscriber' ) )
        	        $value = 'subscriber';
        	        break;
    
        	case 'moderation_keys':
        	case 'blacklist_keys':
        	    $value = $wpdb->strip_invalid_text_for_column( $wpdb->options, 'option_value', $value );
        	    if ( is_ecjia_error( $value ) ) {
        	        $error = $value->get_error_message();
        	    } else {
        	        $value = explode( "\n", $value );
        	        $value = array_filter( array_map( 'trim', $value ) );
        	        $value = array_unique( $value );
        	        $value = implode( "\n", $value );
        	    }
        	    break;
        }
    
        if ( ! empty( $error ) ) {
            $value = self::get_option( $option );
            if ( function_exists( 'add_settings_error' ) ) {
                add_settings_error( $option, "invalid_{$option}", $error );
            }
        }
    
        /**
         * Filter an option value following sanitization.
         *
         * @since 2.3.0
         * @since 4.3.0 Added the `$original_value` parameter.
         *
         * @param string $value          The sanitized option value.
         * @param string $option         The option name.
         * @param string $original_value The original value passed to the function.
         */
        return RC_Hook::apply_filters( "sanitize_option_{$option}", $value, $option, $original_value );
    }
    
    /**
     * Delete a transient.
     *
     * @since 2.8.0
     *
     * @param string $transient Transient name. Expected to not be SQL-escaped.
     * @return bool true if successful, false otherwise
     */
    public static function delete_transient( $transient ) {
    
        /**
         * Fires immediately before a specific transient is deleted.
         *
         * The dynamic portion of the hook name, `$transient`, refers to the transient name.
         *
         * @since 3.0.0
         *
         * @param string $transient Transient name.
         */
        RC_Hook::do_action( 'delete_transient_' . $transient, $transient );
    
        if ( wp_using_ext_object_cache() ) {
            $result = RC_Cache::app_cache_delete( $transient, 'transient' );
        } else {
            $option_timeout = '_transient_timeout_' . $transient;
            $option = '_transient_' . $transient;
            $result = self::delete_option( $option );
            if ( $result )
                self::delete_option( $option_timeout );
        }
    
        if ( $result ) {
    
            /**
             * Fires after a transient is deleted.
             *
             * @since 3.0.0
             *
             * @param string $transient Deleted transient name.
             */
            RC_Hook::do_action( 'deleted_transient', $transient );
        }
    
        return $result;
    }
    
    /**
     * Get the value of a transient.
     *
     * If the transient does not exist, does not have a value, or has expired,
     * then the return value will be false.
     *
     * @since 2.8.0
     *
     * @param string $transient Transient name. Expected to not be SQL-escaped.
     * @return mixed Value of transient.
     */
    public static function get_transient( $transient ) {
    
        /**
         * Filter the value of an existing transient.
         *
         * The dynamic portion of the hook name, `$transient`, refers to the transient name.
         *
         * Passing a truthy value to the filter will effectively short-circuit retrieval
         * of the transient, returning the passed value instead.
         *
         * @since 2.8.0
         * @since 4.4.0 The `$transient` parameter was added
         *
         * @param mixed  $pre_transient The default value to return if the transient does not exist.
         *                              Any value other than false will short-circuit the retrieval
         *                              of the transient, and return the returned value.
         * @param string $transient     Transient name.
         */
        $pre = RC_Hook::apply_filters( 'pre_transient_' . $transient, false, $transient );
        if ( false !== $pre )
            return $pre;
    
        if ( wp_using_ext_object_cache() ) {
            $value = RC_Cache::app_cache_get( $transient, 'transient' );
        } else {
            $transient_option = '_transient_' . $transient;
//             if ( ! wp_installing() ) {
                // If option is not in alloptions, it is not autoloaded and thus has a timeout
                $alloptions = self::load_alloptions();
                if ( !isset( $alloptions[$transient_option] ) ) {
                    $transient_timeout = '_transient_timeout_' . $transient;
                    $timeout = self::get_option( $transient_timeout );
                    if ( false !== $timeout && $timeout < time() ) {
                        self::delete_option( $transient_option  );
                        self::delete_option( $transient_timeout );
                        $value = false;
                    }
                }
//             }
    
            if ( ! isset( $value ) )
                $value = self::get_option( $transient_option );
        }
    
        /**
         * Filter an existing transient's value.
         *
         * The dynamic portion of the hook name, `$transient`, refers to the transient name.
         *
         * @since 2.8.0
         * @since 4.4.0 The `$transient` parameter was added
         *
         * @param mixed  $value     Value of transient.
         * @param string $transient Transient name.
         */
        return RC_Hook::apply_filters( 'transient_' . $transient, $value, $transient );
    }
    
    /**
     * Set/update the value of a transient.
     *
     * You do not need to serialize values. If the value needs to be serialized, then
     * it will be serialized before it is set.
     *
     * @since 2.8.0
     *
     * @param string $transient  Transient name. Expected to not be SQL-escaped. Must be
     *                           172 characters or fewer in length.
     * @param mixed  $value      Transient value. Must be serializable if non-scalar.
     *                           Expected to not be SQL-escaped.
     * @param int    $expiration Optional. Time until expiration in seconds. Default 0 (no expiration).
     * @return bool False if value was not set and true if value was set.
     */
    public static function set_transient( $transient, $value, $expiration = 0 ) {
    
        $expiration = (int) $expiration;
    
        /**
         * Filter a specific transient before its value is set.
         *
         * The dynamic portion of the hook name, `$transient`, refers to the transient name.
         *
         * @since 3.0.0
         * @since 4.2.0 The `$expiration` parameter was added.
         * @since 4.4.0 The `$transient` parameter was added.
         *
         * @param mixed  $value      New value of transient.
         * @param int    $expiration Time until expiration in seconds.
         * @param string $transient  Transient name.
         */
        $value = RC_Hook::apply_filters( 'pre_set_transient_' . $transient, $value, $expiration, $transient );
    
        /**
         * Filter the expiration for a transient before its value is set.
         *
         * The dynamic portion of the hook name, `$transient`, refers to the transient name.
         *
         * @since 4.4.0
         *
         * @param int    $expiration Time until expiration in seconds. Use 0 for no expiration.
         * @param mixed  $value      New value of transient.
         * @param string $transient  Transient name.
        */
        $expiration = RC_Hook::apply_filters( 'expiration_of_transient_' . $transient, $expiration, $value, $transient );
    
        if ( wp_using_ext_object_cache() ) {
            $result = RC_Cache::app_cache_set( $transient, $value, 'transient', $expiration );
        } else {
            $transient_timeout = '_transient_timeout_' . $transient;
            $transient_option = '_transient_' . $transient;
            if ( false === self::get_option( $transient_option ) ) {
                $autoload = 'yes';
                if ( $expiration ) {
                    $autoload = 'no';
                    self::add_option( $transient_timeout, time() + $expiration, '', 'no' );
                }
                $result = self::add_option( $transient_option, $value, '', $autoload );
            } else {
                // If expiration is requested, but the transient has no timeout option,
                // delete, then re-create transient rather than update.
                $update = true;
                if ( $expiration ) {
                    if ( false === self::get_option( $transient_timeout ) ) {
                        self::delete_option( $transient_option );
                        self::add_option( $transient_timeout, time() + $expiration, '', 'no' );
                        $result = self::add_option( $transient_option, $value, '', 'no' );
                        $update = false;
                    } else {
                        self::update_option( $transient_timeout, time() + $expiration );
                    }
                }
                if ( $update ) {
                    $result = self::update_option( $transient_option, $value );
                }
            }
        }
    
        if ( $result ) {
    
            /**
             * Fires after the value for a specific transient has been set.
             *
             * The dynamic portion of the hook name, `$transient`, refers to the transient name.
             *
             * @since 3.0.0
             * @since 3.6.0 The `$value` and `$expiration` parameters were added.
             * @since 4.4.0 The `$transient` parameter was added.
             *
             * @param mixed  $value      Transient value.
             * @param int    $expiration Time until expiration in seconds.
             * @param string $transient  The name of the transient.
             */
            RC_Hook::do_action( 'set_transient_' . $transient, $value, $expiration, $transient );
    
            /**
             * Fires after the value for a transient has been set.
             *
             * @since 3.0.0
             * @since 3.6.0 The `$value` and `$expiration` parameters were added.
             *
             * @param string $transient  The name of the transient.
             * @param mixed  $value      Transient value.
             * @param int    $expiration Time until expiration in seconds.
            */
            RC_Hook::do_action( 'setted_transient', $transient, $value, $expiration );
        }
        return $result;
    }
    
    /**
     * Retrieve an option value for the current network based on name of option.
     *
     * @since 2.8.0
     * @since 4.4.0 The `$use_cache` parameter was deprecated.
     * @since 4.4.0 Modified into wrapper for get_network_option()
     *
     * @see get_network_option()
     *
     * @param string $option     Name of option to retrieve. Expected to not be SQL-escaped.
     * @param mixed  $default    Optional value to return if option doesn't exist. Default false.
     * @param bool   $deprecated Whether to use cache. Multisite only. Always set to true.
     * @return mixed Value set for the option.
     */
    public static function get_site_option( $option, $default = false, $deprecated = true ) {
        return self::get_network_option( null, $option, $default );
    }
    
    /**
     * Add a new option for the current network.
     *
     * Existing options will not be updated. Note that prior to 3.3 this wasn't the case.
     *
     * @since 2.8.0
     * @since 4.4.0 Modified into wrapper for add_network_option()
     *
     * @see add_network_option()
     *
     * @param string $option Name of option to add. Expected to not be SQL-escaped.
     * @param mixed  $value  Option value, can be anything. Expected to not be SQL-escaped.
     * @return bool False if the option was not added. True if the option was added.
     */
    public static function add_site_option( $option, $value ) {
        return self::add_network_option( null, $option, $value );
    }
    
    /**
     * Removes a option by name for the current network.
     *
     * @since 2.8.0
     * @since 4.4.0 Modified into wrapper for delete_network_option()
     *
     * @see delete_network_option()
     *
     * @param string $option Name of option to remove. Expected to not be SQL-escaped.
     * @return bool True, if succeed. False, if failure.
     */
    public static function delete_site_option( $option ) {
        return self::delete_network_option( null, $option );
    }
    
    /**
     * Update the value of an option that was already added for the current network.
     *
     * @since 2.8.0
     * @since 4.4.0 Modified into wrapper for update_network_option()
     *
     * @see update_network_option()
     *
     * @param string $option Name of option. Expected to not be SQL-escaped.
     * @param mixed  $value  Option value. Expected to not be SQL-escaped.
     * @return bool False if value was not updated. True if value was updated.
     */
    public static function update_site_option( $option, $value ) {
        return self::update_network_option( null, $option, $value );
    }
    
    /**
     * Retrieve a network's option value based on the option name.
     *
     * @since 4.4.0
     *
     * @see get_option()
     *
     * @global wpdb   $wpdb
     * @global object $current_site
     *
     * @param int      $network_id ID of the network. Can be null to default to the current network ID.
     * @param string   $option     Name of option to retrieve. Expected to not be SQL-escaped.
     * @param mixed    $default    Optional. Value to return if the option doesn't exist. Default false.
     * @return mixed Value set for the option.
     */
    public static function get_network_option( $network_id, $option, $default = false ) {
//         global $wpdb, $current_site;
    
        if ( $network_id && ! is_numeric( $network_id ) ) {
            return false;
        }
    
        $network_id = (int) $network_id;
    
        // Fallback to the current network if a network ID is not specified.
        if ( ! $network_id && is_multisite() ) {
            $network_id = $current_site->id;
        }
    
        /**
         * Filter an existing network option before it is retrieved.
         *
         * The dynamic portion of the hook name, `$option`, refers to the option name.
         *
         * Passing a truthy value to the filter will effectively short-circuit retrieval,
         * returning the passed value instead.
         *
         * @since 2.9.0 As 'pre_site_option_' . $key
         * @since 3.0.0
         * @since 4.4.0 The `$option` parameter was added
         *
         * @param mixed  $pre_option The default value to return if the option does not exist.
         * @param string $option     Option name.
         */
        $pre = RC_Hook::apply_filters( 'pre_site_option_' . $option, false, $option );
    
        if ( false !== $pre ) {
            return $pre;
        }
    
        // prevent non-existent options from triggering multiple queries
        $notoptions_key = "$network_id:notoptions";
        $notoptions = RC_Cache::app_cache_get( $notoptions_key, 'site-options' );
    
        if ( isset( $notoptions[ $option ] ) ) {
    
            /**
             * Filter a specific default network option.
             *
             * The dynamic portion of the hook name, `$option`, refers to the option name.
             *
             * @since 3.4.0
             * @since 4.4.0 The `$option` parameter was added.
             *
             * @param mixed  $default The value to return if the site option does not exist
             *                        in the database.
             * @param string $option  Option name.
             */
            return RC_Hook::apply_filters( 'default_site_option_' . $option, $default, $option );
        }
    
        if ( ! is_multisite() ) {
            /** This filter is documented in wp-includes/option.php */
            $default = RC_Hook::apply_filters( 'default_site_option_' . $option, $default, $option );
            $value = self::get_option( $option, $default );
        } else {
            $cache_key = "$network_id:$option";
            $value = RC_Cache::app_cache_get( $cache_key, 'site-options' );
    
            if ( ! isset( $value ) || false === $value ) {
                $row = $wpdb->get_row( $wpdb->prepare( "SELECT meta_value FROM $wpdb->sitemeta WHERE meta_key = %s AND site_id = %d", $option, $network_id ) );
    
                // Has to be get_row instead of get_var because of funkiness with 0, false, null values
                if ( is_object( $row ) ) {
                    $value = $row->meta_value;
                    $value = RC_Format::maybe_unserialize( $value );
                    RC_Cache::app_cache_set( $cache_key, $value, 'site-options' );
                } else {
                    if ( ! is_array( $notoptions ) ) {
                        $notoptions = array();
                    }
                    $notoptions[ $option ] = true;
                    RC_Cache::app_cache_set( $notoptions_key, $notoptions, 'site-options' );
    
                    /** This filter is documented in wp-includes/option.php */
                    $value = RC_Hook::apply_filters( 'default_site_option_' . $option, $default, $option );
                }
            }
        }
    
        /**
         * Filter the value of an existing network option.
         *
         * The dynamic portion of the hook name, `$option`, refers to the option name.
         *
         * @since 2.9.0 As 'site_option_' . $key
         * @since 3.0.0
         * @since 4.4.0 The `$option` parameter was added
         *
         * @param mixed  $value  Value of network option.
         * @param string $option Option name.
         */
        return RC_Hook::apply_filters( 'site_option_' . $option, $value, $option );
    }
    
    /**
     * Add a new network option.
     *
     * Existing options will not be updated.
     *
     * @since 4.4.0
     *
     * @see add_option()
     *
     * @global wpdb   $wpdb
     * @global object $current_site
     *
     * @param int    $network_id ID of the network. Can be null to default to the current network ID.
     * @param string $option     Name of option to add. Expected to not be SQL-escaped.
     * @param mixed  $value      Option value, can be anything. Expected to not be SQL-escaped.
     * @return bool False if option was not added and true if option was added.
     */
    public static function add_network_option( $network_id, $option, $value ) {
//         global $wpdb, $current_site;
    
        if ( $network_id && ! is_numeric( $network_id ) ) {
            return false;
        }
    
        $network_id = (int) $network_id;
    
        // Fallback to the current network if a network ID is not specified.
        if ( ! $network_id && is_multisite() ) {
            $network_id = $current_site->id;
        }
    
        self::protect_special_option( $option );
    
        /**
         * Filter the value of a specific network option before it is added.
         *
         * The dynamic portion of the hook name, `$option`, refers to the option name.
         *
         * @since 2.9.0 As 'pre_add_site_option_' . $key
         * @since 3.0.0
         * @since 4.4.0 The `$option` parameter was added
         *
         * @param mixed  $value  Value of network option.
         * @param string $option Option name.
        */
        $value = RC_Hook::apply_filters( 'pre_add_site_option_' . $option, $value, $option );
    
        $notoptions_key = "$network_id:notoptions";
    
        if ( ! is_multisite() ) {
            $result = self::add_option( $option, $value );
        } else {
            $cache_key = "$network_id:$option";
    
            // Make sure the option doesn't already exist. We can check the 'notoptions' cache before we ask for a db query
            $notoptions = RC_Cache::app_cache_get( $notoptions_key, 'site-options' );
            if ( ! is_array( $notoptions ) || ! isset( $notoptions[ $option ] ) ) {
                if ( false !== self::get_network_option( $network_id, $option, false ) ) {
                    return false;
                }
            }
    
            $value = self::sanitize_option( $option, $value );
    
            $serialized_value = RC_Format::maybe_serialize( $value );
            $result = $wpdb->insert( $wpdb->sitemeta, array( 'site_id'    => $network_id, 'meta_key'   => $option, 'meta_value' => $serialized_value ) );
    
            if ( ! $result ) {
                return false;
            }
    
            RC_Cache::app_cache_set( $cache_key, $value, 'site-options' );
    
            // This option exists now
            $notoptions = RC_Cache::app_cache_get( $notoptions_key, 'site-options' ); // yes, again... we need it to be fresh
            if ( is_array( $notoptions ) && isset( $notoptions[ $option ] ) ) {
                unset( $notoptions[ $option ] );
                RC_Cache::app_cache_set( $notoptions_key, $notoptions, 'site-options' );
            }
        }
    
        if ( $result ) {
    
            /**
             * Fires after a specific network option has been successfully added.
             *
             * The dynamic portion of the hook name, `$option`, refers to the option name.
             *
             * @since 2.9.0 As "add_site_option_{$key}"
             * @since 3.0.0
             *
             * @param string $option Name of the network option.
             * @param mixed  $value  Value of the network option.
             */
            RC_Hook::do_action( 'add_site_option_' . $option, $option, $value );
    
            /**
             * Fires after a network option has been successfully added.
             *
             * @since 3.0.0
             *
             * @param string $option Name of the network option.
             * @param mixed  $value  Value of the network option.
            */
            RC_Hook::do_action( 'add_site_option', $option, $value );
    
            return true;
        }
    
        return false;
    }
    
    /**
     * Removes a network option by name.
     *
     * @since 4.4.0
     *
     * @see delete_option()
     *
     * @global wpdb   $wpdb
     * @global object $current_site
     *
     * @param int    $network_id ID of the network. Can be null to default to the current network ID.
     * @param string $option     Name of option to remove. Expected to not be SQL-escaped.
     * @return bool True, if succeed. False, if failure.
     */
    public static function delete_network_option( $network_id, $option ) {
//         global $wpdb, $current_site;
    
        if ( $network_id && ! is_numeric( $network_id ) ) {
            return false;
        }
    
        $network_id = (int) $network_id;
    
        // Fallback to the current network if a network ID is not specified.
        if ( ! $network_id && is_multisite() ) {
            $network_id = $current_site->id;
        }
    
        /**
         * Fires immediately before a specific network option is deleted.
         *
         * The dynamic portion of the hook name, `$option`, refers to the option name.
         *
         * @since 3.0.0
         * @since 4.4.0 The `$option` parameter was added
         *
         * @param string $option Option name.
         */
        RC_Hook::do_action( 'pre_delete_site_option_' . $option, $option );
    
        if ( ! is_multisite() ) {
            $result = self::delete_option( $option );
        } else {
            $row = $wpdb->get_row( $wpdb->prepare( "SELECT meta_id FROM {$wpdb->sitemeta} WHERE meta_key = %s AND site_id = %d", $option, $network_id ) );
            if ( is_null( $row ) || ! $row->meta_id ) {
                return false;
            }
            $cache_key = "$network_id:$option";
            RC_Cache::app_cache_delete( $cache_key, 'site-options' );
    
            $result = $wpdb->delete( $wpdb->sitemeta, array( 'meta_key' => $option, 'site_id' => $network_id ) );
        }
    
        if ( $result ) {
    
            /**
             * Fires after a specific network option has been deleted.
             *
             * The dynamic portion of the hook name, `$option`, refers to the option name.
             *
             * @since 2.9.0 As "delete_site_option_{$key}"
             * @since 3.0.0
             *
             * @param string $option Name of the network option.
             */
            RC_Hook::do_action( 'delete_site_option_' . $option, $option );
    
            /**
             * Fires after a network option has been deleted.
             *
             * @since 3.0.0
             *
             * @param string $option Name of the network option.
            */
            RC_Hook::do_action( 'delete_site_option', $option );
    
            return true;
        }
    
        return false;
    }
    
    /**
     * Update the value of a network option that was already added.
     *
     * @since 4.4.0
     *
     * @see update_option()
     *
     * @global wpdb   $wpdb
     * @global object $current_site
     *
     * @param int      $network_id ID of the network. Can be null to default to the current network ID.
     * @param string   $option     Name of option. Expected to not be SQL-escaped.
     * @param mixed    $value      Option value. Expected to not be SQL-escaped.
     * @return bool False if value was not updated and true if value was updated.
     */
    public static function update_network_option( $network_id, $option, $value ) {
//         global $wpdb, $current_site;
    
        if ( $network_id && ! is_numeric( $network_id ) ) {
            return false;
        }
    
        $network_id = (int) $network_id;
    
        // Fallback to the current network if a network ID is not specified.
        if ( ! $network_id && is_multisite() ) {
            $network_id = $current_site->id;
        }
    
        self::protect_special_option( $option );
    
        $old_value = self::get_network_option( $network_id, $option, false );
    
        /**
         * Filter a specific network option before its value is updated.
         *
         * The dynamic portion of the hook name, `$option`, refers to the option name.
         *
         * @since 2.9.0 As 'pre_update_site_option_' . $key
         * @since 3.0.0
         * @since 4.4.0 The `$option` parameter was added
         *
         * @param mixed  $value     New value of the network option.
         * @param mixed  $old_value Old value of the network option.
         * @param string $option    Option name.
        */
        $value = RC_Hook::apply_filters( 'pre_update_site_option_' . $option, $value, $old_value, $option );
    
        if ( $value === $old_value ) {
            return false;
        }
    
        if ( false === $old_value ) {
            return self::add_network_option( $network_id, $option, $value );
        }
    
        $notoptions_key = "$network_id:notoptions";
        $notoptions = RC_Cache::app_cache_get( $notoptions_key, 'site-options' );
        if ( is_array( $notoptions ) && isset( $notoptions[ $option ] ) ) {
            unset( $notoptions[ $option ] );
            RC_Cache::app_cache_set( $notoptions_key, $notoptions, 'site-options' );
        }
    
        if ( ! is_multisite() ) {
            $result = self::update_option( $option, $value );
        } else {
            $value = self::sanitize_option( $option, $value );
    
            $serialized_value = RC_Format::maybe_serialize( $value );
            $result = $wpdb->update( $wpdb->sitemeta, array( 'meta_value' => $serialized_value ), array( 'site_id' => $network_id, 'meta_key' => $option ) );
    
            if ( $result ) {
                $cache_key = "$network_id:$option";
                RC_Cache::app_cache_set( $cache_key, $value, 'site-options' );
            }
        }
    
        if ( $result ) {
    
            /**
             * Fires after the value of a specific network option has been successfully updated.
             *
             * The dynamic portion of the hook name, `$option`, refers to the option name.
             *
             * @since 2.9.0 As "update_site_option_{$key}"
             * @since 3.0.0
             *
             * @param string $option    Name of the network option.
             * @param mixed  $value     Current value of the network option.
             * @param mixed  $old_value Old value of the network option.
             */
            RC_Hook::do_action( 'update_site_option_' . $option, $option, $value, $old_value );
    
            /**
             * Fires after the value of a network option has been successfully updated.
             *
             * @since 3.0.0
             *
             * @param string $option    Name of the network option.
             * @param mixed  $value     Current value of the network option.
             * @param mixed  $old_value Old value of the network option.
            */
            RC_Hook::do_action( 'update_site_option', $option, $value, $old_value );
    
            return true;
        }
    
        return false;
    }
    
    /**
     * Delete a site transient.
     *
     * @since 2.9.0
     *
     * @param string $transient Transient name. Expected to not be SQL-escaped.
     * @return bool True if successful, false otherwise
     */
    public static function delete_site_transient( $transient ) {
    
        /**
         * Fires immediately before a specific site transient is deleted.
         *
         * The dynamic portion of the hook name, `$transient`, refers to the transient name.
         *
         * @since 3.0.0
         *
         * @param string $transient Transient name.
         */
        RC_Hook::do_action( 'delete_site_transient_' . $transient, $transient );
    
        if ( wp_using_ext_object_cache() ) {
            $result = RC_Cache::app_cache_delete( $transient, 'site-transient' );
        } else {
            $option_timeout = '_site_transient_timeout_' . $transient;
            $option = '_site_transient_' . $transient;
            $result = self::delete_site_option( $option );
            if ( $result )
                self::delete_site_option( $option_timeout );
        }
        if ( $result ) {
    
            /**
             * Fires after a transient is deleted.
             *
             * @since 3.0.0
             *
             * @param string $transient Deleted transient name.
             */
            RC_Hook::do_action( 'deleted_site_transient', $transient );
        }
    
        return $result;
    }
    
    /**
     * Get the value of a site transient.
     *
     * If the transient does not exist, does not have a value, or has expired,
     * then the return value will be false.
     *
     * @since 2.9.0
     *
     * @see get_transient()
     *
     * @param string $transient Transient name. Expected to not be SQL-escaped.
     * @return mixed Value of transient.
     */
    public static function get_site_transient( $transient ) {
    
        /**
         * Filter the value of an existing site transient.
         *
         * The dynamic portion of the hook name, `$transient`, refers to the transient name.
         *
         * Passing a truthy value to the filter will effectively short-circuit retrieval,
         * returning the passed value instead.
         *
         * @since 2.9.0
         * @since 4.4.0 The `$transient` parameter was added.
         *
         * @param mixed  $pre_site_transient The default value to return if the site transient does not exist.
         *                                   Any value other than false will short-circuit the retrieval
         *                                   of the transient, and return the returned value.
         * @param string $transient          Transient name.
         */
        $pre = RC_Hook::apply_filters( 'pre_site_transient_' . $transient, false, $transient );
    
        if ( false !== $pre )
            return $pre;
    
        if ( wp_using_ext_object_cache() ) {
            $value = RC_Cache::app_cache_get( $transient, 'site-transient' );
        } else {
            // Core transients that do not have a timeout. Listed here so querying timeouts can be avoided.
            $no_timeout = array('update_core', 'update_plugins', 'update_themes');
            $transient_option = '_site_transient_' . $transient;
            if ( ! in_array( $transient, $no_timeout ) ) {
                $transient_timeout = '_site_transient_timeout_' . $transient;
                $timeout = self::get_site_option( $transient_timeout );
                if ( false !== $timeout && $timeout < time() ) {
                    self::delete_site_option( $transient_option  );
                    self::delete_site_option( $transient_timeout );
                    $value = false;
                }
            }
    
            if ( ! isset( $value ) )
                $value = self::get_site_option( $transient_option );
        }
    
        /**
         * Filter the value of an existing site transient.
         *
         * The dynamic portion of the hook name, `$transient`, refers to the transient name.
         *
         * @since 2.9.0
         * @since 4.4.0 The `$transient` parameter was added.
         *
         * @param mixed  $value     Value of site transient.
         * @param string $transient Transient name.
         */
        return RC_Hook::apply_filters( 'site_transient_' . $transient, $value, $transient );
    }
    
    /**
     * Set/update the value of a site transient.
     *
     * You do not need to serialize values, if the value needs to be serialize, then
     * it will be serialized before it is set.
     *
     * @since 2.9.0
     *
     * @see set_transient()
     *
     * @param string $transient  Transient name. Expected to not be SQL-escaped. Must be
     *                           40 characters or fewer in length.
     * @param mixed  $value      Transient value. Expected to not be SQL-escaped.
     * @param int    $expiration Optional. Time until expiration in seconds. Default 0 (no expiration).
     * @return bool False if value was not set and true if value was set.
     */
    public static function set_site_transient( $transient, $value, $expiration = 0 ) {
    
        /**
         * Filter the value of a specific site transient before it is set.
         *
         * The dynamic portion of the hook name, `$transient`, refers to the transient name.
         *
         * @since 3.0.0
         * @since 4.4.0 The `$transient` parameter was added.
         *
         * @param mixed  $value     New value of site transient.
         * @param string $transient Transient name.
         */
        $value = RC_Hook::apply_filters( 'pre_set_site_transient_' . $transient, $value, $transient );
    
        $expiration = (int) $expiration;
    
        /**
         * Filter the expiration for a site transient before its value is set.
         *
         * The dynamic portion of the hook name, `$transient`, refers to the transient name.
         *
         * @since 4.4.0
         *
         * @param int    $expiration Time until expiration in seconds. Use 0 for no expiration.
         * @param mixed  $value      New value of site transient.
         * @param string $transient  Transient name.
         */
        $expiration = RC_Hook::apply_filters( 'expiration_of_site_transient_' . $transient, $expiration, $value, $transient );
    
        if ( wp_using_ext_object_cache() ) {
            $result = RC_Cache::app_cache_set( $transient, $value, 'site-transient', $expiration );
        } else {
            $transient_timeout = '_site_transient_timeout_' . $transient;
            $option = '_site_transient_' . $transient;
            if ( false === self::get_site_option( $option ) ) {
                if ( $expiration )
                    self::add_site_option( $transient_timeout, time() + $expiration );
                $result = self::add_site_option( $option, $value );
            } else {
                if ( $expiration )
                    self::update_site_option( $transient_timeout, time() + $expiration );
                $result = self::update_site_option( $option, $value );
            }
        }
        if ( $result ) {
    
            /**
             * Fires after the value for a specific site transient has been set.
             *
             * The dynamic portion of the hook name, `$transient`, refers to the transient name.
             *
             * @since 3.0.0
             * @since 4.4.0 The `$transient` parameter was added
             *
             * @param mixed  $value      Site transient value.
             * @param int    $expiration Time until expiration in seconds.
             * @param string $transient  Transient name.
             */
            RC_Hook::do_action( 'set_site_transient_' . $transient, $value, $expiration, $transient );
    
            /**
             * Fires after the value for a site transient has been set.
             *
             * @since 3.0.0
             *
             * @param string $transient  The name of the site transient.
             * @param mixed  $value      Site transient value.
             * @param int    $expiration Time until expiration in seconds.
            */
            RC_Hook::do_action( 'setted_site_transient', $transient, $value, $expiration );
        }
        return $result;
    }
}

