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
 * 收银快捷收款，快捷收款订单支付确认
 * @author zrl
 *
 */
class payConfirm_module extends api_admin implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {	
		$this->authadminSession();
		if ($_SESSION['staff_id'] <= 0) {
			return new ecjia_error(100, 'Invalid session');
		}
		$device = $this->device;
		
    	/* 获取请求当前数据的device信息*/
        $codes = RC_Loader::load_app_config('cashier_device_code', 'cashier');
        if (!is_array($device) || !isset($device['code']) || !in_array($device['code'], $codes)) {
            return new ecjia_error('caskdesk_error', __('非收银台请求！', 'cashier'));
        }
		
		$order_id = $this->requestData('order_id');
		
		if (empty($order_id)) {
			return new ecjia_error('invalid_parameter', __('参数错误', 'cashier'));
		}
		
		/*买单订单信息 */
		$quickpay_order_info = RC_Api::api('quickpay', 'quickpay_order_info', array('order_id' => $order_id));
		if (is_ecjia_error($quickpay_order_info)) {
			return $quickpay_order_info;
		}
		if (empty($quickpay_order_info)) {
			return new ecjia_error('quickpay_order_info_not_exist', __('收款订单不存在！', 'cashier'));
		}
		$payment_method	= new Ecjia\App\Payment\PaymentPlugin();
		$pay_info = $payment_method->getPluginDataByCode($quickpay_order_info['pay_code']);
		
		$payment_handler = $payment_method->channel($pay_info['pay_code']);
		
		/* 判断是否有支付方式有没*/
		if (is_ecjia_error($payment_handler)) {
			return $payment_handler;
		}
		
		if (in_array($pay_info['pay_code'], array('pay_cash', 'pay_koolyun_alipay', 'pay_koolyun_unionpay', 'pay_koolyun_wxpay', 'pay_shouqianba'))) {
			$result = RC_Api::api('quickpay', 'quickpay_order_paid', array('order_sn' => $quickpay_order_info['order_sn'], 'money' => $quickpay_order_info['order_amount']));
			if (is_ecjia_error($result)) {
				return $result;
			} else {
				$data = array(
						'order_id' 					=> $quickpay_order_info['order_id'],
						'order_amount'				=> $quickpay_order_info['order_amount'],
						'formatted_order_amount' 	=> price_format($quickpay_order_info['order_amount'], false),
						'pay_code'					=> $pay_info['pay_code'],
						'pay_name'					=> $pay_info['pay_name'],
						'pay_status'				=> 'success',
						'desc'						=> __('订单支付成功！', 'cashier')
				);
				$print_data = $this->_getPrint_data($quickpay_order_info);
				
				return array('payment' => $data, 'print_data' => $print_data);
			}
		} else {
			return new ecjia_error('not_support_payment', __('此充值记录对应的支付方式不支持收银台充值支付！', 'cashier'));
		}
	}
	
	/**
	 * 获取快捷收款买单订单打印数据
	 */
	private function _getPrint_data($order_info = array())
	{
		$quickpay_print_data = [];
		//获取更新后的数据
		$order_info = RC_Api::api('quickpay', 'quickpay_order_info', array('order_id' => $order_info['order_id']));
		if ($order_info) {
			$payment_record_info 	= $this->paymentRecordInfo($order_info['order_sn'], 'quickpay');
			$total_discount 		= $order_info['discount'] + $order_info['integral_money'] + $order_info['bonus'];
			$money_paid 			= $order_info['order_amount'] + $order_info['surplus'];
		
			//下单收银员
			$cashier_name = RC_DB::table('cashier_record as cr')
				->leftJoin('staff_user as su', RC_DB::raw('cr.staff_id'), '=', RC_DB::raw('su.user_id'))
				->where(RC_DB::raw('cr.order_id'), $order_info['order_id'])
				->where(RC_DB::raw('cr.order_type'), 'quickpay')
				->where(RC_DB::raw('cr.action'), 'receipt')
				->pluck('name');
		
			$user_info = [];
			//有没用户
			if ($order_info['user_id'] > 0) {
				$userinfo = RC_DB::table('users')->where('user_id', $order_info['user_id'])->first();
				if (!empty($userinfo)) {
					$user_info = array(
							'user_name' 			=> empty($userinfo['user_name']) ? '' : trim($userinfo['user_name']),
							'mobile'				=> empty($userinfo['mobile_phone']) ? '' : trim($userinfo['mobile_phone']),
							'user_points'			=> $userinfo['pay_points'],
							'user_money'			=> $userinfo['user_money'],
							'formatted_user_money'	=> price_format($userinfo['user_money'], false),
					);
				}
			}
		
			$quickpay_print_data = array(
					'order_sn' 						=> $order_info['order_sn'],
					'trade_no'						=> empty($payment_record_info['trade_no']) ? '' : $payment_record_info['trade_no'],
					'order_trade_no'				=> empty($payment_record_info['order_trade_no']) ? '' : $payment_record_info['order_trade_no'],
					'trade_type'					=> 'quickpay',
					'pay_time'						=> empty($order_info['pay_time']) ? '' : RC_Time::local_date(ecjia::config('time_format'), $order_info['pay_time']),
					'goods_list'					=> [],
					'total_goods_number' 			=> 0,
					'total_goods_amount'			=> $order_info['goods_amount'],
					'formatted_total_goods_amount'	=> price_format($order_info['goods_amount'], false),
					'total_discount'				=> $total_discount,
					'formatted_total_discount'		=> price_format($total_discount, false),
					'money_paid'					=> $money_paid,
					'formatted_money_paid'			=> price_format($money_paid, false),
					'integral'						=> intval($order_info['integral']),
					'integral_money'				=> $order_info['integral_money'],
					'formatted_integral_money'		=> price_format($order_info['integral_money'], false),
					'pay_name'						=> !empty($order_info['pay_name']) ? $order_info['pay_name'] : '',
					'payment_account'				=> '',
					'user_info'						=> $user_info,
					'refund_sn'						=> '',
					'refund_total_amount'			=> 0,
					'formatted_refund_total_amount' => '',
					'cashier_name'					=> empty($cashier_name) ? '' : $cashier_name
			);
		}
		
		return $quickpay_print_data;
	}
	
	/**
	 * 支付交易记录信息
	 * @param string $order_sn
	 * @param string $trade_type
	 * @return array
	 */
	private function paymentRecordInfo($order_sn = '', $trade_type = '')
	{
		$payment_revord_info = [];
		if (!empty($order_sn) && !empty($trade_type)) {
			$payment_revord_info = RC_DB::table('payment_record')->where('order_sn', $order_sn)->where('trade_type', $trade_type)->first();
		}
		return $payment_revord_info;
	}
}

// end