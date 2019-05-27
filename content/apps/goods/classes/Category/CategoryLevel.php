<?php


namespace Ecjia\App\Goods\Category;


use Ecjia\App\Goods\Models\CategoryModel;
use Royalcms\Component\Support\Collection;

class CategoryLevel
{
    protected $collection;

    protected $parentCategories;

    public function __construct()
    {
        $this->collection = CategoryModel::get();
    }


    /**
     * 获取分类列表
     * @return \Royalcms\Component\Support\Collection
     */
    public function getParentCategories($category_id)
    {
        $parentCategories = [];

        $top_levels = $this->collection->where('cat_id', $category_id);

        $this->recursiveParentCategroy($top_levels, $this->collection, $parentCategories);

        return collect($parentCategories);
    }

    /**
     * 获取指定分类ID下的所有子分类ID，包含自己
     * @param $category_id
     */
    public function getParentCategoryIds($category_id)
    {
        $parentCategories = $this->getParentCategories($category_id);
        if ($parentCategories->isNotEmpty()) {
            $parents = $parentCategories->pluck('cat_id');
            $cat_ids = $parents->reverse()->values()->all();
        } else {
            $cat_ids = [];
        }

        return $cat_ids;
    }

    /**
     * 递归分类数据
     * @param $categories \Royalcms\Component\Support\Collection
     * @param $collection \Royalcms\Component\Support\Collection
     * @return \Royalcms\Component\Support\Collection
     */
    protected function recursiveParentCategroy($categories, $collection, & $parentCategories)
    {
        if (empty($categories)) {
            return null;
        }

        $categories = $categories->map(function ($model) use ($collection, & $parentCategories) {

            $item = $model->toArray();

            $parentCategories[] = $item;

            $item['parents'] = $collection->where('cat_id', $item['parent_id']);

            if ($item['parents'] instanceof Collection) {
                $level = $item['level'];

                $item['parents'] = $item['parents']->map(function($item) use ($level) {
                    $item['level'] = ++$level;
                    return $item;
                });

                $item['parents'] = $this->recursiveParentCategroy($item['parents'], $collection, $parentCategories);
            }

            return $item;
        });

        return $categories;
    }



    /**
     * 获取分类列表
     * @return \Royalcms\Component\Support\Collection
     */
    public function getChildrenCategories()
    {
        $top_levels = $this->collection->where('parent_id', 0);

        $top_levels = $this->recursiveChildrenCategroy($top_levels, $this->collection);

        return $top_levels;
    }


    /**
     * 获取指定分类ID下的所有子分类ID，包含自己
     * @param $category_id
     */
    public function getChildrenCategoryIds()
    {
        if ($this->getChildrenCategories()->isNotEmpty()) {
            $children = $this->getChildrenCategories()->pluck('children_ids');
            $cat_ids = $this->getChildrenCategories()->pluck('cat_id');
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
     * @return \Royalcms\Component\Support\Collection
     */
    protected function recursiveChildrenCategroy($categories, $collection)
    {
        if (empty($categories)) {
            return null;
        }

        $categories = $categories->map(function ($model) use ($collection) {

            $item = $model->toArray();
            $item['childrens'] = $collection->where('parent_id', $model->cat_id);

            if ($item['parent_id'] === 0) {
                $item['level'] = 0;
            }

            if ($item['childrens'] instanceof Collection) {
                $level = $item['level'];
                $item['childrens'] = $item['childrens']->map(function($item) use ($level) {
                    $item['level'] = ++$level;
                    return $item;
                });

                $item['childrens'] = $this->recursiveChildrenCategroy($item['childrens'], $collection);

                $item['children_ids'] = $item['childrens']->pluck('cat_id')->all();
            }

            return $item;
        });

        return $categories;
    }

}