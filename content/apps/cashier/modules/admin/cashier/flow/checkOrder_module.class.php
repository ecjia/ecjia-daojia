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
 * 收银台添加购物流
 * @author zrl
 *
 */
class admin_cashier_flow_checkOrder_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

		$this->authadminSession();
        if ($_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }
        
        RC_Loader::load_app_class('cart', 'cart', false);
        
        $device = $this->device;
		RC_Loader::load_app_func('global','cart');
		RC_Loader::load_app_func('admin_order','orders');
		RC_Loader::load_app_func('admin_bonus','bonus');
		$db_cart = RC_Loader::load_app_model('cart_model', 'cart');
		
		RC_Loader::load_app_class('cart_cashdesk', 'cart', false);
		
		$api_version = $this->request->header('api-version');
		
		//从移动端接收数据
		$addgoods		= $this->requestData('addgoods');		//添加商品
		$updategoods	= $this->requestData('updategoods');	//更新商品数量
		$deletegoods	= $this->requestData('deletegoods');	//删除商品
		$user			= $this->requestData('user');			//选择用户
		$pendorder_id   = $this->requestData('pendorder_id', '0');	//挂单id
		
		/*收银台商品购物车类型*/
		$flow_type = CART_CASHDESK_GOODS;
		
		if (!empty($pendorder_id) && empty($user['user_id'])) {
			$user_id = RC_DB::table('cart')->where('pendorder_id', $pendorder_id)->lists('user_id');
			$user_id = array_unique($user_id);
			if (count($user_id) == 1) {
				$user['user_id'] = $user_id['0'];
			}
		}
		
