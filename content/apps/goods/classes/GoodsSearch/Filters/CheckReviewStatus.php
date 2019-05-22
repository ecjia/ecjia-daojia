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
 * 商品待审核或未通过的
 * @author Administrator
 *
 */
class CheckReviewStatus implements FilterInterface
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
        if (is_array($value)) {
            return $builder->whereIn('goods.review_status', $value);
        }
        
    	return $builder->where('goods.review_status', $value);//$value=1或者2
    }
}