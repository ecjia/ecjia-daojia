<?php
namespace Ecjia\Component\Upgrade;

use Ecjia\Component\Upgrade\Skin\AutomaticUpgraderSkin;
use Ecjia\Component\Upgrade\Upgrader\CoreUpgrader;
use Ecjia\Component\Upgrade\Upgrader\LanguagePackUpgrader;
use Ecjia\Component\Upgrade\Upgrader\PluginUpgrader;
use Ecjia\Component\Upgrade\Upgrader\ThemeUpgrader;
use RC_Hook;
use RC_Format;
use ecjia_error;

/**
 * The ECJia automatic background updater.
 *
 * @package ECJia
 * @subpackage Upgrader
 * @since 3.7.0
 */
class AutomaticUpdater
{
    /**
     * Tracks update results during processing.
     *
     * @var array
     */
    protected $update_results = array();
    
    /**
     * Whether the entire automatic updater is disabled.
     *
     * @since 3.7.0
    */
    public function is_disabled()
    {
        // Background updates are disabled if you don't want file changes.
        if ( defined( 'DISALLOW_FILE_MODS' ) && DISALLOW_FILE_MODS )
            return true;
    
        if ( defined( 'WP_INSTALLING' ) )
            return true;
    
        // More fine grained control can be done through the WP_AUTO_UPDATE_CORE constant and filters.
        $disabled = defined( 'AUTOMATIC_UPDATER_DISABLED' ) && AUTOMATIC_UPDATER_DISABLED;
    
        /**
         * Filter whether to entirely disable background updates.
         *
         * There are more fine-grained filters and controls for selective disabling.
         * This filter parallels the AUTOMATIC_UPDATER_DISABLED constant in name.
         *
         * This also disables update notification emails. That may change in the future.
         *
         * @since 3.7.0
         *
         * @param bool $disabled Whether the updater should be disabled.
         */
        return RC_Hook::apply_filters( 'automatic_updater_disabled', $disabled );
    }
    
    /**
     * Check for version control checkouts.
     *
     * Checks for Subversion, Git, Mercurial, and Bazaar. It recursively looks up the
     * filesystem to the top of the drive, erring on the side of detecting a VCS
     * checkout somewhere.
     *
     * ABSPATH is always checked in addition to whatever $context is (which may be the
     * wp-content directory, for example). The underlying assumption is that if you are
     * using version control *anywhere*, then you should be making decisions for
     * how things get updated.
     *
     * @since 3.7.0
     *
     * @param string $context The filesystem path to check, in addition to ABSPATH.
     */
    public function is_vcs_checkout( $context )
    {
        $context_dirs = array( RC_Format::untrailingslashit( $context ) );
        if ( $context !== ABSPATH )
            $context_dirs[] = RC_Format::untrailingslashit( ABSPATH );
    
        $vcs_dirs = array( '.svn', '.git', '.hg', '.bzr' );
        $check_dirs = array();
    
        foreach ( $context_dirs as $context_dir ) {
            // Walk up from $context_dir to the root.
            do {
                $check_dirs[] = $context_dir;
    
                // Once we've hit '/' or 'C:\', we need to stop. dirname will keep returning the input here.
                if ( $context_dir == dirname( $context_dir ) )
                    break;
    
                // Continue one level at a time.
            } while ( ($context_dir = dirname( $context_dir )) !== false );
        }
    
        $check_dirs = array_unique( $check_dirs );
    
        // Search all directories we've found for evidence of version control.
        foreach ( $vcs_dirs as $vcs_dir ) {
            foreach ( $check_dirs as $check_dir ) {
                if ( $checkout = @is_dir( rtrim( $check_dir, '\\/' ) . "/$vcs_dir" ) )
                    break 2;
            }
        }
    
        /**
         * Filter whether the automatic updater should consider a filesystem
         * location to be potentially managed by a version control system.
         *
         * @since 3.7.0
         *
         * @param bool $checkout  Whether a VCS checkout was discovered at $context
         *                        or ABSPATH, or anywhere higher.
         * @param string $context The filesystem context (a path) against which
         *                        filesystem status should be checked.
         */
        return RC_Hook::apply_filters( 'automatic_updates_is_vcs_checkout', $checkout, $context );
    }
    
