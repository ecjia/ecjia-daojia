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
 * 关闭订单（已支付，待发货的）默认退款，流程至商家同意，待平台打款处理
 * @author will
 *
 */
class admin_merchant_orders_operate_close_module extends api_admin implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {
        $this->authadminSession();

        if ($_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, __('Invalid session', 'orders'));
        }
        $result_view = $this->admin_priv('order_view');
        $result_edit = $this->admin_priv('order_os_edit');
        if (is_ecjia_error($result_view)) {
            return $result_view;
        } elseif (is_ecjia_error($result_edit)) {
            return $result_edit;
        }
        $order_id    = $this->requestData('order_id', 0);
        $cancel_note = $this->requestData('cancel_note', '');

        if (empty($order_id)) {
            return new ecjia_error(101, sprintf(__('请求接口%s参数无效', 'orders'), __CLASS__));
        }
        /*验证订单是否属于此入驻商*/
        if (isset($_SESSION['store_id']) && $_SESSION['store_id'] > 0) {
            $ru_id_group = RC_Model::model('orders/order_info_model')->where(array('order_id' => $order_id))->get_field('store_id', true);
            if (count($ru_id_group) > 1 || $ru_id_group[0] != $_SESSION['store_id']) {
                return new ecjia_error('no_authority', __('对不起，您没权限对此订单进行操作！', 'orders'));
            }
        }

        $order_info = RC_DB::table('order_info')->where('order_id', $order_id)
				        ->whereIn('order_status', [OS_UNCONFIRMED, OS_CONFIRMED])
				        ->where('pay_status', PS_PAYED)
				        ->where('shipping_status', SS_UNSHIPPED)
				        ->where('is_delete', 0)
				        ->first();
        
        if (empty($order_info)) {
            return new ecjia_error('order_no_exists', __('订单信息不存在', 'orders'));
        }
		
        //发货状态只能是“未发货”
        if ($order_info['shipping_status'] != SS_UNSHIPPED) {
        	return new ecjia_error('current_ss_not_cancel', __('只有在未发货状态下才能关闭。', 'orders'));
        }
        
        //支付状态只能是已支付的
        if ($order_info['pay_status'] == PS_UNPAYED) {
        	return new ecjia_error('current_ps_not_cancel', __('只有已付款的订单才能关闭。', 'orders'));
        }
        //订单状态是未确认或已接单
        if ($order_info['order_status'] > OS_CONFIRMED) {
        	return new ecjia_error('order_has_canceled', __('该订单状态不支持关闭！', 'orders'));
        }
        
        $res = Ecjia\App\Orders\OrderMerchantClosed::CloseOrderToRefundFinished($order_info, $_SESSION['staff_id'], $cancel_note);
        
        if (is_ecjia_error($res)) {
        	return $res;
        }
        
        return array();
    }
}


// end