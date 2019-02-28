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
/**
 * 余额支付插件
 */
defined('IN_ECJIA') or exit('No permission resources.');

use Ecjia\App\Payment\PaymentAbstract;
use Ecjia\App\Payment\Contracts\CancelPayment;
use Ecjia\App\Payment\Contracts\RefundPayment;
use Ecjia\App\Payment\Contracts\PayPayment;

class pay_balance extends PaymentAbstract implements CancelPayment, RefundPayment, PayPayment
{

	
    /**
     * 获取插件代号
     *
     * @see \Ecjia\System\Plugin\PluginInterface::getCode()
     */
    public function getCode()
    {
        return $this->loadConfig('pay_code');
    }
    
    /**
     * 加载配置文件
     *
     * @see \Ecjia\System\Plugin\PluginInterface::loadConfig()
     */
    public function loadConfig($key = null, $default = null)
    {
        return $this->loadPluginData(RC_Plugin::plugin_dir_path(__FILE__) . 'config.php', $key, $default);
    }
    
    /**
     * 加载语言包
     *
     * @see \Ecjia\System\Plugin\PluginInterface::loadLanguage()
     */
    public function loadLanguage($key = null, $default = null)
    {
        $locale = RC_Config::get('system.locale');
    
        return $this->loadPluginData(RC_Plugin::plugin_dir_path(__FILE__) . '/languages/'.$locale.'/plugin.lang.php', $key, $default);
    }

    /**
     * 统一下单方法
     */
    public function unifiedOrder()
    {
        $user_id = $_SESSION['user_id'];
        /* 获取会员信息*/
        $user_info = RC_Api::api('user', 'user_info', array('user_id' => $user_id));

        $api_version = royalcms('request')->header('api-version');
        if (version_compare($api_version, '1.25', '<')) {
            $predata = $this->beforVersionPredata($user_info);
        } else {
            $predata = $this->nowVersionPredata($user_info);
        }

        return $predata;
    }
    
    private function beforVersionPredata($user_info)
    {
    	if ($this->order_info['order_type'] == Ecjia\App\Payment\PayConstant::PAY_QUICKYPAY) {
    		$result = RC_Api::api('quickpay', 'quickpay_user_account_paid', array('user_id' => $user_info['user_id'], 'order_id' => $this->order_info['order_id']));
    	} else {
    		$result = RC_Api::api('orders', 'user_account_paid', array('user_id' => $user_info['user_id'], 'order_id' => $this->order_info['order_id']));
    	}
    	if (is_ecjia_error($result)) {
    		/* 支付失败返回信息*/
    		$error_predata = array(
    				'order_id'      => $this->order_info['order_id'],
    				'order_surplus' => price_format($this->order_info['surplus'], false),
    				'order_amount'  => price_format($this->order_info['order_amount'], false),
    				'pay_code'      => $this->getCode(),
    				'pay_name'      => $this->getDisplayName(),
    				'pay_status'    => 'error',
    				'pay_online'    => '',
    		);
    		$error_predata['error_message'] = $result->get_error_message();
    		return $error_predata;
    	
    	} else {
    		/* 更新支付流水记录*/
    		RC_Api::api('payment', 'update_payment_record', [
    		'order_sn' 		=> $this->order_info['order_sn'],
    		'trade_no'      => ''
    				]);
    	
    		/* 支付成功返回信息*/
    		$predata = array(
    				'order_id'      => $this->order_info['order_id'],
    				'order_surplus' => price_format($this->order_info['order_amount'], false),
    				'order_amount'  => price_format(0, false),
    				'user_money'    => price_format($user_info['user_money'] - $this->order_info['order_amount'], false),
    				'pay_code'      => $this->getCode(),
    				'pay_name'      => $this->getDisplayName(),
    				'pay_status'    => 'success',
    				'pay_online'    => '',
    		);
    		return $predata;
    	}
    }

    private function nowVersionPredata($user_info)
    {
    	$recordId = $this->getPaymentRecordId();
        $output = new Ecjia\App\Payment\PaymentOutput();
        $output->setOrderSn($this->order_info['order_sn'])
                ->setOrderId($this->order_info['order_id'])
                ->setOrderAmount($this->order_info['order_amount'])
                ->setPayCode($this->getCode())
                ->setPayName($this->getDisplayName())
                ->setPayRecordId($recordId)
                ->setSubject(ecjia::config('shop_name') . '的订单：' . $this->order_info['order_sn'])
                ->setOrderTradeNo($this->getOrderTradeNo($recordId));
        
        return $output->export();
    }
    
