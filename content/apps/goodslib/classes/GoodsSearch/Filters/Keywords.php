<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-01
 * Time: 18:24
 */

namespace Ecjia\App\Goodslib\GoodsSearch\Filters;


use Ecjia\System\Frameworks\SuperSearch\FilterInterface;
use Ecjia\App\Goods\GoodsSearch\GoodsKeywords;
use Royalcms\Component\Database\Eloquent\Builder;

/**
 * 商品关键字条件
 * @author Administrator
 *
 */
class Keywords implements FilterInterface
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

        $query = (new GoodsKeywords($value))->buildQuery();

        return $builder->where($query);
		
    }

}