<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/27
 * Time: 10:57
 */

namespace Ecjia\App\Refund\RefundProcess;

use Ecjia\App\Refund\Exceptions\RefundException;
use RC_Notification;
use RC_DB;
use RC_Time;
use RC_Loader;
use RC_Api;
use RC_Model;
use RefundStatusLog;
use OrderStatusLog;
use Ecjia\App\Refund\RefundStatus;
use Ecjia\App\Refund\Models\RefundOrderModel;
use Ecjia\App\Refund\Notifications\RefundOriginalArrived;
use Ecjia\App\Refund\Notifications\RefundBalanceArrived;
use ecjia;

/**
 * 消费订单退款成功后续处理
 * Class BuyOrderRefundProcess
 * @package Ecjia\App\Refund\RefundProcess
 */
class BuyOrderRefundProcess
{

    /**
     * @var \Ecjia\App\Refund\Models\RefundOrderModel
     */
    protected $refund_order;

    public function __construct($refund_id = null, $refund_sn = null)
    {
        if (! is_null($refund_id)) {
            $this->refund_order = RefundOrderModel::where('refund_id', $refund_id)->first();

            if (empty($this->refund_order)) {
                throw new RefundException(sprintf('Refund order id %s not found.', $refund_id));
            }
        }
        else {
            $this->refund_order = RefundOrderModel::where('refund_sn', $refund_sn)->first();

            if (empty($this->refund_order)) {
                throw new RefundException(sprintf('Refund order sn %s not found.', $refund_sn));
            }
        }
    }

    /**
     * 执行
     */
    public function run()
    {
		//更新用户积分 refund_back_pay_points
    	$this->refundBackPayPoints();
    	
        //更新售后订单表 update_refund_order
        $this->updateRefundOrder();
        //售后订单状态变动日志表 update_refund_status_log
        $this->updateRefundStatusLog();

        //更新订单操作表 update_order_action
        $this->updateOrderAction();
        //普通订单状态变动日志表 update_order_status_log
        $this->updateOrderStatusLog();

        //记录到结算表 update_merchant_commission
        $this->updateMerchantCommission();
        //更新商家会员 update_merchant_customer
        $this->updateMerchantCustomer();

        //短信告知用户退款退货成功 send_sms_notice
        $this->sendSmsNotice();
        //消息通知 send_datatbase_notice
        $this->sendDatatbaseNotice();
    }
	
    /**
     * 更新用户积分；下单使用积分退还，下单赠送积分扣除
     */
    protected function refundBackPayPoints()
    {
    	RC_Api::api('finance', 'refund_back_pay_points', array('refund_id' => $this->refund_order->refund_id));
    }


    /**
     * 更新售后订单表
     */
    protected function updateRefundOrder()
    {
        $this->refund_order->refund_status = RefundStatus::PAY_TRANSFERED;
        $this->refund_order->refund_time = RC_Time::gmtime();
        $this->refund_order->save();
    }

    /**
     * 售后订单状态变动日志表
     */
    protected function updateRefundStatusLog()
    {
        //兼容旧的类手动加载
        RC_Loader::load_app_class('RefundStatusLog', 'refund', false);
        RefundStatusLog::refund_payrecord(array('refund_id' => $this->refund_order->refund_id, 'back_money' => $this->refund_order->refundPayRecord->back_money_total, 'back_pay_name' => $this->refund_order->refundPayRecord->back_pay_name));
    }

    /**
     * 更新订单操作表
     */
    protected function updateOrderAction()
    {
        $integral_name = ecjia::config('integral_name');
        if (empty($integral_name)) {
            $integral_name = '积分';
        }

        $action_note = '退款金额已退回'.$this->refund_order->refundPayRecord->back_pay_name.$this->refund_order->refundPayRecord->back_money_total.'元，退回'.$integral_name.'为：'.$this->refund_order->refundPayRecord->back_integral;

        //更新订单操作表
        $data = array(
            'refund_id' 		=> $this->refund_order->refund_id,
            'action_user_type'	=> $this->refund_order->refundPayRecord->action_user_type,
            'action_user_id'	=> $this->refund_order->refundPayRecord->action_user_id,
            'action_user_name'	=> $this->refund_order->refundPayRecord->action_user_name,
            'status'		    => RefundStatus::ORDER_AGREE,
            'refund_status'		=> RefundStatus::PAY_TRANSFERED,
            'return_status'		=> $this->refund_order->return_status,
            'action_note'		=> $action_note,
            'log_time'			=> RC_Time::gmtime(),
        );
        RC_DB::table('refund_order_action')->insertGetId($data);
    }

    /**
     * 普通订单状态变动日志表
     */
    protected function updateOrderStatusLog()
    {
        //兼容旧的类手动加载
        RC_Loader::load_app_class('OrderStatusLog', 'orders', false);
        $order_id = RC_DB::table('refund_order')->where('refund_id', $this->refund_order->refund_id)->pluck('order_id');
        OrderStatusLog::refund_payrecord(array(
            'order_id' 		=> $order_id,
            'back_money' 	=> $this->refund_order->refundPayRecord->back_money_total,
            'back_pay_name'	=> $this->refund_order->refundPayRecord->back_pay_name,
        ));
    }

