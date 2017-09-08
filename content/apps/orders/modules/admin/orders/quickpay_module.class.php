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

class quickpay_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
		$this->authadminSession();

        if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
			return new ecjia_error(100, 'Invalid session');
		}
		/**
		 * bonus 0 //红包
		 * how_oos 0 //缺货处理
		 * integral 0 //积分
		 * payment 3 //支付方式
		 * postscript //订单留言
		 * shipping 3 //配送方式
		 * surplus 0 //余额
		 * inv_type 4 //发票类型
		 * inv_payee 发票抬头
		 * inv_content 发票内容
		 */

		RC_Loader::load_app_func('cart','cart');
		RC_Loader::load_app_func('admin_order','orders');

		$pay_id = $this->requestData('pay_id');
		$amount = $this->requestData('amount');
		
		if (empty($pay_id) || $pay_id <= 0) {
			return new ecjia_error(100, '错误的参数提交');
		}
		
		/* 判断是否是会员 */
		$consignee = array();
		if ($_SESSION['user_id']) {
			$db_user_model = RC_Loader::load_app_model('users_model','user');
			$user_info = $db_user_model->field('user_name, mobile_phone, email')
			->where(array('user_id'=>$_SESSION['user_id']))
			->find();
			$consignee = array(
					'consignee'		=> $user_info['user_name'],
					'mobile'		=> $user_info['mobile_phone'],
					'tel'			=> $user_info['mobile_phone'],
					'email'			=> $user_info['email'],
			);
		} else {//匿名用户
			$consignee = array(
					'consignee'	=> '匿名用户',
					'mobile'	=> '',
					'tel'		=> '',
					'email'		=> '',
			);
		}

		/* 获取商家或平台的地址 作为收货地址 */
		$region = RC_Loader::load_app_model('region_model','shipping');
		if ($_SESSION['ru_id'] > 0){
			$msi_dbview = RC_Loader::load_app_model('merchants_shop_information_viewmodel', 'seller');
			$where = array();
			$where['ssi.status'] = 1;
			$where['msi.merchants_audit'] = 1;
			$where['msi.user_id'] = $_SESSION['ru_id'];
			$info = $msi_dbview->join(array('category', 'seller_shopinfo'))
			->field('ssi.*')
			->where($where)
			->find();
			$region_info = array(
					'country'			=> $info['country'],
					'province'			=> $info['province'],
					'city'				=> $info['city'],
					'address'			=> $info['shop_address'],
			);
			$consignee = array_merge($consignee, $region_info);
		} else {
			$region_info = array(
					'country'			=> ecjia::config('shop_country'),
					'province'			=> ecjia::config('shop_province'),
					'city'				=> ecjia::config('shop_city'),
					'address'			=> ecjia::config('shop_address'),
			);
			$consignee = array_merge($consignee, $region_info);
		}

		$order = array(
				'user_id' => $_SESSION['user_id'],
				'pay_id' 		=> intval($pay_id),
				'goods_amount' 	=> isset($amount) ? floatval($amount) : '0.00',
				'money_paid' 	=> 0,
				'order_amount' 	=> isset($amount) ? floatval($amount) : '0.00',
				'add_time' 		=> RC_Time::gmtime(),
				'order_status'  => OS_CONFIRMED,
				'shipping_status'=> SS_UNSHIPPED,
				'pay_status' 	=> PS_UNPAYED,
// 				'agency_id' => get_agency_by_regions(array(
// 						$consignee['country'],
// 						$consignee['province'],
// 						$consignee['city'],
// 						$consignee['district']
// 				))
		);

		/* 收货人信息 */
		foreach ($consignee as $key => $value) {
			$order[$key] = addslashes($value);
		}

// 		$payment_method = RC_Loader::load_app_class('payment_method','payment');
		/* 支付方式 */
		if ($pay_id > 0) {
			$payment = with(new Ecjia\App\Payment\PaymentPlugin)->getPluginDataById($order['pay_id']);
			$order['pay_name'] = addslashes($payment['pay_name']);
		}
		
		if (empty($payment)) {
			return new ecjia_error(100, '错误的参数提交');
		}
		
		$order['from_ad'] = ! empty($_SESSION['from_ad']) ? $_SESSION['from_ad'] : '0';
		//TODO:订单来源收银台暂时写死
		$order['referer'] = 'ecjia-cashdesk'; // !empty($_SESSION['referer']) ? addslashes($_SESSION['referer']) : '';

		$parent_id = 0;
		$order['parent_id'] = $parent_id;

		/* 插入订单表 */
		$order['order_sn'] = get_order_sn(); // 获取新订单号

		$db_order_info = RC_Loader::load_app_model('order_info_model','orders');
		$new_order_id = $db_order_info->insert($order);

		/* 插入订单商品 */
		if ($new_order_id > 0) {
			$db_order_goods = RC_Loader::load_app_model('order_goods_model','orders');
			$arr = array(
					'order_id' 		=> $new_order_id,
					'goods_id' 		=> '0',
					'goods_name' 	=> '收银台快捷收款',
					'goods_sn' 		=> '',
					'product_id' 	=> '0',
					'goods_number' 	=> '1',
					'market_price' 	=> '0.00',
					'goods_price' 	=> isset($amount) ? floatval($amount) : '0.00',
					'goods_attr' 	=> '',
					'is_real' 		=> '1',
			);
// 			if ($_SESSION['store_id'] > 0) {
// 				$arr['store_id'] = $_SESSION['store_id'];
// 			}
			$order_goods_id = $db_order_goods->insert($arr);
		}
		
		if ($new_order_id > 0 && $order_goods_id > 0) {
			$adviser_log = array(
				'adviser_id' => $_SESSION['adviser_id'],
				'order_id'	 => $new_order_id,
				'device_id'	 => $_SESSION['device_id'],
				'type'   	 => '2',//收款
				'add_time'	 => RC_Time::gmtime(),
			);
			$adviser_log_id = RC_Model::model('achievement/adviser_log_model')->insert($adviser_log);
		}
		
// 		/* 插入支付日志 */
// 		$order['log_id'] = $payment_method->insert_pay_log($new_order_id, $order['order_amount'], PAY_ORDER);
// 		$payment_info = $payment_method->payment_info_by_id($pay_id);

		$subject = '收银台快捷收款￥'.floatval($amount).'';
		$out = array(
				'order_sn' => $order['order_sn'],
				'order_id' => $new_order_id,
				'order_info' => array(
						'pay_code' 		=> $payment_info['pay_code'],
						'order_amount' 	=> $order['order_amount'],
						'order_id' 		=> $new_order_id,
						'subject' 		=> $subject,
						'desc' 			=> $subject,
						'order_sn' 		=> $order['order_sn']
				)
		);
		return $out;
	}
}

// end