    /**
     * Tests to see if we can and should update a specific item.
     *
     * @since 3.7.0
     *
     * @param string $type    The type of update being checked: 'core', 'theme',
     *                        'plugin', 'translation'.
     * @param object $item    The update offer.
     * @param string $context The filesystem context (a path) against which filesystem
     *                        access and status should be checked.
     */
    public function should_update( $type, $item, $context )
    {
        // Used to see if WP_Filesystem is set up to allow unattended updates.
        $skin = new AutomaticUpgraderSkin();
    
        if ( $this->is_disabled() ) {
            return false;
        }
    
        // If we can't do an auto core update, we may still be able to email the user.
        if ( ! $skin->request_filesystem_credentials( false, $context ) || $this->is_vcs_checkout( $context ) ) {
            if ( 'core' == $type ) {
                $this->send_core_update_notification_email( $item );
            }
            return false;
        }
    
        // Next up, is this an item we can update?
        if ( 'core' == $type ) {
            $update = CoreUpgrader::should_update_to_version( $item->current );
        } else {
            $update = ! empty( $item->autoupdate );
        }
    
        /**
         * Filter whether to automatically update core, a plugin, a theme, or a language.
         *
         * The dynamic portion of the hook name, $type, refers to the type of update
         * being checked. Can be 'core', 'theme', 'plugin', or 'translation'.
         *
         * Generally speaking, plugins, themes, and major core versions are not updated
         * by default, while translations and minor and development versions for core
         * are updated by default.
         *
         * See the allow_dev_auto_core_updates, allow_minor_auto_core_updates, and
         * allow_major_auto_core_updates filters for a more straightforward way to
         * adjust core updates.
         *
         * @since 3.7.0
         *
         * @param bool   $update Whether to update.
         * @param object $item   The update offer.
        */
        $update = RC_Hook::apply_filters( 'auto_update_' . $type, $update, $item );
    
        if ( ! $update ) {
            if ( 'core' == $type ) {
                $this->send_core_update_notification_email( $item );
            }
            return false;
        }
    
        // If it's a core update, are we actually compatible with its requirements?
        if ( 'core' == $type ) {
            global $wpdb;
    
            $php_compat = version_compare( phpversion(), $item->php_version, '>=' );
            if ( file_exists( WP_CONTENT_DIR . '/db.php' ) && empty( $wpdb->is_mysql ) ) {
                $mysql_compat = true;
            } else {
                $mysql_compat = version_compare( $wpdb->db_version(), $item->mysql_version, '>=' );
            }
    
            if ( ! $php_compat || ! $mysql_compat ) {
                return false;
            }
        }
    
        return true;
    }
    
    /**
     * Notifies an administrator of a core update.
     *
     * @since 3.7.0
     *
     * @param object $item The update offer.
     */
    protected function send_core_update_notification_email( $item )
    {
        $notify   = true;
        $notified = get_site_option( 'auto_core_update_notified' );
    
        // Don't notify if we've already notified the same email address of the same version.
        if ( $notified && $notified['email'] == get_site_option( 'admin_email' ) && $notified['version'] == $item->current ) {
            return false;
        }
    
        // See if we need to notify users of a core update.
        $notify = ! empty( $item->notify_email );
    
        /**
         * Filter whether to notify the site administrator of a new core update.
         *
         * By default, administrators are notified when the update offer received
         * from WordPress.org sets a particular flag. This allows some discretion
         * in if and when to notify.
         *
         * This filter is only evaluated once per release. If the same email address
         * was already notified of the same new version, WordPress won't repeatedly
         * email the administrator.
         *
         * This filter is also used on about.php to check if a plugin has disabled
         * these notifications.
         *
         * @since 3.7.0
         *
         * @param bool   $notify Whether the site administrator is notified.
         * @param object $item   The update offer.
        */
        if ( ! RC_Hook::apply_filters( 'send_core_update_notification_email', $notify, $item ) ) {
            return false;
        }
    
        $this->send_email( 'manual', $item );
        return true;
    }
    
