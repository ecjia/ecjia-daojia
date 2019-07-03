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

/**
 * 订单编号或商品名称条件
 * @author royalwang
 *
 */
class GoodsSnOrProductSn implements FilterInterface
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
    	if (!empty($value)) {
    		return $builder
    		->where('goods.goods_sn', 'like', '%' . ecjia_mysql_like_quote($value) . '%')
    		->orWhereHas('products_collection', function($query) use ($value) {
                    /**
                     * @var \Royalcms\Component\Database\Query\Builder $query
                     */
                    $query->where('product_sn', 'like', '%' . ecjia_mysql_like_quote($value) . '%');
                });
    	}
    	return $builder;
    }
}