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
 * 促销商品开始日期筛选
 * @author Administrator
 *
 */
class GoodsPromotionType implements FilterInterface
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
    		if ($value == 'today') {
    			$date = \RC_Time::local_date('Y-m-d', \RC_Time::gmtime());
    			$time_start = \RC_Time::local_strtotime($date);
    		} elseif ($value == 'tomorrow') {
    			$date = \RC_Time::local_date("Y-m-d",\RC_Time::local_strtotime("+1 day"));
    			$time_start = \RC_Time::local_strtotime($date);
    		} elseif ($value == 'aftertheday') {
    			$date = \RC_Time::local_date("Y-m-d",\RC_Time::local_strtotime("+2 day"));
    			$time_start = \RC_Time::local_strtotime($date);
    		}
    		$time_end   = $time_start + 86399;
    		return $builder->where('goods.promote_start_date', '>=', $time_start)->where('goods.promote_start_date', '<=', $time_end);
    	}
    	return $builder;
    }

}