    /**
     * Update an item, if appropriate.
     *
     * @since 3.7.0
     *
     * @param string $type The type of update being checked: 'core', 'theme', 'plugin', 'translation'.
     * @param object $item The update offer.
     */
    public function update( $type, $item )
    {
        $skin = new AutomaticUpgraderSkin();
    
        switch ( $type ) {
            case 'core':
                // The Core upgrader doesn't use the Upgrader's skin during the actual main part of the upgrade, instead, firing a filter.
                RC_Hook::add_filter( 'update_feedback', array( $skin, 'feedback' ) );
                $upgrader = new CoreUpgrader( $skin );
                $context  = ABSPATH;
                break;
            case 'plugin':
                $upgrader = new PluginUpgrader( $skin );
                $context  = WP_PLUGIN_DIR; // We don't support custom Plugin directories, or updates for WPMU_PLUGIN_DIR
                break;
            case 'theme':
                $upgrader = new ThemeUpgrader( $skin );
                $context  = get_theme_root( $item->theme );
                break;
            case 'translation':
                $upgrader = new LanguagePackUpgrader( $skin );
                $context  = WP_CONTENT_DIR; // WP_LANG_DIR;
                break;
        }
    
        // Determine whether we can and should perform this update.
        if ( ! $this->should_update( $type, $item, $context ) ) {
            return false;
        }
    
        $upgrader_item = $item;
        switch ( $type ) {
            case 'core':
                $skin->feedback( sprintf(__( 'Updating to WordPress %s', 'ecjia'), $item->version));
                $item_name = sprintf( __( 'WordPress %s', 'ecjia'), $item->version );
                break;
            case 'theme':
                $upgrader_item = $item->theme;
                $theme = wp_get_theme( $upgrader_item );
                $item_name = $theme->Get( 'Name' );
                $skin->feedback( sprintf(__( 'Updating theme: %s', 'ecjia'), $item_name ));
                break;
            case 'plugin':
                $upgrader_item = $item->plugin;
                $plugin_data = get_plugin_data( $context . '/' . $upgrader_item );
                $item_name = $plugin_data['Name'];
                $skin->feedback( sprintf(__( 'Updating plugin: %s', 'ecjia'), $item_name ));
                break;
            case 'translation':
                $language_item_name = $upgrader->get_name_for_update( $item );
                $item_name = sprintf( __( 'Translations for %s', 'ecjia'), $language_item_name );
                $skin->feedback( sprintf( __( 'Updating translations for %1$s (%2$s)&#8230;', 'ecjia'), $language_item_name, $item->language ) );
                break;
        }
    
        // Boom, This sites about to get a whole new splash of paint!
        $upgrade_result = $upgrader->upgrade( $upgrader_item, array(
            'clear_update_cache' => false,
            'pre_check_md5'      => false, /* always use partial builds if possible for core updates */
            'attempt_rollback'   => true, /* only available for core updates */
        ) );
    
        // if the filesystem is unavailable, false is returned.
        if ( false === $upgrade_result ) {
            $upgrade_result = new ecjia_error( 'fs_unavailable', __( 'Could not access filesystem.', 'ecjia') );
        }
    
        // Core doesn't output this, so lets append it so we don't get confused
        if ( 'core' == $type ) {
            if ( is_ecjia_error( $upgrade_result ) ) {
                $skin->error( __( 'Installation Failed', 'ecjia'), $upgrade_result );
            } else {
                $skin->feedback( __( 'WordPress updated successfully', 'ecjia') );
            }
        }
    
        $this->update_results[ $type ][] = (object) array(
            'item'     => $item,
            'result'   => $upgrade_result,
            'name'     => $item_name,
            'messages' => $skin->get_upgrade_messages()
        );
    
        return $upgrade_result;
    }
    
