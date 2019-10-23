<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-03
 * Time: 19:52
 */

namespace Ecjia\App\Affiliate\AffiliateStore\Collections;


use Ecjia\App\Affiliate\Models\AffiliateOrderCommissionModel;
use ecjia_page;
use RC_Time;


class AffiliateOrderCommissionCollection
{
    protected $store_id = [];

    protected $filters;

    public function __construct($agent_id = 0, array $filters = [])
    {
        $this->agent_id = $agent_id;

        $this->filters = $filters;
    }

    /**
	 *代理商分佣记录（分钱的数据）
     */
    public function getData()
    {
    	$filters = $this->filters;
    	
    	$page = empty($this->filters['page']) ? 1 : $this->filters['page'];
    	$size = empty($this->filters['size']) ? '15' : $this->filters['size'];
    	
    	$query = AffiliateOrderCommissionModel::with([
    			'order_info_model',
    			'quickpay_orders_model'
    	]);
    	
    	//代理商分佣金额大于0的
    	$query->where('affiliate_order_commission.agent_amount', '>', 0);
    	
    	//代理商
    	if (!empty($this->agent_id)) {
    		$query->where('affiliate_order_commission.affiliate_store_id', $this->agent_id);
    	}
    	
    	//分佣状态
    	if (!empty($filters['status'])){
    		if ($filters['status'] == 'await_separate') {
    			$query->where('affiliate_order_commission.status', 0);
    		} else {
    			$query->where('affiliate_order_commission.status', 1);
    		}
    	}
    	
        $count = $query->count();

        $ecjia_page = new ecjia_page($count, $size, 6, '', $page);

        $pager = array(
        		'total' => $ecjia_page->total_records,
        		'count' => $ecjia_page->total_records,
        		'more'  => $ecjia_page->total_pages <= $page ? 0 : 1,
        );
        
        $affiliate_order_commission = $query->skip($ecjia_page->start_id - 1)->take($ecjia_page->page_size)->orderBy('affiliate_order_commission.add_time', 'desc')->get();
        
        
        $data['list'] = $this->affiliateOrderCommissionList($affiliate_order_commission);
        
        $data['pager'] = $pager;
        
        return $data;
    }
    
    /**
	 *分佣数据格式化处理
     */
    protected function affiliateOrderCommissionList($affiliate_order_commission)
    {
    	$list = [];
    	$agent_id = $this->agent_id;
    	if (!empty($affiliate_order_commission)) {
    		$collection_list = $affiliate_order_commission->map(function ($val) use ($agent_id){
				$formatted_order_time = '';
				$referrer = null;
				$goods_list = [];
				if ($val->order_type == 'quickpay') {
					if ($val->quickpay_orders_model) {
						$formatted_order_time = empty($val->quickpay_orders_model->add_time) ? '' : RC_Time::local_date('Y-m-d H:i:s', $val->quickpay_orders_model->add_time);
					}
				} else {
					if ($val->order_info_model) {
						$formatted_order_time = empty($val->order_info_model->add_time) ? '' : RC_Time::local_date('Y-m-d H:i:s', $val->order_info_model->add_time);
					}
					$goods_list = $this->formattedOrderGoods($val->order_info_model);
				}
				if ($val->store_franchisee_model->affiliate_store_record_model) {
					$affiliate_store_record_model = $val->store_franchisee_model->affiliate_store_record_model;
					if ($affiliate_store_record_model->affiliate_store_model) {
						if ($affiliate_store_record_model->affiliate_store_model->id != $agent_id) {
							$referrer = $affiliate_store_record_model->affiliate_store_model->agent_name;
						}
					}
				}
				
    			$arr = [
	    				'order_id' 						=> intval($val->order_id),
	    				'order_sn' 						=> trim($val->order_sn),
	    				'formatted_order_time'			=> $formatted_order_time,
	    				'log_id'						=> intval($val->id),
	    				'affiliated_amount'				=> $val->agent_amount,
	    				'type'							=> $val->order_type,
    					'formatted_affiliated_amount'	=> ecjia_price_format($val->agent_amount, false),
    					'referrer'						=> $referrer,
    					'goods_list'					=> $goods_list
	    			];
    			
    			return $arr;
    		});
    		$list = $collection_list->toArray();
    	}
    	
    	return $list;
    }
    
    /**
     *代理商分佣记录（分钱的数据）
     */
    public function getStoreAgentAffiliateIntegralData()
    {
    	$filters = $this->filters;
    	 
    	$page = empty($this->filters['page']) ? 1 : $this->filters['page'];
    	$size = empty($this->filters['size']) ? '15' : $this->filters['size'];
    	 
    	$query = AffiliateOrderCommissionModel::with([
	    			'order_info_model',
	    			'quickpay_orders_model'
    		   ]);
    	 
    	//代理商分佣积分数大于0的
    	$query->where('affiliate_order_commission.agent_integral', '>', 0);
    	 
    	//代理商
    	if (!empty($this->agent_id)) {
    		$query->where('affiliate_order_commission.affiliate_store_id', $this->agent_id);
    	}
    	 
    	//分佣状态
    	if (!empty($filters['status'])){
    		if ($filters['status'] == 'await_separate') {
    			$query->where('affiliate_order_commission.status', 0);
    		} else {
    			$query->where('affiliate_order_commission.status', 1);
    		}
    	}
    	 
    	$count = $query->count();
    
    	$ecjia_page = new ecjia_page($count, $size, 6, '', $page);
    
    	$pager = array(
    			'total' => $ecjia_page->total_records,
    			'count' => $ecjia_page->total_records,
    			'more'  => $ecjia_page->total_pages <= $page ? 0 : 1,
    	);
    
    	$affiliate_order_commission = $query->skip($ecjia_page->start_id - 1)->take($ecjia_page->page_size)->orderBy('affiliate_order_commission.add_time', 'desc')->get();
    
    	$data['list'] = $this->affiliateOrderIntegralCommissionList($affiliate_order_commission);
    
    	$data['pager'] = $pager;
    
    	return $data;
    }
    
