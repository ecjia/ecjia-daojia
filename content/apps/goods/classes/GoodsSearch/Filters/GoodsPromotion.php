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
    		$time_start = \RC_Time::gmtime();
    		
    		$one_month = \RC_Time::local_date("Y-m-d",\RC_Time::local_strtotime("+1months"));
    	
    		$time_end = \RC_Time::local_strtotime($one_month) + 86399;
    		
    		return $builder->where('goods.promote_limited', '>', 0)->where('goods.promote_price', '>', 0)->where('goods.is_promote', '=', 1)->where('goods.promote_start_date', '>', $time_start)->where('goods.promote_start_date', '<=', $time_end);
    	}
    	return $builder;
    }

}