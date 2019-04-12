<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-25
 * Time: 13:32
 */

namespace Ecjia\App\Cart\CreateOrders\OrderParts;


use Ecjia\App\Cart\CreateOrders\OrderPartAbstract;

class OrderIntegralPart extends OrderPartAbstract
{

    protected $part_key = 'integral';

    protected $integral;
    
    protected $user_id;
    

    public function __construct($integral, $user_id)
    {
        $this->integral = $integral;
        $this->user_id = $user_id;
    }

    /**
     * 检查积分是否可用
     */
    public function check_integral()
    {
    	//TODO 待处理
//     	if ($user_id > 0) {
//     		$user_info = RC_Api::api('user', 'user_info', array('user_id' => $user_id));
//     		// 查询用户有多少积分
//     		$flow_points = cart::flow_available_points($options['cart_id']); // 该订单总共允许使用的积分
//     		$user_points = $user_info['pay_points']; // 用户的积分总数
    	
//     		$order['integral'] = min($order['integral'], $user_points, $flow_points); //使用积分数不可超过订单可用积分数
//     		if ($order['integral'] < 0) {
//     			$order['integral'] = 0;
//     		}
//     	} else {
//     		$order['surplus']  = 0;
//     		$order['integral'] = 0;
//     	}
    }
    
	/**
	 * 获取订单实际可用积分及可抵扣金额
	 */
    public function order_integral()
    {
    	//TODO 待处理
//     	$order['integral'] = $order['integral'] > 0 ? $order['integral'] : 0;
//     	if ($total['amount'] > 0 && $max_amount > 0 && $order['integral'] > 0) {
//     		/*输入的积分数可抵扣的金额*/
//     		$integral_money = \Ecjia\App\Cart\CartFunction::value_of_integral($order['integral']);
    	
//     		/*实际使用积分支付抵扣的金额*/
//     		$use_integral = min($total['amount'], $max_amount, $integral_money); //积分抵扣金额不可超过订单总金额
    	
//     		/* 订单总金额重新计算 */
//     		$total['amount'] -= $use_integral;
//     		$total['integral_money'] = $use_integral;
    	
//     		/*实际使用的积分数*/
//     		$order['integral'] = \Ecjia\App\Cart\CartFunction::integral_of_value($use_integral);
//     	} else {
//     		$total['integral_money'] = 0;
//     		$order['integral'] = 0;
//     	}
//     	$total['integral'] = $order['integral'];
    	
    }
    
    

}