    /**
     * Kicks off the background update process, looping through all pending updates.
     *
     * @since 3.7.0
     */
    public function run()
    {
        global $wpdb, $wp_version;
    
        if ( $this->is_disabled() )
            return;
    
        if ( ! is_main_network() || ! is_main_site() )
            return;
    
        $lock_name = 'auto_updater.lock';
    
        // Try to lock
        $lock_result = $wpdb->query( $wpdb->prepare( "INSERT IGNORE INTO `$wpdb->options` ( `option_name`, `option_value`, `autoload` ) VALUES (%s, %s, 'no') /* LOCK */", $lock_name, time() ) );
    
        if ( ! $lock_result ) {
            $lock_result = get_option( $lock_name );
    
            // If we couldn't create a lock, and there isn't a lock, bail
            if ( ! $lock_result )
                return;
    
            // Check to see if the lock is still valid
            if ( $lock_result > ( time() - HOUR_IN_SECONDS ) )
                return;
        }
    
        // Update the lock, as by this point we've definately got a lock, just need to fire the actions
        update_option( $lock_name, time() );
    
        // Don't automatically run these thins, as we'll handle it ourselves
        RC_Hook::remove_action( 'upgrader_process_complete', array( 'Language_Pack_Upgrader', 'async_upgrade' ), 20 );
        RC_Hook::remove_action( 'upgrader_process_complete', 'wp_version_check' );
        RC_Hook::remove_action( 'upgrader_process_complete', 'wp_update_plugins' );
        RC_Hook::remove_action( 'upgrader_process_complete', 'wp_update_themes' );
    
        // Next, Plugins
        wp_update_plugins(); // Check for Plugin updates
        $plugin_updates = get_site_transient( 'update_plugins' );
        if ( $plugin_updates && !empty( $plugin_updates->response ) ) {
            foreach ( $plugin_updates->response as $plugin ) {
                $this->update( 'plugin', $plugin );
            }
            // Force refresh of plugin update information
            wp_clean_plugins_cache();
        }
    
        // Next, those themes we all love
        wp_update_themes();  // Check for Theme updates
        $theme_updates = get_site_transient( 'update_themes' );
        if ( $theme_updates && !empty( $theme_updates->response ) ) {
            foreach ( $theme_updates->response as $theme ) {
                $this->update( 'theme', (object) $theme );
            }
            // Force refresh of theme update information
            wp_clean_themes_cache();
        }
    
        // Next, Process any core update
        wp_version_check(); // Check for Core updates
        $core_update = find_core_auto_update();
    
        if ( $core_update )
            $this->update( 'core', $core_update );
    
        // Clean up, and check for any pending translations
        // (Core_Upgrader checks for core updates)
        $theme_stats = array();
        if ( isset( $this->update_results['theme'] ) ) {
            foreach ( $this->update_results['theme'] as $upgrade ) {
                $theme_stats[ $upgrade->item->theme ] = ( true === $upgrade->result );
            }
        }
        wp_update_themes( $theme_stats );  // Check for Theme updates
    
        $plugin_stats = array();
        if ( isset( $this->update_results['plugin'] ) ) {
            foreach ( $this->update_results['plugin'] as $upgrade ) {
                $plugin_stats[ $upgrade->item->plugin ] = ( true === $upgrade->result );
            }
        }
        wp_update_plugins( $plugin_stats ); // Check for Plugin updates
    
        // Finally, Process any new translations
        $language_updates = wp_get_translation_updates();
        if ( $language_updates ) {
            foreach ( $language_updates as $update ) {
                $this->update( 'translation', $update );
            }
    
            // Clear existing caches
            wp_clean_plugins_cache();
            wp_clean_themes_cache();
            delete_site_transient( 'update_core' );
    
            wp_version_check();  // check for Core updates
            wp_update_themes();  // Check for Theme updates
            wp_update_plugins(); // Check for Plugin updates
        }
    
        // Send debugging email to all development installs.
        if ( ! empty( $this->update_results ) ) {
            $development_version = false !== strpos( $wp_version, '-' );
    
            /**
             * Filter whether to send a debugging email for each automatic background update.
             *
             * @since 3.7.0
             *
             * @param bool $development_version By default, emails are sent if the
             *                                  install is a development version.
             *                                  Return false to avoid the email.
            */
            if ( RC_Hook::apply_filters( 'automatic_updates_send_debug_email', $development_version ) )
                $this->send_debug_email();
    
            if ( ! empty( $this->update_results['core'] ) )
                $this->after_core_update( $this->update_results['core'][0] );
    
            /**
             * Fires after all automatic updates have run.
             *
             * @since 3.8.0
             *
             * @param array $update_results The results of all attempted updates.
            */
            RC_Hook::do_action( 'automatic_updates_complete', $this->update_results );
        }
    
        // Clear the lock
        delete_option( $lock_name );
    }
    
    
    /**
     * If we tried to perform a core update, check if we should send an email,
     * and if we need to avoid processing future updates.
     *
     * @param object $update_result The result of the core update. Includes the update offer and result.
     */
    protected function after_core_update( $update_result )
    {
        global $wp_version;
    
        $core_update = $update_result->item;
        $result      = $update_result->result;
    
        if ( ! is_ecjia_error( $result ) ) {
            $this->send_email( 'success', $core_update );
            return;
        }
    
        $error_code = $result->get_error_code();
    
        // Any of these WP_Error codes are critical failures, as in they occurred after we started to copy core files.
        // We should not try to perform a background update again until there is a successful one-click update performed by the user.
        $critical = false;
        if ( $error_code === 'disk_full' || false !== strpos( $error_code, '__copy_dir' ) ) {
            $critical = true;
        } elseif ( $error_code === 'rollback_was_required' && is_ecjia_error( $result->get_error_data()->rollback ) ) {
            // A rollback is only critical if it failed too.
            $critical = true;
            $rollback_result = $result->get_error_data()->rollback;
        } elseif ( false !== strpos( $error_code, 'do_rollback' ) ) {
            $critical = true;
        }
    
        if ( $critical ) {
            $critical_data = array(
                'attempted'  => $core_update->current,
                'current'    => $wp_version,
                'error_code' => $error_code,
                'error_data' => $result->get_error_data(),
                'timestamp'  => time(),
                'critical'   => true,
            );
            if ( isset( $rollback_result ) ) {
                $critical_data['rollback_code'] = $rollback_result->get_error_code();
                $critical_data['rollback_data'] = $rollback_result->get_error_data();
            }
            update_site_option( 'auto_core_update_failed', $critical_data );
            $this->send_email( 'critical', $core_update, $result );
            return;
        }
    
        /*
         * Any other WP_Error code (like download_failed or files_not_writable) occurs before
         * we tried to copy over core files. Thus, the failures are early and graceful.
         *
         * We should avoid trying to perform a background update again for the same version.
         * But we can try again if another version is released.
         *
         * For certain 'transient' failures, like download_failed, we should allow retries.
         * In fact, let's schedule a special update for an hour from now. (It's possible
         * the issue could actually be on WordPress.org's side.) If that one fails, then email.
         */
        $send = true;
      		$transient_failures = array( 'incompatible_archive', 'download_failed', 'insane_distro' );
      		if ( in_array( $error_code, $transient_failures ) && ! get_site_option( 'auto_core_update_failed' ) ) {
      		    wp_schedule_single_event( time() + HOUR_IN_SECONDS, 'wp_maybe_auto_update' );
      		    $send = false;
      		}
    
      		$n = get_site_option( 'auto_core_update_notified' );
      		// Don't notify if we've already notified the same email address of the same version of the same notification type.
      		if ( $n && 'fail' == $n['type'] && $n['email'] == get_site_option( 'admin_email' ) && $n['version'] == $core_update->current )
      		    $send = false;
    
      		update_site_option( 'auto_core_update_failed', array(
      		'attempted'  => $core_update->current,
      		'current'    => $wp_version,
      		'error_code' => $error_code,
      		'error_data' => $result->get_error_data(),
      		'timestamp'  => time(),
      		'retry'      => in_array( $error_code, $transient_failures ),
      		) );
    
      		if ( $send )
      		    $this->send_email( 'fail', $core_update, $result );
    }
    
    
    /**
     * Sends an email upon the completion or failure of a background core update.
     *
     * @since 3.7.0
     *
     * @param string $type        The type of email to send. Can be one of 'success', 'fail', 'manual', 'critical'.
     * @param object $core_update The update offer that was attempted.
     * @param mixed  $result      Optional. The result for the core update. Can be WP_Error.
     */
    protected function send_email( $type, $core_update, $result = null )
    {
        update_site_option( 'auto_core_update_notified', array(
        'type'      => $type,
        'email'     => get_site_option( 'admin_email' ),
        'version'   => $core_update->current,
        'timestamp' => time(),
        ) );
    
        $next_user_core_update = get_preferred_from_update_core();
        // If the update transient is empty, use the update we just performed
        if ( ! $next_user_core_update )
            $next_user_core_update = $core_update;
        $newer_version_available = ( 'upgrade' == $next_user_core_update->response && version_compare( $next_user_core_update->version, $core_update->version, '>' ) );
    
        /**
         * Filter whether to send an email following an automatic background core update.
         *
         * @since 3.7.0
         *
         * @param bool   $send        Whether to send the email. Default true.
         * @param string $type        The type of email to send. Can be one of
         *                            'success', 'fail', 'critical'.
         * @param object $core_update The update offer that was attempted.
         * @param mixed  $result      The result for the core update. Can be WP_Error.
        */
        if ( 'manual' !== $type && ! RC_Hook::apply_filters( 'auto_core_update_send_email', true, $type, $core_update, $result ) )
            return;
    
        switch ( $type ) {
            case 'success' : // We updated.
                /* translators: 1: Site name, 2: WordPress version number. */
                $subject = __( '[%1$s] Your site has updated to WordPress %2$s', 'ecjia');
                break;
    
            case 'fail' :   // We tried to update but couldn't.
            case 'manual' : // We can't update (and made no attempt).
                /* translators: 1: Site name, 2: WordPress version number. */
                $subject = __( '[%1$s] WordPress %2$s is available. Please update!', 'ecjia');
                break;
    
            case 'critical' : // We tried to update, started to copy files, then things went wrong.
                /* translators: 1: Site name. */
                $subject = __( '[%1$s] URGENT: Your site may be down due to a failed update', 'ecjia');
                break;
    
            default :
                return;
        }
    
        // If the auto update is not to the latest version, say that the current version of WP is available instead.
        $version = 'success' === $type ? $core_update->current : $next_user_core_update->current;
        $subject = sprintf( $subject, wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES ), $version );
    
