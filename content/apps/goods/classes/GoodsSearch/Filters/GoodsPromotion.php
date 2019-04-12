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

/**
 * 促销商品（不显示货品的条件）
 * @author Administrator
 *
 */
class GoodsPromotion implements FilterInterface
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
    		$time = \RC_Time::gmtime();
    		return $builder->where('goods.promote_price', '>', 0)->where('goods.promote_start_date', '<=', $time)->where('goods.promote_end_date', '>=', $time);
    	}
    	return $builder;
    }

}