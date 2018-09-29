<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 用户注册字段
 * @author royalwang
 *
 */
class user_signupFields_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
		
		$db = RC_Loader::load_app_model('reg_fields_model','user');

		$extend_info_list = $db->where(array('type' => array('lt' => 2), 'display' => '1', 'id' => array('neq' => 6)))->order(array('dis_order' => 'asc' , 'id' => 'asc'))->select();
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