        $body = '';
    
        switch ( $type ) {
            case 'success' :
                $body .= sprintf( __( 'Howdy! Your site at %1$s has been updated automatically to WordPress %2$s.', 'ecjia'), home_url(), $core_update->current );
                $body .= "\n\n";
                if ( ! $newer_version_available )
                    $body .= __( 'No further action is needed on your part.', 'ecjia') . ' ';
    
                // Can only reference the About screen if their update was successful.
                list( $about_version ) = explode( '-', $core_update->current, 2 );
                $body .= sprintf( __( "For more on version %s, see the About WordPress screen:", 'ecjia'), $about_version );
                $body .= "\n" . admin_url( 'about.php' );
    
                if ( $newer_version_available ) {
                    $body .= "\n\n" . sprintf( __( 'WordPress %s is also now available.', 'ecjia'), $next_user_core_update->current ) . ' ';
                    $body .= __( 'Updating is easy and only takes a few moments:', 'ecjia');
                    $body .= "\n" . network_admin_url( 'update-core.php' );
                }
    
                break;
    
            case 'fail' :
            case 'manual' :
                $body .= sprintf( __( 'Please update your site at %1$s to WordPress %2$s.', 'ecjia'), home_url(), $next_user_core_update->current );
    
                $body .= "\n\n";
    
                // Don't show this message if there is a newer version available.
                // Potential for confusion, and also not useful for them to know at this point.
                if ( 'fail' == $type && ! $newer_version_available )
                    $body .= __( 'We tried but were unable to update your site automatically.', 'ecjia') . ' ';
    
                $body .= __( 'Updating is easy and only takes a few moments:', 'ecjia');
                $body .= "\n" . network_admin_url( 'update-core.php' );
                break;
    
            case 'critical' :
                if ( $newer_version_available )
                    $body .= sprintf( __( 'Your site at %1$s experienced a critical failure while trying to update WordPress to version %2$s.', 'ecjia'), home_url(), $core_update->current );
                    else
                        $body .= sprintf( __( 'Your site at %1$s experienced a critical failure while trying to update to the latest version of WordPress, %2$s.', 'ecjia'), home_url(), $core_update->current );
    
                    $body .= "\n\n" . __( "This means your site may be offline or broken. Don't panic; this can be fixed.", 'ecjia');
    
                    $body .= "\n\n" . __( "Please check out your site now. It's possible that everything is working. If it says you need to update, you should do so:", 'ecjia');
                    $body .= "\n" . network_admin_url( 'update-core.php' );
                    break;
        }
    
