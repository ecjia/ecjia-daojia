<?php

namespace Ecjia\App\Orders;

use RC_Lang;
use RC_Loader;

class OrderStatus
{
    /* 已完成订单 */
    const FINISHED = 'finished';
    
    /* 待付款订单 */
    const AWAIT_PAY = 'await_pay';
    
    /* 待发货订单 */
    const AWAIT_SHIP = 'await_ship';
    
    /* 未确认订单 */
    const UNCONFIRMED = 'unconfirmed';
    
    /* 未处理订单：用户可操作 */
    const UNPROCESSED = 'unprocessed';
    
    /* 未付款未发货订单：管理员可操作 */
    const UNPAY_UNSHIP = 'unpay_unship';
    
    /* 已发货订单：不论是否付款 */
    const SHIPPED = 'shipped';
    
    /* 退货 */
    const REFUND = 'refund';
    
    /* 无效 */
    const INVALID = 'invalid';
    
    /* 取消 */
    const CANCELED = 'canceled';
    
    /* 待评论 */
    const ALLOW_COMMENT = 'allow_comment';
    
    /**
     * 订单状态映射
     * 
     * @var array
     */
    protected static $orderTypes = [
        self::FINISHED        => 'queryOrderFinished',
        self::AWAIT_PAY       => 'queryOrderAwaitPay',
        self::AWAIT_SHIP      => 'queryOrderAwaitShip',
        self::UNCONFIRMED     => 'queryOrderUnconfirmed',
        self::UNPROCESSED     => 'queryOrderUnprocessed',
        self::UNPAY_UNSHIP    => 'queryOrderUnpayUnship',
        self::SHIPPED         => 'queryOrderShipped',
        self::REFUND          => 'queryOrderRefund',
        self::INVALID         => 'queryOrderInvalid',
        self::CANCELED        => 'queryOrderCanceled',
        self::ALLOW_COMMENT   => 'queryOrderAllowComment',
    ];

    
    public static function getOrderStatusLabel($order_status, $shipping_status, $pay_status, $is_cod, $refund_info) 
    {
        if (in_array($order_status, array(OS_CONFIRMED, OS_SPLITED)) &&
            in_array($shipping_status, array(SS_RECEIVED)) &&
            in_array($pay_status, array(PS_PAYED, PS_PAYING)))
        {
            $label_order_status = RC_Lang::get('orders::order.cs.'.CS_FINISHED);
            $status_code = 'finished';
        }
        elseif (in_array($shipping_status, array(SS_SHIPPED)) && $order_status != OS_RETURNED)
        {
            $label_order_status = RC_Lang::get('orders::order.label_await_confirm');
            $status_code = 'shipped';
        }
        elseif (in_array($order_status, array(OS_CONFIRMED, OS_SPLITED, OS_UNCONFIRMED)) &&
            in_array($pay_status, array(PS_UNPAYED)) &&
            (in_array($shipping_status, array(SS_SHIPPED, SS_RECEIVED)) || !$is_cod))
        {
            $label_order_status = RC_Lang::get('orders::order.label_await_pay');
            $status_code = 'await_pay';
        }
        elseif (in_array($order_status, array(OS_UNCONFIRMED, OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART)) &&
            in_array($shipping_status, array(SS_UNSHIPPED, SS_PREPARING, SS_SHIPPED_ING)) &&
            (in_array($pay_status, array(PS_PAYED, PS_PAYING)) || $is_cod))
        {
            $label_order_status = RC_Lang::get('orders::order.label_await_ship');
            $status_code = 'await_ship';
        }
        elseif (in_array($order_status, array(OS_SPLITING_PART)) &&
            in_array($shipping_status, array(SS_SHIPPED_PART)))
        {
            $label_order_status = RC_Lang::get('orders::order.label_shipped_part');
            $status_code = 'shipped_part';
        }
        elseif (in_array($order_status, array(OS_CANCELED))) {
            $label_order_status = RC_Lang::get('orders::order.label_canceled');
            $status_code = 'canceled';
        }
        elseif (in_array($order_status, array(OS_RETURNED)) && $pay_status == PS_PAYED) {
        	$label_order_status = RC_Lang::get('orders::order.label_refunded');
        	$status_code = 'refund';
        }
        
        return array($label_order_status, $status_code);
    }
    
    
    public static function getRefundStatusLabel($order_status, $rfo_status, $rfd_status)
    {
    	if ($rfo_status == '10') {
    		$status_code 		= 'canceled';
    		$label_refund_status	= '取消退款';
    	} elseif (($rfo_status == '1' && $rfd_status == '2')) {
    		$status_code = 'refunded';
    		$label_refund_status= '已退款';
    	}elseif ($rfo_status == '11') {
    		$status_code = 'refused';
    		$label_refund_status = '退款被拒';
    	} else{
    		$status_code = 'going';
    		$label_refund_status = '进行中';
    	}
    	return array($label_refund_status, $status_code);
    }
    
    public static function getQueryOrder($type)
    {
        $method = array_get(self::$orderTypes, $type);
        if ($method) {
            return self::$method();
        }
        return null;
    }
    
