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
 * 用户充值提现记录
 * @author royalwang
 */
class user_account_record_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	
    	if ($_SESSION['user_id'] <= 0) {
    		return new ecjia_error(100, 'Invalid session');
    	}
    	$size         = $this->requestData('pagination.count', 15);
    	$page         = $this->requestData('pagination.page', 1);
 		$user_id      = $_SESSION['user_id'];
 		$process_type = $this->requestData('type');
 		$type         = array('', 'deposit', 'raply');
		if (!in_array($process_type, $type)) {
			return new ecjia_error( 'invalid_parameter', RC_Lang::get ('system::system.invalid_parameter' ));
		}
		if (!$user_id) {
		    return new ecjia_error(100, 'Invalid session' );
		}
		
		$db = RC_DB::table('user_account')->where('user_id', $user_id);
		if (!empty($process_type)) {
			if ($process_type == 'deposit') {
				$db->where('process_type', SURPLUS_SAVE);
			} else {
				$db->where('process_type', SURPLUS_RETURN);
			}
		} else {
			$db->whereIn('process_type', array(SURPLUS_SAVE, SURPLUS_RETURN));
		}
		
 		/* 获取记录条数 */
		$record_count = $db->count();
		
 		//加载分页类
		RC_Loader::load_sys_class('ecjia_page', false);
		//实例化分页
		$page_row = new ecjia_page($record_count, $size, 6, '', $page);
 		
 		RC_Loader::load_app_func('admin_user' ,'user');

 		//获取余额记录
 		$account_log = get_account_log($user_id, $size, $page_row, $process_type);
 		
 		if (!empty($account_log) && is_array($account_log)) {
 			$account_list = array();
 			foreach ($account_log as $key => $value) {
				$account_list[$key]['account_id']	 = $value['id'];
				$account_list[$key]['order_sn']	 	 = $value['order_sn'];
				$account_list[$key]['user_id']		 = $value['user_id'];
				$account_list[$key]['admin_user']	 = $value['admin_user'];
				$account_list[$key]['amount']		 = $value['amount'];
				$account_list[$key]['format_amount'] = $value['format_amount'];
				$account_list[$key]['user_note']	 = $value['user_note'];
				$account_list[$key]['type']			 = $value['process_type'] == '0' ? 'deposit' : 'raply';
				$account_list[$key]['type_lable']	 = $value['type'];
				$account_list[$key]['payment_name']	 = (empty($value['payment']) && $value['process_type'] == '0') ? '管理员操作' : strip_tags($value['payment']);
				$account_list[$key]['payment_id']	 = $value['pid'];
				$account_list[$key]['is_paid']		 = $value['is_paid'];
				$account_list[$key]['pay_status']	 = $value['pay_status'];
				$account_list[$key]['add_time']		 = $value['add_time'];
				$account_list[$key]['real_amount']	 = $value['real_amount'];
				$account_list[$key]['formatted_real_amount'] = $value['formatted_real_amount'];
				$account_list[$key]['pay_fee']	 = $value['pay_fee'];
				$account_list[$key]['formatted_pay_fee'] = $value['formatted_pay_fee'];
 			}
 			
 			$pager = array(
 					"total" => $page_row->total_records,
 					"count" => $page_row->total_records,
 					"more"	=> $page_row->total_pages <= $page ? 0 : 1,
 			);
 			return array('data' => $account_list, 'pager' => $pager);
 		} else {
 			$pager = array(
 					"total" => $page_row->total_records,
 					"count" => $page_row->total_records,
 					"more"	=> $page_row->total_pages <= $page ? 0 : 1,
 			);
 			return array('data' => array(), 'pager' => $pager);
 		}
	}
}

// end