        $critical_support = 'critical' === $type && ! empty( $core_update->support_email );
        if ( $critical_support ) {
            // Support offer if available.
            $body .= "\n\n" . sprintf( __( "The WordPress team is willing to help you. Forward this email to %s and the team will work with you to make sure your site is working.", 'ecjia'), $core_update->support_email );
        } else {
            // Add a note about the support forums.
            $body .= "\n\n" . __( 'If you experience any issues or need support, the volunteers in the WordPress.org support forums may be able to help.', 'ecjia');
            $body .= "\n" . __( 'https://wordpress.org/support/', 'ecjia');
        }
    
        // Updates are important!
        if ( $type != 'success' || $newer_version_available ) {
            $body .= "\n\n" . __( 'Keeping your site updated is important for security. It also makes the internet a safer place for you and your readers.', 'ecjia');
        }
    
        if ( $critical_support ) {
            $body .= " " . __( "If you reach out to us, we'll also ensure you'll never have this problem again.", 'ecjia');
        }
    
        // If things are successful and we're now on the latest, mention plugins and themes if any are out of date.
        if ( $type == 'success' && ! $newer_version_available && ( get_plugin_updates() || get_theme_updates() ) ) {
            $body .= "\n\n" . __( 'You also have some plugins or themes with updates available. Update them now:', 'ecjia');
            $body .= "\n" . network_admin_url();
        }
    
