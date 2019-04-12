<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-01
 * Time: 18:20
 */

namespace Ecjia\App\Goods\GoodsSearch;

use Ecjia\App\Goods\Models\GoodsModel;
use Royalcms\Component\Database\Eloquent\Builder;
use Royalcms\Component\Http\Request;

class GoodsSearch
{

    public static function apply(Request $filters)
    {

        $query = (new GoodsModel())->newQuery();

        $query = static::applyDecoratorsFromRequest($filters, $query);

        // 返回搜索结果
        return static::getResults($query);
    }

    public static function applyCount(Request $filters)
    {

        $filters->replace($filters->except('page'));

        $query = (new GoodsModel())->newQuery();

        $query = static::applyDecoratorsFromRequest($filters, $query);

        // 返回搜索结果
        return static::getCount($query);
    }



    private static function applyDecoratorsFromRequest(Request $request, Builder $query)
    {
        foreach ($request->all() as $filterName => $value) {
            $decorator = static::createFilterDecorator($filterName);

            if (static::isValidDecorator($decorator)) {
                $query = $decorator::apply($query, $value);
            }

        }

        return $query;
    }

    private static function createFilterDecorator($name)
    {
        return __NAMESPACE__ . '\\Filters\\' .
        str_replace(' ', '',
            ucwords(str_replace('_', ' ', $name)));
    }

    private static function isValidDecorator($decorator)
    {
        return class_exists($decorator);
    }

    /**
     * 获取条数
     * @param Builder $query
     * @return mixed
     */
    private static function getCount(Builder $query)
    {
        return $query->count('goods.goods_id');
    }

    /**
     * 获取结果集
     * @param Builder $query
     * @return Builder[]|\Royalcms\Component\Database\Eloquent\Collection
     */
    private static function getResults(Builder $query)
    {
     	return $query->get();
    }

}