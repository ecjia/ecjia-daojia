<?php
namespace Ecjia\Component\Upgrade\Skin;

use Ecjia\Component\Upgrade\UpgraderSkin;
use RC_Format;
use RC_Hook;

/**
 * Theme Upgrader Skin for ECJia Theme Upgrades.
 *
 * @package ECJia
 * @subpackage Upgrader
 * @since 2.8.0
 */
class ThemeUpgraderSkin extends UpgraderSkin
{
    
    protected $theme = '';
    
    public function __construct($args = array())
    {
        $defaults = array(
            'url' => '',
            'theme' => '',
            'nonce' => '',
            'title' => __('Update Theme', 'ecjia')
        );
        $args = rc_parse_args($args, $defaults);
    
        $this->theme = $args['theme'];
    
        parent::__construct($args);
    }
    
    public function after()
    {
        $this->decrement_update_count( 'theme' );
    
        $update_actions = array();
        if ( ! empty( $this->upgrader->result['destination_name'] ) && $theme_info = $this->upgrader->theme_info() ) {
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
    
            if ( get_stylesheet() == $stylesheet ) {
                if ( current_user_can( 'edit_theme_options' ) )
                    $update_actions['preview']  = '<a href="' . wp_customize_url( $stylesheet ) . '" class="hide-if-no-customize load-customize" title="' . esc_attr( sprintf( __('Customize &#8220;%s&#8221;', 'ecjia'), $name ) ) . '">' . __('Customize', 'ecjia') . '</a>';
            } elseif ( current_user_can( 'switch_themes' ) ) {
                $update_actions['preview']  = '<a href="' . RC_Format::esc_url( $preview_link ) . '" class="hide-if-customize" title="' . esc_attr( sprintf( __('Preview &#8220;%s&#8221;', 'ecjia'), $name ) ) . '">' . __('Preview', 'ecjia') . '</a>';
                $update_actions['preview'] .= '<a href="' . wp_customize_url( $stylesheet ) . '" class="hide-if-no-customize load-customize" title="' . esc_attr( sprintf( __('Preview &#8220;%s&#8221;', 'ecjia'), $name ) ) . '">' . __('Live Preview', 'ecjia') . '</a>';
                $update_actions['activate'] = '<a href="' . RC_Format::esc_url( $activate_link ) . '" class="activatelink" title="' . esc_attr( sprintf( __('Activate &#8220;%s&#8221;', 'ecjia'), $name ) ) . '">' . __('Activate', 'ecjia') . '</a>';
            }
    
            if ( ! $this->result || is_ecjia_error( $this->result ) || is_network_admin() )
                unset( $update_actions['preview'], $update_actions['activate'] );
        }
    
        $update_actions['themes_page'] = '<a href="' . self_admin_url('themes.php') . '" title="' . esc_attr__('Return to Themes page') . '" target="_parent">' . __('Return to Themes page', 'ecjia') . '</a>';
    
        /**
         * Filter the list of action links available following a single theme update.
         *
         * @since 2.8.0
         *
         * @param array  $update_actions Array of theme action links.
         * @param string $theme          Theme directory name.
         */
        $update_actions = RC_Hook::apply_filters( 'update_theme_complete_actions', $update_actions, $this->theme );
    
        if ( ! empty($update_actions) )
        {
            $this->feedback(implode(' | ', (array)$update_actions));
        }
    }
    
}

// end