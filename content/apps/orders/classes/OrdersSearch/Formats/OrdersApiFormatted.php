<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-03
 * Time: 19:00
 */

namespace Ecjia\App\Orders\OrdersSearch\Formats;


use Ecjia\App\Orders\Models\OrdersModel;
use Ecjia\App\Orders\OrderStatus;
use Ecjia\App\Orders\GoodsAttr;

class OrdersApiFormatted
{

    /**
     * @var OrdersModel
     */
    protected $model;
    
    public function __construct(OrdersModel $model)
    {
        $this->model = $model;
    }

    public function toArray()
    {
    	//计算订单总价格
    	$total_fee    = $this->model->goods_amount + $this->model->shipping_fee + $this->model->insure_fee + $this->model->pay_fee + $this->model->pack_fee + $this->model->card_fee + $this->model->tax - $this->model->integral_money - $this->model->bonus - $this->model->discount;
    	
    	list($label_order_status, $status_code) = OrderStatus::getOrderStatusLabel($this->model->order_status, $this->model->shipping_status, $this->model->pay_status, $this->model->payment_model->is_cod);

    	list($order_mode, $label_order_mode) = $this->getOrderModeLabel();
    	
    	list($total_goods_number, $goods_list) = $this->getFormatOrderGoods();
    	
    	$order_arr = [
	    	//store_info
	    	'store_id' 					=> $this->model->store_id,
	    	'store_name'				=> $this->model->store_franchisee_model->merchants_name,
			'seller_id'					=> $this->model->store_id,
			'seller_name'				=> $this->model->store_franchisee_model->merchants_name,
			'manage_mode'				=> $this->model->store_franchisee_model->manage_mode,
			//order_info 
			'order_id'					=> $this->model->order_id,
			'order_sn'					=> $this->model->order_sn,
			'extension_code'			=> empty($this->model->extension_code) ? null : $this->model->extension_code,
			'extension_id'				=> empty($this->model->extension_id) ? 0 : $this->model->extension_id,
			'order_amount'				=> $this->model->order_amount,
			'order_status'				=> $this->model->order_status,
			'shipping_status'			=> $this->model->shipping_status,
			'pay_status'				=> $this->model->pay_status,
			'pay_code'					=> $this->model->payment_model->pay_code,
			'is_cod'					=> $this->model->payment_model->is_cod,
			'label_order_status'		=> $label_order_status,
			'order_status_code'			=> $status_code,
			'order_time'				=> ecjia_time_format($this->model->add_time),
			'total_fee'					=> number_format($total_fee, 2, '.', ''),
			'discount'					=> $this->model->discount,
			'goods_number'				=> $total_goods_number,
			'formated_total_fee'      	=> ecjia_price_format($total_fee, false),
			'formated_integral_money' 	=> ecjia_price_format($this->model->integral_money, false),
			'formated_bonus'          	=> ecjia_price_format($this->model->bonus, false),
			'formated_shipping_fee'   	=> ecjia_price_format($this->model->shipping_fee, false),
			'formated_discount'       	=> ecjia_price_format($this->model->discount, false),
			
			'order_info'				=> [
												'pay_code'		=> $this->model->payment_model->pay_code,
												'order_amount'	=> $this->model->order_amount,
												'order_id'		=> $this->model->order_id,
												'order_sn'		=> $this->model->order_sn
											],
			'order_mode'				=> $order_mode,
			'label_order_mode'			=> $label_order_mode,
			'goods_list'				=> $goods_list
    	];
    	
    	//团购订单情况处理；增加返回几个字段
    	if ($this->model->extension_code == 'group_buy' && $this->model->extension_id > 0) {
    		$order_arr = $this->groupBuyOrderHandle($order_arr);
    	}
    	
    	return $order_arr;
    }
    
