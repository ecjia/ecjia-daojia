<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/30
 * Time: 15:22
 */
namespace Ecjia\App\Goods\Product;

/**
 * Class GoodsProduct
 * 商品货品类
 *
 * @package Ecjia\App\Goods\Product
 */
class GoodsProduct
{
    protected $product_id;

    public function __construct($product_id)
    {
        $this->product_id = $product_id;
    }

}