// 		$addgoods = array(
// 			'goods_sn' 	=> 'ECS001314',
// 			'goods_sn'	=> 'ECS000412',
// 			'number'	=> 3,
// 			'number'	=> 1,
// 			'goods_sn'	=> '2184879005477',
// 			'goods_sn'	=> '289036800150005863',
// 			'weight'	=> 1500,
// 			'price'		=> 20.47
// 		);
// 		$user = array(
// 				'user_id' => '1024',
// 		);
		
		//有添加用户
		if ($user['user_id'] > 0) {
			$result = $this->_processAddUser($user, $api_version, $pendorder_id, $device, $_SESSION['store_id']);
		}
		
		//有添加商品
		if (!empty($addgoods['goods_sn'])) {
			$result = $this->_processAddgoods($addgoods, $_SESSION['store_id'], $pendorder_id, $flow_type);
		}
		//编辑购物车商品
		if (!empty($updategoods)) {
			$result = cart_cashdesk::flow_update_cart(array($updategoods['rec_id'] => $updategoods['number']));
		}
		//删除购物车商品
		if (!empty($deletegoods['rec_id'])) {
			$result = $this->deletecart($deletegoods, $pendorder_id);
		}
		
		if (is_ecjia_error($result)) {
		    return $result;
		}
		
		
		/* 对商品信息赋值 */
		$cart_goods = cart_cashdesk::cashdesk_cart_goods($flow_type, array(), $pendorder_id); // 取得商品列表，计算合计
		if (!empty($cart_goods)) {
			foreach ($cart_goods as $row) {
				$cart_ids[] = $row['rec_id'];
			}
		}
		/* 取得订单信息*/
		$order = cart_cashdesk::flow_order_info();
		/* 计算订单的费用 */
		$total = cart_cashdesk::cashdesk_order_fee($order, $cart_goods,  array(), $cart_ids, CART_CASHDESK_GOODS, $pendorder_id, $_SESSION['store_id']);
		
		$out = array();
		$out['user_info'] = array();
		if (!empty($_SESSION['user_id'])) {
			$user_info = user_info($_SESSION['user_id']);
			if (is_ecjia_error($user_info)) {
				return $user_info;
			}
			$out['user_info'] = array(
					'user_id'	=> intval($user_info['user_id']),
					'user_name'	=> $user_info['user_name'],
					'mobile'	=> $user_info['mobile_phone'],
					'integral'	=> intval($user_info['pay_points']),
			);
		}
		
		$out['goods_list']		= $cart_goods;		//商品
		/* 如果使用积分，取得用户可用积分及本订单最多可以使用的积分 */
		$rec_ids = array();
		/*会员价处理*/
		if (!empty($cart_goods)) {
			RC_Loader::load_app_class('goods_info', 'goods', false);
			foreach ($cart_goods as $k => $v) {
				$rec_ids[] = $v['rec_id'];
			}
		}
		
		if ((ecjia::config('use_integral') == '1') && $_SESSION['user_id'] > 0 && $user_info['pay_points'] > 0
		&& ($flow_type != CART_GROUP_BUY_GOODS && $flow_type != CART_EXCHANGE_GOODS))
		{
			// 能使用积分
			$allow_use_integral = 1;
			$order_max_integral = cart::flow_available_points($rec_ids, $flow_type);
		} else {
			$allow_use_integral = 0;
			$order_max_integral = 0;
		}
		
		$out['allow_use_integral'] = $allow_use_integral;//积分 是否使用积分
		$out['order_max_integral'] = $order_max_integral;//订单最大可使用积分
		/* 如果使用红包，取得用户可以使用的红包及用户选择的红包 */
		$allow_use_bonus = 0;
		$bonus_list = [];
		if ((ecjia::config('use_bonus') == '1') && ($flow_type != CART_GROUP_BUY_GOODS && $flow_type != CART_EXCHANGE_GOODS)){
			// 取得用户可用红包
			$user_bonus = user_bonus($_SESSION['user_id'], $total['goods_price'], array(), $_SESSION['store_id']);
			$bonus_list = $this->user_bonus_data_handle($user_bonus);
			// 能使用红包
			$allow_use_bonus = 1;
		}
		$out['allow_use_bonus'] = $allow_use_bonus;//是否使用红包
		$out['bonus_list'] 		= $bonus_list;//红包
		$out['your_integral']	= $user_info['pay_points'];//用户可用积分
		
		$out['discount']		= number_format($total['discount'], 2, '.', '');//用户享受折扣数
		$out['discount_formated'] = $total['discount_formated'];

		//当前收银员挂单数量
		$pendorder_count = RC_DB::table('cashier_pendorder')->where('store_id', $_SESSION['store_id'])->where('cashier_user_id', $_SESSION['staff_id'])->count();
		$out['pendorder_count'] = empty($pendorder_count) ? 0 : $pendorder_count;
					
		if (!empty($out['goods_list'])) {
			foreach ($out['goods_list'] as $key => $value) {
				if (!empty($value['goods_attr'])) {
					$goods_attr = explode("\n", $value['goods_attr']);
					$goods_attr = array_filter($goods_attr);
					$out['goods_list'][$key]['goods_attr'] = array();
					foreach ($goods_attr as  $v) {
						$a = explode(':',$v);
						if (!empty($a[0]) && !empty($a[1])) {
							$out['goods_list'][$key]['goods_attr'][] = array('name' => $a[0], 'value' => $a[1]);
						}
					}
				}
			}
		}
		return $out;
	}	
	
	//删除购物车商品(购物车可以批量删除)
	private function deletecart($deletegoods, $pendorder_id = 0){
		$rec_id = explode(',', $deletegoods['rec_id']);
		RC_DB::table('cart')->whereIn('rec_id', $rec_id)->delete();
		if (!empty($pendorder_id)) {
			RC_Loader::load_app_class('pendorder', 'cashier', false);
			$count = pendorder::pendorder_goods_count($pendorder_id);
			if ($count == 0) {
				pendorder::delete_pendorder($pendorder_id);
			}
		}
	}
	
	/**
	 * 有添加用户相关数据更新
	 */
	private function _processAddUser($user = array(), $api_version = '', $pendorder_id = 0, $device = array(), $store_id = 0)
	{
		if (!empty($user['user_id'])) {
			$pendorder_id = empty($pendorder_id) ? 0 : $pendorder_id;
			$user_id = (empty($user['user_id']) || !isset($user['user_id'])) ? 0 : $user['user_id'];
			if ($user_id > 0) {
				//判断用户有没申请注销
				if (version_compare($api_version, '1.25', '>=')) {
					$account_status = Ecjia\App\User\Users::UserAccountStatus($user_id);
					if ($account_status == Ecjia\App\User\Users::WAITDELETE) {
						return new ecjia_error('account_status_error', __('当前账号已申请注销，不可执行此操作！', 'cashier'));
					}
				}
		
				$_SESSION['cashdesk_temp_user_id']	= $user_id;
				$_SESSION['user_id']		= $user_id;
				
				$dbcart_updateuser = RC_DB::table('cart');
				if (!empty($pendorder_id)) {
					//有添加用户且是挂单结算；更新挂单购物车user_id
					$dbcart_updateuser->where('pendorder_id', $pendorder_id);
				} else {
					$dbcart_updateuser->where('user_id', 0);
				}
				
				$dbcart_updateuser->where('store_id', $store_id)->where('rec_type', CART_CASHDESK_GOODS)->update(array('user_id' => $user_id));
		
				$user_info = user_info($user_id);
		
				if ($user_info) {
					/* 取得用户等级和折扣 */
					if ($user_info['user_rank'] == 0) {
						//重新计算会员等级
						$row_rank = RC_Api::api('user', 'update_user_rank', array('user_id' => $user_id));
					} else {
						$row_rank = RC_DB::table('user_rank')->where('rank_id', $user_info['user_rank'])->first();
					}
						
					if ($row_rank) {
						$_SESSION['user_rank']	= $row_rank['rank_id'];
						$_SESSION['discount']	= $row_rank['discount'] / 100.00;
					} else {
						$_SESSION['user_rank']	= 0;
						$_SESSION['discount']	= 1;
					}
				}
			} else {
				unset($_SESSION['cashdesk_temp_user_id']);
				unset($_SESSION['user_id']);
				$_SESSION['user_rank']	= 0;
				$_SESSION['discount']	= 1;
			}
			cart_cashdesk::recalculate_price($device, $store_id, $user_id);
		}
	}
	
	/**
	 * 有添加商品货号
	 */
	private function _processAddgoods($addgoods = array(), $store_id = 0, $pendorder_id = 0, $flow_type = CART_CASHDESK_GOODS)
	{
		$goods_spec = array();
			
		//商品区分
		$goods_sn = trim($addgoods['goods_sn']);
		$pre = substr($goods_sn, 0, 1);
		
		if ($pre == '2') {
			//是否是散装商品处理
			$bulkGoodsResult = $this->_judgeIsBulkGoods($addgoods, $goods_sn, $store_id);
			$addgoods['goods_sn']	= $bulkGoodsResult['goods_sn'];
			$addgoods['price'] 		= $bulkGoodsResult['price'];
			$addgoods['weight'] 	= $bulkGoodsResult['weight'];
		}
			
		$products_goods	  = RC_DB::table('products')->where('product_sn', trim($addgoods['goods_sn']))->first();
		if (!empty($products_goods)) {
			$goods_spec = explode('|', $products_goods['goods_attr']);
			$goods = RC_DB::table('goods')->where('goods_id', $products_goods['goods_id'])->where('store_id', $store_id)->where('is_on_sale', 1)->where('is_delete', 0)->first();
		} else {
			$goods = RC_DB::table('goods')->where('goods_sn', trim($addgoods['goods_sn']))->where('store_id', $store_id)->where('is_on_sale', 1)->where('is_delete', 0)->first();
		}
		if (empty($goods)) {
			return new ecjia_error('addgoods_error', __('该商品不存在或已下架', 'cashier'));
		}
		//该商品对应店铺是否被锁定
		if (!empty($goods['goods_id'])) {
			$store_id 		= Ecjia\App\Cart\StoreStatus::GetStoreId($goods['goods_id']);
			$store_status 	= Ecjia\App\Cart\StoreStatus::GetStoreStatus($store_id);
			if ($store_status == Ecjia\App\Cart\StoreStatus::LOCKED) {
				return new ecjia_error('store_locked', __('对不起，该商品所属的店铺已锁定！', 'cashier'));
			}
		}
			
		$result = cart_cashdesk::addto_cart($goods['goods_id'], $addgoods['number'], $goods_spec, 0, strlen($addgoods['goods_sn']) == 7 ? $addgoods['price'] : 0, strlen($addgoods['goods_sn']) == 7 ? $addgoods['weight'] : 0, $flow_type, $pendorder_id);
		//挂单继续添加商品
		if (!empty($pendorder_id) && !empty($result)) {
			RC_DB::table('cart')->where('rec_id', $result)->update(array('pendorder_id' => $pendorder_id));
		}
		if (is_ecjia_error($result)) {
			return $result;
		}
	}
	
	
	/**
	 * 是否是散装商品判断，并返回散装商品信息
	 */
	private function _judgeIsBulkGoods($addgoods, $goods_sn, $store_id)
	{
		$bulk_goods_sn = substr($goods_sn, 0, 7);
		$bulk_goods_info = RC_DB::table('goods')->where('store_id', $store_id)->where('is_on_sale', 1)->where('is_delete', 0)->where('goods_sn', $bulk_goods_sn)->first();
		if ($bulk_goods_info['extension_code'] == 'bulk') {
			$addgoods['goods_sn'] = $bulk_goods_sn;
			$scale_sn = substr($goods_sn, 0, 2);
				
			$cashier_scales_info = cart_cashdesk::get_scales_info(array('store_id' =>$store_id, 'scale_sn' => $scale_sn));
			$goods_sn_length = strlen($goods_sn);
			if ($goods_sn_length == '13') {
				$string = substr($goods_sn, 0, 12);
				$string = substr($string, -5);
				$string = preg_replace('/^0*/', '', $string);
				if ($cashier_scales_info['barcode_mode'] == '1') {
					//金额模式
					$price_string = $string/100;
					$addgoods['price'] =  $price_string;
				} elseif ($cashier_scales_info['barcode_mode'] == '2') {
					//重量模式
					$addgoods['weight'] =  $string;
				}
			} elseif ($goods_sn_length == '18' && $cashier_scales_info['barcode_mode'] == '3') {
				//重量模式+金额模式
				$string = substr($goods_sn, 0, 17);//去除最后一位校验码
				//重量码
				$weight_string = substr($string, -5);
				$weight_string = preg_replace('/^0*/', '', $weight_string);
				$addgoods['weight'] =  $weight_string;
				//金额码
				$string = substr($string, -10);  //金额码 + 重量码
				$string = substr($string, 0, 5); //金额码
				$string = preg_replace('/^0*/', '', $string); //去除前面的0
				$price_string = $string/100;
				$addgoods['price'] =  $price_string;
			}
		} else {
			$addgoods['goods_sn'] = $goods_sn;
		}
		return $addgoods;
	}
	
	
	/**
	 * 用户可用红包数据处理
	 */
	private function user_bonus_data_handle($user_bonus)
	{
		$bonus_list = [];
		if (!empty($user_bonus)) {
			foreach ($user_bonus AS $key => $val) {
				$bonus_list[] = [
					'bonus_id' 					=> intval($val['bonus_id']),	
					'bonus_sn'					=> empty($val['bonus_sn']) ? '' : trim($val['bonus_sn']),
					'bonus_name'				=> $val['type_name'],
					'bonus_money'				=> $val['type_money'],
					'formatted_bonus_money'		=> ecjia_price_format($val['type_money'], false),
					'min_amount'				=> $val['min_goods_amount'],
					'label_min_amount'			=> '满'.$val['min_goods_amount'].'可使用',
					'formatted_use_start_date'	=> RC_Time::local_date(ecjia::config('date_format'), $val['use_start_date']),
					'formatted_use_end_date'	=> RC_Time::local_date(ecjia::config('date_format'), $val['use_end_date'])
				]; 
			}
			
		}
		return $bonus_list;
	}
	
}

//end