<?php

namespace Royalcms\Component\Editor;

use RC_Uri;
use RC_Hook;
use RC_Locale;


/**
 * Facilitates adding of the Royalcms editor as used on the Write and Edit screens.
 *
 * @package WordPress
 * @since 3.3.0
 *
 * Private, not included by default. See wp_editor() in wp-includes/general-template.php.
 */
class Tinymce extends Editor
{

    public $mce_locale;

    private $mce_settings = array();

    private $plugins = array();

    private $ext_plugins;

    private $baseurl;

    private $first_init;

    private $this_tinymce = false;

    private $has_tinymce = false;

    private $editor_buttons_css = true;

    private $drag_drop_upload = false;

    public function __construct()
    {
        $this->baseurl = RC_Uri::vendor_url(VENDOR_TINYMCE);
        
        $mce_locale = RC_Locale::get_locale();
        $mce_locale = empty($mce_locale) ? 'zh_CN' : $mce_locale; // strtolower( substr( $mce_locale, 0, 2 ) ); // ISO 639-1

        $this->mce_locale = RC_Hook::apply_filters('mce_locale', $mce_locale);
    }

    public function editor_settings($editor_id, $set)
    {
        $first_run = false;
        
        if (empty($this->first_init)) {
            if (defined('IN_ADMIN')) {
                if (is_pjax()) {
                    RC_Hook::add_action('admin_pjax_footer', array(
                        &$this,
                        'editor_js'
                    ), 50);
                    RC_Hook::add_action('admin_pjax_footer', array(
                        &$this,
                        'enqueue_scripts'
                    ), 1);
                } else {
                    RC_Hook::add_action('admin_footer', array(
                        &$this,
                        'editor_js'
                    ), 50);
                    RC_Hook::add_action('admin_footer', array(
                        &$this,
                        'enqueue_scripts'
                    ), 1);
                }
            } else {
                RC_Hook::add_action('front_print_footer_scripts', array(
                    &$this,
                    'editor_js'
                ), 50);
                RC_Hook::add_action('front_print_footer_scripts', array(
                    &$this,
                    'enqueue_scripts'
                ), 1);
            }
        }
        
        if (empty($this->first_init)) {
            
            /**
             * This filter is documented in wp-admin/includes/media.php
             */
            $no_captions = (bool) RC_Hook::apply_filters('disable_captions', '');
            $first_run = true;
            $ext_plugins = '';
            
            if ($set['teeny']) {
                
                /**
                 * Filter the list of teenyMCE plugins.
                 *
                 * @since 2.7.0
                 *       
                 * @param array $plugins
                 *            An array of teenyMCE plugins.
                 * @param string $editor_id
                 *            Unique editor identifier, e.g. 'content'.
                 */
                $this->plugins = $plugins = RC_Hook::apply_filters('teeny_mce_plugins', array(
                    'fullscreen',
                    'image',
                ), $editor_id);
                /**
                 * 'wordpress',
                 * 'wpeditimage',
                 * 'wplink'
                 * */
            } else {
                
                /**
                 * Filter the list of TinyMCE external plugins.
                 *
                 * The filter takes an associative array of external plugins for
                 * TinyMCE in the form 'plugin_name' => 'url'.
                 *
                 * The url should be absolute, and should include the js filename
                 * to be loaded. For example:
                 * 'myplugin' => 'http://mysite.com/wp-content/plugins/myfolder/mce_plugin.js'.
                 *
                 * If the external plugin adds a button, it should be added with
                 * one of the 'mce_buttons' filters.
                 *
                 * @since 2.5.0
                 *       
                 * @param array $external_plugins
                 *            An array of external TinyMCE plugins.
                 */
                $mce_external_plugins = RC_Hook::apply_filters('mce_external_plugins', array());
                
                $plugins = array(
                    'charmap',
                    'hr',
                    'media',
                    'paste',
                    'tabfocus',
                    'textcolor',
                    'fullscreen',
                    'image',
                    'preview',
                    'code',
                );
                /**
                 * 'wordpress',
                 * 'wpeditimage',
                 * 'wpgallery',
                 * 'wplink',
                 * 'wpdialogs',
                 * 'wpview'  
                 */
                if (! $this->has_medialib) {
                    $plugins[] = 'image';
                }
               
                
                /**
                 * Filter the list of default TinyMCE plugins.
                 *
                 * The filter specifies which of the default plugins included
                 * in WordPress should be added to the TinyMCE instance.
                 *
                 * @since 3.3.0
                 *       
                 * @param array $plugins
                 *            An array of default TinyMCE plugins.
                 */
                $plugins = array_unique(RC_Hook::apply_filters('mce_plugins', $plugins));
                
                if (($key = array_search('spellchecker', $plugins)) !== false) {
                    // Remove 'spellchecker' from the internal plugins if added with 'tiny_mce_plugins' filter to prevent errors.
                    // It can be added with 'mce_external_plugins'.
                    unset($plugins[$key]);
                }
                
            }
            
            $this->plugins = $plugins;
            $this->ext_plugins = $ext_plugins;
            
            /**
               'formats' => "{
                        alignleft: [
							{selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li', styles: {textAlign:'left'}},
							{selector: 'img,table,dl.wp-caption', classes: 'alignleft'}
						],
						aligncenter: [
							{selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li', styles: {textAlign:'center'}},
							{selector: 'img,table,dl.wp-caption', classes: 'aligncenter'}
						],
						alignright: [
							{selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li', styles: {textAlign:'right'}},
							{selector: 'img,table,dl.wp-caption', classes: 'alignright'}
						],
						strikethrough: {inline: 'del'}
					}",
             */
            $formats = array(
            	'alignleft' => array(
            	    array(
            	        'selector' => 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li',
            	        'styles' => array('textAlign' => 'left'),
                    ),
            	    array(
            	    	'selector' => 'img,table,dl.wp-caption',
            	        'classes' => 'alignleft',
            	    ),
            	),
                'aligncenter' => array(
                	array(
                		'selector' => 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li',
                	    'styles' => array('textAlign' => 'center'),
                	),
                    array(
                    	'selector' => 'img,table,dl.wp-caption',
                        'classes' => 'alignright',
                    ),
                ),
                'alignright' => array(
                	array(
                		'selector' => 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li',
                	    'styles' => array('textAlign' => 'right'),
                	),
                    array(
                    	'selector' => 'img,table,dl.wp-caption',
                        'classes' => 'alignright',
                    ),
                ),
                'strikethrough' => array('inline' => 'del'),
            );
            
            $this->first_init = array(
                'theme' => 'modern',
                'skin' => 'ecjia',
                'language' => $this->mce_locale,
                'relative_urls' => false,
                'remove_script_host' => false,
                'convert_urls' => false,
                'browser_spellcheck' => true,
                'fix_list_elements' => true,
                'entities' => '38,amp,60,lt,62,gt',
                'entity_encoding' => 'raw',
                'keep_styles' => false,
                'paste_webkit_styles' => 'font-weight font-style color',
                
                // Limit the preview styles in the menu/toolbar
                'preview_styles' => 'font-family font-size font-weight font-style text-decoration text-transform',
                
//                 'wpeditimage_disable_captions' => $no_captions,
                // 'wpeditimage_html5_captions' => current_theme_supports( 'html5', 'caption' ),
                'plugins' => implode(',', $plugins)
            );
            
            if (! empty($mce_external_plugins)) {
                $this->first_init['external_plugins'] = json_encode($mce_external_plugins);
            }
            
            // default stylesheet and dashicons
            $mce_css = array();
            
            /**
             * Filter the comma-delimited list of stylesheets to load in TinyMCE.
             *
             * @since 2.1.0
             *       
             * @param array $stylesheets
             *            Comma-delimited list of stylesheets.
             */
            $mce_css = trim(RC_Hook::apply_filters('mce_css', implode(',', $mce_css)), ' ,');
            
            if (! empty($mce_css))
                $this->first_init['content_css'] = $mce_css;
        }
        
        if ($set['teeny']) {
            
            /**
             * Filter the list of teenyMCE buttons (Text tab).
             *
             * @since 2.7.0
             *       
             * @param array $buttons
             *            An array of teenyMCE buttons.
             * @param string $editor_id
             *            Unique editor identifier, e.g. 'content'.
             */
            $mce_buttons = RC_Hook::apply_filters('teeny_mce_buttons', array(
                'bold',
                'italic',
                'underline',
                'blockquote',
                'strikethrough',
                'bullist',
                'numlist',
                'alignleft',
                'aligncenter',
                'alignright',
                'undo',
                'redo',
                'link',
                'unlink',
                'fullscreen',
            ), $editor_id);
            $mce_buttons_2 = $mce_buttons_3 = $mce_buttons_4 = array();
        } else {
            
            /**
             * Filter the first-row list of TinyMCE buttons (Visual tab).
             *
             * @since 2.0.0
             *       
             * @param array $buttons
             *            First-row list of buttons.
             * @param string $editor_id
             *            Unique editor identifier, e.g. 'content'.
             */
            $mce_buttons = RC_Hook::apply_filters('mce_buttons', array(
                'bold',
                'italic',
                'strikethrough',
                'bullist',
                'numlist',
                'blockquote',
                'hr',
                'alignleft',
                'aligncenter',
                'alignright',
                'link',
                'unlink',
                'spellchecker',
                'preview',
                'fullscreen',
            ), $editor_id);
            /**
             * 'wp_adv'
             * 'wp_more',
             */
            
            /**
             * Filter the second-row list of TinyMCE buttons (Visual tab).
             *
             * @since 2.0.0
             *       
             * @param array $buttons
             *            Second-row list of buttons.
             * @param string $editor_id
             *            Unique editor identifier, e.g. 'content'.
             */
            $mce_buttons_2 = RC_Hook::apply_filters('mce_buttons_2', array(
                'formatselect',
                'underline',
                'alignjustify',
                'forecolor',
                'pastetext',
                'removeformat',
                'charmap',
                'outdent',
                'indent',
                'undo',
                'redo',
                'image',
                'media',
                'code',
            ), $editor_id);
            /**
             * 'wp_help'
             */
            
            /**
             * Filter the third-row list of TinyMCE buttons (Visual tab).
             *
             * @since 2.0.0
             *       
             * @param array $buttons
             *            Third-row list of buttons.
             * @param string $editor_id
             *            Unique editor identifier, e.g. 'content'.
             */
            $mce_buttons_3 = RC_Hook::apply_filters('mce_buttons_3', array(), $editor_id);
            
            /**
             * Filter the fourth-row list of TinyMCE buttons (Visual tab).
             *
             * @since 2.5.0
             *       
             * @param array $buttons
             *            Fourth-row list of buttons.
             * @param string $editor_id
             *            Unique editor identifier, e.g. 'content'.
             */
            $mce_buttons_4 = RC_Hook::apply_filters('mce_buttons_4', array(), $editor_id);
        }
        
        $body_class = $editor_id;
        
        if (! empty($set['tinymce']['body_class'])) {
            $body_class .= ' ' . $set['tinymce']['body_class'];
            unset($set['tinymce']['body_class']);
        }
        
        /**
         * 'wpautop' => (bool) $set['wpautop'], 
         * 'indent' => ! $set['wpautop'],
         */
        $mceInit = array(
            'selector'  => "#$editor_id",
            'resize'    => 'vertical',
            'menubar'   => false,
            'toolbar1'  => implode($mce_buttons, ','),
            'toolbar2'  => implode($mce_buttons_2, ','),
            'toolbar3'  => implode($mce_buttons_3, ','),
            'toolbar4'  => implode($mce_buttons_4, ','),
            'tabfocus_elements' => $set['tabfocus_elements'],
            'body_class' => $body_class
        );
        
        if ($first_run)
            $mceInit = array_merge($this->first_init, $mceInit);
        
        if (is_array($set['tinymce']))
            $mceInit = array_merge($mceInit, $set['tinymce']);
        
        /**
         * For people who really REALLY know what they're doing with TinyMCE You can modify $mceInit to add, remove, change elements of the config before tinyMCE.init.
         * Setting "valid_elements", "invalid_elements" and "extended_valid_elements" can be done through this filter. Best is to use the default cleanup by not specifying valid_elements, as TinyMCE contains full set of XHTML 1.0.
         */
        if ($set['teeny']) {
            
            /**
             * Filter the teenyMCE config before init.
             *
             * @since 2.7.0
             *       
             * @param array $mceInit
             *            An array with teenyMCE config.
             * @param string $editor_id
             *            Unique editor identifier, e.g. 'content'.
             */
            $mceInit = RC_Hook::apply_filters('teeny_mce_before_init', $mceInit, $editor_id);
        } else {
            
            /**
             * Filter the TinyMCE config before init.
             *
             * @since 2.5.0
             *       
             * @param array $mceInit
             *            An array with TinyMCE config.
             * @param string $editor_id
             *            Unique editor identifier, e.g. 'content'.
             */
            $mceInit = RC_Hook::apply_filters('mce_before_init', $mceInit, $editor_id);
        }
        
        if (empty($mceInit['toolbar3']) && ! empty($mceInit['toolbar4'])) {
            $mceInit['toolbar3'] = $mceInit['toolbar4'];
            $mceInit['toolbar4'] = '';
        }
        
        $this->mce_settings[$editor_id] = $mceInit;
    }

