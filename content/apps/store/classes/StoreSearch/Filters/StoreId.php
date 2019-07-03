<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-01
 * Time: 18:24
 */

namespace Ecjia\App\Store\StoreSearch\Filters;


use Ecjia\System\Frameworks\SuperSearch\FilterInterface;
use Royalcms\Component\Database\Eloquent\Builder;

/**
 * 店铺id条件
 * @author 
 *
 */
class StoreId implements FilterInterface
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
    		if (is_array($value)) {
    			return $builder->whereIn('store_franchisee.store_id', $value);
    		} else {
    			return $builder->where('store_franchisee.store_id', $value);
    		}
    	}
    	
    	return $builder;
    	
    }

}