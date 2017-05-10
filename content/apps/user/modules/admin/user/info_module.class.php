<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 用户信息
 * @author royalwang
 *
 */
class info_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
		$this->authadminSession();
		
		if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
		    return new ecjia_error(100, 'Invalid session');
		}
		
		$user_id = $this->requestData('user_id', 0);
		$mobile	 = $this->requestData('mobile');
		if (empty($user_id) && empty($mobile)) {
			return new ecjia_error(101, '错误的参数提交');
		}
		
		RC_Loader::load_app_func('admin_user', 'user');
		$user_info = EM_user_info($user_id);
		
		return $user_info;
	}
}

// end