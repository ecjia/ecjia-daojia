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
 * 返回订单可执行操作的操作
 * @author will.chen
 */
class orders_order_operable_list_api extends Component_Event_Api {
	
    /**
     * @param  $options 订单信息
     *
     * @return array
     */
	public function call(&$options) {	
	    if (!is_array($options)) {
	        return new ecjia_error('invalid_parameter', RC_Lang::get('orders::order.invalid_parameter'));
	    }
	    
	    return $this->operable_list($options);
	}
	
	/**
	 * 检查支付的金额是否与订单相符
	 *
	 * @access  public
	 * @param   string   $log_id      支付编号
	 * @param   float    $money       支付接口返回的金额
	 * @return  true
	 */
	private function operable_list($order) {
	    /* 取得订单状态、发货状态、付款状态 */
		$os = $order['order_status'];
		$ss = $order['shipping_status'];
		$ps = $order['pay_status'];
	
		/* 取得订单操作权限 */
		$actions = $_SESSION['action_list'];
		if ($actions == 'all') {
			$priv_list	= array('os' => true, 'ss' => true, 'ps' => true, 'edit' => true);
		} else {
			$actions    = ',' . $actions . ',';
			$priv_list  = array(
				'os'	=> strpos($actions, ',order_os_edit,') !== false,
				'ss'	=> strpos($actions, ',order_ss_edit,') !== false,
				'ps'	=> strpos($actions, ',order_ps_edit,') !== false,
				'edit'	=> strpos($actions, ',order_edit,') !== false
			);
		}
	
		/* 取得订单支付方式是否货到付款 */
// 		$payment_method = RC_Loader::load_app_class('payment_method','payment');
		$payment = with(new Ecjia\App\Payment\PaymentPlugin)->getPluginDataById($order['pay_id']);
	
		$is_cod  = $payment['is_cod'] == 1;
	
		/* 根据状态返回可执行操作 */
		$list = array();
		if (OS_UNCONFIRMED == $os) {
			/* 状态：未确认 => 未付款、未发货 */
			if ($priv_list['os']) {
				$list['confirm']	= true;	// 确认
				$list['invalid']	= true;	// 无效
				$list['cancel']		= true;	// 取消
				if ($is_cod) {
					/* 货到付款 */
					if ($priv_list['ss']) {
						$list['prepare']	= true;	// 配货
						$list['split']		= true;	// 分单
					}
				} else {
					/* 不是货到付款 */
					if ($priv_list['ps']) {
						$list['pay'] = true;	// 付款
					}
				}
			}
		} elseif (OS_CONFIRMED == $os || OS_SPLITED == $os || OS_SPLITING_PART == $os) {
			/* 状态：已确认 */
			if (PS_UNPAYED == $ps) {
				/* 状态：已确认、未付款 */
				if (SS_UNSHIPPED == $ss || SS_PREPARING == $ss) {
					/* 状态：已确认、未付款、未发货（或配货中） */
					if ($priv_list['os']) {
						$list['cancel'] = true;		// 取消
						$list['invalid'] = true;	// 无效
					}
					if ($is_cod) {
						/* 货到付款 */
						if ($priv_list['ss']) {
							if (SS_UNSHIPPED == $ss) {
								$list['prepare'] = true;	// 配货
							}
							$list['split'] = true;	// 分单
						}
					} else {
						/* 不是货到付款 */
						if ($priv_list['ps']) {
							$list['pay'] = true;	// 付款
						}
					}
				} elseif (SS_SHIPPED_ING == $ss || SS_SHIPPED_PART == $ss) {
					/* 状态：已确认、未付款、发货中 */
					// 部分分单
					if (OS_SPLITING_PART == $os) {
						$list['split'] = true;		// 分单
					}
					$list['to_delivery'] = true;	// 去发货
				} else {
					/* 状态：已确认、未付款、已发货或已收货 => 货到付款 */
					if ($priv_list['ps']) {
						$list['pay'] = true;	// 付款
					}
					if ($priv_list['ss']) {
						if (SS_SHIPPED == $ss) {
							$list['receive'] = true;	// 收货确认
						}
						$list['unship'] = true;	// 设为未发货
						if ($priv_list['os']) {
							$list['return'] = true;	// 退货
						}
					}
				}
			} else {
				/* 状态：已确认、已付款和付款中 */
				if (SS_UNSHIPPED == $ss || SS_PREPARING == $ss) {
					/* 状态：已确认、已付款和付款中、未发货（配货中） => 不是货到付款 */
					if ($priv_list['ss']) {
						if (SS_UNSHIPPED == $ss) {
							$list['prepare'] = true;	// 配货
						}
						$list['split'] = true;	// 分单
					}
					if ($priv_list['ps']) {
						$list['unpay'] = true;	// 设为未付款
						if ($priv_list['os']) {
							$list['cancel'] = true;	// 取消
						}
					}
				} elseif (SS_SHIPPED_ING == $ss || SS_SHIPPED_PART == $ss) {
					/* 状态：已确认、未付款、发货中 */
					// 部分分单
					if (OS_SPLITING_PART == $os) {
						$list['split'] = true;	// 分单
					}
					$list['to_delivery'] = true;	// 去发货
				} else {
					/* 状态：已确认、已付款和付款中、已发货或已收货 */
					if ($priv_list['ss']) {
						if (SS_SHIPPED == $ss) {
							$list['receive'] = true;	// 收货确认
						}
						if (!$is_cod) {
							$list['unship'] = true;	// 设为未发货
						}
					}
					if ($priv_list['ps'] && $is_cod) {
						$list['unpay']  = true;	// 设为未付款
					}
					if ($priv_list['os'] && $priv_list['ss'] && $priv_list['ps']) {
						$list['return'] = true;	// 退货（包括退款）
					}
				}
			}
		} elseif (OS_CANCELED == $os) {
			/* 状态：取消 */
			if ($priv_list['os']) {
				$list['confirm'] = true;
			}
			if ($priv_list['edit']) {
				$list['remove'] = true;
			}
		} elseif (OS_INVALID == $os) {
			/* 状态：无效 */
			if ($priv_list['os']) {
				$list['confirm'] = true;
			}
			if ($priv_list['edit']) {
				$list['remove'] = true;
			}
		} elseif (OS_RETURNED == $os) {
			/* 状态：退货 */
			if ($priv_list['os']) {
				$list['confirm'] = true;
			}
		}
	
		/* 修正发货操作 */
		if (!empty($list['split'])) {
			/* 如果是团购活动且未处理成功，不能发货 */
			RC_Loader::load_app_func('global', 'orders');
			if ($order['extension_code'] == 'group_buy') {
				RC_Loader::load_app_func('admin_goods', 'goods');
				$group_buy = group_buy_info(intval($order['extension_id']));
				if ($group_buy['status'] != GBS_SUCCEED) {
					unset($list['split']);
					unset($list['to_delivery']);
				}
			}
	
			/* 如果部分发货 不允许 取消 订单 */
			if (order_deliveryed($order['order_id'])) {
				$list['return'] = true;	// 退货（包括退款）
				unset($list['cancel']);	// 取消
			}
		}
	
		/* 售后 */
		$list['after_service'] = true;
		return $list;
	}
}

// end