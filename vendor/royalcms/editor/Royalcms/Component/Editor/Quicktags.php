<?php

namespace Royalcms\Component\Editor;

use RC_Hook;

/**
 * Facilitates adding of the Royalcms editor as used on the Write and Edit screens.
 *
 * @package WordPress
 * @since 3.3.0
 *
 * Private, not included by default. See wp_editor() in wp-includes/general-template.php.
 */
class Quicktags extends Editor
{
	private static $qt_settings = array ();
	private static $qt_buttons = array ();
	private static $baseurl;
	private static $first_init;
	private static $this_quicktags = false;
	private static $has_quicktags = false;
	private static $editor_buttons_css = true;

	public function __construct()
    {

	}

	public function editor_settings($editor_id, $set)
    {
		$first_run = false;
		
		if (empty ( self::$first_init )) {
			if (defined ( 'IN_ADMIN' )) {
				RC_Hook::add_action ( 'admin_footer', array (
						__CLASS__,
						'editor_js' 
				), 50 );
				RC_Hook::add_action ( 'admin_footer', array (
						__CLASS__,
						'enqueue_scripts' 
				), 1 );
			} else {
				RC_Hook::add_action ( 'front_print_footer_scripts', array (
						__CLASS__,
						'editor_js' 
				), 50 );
				RC_Hook::add_action ( 'front_print_footer_scripts', array (
						__CLASS__,
						'enqueue_scripts' 
				), 1 );
			}
		}
		
		$qtInit = array (
				'id' => $editor_id,
				'buttons' => '' 
		);
		
		if (is_array ( $set ['quicktags'] ))
			$qtInit = array_merge ( $qtInit, $set ['quicktags'] );
		
		if (empty ( $qtInit ['buttons'] ))
			$qtInit ['buttons'] = 'strong,em,link,block,del,ins,img,ul,ol,li,code,more,close';
		
		/**
		 * Filter the Quicktags settings.
		 *
		 * @since 3.3.0
		 *       
		 * @param array $qtInit
		 *        	Quicktags settings.
		 * @param string $editor_id
		 *        	The unique editor ID, e.g. 'content'.
		 */
		$qtInit = RC_Hook::apply_filters ( 'quicktags_settings', $qtInit, $editor_id );
		
		self::$qt_settings [$editor_id] = $qtInit;
		
		self::$qt_buttons = array_merge ( self::$qt_buttons, explode ( ',', $qtInit ['buttons'] ) );
	}


	private static function _parse_init($init)
    {
		$options = '';
		
		foreach ( $init as $k => $v ) {
			if (is_bool ( $v )) {
				$val = $v ? 'true' : 'false';
				$options .= $k . ':' . $val . ',';
				continue;
			} elseif (! empty ( $v ) && is_string ( $v ) && (('{' == $v {0} && '}' == $v {strlen ( $v ) - 1}) || ('[' == $v {0} && ']' == $v {strlen ( $v ) - 1}) || preg_match ( '/^\(?function ?\(/', $v ))) {
				$options .= $k . ':' . $v . ',';
				continue;
			}
			$options .= $k . ':"' . $v . '",';
		}
		
		return '{' . trim ( $options, ' ,' ) . '}';
	}


	public static function enqueue_scripts()
    {
		
		/**
		 * Fires when scripts and styles are enqueued for the editor.
		 *
		 * @since 3.9.0
		 *       
		 * @param array $to_load
		 *        	An array containing boolean values whether TinyMCE
		 *        	and Quicktags are being loaded.
		 */
		RC_Hook::do_action ( 'ecjia_enqueue_editor', array (
				'quicktags' => self::$has_quicktags 
		) );
	}


	public static function editor_js()
    {

	}
}


// end