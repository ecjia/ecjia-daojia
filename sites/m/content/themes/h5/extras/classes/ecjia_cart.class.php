<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-15
 * Time: 15:47
 */

class ecjia_cart
{
    /**
     * 缓存key
     * @var string
     */
    protected $storage_key;

    /**
     * 店铺ID
     * @var
     */
    protected $store_id;

    /**
     * 登录token
     * @var
     */
    protected $token;

    /**
     * 城市ID
     * @var
     */
    protected $city_id;

    /**
     * 经度
     * @var
     */
    protected $longitude;

    /**
     * 纬度
     * @var
     */
    protected $latitude;

    public function __construct($store_id, $token = null)
    {
        $this->store_id = $store_id;

        if (is_null($token)) {
            $this->token = $token;
        } else {
            $this->token = ecjia_touch_user::singleton()->getToken();
        }

        $this->longitude = $_COOKIE['longitude'];
        $this->latitude  = $_COOKIE['latitude'];
        $this->city_id   = $_COOKIE['city_id'];

        $this->storage_key = 'cart_goods' . $this->token . $store_id . $this->longitude . $this->latitude . $this->city_id;
    }

    /**
     * 存储购物车缓存数据
     */
    public function saveLocalStorage($cart_list)
    {
        RC_Cache::app_cache_set($this->storage_key, $cart_list, 'cart');
    }

    /**
     * 取出购物车缓存数据
     */
    public function getLocalStorage()
    {
        //店铺购物车商品
        $cart_list = RC_Cache::app_cache_get($this->storage_key, 'cart');

        if (empty($cart_list['cart_list'])) {
            return $this->getServerCartData();
        }

        return $cart_list;
    }

    /**
     * 删除购物车缓存数据
     */
    public function deleteLocalStorage()
    {
        RC_Cache::app_cache_delete($this->storage_key, 'cart');
    }

    /**
     * 获取线上购物车数据
     * @return array|ecjia_error
     */
    public function getServerCartData()
    {
        $cart_list = array();

        if (ecjia_touch_user::singleton()->isSignin()) {
            $cart_list = $this->getCartList();
            if (! is_ecjia_error($cart_list)) {
                $this->saveLocalStorage($cart_list);
            }
        }

        return $cart_list;
    }


    public function getGoodsCartList($cart_list)
    {
        $goods_cart_list = array();
        if (!empty($cart_list)) {
            //单店铺购物车
            $cart_list = array_shift($cart_list['cart_list']);

            $goods_cart_list = collect($cart_list['goods_list'])->map(function ($item) {
                $goods_attr_id = array();
                if (!empty($item['goods_attr_id'])) {
                    $goods_attr_id = explode(',', $item['goods_attr_id']);
                    asort($goods_attr_id);
                }

                $product_id = $item['product_id'] ?: 0;

                return array(
                    'num'           => $item['goods_number'],
                    'id'            => $item['goods_id'] . '_' . $product_id,
                    'rec_id'        => $item['rec_id'],
                    'goods_id'      => $item['goods_id'],
                    'product_id'    => $product_id,
                    'goods_attr_id' => $goods_attr_id
                );
            })->all();

        }

        return $goods_cart_list;
    }

    /**
     * 格式化购物车返回的列表数据
     * @param $cart_list
     * @param null $spec
     * @return array
     */
    public function formattedCartGoodsList($cart_list, $spec = null)
    {
        $cart_goods_list = array();

        if (!empty($cart_list)) {
            //单店铺购物车
            $cart_list  = array_shift($cart_list['cart_list']);
            $cart_count = $cart_list['total'];

            $data_rec = [];
            $current  = [];

            $cart_goods_list = collect($cart_list['goods_list'])->map(function ($item) use (& $cart_count, & $data_rec, & $current, $spec) {
                if ($item['is_disabled'] == 0 && $item['is_checked'] == 1) {
                    $data_rec[] = $item['rec_id'];
                } elseif ($item['is_checked'] == 0) {
                    $cart_count['check_all']    = false; //全部选择
                    $cart_count['goods_number'] -= $item['goods_number'];
                }

                if (!empty($item['goods_attr_id'])) {
                    $goods_attr_id = explode(',', $item['goods_attr_id']);
                    if (!empty($spec) && !empty($goods_attr_id)) {
                        asort($spec);
                        asort($goods_attr_id);

                        if ($goods_attr_id == $spec) {
                            $current['rec_id']       = $item['rec_id'];
                            $current['goods_number'] = $item['goods_number'];
                        }
                    }
                }

                $item['id'] = $item['goods_id'] . '_' . $item['product_id'];

                return $item;
            })->all();

            $data_rec = implode(',', $data_rec);
        }

        return [$cart_goods_list, $data_rec, $current, $cart_count];
    }

