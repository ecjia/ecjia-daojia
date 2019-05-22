<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-01
 * Time: 18:24
 */

namespace Ecjia\App\Orders\OrdersSearch\Filters;


use Ecjia\System\Frameworks\SuperSearch\FilterInterface;
use Royalcms\Component\Database\Eloquent\Builder;

/**
 * 订单下单时间按日期筛选
 * @author Administrator
 *
 */
class OrderAddTime implements FilterInterface
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
    	if (!empty($value) && is_array($value)) {
    		list($start_time, $end_time) = $value;
    		if (!empty($start_time) && !empty($end_time)) {
    		 	$builder->where('order_info.add_time', '>=', $start_time)->where('order_info.add_time', '<', $end_time);
    		}
    	}
    	return $builder;
    }
}