    /**
     *分佣数据格式化处理
     */
    protected function affiliateOrderIntegralCommissionList($affiliate_order_commission)
    {
    	$list = [];
    	$agent_id = $this->agent_id;
    	if (!empty($affiliate_order_commission)) {
    		$collection_list = $affiliate_order_commission->map(function ($val) use ($agent_id){
    			$formatted_order_time = '';
    			$referrer = null;
    			$goods_list = [];
    			if ($val->order_type == 'quickpay') {
    				if ($val->quickpay_orders_model) {
    					$formatted_order_time = empty($val->quickpay_orders_model->add_time) ? '' : RC_Time::local_date('Y-m-d H:i:s', $val->quickpay_orders_model->add_time);
    					$goods_list = $this->quickpayOrderGoods($val->quickpay_orders_model);
    				}
    			} else {
    				if ($val->order_info_model) {
    					$formatted_order_time = empty($val->order_info_model->add_time) ? '' : RC_Time::local_date('Y-m-d H:i:s', $val->order_info_model->add_time);
    				}
    				$goods_list = $this->formattedOrderGoods($val->order_info_model);
    			}
    			if ($val->store_franchisee_model->affiliate_store_record_model) {
    				$affiliate_store_record_model = $val->store_franchisee_model->affiliate_store_record_model;
    				if ($affiliate_store_record_model->affiliate_store_model) {
    					if ($affiliate_store_record_model->affiliate_store_model->id != $agent_id) {
    						$referrer = $affiliate_store_record_model->affiliate_store_model->agent_name;
    					}
    				}
    			}
    
    			$arr = [
	    			'order_id' 						=> intval($val->order_id),
	    			'order_sn' 						=> trim($val->order_sn),
	    			'formatted_order_time'			=> $formatted_order_time,
	    			'log_id'						=> intval($val->id),
	    			'affiliated_amount'				=> $val->agent_amount,
	    			'formatted_affiliated_amount'	=> ecjia_price_format($val->agent_amount, false),
	    			'affiliated_integral'			=> intval($val->agent_integral),
	    			'type'							=> $val->order_type,
	    			'referrer'						=> $referrer,
	    			'goods_list'					=> $goods_list
    			];
    			 
    			return $arr;
    		});
    		$list = $collection_list->toArray();
    	}
    	 
    	return $list;
    }
    
    /**
	 *订单商品格式化处理
     */
    protected function formattedOrderGoods($order_info_model)
    {
    	$list = [];
    	$goods_list = $order_info_model->order_goods_collection;
    	if ($goods_list) {
    		$list = $goods_list->map(function($val){
    			$small = ''; $thumb = ''; $url = '';
    			if ($val->goods_model) {
    				$small = empty($val->goods_model->goods_img) ? '' : \RC_Upload::upload_url($val->goods_model->goods_img);
    				$thumb = empty($val->goods_model->goods_thumb) ? '' : \RC_Upload::upload_url($val->goods_model->goods_thumb);
    				$url   = empty($val->goods_model->original_img) ? '' : \RC_Upload::upload_url($val->goods_model->original_img);
    			}
    			$arr = [
    				'goods_id' 				=> intval($val->goods_id),
    				'goods_name'			=> trim($val->goods_name),
    				'goods_sn'				=> trim($val->goods_sn),
    				'goods_number'			=> intval($val->goods_number),
    				'goods_price'			=> $val->goods_price,
    				'formatted_goods_price'	=> ecjia_price_format($val->goods_price, false),
    				'img'					=> array(
    												'small' => $small,
    												'thumb' => $thumb,
    												'url'	=> $url	
    											)
    			];
    			return $arr;
    		});
    	  $list = $list->toArray();
    	}
    	return $list;
    }
    
    /**
	 *买单订单模拟订单商品数据结构
     */
    protected function quickpayOrderGoods($quickpay_orders_model)
    {
    	$small = ''; $thumb = ''; $url = '';
    	$total_order_amount = $quickpay_orders_model->goods_amount - $quickpay_orders_model->discount - $quickpay_orders_model->integral_money - $quickpay_orders_model->bonus;
    	$arr = [
    		'goods_id' 				=> 0,
    		'goods_name'			=> $quickpay_orders_model->quickpay_activity_model ? $quickpay_orders_model->quickpay_activity_model->title : '优惠买单',
    		'goods_sn'				=> '',
    		'goods_number'			=> 0,
    		'goods_price'			=> sprintf("%.2f",$total_order_amount),
    		'formatted_goods_price'	=> ecjia_price_format($total_order_amount, false),
    		'img'					=> ['small' => $small, 'thumb' => $thumb, 'url' => $url],
    	];
    	
    	$list = [$arr];
    	
    	return $list;
    }
}