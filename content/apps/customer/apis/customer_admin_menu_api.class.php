<?php

defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台客户菜单API
 * @author royalwang
 *
 */
class customer_admin_menu_api extends Component_Event_Api {

    public function call(&$options) {
        $menus = ecjia_admin::make_admin_menu('customer_manage', '客户管理', '', 0);

        $submenus = array(
            ecjia_admin::make_admin_menu('customer_manage', __('全部客户'), RC_Uri::url('customer/admin/init', array('menu' => 'all', 'status' => 'whole')), 0)->add_purview('customer_manage_all'),
            ecjia_admin::make_admin_menu('customer_list', __('我的客户'), RC_Uri::url('customer/admin/init'), 1)->add_purview('customer_manage'),
            ecjia_admin::make_admin_menu('customer_contact_list', __('联系记录'), RC_Uri::url('customer/admin_contact/init'), 2)->add_purview('customer_contact_list'),
            ecjia_admin::make_admin_menu('customer_contact_plan', __('回访计划'), RC_Uri::url('customer/admin_contact/contact_plan'), 3)->add_purview('customer_contact_plan'),
            ecjia_admin::make_admin_menu('customer_share_list', __('共享客户'), RC_Uri::url('customer/admin/share_list'), 4)->add_purview('customer_share_list'),
            ecjia_admin::make_admin_menu('customer_public_list', __('公共客户'), RC_Uri::url('customer/admin/public_list'), 5)->add_purview('customer_public_list'),
            ecjia_admin::make_admin_menu('divider', '', '', 6)->add_purview(array('customer_excel_upload', 'customer_type_list', 'customer_source_list', 'customer_contact_way_manage', 'customer_set')),
            ecjia_admin::make_admin_menu('customer_excel_upload', __('客户资料导入'), RC_Uri::url('customer/admin/excel_upload'), 7)->add_purview('customer_excel_upload'),
            ecjia_admin::make_admin_menu('customer_type_manage', __('客户类别管理'), RC_Uri::url('customer/admin_customer_type/init'), 8)->add_purview('customer_type_list'),
            ecjia_admin::make_admin_menu('customer_source_manage', __('客户来源管理'), RC_Uri::url('customer/admin_customer_source/init'), 9)->add_purview('customer_source_list'),
            ecjia_admin::make_admin_menu('customer_contact_way_manage', __('联系方式管理'), RC_Uri::url('customer/admin_contact/way_list'), 10)->add_purview('customer_contact_way_manage'),
            ecjia_admin::make_admin_menu('customer_set', __('客户设置'), RC_Uri::url('customer/admin_set/init'), 11)->add_purview('customer_set'),
        );

        $menus->add_submenu($submenus);
        //return $menus;
    }

}

// end