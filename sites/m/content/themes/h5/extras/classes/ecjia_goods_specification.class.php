<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-17
 * Time: 19:53
 */

class ecjia_goods_specification
{

    /**
     * 缓存key
     * @var string
     */
    private $storage_key;

    /**
     * 登录token
     * @var
     */
    private $token;

    private $goods_id;

    public function __construct($goods_id, $token = null)
    {

        if (is_null($token)) {
            $this->token = $token;
        } else {
            $this->token = ecjia_touch_user::singleton()->getToken();
        }

        $this->goods_id = $goods_id;

        $this->storage_key = sprintf('%X', crc32('goods_product_specification_' . $this->token . $this->goods_id));
    }


    /**
     * 存储购物车缓存数据
     */
    public function saveLocalStorage($spec_list)
    {
        RC_Cache::app_cache_set($this->storage_key, $spec_list, 'goods');
    }

    /**
     * 取出购物车缓存数据
     */
    public function getLocalStorage()
    {
        //店铺购物车商品
        $cart_list = RC_Cache::app_cache_get($this->storage_key, 'goods');

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
        RC_Cache::app_cache_delete($this->storage_key, 'goods');
    }


    /**
     * 获取线上购物车数据
     * @return array|ecjia_error
     */
    public function getServerCartData()
    {
        $arr = array(
            'token'    => $this->token,
            'goods_id' => $this->goods_id,
        );

        $cart_list = ecjia_touch_manager::make()->api(ecjia_touch_api::GOODS_PRODUCT_SPECIFICATION)->data($arr)->run();
        if (!is_ecjia_error($cart_list)) {
            $this->saveLocalStorage($cart_list);
        } else {
            $cart_list = array();
        }

        return $cart_list;
    }

    /**
     * 通过规格参数查找product_id
     * @param $spec
     */
    public function findProductIdBySpec($spec)
    {
        $goods_specification = $this->getLocalStorage();
        $product_specification = $goods_specification['product_specification'];

        if (is_array($spec)) {
            $spec = implode('|', $spec);
        }

        $product_id = 0;
        if (!empty($product_specification)) {
            foreach ($product_specification as $key => $value) {
                if (!empty($value['product_goods_attr'])) {
                    if ($spec == $value['product_goods_attr'] && !empty($value['product_id'])) {
                        $product_id = $value['product_id'];
                        break;
                    }
                }
            }
        }

        return $product_id;
    }

    /**
     * 通过规格参数查找货品规格
     * @param $spec
     */
    public function findProductSpecificationBySpec($spec)
    {
        $goods_specification = $this->getLocalStorage();
        $product_specification = $goods_specification['product_specification'];

        //判断是否是数组，转换为竖线分隔的字符串
        if (is_array($spec)) {
            asort($spec);
            $spec = implode('|', $spec);//123|124
        }

        //判断逗号分隔是否存在，转换为竖线分隔
        if (strpos($spec, ',') !== false) {
            $spec = str_replace(',', '|', $spec);
        }

        $specification_item = collect($product_specification)->filter(function($item) use ($spec) {
            if (!empty($item['product_goods_attr'])) {
                if ($spec == $item['product_goods_attr']) {
                    return true;
                }
            }

            return false;
        })->first();

        if ($specification_item['is_promote'] == 1) {
            $specification_item['product_shop_price'] = min($specification_item['product_shop_price'], $specification_item['promote_price']);
        }

        $specification_item['product_goods_attr_label'] = $this->convertProductGoodsAttrLabel($spec);
        $specification_item['product_shop_price_label'] = ecjia_price_format($specification_item['product_shop_price']);

        return $specification_item;
    }

    /**
     * 通过product_id查找货品规格
     * @param $spec
     */
    public function findProductSpecificationByProductId($product_id, $product_specification = null)
    {
        if (is_null($product_specification)) {
            $goods_specification = $this->getLocalStorage();
            $product_specification = $goods_specification['product_specification'];
        }

        $specification_item = collect($product_specification)->filter(function($item) use ($product_id) {
            if ($item['product_id'] == $product_id) {
                return true;
            }

            return false;
        })->first();

        if (empty($specification_item)) {
            $specification_item = $product_specification[0];
        }

        if ($specification_item) {
            if ($specification_item['is_promote'] == 1) {
                $specification_item['product_shop_price'] = min($specification_item['product_shop_price'], $specification_item['promote_price']);
            }

            $specification_item['product_goods_attr_label'] = $this->convertProductGoodsAttrLabel($specification_item['product_goods_attr']);
            $specification_item['product_shop_price_label'] = ecjia_price_format($specification_item['product_shop_price']);

            return $specification_item;
        }

        return null;
    }


    /**
     * 获取默认的spec id
     * @return mixed
     */
    public function findDefaultProductGoodsAttrId($specification = null)
    {
        if (is_null($specification)) {
            $goods_specification = $this->getLocalStorage();
            $specification = $goods_specification['specification'];
        }

        $product_goods_attr_label = collect($specification)
            ->pluck('value')
            ->map(function($item) {
                return $item[0];
            })
            ->pluck('id')
            ->implode(',');

        return $product_goods_attr_label;
    }

    /**
     * 转换spec id 为 字符串名字
     * @param $spec
     * @return mixed
     */
    public function convertProductGoodsAttrLabel($spec)
    {
        $spec = explode('|', $spec);

        $goods_specification = $this->getLocalStorage();

        $specification = $goods_specification['specification'];
        $product_goods_attr_label = collect($specification)
            ->pluck('value')
            ->collapse()
            ->whereIn('id', $spec)
            ->pluck('label')
            ->implode('/');

        return $product_goods_attr_label;
    }

}