    private function _parse_init($init)
    {
        $options = '';
        
        foreach ($init as $k => $v) {
            if (is_bool($v)) {
                $val = $v ? 'true' : 'false';
                $options .= $k . ':' . $val . ',';
                continue;
            } elseif (! empty($v) && is_string($v) && (('{' == $v{0} && '}' == $v{strlen($v) - 1}) || ('[' == $v{0} && ']' == $v{strlen($v) - 1}) || preg_match('/^\(?function ?\(/', $v))) {
                $options .= $k . ':' . $v . ',';
                continue;
            }
            $options .= $k . ':"' . $v . '",';
        }
        
        return '{' . trim($options, ' ,') . '}';
    }

    public function enqueue_scripts()
    {
        if ($this->has_tinymce)
            RC_Script::enqueue_script('tinymce');
        
        /**
         * Fires when scripts and styles are enqueued for the editor.
         *
         * @since 3.0.0
         *       
         * @param array $to_load
         *            An array containing boolean values whether TinyMCE
         *            and Quicktags are being loaded.
         */
        RC_Hook::do_action('rc_enqueue_editor', array(
            'tinymce' => $this->has_tinymce
        ));
    }

    public function mce_translation()
    {
        $baseurl = $this->baseurl;
        $mce_locale = $this->mce_locale;
        
        $mce_locale_url = "$baseurl/langs/$mce_locale.js";
        
        /**
         * Filter the fourth-row list of TinyMCE buttons (Visual tab).
         *
         * @since 2.5.0
         *       
         * @param array $buttons
         *            Fourth-row list of buttons.
         * @param string $editor_id
         *            Unique editor identifier, e.g. 'content'.
         */
        $mce_locale_url = RC_Hook::apply_filters('mce_locale_url', $mce_locale_url);
        
        return "tinymce.ScriptLoader.load( '$mce_locale_url' );\n";
    }

