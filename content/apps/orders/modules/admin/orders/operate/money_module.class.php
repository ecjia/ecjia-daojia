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
 * 修改订单金额
 * @author will
 *
 */
class money_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
		$this->authadminSession();

        if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
			return new ecjia_error(100, 'Invalid session');
		}
		
		$result_view = $this->admin_priv('order_view');
		$result_edit = $this->admin_priv('order_edit');
		if (is_ecjia_error($result_view)) {
			return $result_view;
		} elseif (is_ecjia_error($result_edit)) {
			return $result_edit;
		}
		$order_id		= $this->requestData('order_id', 0);
		$goods_amount	= $this->requestData('goods_amount');
		$shipping_fee	= $this->requestData('shipping_fee');
		if ($order_id <= 0) {
			return new ecjia_error(100, 'Invalid session');
		}
		/*验证订单是否属于此入驻商*/
        if (isset($_SESSION['store_id']) && $_SESSION['store_id'] > 0) {
		    $ru_id_group = RC_Model::model('orders/order_info_model')->where(array('order_id' => $order_id))->group('store_id')->get_field('store_id', true);
		    if (count($ru_id_group) > 1 || $ru_id_group[0] != $_SESSION['store_id']) {
		        return new ecjia_error('no_authority', '对不起，您没权限对此订单进行操作！');
		    }
		}
		
		$order_info = RC_Api::api('orders', 'order_info', array('order_id' => $order_id));
		if (empty($order_info)) {
			return new ecjia_error(100, 'Invalid session');
		}
		
		$order= array();
		if (!empty($goods_amount)) {
			$order['goods_amount'] = $goods_amount;
		}
		if (!empty($shipping_fee)) {
			$order['shipping_fee'] = $shipping_fee;
		}

		/* 计算待付款金额 */
		$order['order_amount']  = $goods_amount - $order_info['discount']
								+ $order_info['tax']
								+ $shipping_fee
								+ $order_info['insure_fee']
								+ $order_info['pay_fee']
								+ $order_info['pack_fee']
								+ $order_info['card_fee']
								- $order_info['money_paid']
								- $order_info['integral_money']
								- $order_info['bonus'];
		RC_Loader::load_app_func('admin_order', 'orders');
		RC_Loader::load_app_func('global', 'orders');
		
		/* 暂不支持产生退款费用*/
		if ($order['order_amount'] < 0) {
			return new ecjia_error('amount_error', '订单金额过小，将产生退款费用！');
		}
		
		update_order($order_id, $order);
		/* 更新 pay_log */
		update_pay_log($order_id);
		
		$sn = '编辑费用信息，';
		$new_order = RC_Api::api('orders', 'order_info', array('order_id' => $order_id));
		if ($order_info['total_fee'] != $new_order['total_fee']) {
			$sn .= sprintf(RC_Lang::lang('order_amount_change'), $order_info['total_fee'], $new_order['total_fee']).'，';
		}
		$sn .= '订单号是 '.$order_info['order_sn'];
		if ($_SESSION['store_id'] > 0) {
		    RC_Api::api('merchant', 'admin_log', array('text' => $sn.'【来源掌柜】', 'action' => 'edit', 'object' => 'order'));
		} else {
		    ecjia_admin::admin_log($sn.'【来源掌柜】', 'edit', 'order'); // 记录日志
		}
			
		return array();
	} 
}


// end