    /**
     * 订单模式处理
     * @return array
     */
    protected function getOrderModeLabel()
    {
    	if (in_array($this->model->extension_code, array('storebuy', 'cashdesk'))) {
    		$order_mode       = 'storebuy';
    		$label_order_mode = __('扫码购', 'orders');
    	} elseif ($this->model->extension_code == 'storepickup') {
    		$order_mode       = 'storepickup';
    		$label_order_mode = __('自提', 'orders');
    	} elseif ($this->model->extension_code == 'group_buy') {
    		$order_mode       = 'groupbuy';
    		$label_order_mode = __('团购', 'orders');
    	} else {
    		$order_mode       = 'default';
    		$label_order_mode = __('配送', 'orders');
    	}
    	return array($order_mode, $label_order_mode);
    }
    
    /**
     * 订单商品处理
     * @return array
     */
    protected function getFormatOrderGoods()
    {
    	$goods_list = [];
    	$goods_number = 0;
    	
    	if ($this->model->order_goods_collection) {
    		$goods_list = $this->model->order_goods_collection->map(function ($item) use (&$goods_number) {
    			$attr         = GoodsAttr::decodeGoodsAttr($item->goods_attr);
    			$subtotal     = $item->goods_price * $item->goods_number;
    			$goods_number += $item->goods_number;
    		
    			if ($item->product_id > 0) {
    				if (!empty($item->products_model->product_thumb)) {
    					$goods_thumb = $item->products_model->product_thumb;
    				}
    				if (!empty($item->products_model->product_img)) {
    					$goods_img = $item->products_model->product_img;
    				}
    				if (!empty($item->products_model->product_original_img)) {
    					$original_img = $item->products_model->product_original_img;
    				}
    			}
    		
    			$data = [
    				'id'                  => $item->goods_id,
    				'name'				  => $item->goods_name,
	    			'goods_id'            => $item->goods_id,
	    			'goods_name'		  => $item->goods_name,
	    			'goods_attr_id'       => $item->goods_attr_id,
	    			'goods_attr'          => $attr,
	    			'goods_number'        => $item->goods_number,
	    			'subtotal'            => ecjia_price_format($subtotal, false),
	    			'formated_shop_price' => ecjia_price_format($item->goods_price, false),
	    			'img'                 => [
								    			'small' => !empty($goods_thumb) ? ecjia_upload_url($goods_thumb) : ecjia_upload_url($item->goods_model->goods_img),
								    			'thumb' => !empty($goods_img) ? ecjia_upload_url($goods_img) : ecjia_upload_url($item->goods_model->goods_thumb),
								    			'url'   => !empty($original_img) ?  ecjia_upload_url($original_img) : ecjia_upload_url($item->goods_model->original_img),
							    			],
	    			'is_commented'        => empty($item->comment_model->comment_id) ? 0 : 1,
	    			'is_showorder'        => empty($item->comment_model->has_image) ? 0 : 1,
    			];
    			
    			return $data;
    		})->toArray();
    	}
    	
    	return [$goods_number, $goods_list];
    }
    
    /**
     * 团购订单情况处理；增加返回几个字段
     * @param array $order_arr
     * @return array
     */
    protected function groupBuyOrderHandle($order_arr)
    {
    	$has_deposit = 0;
    	$order_deposit = 0;
    	if ($this->model->goods_activity_model) {
    		$goods_activity_model = $this->model->goods_activity_model;
    		$ext_info = unserialize ($goods_activity_model->ext_info);
    		if (array_key_exists('deposit', $ext_info)) {
    			if ($ext_info['deposit'] > 0) {
    				 if ($goods_activity_model->is_finished == GBS_SUCCEED) {
    				 	$has_deposit = 1;
    				 }
    				 $order_deposit = $order_arr['goods_number']*$ext_info['deposit'];
    			}
    		}
    	}
    	$order_arr['has_deposit'] 			= $has_deposit;
    	$order_arr['order_deposit']			= $order_deposit;
    	$order_arr['formated_order_deposit']= ecjia_price_format($order_deposit, false);
    	$order_arr['formated_order_amount'] = ecjia_price_format($order_arr['order_amount'], false);
    	return $order_arr;
    }
    
}