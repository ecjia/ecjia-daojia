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
 * 售罄商品
 * @author Administrator
 *
 */
class GoodsNumber implements FilterInterface
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
    	if(is_array($value)) {
    		list($expression, $new_value) = $value;
    	} else {
    		$expression = '=';
    		$new_value  = $value;
    	}
    	return $builder->where('goods.goods_number', $expression, $new_value);
    }
}