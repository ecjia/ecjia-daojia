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
 * ECJia Administration Screen API.
 *
 * @package ECJia
 * @subpackage Administration
 */

/**
 * A class representing the admin screen.
 *
 * @since 1.0.0
 * @access public
 */
class ecjia_screen {
	/**
	 * Any action associated with the screen. 'add' for *-add.php and *-new.php screens. Empty otherwise.
	 *
	 * @since 1.0.0
	 * @var string
	 * @access public
	 */
	public $action;

	/**
	 * The base type of the screen. This is typically the same as $id but with any post types and taxonomies stripped.
	 * For example, for an $id of 'edit-post' the base is 'edit'.
	 *
	 * @since 1.0.0
	 * @var string
	 * @access public
	 */
	public $base;

	/**
	 * The number of columns to display. Access with get_columns().
	 *
	 * @since 1.0.0
	 * @var int
	 * @access private
	 */
	private $columns = 0;

	/**
	 * The unique ID of the screen.
	 *
	 * @since 1.0.0
	 * @var string
	 * @access public
	 */
	public $id;

	/**
	 * Which admin the screen is in. network | user | site | false
	 *
	 * @since 1.0.0
	 * @var string
	 * @access protected
	 */
	protected $in_admin;

// 	/**
// 	 * Whether the screen is in the network admin.
// 	 *
// 	 * Deprecated. Use in_admin() instead.
// 	 *
// 	 * @since 3.3.0
// 	 * @deprecated 3.5.0
// 	 * @var bool
// 	 * @access public
// 	 */
// 	public $is_network;

// 	/**
// 	 * Whether the screen is in the user admin.
// 	 *
// 	 * Deprecated. Use in_admin() instead.
// 	 *
// 	 * @since 3.3.0
// 	 * @deprecated 3.5.0
// 	 * @var bool
// 	 * @access public
// 	 */
// 	public $is_user;

	/**
	 * The base menu parent.
	 * This is derived from $parent_file by removing the query string and any .php extension.
	 * $parent_file values of 'edit.php?post_type=page' and 'edit.php?post_type=post' have a $parent_base of 'edit'.
	 *
	 * @since 1.0.0
	 * @var string
	 * @access public
	 */
	public $parent_base;

	/**
	 * The parent_file for the screen per the admin menu system.
	 * Some $parent_file values are 'edit.php?post_type=page', 'edit.php', and 'options-general.php'.
	 *
	 * @since 1.0.0
	 * @var string
	 * @access public
	 */
	public $parent_file;

// 	/**
// 	 * The post type associated with the screen, if any.
// 	 * The 'edit.php?post_type=page' screen has a post type of 'page'.
// 	 * The 'edit-tags.php?taxonomy=$taxonomy&post_type=page' screen has a post type of 'page'.
// 	 *
// 	 * @since 3.3.0
// 	 * @var string
// 	 * @access public
// 	 */
// 	public $post_type;

// 	/**
// 	 * The taxonomy associated with the screen, if any.
// 	 * The 'edit-tags.php?taxonomy=category' screen has a taxonomy of 'category'.
// 	 * @since 3.3.0
// 	 * @var string
// 	 * @access public
// 	 */
// 	public $taxonomy;

	/**
	 * The help tab data associated with the screen, if any.
	 *
	 * @since 1.0.0
	 * @var array
	 * @access private
	 */
	private $_help_tabs = array();

	/**
	 * The help sidebar data associated with screen, if any.
	 *
	 * @since 1.0.0
	 * @var string
	 * @access private
	 */
	private $_help_sidebar = '';

	/**
	 * Stores old string-based help.
	 */
	private static $_old_compat_help = array();

	/**
	 * The screen options associated with screen, if any.
	 *
	 * @since 1.0.0
	 * @var array
	 * @access private
	 */
	private $_options = array();

	/**
	 * The screen options associated with screen, if any.
	 *
	 * @since 1.0.0
	 * @var array
	 * @access protected
	 */
	protected $_nav_here = array();

	/**
	 * The screen options associated with screen, if any.
	 *
	 * @since 1.0.0
	 * @var array
	 * @access protected
	 */
	protected $_admin_notice = array();

	/**
	 * The screen object registry.
	 *
	 * @since 1.0.0
	 * @var array
	 * @access private
	 */
	private static $_registry = array();

	/**
	 * Stores the result of the public show_screen_options function.
	 *
	 * @since 1.0.0
	 * @var bool
	 * @access private
	 */
	private $_show_screen_options;

	/**
	 * Stores the 'screen_settings' section of screen options.
	 *
	 * @since 1.0.0
	 * @var string
	 * @access private
	 */
	private $_screen_settings;

	public static $hook_suffix;

	private $_sidebar_display = true;

