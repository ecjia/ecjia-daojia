<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-25
 * Time: 13:32
 */

namespace Ecjia\App\Cart\CreateOrders\OrderParts;


use Ecjia\App\Cart\CreateOrders\OrderPartAbstract;

class OrderBonusPart extends OrderPartAbstract
{

    protected $part_key = 'bonus';

    protected $bonus_id;
    
    protected $user_id;

    protected $data;

    public function __construct($bonus_id, $user_id)
    {
        $this->bonus_id = $bonus_id;
        
        $this->user_id 	= $user_id;
        
        $this->data 	= $this->getBonusInfo();
    }

	/**
	 * 红包信息
	 */
    public function getBonusInfo()
    {
    	$bonus = \Ecjia\App\Bonus\UserAvaliableBonus::bonusInfo($this->bonus_id);
    	return $bonus;
    }
    
    /**
     * 检验红包是否可用
     */
    public function check_bonus($bonus, $cart)
    {
    	
    	if ($bonus) {
    		//购物车商品总金额
    		$data = $cart->data;
    		$goods_amount = $data['total']['goods_amount'];
    		
    		if (empty($bonus) || $bonus->user_id != $this->user_id || $bonus->order_id > 0 || $bonus->min_goods_amount > $goods_amount) {
    			$this->data = [];
    		}
    		
    		//根据红包所属的店铺，判断店铺购物车金额是否满足使用红包
//     		if ($order['bonus_id'] > 0) {
//     			foreach ($cart_goods_list['cart_list'] as $v) {
//     				if ($bonus['store_id'] == $v['store_id']) {
//     					$temp_amout = $v['goods_amount'] - $v['total']['discount']; //除去优惠活动抵扣，剩下可以用红包抵扣的商品金额
//     					if ($temp_amout <= 0) {
//     						$order['bonus_id'] = 0;
//     						$temp_amout = 0;
//     					}
//     					$order['temp_amout'] = $temp_amout;
//     				}
//     			}
//     		}
    	}
    }
	
    /**
     * 订单实际允许使用的红包金额
     */
    public function order_bonus()
    {
    	//TODO 待处理
    	/* 红包金额 */
//     	if (!empty($order['bonus_id'])) {
//     		$bonus = \Ecjia\App\Bonus\UserAvaliableBonus::bonusInfo($order['bonus_id']);
//     		$total['bonus'] = $bonus['type_money'];
//     	}

    	/*红包和积分最多能支付的金额为剩余商品总额（既已扣除优惠金额的商品金额）*/
//     	$max_amount = $total['goods_price'] == 0 ? $total['goods_price'] : $total['goods_price'] - $total['discount'];
    	 
    	/* 计算订单总额 */
//     	if ($order['extension_code'] == 'group_buy') {
//     		RC_Loader::load_app_func('admin_goods', 'goods');
//     		$group_buy = group_buy_info($order['extension_id']);
//     	}
//     	if ($order['extension_code'] == 'group_buy' && $group_buy['deposit'] > 0) {
//     		$total['amount'] = $total['goods_price'];
//     	} else {
//     		$total['amount'] = $total['goods_price'] - $total['discount'] + $total['tax'] + $total['pack_fee'] + $total['card_fee'] + $total['shipping_fee'] + $total['shipping_insure'] + $total['cod_fee'];
//     		/* 实际可使用的红包金额 */
//     		$use_bonus = min($total['bonus'], $max_amount); //使用红包的金额不可超过剩余商品金额
//     		$total['bonus'] = $use_bonus;
//     		$total['bonus_formated'] = ecjia_price_format($total['bonus'], false);
//     		/* 订单总金额重新计算 */
//     		$total['amount'] -= $use_bonus;
//     		/* 还需要支付的订单商品金额 */
//     		$max_amount -= $use_bonus;
//     	}
    }
}