<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 用户注册字段
 * @author royalwang
 *
 */
class user_signupFields_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
		
    	$extend_info_list = RC_DB::table('reg_fields')->where('type', '<', 2)->where('display', 1)->where('id', '!=', 6)->orderBy('dis_order', 'asc')->orderBy('id', 'asc')->get();
    	
    	$out = array();
		foreach ($extend_info_list as $val) {
			$out[] = array(
					'id' => $val['id'],
					'name' => $val['reg_field_name'],
					'need' => $val['is_need']
			);
		}

		return $out;
	}
}


// end