	/**
	 * Fetches a screen object.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param string $hook_name Optional. The hook name (also known as the hook suffix) used to determine the screen.
	 * 	Defaults to the current $hook_suffix global.
	 * @return WP_Screen Screen object.
	 */
	public static function get( $hook_name = '' ) {

		if ( is_a( $hook_name, __CLASS__ ) )
			return $hook_name;

		$post_type = $taxonomy = null;
		$in_admin = false;
		$action = '';

		if ( $hook_name )
			$id = $hook_name;
		else
			$id = self::$hook_suffix;

// 		// For those pesky meta boxes.
// 		if ( $hook_name && post_type_exists( $hook_name ) ) {
// 			$post_type = $id;
// 			$id = 'post'; // changes later. ends up being $base.
// 		} else {
// 			if ( '.php' == substr( $id, -4 ) )
// 				$id = substr( $id, 0, -4 );

// 			if ( 'post-new' == $id || 'link-add' == $id || 'media-new' == $id || 'user-new' == $id ) {
// 				$id = substr( $id, 0, -4 );
// 				$action = 'add';
// 			}
// 		}

// 		if ( ! $post_type && $hook_name ) {
// 			if ( '-network' == substr( $id, -8 ) ) {
// 				$id = substr( $id, 0, -8 );
// 				$in_admin = 'network';
// 			} elseif ( '-user' == substr( $id, -5 ) ) {
// 				$id = substr( $id, 0, -5 );
// 				$in_admin = 'user';
// 			}

// 			$id = sanitize_key( $id );
// 			if ( 'edit-comments' != $id && 'edit-tags' != $id && 'edit-' == substr( $id, 0, 5 ) ) {
// 				$maybe = substr( $id, 5 );
// 				if ( taxonomy_exists( $maybe ) ) {
// 					$id = 'edit-tags';
// 					$taxonomy = $maybe;
// 				} elseif ( post_type_exists( $maybe ) ) {
// 					$id = 'edit';
// 					$post_type = $maybe;
// 				}
// 			}

// 			if ( ! $in_admin )
// 				$in_admin = 'site';
// 		} else {
// 			if ( defined( 'WP_NETWORK_ADMIN' ) && WP_NETWORK_ADMIN )
// 				$in_admin = 'network';
// 			elseif ( defined( 'WP_USER_ADMIN' ) && WP_USER_ADMIN )
// 				$in_admin = 'user';
// 			else
// 				$in_admin = 'site';
// 		}

		if ( 'index' == $id )
			$id = 'dashboard';
		elseif ( 'front' == $id )
			$in_admin = false;

		$base = $id;

// 		If this is the current screen, see if we can be more accurate for post types and taxonomies.
// 		if ( ! $hook_name ) {
// 			if ( isset( $_REQUEST['post_type'] ) )
// 				$post_type = post_type_exists( $_REQUEST['post_type'] ) ? $_REQUEST['post_type'] : false;
// 			if ( isset( $_REQUEST['taxonomy'] ) )
// 				$taxonomy = taxonomy_exists( $_REQUEST['taxonomy'] ) ? $_REQUEST['taxonomy'] : false;

// 			switch ( $base ) {
// 				case 'post' :
// 					if ( isset( $_GET['post'] ) )
// 						$post_id = (int) $_GET['post'];
// 					elseif ( isset( $_POST['post_ID'] ) )
// 						$post_id = (int) $_POST['post_ID'];
// 					else
// 						$post_id = 0;

// 					if ( $post_id ) {
// 						$post = get_post( $post_id );
// 						if ( $post )
// 							$post_type = $post->post_type;
// 					}
// 					break;
// 				case 'edit-tags' :
// 					if ( null === $post_type && is_object_in_taxonomy( 'post', $taxonomy ? $taxonomy : 'post_tag' ) )
// 						$post_type = 'post';
// 					break;
// 			}
// 		}

// 		switch ( $base ) {
// 			case 'post' :
// 				if ( null === $post_type )
// 					$post_type = 'post';
// 				$id = $post_type;
// 				break;
// 			case 'edit' :
// 				if ( null === $post_type )
// 					$post_type = 'post';
// 				$id .= '-' . $post_type;
// 				break;
// 			case 'edit-tags' :
// 				if ( null === $taxonomy )
// 					$taxonomy = 'post_tag';
// 				// The edit-tags ID does not contain the post type. Look for it in the request.
// 				if ( null === $post_type ) {
// 					$post_type = 'post';
// 					if ( isset( $_REQUEST['post_type'] ) && post_type_exists( $_REQUEST['post_type'] ) )
// 						$post_type = $_REQUEST['post_type'];
// 				}

// 				$id = 'edit-' . $taxonomy;
// 				break;
// 		}

// 		if ( 'network' == $in_admin ) {
// 			$id   .= '-network';
// 			$base .= '-network';
// 		} elseif ( 'user' == $in_admin ) {
// 			$id   .= '-user';
// 			$base .= '-user';
// 		}

		if ( isset( self::$_registry[ $id ] ) ) {
			$screen = self::$_registry[ $id ];
			if ( $screen === self::get_current_screen() )
				return $screen;
		} else {
			$screen = new static();
			$screen->id     = $id;
		}

		$screen->base       = $base;
		$screen->action     = $action;
// 		$screen->post_type  = (string) $post_type;
// 		$screen->taxonomy   = (string) $taxonomy;
// 		$screen->is_user    = ( 'user' == $in_admin );
// 		$screen->is_network = ( 'network' == $in_admin );
// 		$screen->in_admin   = $in_admin;

		self::$_registry[ $id ] = $screen;

		return $screen;
	}

