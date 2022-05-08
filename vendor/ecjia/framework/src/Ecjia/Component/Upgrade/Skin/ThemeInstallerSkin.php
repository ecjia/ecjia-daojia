<?php
namespace Ecjia\Component\Upgrade\Skin;

use Ecjia\Component\Upgrade\UpgraderSkin;
use RC_Format;
use RC_Hook;

/**
 * Theme Installer Skin for the ECJia Theme Installer.
 *
 * @package ECJia
 * @subpackage Upgrader
 * @since 2.8.0
 */
class ThemeInstallerSkin extends UpgraderSkin
{
    protected $api;
    protected $type;
    
    public function __construct($args = array())
    {
        $defaults = array( 'type' => 'web', 'url' => '', 'theme' => '', 'nonce' => '', 'title' => '' );
        $args = rc_parse_args($args, $defaults);
    
        $this->type = $args['type'];
        $this->api = isset($args['api']) ? $args['api'] : array();
    
        parent::__construct($args);
    }
    
    public function before()
    {
        if ( !empty($this->api) ) {
            $this->upgrader->strings['process_success'] = sprintf( $this->upgrader->strings['process_success_specific'], $this->api->name, $this->api->version);
        }
    }
    
    public function after()
    {
        if ( empty($this->upgrader->result['destination_name']) ) {
            return;
        }
    
        $theme_info = $this->upgrader->theme_info();
        if ( empty( $theme_info ) ) {
            return;
        }
    
        $name       = $theme_info->display('Name');
        $stylesheet = $this->upgrader->result['destination_name'];
        $template   = $theme_info->get_template();
    
        $preview_link = \RC_Uri::add_query_arg( array(
            'preview'    => 1,
            'template'   => urlencode( $template ),
            'stylesheet' => urlencode( $stylesheet ),
        ), trailingslashit( home_url() ) );
    
        $activate_link = \RC_Uri::add_query_arg( array(
            'action'     => 'activate',
            'template'   => urlencode( $template ),
            'stylesheet' => urlencode( $stylesheet ),
        ), admin_url('themes.php') );
        $activate_link = wp_nonce_url( $activate_link, 'switch-theme_' . $stylesheet );
    
        $install_actions = array();
        $install_actions['preview']  = '<a href="' . RC_Format::esc_url( $preview_link ) . '" class="hide-if-customize" title="' . esc_attr( sprintf( __('Preview &#8220;%s&#8221;', 'ecjia'), $name ) ) . '">' . __('Preview', 'ecjia') . '</a>';
        $install_actions['preview'] .= '<a href="' . wp_customize_url( $stylesheet ) . '" class="hide-if-no-customize load-customize" title="' . esc_attr( sprintf( __('Preview &#8220;%s&#8221;', 'ecjia'), $name ) ) . '">' . __('Live Preview', 'ecjia') . '</a>';
        $install_actions['activate'] = '<a href="' . RC_Format::esc_url( $activate_link ) . '" class="activatelink" title="' . esc_attr( sprintf( __('Activate &#8220;%s&#8221;', 'ecjia'), $name ) ) . '">' . __('Activate', 'ecjia') . '</a>';
    
        if ( is_network_admin() && current_user_can( 'manage_network_themes' ) )
            $install_actions['network_enable'] = '<a href="' . esc_url( wp_nonce_url( 'themes.php?action=enable&amp;theme=' . urlencode( $stylesheet ), 'enable-theme_' . $stylesheet ) ) . '" title="' . esc_attr__( 'Enable this theme for all sites in this network' ) . '" target="_parent">' . __( 'Network Enable' , 'ecjia') . '</a>';
    
        if ( $this->type == 'web' )
            $install_actions['themes_page'] = '<a href="' . self_admin_url('theme-install.php') . '" title="' . esc_attr__('Return to Theme Installer') . '" target="_parent">' . __('Return to Theme Installer', 'ecjia') . '</a>';
        elseif ( current_user_can( 'switch_themes' ) || current_user_can( 'edit_theme_options' ) )
        $install_actions['themes_page'] = '<a href="' . self_admin_url('themes.php') . '" title="' . esc_attr__('Themes page') . '" target="_parent">' . __('Return to Themes page', 'ecjia') . '</a>';
    
        if ( ! $this->result || is_ecjia_error($this->result) || is_network_admin() || ! current_user_can( 'switch_themes' ) ) {
            unset( $install_actions['activate'], $install_actions['preview'] );
        }
        
        /**
         * Filter the list of action links available following a single theme installation.
         *
         * @since 2.8.0
         *
         * @param array    $install_actions Array of theme action links.
         * @param object   $api             Object containing WordPress.org API theme data.
         * @param string   $stylesheet      Theme directory name.
         * @param WP_Theme $theme_info      Theme object.
        */
        $install_actions = RC_Hook::apply_filters( 'install_theme_complete_actions', $install_actions, $this->api, $stylesheet, $theme_info );
        if ( ! empty($install_actions) ) {
            $this->feedback(implode(' | ', (array)$install_actions));
        }
    }
}

// end