<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/20
 * Time: 09:47
 */

namespace Ecjia\App\Theme\ThemeFramework\Foundation;

use Ecjia\App\Theme\ThemeFramework\ThemeFrameworkAbstract;
use RC_Hook;

/**
 *
 * Customize Class
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class Customize extends ThemeFrameworkAbstract
{

    /**
     *
     * sections
     * @access public
     * @var array
     *
     */
    public $options = array();

    /**
     *
     * panel priority
     * @access public
     * @var bool
     *
     */
    public $priority = 1;

    /**
     *
     * instance
     * @access private
     * @var class
     *
     */
    private static $instance = null;

    /**
     * instance
     * @param array $options
     * @return class|Customize
     */
    public static function instance( $options = array() )
    {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self( $options );
        }
        return self::$instance;
    }


    // run custom construct
    public function __construct( $options )
    {
        parent::__construct();

        $this->options = RC_Hook::apply_filters( 'cs_customize_options', $options );

        if( ! empty( $this->options ) ) {
            $this->addAction( 'customize_register', 'customize_register' );
        }

    }


    // custom register
    public function customize_register( $wp_customize )
    {

        // load extra WP_Customize_Control
        cs_locate_template( 'functions/custom.php' );
        RC_Hook::do_action( 'cs_customize_register' );

        $panel_priority = 1;

        foreach ( $this->options as $value ) {

            $this->priority = $panel_priority;

            if ( isset( $value['sections'] ) ) {

                $wp_customize->add_panel( $value['name'], array(
                    'title'       => $value['title'],
                    'priority'    => ( isset( $value['priority'] ) ) ? $value['priority'] : $panel_priority,
                    'description' => ( isset( $value['description'] ) ) ? $value['description'] : '',
                ));

                $this->add_section( $wp_customize, $value, $value['name'] );

            } else {

                $this->add_section( $wp_customize, $value );

            }

            $panel_priority++;

        }

    }

    // add custom section
    public function add_section( $wp_customize, $value, $panel = false )
    {

        $section_priority = ( $panel ) ? 1 : $this->priority;
        $sections         = ( $panel ) ? $value['sections'] : array( 'sections' => $value );

        foreach ( $sections as $section ) {

            // add_section
            $wp_customize->add_section( $section['name'], array(
                'title'       => $section['title'],
                'priority'    => ( isset( $section['priority'] ) ) ? $section['priority'] : $section_priority,
                'description' => ( isset( $section['description'] ) ) ? $section['description'] : '',
                'panel'       => ( $panel ) ? $panel : '',
            ) );

            $setting_priority = 1;

            foreach ( $section['settings'] as $setting ) {

                $setting_name = CS_CUSTOMIZE . '[' . $setting['name'] .']';

                // add_setting
                $wp_customize->add_setting( $setting_name,
                    wp_parse_args( $setting, array(
                            'type'              => 'option',
                            'capability'        => 'edit_theme_options',
                            'sanitize_callback' => 'cs_sanitize_clean',
                        )
                    )
                );

                // add_control
                $control_args = wp_parse_args( $setting['control'], array(
                    'unique'    => CS_CUSTOMIZE,
                    'section'   => $section['name'],
                    'settings'  => $setting_name,
                    'priority'  => $setting_priority,
                ));

                if( $control_args['type'] == 'cs_field' ) {

                    $call_class = 'WP_Customize_'. $control_args['type'] .'_Control';
                    $wp_customize->add_control( new $call_class( $wp_customize, $setting['name'], $control_args ) );

                } else {

                    $wp_controls = array( 'color', 'upload', 'image', 'media' );
                    $call_class  = 'WP_Customize_'. ucfirst( $control_args['type'] ) .'_Control';

                    if( in_array( $control_args['type'], $wp_controls ) && class_exists( $call_class ) ) {
                        $wp_customize->add_control( new $call_class( $wp_customize, $setting['name'], $control_args ) );
                    } else {
                        $wp_customize->add_control( $setting['name'], $control_args );
                    }

                }

                $setting_priority++;
            }

            $section_priority++;

        }

    }

}