    /**
     * 格式化商品祥情页的购物车数据
     * @param $cart_goods
     * @param $goods_id
     * @return mixed
     */
    public function formattedCartGoodsWithCurrentGoods($cart_goods, $goods_id, $product_id = 0)
    {
        //单店铺购物车
        $cart_list = array_shift($cart_goods['cart_list']);

        if (!empty($cart_list)) {

            $cart_list['total']['check_all'] = true;
            $cart_list['total']['check_one'] = false;

            $data_rec = [];

            $cart_list['goods_list'] = collect($cart_list['goods_list'])->map(function ($item) use (& $cart_list, & $data_rec, & $cart_goods, $goods_id, $product_id) {

                $goods_attr_id = array();
                if (!empty($item['goods_attr_id'])) {
                    $goods_attr_id = explode(',', $item['goods_attr_id']);
                    asort($goods_attr_id);
                }

                if ($item['is_checked'] == 1 && $item['is_disabled'] == 0) {
                    $cart_list['total']['check_one'] = true; //至少选择了一个
                    $data_rec[]                      = $item['rec_id'];
                } elseif ($item['is_checked'] == 0) {
                    $cart_list['total']['check_all']    = false; //全部选择
                    $cart_list['total']['goods_number'] -= $item['goods_number'];
                }
//                _dump($goods_id);
//                _dump($product_id,0);
//                _dump($item,0);
//                _dump(($goods_id == $item['goods_id'] && $product_id == $item['product_id']),1);
                if ($goods_id == $item['goods_id'] && $product_id == $item['product_id']) {
                    $cart_goods['current_goods']['goods_attr_num'] = $item['goods_number'];

                    $last_spec_str = implode(',', $cart_goods['goods_info']['last_spec']);
//                    dd($last_spec_str);
                    if ($last_spec_str == $item['goods_attr_id']) {
                        $cart_goods['goods_info']['last_spec']       = explode(',', $item['goods_attr_id']);
                        $cart_goods['current_goods']['rec_id']       = $item['rec_id'];
                        $cart_goods['current_goods']['goods_number'] = $item['goods_number'];
                        $cart_goods['current_spec']                  = $item;
                    }

                }

                $product_id = $item['product_id'] ?: 0;

                $cart_goods['arr'][] = array(
                    'num'           => $item['goods_number'],
                    'id'            => $item['goods_id'] . '_' . $product_id,
                    'rec_id'        => $item['rec_id'],
                    'goods_id'      => $item['goods_id'],
                    'product_id'    => $item['product_id'] ?: 0,
                    'goods_attr_id' => $goods_attr_id
                );

                $item['id'] = $item['goods_id'] . '_' . $item['product_id'];

                return $item;

            })->all();

//            $cart_goods['arr'] = $cart_goods_list;

            $cart_goods['current_seller']['data_rec'] = implode(',', $data_rec);

        } else {
            $cart_list['total']['check_all'] = false;
            $cart_list['total']['check_one'] = false;
        }

        $cart_goods['cart_list'] = $cart_list;

        return $cart_goods;
    }

    /**
     * 匹配购物车中的商品数据
     * @param $goods_id
     * @param $product_id
     * @param $goods_cart_list
     */
    public function matchingGoodsWithProduct($goods_id, $product_id, $goods_cart_list)
    {
        return collect($goods_cart_list)->contains(function ($item) use ($goods_id, $product_id) {
            return $item['goods_id'] == $goods_id && $item['product_id'] == $product_id;
        });
    }

