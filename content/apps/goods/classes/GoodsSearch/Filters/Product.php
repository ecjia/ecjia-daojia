<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-01
 * Time: 18:24
 */

namespace Ecjia\App\Goods\GoodsSearch\Filters;


use Ecjia\App\Goods\GoodsSearch\FilterInterface;
use Royalcms\Component\Database\Eloquent\Builder;

class Product implements FilterInterface
{

    /**
     * 把过滤条件附加到 builder 的实例上
     *
     * @param Builder $builder
     * @param mixed $value
     * @return Builder $builder
     */
    public static function apply(Builder $builder, $value)
    {
        if ($value) {
            return $builder->leftJoin('products', function ($join) {
                $join->on('goods.goods_id', '=', 'products.goods_id');
            })->select('goods.*',
                'products.goods_id as product_goods_id',
                'products.goods_attr as product_goods_attr',
                'products.product_id',
                'products.product_sn',
                'products.product_number',
            	'products.promote_price as product_promote_price',
            	'products.product_name',
            	'products.product_thumb',
            	'products.product_img',
            	'products.product_original_img'
            );
        }

        return $builder;
    }

}