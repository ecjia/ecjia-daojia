<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-01
 * Time: 18:24
 */

namespace Ecjia\App\Goods\GoodsSearch\Filters;


use Ecjia\System\Frameworks\SuperSearch\FilterInterface;
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
            	'products.is_promote as is_product_promote',
                'products.product_sn',
                'products.product_number',
            	'products.product_shop_price',
            	'products.promote_price as product_promote_price',
            	'products.product_name',
            	'products.product_thumb',
            	'products.product_img',
            	'products.product_original_img',
            	'products.promote_limited as product_promote_limited',
            	'products.product_bar_code'
            );
        }

        return $builder;
    }

}