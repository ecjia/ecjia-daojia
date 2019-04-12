<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-25
 * Time: 13:32
 */

namespace Ecjia\App\Cart\CreateOrders\OrderParts;


use Ecjia\App\Cart\CreateOrders\OrderPartAbstract;
use \Ecjia\App\Cart\Models\CartModel;
use \Ecjia\App\User\Models\UserAddressModel;


class OrderAddressPart extends OrderPartAbstract
{

    protected $part_key = 'address';
    
    protected $address_id;
    
    protected $user_id;

    public function __construct($address_id, $user_id, $flow_type)
    {
        $this->address_id 		= $address_id;
        $this->user_id 			= $user_id;
        $this->flow_type 		= $flow_type;
        $this->data 			= $this->order_consignee();
    }
	
    /**
     * 收货人信息
     * @return \ecjia_error|array
     */
	public function consigneeInfo()
	{
		$consignee = [];
		if ($this->address_id == 0) {
			if ($this->user_id > 0) {
				/* 取默认地址 */
				$consignee = \Ecjia\App\User\UserAddress::UserDefaultAddressInfo($this->user_id);
			}
		} else {
			$consignee = UserAddressModel::where('address_id', $this->address_id)
			->where('user_id', $this->user_id)
			->first();
			if ($consignee) {
				$consignee = $consignee->toArray();
			}
		}
		
		/*检查收货人地址*/
		$check_result = $this->check_consignee_info($consignee);
		if (!$check_result) {
			return new \ecjia_error('pls_fill_in_consinee_info', __('请完善收货人信息！', 'cart'));
		}
		
		return $consignee;
	}
	
	/**
	 * 订单收货人信息
	 */
	public function order_consignee()
	{
		/* 订单收货人信息 */
		$order_consignee_fields = ['consignee', 'country', 'province', 'city', 'district', 'street', 'address'];
		$order_consignee = [];
		$consignee = $this->consigneeInfo();
		if (!is_ecjia_error($consignee) && !empty($consignee)) {
			foreach ($consignee as $key => $value) {
				if (in_array($key, $order_consignee_fields)) {
					$order_consignee[$key] = addslashes($value);
				}
				if($key == 'address_info'){
					$order_consignee['address'] = $order_consignee['address'].$value;
				}
			}
		}
		
		return $order_consignee;
	}
	
	/**
	 * 检查收货人信息是否完整
	 * @param   array   $consignee  收货人信息
	 * @param   int	 $flow_type  购物流程类型
	 * @return  bool	true 完整 false 不完整
	 */
	protected function check_consignee_info($consignee)
	{
		if ($this->exist_real_goods()) {
			/* 如果存在实体商品 */
			$res = !empty($consignee['consignee']) &&
			!empty($consignee['country']);
			if ($res) {
				if (empty($consignee['province'])) {
					/* 没有设置省份，检查当前国家下面有没有设置省份 */
					$pro = with(new \Ecjia\App\Setting\Region)->getSubarea($consignee['country']);
					$res = empty($pro);
				} elseif (empty($consignee['city'])) {
					/* 没有设置城市，检查当前省下面有没有城市 */
					$city = with(new \Ecjia\App\Setting\Region)->getSubarea($consignee['province']);
					$res = empty($city);
				} elseif (empty($consignee['district'])) {
					$res = true;
				}
			}
			return $res;
		} else {
			/* 如果不存在实体商品 */
			return !empty($consignee['consignee']) &&
			!empty($consignee['tel']);
		}
	}
	
	
	/**
	 * 查询购物车中是否有实体商品
	 * @param   int	 $flow_type  购物流程类型
	 * @return  bool
	 */
	protected function exist_real_goods() {
		$count = CartModel::where('user_id', $this->user_id)->where('is_real', 1)->where('rec_type', $this->flow_type)->count();
		return $count > 0;
	}

}