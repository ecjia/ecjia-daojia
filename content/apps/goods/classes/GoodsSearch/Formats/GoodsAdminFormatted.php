<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-03
 * Time: 19:00
 */

namespace Ecjia\App\Goods\GoodsSearch\Formats;


use Ecjia\App\Goods\Models\GoodsModel;
use RC_Upload;
use ecjia;

class GoodsAdminFormatted
{

    /**
     * @var GoodsModel
     */
    protected $model;
    
    protected $user_rank_discount;
    
    protected $user_rank;
    
    public function __construct(GoodsModel $model, $user_rank_discount = 1, $user_rank = 0)
    {
        $this->model = $model;
        $this->user_rank_discount = $user_rank_discount;
        $this->user_rank = $user_rank;
    }

    public function toArray()
    {

        return [
            //store info
            'store_id' 					=> $this->model->store_id,
            'store_name'				=> $this->model->store_franchisee_model->merchants_name,
            'merchants_name'			=> $this->model->store_franchisee_model->merchants_name,
            'manage_mode' 				=> $this->model->store_franchisee_model->manage_mode,

            //goods info
            'goods_id' 					=> $this->model->goods_id,
            'goods_name' 				=> $this->filterGoodsName($this->model->goods_name),
            'goods_sn' 					=> $this->filterGoodsSn($this->model->goods_sn),
            'goods_barcode' 			=> $this->filterGoodsBarcode($this->model->goods_barcode),
            'goods_type'                => $this->model->goods_type,
            'shop_price'                => $this->model->shop_price,
            'market_price'              => $this->model->market_price,
            'cost_price'                => $this->model->cost_price,
            'goods_thumb'               => empty($this->model->goods_thumb) ? \RC_Uri::admin_url('statics/images/nopic.png') : RC_Upload::upload_url($this->model->goods_thumb),
            'is_on_sale'                => $this->model->is_on_sale,
            'is_best'                   => $this->model->is_best,
            'is_new'                    => $this->model->is_new,
            'is_hot'                    => $this->model->is_hot,
            'store_best'             	=> $this->model->store_best,
            'store_new'              	=> $this->model->store_new,
            'store_hot'              	=> $this->model->store_hot,
            'sort_order'                => $this->model->sort_order,
            'goods_number'              => $this->model->goods_number,
            'sales_volume'              => $this->model->sales_volume,
            'weight_unit'               => $this->model->weight_unit,
            'integral'                  => $this->model->integral,
            'is_promote'                => $this->model->is_promote,
            'review_status'             => $this->model->review_status,
            'add_time'             		=> \RC_Time::local_date(ecjia::config('time_format'), $this->model->add_time),
            'has_product'               => count($this->model->products_collection) > 1 ? 1 : 0,
        ];
    }

    /**
     * 商品主图信息处理
     * @param int $product_id
     * @return array
     */
    protected function filterGoodsImg($product_id)
    {
    	$img = [
    		'thumb' => $this->model->goods_thumb ? \RC_Upload::upload_url($this->model->goods_thumb) : '',
    		'url'     => $this->model->original_img ? \RC_Upload::upload_url($this->model->original_img) : '',
    		'small'   => $this->model->goods_img ? \RC_Upload::upload_url($this->model->goods_img) : '',
    	];
    	if ($product_id > 0) {
    		if (!empty($this->model->product_thumb)) {
    			$img['thumb'] = \RC_Upload::upload_url($this->model->product_thumb);
    		}
    		if (!empty($this->model->product_original_img)) {
    			$img['url'] = \RC_Upload::upload_url($this->model->product_original_img);
    		}
    		if (!empty($this->model->product_img)) {
    			$img['small'] = \RC_Upload::upload_url($this->model->product_img);
    		}
    	}
    	
    	return $img;
    }
    
    protected function filterGoodsBarcode($goods_barcode)
    {
        return $goods_barcode;
    }

    protected function filterGoodsSn($goods_sn)
    {
        return $this->model->product_sn ?: $goods_sn;
    }

    /**
     * 过滤product_name
     * @param $goods_name
     * @return mixed
     */
    protected function filterGoodsName($goods_name)
    {
        return $this->model->product_name ?: $goods_name;
    }

}