    public function findGoodsWithProduct($goods_id, $product_id, $goods_cart_list)
    {
        $product = collect($goods_cart_list)->first(function ($item) use ($goods_id, $product_id) {
            return $item['goods_id'] == $goods_id && $item['product_id'] == $product_id;
        });

        if (!ecjia::config('show_product')) {
            if (empty($product)) {
                $product        = collect($goods_cart_list)->filter(function ($item) use ($goods_id) {
                    return $item['goods_id'] == $goods_id;
                });
                $num            = $product->pluck('num')->sum();
                $product        = $product->first();
                $product['num'] = $num;
            }
        }

        return $product;
    }

    /**
     * 添加商品到购物车
     * @param $goods_id
     * @param int $product_id
     * @return array|ecjia_error
     */
    public function createCart($goods_id, $product_id = 0, $spec = null, $number = 1)
    {
        $data = array(
            'token'      => $this->token,
            'location'   => array('longitude' => $this->longitude, 'latitude' => $this->latitude),
            'city_id'    => $this->city_id,
            'seller_id'  => $this->store_id,
            'goods_id'   => $goods_id,
            'product_id' => $product_id,
            'number'     => $number,
        );

        if ($spec != 'false' && !empty($spec)) {
            $data['spec'] = $spec;
        }

        $result = ecjia_touch_manager::make()->api(ecjia_touch_api::CART_CREATE)->data($data)->run();


        return $result;
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

    /**
     * 从购物车中删除商品
     * @param $rec_id
     */
    public function deleteCart($rec_id)
    {

        $data = array(
            'token'     => $this->token,
            'location'  => array('longitude' => $this->longitude, 'latitude' => $this->latitude),
            'city_id'   => $this->city_id,
            'seller_id' => $this->store_id,
            'rec_id'    => $rec_id,
        );

        $result = ecjia_touch_manager::make()->api(ecjia_touch_api::CART_DELETE)->data($data)->run();

        return $result;
    }

    /**
     * 更新购物车中商品
     * @param $rec_id
     */
    public function updateCart($rec_id, $number)
    {
        $data = array(
            'token'      => $this->token,
            'location'   => array('longitude' => $this->longitude, 'latitude' => $this->latitude),
            'city_id'    => $this->city_id,
            'seller_id'  => $this->store_id,
            'rec_id'     => $rec_id,
            'new_number' => $number,
        );

        $result = ecjia_touch_manager::make()->api(ecjia_touch_api::CART_UPDATE)->data($data)->run();

        return $result;
    }

    /**
     * 清空购物车
     * @param array $rec_ids 多个rec_id
     */
    public function clearCart(array $rec_ids)
    {
        $rec_id = implode(',', $rec_ids);

        return $this->deleteCart($rec_id);
    }

    /**
     * 修改购物车中商品选中状态
     * @param $rec_id
     */
    public function checkedCart($rec_id, $checked = 1)
    {
        if (is_array($rec_id)) {
            $rec_id = implode(',', $rec_id);
        }

        $data = array(
            'token'      => $this->token,
            'location'   => array('longitude' => $this->longitude, 'latitude' => $this->latitude),
            'city_id'    => $this->city_id,
            'seller_id'  => $this->store_id,
            'rec_id'     => $rec_id,
            'is_checked' => $checked,
        );

        $result = ecjia_touch_manager::make()->api(ecjia_touch_api::CART_CHECKED)->data($data)->run();

        return $result;
    }


    public function getCartList()
    {
        $data = array(
            'token'     => $this->token,
            'seller_id' => $this->store_id,
            'location'  => array('longitude' => $this->longitude, 'latitude' => $this->latitude),
            'city_id'   => $this->city_id,
        );

        $result = ecjia_touch_manager::make()->api(ecjia_touch_api::CART_LIST)->data($data)->run();

        return $result;
    }

}