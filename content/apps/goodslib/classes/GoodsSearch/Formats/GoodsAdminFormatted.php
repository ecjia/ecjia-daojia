<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-03
 * Time: 19:00
 */

namespace Ecjia\App\Goodslib\GoodsSearch\Formats;


use Ecjia\App\Goodslib\Models\GoodslibModel;
use RC_Upload;

class GoodsAdminFormatted
{

    protected $model;
    
    protected $user_rank_discount;
    
    protected $user_rank;
    
    public function __construct(GoodslibModel $model)
    {
        $this->model = $model;
    }

    public function toArray()
    {

        $formatted = [
            //store info
            'store_id' 					=> $this->model->store_id,
            'store_name'				=> $this->model->store->merchants_name,
            'merchants_name'			=> $this->model->store->merchants_name,
            'manage_mode' 				=> $this->model->store->manage_mode,

            //goods info
            'goods_id' 					=> $this->model->goods_id,
            'goods_name' 				=> $this->filterGoodsName($this->model->goods_name),
            'goods_sn' 					=> $this->filterGoodsSn($this->model->goods_sn),
            'goods_barcode' 			=> $this->filterGoodsBarcode($this->model->goods_barcode),
            'goods_number'              => $this->model->goods_number,
            'shop_price'                => $this->model->shop_price,
            'market_price'              => $this->model->market_price,
            'goods_weight'              => $this->model->goods_weight,
            'sort_order'                => $this->model->sort_order,
            'is_display'                => $this->model->is_display,
            'has_products'              => $this->model->goodslib_products_collection->isNotEmpty() ? 1 : 0,
        ];

        if ($this->model->goods_thumb) {
            $formatted['goods_thumb'] = RC_Upload::upload_url($this->model->goods_thumb);
        } else {
            $formatted['goods_thumb'] = \RC_Uri::admin_url('statics/images/nopic.png');
        }

        return $formatted;
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