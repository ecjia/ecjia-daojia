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

    protected $model;

    public function __construct($user_id, $store_id, $cart_type)
    {
        $this->user_id   = $user_id;
        $this->store_id  = $store_id;
        $this->cart_type = $cart_type;

        $this->model = new CartModel();
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
        $data = $this->model
            ->where('rec_type', $this->cart_type)
            ->where('user_id', $this->user_id)
             ->where('store_id', $this->store_id)
            ->orderBy('add_time', 'desc')->orderBy('rec_id', 'desc')
            ->get();

        $data = $this->mapGoodsCollection($data);

        return $data;
    }


    public function mapGoodsCollection(Collection $data)
    {
        $store_price = new CartStorePrice($this->store_id);

        $result = $data->map(function($item) use ($store_price) {

            $inst_goods = new CartGoods($item);
            $inst_price = new CartPrice($item);
            $inst_store = new CartStore($item);

            $store_price->addPrice($inst_price);

            return $inst_goods->formattedHandleData();

        });

        $total = $store_price->computeTotalPrice();

        return array('goods_list' => $result, 'total' => $total);
    }


}