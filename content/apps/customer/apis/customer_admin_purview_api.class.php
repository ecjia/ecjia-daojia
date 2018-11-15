<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 客户后台权限API
 *
 */
class customer_admin_purview_api extends Component_Event_Api {
     
    public function call(&$options) {
        $purviews = array(
            array('action_name' => __('全部客户(高)'), 'action_code' => 'customer_manage_all', 'relevance'   => ''),
            array('action_name' => __('客户导出(高)'), 'action_code' => 'customer_excel_export', 'relevance'   => ''),
            array('action_name' => __('批量指派客户(高)'), 'action_code' => 'customer_assign_batch', 'relevance'=> ''),
            array('action_name' => __('客户类别列表(高)'), 'action_code' => 'customer_type_list', 'relevance'=> ''),
            array('action_name' => __('客户类别添加(高)'), 'action_code' => 'customer_type_add', 'relevance'=> ''),
            array('action_name' => __('客户类别编辑(高)'), 'action_code' => 'customer_type_edit', 'relevance'=> ''),
            array('action_name' => __('客户类别删除(高)'), 'action_code' => 'customer_type_del', 'relevance'=> ''),
            array('action_name' => __('客户类别批量删除(高)'), 'action_code' => 'customer_type_batch', 'relevance'=> ''),
            
            array('action_name' => __('客户来源列表(高)'), 'action_code' => 'customer_source_list', 'relevance'=> ''),
            array('action_name' => __('客户来源添加(高)'), 'action_code' => 'customer_source_add', 'relevance'=> ''),
            array('action_name' => __('客户来源编辑(高)'), 'action_code' => 'customer_source_edit', 'relevance'=> ''),
            array('action_name' => __('客户来源删除(高)'), 'action_code' => 'customer_source_del', 'relevance'=> ''),
            array('action_name' => __('客户来源批量删除(高)'), 'action_code' => 'customer_source_batch', 'relevance'=> ''),
            
            array('action_name' => __('更换营销顾问(高)'), 'action_code' => 'binding_adviser', 'relevance'=> ''),
            array('action_name' => __('客户设置(高)'), 'action_code' => 'customer_set', 'relevance'   => ''),
            
        	array('action_name' => __('我的客户'), 'action_code' => 'customer_manage', 'relevance'   => ''),
            array('action_name' => __('客户添加'), 'action_code' => 'customer_add', 'relevance'   => ''),
        	array('action_name' => __('客户编辑'), 'action_code' => 'customer_update', 'relevance'   => ''),
        	array('action_name' => __('客户删除'), 'action_code' => 'customer_del', 'relevance'=> ''),
            array('action_name' => __('客户还原'), 'action_code' => 'customer_reback', 'relevance'=> ''), 
        	array('action_name' => __('放弃客户'), 'action_code' => 'customer_quit', 'relevance'=> ''),
        	array('action_name' => __('共享客户'), 'action_code' => 'customer_share', 'relevance'=> ''),
        	array('action_name' => __('查看客户详情'), 'action_code' => 'customer_check', 'relevance'=> ''),
        	
        		
        	array('action_name' => __('所属类别批量修改'), 'action_code' => 'customer_type_update_batch', 'relevance'=> ''),
        	array('action_name' => __('所属来源批量修改'), 'action_code' => 'customer_source_update_batch', 'relevance'=> ''),
        	
        	array('action_name' => __('批量共享客户'), 'action_code' => 'customer_share_batch', 'relevance'=> ''),
        	array('action_name' => __('批量放弃客户'), 'action_code' => 'customer_quit_batch', 'relevance'=> ''),
        	array('action_name' => __('批量删除客户'), 'action_code' => 'customer_del_batch', 'relevance'=> ''),

        	array('action_name' => __('回访计划列表'), 'action_code' => 'customer_contact_plan', 'relevance'=> ''),
        		
        	array('action_name' => __('联系记录列表'), 'action_code' => 'customer_contact_list', 'relevance'=> ''),
        	array('action_name' => __('编辑联系记录'), 'action_code' => 'customer_contact_edit', 'relevance'=> ''),
        	array('action_name' => __('删除联系记录'), 'action_code' => 'customer_contact_del', 'relevance'=> ''),
        	array('action_name' => __('批量删除联系记录'), 'action_code' => 'customer_contact_del_batch', 'relevance'=> ''),
        	
        	array('action_name' => __('编辑联系人'), 'action_code' => 'customer_linkman_edit', 'relevance'=> ''),
        	array('action_name' => __('删除联系人'), 'action_code' => 'customer_linkman_del', 'relevance'=> ''),

        	array('action_name' => __('添加客户合同'), 'action_code' => 'customer_files_add', 'relevance'=> ''),
        	array('action_name' => __('编辑客户合同'), 'action_code' => 'customer_files_edit', 'relevance'=> ''),
        	array('action_name' => __('删除客户合同'), 'action_code' => 'customer_files_del', 'relevance'=> ''),
        		
            array('action_name' => __('共享客户列表'), 'action_code' => 'customer_share_list', 'relevance'   => ''),
            array('action_name' => __('公共客户列表'), 'action_code' => 'customer_public_list', 'relevance'   => ''),
            array('action_name' => __('客户领用'), 'action_code' => 'customer_get', 'relevance'   => ''),
            array('action_name' => __('客户导入'), 'action_code' => 'customer_excel_upload', 'relevance'   => ''),
        		
        	array('action_name' => __('联系方式管理'), 'action_code' => 'customer_contact_way_manage', 'relevance'   => ''),
        	array('action_name' => __('添加联系方式'), 'action_code' => 'contact_way_add', 'relevance'   => ''),
        	array('action_name' => __('更新联系方式'), 'action_code' => 'contact_way_update', 'relevance'   => ''),
        	array('action_name' => __('删除联系方式'), 'action_code' => 'contact_way_delete', 'relevance'   => ''),
        		
        	
        		
        );
        
//         return $purviews;
    }
}

// end