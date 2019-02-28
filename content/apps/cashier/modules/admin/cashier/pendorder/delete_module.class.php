<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 收银台挂单删除
 * @author zrl
 * 
 */
class admin_cashier_pendorder_delete_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

		$this->authadminSession();
        if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }
		
	    $pendorder_id = $this->requestData('pendorder_id', 0);
	   
	    if (empty($pendorder_id)) {
	        return new ecjia_error('invalid_parameter', __('参数错误', 'cashier'));
	    }
	    
	   	$pendorder_info = RC_DB::table('cashier_pendorder')->where('pendorder_id', $pendorder_id)->first();
	   	if (empty($pendorder_info)) {
	   		return new ecjia_error('penorder_not_exist', __('挂单信息不存在！', 'cashier'));
	   	}
	   	
	    if ($pendorder_info['cashier_user_id'] != $_SESSION['staff_id']) {
	    	return new ecjia_error('no_previllege', __('您没权限执行此操作！', 'cashier'));
	    }
	    
	    $rec_ids = RC_DB::table('cart')->where('pendorder_id', $pendorder_id)->lists('rec_id');
	    
	    RC_DB::table('cashier_pendorder')->where('pendorder_id', $pendorder_id)->delete();
	    RC_DB::table('cart')->whereIn('rec_id', $rec_ids)->delete();
	    
	    return array();
	}
	
}

// end