    /* 已完成订单 */
    public static function queryOrderFinished()
    {
    	return function ($query) {
    		$query->whereIn('order_info.order_status', array(OS_CONFIRMED, OS_SPLITED))
    		      ->whereIn('order_info.shipping_status', array(SS_SHIPPED, SS_RECEIVED))
    		      ->whereIn('order_info.pay_status', array(PS_PAYED, PS_PAYING));
    	};
        
    }
    
    /* 待付款订单 */
    public static function queryOrderAwaitPay() 
    {
    	return function ($query) {
    		$query->whereIn('order_info.order_status', array(OS_UNCONFIRMED, OS_CONFIRMED, OS_SPLITED))
    		      ->where('order_info.pay_status', PS_UNPAYED);
    	};
    }
    
    
    /* 待发货订单 */
    public static function queryOrderAwaitShip() 
    {
        $payment_method = RC_Loader::load_app_class('payment_method','payment');
        $payment_ids = $payment_method->payment_id_list(true);
        
        if (!empty($payment_ids)) {
        	return function ($query) use ($payment_ids) {
        		$query->whereIn('order_info.order_status', array(OS_UNCONFIRMED, OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART))
        		->whereIn('order_info.shipping_status', array(SS_UNSHIPPED, SS_PREPARING, SS_SHIPPED_ING))
        		->where(function ($query) use ($payment_ids) {
        			$query->whereIn('order_info.pay_status', array(PS_PAYED, PS_PAYING))
        			->orWhere(function ($query) use ($payment_ids) {
        				$query->whereIn('pay_id', $payment_ids);
        			});
        		});
        	
        	};
        } else {
        	return function ($query) {
        		$query->whereIn('order_info.order_status', array(OS_UNCONFIRMED, OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART))
        			  ->whereIn('order_info.shipping_status', array(SS_UNSHIPPED, SS_PREPARING, SS_SHIPPED_ING))
        			  ->whereIn('order_info.pay_status', array(PS_PAYED, PS_PAYING));
        	};
        }
    }
    
    /* 未确认订单 */
    public static function queryOrderUnconfirmed() 
    {
        return function ($query) {
            $query->where('order_info.order_status', OS_UNCONFIRMED);
        };
    }
    
    
    /* 未处理订单：用户可操作 */
    public static function queryOrderUnprocessed() 
    {
        return function ($query) {
        	$query->whereIn('order_info.order_status', array(OS_UNCONFIRMED, OS_CONFIRMED))
        	      ->where('order_info.shipping_status', SS_UNSHIPPED)
        	      ->where('order_info.pay_status', PS_UNPAYED);
        };
    }
    
    /* 未付款未发货订单：管理员可操作 */
    public static function queryOrderUnpayUnship() 
    {
    	return function ($query) {
    		$query->whereIn('order_info.order_status', array(OS_UNCONFIRMED, OS_CONFIRMED))
    		      ->whereIn('order_info.shipping_status', array(SS_UNSHIPPED, SS_PREPARING))
    		      ->where('order_info.pay_status', PS_UNPAYED);
    	};
    }
    
    /* 已发货订单：不论是否付款 */
    public static function queryOrderShipped() 
    {
    	return function ($query) {
    		$query->where('order_info.shipping_status', SS_SHIPPED)
    			  ->where('order_info.order_status', '<>', OS_RETURNED);
    	};
    }
    
    /* 退款 */
    public static function queryOrderRefund() 
    {
    	return function ($query) {
    		$query->leftJoin('refund_order', function ($join) {
    			$join->on('order_info.order_id', '=', 'refund_order.order_id')
    			     ->where('refund_order.status', '<>', 10);
    		});
    		$query->where('order_info.order_status', OS_RETURNED)
    			  ->where('order_info.pay_status', PS_PAYED);
    		
    		$fields = array('refund_order.status as rfo_status', 'refund_order.refund_status as rfd_status', 'refund_order.refund_sn');
    		$query->addSelect($fields);
    	};
    }
    
    /* 无效 */
    public static function queryOrderInvalid()
    {
    	return function ($query) {
    		$query->where('order_info.order_status', OS_INVALID);
    	};
    }
    
    /* 取消 */
    public static function queryOrderCanceled() 
    {
    	return function ($query) {
    		$query->where('order_info.order_status', OS_CANCELED);
    	};
    }
    
    /* 待评论 */
    public static function queryOrderAllowComment()
    {
        return  function ($query) {
            $query->leftJoin('order_goods', function ($join) {
                $join->on('order_info.order_id', '=', 'order_goods.order_id');
            })->leftJoin('comment', function ($join) {
                $join->on('order_goods.rec_id', '=', 'comment.rec_id')
                    ->on('comment.id_value', '=', 'order_goods.goods_id')
                    ->on('comment.order_id', '=', 'order_goods.order_id')
                    ->where('comment.comment_type', '=', 0)
                    ->where('comment.parent_id', '=', 0);
            });
        
            $query->whereIn('order_info.order_status', [OS_CONFIRMED, OS_SPLITED])
                ->whereIn('order_info.pay_status', [PS_PAYED, PS_PAYING])
                ->where('order_info.shipping_status', SS_RECEIVED);
        
            $fields = array('comment.comment_id', 'comment.has_image');
            $query->addSelect($fields);
            $query->whereNull('comment.comment_id');
        };
    }

}
