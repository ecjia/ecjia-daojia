<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/20
 * Time: 09:41
 */

namespace Ecjia\App\Theme\ThemeFramework\Foundation;

use Ecjia\App\Theme\ThemeFramework\Support\Helpers;
use Ecjia\App\Theme\ThemeFramework\ThemeConstant;
use Ecjia\App\Theme\ThemeFramework\ThemeFrameworkAbstract;
use RC_Hook;
use RC_Uri;
use RC_Style;
use RC_Script;
use ecjia_theme_option;
use ecjia_theme_setting;
use ecjia_theme_transient;

/**
 *
 * Framework Class
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class AdminPanel extends ThemeFrameworkAbstract
{

    /**
     *
     * option database/data name
     * @access public
     * @var string
     *
     */
    public $unique = ThemeConstant::CS_OPTION;

    /**
     *
     * settings
     * @access public
     * @var array
     *
     */
    public $settings = array();

    /**
     *
     * options tab
     * @access public
     * @var array
     *
     */
    public $options = array();

    /**
     *
     * options section
     * @access public
     * @var array
     *
     */
    public $sections = array();

    /**
     *
     * options store
     * @access public
     * @var array
*
*/
    public $theme_options = array();

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
     * @param array $settings
     * @param array $options
     * @return AdminPanel|class
     */
    public static function instance($settings = array(), $options = array() )
    {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self($settings, $options );
        }
        return self::$instance;
    }


    // run framework construct
    public function __construct($settings, $options )
    {
        parent::__construct();

        $this->settings = RC_Hook::apply_filters( 'cs_framework_settings', $settings );
        $this->options  = RC_Hook::apply_filters( 'cs_framework_options', $options );


        if( ! empty( $this->options ) ) {

            $this->sections   = $this->getSections();
            $this->theme_options = ecjia_theme_option::load_alloptions();

            $this->addAction('admin_theme_option_nav', 'display_setting_menus');
            $this->addAction('admin_theme_option_page', 'display_theme_option_page');
            $this->addAction('admin_enqueue_scripts', 'admin_enqueue_scripts');
            $this->addFilter('template_option_default_section', 'template_option_default_section');
        }

        $this->admin_enqueue_scripts();
    }

    /**
     * 获取默认的分组名称
     * @return mixed
     */
    public function template_option_default_section()
    {
        return collect($this->sections)->keys()->first();
    }


    /**
     * get sections
     *
     * @return array
     */
    public function getSections()
    {

        $sections = array();

        foreach ( $this->options as $key => $value ) {

            if ( isset( $value['sections'] ) ) {

                foreach ( $value['sections'] as $section ) {

                    if ( isset( $section['fields'] ) ) {
                        $sections[$section['name']] = $section;
                    }

                }

            } else {

                if ( isset( $value['fields'] ) ) {
                    $sections[$value['name']] = $value;
                }

            }

        }

        return $sections;
    }

    /**
     * 获取某个section下的字段信息
     *
     * @param $name
     * @return mixed
     */
    public function getSection($name)
    {
        return array_get($this->sections, $name, []);
    }

    /**
     * 渲染主题选项菜单
     *
     * @param $name
     */
    public function display_setting_menus($name)
    {
        echo '<div class="setting-group">'.PHP_EOL;
        echo '<span class="setting-group-title"><i class="fontello-icon-cog"></i>'.$this->settings['menu_title'].'</span>'.PHP_EOL;
        echo '<ul class="nav nav-list m_t10">'.PHP_EOL;

        foreach ($this->sections as $section) {
            echo '<li><a class="data-pjax setting-group-item'; //data-pjax

            if ($name == $section['name']) {
                echo ' llv-active';
            }

            $url = RC_Uri::url('theme/admin_option/init', ['section' => $section['name']]);
            echo '" href="'.$url.'">' . $section['title'] . '</a></li>'.PHP_EOL;
        }


        echo '</ul>'.PHP_EOL;
        echo '</div>'.PHP_EOL;
    }

    /**
     * 渲染主题选项配置页面
     *
     * @param $name
     */
    public function display_theme_option_page($name)
    {
        $section = $this->getSection($name);

        $this->setSettingsFields($section);

        $form_action = RC_Uri::url('theme/admin_option/update', ['section' => $name]);

        echo '<form method="post" class="form-horizontal" action="' . $form_action . '" name="theForm" >'.PHP_EOL;

        echo '<fieldset>'.PHP_EOL;

            echo '<div>'.PHP_EOL;
                echo '<h3 class="heading">';
                echo $section['title'];
                echo '</h3>'.PHP_EOL;
            echo '</div>'.PHP_EOL;

            $this->displaySettingsPageSection($section);

            echo '<div class="control-group">'.PHP_EOL;
                echo '<div class="controls">'.PHP_EOL;
                    echo '<input type="submit" value="确定" class="btn btn-gebo" />'.PHP_EOL;
                echo '</div>'.PHP_EOL;
            echo '</div>'.PHP_EOL;

        echo '</fieldset>'.PHP_EOL;

        echo '</form>'.PHP_EOL;

    }


    protected function staticsPath($path)
    {
        return $this->getFramework()->getStaticsUrl() . $path;
    }

    /**
     *
     * Framework admin enqueue style and scripts
     *
     * @since 1.0.0
     * @version 1.0.0
     *
     */
    public function admin_enqueue_scripts()
    {
        $route = royalcms('default-router');
        if (! $route->justCurrentRoute('theme/admin_option/init')) {
            return ;
        }

        // framework core styles
        RC_Style::enqueue_style( 'cs-framework', $this->staticsPath('/theme-framework/css/cs-framework.css'), array(), '1.0.0', 'all' );
        RC_Style::enqueue_style( 'font-awesome', $this->staticsPath('/theme-framework/css/font-awesome.css'), array(), '4.2.0', 'all' );

        if ( is_rtl() ) {
            RC_Style::enqueue_style( 'cs-framework-rtl', $this->staticsPath('/theme-framework/css/cs-framework-rtl.css'), array(), '1.0.0', 'all' );
        }

        // framework core scripts
        RC_Script::enqueue_script( 'cs-plugins',    $this->staticsPath('/theme-framework/js/cs-plugins.js'),    array(), '1.0.0', true );
        RC_Script::enqueue_script( 'cs-framework',  $this->staticsPath('/theme-framework/js/cs-framework.js'),  array( 'cs-plugins' ), '1.0.0', true );

        RC_Script::enqueue_script( 'bootstrap-colorpicker' );

        RC_Script::enqueue_script('jquery-ui-dialog');
        RC_Script::enqueue_script('jquery-ui-sortable');
        RC_Script::enqueue_script('jquery-ui-accordion');
    }


    protected function displaySettingsPageSection(array $section)
    {
        $page = $section['name'] .'_section_group';

        echo '<div class="cs-content">';

        echo '<div class="cs-sections">';

        if ( isset( $section['fields'] ) ) {

            echo '<div id="cs-tab-'. $section['name'] .'" class="cs-section">';
            echo ( isset( $section['title'] ) && empty( $has_nav ) ) ? '<div class="cs-section-title"><h3>'. $section['title'] .'</h3></div>' : '';
            $this->do_settings_section($page, $section);
            echo '</div>';

        }

        echo '</div>'; // end .cs-sections

        echo '<div class="clear"></div>';

        echo '</div>'; // end .cs-content

    }

    /**
     * settings api
     */
    protected function setSettingsFields(array $section)
    {

        $defaults = array();

        ecjia_theme_setting::register_setting( $this->unique .'_group', $this->unique, array( &$this, 'validate_save' ) );

        if ( isset( $section['fields'] ) ) {

            ecjia_theme_setting::add_settings_section( $section['name'] .'_section', $section['title'], '', $section['name'] .'_section_group' );

            foreach ( $section['fields'] as $field_key => $field ) {

                ecjia_theme_setting::add_settings_field( $field_key .'_field', '', array( &$this, 'fieldCallback' ), $section['name'] .'_section_group', $section['name'] .'_section', $field );

                // set default option if isset
                if ( isset( $field['default'] ) ) {
                    $defaults[$field['id']] = $field['default'];
                    if ( ! empty( $this->theme_options ) && ! isset( $this->theme_options[$field['id']] ) ) {
                        $this->theme_options[$field['id']] = $field['default'];
                    }
                }

            }
        }

        // set default variable if empty options and not empty defaults
        if( empty( $this->theme_options )  && ! empty( $defaults ) ) {
            $this->theme_options = $defaults;
        }

    }

    /**
     * section fields validate in save
     * @return null|array
     */
    public function validate_save( $request )
    {
        $add_errors = array();
        $section_id = Helpers::cs_get_var( 'cs_section_id' );

        // ignore nonce requests
        if ( isset( $request['_nonce'] ) ) {
            unset( $request['_nonce'] );
        }

        // import
        if ( isset( $request['import'] ) && ! empty( $request['import'] ) ) {
            $decode_string = Helpers::cs_decode_string( $request['import'] );
            if ( is_array( $decode_string ) ) {
                return $decode_string;
            }
            $add_errors[] = $this->add_settings_error( __( 'Success. Imported backup options.', 'cs-framework' ), 'updated' );
        }

        // reset all options
        if ( isset( $request['resetall'] ) ) {
            $add_errors[] = $this->add_settings_error( __( 'Default options restored.', 'cs-framework' ), 'updated' );
            return null;
        }

        // reset only section
        if ( isset( $request['reset'] ) && ! empty( $section_id ) ) {
            foreach ( $this->sections as $value ) {
                if ( $value['name'] == $section_id ) {
                    foreach ( $value['fields'] as $field ) {
                        if ( isset( $field['id'] ) ) {
                            if ( isset( $field['default'] ) ) {
                                $request[$field['id']] = $field['default'];
                            } else {
                                unset( $request[$field['id']] );
                            }
                        }
                    }
                }
            }
            $add_errors[] = $this->add_settings_error( __( 'Default options restored for only this section.', 'cs-framework' ), 'updated' );
        }

        // option sanitize and validate
        foreach ( $this->sections as $section ) {
            if ( isset( $section['fields'] ) ) {
                foreach( $section['fields'] as $field ) {

                    // ignore santize and validate if element multilangual
                    if ( isset( $field['type'] ) && ! isset( $field['multilang'] ) && isset( $field['id'] ) ) {

                        // sanitize options
                        $request_value = isset( $request[$field['id']] ) ? $request[$field['id']] : '';
                        $sanitize_type = $field['type'];

                        if ( isset( $field['sanitize'] ) ) {
                            $sanitize_type = ( $field['sanitize'] !== false ) ? $field['sanitize'] : false;
                        }

                        if ( $sanitize_type !== false && RC_Hook::has_filter( 'cs_sanitize_'. $sanitize_type ) ) {
                            $request[$field['id']] = RC_Hook::apply_filters( 'cs_sanitize_' . $sanitize_type, $request_value, $field, $section['fields'] );
                        }

                        // validate options
                        if ( isset( $field['validate'] ) && RC_Hook::has_filter( 'cs_validate_'. $field['validate'] ) ) {

                            $validate = RC_Hook::apply_filters( 'cs_validate_' . $field['validate'], $request_value, $field, $section['fields'] );

                            if ( ! empty( $validate ) ) {
                                $add_errors[] = $this->add_settings_error( $validate, 'error', $field['id'] );
                                $request[$field['id']] = ( isset( $this->theme_options[$field['id']] ) ) ? $this->theme_options[$field['id']] : '';
                            }

                        }

                    }

                    if ( ! isset( $field['id'] ) || empty( $request[$field['id']] ) ) {
                        continue;
                    }

                }
            }
        }

        $request = RC_Hook::apply_filters( 'cs_validate_save', $request );

        RC_Hook::do_action( 'cs_validate_save', $request );

        // set transient
        ecjia_theme_transient::set_transient( 'cs-framework-transient', array( 'errors' => $add_errors, 'section_id' => $section_id ), 30 );

        return $request;
    }

    // settings sections
    public function do_settings_sections( $page )
    {

        $theme_settings_sections = ecjia_theme_setting::get_settings_sections($page);

        if ( empty( $theme_settings_sections ) ){
            return;
        }

        foreach ( $theme_settings_sections as $section ) {

            $this->do_settings_section($page, $section);

        }

    }


    public function do_settings_section($page, $section)
    {
        if ( $section['callback'] ){
            call_user_func( $section['callback'], $section );
        }

        $this->do_settings_fields( $page, $section );
    }

    // settings fields
    public function do_settings_fields( $page, $section ) {

        $section_id = $section['name'] .'_section';

        $theme_settings_fields = ecjia_theme_setting::get_settings_fields($page, $section_id);

        if ( empty($theme_settings_fields) ) {
            return;
        }

        foreach ( $theme_settings_fields as $field ) {
            call_user_func($field['callback'], $field['args']);
        }

    }

    /**
     * field callback classes
     *
     * @param $field
     */
    public function fieldCallback( $field )
    {
        $value = ( isset( $field['id'] ) && isset( $this->theme_options[$field['id']] ) ) ? $this->theme_options[$field['id']] : '';
        echo $this->getFramework()->getOptionField()->addElement( $field, $value, $this->unique );
    }

    public function add_settings_error( $message, $type = 'error', $id = 'global' )
    {
        return array(
            'setting' => 'cs-errors',
            'code' => $id,
            'message' => $message,
            'type' => $type
        );
    }



}