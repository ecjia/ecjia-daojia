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
 * 促销商品开始日期筛选（列表展示货品的条件，商品促销条件满足或货品促销条件满足）
 * @author Administrator
 *
 */
class GoodsAndProductPromotionType implements FilterInterface
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
    			$time = \RC_Time::gmtime();
    		} elseif ($value == 'tomorrow') {
    			$date = \RC_Time::local_date("Y-m-d",\RC_Time::local_strtotime("+1 day"));
    			$time_start = \RC_Time::local_strtotime($date);
    		} elseif ($value == 'aftertheday') {
    			$date = \RC_Time::local_date("Y-m-d",\RC_Time::local_strtotime("+2 day"));
    			$time_start = \RC_Time::local_strtotime($date);
    		}
    		
    		$time_end   = $time_start + 86399;
    		
    		if ($value == 'today') {
    			$subQuery = $builder
    			->where('goods.promote_start_date', '<=', $time)
    			->where('goods.promote_end_date', '>=', $time)
    			->where(function ($query) {
    				$query->where(function ($query) {
    						$query->where('products.is_promote', 1)
    							  ->where('products.promote_limited', '>', 0);
    					})->orWhere(function ($query) {
    						$query->where('goods.is_promote', 1)
    						      ->where('goods.promote_limited', '>', 0)
    							  ->whereRaw("product_id is null");
    					});
    			});
    		} else {
    			$subQuery = $builder
    			->where('goods.promote_start_date', '>=', $time_start)
    			->where('goods.promote_start_date', '<=', $time_end)
    			->where(function ($query) {
    				$query->where(function ($query) {
    						$query->where('products.is_promote', 1)
    							  ->where('products.promote_limited', '>', 0);
    					})->orWhere(function ($query) {
    						$query->where('goods.is_promote', 1)
    						      ->where('goods.promote_limited', '>', 0)
    							  ->whereRaw("product_id is null");
    					});
    			});
    		}
    		
    		return $subQuery;
    	}
    	return $builder;
    }

}