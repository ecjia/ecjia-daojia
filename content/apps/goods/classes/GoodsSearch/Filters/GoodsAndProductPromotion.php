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
 * 促销商品（显示货品的条件，商品促销条件满足或货品促销条件满足）
 * @author Administrator
 *
 */
class GoodsAndProductPromotion implements FilterInterface
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
    		
    		$subQuery = $builder
	    		->where('goods.promote_start_date', '>', $time_start)
	    		->where('goods.promote_start_date', '<=', $time_end)
    			->where(function ($query){
    				$query->where(function ($query) {
    					$query->where('products.is_promote', 1)
    					->orWhere(function ($query) {
    						$query->where('goods.is_promote', 1)
    							  ->whereRaw("(product_id is null)");
    					});
    				});
    			});
    		return $subQuery;
    	}
    	return $builder;
    }

}