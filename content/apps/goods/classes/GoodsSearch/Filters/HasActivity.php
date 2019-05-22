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
use RC_Time;

/**
 * 商品单独销售的
 * @author Administrator
 *
 */
class HasActivity implements FilterInterface
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
            /**
             * @var \Royalcms\Component\Database\Query\Builder $query
             */
            $builder->where(function($query){
                /**
                 * @var \Royalcms\Component\Database\Eloquent\Builder $query
                 */
                $query->where('is_promote', 1)->orWhereHas('goods_activity_collection', function($query) {
                    /**
                     * @var \Royalcms\Component\Database\Query\Builder $query
                     */
                    $time = RC_Time::gmtime();
                    $query->where('start_time', '<=', $time)->where('end_time', '>=', $time);
                })->orWhereHas('favourable_activity_collection', function($query) {
                    /**
                     * @var \Royalcms\Component\Database\Query\Builder $query
                     */
                    $time = RC_Time::gmtime();
                    $query->where('start_time', '<=', $time)->where('end_time', '>=', $time);
                });
            });
        }

    	return $builder;
    }

}