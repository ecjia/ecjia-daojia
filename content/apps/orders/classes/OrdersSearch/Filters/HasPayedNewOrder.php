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
use RC_DB;

/**
 * 是否有新支付的订单
 * @author Administrator
 */
class HasPayedNewOrder implements FilterInterface
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
    	$payment_id = RC_DB::table('payment')->where('pay_code', 'pay_cod')->value('pay_id');
    	$payment_id = empty($payment_id) ? 0 : $payment_id;
    	
    	$last_refresh_time = $value;
    	$time = \RC_Time::gmtime();
    	
    	$builder->where(function($query) use ($last_refresh_time, $time, $payment_id){
    		$query->where(function($query) use ($last_refresh_time, $time, $payment_id) {
    			$query->where('order_info.pay_time', '>=', $last_refresh_time)->where('order_info.pay_time', '<=', $time);
    		});
    		if (!empty($payment_id)) {
    			$query->orWhere('order_info.pay_id', $payment_id);
    		}
    	});
    	
        return $builder;
    }
}