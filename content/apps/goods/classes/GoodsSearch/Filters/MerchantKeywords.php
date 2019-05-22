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
 * 商家名称关键字条件
 * @author Administrator
 *
 */
class MerchantKeywords implements FilterInterface
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

        $builder->whereHas('store_franchisee_model', function($query) use ($value) {
            $query->where('merchants_name', 'like', '%' . ecjia_mysql_like_quote($value) . '%');
        });

        return $builder;
    }

}