	/**
	 * Makes the screen object the current screen.
	 *
	 * @see set_current_screen()
	 * @since 1.0.0
	 */
	function make_current_screen() {
// 		global $current_screen, $taxnow, $typenow;
		self::$current_screen = $this;
// 		$taxnow = $this->taxonomy;
// 		$typenow = $this->post_type;

		/**
		 * Fires after the current screen has been set.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Screen $current_screen Current WP_Screen object.
		 */
		RC_Hook::do_action( 'current_screen', self::$current_screen );
	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function __construct() {}

	/**
	 * Indicates whether the screen is in a particular admin
	 *
	 * @since 1.0.0
	 *
	 * @param string $admin The admin to check against (network | user | site).
	 * If empty any of the three admins will result in true.
	 * @return boolean True if the screen is in the indicated admin, false otherwise.
	 *
	 */
	public function in_admin( $admin = null ) {
		if ( empty( $admin ) ) {
		    return (bool) $this->in_admin;
		}

		return ( $admin == $this->in_admin );
	}

	/**
	 * Sets the old string-based contextual help for the screen.
	 *
	 * For backwards compatibility.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Screen $screen A screen object.
	 * @param string $help Help text.
	 */
	static function add_old_compat_help( $screen, $help ) {
		self::$_old_compat_help[ $screen->id ] = $help;
	}

	/**
	 * Set the parent information for the screen.
	 * This is called in header after the menu parent for the screen has been determined.
	 *
	 * @since 1.0.0
	 * 
	 * @param string $parent_base The parent base of the screen. 
	 * @param string $parent_file The parent file of the screen. Typically the $parent_file global.
	 */
	function set_parentage($parent_base, $parent_file ) {
		$this->parent_file = $parent_file;
		$this->parent_base = $parent_base;
	}

	/**
	 * 添加一个对象
	 * @param admin_nav_here $nav_here
	 */
	public function add_nav_here(admin_nav_here $nav_here) {
	    if ($nav_here instanceof admin_nav_here) {
	        $this->_nav_here[] = $nav_here;
	    }
	}

	/**
	 * 移除所有对象
	 */
	public function remove_nav_here() {
	    $this->_nav_here = array();
	}

	/**
	 * 移出最后一个对象
	 */
	public function remove_last_nav_here() {
	    array_pop($this->_nav_here);
	}

	/**
	 * 添加一个对象
	 * @param admin_notice $admin_notice
	 */
	public function add_admin_notice(admin_notice $admin_notice) {
	    if ($admin_notice instanceof admin_notice) {
	        $this->_admin_notice[] = $admin_notice;
	    }
	}

	/**
	 * 设置隐藏侧边栏
	 */
	public function set_sidebar_display($bool) {
	    $this->_sidebar_display = $bool;

	    if ($bool) {
	        setcookie('ecjia_sidebar', '');
	    } else {
	        setcookie('ecjia_sidebar', 'hidden');
	    }
	}

	/**
	 * 获取侧边栏显示状态
	 * @return boolean
	 */
	public function get_sidebar_display() {
	    return $this->_sidebar_display;
	}

	/**
	 * Adds an option for the screen.
	 * Call this in template files after admin.php is loaded and before admin-header.php is loaded to add screen options.
	 *
	 * @since 1.0.0
	 *
	 * @param string $option Option ID
	 * @param mixed $args Option-dependent arguments.
	 */
	public function add_option( $option, $args = array() ) {
		$this->_options[ $option ] = $args;
	}

	/**
	 * Remove an option from the screen.
	 *
	 * @since 1.0.0
	 *
	 * @param string $option Option ID.
	 */
	public function remove_option( $option ) {
		unset( $this->_options[ $option ] );
	}

	/**
	 * Remove all options from the screen.
	 *
	 * @since 1.0.0
	 */
	public function remove_options() {
		$this->_options = array();
	}

	/**
	 * Get the options registered for the screen.
	 *
	 * @since 1.0.0
	 *
	 * @return array Options with arguments.
	 */
	public function get_options() {
		return $this->_options;
	}

	/**
	 * Gets the arguments for an option for the screen.
	 *
	 * @since 1.0.0
	 *
	 * @param string $option Option ID.
	 * @param mixed $key Optional. Specific array key for when the option is an array.
	 */
	public function get_option( $option, $key = false ) {
		if ( ! isset( $this->_options[ $option ] ) )
			return null;
		if ( $key ) {
			if ( isset( $this->_options[ $option ][ $key ] ) )
				return $this->_options[ $option ][ $key ];
			return null;
		}
		return $this->_options[ $option ];
	}

	/**
	 * Gets the help tabs registered for the screen.
	 *
	 * @since 1.0.0
	 *
	 * @return array Help tabs with arguments.
	 */
	public function get_help_tabs() {
		return $this->_help_tabs;
	}

	/**
	 * Gets the arguments for a help tab.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id Help Tab ID.
	 * @return array Help tab arguments.
	 */
	public function get_help_tab( $id ) {
		if ( ! isset( $this->_help_tabs[ $id ] ) )
			return null;
		return $this->_help_tabs[ $id ];
	}

	/**
	 * Add a help tab to the contextual help for the screen.
	 * Call this on the load-$pagenow hook for the relevant screen.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args
	 * - string   - title    - Title for the tab.
	 * - string   - id       - Tab ID. Must be HTML-safe.
	 * - string   - content  - Help tab content in plain text or HTML. Optional.
	 * - callback - callback - A callback to generate the tab content. Optional.
	 *
	 */
	public function add_help_tab( $args ) {
		$defaults = array(
			'title'    => false,
			'id'       => false,
			'content'  => '',
			'callback' => false,
		);
		$args = rc_parse_args( $args, $defaults );

		$args['id'] = RC_Format::sanitize_html_class( $args['id'] );

		// Ensure we have an ID and title.
		if ( ! $args['id'] || ! $args['title'] )
			return;

		// Allows for overriding an existing tab with that ID.
		$this->_help_tabs[ $args['id'] ] = $args;
	}

	/**
	 * Removes a help tab from the contextual help for the screen.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id The help tab ID.
	 */
	public function remove_help_tab( $id ) {
		unset( $this->_help_tabs[ $id ] );
	}

	/**
	 * Removes all help tabs from the contextual help for the screen.
	 *
	 * @since 1.0.0
	 */
	public function remove_help_tabs() {
		$this->_help_tabs = array();
	}

	/**
	 * Gets the content from a contextual help sidebar.
	 *
	 * @since 1.0.0
	 *
	 * @return string Contents of the help sidebar.
	 */
	public function get_help_sidebar() {
		return $this->_help_sidebar;
	}

	/**
	 * Add a sidebar to the contextual help for the screen.
	 * Call this in template files after admin.php is loaded and before admin-header.php is loaded to add a sidebar to the contextual help.
	 *
	 * @since 1.0.0
	 *
	 * @param string $content Sidebar content in plain text or HTML.
	 */
	public function set_help_sidebar( $content ) {
		$this->_help_sidebar = $content;
	}

	/**
	 * Gets the number of layout columns the user has selected.
	 *
	 * The layout_columns option controls the max number and default number of
	 * columns. This method returns the number of columns within that range selected
	 * by the user via Screen Options. If no selection has been made, the default
	 * provisioned in layout_columns is returned. If the screen does not support
	 * selecting the number of layout columns, 0 is returned.
	 *
	 * @since 1.0.0
	 *
	 * @return int Number of columns to display.
	 */
	public function get_columns() {
		return $this->columns;
	}

	/**
	 * Render the screen's help section.
	 *
	 * This will trigger the deprecated filters for backwards compatibility.
	 *
	 * @since 1.0.0
	 */
	public function render_screen_meta() {

		/**
		 * Filter the legacy contextual help list.
		 *
		 * @since 1.0.0
		 * @deprecated 1.0.0 Use get_current_screen()->add_help_tab() or
		 *                   get_current_screen()->remove_help_tab() instead.
		 *
		 * @param array     $old_compat_help Old contextual help.
		 * @param WP_Screen $this            Current WP_Screen instance.
		 */
		self::$_old_compat_help = RC_Hook::apply_filters( 'contextual_help_list', self::$_old_compat_help, $this );

		$old_help = isset( self::$_old_compat_help[ $this->id ] ) ? self::$_old_compat_help[ $this->id ] : '';

		/**
		 * Filter the legacy contextual help text.
		 *
		 * @since 1.0.0
		 * @deprecated 1.0.0 Use get_current_screen()->add_help_tab() or
		 *                   get_current_screen()->remove_help_tab() instead.
		 *
		 * @param string    $old_help  Help text that appears on the screen.
		 * @param string    $screen_id Screen ID.
		 * @param WP_Screen $this      Current WP_Screen instance.
		 *
		 */
		$old_help = RC_Hook::apply_filters( 'contextual_help', $old_help, $this->id, $this );

		// Default help only if there is no old-style block of text and no new-style help tabs.
		if ( empty( $old_help ) && ! $this->get_help_tabs() ) {

			/**
			 * Filter the default legacy contextual help text.
			 *
			 * @since 1.0.0
			 * @deprecated 1.0.0 Use get_current_screen()->add_help_tab() or
			 *                   get_current_screen()->remove_help_tab() instead.
			 *
			 * @param string $old_help_default Default contextual help text.
			 */
			$default_help = RC_Hook::apply_filters( 'default_contextual_help', '' );
			if ( $default_help )
				$old_help = '<p>' . $default_help . '</p>';
		}

		if ( $old_help ) {
			$this->add_help_tab( array(
				'id'      => 'old-contextual-help',
				'title'   => __('Overview'),
				'content' => $old_help,
			) );
		}

		$help_sidebar = $this->get_help_sidebar();

		$help_class = 'hidden';
		if ( ! $help_sidebar )
			$help_class .= ' no-sidebar';

		// Time to render!
		if (!empty($this->_nav_here)) :
		?>
		<div id="jCrumbs" class="breadCrumb module breadCrumbECJ">
			<div class="breadCrumbWrap">
				<ul>
					<li><a href="<?php echo RC_Uri::url('@index/init');?>"><i class="icon-home"></i></a></li>
					<?php

						foreach ($this->_nav_here as $nav_here) :
						    if (end($this->_nav_here) === $nav_here) {
                                $last_css = ' class="last"';
                            }
							if ($nav_here->get_link()) :
								?>
							<li<?php echo $last_css;?>><a href="<?php echo $nav_here->get_link();?>"><?php echo $nav_here->get_label();?></a></li>
					       <?php else : ?>
					       <li<?php echo $last_css;?>><?php echo $nav_here->get_label();?></li>
					       <?php
					       endif;
					   endforeach;
					?>
				</ul>
			</div>

			<div id="screen-meta" class="metabox-prefs">

				<div class="contextual-help-wrap" class="<?php echo RC_Format::esc_attr( $help_class ); ?>" aria-label="<?php esc_attr_e('Contextual Help Tab'); ?>"><!-- tabindex="-1"  -->

					<div id="contextual-help-columns tab-content row-fluid">

							<div class="contextual-help-tabs">
								<ul class="">
									<?php
									$class = ' class="active"';
									foreach ( $this->get_help_tabs() as $tab ) :
										$link_id  = "tab-link-{$tab['id']}";
										$panel_id = "tab-panel-{$tab['id']}";
									?>

									<li id="<?php echo RC_Format::esc_attr( $link_id ); ?>"<?php echo $class; ?>>
										<a href="#<?php echo RC_Format::esc_attr( "#$panel_id" ); ?>" aria-controls="<?php echo RC_Format::esc_attr( $panel_id ); ?>" data-toggle="tab">
											<?php echo RC_Format::esc_html( $tab['title'] ); ?>
										</a>
									</li>
									<?php
										$class = '';
									endforeach;
									?>
								</ul>
							</div>
							<div class="contextual-help-tabs-wrap">
								<div class="tab-content">
									<?php
									$classes = 'help-tab-content active';
									foreach ( $this->get_help_tabs() as $tab ):
										$panel_id = "tab-panel-{$tab['id']}";
									?>

									<div id="<?php echo RC_Format::esc_attr( $panel_id ); ?>" class="<?php echo $classes; ?> tab-pane">
										<?php
											// Print tab content.
										echo $tab['content'];

											// If it exists, fire tab callback.
										if ( ! empty( $tab['callback'] ) )
											call_user_func_array( $tab['callback'], array( $this, $tab ) );
										?>
									</div>
									<?php
									$classes = 'help-tab-content';
									endforeach;
									?>
								</div>
							</div>

						<?php if ( $help_sidebar ) : ?>
							<div class="contextual-help-sidebar tab-pane active">
								<?php echo $help_sidebar; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
    		<?php
    		// Setup layout columns

    		/**
    		 * Filter the array of screen layout columns.
    		 *
    		 * This hook provides back-compat for plugins using the back-compat
    		 * filter instead of add_screen_option().
    		 *
    		 * @since 1.0.0
    		 *
    		 * @param array     $empty_columns Empty array.
    		 * @param string    $screen_id     Screen ID.
    		 * @param WP_Screen $this          Current WP_Screen instance.
    		 */
    		$columns = RC_Hook::apply_filters( 'screen_layout_columns', array(), $this->id, $this );

    		if ( ! empty( $columns ) && isset( $columns[ $this->id ] ) )
    			$this->add_option( 'layout_columns', array('max' => $columns[ $this->id ] ) );

    		if ( $this->get_option( 'layout_columns' ) ) {
    			$this->columns = (int) get_user_option("screen_layout_$this->id");

    			if ( ! $this->columns && $this->get_option( 'layout_columns', 'default' ) )
    				$this->columns = $this->get_option( 'layout_columns', 'default' );
    		}
    		$GLOBALS[ 'screen_layout_columns' ] = $this->columns; // Set the global for back-compat.

    		// Add screen options
    		if ( $this->show_screen_options() )
    			$this->render_screen_options();
    		?>
    		</div>
    		<?php
    		if ( ! $this->get_help_tabs() && ! $this->show_screen_options() ){
    			echo "</div>";
    			return;
    		}
    		?>

            <div class="screen-meta-links" id="screen-meta-links">
                <?php if ( $this->get_help_tabs() ) : ?>
                <a class="btn btn-mini contextual-help-link" href="javascript:;" id="contextual-help-link" aria-controls="contextual-help-wrap" aria-expanded="false"><?php _e( '帮助' ); ?><i class="fontello-icon-angle-down"></i></a>
                <?php endif;
                if ( $this->show_screen_options() ) : ?>
                <a class="btn btn-mini show-settings-link" href="javascript:;" id="show-settings-link" aria-controls="screen-options-wrap" aria-expanded="false"><?php _e( '选项' ); ?><i class="fontello-icon-angle-down"></i></a>
                <?php endif; ?>
            </div>

			<script type="text/javascript">
				$('.contextual-help-link').on('click', function(){
					var
						$this = $(this),
						$screenmeta = $this.parents('.breadCrumb').find('.contextual-help-wrap'),
						$i = $this.find('i');
					if(!$screenmeta.is(":animated") && $this.css('opacity') != 0){
						if($i.attr('class', $i.hasClass('fontello-icon-angle-down') ? 'fontello-icon-angle-up' : 'fontello-icon-angle-down').hasClass('fontello-icon-angle-up')){
							$screenmeta.slideDown('slow', 'easeOutQuint');
							$('.show-settings-link').css({'opacity':0,'cursor':'default'});
						}else{
							$screenmeta.slideUp('slow', 'easeInQuart');
							$('.show-settings-link').css({'opacity':1,'cursor':'pointer'});
						}
					}
				})
				$('.show-settings-link').on('click', function(){
					var
						$this = $(this),
						$screenmeta = $this.parents('.breadCrumb').find('.screen-options-wrap'),
						$i = $this.find('i');
					if(!$screenmeta.is(":animated") && $this.css('opacity') != 0){
						if($i.attr('class', $i.hasClass('fontello-icon-angle-down') ? 'fontello-icon-angle-up' : 'fontello-icon-angle-down').hasClass('fontello-icon-angle-up')){
							$screenmeta.slideDown('slow', 'easeOutBack');
							$('.contextual-help-link').css({'opacity':0,'cursor':'default'});
						}else{
							$screenmeta.slideUp('slow', 'easeInBack');
							$('.contextual-help-link').css({'opacity':1,'cursor':'pointer'});
						}
					}
				})
			</script>
		</div>
		<?php
		endif;

		if (!empty($this->_admin_notice)) :
    		foreach ($this->_admin_notice as $admin_notice) :
		 ?>
                <div class="alert">
                    <?php if ($admin_notice->get_allow_close()) :?>
                	<a data-dismiss="alert" class="close">×</a>
                	<?php endif;?>
                	<?php echo $admin_notice->get_content();?>
                </div>
		       <?php
		    endforeach;
		endif;
	}

	public function show_screen_options() {
		global $wp_meta_boxes;

		if ( is_bool( $this->_show_screen_options ) )
			return $this->_show_screen_options;

		$columns = self::get_column_headers( $this );

		$show_screen = ! empty( $wp_meta_boxes[ $this->id ] ) || $columns || $this->get_option( 'per_page' );

		switch ( $this->id ) {
			case 'widgets':
				$this->_screen_settings = '<p><a id="access-on" href="widgets.php?widgets-access=on">' . __('Enable accessibility mode') . '</a><a id="access-off" href="widgets.php?widgets-access=off">' . __('Disable accessibility mode') . "</a></p>\n";
				break;
			default:
				$this->_screen_settings = '';
				break;
		}

		/**
		 * Filter the screen settings text displayed in the Screen Options tab.
		 *
		 * This filter is currently only used on the Widgets screen to enable
		 * accessibility mode.
		 *
		 * @since 1.0.0
		 *
		 * @param string    $screen_settings Screen settings.
		 * @param WP_Screen $this            WP_Screen object.
		 */
		$this->_screen_settings = RC_Hook::apply_filters( 'screen_settings', $this->_screen_settings, $this );

		if ( $this->_screen_settings || $this->_options )
			$show_screen = true;

		/**
		 * Filter whether to show the Screen Options tab.
		 *
		 * @since 1.0.0
		 *
		 * @param bool      $show_screen Whether to show Screen Options tab.
		 *                               Default true.
		 * @param WP_Screen $this        Current WP_Screen instance.
		 */
		$this->_show_screen_options = RC_Hook::apply_filters( 'screen_options_show_screen', $show_screen, $this );
		return $this->_show_screen_options;
	}

	/**
	 * Render the screen options tab.
	 *
	 * @since 1.0.0
	 */
	public function render_screen_options() {
		global $wp_meta_boxes, $wp_list_table;

		$columns = self::get_column_headers( $this );
		$hidden  = self::get_hidden_columns( $this );
// 		$post    = get_post();

		?>

		<div class="screen-options-wrap" class="hidden" aria-label="<?php esc_attr_e('Screen Options Tab'); ?>"><!-- tabindex="-1" -->
		<form id="adv-settings" action="" method="post">
		<?php if ( isset( $wp_meta_boxes[ $this->id ] ) || $this->get_option( 'per_page' ) || ( $columns && empty( $columns['_title'] ) ) ) : ?>
			<h5><?php _e( '显示下列项目' ); ?></h5>
		<?php
		endif;

		if ( isset( $wp_meta_boxes[ $this->id ] ) ) : ?>
			<div class="metabox-prefs">
				<?php
					self::meta_box_prefs( $this );

					if ( 'dashboard' === $this->id && RC_Hook::has_action( 'welcome_panel' ) && current_user_can( 'edit_theme_options' ) ) {
						if ( isset( $_GET['welcome'] ) ) {
							$welcome_checked = empty( $_GET['welcome'] ) ? 0 : 1;
							update_user_meta( get_current_user_id(), 'show_welcome_panel', $welcome_checked );
						} else {
							$welcome_checked = get_user_meta( get_current_user_id(), 'show_welcome_panel', true );
							if ( 2 == $welcome_checked && wp_get_current_user()->user_email != get_option( 'admin_email' ) )
								$welcome_checked = false;
						}
						echo '<label for="wp_welcome_panel-hide">';
						echo '<input type="checkbox" id="wp_welcome_panel-hide"' . checked( (bool) $welcome_checked, true, false ) . ' />';
						echo _x( 'Welcome', 'Welcome panel' ) . "</label>\n";
					}
				?>
				<br class="clear" />
			</div>
			<?php endif;
			if ( $columns ) :
				if ( ! empty( $columns['_title'] ) ) : ?>
			<h5><?php echo $columns['_title']; ?></h5>
			<?php endif; ?>
			<div class="metabox-prefs">
				<?php
				$special = array('_title', 'cb', 'comment', 'media', 'name', 'title', 'username', 'blogname');

				foreach ( $columns as $column => $title ) {
					// Can't hide these for they are special
					if ( in_array( $column, $special ) )
						continue;
					if ( empty( $title ) )
						continue;

					if ( 'comments' == $column )
						$title = __( 'Comments' );
					$id = "$column-hide";
					echo '<label for="' . $id . '">';
					echo '<input class="hide-column-tog" name="' . $id . '" type="checkbox" id="' . $id . '" value="' . $column . '"' . checked( !in_array($column, $hidden), true, false ) . ' />';
					echo "$title</label>\n";
				}
				?>
				<br class="clear" />
			</div>
		<?php endif;

		$this->render_screen_layout();
		$this->render_per_page_options();
		echo $this->_screen_settings;

		?>
		<div><?php //wp_nonce_field( 'screen-options-nonce', 'screenoptionnonce', false ); ?></div>
		</form>
		</div>
		<?php
	}

	/**
	 * Render the option for number of columns on the page
	 *
	 * @since 1.0.0
	 */
	function render_screen_layout() {
		if ( ! $this->get_option('layout_columns') )
			return;

		$screen_layout_columns = $this->get_columns();
		$num = $this->get_option( 'layout_columns', 'max' );

		?>
		<h5 class="screen-layout"><?php _e('Screen Layout'); ?></h5>
		<div class='columns-prefs'><?php
			_e('Number of Columns:');
			for ( $i = 1; $i <= $num; ++$i ):
				?>
				<label class="columns-prefs-<?php echo $i; ?>">
					<input type='radio' name='screen_columns' value='<?php echo RC_Format::esc_attr( $i ); ?>'
						<?php checked( $screen_layout_columns, $i ); ?> />
					<?php echo RC_Format::esc_html( $i ); ?>
				</label>
				<?php
			endfor; ?>
		</div>
		<?php
	}

	/**
	 * Render the items per page option
	 *
	 * @since 1.0.0
	 */
	function render_per_page_options() {
		if ( ! $this->get_option( 'per_page' ) )
			return;

		$per_page_label = $this->get_option( 'per_page', 'label' );

// 		$per_page_button

		$option = $this->get_option( 'per_page', 'option' );
		if ( ! $option )
			$option = str_replace( '-', '_', "{$this->id}_per_page" );

// 		$per_page = (int) get_user_option( $option );
// 		if ( empty( $per_page ) || $per_page < 1 ) {
// 			$per_page = $this->get_option( 'per_page', 'default' );
// 			if ( ! $per_page )
// 				$per_page = 20;
// 		}


		$per_page = RC_Hook::apply_filters( $option, $per_page );


		?>
		<div class="screen-options">
			<?php if ( $per_page_label ) : ?>
				<input type="number" step="1" min="1" max="999" class="screen-per-page" name="wp_screen_options[value]"
					id="<?php echo RC_Format::esc_attr( $option ); ?>" maxlength="3"
					value="<?php echo RC_Format::esc_attr( $per_page ); ?>" />
				<label for="<?php echo RC_Format::esc_attr( $option ); ?>">
					<?php echo RC_Format::esc_html( $per_page_label ); ?>
				</label>
			<?php endif;
			echo ecjia_form::get_submit_button( __( '应用' ), 'btn', 'screen-options-apply', false ); ?>
			<input type='hidden' name='wp_screen_options[option]' value='<?php echo RC_Format::esc_attr($option); ?>' />
		</div>
		<?php
	}


	/**
	 * =================================================
	 * 静态操作方法
	 * =================================================
	 */
	public static $current_screen;

	/**
	 * Get the current screen object
	 *
	 * @since 1.0.0
	 *
	 * @return WP_Screen Current screen object
	 */
	public static function get_current_screen() {
	    if ( ! isset( self::$current_screen ) )
	        return null;

	    return self::$current_screen;
	}


	/**
	 * Set the current screen object
	 *
	 * @since 1.0.0
	 * @uses $current_screen
	 *
	 * @param mixed $hook_name Optional. The hook name (also known as the hook suffix) used to determine the screen,
	 *	or an existing screen object.
	 */
	public static function set_current_screen( $hook_name = '' ) {
	    self::get( $hook_name )->make_current_screen();
	}


	/**
	 * Register and configure an admin screen option
	 *
	 * @since 1.0.0
	 *
	 * @param string $option An option name.
	 * @param mixed $args Option-dependent arguments.
	 */
	public static function add_screen_option( $option, $args = array() ) {
	    $current_screen = self::get_current_screen();

	    if ( ! $current_screen )
	        return;

	    $current_screen->add_option( $option, $args );
	}


	/**
	 * Get Hidden Meta Boxes
	 *
	 * @since 1.0.0
	 *
	 * @param string|WP_Screen $screen Screen identifier
	 * @return array Hidden Meta Boxes
	 */
	public static function get_hidden_meta_boxes( $screen ) {
	    if ( is_string( $screen ) )
	        $screen = self::convert_to_screen( $screen );

	    $hidden = get_user_option( "metaboxhidden_{$screen->id}" );

	    $use_defaults = ! is_array( $hidden );

	    // Hide slug boxes by default
	    if ( $use_defaults ) {
	        $hidden = array();
	        if ( 'post' == $screen->base ) {
	            if ( 'post' == $screen->post_type || 'page' == $screen->post_type || 'attachment' == $screen->post_type )
	                $hidden = array('slugdiv', 'trackbacksdiv', 'postcustom', 'postexcerpt', 'commentstatusdiv', 'commentsdiv', 'authordiv', 'revisionsdiv');
	            else
	                $hidden = array( 'slugdiv' );
	        }

	        /**
	         * Filter the default list of hidden meta boxes.
	         *
	         * @since 3.1.0
	         *
	         * @param array     $hidden An array of meta boxes hidden by default.
	         * @param WP_Screen $screen WP_Screen object of the current screen.
	         */
	        $hidden = RC_Hook::apply_filters( 'default_hidden_meta_boxes', $hidden, $screen );
	    }

	    /**
	     * Filter the list of hidden meta boxes.
	     *
	     * @since 1.0.0
	     *
	     * @param array     $hidden       An array of hidden meta boxes.
	     * @param WP_Screen $screen       WP_Screen object of the current screen.
	     * @param bool      $use_defaults Whether to show the default meta boxes.
	     *                                Default true.
	     */
	    return RC_Hook::apply_filters( 'hidden_meta_boxes', $hidden, $screen, $use_defaults );
	}


	/**
	 * Prints the meta box preferences for screen meta.
	 *
	 * @since 1.0.0
	 *
	 * @param string|WP_Screen $screen
	 */
	public static function meta_box_prefs( $screen ) {
	    global $wp_meta_boxes;

	    if ( is_string( $screen ) )
	        $screen = self::convert_to_screen( $screen );

	    if ( empty($wp_meta_boxes[$screen->id]) )
	        return;

	    $hidden = self::get_hidden_meta_boxes($screen);

	    foreach ( array_keys($wp_meta_boxes[$screen->id]) as $context ) {
	        foreach ( array_keys($wp_meta_boxes[$screen->id][$context]) as $priority ) {
	            foreach ( $wp_meta_boxes[$screen->id][$context][$priority] as $box ) {
	                if ( false == $box || ! $box['title'] )
	                    continue;
	                // Submit box cannot be hidden
	                if ( 'submitdiv' == $box['id'] || 'linksubmitdiv' == $box['id'] )
	                    continue;
	                $box_id = $box['id'];
	                echo '<label for="' . $box_id . '-hide">';
	                echo '<input class="hide-postbox-tog" name="' . $box_id . '-hide" type="checkbox" id="' . $box_id . '-hide" value="' . $box_id . '"' . (! in_array($box_id, $hidden) ? ' checked="checked"' : '') . ' />';
	                echo "{$box['title']}</label>\n";
	            }
	        }
	    }
	}


	/**
	 * Convert a screen string to a screen object
	 *
	 * @since 1.0.0
	 *
	 * @param string $hook_name The hook name (also known as the hook suffix) used to determine the screen.
	 * @return WP_Screen Screen object.
	 */
	public static function convert_to_screen( $hook_name ) {
	    if ( ! class_exists( __CLASS__ ) ) {
	        _doing_it_wrong( 'convert_to_screen(), add_meta_box()', __( "Likely direct inclusion of wp-admin/includes/template.php in order to use add_meta_box(). This is very wrong. Hook the add_meta_box() call into the add_meta_boxes action instead." ), '3.3' );
	        return (object) array( 'id' => '_invalid', 'base' => '_are_belong_to_us' );
	    }

	    return self::get( $hook_name );
	}

	/**
	 * Get a list of hidden columns.
	 *
	 * @since 1.0.0
	 *
	 * @param string|WP_Screen $screen The screen you want the hidden columns for
	 * @return array
	 */
	public static function get_hidden_columns( $screen ) {
	    if ( is_string( $screen ) )
	        $screen = self::convert_to_screen( $screen );

// 	    return (array) get_user_option( 'manage' . $screen->id . 'columnshidden' );
	}


	/**
	 * Get the column headers for a screen
	 *
	 * @since 1.0.0
	 *
	 * @param string|ecjia_screen $screen The screen you want the headers for
	 * @return array Containing the headers in the format id => UI String
	 */
	public static function get_column_headers( $screen ) {
	    if ( is_string( $screen ) )
	        $screen = self::convert_to_screen( $screen );

	    static $column_headers = array();

	    if ( ! isset( $column_headers[ $screen->id ] ) ) {

	        /**
	         * Filter the column headers for a list table on a specific screen.
	         *
	         * The dynamic portion of the hook name, $screen->id, refers to the
	         * ID of a specific screen. For example, the screen ID for the Posts
	         * list table is edit-post, so the filter for that screen would be
	         * manage_edit-post_columns.
	         *
	         * @since 1.0.0
	         *
	         * @param array $columns An array of column headers. Default empty.
	         */
	        $column_headers[ $screen->id ] = RC_Hook::apply_filters( 'manage_' . $screen->id . '_columns', array() );
	    }

	    return $column_headers[ $screen->id ];
	}
}


// end
