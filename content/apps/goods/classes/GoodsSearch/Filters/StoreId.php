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
 * 商品所属店铺条件
 * @author Administrator
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
    			return $builder->whereIn('store_id', $value);
    		} else {
    			return $builder->where('store_id', $value);
    		}
    	}
    	
    	return $builder;
    	
    }

}