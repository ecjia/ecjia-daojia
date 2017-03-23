<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 后台文章菜单API
 * @author royalwang
 *
 */
class comment_admin_menu_api extends Component_Event_Api {

    public function call(&$options) {
        $menus = ecjia_admin::make_admin_menu('05_comment_manage', RC_Lang::get('comment::comment_manage.comment_manage'), '', 8);
        $submenus = array(
            ecjia_admin::make_admin_menu('01_goods_comment', RC_Lang::get('comment::comment_manage.goods_comment'), RC_Uri::url('comment/admin/init', array('list' => 1)), 1)->add_purview('comment_manage'),
            ecjia_admin::make_admin_menu('04_comment_trash', __('评论回收站'), RC_Uri::url('comment/admin/trash', array('list' => 2)), 4)->add_purview('comment_manage'),
        	ecjia_admin::make_admin_menu('04_comment_trash', __('申诉列表'), RC_Uri::url('comment/appeal/init'), 5)->add_purview('appeal_manage'),
        );
        $menus->add_submenu($submenus);
        return $menus;
    }
}

// end