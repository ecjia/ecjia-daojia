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

/**
 * Facilitates adding of the ecjia editor as used on the Write and Edit screens.
 *
 * @package ecjia
 * @since 1.0.0
 *
 */

final class ecjia_editor {

	private static $this_tinymce = null;
	private static $this_quicktags = null;
	private static $has_tinymce = false;
	private static $has_quicktags = false;
	private static $has_medialib = false;
	private static $drag_drop_upload = false;

	private function __construct() {}

	/**
	 * Parse default arguments for the editor instance.
	 *
	 * @param string $editor_id ID for the current editor instance.
	 * @param array  $settings {
	 *     Array of editor arguments.
	 *
	 *     @type bool       $wpautop           Whether to use wpautop(). Default true.
	 *     @type bool       $media_buttons     Whether to show the Add Media/other media buttons.
	 *     @type string     $default_editor    When both TinyMCE and Quicktags are used, set which
	 *                                         editor is shown on page load. Default empty.
	 *     @type bool       $drag_drop_upload  Whether to enable drag & drop on the editor uploading. Default false.
	 *                                         Requires the media modal.
	 *     @type string     $textarea_name     Give the textarea a unique name here. Square brackets
	 *                                         can be used here. Default $editor_id.
	 *     @type int        $textarea_rows     Number rows in the editor textarea. Default 20.
	 *     @type string|int $tabindex          Tabindex value to use. Default empty.
	 *     @type string     $tabfocus_elements The previous and next element ID to move the focus to
	 *                                         when pressing the Tab key in TinyMCE. Defualt ':prev,:next'.
	 *     @type string     $editor_css        Intended for extra styles for both Visual and Text editors.
	 *                                         Should include <style> tags, and can use "scoped". Default empty.
	 *     @type string     $editor_class      Extra classes to add to the editor textarea elemen. Default empty.
	 *     @type bool       $teeny             Whether to output the minimal editor config. Examples include
	 *                                         Press This and the Comment editor. Default false.
	 *     @type bool       $dfw               Whether to replace the default fullscreen with "Distraction Free
	 *                                         Writing". DFW requires specific DOM elements and css). Default false.
	 *     @type bool|array $tinymce           Whether to load TinyMCE. Can be used to pass settings directly to
	 *                                         TinyMCE using an array. Default true.
	 *     @type bool|array $quicktags         Whether to load Quicktags. Can be used to pass settings directly to
	 *                                         Quicktags using an array. Default true.
	 * }
	 * @return array Parsed arguments array.
	 */
	private static function parse_settings( $editor_id, $settings ) {
		$set = rc_parse_args( $settings,  array(
			'wpautop'           => true,
			'media_buttons'     => true,
			'default_editor'    => '',
			'drag_drop_upload'  => false,
			'textarea_name'     => $editor_id,
			'textarea_rows'     => 20,
			'tabindex'          => '',
			'tabfocus_elements' => ':prev,:next',
			'editor_css'        => '',
			'editor_class'      => '',
			'teeny'             => false,
			'dfw'               => false,
			'tinymce'           => true,
			'quicktags'         => false
		) );

		if ( (bool) $set['tinymce'] )
			self::$has_tinymce = true;

		if ( (bool) $set['quicktags'] )
			self::$has_quicktags = true;

		if ( empty( $set['editor_height'] ) )
			return $set;

		if ( 'content' === $editor_id ) {

		}

		if ( $set['editor_height'] < 50 )
			$set['editor_height'] = 50;
		elseif ( $set['editor_height'] > 5000 )
			$set['editor_height'] = 5000;

		return $set;
	}

	

