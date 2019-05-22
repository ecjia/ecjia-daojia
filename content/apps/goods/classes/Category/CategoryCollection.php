<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-24
 * Time: 14:41
 */

namespace Ecjia\App\Goods\Category;


use Ecjia\App\Goods\Models\CategoryModel;
use RC_DB;
use Royalcms\Component\Support\Collection;

class CategoryCollection
{

    protected $category_id;


    public function __construct($category_id = 0)
    {
        $this->category_id = $category_id;
    }


    /**
     * 查询所有的类
     * @return \Royalcms\Component\Support\Collection
     */
    protected function queryAllCategories()
    {
        $cache_key = 'query_all_categories';

        $collection = ecjia_cache('goods')->get($cache_key);

        if (empty($collection)) {
            $collection = CategoryModel::leftJoin('category as sc', 'category.cat_id', '=', RC_DB::raw('`sc`.`parent_id`'))
                ->select('category.cat_id', 'category.cat_name', 'category.measure_unit', 'category.parent_id', 'category.is_show', 'category.show_in_nav', 'category.grade', 'category.sort_order', RC_DB::raw('COUNT(sc.cat_id) AS has_children'))
                ->groupBy('category.cat_id')
                ->orderBy('category.parent_id', 'asc')
                ->orderBy('category.sort_order', 'asc')
                ->get()
                ->groupBy('parent_id');

            ecjia_cache('goods')->put($cache_key, $collection, 60);
        }

        return $collection;
    }

    /**
     * 查询指定父级的所有类
     * @return \Royalcms\Component\Support\Collection
     */
    protected function queryParentCategories()
    {
        $collection = CategoryModel::leftJoin('category as sc', 'category.cat_id', '=', RC_DB::raw('`sc`.`parent_id`'))
            ->select('category.cat_id', 'category.cat_name', 'category.measure_unit', 'category.parent_id', 'category.is_show', 'category.show_in_nav', 'category.grade', 'category.sort_order', RC_DB::raw('COUNT(sc.cat_id) AS has_children'))
            ->where('category.parent_id', $this->category_id)
            ->groupBy('category.cat_id')
            ->orderBy('category.parent_id', 'asc')
            ->orderBy('category.sort_order', 'asc')
            ->get()
            ->groupBy('parent_id');

        return $collection;
    }

    /**
     * 获取顶级分类列表
     * @return \Royalcms\Component\Support\Collection
     */
    public function getTopCategories()
    {
        $goods_num = CategoryGoodsNumber::getGoodsNumberWithCatId();

        $collection = $this->queryAllCategories();

        $top_levels = $collection->get(0);

        $top_levels = $this->recursiveCategroy($top_levels, $collection, $goods_num);

        return $top_levels;
    }

    /**
     * 获取分类列表
     * @return \Royalcms\Component\Support\Collection
     */
    public function getCategories()
    {
        $allcollection = $this->queryAllCategories();
        $collection = $this->queryParentCategories();

        $top_levels = $collection->get($this->category_id);

        $goods_num = CategoryGoodsNumber::getGoodsNumberWithCatId();

        $top_levels = $this->recursiveCategroy($top_levels, $allcollection, $goods_num);

        return $top_levels;
    }

    /**
     * 获取分类列表，不带子级项目的
     * @return \Royalcms\Component\Support\Collection
     */
    public function getCategoriesWithoutChildren()
    {
        $allcollection = collect();
        $collection = $this->queryParentCategories();

        $top_levels = $collection->get($this->category_id);

        $goods_num = CategoryGoodsNumber::getGoodsNumberWithCatId();

        $top_levels = $this->recursiveCategroy($top_levels, $allcollection, $goods_num);

        return $top_levels;
    }

    /**
     * 获取指定分类ID下的所有子分类ID，包含自己
     * @param $category_id
     */
    public function getChildrenCategoryIds()
    {
    	if ($this->getCategories()) {
    		$children = $this->getCategories()->pluck('children_ids');
    		$cat_ids = $this->getCategories()->pluck('cat_id');
    		$cat_ids = array_merge($cat_ids->all(), $children->collapse()->all());
    		
    		array_unshift($cat_ids, $this->category_id);
    	} else {
    		$cat_ids = [$this->category_id];
    	}
       
        return $cat_ids;
    }


    /**
     * 递归分类数据
     * @param $categories \Royalcms\Component\Support\Collection
     * @param $collection \Royalcms\Component\Support\Collection
     * @param $goods_num \Royalcms\Component\Support\Collection
     * @return \Royalcms\Component\Support\Collection
     */
    protected function recursiveCategroy($categories, $collection, $goods_num)
    {
        if (empty($categories)) {
            return null;
        }

        $categories = $categories->map(function ($model) use ($collection, $goods_num) {

            $item = $model->toArray();
            $item['childrens'] = $collection->get($model->cat_id);

            if ($item['parent_id'] === 0) {
                $item['level'] = 0;
            }


            $only = [$model->cat_id];
            $item['goods_num'] = $goods_num->only($only)->sum();

            if ($item['childrens'] instanceof Collection) {
                $level = $item['level'];
                $item['childrens'] = $item['childrens']->map(function($item) use ($level) {
                    $item['level'] = ++$level;
                    return $item;
                });

                $item['childrens'] = $this->recursiveCategroy($item['childrens'], $collection, $goods_num);

                $item['children_ids'] = $item['childrens']->pluck('cat_id')->all();

                $item['goods_num'] = $item['goods_num'] + $item['childrens']->pluck('goods_num')->sum();
            }

            return $item;
        });

        return $categories;
    }

}