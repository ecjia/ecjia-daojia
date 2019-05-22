<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/30
 * Time: 15:25
 */

namespace Ecjia\App\Goods\Category;


use Ecjia\App\Goods\Models\CategoryModel;
use Royalcms\Component\Database\Eloquent\Builder;

class CategoryTree
{
    protected $category_id;

    /**
     * @var \Royalcms\Component\Database\Eloquent\Builder
     */
    protected $category_builder;

    /**
     * @var \Royalcms\Component\Database\Eloquent\Builder
     */
    protected $parent_builder;

    protected $model;

    /**
     * CategoryTree constructor.
     * Default $category_id = 0 root categroy
     * @param int $category_id
     */
    public function __construct($category_id = 0)
    {
        $this->category_id = $category_id;

        if ($this->category_id > 0) {
            $this->category_builder = CategoryModel::where('cat_id', $this->category_id);
        }

        $this->parent_builder = CategoryModel::where('parent_id', $this->category_id);

    }

    /**
     * @return \Ecjia\App\Goods\Models\CategoryModel
     */
    public function getModel()
    {
        if (is_null($this->model) && $this->category_id > 0) {
            $this->model = $this->category_builder->first();
        }

        return $this->model;
    }

    /**
     * @return \Royalcms\Component\Database\Eloquent\Collection
     */
    public function getQueryModels()
    {
        return $this->parent_builder->get();
    }

    /**
     * 获取当前分类ID
     *
     * @return mixed
     */
    public function getCategoryId()
    {
        return $this->getModel()->cat_id;
    }

    /**
     * 获取当前分类名称
     * @return mixed
     */
    public function getCategoryName()
    {
        return $this->getModel()->cat_name;
    }

    /**
     * 获取父级分类ID
     */
    public function getParentCategoryId()
    {
        return $this->getModel()->parent_id;
    }

    /**
     * 获取父级分类名称
     */
    public function getParentCategoryName()
    {

    }

    /**
     * 获取子级分类数组
     */
    public function getChildCategories()
    {
        return $this->getQueryModels()->toArray();
    }



}