    /**
     * 记录到结算表
     */
    protected function updateMerchantCommission()
    {
        RC_Api::api('commission', 'add_bill_queue', array(
            'order_type' => 'refund',
            'order_id' => $this->refund_order->refund_id
        ));
    }

    /**
     * 更新商家会员
     */
    protected function updateMerchantCustomer()
    {
        if (! empty($this->refund_order->user_id) && !empty($this->refund_order->store_id)) {
            RC_Api::api('customer', 'store_user_buy', array(
                'store_id' => $this->refund_order->store_id,
                'user_id' => $this->refund_order->user_id
            ));
        }
    }

    /**
     * 短信告知用户退款退货成功
     */
    protected function sendSmsNotice()
    {
        //发送退款短信通知
        $user_info = RC_DB::table('users')->where('user_id', $this->refund_order->user_id)->select('user_name', 'pay_points', 'user_money', 'mobile_phone')->first();
        if (!empty($user_info['mobile_phone'])) {
        	$action_back_type = $this->refund_order->refundPayRecord->action_back_type;
        	
        	if ($action_back_type == 'original') {
        		$this->sendOriginalRefundSms($user_info);
        	} else {
        		$this->sendBalanceRefundSms($user_info);
        	}
        }
    }

    /**
     * 发送原路退回短信
     */
    protected function sendOriginalRefundSms($user_info)
    {
    	$back_pay_name = $this->refund_order->refundPayRecord->back_pay_name;
    	$options = array(
    			'mobile' => $user_info['mobile_phone'],
    			'event'	 => 'sms_refund_original_arrived',
    			'value'  =>array(
    					'user_name' 	=> $user_info['user_name'],
    					'back_pay_name' => $back_pay_name,
    			),
    	);
    	RC_Api::api('sms', 'send_event_sms', $options);
    }
    
    /**
     * 发送退回余额短信
     */
    protected function sendBalanceRefundSms($user_info)
    {
    	$back_money_total = $this->refund_order->refundPayRecord->back_money_total;
    	$options = array(
    			'mobile' => $user_info['mobile_phone'],
    			'event'	 => 'sms_refund_balance_arrived',
    			'value'  =>array(
    					'user_name' 	=> $user_info['user_name'],
    					'amount' 		=> $back_money_total,
    					'user_money' 	=> $user_info['user_money'],
    			),
    	);
    	RC_Api::api('sms', 'send_event_sms', $options);
    }
    
    /**
     * 消息通知
     */
    protected function sendDatatbaseNotice()
    {
    	$action_back_type = $this->refund_order->refundPayRecord->back_pay_name;
    	if ($action_back_type == 'original') {
    		$this->sendOriginalDatatbaseNotice();
    	} else {
    		$this->sendBalanceDatatbaseNotice();
    	}
    }
	
    /**
     * 原路退回消息通知
     */
    protected function sendOriginalDatatbaseNotice()
    {
    	$orm_user_db = RC_Model::model('orders/orm_users_model');
    	$user = $orm_user_db->find($this->refund_order->user_id);
    	if ($user) {
    		$user_refund_data = array(
    				'title'	=> '退款原路退回',
    				'body'	=> '尊敬的'.$user->user_name.'，退款业务已受理成功，原路退回'.$this->refund_order->refundPayRecord->back_pay_name,
    				'data'	=> array(
    						'user_id'				=> $this->refund_order->user_id,
    						'user_name'				=> $user->user_name,
    						'amount'				=> $this->refund_order->refundPayRecord->back_money_total,
    						'formatted_amount' 		=> ecjia_price_format($this->refund_order->refundPayRecord->back_money_total),
    						'user_money'			=> $user->user_money,
    						'formatted_user_money'	=> ecjia_price_format($user->user_money),
    						'refund_id'				=> $this->refund_order->refund_id,
    						'refund_sn'				=> $this->refund_order->refund_sn,
    				),
    		);
    	
    		$push_refund_data = new RefundOriginalArrived($user_refund_data);
    		RC_Notification::send($user, $push_refund_data);
    	}
    }
    
    /**
     * 退回余额消息通知
     */
    protected function sendBalanceDatatbaseNotice()
    {
    	$orm_user_db = RC_Model::model('orders/orm_users_model');
    	$user = $orm_user_db->find($this->refund_order->user_id);
    	if ($user) {
    		$user_refund_data = array(
    				'title'	=> '退款到余额',
    				'body'	=> '尊敬的'.$user['user_name'].'，退款业务已受理成功，退回余额'.$this->refund_order->refundPayRecord->back_money_total.'元，目前可用余额'.$user['user_money'].'元。',
    				'data'	=> array(
    						'user_id'				=> $this->refund_order->user_id,
    						'user_name'				=> $user->user_name,
    						'amount'				=> $this->refund_order->refundPayRecord->back_money_total,
    						'formatted_amount' 		=> ecjia_price_format($this->refund_order->refundPayRecord->back_money_total, false),
    						'user_money'			=> $user['user_money'],
    						'formatted_user_money'	=> ecjia_price_format($user['user_money'], false),
    						'refund_id'				=> $this->refund_order->refund_id,
    						'refund_sn'				=> $this->refund_order->refund_sn,
    				),
    		);
    			
    		$push_refund_data = new RefundBalanceArrived($user_refund_data);
    		RC_Notification::send($user, $push_refund_data);
    	}
    }    
}