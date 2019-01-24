<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/20
 * Time: 09:49
 */

namespace Ecjia\App\Theme\ThemeFramework\Foundation;

use Ecjia\App\Theme\ThemeFramework\ThemeFrameworkAbstract;
use RC_Hook;

/**
 *
 * Metabox Class
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class Metabox extends ThemeFrameworkAbstract
{

    /**
     *
     * metabox options
     * @access public
     * @var array
     *
     */
    public $options = array();

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
     * @return class|Metabox
     */
    public static function instance( $options = array() )
    {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self( $options );
        }
        return self::$instance;
    }

    // run metabox construct
    public function __construct( $options )
    {
        parent::__construct();

        $this->options = RC_Hook::apply_filters( 'cs_metabox_options', $options );

        if( ! empty( $this->options ) ) {
            $this->addAction( 'add_meta_boxes', 'add_meta_box' );
            $this->addAction( 'save_post', 'save_post', 10, 2 );
        }

    }

    // add metabox
    public function add_meta_box( $post_type )
    {

        foreach ( $this->options as $value ) {
            add_meta_box( $value['id'], $value['title'], array( &$this, 'render_meta_box_content' ), $value['post_type'], $value['context'], $value['priority'], $value );
        }

    }

    // metabox render content
    public function render_meta_box_content( $post, $callback )
    {

        global $post, $cs_errors;

        wp_nonce_field( 'cs-framework-metabox', 'cs-framework-metabox-nonce' );

        $unique       = $callback['args']['id'];
        $sections     = $callback['args']['sections'];
        $meta_value   = get_post_meta( $post->ID, $unique, true );
        $transient    = get_transient( 'cs-metabox-transient' );
        $cs_errors    = $transient['errors'];
        $has_nav      = ( count( $sections ) >= 2 && $callback['args']['context'] != 'side' ) ? true : false;
        $show_all     = ( ! $has_nav ) ? ' cs-show-all' : '';
        $section_name = ( ! empty( $sections[0]['fields'] ) ) ? $sections[0]['name'] : $sections[1]['name'];
        $section_id   = ( ! empty( $transient['ids'][$unique] ) ) ? $transient['ids'][$unique] : $section_name;
        $section_id   = cs_get_var( 'cs-section', $section_id );

        echo '<div class="cs-framework cs-metabox-framework">';

        echo '<input type="hidden" name="cs_section_id['. $unique .']" class="cs-reset" value="'. $section_id .'">';

        echo '<div class="cs-body'. $show_all .'">';

        if( $has_nav ) {

            echo '<div class="cs-nav">';

            echo '<ul>';
            foreach( $sections as $value ) {

                $tab_icon = ( ! empty( $value['icon'] ) ) ? '<i class="cs-icon '. $value['icon'] .'"></i>' : '';

                if( isset( $value['fields'] ) ) {
                    $active_section = ( $section_id == $value['name'] ) ? ' class="cs-section-active"' : '';
                    echo '<li><a href="#"'. $active_section .' data-section="'. $value['name'] .'">'. $tab_icon . $value['title'] .'</a></li>';
                } else {
                    echo '<li><div class="cs-seperator">'. $tab_icon . $value['title'] .'</div></li>';
                }

            }
            echo '</ul>';

            echo '</div>';

        }

        echo '<div class="cs-content">';

        echo '<div class="cs-sections">';

        foreach( $sections as $val ) {

            if ( isset( $val['fields'] ) ) {

                $active_content = ( $section_id == $val['name'] ) ? ' style="display: block;"' : '';

                echo '<div id="cs-tab-'. $val['name'] .'" class="cs-section"'. $active_content .'>';
                echo ( isset( $val['title'] ) ) ? '<div class="cs-section-title"><h3>'. $val['title'] .'</h3></div>' : '';

                foreach ( $val['fields'] as $field_key => $field ) {

                    $default    = ( isset( $field['default'] ) ) ? $field['default'] : '';
                    $elem_id    = ( isset( $field['id'] ) ) ? $field['id'] : '';
                    $elem_value = ( is_array( $meta_value ) && isset( $meta_value[$elem_id] ) ) ? $meta_value[$elem_id] : $default;
                    echo cs_add_element( $field, $elem_value, $unique );

                }
                echo '</div>';

            }
        }
        echo '</div>';

        echo '<div class="clear"></div>';

        echo '</div>';

        echo ( $has_nav ) ? '<div class="cs-nav-background"></div>' : '';

        echo '<div class="clear"></div>';

        echo '</div>';

        echo '</div>';

    }

    // save metabox options
    public function save_post( $post_id, $post )
    {

        if ( wp_verify_nonce( cs_get_var( 'cs-framework-metabox-nonce' ), 'cs-framework-metabox' ) ) {

            $errors = array();
            $post_type = cs_get_var( 'post_type' );

            foreach ( $this->options as $request_value ) {

                if ( in_array( $post_type, (array) $request_value['post_type'] ) ) {

                    $request_key = $request_value['id'];
                    $request = cs_get_var( $request_key, array() );

                    // ignore _nonce
                    if( isset( $request['_nonce'] ) ) {
                        unset( $request['_nonce'] );
                    }

                    foreach ( $request_value['sections'] as $key => $section ) {

                        if ( isset( $section['fields'] ) ) {

                            foreach ( $section['fields'] as $field ) {

                                if ( isset( $field['type'] ) && isset( $field['id'] ) ) {

                                    $field_value = cs_get_vars( $request_key, $field['id'] );

                                    // sanitize options
                                    if ( isset( $field['sanitize'] ) && $field['sanitize'] !== false ) {
                                        $sanitize_type = $field['sanitize'];
                                    } else if ( ! isset( $field['sanitize'] ) ) {
                                        $sanitize_type = $field['type'];
                                    }

                                    if ( has_filter( 'cs_sanitize_'. $sanitize_type ) ) {
                                        $request[$field['id']] = apply_filters( 'cs_sanitize_' . $sanitize_type, $field_value, $field, $section['fields'] );
                                    }

                                    // validate options
                                    if ( isset( $field['validate'] ) && has_filter( 'cs_validate_'. $field['validate'] ) ) {

                                        $validate = apply_filters( 'cs_validate_' . $field['validate'], $field_value, $field, $section['fields'] );

                                        if ( ! empty( $validate ) ) {

                                            $meta_value = get_post_meta( $post_id, $request_key, true );

                                            $errors[$field['id']] = array( 'code' => $field['id'], 'message' => $validate, 'type' => 'error' );
                                            $default_value = isset( $field['default'] ) ? $field['default'] : '';
                                            $request[$field['id']] = ( isset( $meta_value[$field['id']] ) ) ? $meta_value[$field['id']] : $default_value;

                                        }

                                    }

                                }

                            }

                        }

                    }

                    $request = RC_Hook::apply_filters( 'cs_save_post', $request, $request_key, $post );

                    if ( empty( $request ) ) {

                        delete_post_meta( $post_id, $request_key );

                    } else {

                        if ( get_post_meta( $post_id, $request_key ) ) {

                            update_post_meta( $post_id, $request_key, $request );

                        } else {

                            add_post_meta( $post_id, $request_key, $request );

                        }

                    }

                    $transient['ids'][$request_key] = cs_get_vars( 'cs_section_id', $request_key );
                    $transient['errors'] = $errors;

                }

            }

            set_transient( 'cs-metabox-transient', $transient, 10 );

        }

    }


}