<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-19
 * Time: 18:04
 */

namespace Ecjia\App\Cart\CartFlow;


use Ecjia\App\Cart\Models\CartModel;
use Royalcms\Component\Database\Eloquent\Collection;

class Cart
{

    protected $user_id;

    protected $store_id;

    protected $cart_type;

    protected $extension_code;

    protected $default = [
        'shop_close' => 0, //店铺不关闭

    ];

    protected $item = [];

    protected $model;

    public function __construct($user_id, $store_id, $cart_type, $cart_id = [])
    {
        $this->user_id   = $user_id;
        $this->store_id  = $store_id;
        $this->cart_type = $cart_type;
        $this->cart_id	 = $cart_id;

        $this->model = new CartModel();
    }

    public function setCartData($key, $value)
    {
        $this->item[$key] = $value;

        return $this;
    }

    public function getCartData($key)
    {
        return array($this->item, $key);
    }

    /**
     * 获得购物车中的商品
     */
    public function getGoodsCollection()
    {
        /**
         * IF(c.parent_id, c.parent_id, c.goods_id) AS pid,
         * s.merchants_name as store_name, manage_mode
         * g.goods_thumb, g.goods_img, g.original_img, g.goods_number as g_goods_number, g.is_on_sale, g.is_delete
         */
        /* 循环、统计 */
        if (is_array($this->cart_id) && !empty($this->cart_id)) {
        	$data = $this->model
        	->where('rec_type', $this->cart_type)
        	->where('user_id', $this->user_id)
        	->where('store_id', $this->store_id)
        	->whereIn('rec_id', $this->cart_id)
        	->orderBy('add_time', 'desc')->orderBy('rec_id', 'desc')
        	->get();
        } else {
        	$data = $this->model
        	->where('rec_type', $this->cart_type)
        	->where('user_id', $this->user_id)
        	->where('store_id', $this->store_id)
        	->orderBy('add_time', 'desc')->orderBy('rec_id', 'desc')
        	->get();
        }

        $data = $this->mapGoodsCollection($data);

        return $data;
    }


    public function mapGoodsCollection(Collection $data)
    {
        $store_price = new CartStorePrice($this->store_id);
        $store		 = new CartStore($this->store_id); 
        
        $result = $data->map(function($item) use ($store_price) {

            $inst_goods = new CartGoods($item);
            $inst_price = new CartPrice($item);
            $store_price->addPrice($inst_price);

            return $inst_goods->formattedHandleData();

        });
        //店铺优惠活动及优惠金额小计
        $store_fav 	 = new CartStoreFavourable($result, $this->store_id, $this->user_id);
        $fav_list = $store_fav->StoreCartFavourableActivity();
        $store_price->addDiscount($fav_list);

        //店铺购物车小计
        $total = $store_price->computeTotalPrice();
        
        //店铺信息
        $store_info = $store->storeInFo();
        
        $res = [];
        $res['store_id'] 	= $store_info['store_id'];
        $res['store_name'] 	= $store_info['merchants_name'];
        $res['manage_mode'] = $store_info['manage_mode'];
        $res['user_id'] 	= $this->user_id;

        $res['goods_list'] = $result;
        $res['favourable_activity'] = empty($fav_list['store_fav_activity']) ? [] : $fav_list['store_fav_activity'];
        $res['total']	   = $total;
       
        return $res;
    }


}