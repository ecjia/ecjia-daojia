<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/23
 * Time: 11:45
 */

namespace Ecjia\System\Frameworks\Component\Pages;

use Ecjia\System\Frameworks\Component\Page;

class CommentsPage extends Page
{

    /**
     * Add submenu page to the Comments main menu.
     *
     * This function takes a capability which will be used to determine whether
     * or not a page is included in the menu.
     *
     * The function which is hooked in to handle the output of the page must check
     * that the user has the required capability as well.
     *
     * @param string   $page_title The text to be displayed in the title tags of the page when the menu is selected.
     * @param string   $menu_title The text to be used for the menu.
     * @param string   $capability The capability required for this menu to be displayed to the user.
     * @param string   $menu_slug  The slug name to refer to this menu by (should be unique for this menu).
     * @param callable $function   The function to be called to output the content for this page.
     * @return false|string The resulting page's hook_suffix, or false if the user does not have the capability required.
     */
    public function add_comments_page( $page_title, $menu_title, $capability, $menu_slug, $function = '' )
    {
        return $this->add_submenu_page( 'edit-comments.php', $page_title, $menu_title, $capability, $menu_slug, $function );
    }

}