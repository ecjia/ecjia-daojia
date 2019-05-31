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
 * 商家商品分类条件
 * @author Administrator
 *
 */
class StoreIdAndMerchantCatId implements FilterInterface
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
    	if (is_array($value) && !empty($value)) {
    		list($merchant_cat_id, $store_id) = $value;
    		if (!empty($merchant_cat_id) && is_array($merchant_cat_id) && !empty($store_id)) {
    			return	$builder->whereIn('goods.merchant_cat_id', $merchant_cat_id);
    		} elseif ($merchant_cat_id === 0 && !empty($store_id)) {
    			return	$builder->where('goods.merchant_cat_id', $merchant_cat_id);
    		} elseif (!is_array($merchant_cat_id) && $merchant_cat_id > 0 && !empty($store_id)) {
    			return	$builder->where('goods.merchant_cat_id', $merchant_cat_id);
    		}
    	} 
    	
    	return $builder;
    }

}