	private static function editor_settings($editor_id, $set) {
		if ( self::$has_quicktags ) {
		    self::$this_quicktags = new Component_Editor_Quicktags(); //(bool) $set['quicktags'];
// 			self::$this_quicktags->editor_settings($editor_id, $set);
		}
		
		if ( self::$has_tinymce ) {
		    self::$this_tinymce = RC_Hook::apply_filters('the_editor_instance', new Component_Editor_Tinymce()); // $set['tinymce'];
			self::$this_tinymce->editor_settings($editor_id, $set);
		}
	}


	
	/**
	 * Outputs the HTML for a single instance of the editor.
	 *
	 * @param string $content The initial content of the editor.
	 * @param string $editor_id ID for the textarea and TinyMCE and Quicktags instances (can contain only ASCII letters and numbers).
	 * @param array $settings See the _parse_settings() method for description.
	 */
	public static function editor( $content, $editor_id, $settings = array() ) {
	
		$set = self::parse_settings( $editor_id, $settings );
		$editor_class = ' class="' . trim( $set['editor_class'] . ' admin-editor-area' ) . '"';
		$tabindex = $set['tabindex'] ? ' tabindex="' . (int) $set['tabindex'] . '"' : '';
		$switch_class = 'html-active';
		$toolbar = $buttons = $autocomplete = '';
	
		if ( $set['drag_drop_upload'] ) {
			self::$drag_drop_upload = true;
		}
	
		if ( ! empty( $set['editor_height'] ) ) {
			$height = ' style="height: ' . $set['editor_height'] . 'px"';
		} else {
			$height = ' rows="' . $set['textarea_rows'] . '"';
		}
		
		if ( ! self::$has_quicktags && self::$has_tinymce ) {
			$switch_class = 'tmce-active';
			$autocomplete = ' autocomplete="off"';
		} elseif ( self::$has_quicktags && self::$has_tinymce ) {
			$default_editor = $set['default_editor'] ? $set['default_editor'] : self::default_editor();
			$autocomplete = ' autocomplete="off"';
	
			// 'html' is used for the "Text" editor tab.
			if ( 'html' === $default_editor ) {
				RC_Hook::add_filter('the_editor_content', 'admin_htmledit_pre');
				$switch_class = 'html-active';
			} else {
				RC_Hook::add_filter('the_editor_content', 'admin_richedit_pre');
				$switch_class = 'tmce-active';
			}
	
			$buttons .= '<a id="' . $editor_id . '-html" class="admin-switch-editor switch-html" onclick="switchEditors.switchto(this);">' . 'Text' . "</a>\n";
			$buttons .= '<a id="' . $editor_id . '-tmce" class="admin-switch-editor switch-tmce" onclick="switchEditors.switchto(this);">' . 'Visual' . "</a>\n";
		}
	
		$wrap_class = 'admin-core-ui admin-editor-wrap ' . $switch_class;
	
		echo '<div id="admin-' . $editor_id . '-wrap" class="' . $wrap_class . '">';
	
		if ( !empty($set['editor_css']) )
			echo $set['editor_css'] . "\n";
	
		if ( !empty($buttons) || $set['media_buttons'] ) {
			echo '<div id="admin-' . $editor_id . '-editor-tools" class="admin-editor-tools hide-if-no-js">';
	
			if ( $set['media_buttons'] ) {
				self::$has_medialib = true;
	
				echo '<div id="admin-' . $editor_id . '-media-buttons" class="admin-media-buttons">';
	
				/**
				 * Fires after the default media button(s) are displayed.
				 *
				 * @since 1.0.0
				 *
				 * @param string $editor_id Unique editor identifier, e.g. 'content'.
				 */
				RC_Hook::do_action( 'media_buttons', $editor_id );
				echo "</div>\n";
			}
	
			echo '<div class="admin-editor-tabs">' . $buttons . "</div>\n";
			echo "</div>\n";
		}
	
		/**
		 * Filter the HTML markup output that displays the editor.
		 *
		 * @since 1.0.0
		 *
		 * @param string $output Editor's HTML markup.
		 */
		$the_editor = RC_Hook::apply_filters( 'the_editor', '<div id="admin-' . $editor_id . '-editor-container" class="admin-editor-container">' .
				'<textarea' . $editor_class . $height . $tabindex . $autocomplete . ' cols="40" name="' . $set['textarea_name'] . '" ' .
				'id="' . $editor_id . '">%s</textarea></div>' );
	
		/**
		 * Filter the default editor content.
		 *
		 * @since 1.0.0
		 *
		 * @param string $content Default editor content.
		*/
        $content = htmlspecialchars($content);
		$content = RC_Hook::apply_filters( 'the_editor_content', $content );
	
		printf( $the_editor, $content );
		echo "\n</div>\n\n";
	
		self::editor_settings($editor_id, $set);
	}
	
	
	/**
	 * Find out which editor should be displayed by default.
	 *
	 * Works out which of the two editors to display as the current editor for a
	 * user. The 'html' setting is for the "Text" editor tab.
	 *
	 * @since 1.0.0
	 *
	 * @return string Either 'tinymce', or 'html', or 'test'
	 */
	public static function default_editor() {
		
		$r = 'tinymce';
	
		/**
		 * Filter which editor should be displayed by default.
		 *
		 * @since 1.0.0
		 *
		 * @param array $r An array of editors. Accepts 'tinymce', 'html', 'test'.
		 */
		return RC_Hook::apply_filters( 'ecjia_default_editor', $r );
	}
}


// end