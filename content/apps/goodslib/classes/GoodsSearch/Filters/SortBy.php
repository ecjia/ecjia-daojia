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

/**
 * 商品列表排序
 * @author royalwang
 *
 */
class SortBy implements FilterInterface
{

    /**
     * 把过滤条件附加到 builder 的实例上
     *
     * @param Builder | \Royalcms\Component\Database\Query\Builder $builder
     * @param mixed $value
     * @return Builder $builder
     */
    public static function apply(Builder $builder, $value)
    {
    	if (!empty($value) && is_array($value)) {
    		foreach ($value as $by => $sort) {
    		    $builder->orderBy($by, $sort);
    		}
    	}

    	return $builder;
    }

}