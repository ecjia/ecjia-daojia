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

/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/23
 * Time: 11:26
 */

namespace Ecjia\System\Frameworks\Component;


class Page
{

    /**
     * @var array
     */
    protected $menu = [];

    /**
     * @var array
     */
    protected $submenu = [];

    /**
     * @var array
     */
    protected $admin_page_hooks = [];

    /**
     * @var array
     */
    protected $_registered_pages = [];

    /**
     * @var array
     */
    protected $_parent_pages = [];

    //
    // Menu
    //

    /**
     * Add a top-level menu page.
     *
     * This function takes a capability which will be used to determine whether
     * or not a page is included in the menu.
     *
     * The function which is hooked in to handle the output of the page must check
     * that the user has the required capability as well.
     *
     * @global array $menu
     * @global array $admin_page_hooks
     * @global array $_registered_pages
     * @global array $_parent_pages
     *
     * @param string   $page_title The text to be displayed in the title tags of the page when the menu is selected.
     * @param string   $menu_title The text to be used for the menu.
     * @param string   $capability The capability required for this menu to be displayed to the user.
     * @param string   $menu_slug  The slug name to refer to this menu by. Should be unique for this menu page and only
     *                             include lowercase alphanumeric, dashes, and underscores characters to be compatible
     *                             with sanitize_key().
     * @param callable $function   The function to be called to output the content for this page.
     * @param string   $icon_url   The URL to the icon to be used for this menu.
     *                             * Pass a base64-encoded SVG using a data URI, which will be colored to match
     *                               the color scheme. This should begin with 'data:image/svg+xml;base64,'.
     *                             * Pass the name of a Dashicons helper class to use a font icon,
     *                               e.g. 'dashicons-chart-pie'.
     *                             * Pass 'none' to leave div.wp-menu-image empty so an icon can be added via CSS.
     * @param int      $position   The position in the menu order this one should appear.
     * @return string The resulting page's hook_suffix.
     */
    public function add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function = '', $icon_url = '', $position = null )
    {
        global $menu, $admin_page_hooks, $_registered_pages, $_parent_pages;

        $menu_slug = plugin_basename( $menu_slug );

        $admin_page_hooks[$menu_slug] = sanitize_title( $menu_title );

        $hookname = get_plugin_page_hookname( $menu_slug, '' );

        if ( !empty( $function ) && !empty( $hookname ) && current_user_can( $capability ) )
            add_action( $hookname, $function );

        if ( empty($icon_url) ) {
            $icon_url = 'dashicons-admin-generic';
            $icon_class = 'menu-icon-generic ';
        } else {
            $icon_url = set_url_scheme( $icon_url );
            $icon_class = '';
        }

        $new_menu = array( $menu_title, $capability, $menu_slug, $page_title, 'menu-top ' . $icon_class . $hookname, $hookname, $icon_url );

        if ( null === $position ) {
            $menu[] = $new_menu;
        } elseif ( isset( $menu[ "$position" ] ) ) {
            $position = $position + substr( base_convert( md5( $menu_slug . $menu_title ), 16, 10 ) , -5 ) * 0.00001;
            $menu[ "$position" ] = $new_menu;
        } else {
            $menu[ $position ] = $new_menu;
        }

        $_registered_pages[$hookname] = true;

        // No parent as top level
        $_parent_pages[$menu_slug] = false;

        return $hookname;
    }

    /**
     * Add a submenu page.
     *
     * This function takes a capability which will be used to determine whether
     * or not a page is included in the menu.
     *
     * The function which is hooked in to handle the output of the page must check
     * that the user has the required capability as well.
     *
     * @global array $submenu
     * @global array $menu
     * @global array $_wp_real_parent_file
     * @global bool  $_wp_submenu_nopriv
     * @global array $_registered_pages
     * @global array $_parent_pages
     *
     * @param string   $parent_slug The slug name for the parent menu (or the file name of a standard
     *                              WordPress admin page).
     * @param string   $page_title  The text to be displayed in the title tags of the page when the menu
     *                              is selected.
     * @param string   $menu_title  The text to be used for the menu.
     * @param string   $capability  The capability required for this menu to be displayed to the user.
     * @param string   $menu_slug   The slug name to refer to this menu by. Should be unique for this menu
     *                              and only include lowercase alphanumeric, dashes, and underscores characters
     *                              to be compatible with sanitize_key().
     * @param callable $function    The function to be called to output the content for this page.
     * @return false|string The resulting page's hook_suffix, or false if the user does not have the capability required.
     */
    public function add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function = '' )
    {
        global $submenu, $menu, $_wp_real_parent_file, $_wp_submenu_nopriv,
               $_registered_pages, $_parent_pages;

        $menu_slug = plugin_basename( $menu_slug );
        $parent_slug = plugin_basename( $parent_slug);

        if ( isset( $_wp_real_parent_file[$parent_slug] ) )
            $parent_slug = $_wp_real_parent_file[$parent_slug];

        if ( !current_user_can( $capability ) ) {
            $_wp_submenu_nopriv[$parent_slug][$menu_slug] = true;
            return false;
        }

        /*
         * If the parent doesn't already have a submenu, add a link to the parent
         * as the first item in the submenu. If the submenu file is the same as the
         * parent file someone is trying to link back to the parent manually. In
         * this case, don't automatically add a link back to avoid duplication.
         */
        if (!isset( $submenu[$parent_slug] ) && $menu_slug != $parent_slug ) {
            foreach ( (array)$menu as $parent_menu ) {
                if ( $parent_menu[2] == $parent_slug && current_user_can( $parent_menu[1] ) )
                    $submenu[$parent_slug][] = array_slice( $parent_menu, 0, 4 );
            }
        }

        $submenu[$parent_slug][] = array ( $menu_title, $capability, $menu_slug, $page_title );

        $hookname = get_plugin_page_hookname( $menu_slug, $parent_slug);
        if (!empty ( $function ) && !empty ( $hookname ))
            add_action( $hookname, $function );

        $_registered_pages[$hookname] = true;

        /*
         * Backward-compatibility for plugins using add_management page.
         * See wp-admin/admin.php for redirect from edit.php to tools.php
         */
        if ( 'tools.php' == $parent_slug )
            $_registered_pages[get_plugin_page_hookname( $menu_slug, 'edit.php')] = true;

        // No parent as top level.
        $_parent_pages[$menu_slug] = $parent_slug;

        return $hookname;
    }


    /**
     * Remove a top-level admin menu.
     *
     * @since 3.1.0
     *
     * @global array $menu
     *
     * @param string $menu_slug The slug of the menu.
     * @return array|bool The removed menu on success, false if not found.
     */
    public function remove_menu_page( $menu_slug )
    {
        global $menu;

        foreach ( $menu as $i => $item ) {
            if ( $menu_slug == $item[2] ) {
                unset( $menu[$i] );
                return $item;
            }
        }

        return false;
    }

    /**
     * Remove an admin submenu.
     *
     * @since 3.1.0
     *
     * @global array $submenu
     *
     * @param string $menu_slug    The slug for the parent menu.
     * @param string $submenu_slug The slug of the submenu.
     * @return array|bool The removed submenu on success, false if not found.
     */
    public function remove_submenu_page( $menu_slug, $submenu_slug )
    {
        global $submenu;

        if ( !isset( $submenu[$menu_slug] ) )
            return false;

        foreach ( $submenu[$menu_slug] as $i => $item ) {
            if ( $submenu_slug == $item[2] ) {
                unset( $submenu[$menu_slug][$i] );
                return $item;
            }
        }

        return false;
    }

    /**
     * Get the url to access a particular menu page based on the slug it was registered with.
     *
     * If the slug hasn't been registered properly no url will be returned
     *
     * @since 3.0.0
     *
     * @global array $_parent_pages
     *
     * @param string $menu_slug The slug name to refer to this menu by (should be unique for this menu)
     * @param bool $echo Whether or not to echo the url - default is true
     * @return string the url
     */
    public function menu_page_url($menu_slug, $echo = true)
    {
        global $_parent_pages;

        if ( isset( $_parent_pages[$menu_slug] ) ) {
            $parent_slug = $_parent_pages[$menu_slug];
            if ( $parent_slug && ! isset( $_parent_pages[$parent_slug] ) ) {
                $url = admin_url( add_query_arg( 'page', $menu_slug, $parent_slug ) );
            } else {
                $url = admin_url( 'admin.php?page=' . $menu_slug );
            }
        } else {
            $url = '';
        }

        $url = esc_url($url);

        if ( $echo )
            echo $url;

        return $url;
    }

    //
    // Pluggable Menu Support -- Private
    //
    /**
     *
     * @global string $parent_file
     * @global array $menu
     * @global array $submenu
     * @global string $pagenow
     * @global string $typenow
     * @global string $plugin_page
     * @global array $_wp_real_parent_file
     * @global array $_wp_menu_nopriv
     * @global array $_wp_submenu_nopriv
     */
    public function get_admin_page_parent( $parent = '' ) {
        global $parent_file, $menu, $submenu, $pagenow, $typenow,
               $plugin_page, $_wp_real_parent_file, $_wp_menu_nopriv, $_wp_submenu_nopriv;

        if ( !empty ( $parent ) && 'admin.php' != $parent ) {
            if ( isset( $_wp_real_parent_file[$parent] ) )
                $parent = $_wp_real_parent_file[$parent];
            return $parent;
        }

        if ( $pagenow == 'admin.php' && isset( $plugin_page ) ) {
            foreach ( (array)$menu as $parent_menu ) {
                if ( $parent_menu[2] == $plugin_page ) {
                    $parent_file = $plugin_page;
                    if ( isset( $_wp_real_parent_file[$parent_file] ) )
                        $parent_file = $_wp_real_parent_file[$parent_file];
                    return $parent_file;
                }
            }
            if ( isset( $_wp_menu_nopriv[$plugin_page] ) ) {
                $parent_file = $plugin_page;
                if ( isset( $_wp_real_parent_file[$parent_file] ) )
                    $parent_file = $_wp_real_parent_file[$parent_file];
                return $parent_file;
            }
        }

        if ( isset( $plugin_page ) && isset( $_wp_submenu_nopriv[$pagenow][$plugin_page] ) ) {
            $parent_file = $pagenow;
            if ( isset( $_wp_real_parent_file[$parent_file] ) )
                $parent_file = $_wp_real_parent_file[$parent_file];
            return $parent_file;
        }

        foreach (array_keys( (array)$submenu ) as $parent) {
            foreach ( $submenu[$parent] as $submenu_array ) {
                if ( isset( $_wp_real_parent_file[$parent] ) )
                    $parent = $_wp_real_parent_file[$parent];
                if ( !empty($typenow) && ($submenu_array[2] == "$pagenow?post_type=$typenow") ) {
                    $parent_file = $parent;
                    return $parent;
                } elseif ( $submenu_array[2] == $pagenow && empty($typenow) && ( empty($parent_file) || false === strpos($parent_file, '?') ) ) {
                    $parent_file = $parent;
                    return $parent;
                } elseif ( isset( $plugin_page ) && ($plugin_page == $submenu_array[2] ) ) {
                    $parent_file = $parent;
                    return $parent;
                }
            }
        }

        if ( empty($parent_file) )
            $parent_file = '';
        return '';
    }

    /**
     *
     * @global string $title
     * @global array $menu
     * @global array $submenu
     * @global string $pagenow
     * @global string $plugin_page
     * @global string $typenow
     */
    public function get_admin_page_title() {
        global $title, $menu, $submenu, $pagenow, $plugin_page, $typenow;

        if ( ! empty ( $title ) )
            return $title;

        $hook = get_plugin_page_hook( $plugin_page, $pagenow );

        $parent = $parent1 = get_admin_page_parent();

        if ( empty ( $parent) ) {
            foreach ( (array)$menu as $menu_array ) {
                if ( isset( $menu_array[3] ) ) {
                    if ( $menu_array[2] == $pagenow ) {
                        $title = $menu_array[3];
                        return $menu_array[3];
                    } elseif ( isset( $plugin_page ) && ($plugin_page == $menu_array[2] ) && ($hook == $menu_array[3] ) ) {
                        $title = $menu_array[3];
                        return $menu_array[3];
                    }
                } else {
                    $title = $menu_array[0];
                    return $title;
                }
            }
        } else {
            foreach ( array_keys( $submenu ) as $parent ) {
                foreach ( $submenu[$parent] as $submenu_array ) {
                    if ( isset( $plugin_page ) &&
                        ( $plugin_page == $submenu_array[2] ) &&
                        (
                            ( $parent == $pagenow ) ||
                            ( $parent == $plugin_page ) ||
                            ( $plugin_page == $hook ) ||
                            ( $pagenow == 'admin.php' && $parent1 != $submenu_array[2] ) ||
                            ( !empty($typenow) && $parent == $pagenow . '?post_type=' . $typenow)
                        )
                    ) {
                        $title = $submenu_array[3];
                        return $submenu_array[3];
                    }

                    if ( $submenu_array[2] != $pagenow || isset( $_GET['page'] ) ) // not the current page
                        continue;

                    if ( isset( $submenu_array[3] ) ) {
                        $title = $submenu_array[3];
                        return $submenu_array[3];
                    } else {
                        $title = $submenu_array[0];
                        return $title;
                    }
                }
            }
            if ( empty ( $title ) ) {
                foreach ( $menu as $menu_array ) {
                    if ( isset( $plugin_page ) &&
                        ( $plugin_page == $menu_array[2] ) &&
                        ( $pagenow == 'admin.php' ) &&
                        ( $parent1 == $menu_array[2] ) )
                    {
                        $title = $menu_array[3];
                        return $menu_array[3];
                    }
                }
            }
        }

        return $title;
    }

    /**
     * @since 2.3.0
     *
     * @param string $plugin_page
     * @param string $parent_page
     * @return string|null
     */
    public function get_plugin_page_hook( $plugin_page, $parent_page ) {
        $hook = get_plugin_page_hookname( $plugin_page, $parent_page );
        if ( has_action($hook) )
            return $hook;
        else
            return null;
    }

    /**
     *
     * @global array $admin_page_hooks
     * @param string $plugin_page
     * @param string $parent_page
     */
    public function get_plugin_page_hookname( $plugin_page, $parent_page ) {
        global $admin_page_hooks;

        $parent = get_admin_page_parent( $parent_page );

        $page_type = 'admin';
        if ( empty ( $parent_page ) || 'admin.php' == $parent_page || isset( $admin_page_hooks[$plugin_page] ) ) {
            if ( isset( $admin_page_hooks[$plugin_page] ) ) {
                $page_type = 'toplevel';
            } elseif ( isset( $admin_page_hooks[$parent] )) {
                $page_type = $admin_page_hooks[$parent];
            }
        } elseif ( isset( $admin_page_hooks[$parent] ) ) {
            $page_type = $admin_page_hooks[$parent];
        }

        $plugin_name = preg_replace( '!\.php!', '', $plugin_page );

        return $page_type . '_page_' . $plugin_name;
    }


}