    /**
     * 插件支付
     * @param $order_trade_no  交易流水号
     */
    public function pay($order_trade_no)
    {
    	$record_model = $this->paymentRecord->getPaymentRecord($order_trade_no);
        if (empty($record_model)) {
            return new ecjia_error('payment_record_not_found', '此笔交易记录未找到');
        }
    	
    	//订单信息
    	if ($record_model->trade_type == Ecjia\App\Payment\PayConstant::PAY_QUICKYPAY) {
    		$orderinfo = RC_Api::api('quickpay', 'quickpay_order_info', array('order_sn' => $record_model->order_sn));
    	} else if ($record_model->trade_type == Ecjia\App\Payment\PayConstant::PAY_SEPARATE_ORDER) {
    	    $orderinfo = RC_Api::api('orders', 'separate_order_info', array('order_sn' => $record_model->order_sn));
    	} else {
    		$orderinfo = RC_Api::api('orders', 'order_info', array('order_sn' => $record_model->order_sn));
    	}
    	
    	if (empty($orderinfo)) {
    		return new ecjia_error('order_dose_not_exist', $record_model->order_sn . '未找到该订单信息');
    	}
    	
    	$user_id = $_SESSION['user_id'];
    	if (empty($user_id)) {
    		$user_id = $orderinfo['user_id'];
    	}
    	/* 获取会员信息*/
    	$user_info = RC_Api::api('user', 'user_info', array('user_id' => $user_id));
    	
    	if ($record_model->trade_type == Ecjia\App\Payment\PayConstant::PAY_QUICKYPAY) {
    		$result = RC_Api::api('quickpay', 'quickpay_user_account_paid', array('user_id' => $user_info['user_id'], 'order_id' => $orderinfo['order_id']));
    	} else if ($record_model->trade_type == Ecjia\App\Payment\PayConstant::PAY_SEPARATE_ORDER) {
    	    $result = RC_Api::api('orders', 'separate_user_account_paid', array('user_id' => $user_info['user_id'], 'order_sn' => $orderinfo['order_sn']));
    	} else {
    		$result = RC_Api::api('orders', 'user_account_paid', array('user_id' => $user_info['user_id'], 'order_id' => $orderinfo['order_id']));
    	}
    	
    	//订单状态更新成功
    	if (is_ecjia_error($result)) {
    		/* 支付失败返回信息*/
    		$error_predata = array(
				'order_id'      => $orderinfo['order_id'],
    		    'order_sn'      => $orderinfo['order_sn'],
				'order_surplus' => ecjia_price_format($orderinfo['surplus'], false),
				'order_amount'  => ecjia_price_format($orderinfo['order_amount'], false),
				'pay_code'      => $this->getCode(),
				'pay_name'      => $this->getDisplayName(),
				'pay_status'    => 'error',
				'pay_online'    => '',
    		);
    		$error_predata['error_message'] = $result->get_error_message();
    		return new ecjia_error('user_surplus_error', $result->get_error_message());
    		 
    	} else {
    		/* 更新支付流水记录*/
    		RC_Api::api('payment', 'update_payment_record', [
        		'order_sn' 		=> $orderinfo['order_sn'],
        		'trade_no'      => ''
				]);
    		/* 支付成功返回信息*/
    		$predata = array(
				'order_id'      => $orderinfo['order_id'],
    		    'order_sn'      => $orderinfo['order_sn'],
				'order_surplus' => ecjia_price_format($orderinfo['order_amount'], false),
				'order_amount'  => ecjia_price_format(0, false),
				'user_money'    => ecjia_price_format($user_info['user_money'] - $orderinfo['order_amount'], false),
				'pay_code'      => $this->getCode(),
				'pay_name'      => $this->getDisplayName(),
				'pay_status'    => 'success',
				'pay_online'    => '',
    		);
    		return $predata;
    	}
    }
    
    /**
     * 确认撤销
     *
     * @param string $order_trade_no 交易号
     * @return array | ecjia_error
     */
    public function cancel($order_trade_no)
    {
    	
    }
    
    
    /**
     * 确认退款
     * @param string $order_trade_no 订单交易号
     * @param float $refund_amount 退款金额
     * @param string $operator 操作员
     * @return ecjia_error | array
     */
    public function refund($order_trade_no, $refund_amount, $operator)
    {
    	$record_model = $this->paymentRecord->getPaymentRecord($order_trade_no);
    	if (empty($record_model)) {
            $record_model = $this->paymentRecord->getPaymentRecordByOrderSn($order_trade_no);
            if (empty($record_model)) {
                return new ecjia_error('payment_record_not_found', '此笔交易记录未找到');
            }
    	}
    	
    	$refund_payrecord = \Ecjia\App\Refund\Models\RefundPayRecordModel::where('order_sn', $record_model->order_sn)->first();
    	if (empty($refund_payrecord)) {
    		return new ecjia_error('payment_record_not_found', '此笔退款申请未找到');
    	}
    	
    	//退款申请单
    	$refund_order = RC_Api::api('refund', 'refund_order_info', array('refund_id' => $refund_payrecord->refund_id));
    	if (is_ecjia_error($refund_order)) {
    		return $refund_order;
    	}
    	
    	if (!empty($refund_order['user_id'])) {
    		$integral_name = ecjia::config('integral_name');
    		if (empty($integral_name)) {
    			$integral_name = '积分';
    		}
    		//账户余额变动记录
    		$options = array(
    				'user_id'		=> $refund_order['user_id'],
    				'user_money'	=> $refund_payrecord['back_money_total'],
    				'change_desc'	=> '由于订单'.$refund_order['order_sn'].'退款，退还下单使用的'.$integral_name.'，退款金额退回余额',
    				'change_type'	=> ACT_SAVING,
    		);
    		
    		RC_Api::api('finance', 'account_balance_change', $options);
    		
    		/* 消费订单退款成功后续处理	
    		 * 1、更新用户积分
    		 * 2、更新售后订单表
    		 * 3、售后订单状态变动日志表
    		 * 4、更新订单操作表
    		 * 5、普通订单状态变动日志表
    		 * 6、记录到结算表
    		 * 7、更新商家会员
    		 * 8、短信告知用户退款退货成功
    		 * 9、消息通知 
    		 */
    		(new \Ecjia\App\Refund\RefundProcess\BuyOrderRefundProcess(null, $refund_order['refund_sn']))->run();
    		
    		//处理成功返回
    		$refund_result = array(
    				'refund_status'	=> 'success',
    				'desc'			=> '订单退款成功！'
    		);
    		return $refund_result;
    	} else {
    		return new ecjia_error('pay_balance_refund_fail', '退款失败!');
    	}
    }
    
    /**
     * 退款流水对账查询
     * @param string $order_trade_no 交易号
     */
    public function refundQuery($order_trade_no)
    {
    	return new ecjia_error('refund_query_not_support', '余额支付不支持退款查询对账功能');
    }
}

// end