<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-01
 * Time: 18:24
 */

namespace Ecjia\App\Goodslib\GoodsSearch\Filters;


use Ecjia\System\Frameworks\SuperSearch\FilterInterface;
use Royalcms\Component\Database\Eloquent\Builder;
use Ecjia\App\Goods\GoodsSearch\GoodsCategory;


/**
 * 平台商品分类条件
 * @author Administrator
 *
 */
class CatId implements FilterInterface
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
    		$children = GoodsCategory::getChildrenCategoryId($value);
    		 
    		if (!empty($children) && is_array($children)) {
    			$extension_goods_id = GoodsCategory::getExtensionGoods($children);
    			if (!empty($extension_goods_id)) {
    				$subQuery = $builder->where(function ($query) use ($children, $extension_goods_id) {
    					$query->whereIn('goodslib.cat_id', $children)
    					->orWhere(function ($query) use ($extension_goods_id) {
    						$query->whereIn('goodslib.goods_id', $extension_goods_id);
    					});
    				});
    				return $subQuery;
    			}else {
    				$builder->whereIn('goodslib.goods_id', $extension_goods_id);
    			}
    		}
    	}	
    	return $builder;
    }

}