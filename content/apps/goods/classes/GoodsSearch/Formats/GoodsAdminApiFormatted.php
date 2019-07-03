<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-03
 * Time: 19:00
 */

namespace Ecjia\App\Goods\GoodsSearch\Formats;


use Ecjia\App\Goods\Models\GoodsModel;
use ecjia;

class GoodsAdminApiFormatted
{

    /**
     * @var GoodsModel
     */
    protected $model;
    
    public function __construct(GoodsModel $model)
    {
        $this->model = $model;
    }

    public function toArray()
    {
    	$is_promote = $this->isPromote();
        /* 分享链接*/
        $share_link = '';
        $goods_id = intval($this->model->goods_id);
        $mobile_touch_url = ecjia::config('mobile_touch_url');
        if (!empty($mobile_touch_url)) {
            /*商品分享链接*/
            $share_link = ecjia::config('mobile_touch_url').'index.php?m=goods&c=index&a=show&goods_id='.$goods_id.'&hidenav=1&hidetab=1';
        } else {
            $share_link = null;
        }
        return [
            //goods info
            'id'							=> $this->model->goods_id,
            'name'							=> $this->model->goods_name,
            'goods_id' 						=> $this->model->goods_id,
            'goods_name' 					=> $this->model->goods_name,
            'goods_sn' 						=> $this->model->goods_sn,
            'goods_type'                	=> $this->model->goods_type,
            'market_price'              	=> ecjia_price_format($this->model->market_price, false),
            'shop_price'                	=> ecjia_price_format($this->model->shop_price, false),
            'is_promote'					=> $is_promote,
            'promote_price'					=> $is_promote > 0 ? ecjia_price_format($this->model->promote_price, false) : ecjia_price_format(0, false),
            'promote_start_date'			=> $this->model->promote_start_date,
            'promote_end_date'				=> $this->model->promote_end_date,
            'formatted_promote_start_date'	=> $this->model->promote_start_date ? \RC_Time::local_date('Y-m-d H:i:s', $this->model->promote_start_date) : '',
            'formatted_promote_end_date'	=> $this->model->promote_end_date ? \RC_Time::local_date('Y-m-d H:i:s', $this->model->promote_end_date) : '',
            'clicks'						=> intval($this->model->click_count),
            'stock'							=> (ecjia::config('use_storage') == 1) ? $this->model->goods_number : '',
            'goods_weight'					=> $this->filterGoodsWeight(),
            'is_best'             			=> $this->model->store_best,
            'is_new'              			=> $this->model->store_new,
            'is_hot'              			=> $this->model->store_hot,
            'is_shipping'					=> $this->model->is_shipping == 1 ? 1 : 0,
            'last_updatetime' 				=> \RC_Time::local_date(ecjia::config('time_format'), $this->model->last_update),
            'sales_volume'					=> $this->model->sales_volume,
            'img'							=> [
										    		'thumb' 	=> $this->model->goods_thumb ? \RC_Upload::upload_url($this->model->goods_thumb) : '',
										    		'url'     	=> $this->model->original_img ? \RC_Upload::upload_url($this->model->original_img) : '',
										    		'small'   	=> $this->model->goods_img ? \RC_Upload::upload_url($this->model->goods_img) : '',
										    	],
			'has_product'               	=> count($this->model->products_collection) > 0 ? 'yes' : 'no',
            'share_link'                    => $share_link,
        ];
    }
    
    
    /**
     * 商品是否在促销
     */
    protected function isPromote()
    {
    	$time = \RC_Time::gmtime();
    	$is_promote = 0;
    	if ($this->model->promote_price > 0 && $this->model->promote_start_date <= $time && $this->model->promote_end_date >= $time && $this->model->is_promote == '1') {
    		$is_promote = 1;
    	}
    	return $is_promote;
    }
    
    /**
     * 商品重量处理
     */
    protected function filterGoodsWeight()
    {
    	$goods_weight_string = '';
    	if ($this->model->goods_weight > 0) {
    		if (empty($this->model->weight_unit)) {
    			if ($this->model->goods_weight >= 1) {
    				$goods_weight_string = $this->model->goods_weight.__('千克', 'goods');
    			} else {
    				$goods_weight_string = ($this->model->goods_weight * 1000).__('克', 'goods');
    			}
    		} else {
    			if ($this->model->weight_unit == 2 ) {
    				$goods['goods_weight_string'] = $goods['goods_weight'].'千克';
    			} else {
    				if ($this->model->goods_weight < 1){
    					$str = '克';
    					$goods_weight = $goods['goods_weight']*1000;
    				} else {
    					$str = '克';
    					$goods_weight = $goods['goods_weight'];
    				}
    				$goods['goods_weight_string'] = $goods_weight.$str;
    			}
    		}
    	}
    	return $goods_weight_string;
    }
}