        $body .= "\n\n" . __( 'The WordPress Team', 'ecjia') . "\n";
    
        if ( 'critical' == $type && is_ecjia_error( $result ) ) {
            $body .= "\n***\n\n";
            $body .= sprintf( __( 'Your site was running version %s.', 'ecjia'), $GLOBALS['wp_version'] );
            $body .= ' ' . __( 'We have some data that describes the error your site encountered.', 'ecjia');
            $body .= ' ' . __( 'Your hosting company, support forum volunteers, or a friendly developer may be able to use this information to help you:', 'ecjia');
    
            // If we had a rollback and we're still critical, then the rollback failed too.
            // Loop through all errors (the main WP_Error, the update result, the rollback result) for code, data, etc.
            if ( 'rollback_was_required' == $result->get_error_code() )
                $errors = array( $result, $result->get_error_data()->update, $result->get_error_data()->rollback );
            else
                $errors = array( $result );
    
            foreach ( $errors as $error ) {
                if ( ! is_ecjia_error( $error ) ) {
                    continue;
                }
                $error_code = $error->get_error_code();
                $body .= "\n\n" . sprintf( __( "Error code: %s", 'ecjia'), $error_code );
                if ( 'rollback_was_required' == $error_code ) {
                    continue;
                }
                if ( $error->get_error_message() ) {
                    $body .= "\n" . $error->get_error_message();
                }
                $error_data = $error->get_error_data();
                if ( $error_data ) {
                    $body .= "\n" . implode( ', ', (array) $error_data );
                }
            }
            $body .= "\n";
        }
    
        $to  = get_site_option( 'admin_email' );
        $headers = '';
    
        $email = compact( 'to', 'subject', 'body', 'headers' );
    
        /**
         * Filter the email sent following an automatic background core update.
         *
         * @since 3.7.0
         *
         * @param array $email {
         *     Array of email arguments that will be passed to wp_mail().
         *
         *     @type string $to      The email recipient. An array of emails
         *                            can be returned, as handled by wp_mail().
         *     @type string $subject The email's subject.
         *     @type string $body    The email message body.
         *     @type string $headers Any email headers, defaults to no headers.
         * }
         * @param string $type        The type of email being sent. Can be one of
         *                            'success', 'fail', 'manual', 'critical'.
         * @param object $core_update The update offer that was attempted.
         * @param mixed  $result      The result for the core update. Can be WP_Error.
        */
        $email = RC_Hook::apply_filters( 'auto_core_update_email', $email, $type, $core_update, $result );
    
