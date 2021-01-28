<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/20
 * Time: 09:51
 */

namespace Ecjia\Component\ThemeFramework\Foundation;

use Ecjia\Component\ThemeFramework\ThemeFrameworkAbstract;
use RC_Hook;

/**
 *
 * Options Class
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
class Options extends ThemeFrameworkAbstract
{
    protected $type;

    /**
     * Common Fields
     * @var array
     */
    protected $common_field = [
        'id'             => 'unique', //an unique id - use nice name
        'type'           => 'background', //type of option
        'title'          => null, //title of field
        'desc'           => null, //decription of field. this is showing below title. can be used html
        'help'           => null, //help tooltip of field
        'class'          => null, //extra class of field.
        'wrap_class'     => null, //extra class of field wrapper
        'dependency'     => null, //dependency for showing and hiding fields
        'before'         => null, //extra text for field before area
        'after'          => null, //extra text for field after area
        'name'           => null, //name of field
        'debug'          => null, //showing all config information
        'debug_light'    => null, //showing some config information
        'attirbutes'     => [], //attributes of field. supporting only html standard attributes
        'sanitize'       => '', //sanitize of field. can be enabled or disabled
        'validate'       => null, //validate of field. can be enabled or disabled
        'multilang'      => false, //multilangual support of field
        'show_only_lang' => null, //multilangual support for language keys eg. ‘en’ or ‘tr’ or ‘es’
    ];

    /**
     * Fields Plugin default field
     * @var array
     */
    protected $default_field = [];

    /**
     * @var array
     */
    protected $field = [];

    /**
     * @var array|null
     */
    protected $value = [];

    /**
     * @var null
     */
    protected $org_value;

    /**
     * @var string
     */
    protected $unique;

    /**
     * @var bool
     */
    protected $multilang;

    public function __construct($field = array(), $value = null, $unique = '')
    {
        parent::__construct();

        $this->field     = $field;
        $this->value     = $value;
        $this->org_value = $value;
        $this->unique    = $unique;
        $this->multilang = $this->element_multilang();
    }

    public function element_value($value = '')
    {

        $value = $this->value;

        if (is_array($this->multilang) && is_array($value)) {

            $current = $this->multilang['current'];

            if (isset($value[$current])) {
                $value = $value[$current];
            } else if ($this->multilang['current'] == $this->multilang['default']) {
                $value = $this->value;
            } else {
                $value = '';
            }

        } else if (!is_array($this->multilang) && isset($this->value['multilang']) && is_array($this->value)) {

            $value = array_values($this->value);
            $value = $value[0];

        } else if (is_array($this->multilang) && !is_array($value) && ($this->multilang['current'] != $this->multilang['default'])) {

            $value = '';

        }

        return $value;

    }

    public function element_name($extra_name = '', $multilang = false)
    {

        $element_id      = (isset($this->field['id'])) ? $this->field['id'] : '';
        $extra_multilang = (!$multilang && is_array($this->multilang)) ? '[' . $this->multilang['current'] . ']' : '';
        return (isset($this->field['name'])) ? $this->field['name'] . $extra_name : $this->unique . '[' . $element_id . ']' . $extra_multilang . $extra_name;

    }

    public function element_type()
    {
        $type = (isset($this->field['attributes']['type'])) ? $this->field['attributes']['type'] : $this->field['type'];
        return $type;
    }

    public function element_class($el_class = '')
    {

        $field_class = (isset($this->field['class'])) ? ' ' . $this->field['class'] : '';
        return ($field_class || $el_class) ? ' class="' . $el_class . $field_class . '"' : '';

    }

    public function element_attributes($el_attributes = array())
    {

        $attributes = (isset($this->field['attributes'])) ? $this->field['attributes'] : array();
        $element_id = (isset($this->field['id'])) ? $this->field['id'] : '';

        if ($el_attributes !== false) {
            $sub_elemenet  = (isset($this->field['sub'])) ? 'sub-' : '';
            $el_attributes = (is_string($el_attributes) || is_numeric($el_attributes)) ? array('data-' . $sub_elemenet . 'depend-id' => $element_id . '_' . $el_attributes) : $el_attributes;
            $el_attributes = (empty($el_attributes) && isset($element_id)) ? array('data-' . $sub_elemenet . 'depend-id' => $element_id) : $el_attributes;
        }

        $attributes = rc_parse_args($attributes, $el_attributes);

        $atts = '';

        if (!empty($attributes)) {
            foreach ($attributes as $key => $value) {
                if ($value === 'only-key') {
                    $atts .= ' ' . $key;
                } else {
                    $atts .= ' ' . $key . '="' . $value . '"';
                }
            }
        }

        return $atts;

    }

    public function element_before()
    {
        return (isset($this->field['before'])) ? $this->field['before'] : '';
    }

    public function element_after()
    {

        $out = (isset($this->field['info'])) ? '<p class="cs-text-desc">' . $this->field['info'] . '</p>' : '';
        $out .= (isset($this->field['after'])) ? $this->field['after'] : '';
        $out .= $this->element_after_multilang();
        $out .= $this->element_get_error();
        $out .= $this->element_help();
        $out .= $this->element_debug();
        return $out;

    }

    public function element_debug()
    {

        $out = '';

        if ((isset($this->field['debug']) && $this->field['debug'] === true) || (defined('CS_OPTIONS_DEBUG') && CS_OPTIONS_DEBUG)) {

            $value = $this->element_value();

            $out .= "<pre>";
            $out .= "<strong>" . __('CONFIG', 'ecjia') . ":</strong>";
            $out .= "\n";
            ob_start();
            var_export($this->field);
            $out .= htmlspecialchars(ob_get_clean());
            $out .= "\n\n";
            $out .= "<strong>" . __('USAGE', 'ecjia') . ":</strong>";
            $out .= "\n";
            $out .= (isset($this->field['id'])) ? "cs_get_option( '" . $this->field['id'] . "' );" : '';

            if (!empty($value)) {
                $out .= "\n\n";
                $out .= "<strong>" . __('VALUE', 'ecjia') . ":</strong>";
                $out .= "\n";
                ob_start();
                var_export($value);
                $out .= htmlspecialchars(ob_get_clean());
            }

            $out .= "</pre>";

        }

        if ((isset($this->field['debug_light']) && $this->field['debug_light'] === true) || (defined('CS_OPTIONS_DEBUG_LIGHT') && CS_OPTIONS_DEBUG_LIGHT)) {

            $out .= "<pre>";
            $out .= "<strong>" . __('USAGE', 'ecjia') . ":</strong>";
            $out .= "\n";
            $out .= (isset($this->field['id'])) ? "cs_get_option( '" . $this->field['id'] . "' );" : '';
            $out .= "\n";
            $out .= "<strong>" . __('ID', 'ecjia') . ":</strong>";
            $out .= "\n";
            $out .= (isset($this->field['id'])) ? $this->field['id'] : '';
            $out .= "</pre>";

        }

        return $out;

    }

    public function element_get_error()
    {

        global $cs_errors;

        $out = '';

        if (!empty($cs_errors)) {
            foreach ($cs_errors as $key => $value) {
                if (isset($this->field['id']) && $value['code'] == $this->field['id']) {
                    $out .= '<p class="cs-text-warning">' . $value['message'] . '</p>';
                }
            }
        }

        return $out;

    }

    public function element_help()
    {
        return (isset($this->field['help'])) ? '<span class="cs-help" data-title="' . $this->field['help'] . '"><span class="fa fa-question-circle"></span></span>' : '';
    }

    public function element_after_multilang()
    {

        $out = '';

        if (is_array($this->multilang)) {

            $out .= '<fieldset class="hidden">';

            foreach ($this->multilang['languages'] as $key => $val) {

                // ignore current language for hidden element
                if ($key != $this->multilang['current']) {

                    // set default value
                    if (isset($this->org_value[$key])) {
                        $value = $this->org_value[$key];
                    } else if (!isset($this->org_value[$key]) && ($key == $this->multilang['default'])) {
                        $value = $this->org_value;
                    } else {
                        $value = '';
                    }

                    $cache_field = $this->field;

                    unset($cache_field['multilang']);
                    $cache_field['name'] = $this->element_name('[' . $key . ']', true);

                    $class   = 'CSFramework_Option_' . $this->field['type'];
                    $element = new $class($cache_field, $value, $this->unique);

                    ob_start();
                    $element->output();
                    $out .= ob_get_clean();

                }
            }

            $out .= '<input type="hidden" name="' . $this->element_name('[multilang]', true) . '" value="true" />';
            $out .= '</fieldset>';
            $out .= '<p class="cs-text-desc">' . sprintf(__('You are editing language: ( <strong>%s</strong> )', 'ecjia'), $this->multilang['current']) . '</p>';

        }

        return $out;
    }

    public function element_data($type = '')
    {

        $options    = array();
        $query_args = (isset($this->field['query_args'])) ? $this->field['query_args'] : array();

        switch ($type) {

            case 'pages':
            case 'page':

                $pages = get_pages($query_args);

                if (!is_ecjia_error($pages) && !empty($pages)) {
                    foreach ($pages as $page) {
                        $options[$page->ID] = $page->post_title;
                    }
                }

                break;

            case 'posts':
            case 'post':

                $posts = get_posts($query_args);

                if (!is_ecjia_error($posts) && !empty($posts)) {
                    foreach ($posts as $post) {
                        $options[$post->ID] = $post->post_title;
                    }
                }

                break;

            case 'categories':
            case 'category':

                $categories = get_categories($query_args);

                if (!is_ecjia_error($categories) && !empty($categories) && !isset($categories['errors'])) {
                    foreach ($categories as $category) {
                        $options[$category->term_id] = $category->name;
                    }
                }

                break;

            case 'tags':
            case 'tag':

                $taxonomies = (isset($query_args['taxonomies'])) ? $query_args['taxonomies'] : 'post_tag';
                $tags       = get_terms($taxonomies, $query_args);

                if (!is_ecjia_error($tags) && !empty($tags)) {
                    foreach ($tags as $tag) {
                        $options[$tag->term_id] = $tag->name;
                    }
                }

                break;

            case 'custom':
            case 'callback':

                if (is_callable($query_args['function'])) {
                    $options = call_user_func($query_args['function'], $query_args['args']);
                }

                break;

        }

        return $options;
    }

    public function checked($helper = '', $current = '', $type = 'checked', $echo = false)
    {

        if (is_array($helper) && in_array($current, $helper)) {
            $result = ' ' . $type . '="' . $type . '"';
        } else if ($helper == $current) {
            $result = ' ' . $type . '="' . $type . '"';
        } else {
            $result = '';
        }

        if ($echo) {
            echo $result;
        }

        return $result;

    }

    public function element_multilang()
    {
        return (isset($this->field['multilang'])) ? royalcms('ecjia.theme.framework')->language_defaults() : false;
    }

}