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
 * 用户充值付款
 * @author royalwang
 */
class pay_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    		
    	if ($_SESSION['user_id'] <= 0) {
    		return new ecjia_error(100, 'Invalid session');
    	}
    	
 		//变量初始化
 		$account_id = $this->requestData('account_id', 0);
 		$payment_id = $this->requestData('payment_id', 0);
 		$user_id = $_SESSION['user_id'];
 		$wxpay_open_id = $this->requestData('wxpay_open_id', 0);
 		if ($account_id <= 0 || $payment_id <= 0) {
	    	return new ecjia_error(101, '参数错误');
	    }
	    
	    //获取单条会员帐目信息
	    $order = get_surplus_info($account_id, $user_id);
	    if (empty($order)) {
	        return new ecjia_error('deposit_log_not_exist', '充值记录不存在');
	    }
	    
	    $plugin = new Ecjia\App\Payment\PaymentPlugin();
	    $payment_info = $plugin->getPluginDataById($payment_id);
	    RC_Logger::getLogger('pay')->info($payment_info);
	    
	    //对比支付方式pay_code；如果有变化，则更新支付方式
	    $pay_code   = $payment_info['pay_code'];
	    if (!empty($pay_code)) {
	    	if ($order['payment'] != $pay_code) {
	    		$payment_list = RC_Api::api('payment', 'available_payments');
	    		if (!empty($payment_list)) {
	    			foreach ($payment_list as $k => $v) {
	    				if ($v['pay_code'] == 'pay_balance') {
	    					unset($payment_list[$k]);
	    				}
	    			}
	    			foreach ($payment_list as $vv) {
	    				$pay_codes[] = $vv['pay_code'];
	    			}
	    			if (in_array($pay_code, $pay_codes)) {
	    				RC_DB::table('user_account')->where('id', $account_id)->update(array('payment' => $pay_code));
	    			}
	    		}
	    	}
	    }
	    
	    /* 如果当前支付方式没有被禁用，进行支付的操作 */
	    if (!empty($payment_info)) {
	        $order['order_id']       = $order['id'];
	        $order['user_name']      = $_SESSION['user_name'];
	        $order['surplus_amount'] = $order['amount'];
	        $order['open_id']	     = $wxpay_open_id;
	        $order['order_type']     = 'user_account';
	        
	        RC_Loader::load_app_func('admin_order', 'orders');
	        //计算支付手续费用
	        $payment_info['pay_fee'] = pay_fee($payment_id, $order['surplus_amount'], 0);
	        
	        //计算此次预付款需要支付的总金额
	        $order['order_amount']   = strval($order['surplus_amount'] + $payment_info['pay_fee']);
	        
	        $handler = $plugin->channel($payment_info['pay_code']);
	        $handler->set_orderinfo($order);
	        $handler->set_mobile(true);
	        $handler->setOrderType(Ecjia\App\Payment\PayConstant::PAY_SURPLUS);
	        $handler->setPaymentRecord(new Ecjia\App\Payment\Repositories\PaymentRecordRepository());
	         
	        $result = $handler->get_code(Ecjia\App\Payment\PayConstant::PAYCODE_PARAM);
	        if (is_ecjia_error($result)) {
	            return $result;
	        } else {
	            $order['payment'] = $result;
	        }
	        
	        return array('payment' => $order['payment']);
        } else {
            /* 重新选择支付方式 */
            return new ecjia_error('select_payment_pls_again', __('支付方式无效，请重新选择支付方式！'));
        } 
	}
}

/**
 * 根据ID获取当前余额操作信息
 *
 * @access  public
 * @param   int     $account_id  会员余额的ID
 *
 * @return  int
 */
function get_surplus_info($account_id, $user_id) {
	$db = RC_Model::model('user/user_account_model');
	
	return $db->find(array('id' => $account_id, 'user_id' => $user_id));
}

// end