        wp_mail( $email['to'], wp_specialchars_decode( $email['subject'] ), $email['body'], $email['headers'] );
    }
    
    /**
     * Prepares and sends an email of a full log of background update results, useful for debugging and geekery.
     *
     * @since 3.7.0
     */
    protected function send_debug_email()
    {
        $update_count = 0;
        foreach ( $this->update_results as $type => $updates )
            $update_count += count( $updates );
    
        $body = array();
        $failures = 0;
    
        $body[] = sprintf( __( 'WordPress site: %s', 'ecjia'), network_home_url( '/' ) );
    
        // Core
        if ( isset( $this->update_results['core'] ) ) {
            $result = $this->update_results['core'][0];
            if ( $result->result && ! is_ecjia_error( $result->result ) ) {
                $body[] = sprintf( __( 'SUCCESS: WordPress was successfully updated to %s', 'ecjia'), $result->name );
            } else {
                $body[] = sprintf( __( 'FAILED: WordPress failed to update to %s', 'ecjia'), $result->name );
                $failures++;
            }
            $body[] = '';
        }
    
        // Plugins, Themes, Translations
        foreach ( array( 'plugin', 'theme', 'translation' ) as $type ) {
            if ( ! isset( $this->update_results[ $type ] ) )
                continue;
            $success_items = wp_list_filter( $this->update_results[ $type ], array( 'result' => true ) );
            if ( $success_items ) {
                $messages = array(
                    'plugin'      => __( 'The following plugins were successfully updated:', 'ecjia'),
                    'theme'       => __( 'The following themes were successfully updated:', 'ecjia'),
                    'translation' => __( 'The following translations were successfully updated:', 'ecjia'),
                );
    
                $body[] = $messages[ $type ];
                foreach ( wp_list_pluck( $success_items, 'name' ) as $name ) {
                    $body[] = ' * ' . sprintf( __( 'SUCCESS: %s', 'ecjia'), $name );
                }
            }
            if ( $success_items != $this->update_results[ $type ] ) {
                // Failed updates
                $messages = array(
                    'plugin'      => __( 'The following plugins failed to update:', 'ecjia'),
                    'theme'       => __( 'The following themes failed to update:', 'ecjia'),
                    'translation' => __( 'The following translations failed to update:', 'ecjia'),
                );
    
                $body[] = $messages[ $type ];
                foreach ( $this->update_results[ $type ] as $item ) {
                    if ( ! $item->result || is_ecjia_error( $item->result ) ) {
                        $body[] = ' * ' . sprintf( __( 'FAILED: %s', 'ecjia'), $item->name );
                        $failures++;
                    }
                }
            }
            $body[] = '';
        }
    
        $site_title = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );
        if ( $failures ) {
            $body[] = __( "
BETA TESTING?
=============
    
This debugging email is sent when you are using a development version of WordPress.
    
If you think these failures might be due to a bug in WordPress, could you report it?
 * Open a thread in the support forums: https://wordpress.org/support/forum/alphabeta
 * Or, if you're comfortable writing a bug report: http://core.trac.wordpress.org/
    
Thanks! -- The WordPress Team", 'ecjia');
    
            $subject = sprintf( __( '[%s] There were failures during background updates', 'ecjia'), $site_title );
        } else {
            $subject = sprintf( __( '[%s] Background updates have finished', 'ecjia'), $site_title );
        }
    
        $title = __( 'UPDATE LOG', 'ecjia');
        $body[] = $title;
        $body[] = str_repeat( '=', strlen( $title ) );
        $body[] = '';
    
        foreach ( array( 'core', 'plugin', 'theme', 'translation' ) as $type ) {
            if ( ! isset( $this->update_results[ $type ] ) )
                continue;
            foreach ( $this->update_results[ $type ] as $update ) {
                $body[] = $update->name;
                $body[] = str_repeat( '-', strlen( $update->name ) );
                foreach ( $update->messages as $message )
                    $body[] = "  " . html_entity_decode( str_replace( '&#8230;', '...', $message ) );
                if ( is_ecjia_error( $update->result ) ) {
                    $results = array( 'update' => $update->result );
                    // If we rolled back, we want to know an error that occurred then too.
                    if ( 'rollback_was_required' === $update->result->get_error_code() )
                        $results = (array) $update->result->get_error_data();
                    foreach ( $results as $result_type => $result ) {
                        if ( ! is_ecjia_error( $result ) )
                            continue;
    
                        if ( 'rollback' === $result_type ) {
                            /* translators: 1: Error code, 2: Error message. */
                            $body[] = '  ' . sprintf( __( 'Rollback Error: [%1$s] %2$s', 'ecjia'), $result->get_error_code(), $result->get_error_message() );
                        } else {
                            /* translators: 1: Error code, 2: Error message. */
                            $body[] = '  ' . sprintf( __( 'Error: [%1$s] %2$s', 'ecjia'), $result->get_error_code(), $result->get_error_message() );
                        }
    
                        if ( $result->get_error_data() )
                            $body[] = '         ' . implode( ', ', (array) $result->get_error_data() );
                    }
                }
                $body[] = '';
            }
        }
    
        $email = array(
            'to'      => get_site_option( 'admin_email' ),
            'subject' => $subject,
            'body'    => implode( "\n", $body ),
            'headers' => ''
        );
    
        /**
         * Filter the debug email that can be sent following an automatic
         * background core update.
         *
         * @since 3.8.0
         *
         * @param array $email {
         *     Array of email arguments that will be passed to wp_mail().
         *
         *     @type string $to      The email recipient. An array of emails
         *                           can be returned, as handled by wp_mail().
         *     @type string $subject Email subject.
         *     @type string $body    Email message body.
         *     @type string $headers Any email headers. Default empty.
         * }
         * @param int   $failures The number of failures encountered while upgrading.
         * @param mixed $results  The results of all attempted updates.
        */
        $email = RC_Hook::apply_filters( 'automatic_updates_debug_email', $email, $failures, $this->update_results );
    
        wp_mail( $email['to'], wp_specialchars_decode( $email['subject'] ), $email['body'], $email['headers'] );
    }
    
}

// end