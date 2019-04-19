<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-15
 * Time: 15:47
 */

class ecjia_cart_groupbuy extends ecjia_cart
{

    protected $activity_type = 'GROUPBUY_GOODS';

    protected $activity_id;

    public function __construct($store_id, $token = null)
    {
        parent::__construct($store_id, $token);

        $this->storage_key = 'cart_goods' . $this->token . $store_id . $this->longitude . $this->latitude . $this->city_id . $this->activity_type . $this->activity_id;
    }

    /**
     * 添加商品到购物车
     * @param $goods_id
     * @param int $product_id
     * @param null $spec
     * @param int $number
     * @return array|ecjia_error|void
     * @throws Exception
     */
    public function createCart($goods_id, $product_id = 0, $spec = null, $number = 1)
    {
        throw new Exception(__('请使用 createCartWithGroupBuy() 创建购物车', 'h5'));
    }

    /**
     * 创建团购活动的购物车
     * @param $act_id
     * @param $goods_id
     * @param int $product_id
     * @param null $spec
     * @param int $number
     * @return array|ecjia_error
     */
    public function createCartWithGroupBuy($act_id, $goods_id, $product_id = 0, $spec = null, $number = 1)
    {
        $data = array(
            'token'             => $this->token,
            'location'          => array('longitude' => $this->longitude, 'latitude' => $this->latitude),
            'city_id'           => $this->city_id,
            'seller_id'         => $this->store_id,
            'goods_id'          => $goods_id,
            'product_id'        => $product_id,
            'number'            => $number,
            'rec_type'          => 'GROUPBUY_GOODS',
            'goods_activity_id' => $act_id,
        );

        if ($spec != 'false' && !empty($spec)) {
            $data['spec'] = $spec;
        }

        $result = ecjia_touch_manager::make()->api(ecjia_touch_api::CART_CREATE)->data($data)->run();


        return $result;
    }


    public function getCartList()
    {
        $data = array(
            'token'     => $this->token,
            'seller_id' => $this->store_id,
            'location'  => array('longitude' => $this->longitude, 'latitude' => $this->latitude),
            'city_id'   => $this->city_id,
            'rec_type'  => $this->activity_type,
        );

        $result = ecjia_touch_manager::make()->api(ecjia_touch_api::CART_LIST)->data($data)->run();

        return $result;
    }

}