    public function editor_js()
    {
        $version = 'ver=' . VERSION;
        $tmce_on = ! empty($this->mce_settings);
        
        $mceInit = '';
        if ($tmce_on) {
            foreach ($this->mce_settings as $editor_id => $init) {
                $options = $this->_parse_init($init);
                $mceInit .= "'$editor_id':{$options},";
            }
            $mceInit = '{' . trim($mceInit, ',') . '}';
        } else {
            $mceInit = '{}';
        }
        
        /*   
         * 编辑器配置选项     
        'theme_advanced_toolbar_align' => 'right',
    	'theme_advanced_toolbar_location' => 'bottom',
		'theme_advanced_buttons2' => 'cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote',
    	'toolbar1' => "undo redo | cut copy paste | bold italic underline strikethrough fullscreen |",
    	'toolbar1' => "bold italic underline blockquote strikethrough bullist numlist alignleft aligncenter alignright undo redo link unlink fullscreen",
    		
    	'toolbar1' => "undo redo | cut copy paste | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
    	'toolbar2' => " searchreplace | bullist numlist | outdent indent blockquote | link unlink anchor image media code | inserttime preview | forecolor backcolor",
    	'toolbar3' => "table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | spellchecker | visualchars visualblocks nonbreaking template pagebreak restoredraft",	
         * */

        $suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';

        /**
         * Fires immediately before the TinyMCE settings are printed.
         *
         * @since 3.2.0
         *       
         * @param array $mce_settings
         *            TinyMCE settings array.
         */
        RC_Hook::do_action('before_tinymce', $this->mce_settings);

        $baseurl = $this->baseurl;
        
        // Load tinymce.js when running from /src, else load wp-tinymce.js.gz (production) or tinymce.min.js (SCRIPT_DEBUG)
        $mce_suffix = false !== strpos(VERSION, '-src') ? '' : '.min';
        
        $mce_url = "$baseurl/tinymce$mce_suffix.js";
        
        echo '<script type="text/javascript" src="' . $mce_url . '"></script>' . "\n";

        if ($tmce_on) {
            $mce_init = json_encode($this->mce_settings["$editor_id"]);
            echo "\n";
            echo '<script type="text/javascript">' . "\n";
            echo $this->mce_translation();
            echo "tinymce.init({$mce_init});\n";
            echo "</script>\n";
        }
        
        
        /**
         * Fires after tinymce.js is loaded, but before any TinyMCE editor
         * instances are created.
         *
         * @since 3.0.0
         *       
         * @param array $mce_settings
         *            TinyMCE settings array.
         */
        RC_Hook::do_action('tinymce_init', $this->mce_settings);

        
        if ($this->ext_plugins) {
            echo '<script type="text/javascript">' . "\n";
            echo $this->ext_plugins . "\n";
            echo '</script>' . "\n";
        }
        
        /**
         * Fires after any core TinyMCE editor instances are created.
         *
         * @since 3.0.0
         *       
         * @param array $mce_settings
         *            TinyMCE settings array.
         */
        RC_Hook::do_action('after_tinymce', $this->mce_settings);
    }
}


// end