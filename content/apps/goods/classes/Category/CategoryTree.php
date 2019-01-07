<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/30
 * Time: 15:25
 */

namespace Ecjia\App\Goods\Category;


use Ecjia\App\Goods\Models\CategoryModel;

class CategoryTree
{
    protected $category_id;

    protected $model;


    public function __construct($category_id)
    {
        $this->category_id = $category_id;

        $this->model = new CategoryModel();

    }

    /**
     * 获取当前分类ID
     *
     * @return mixed
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * 获取当前分类名称
     * @return mixed
     */
    public function getCategoryName()
    {
        return $this->model->cate_name;
    }

    /**
     * 获取父级分类ID
     */
    public function getParentCategoryId()
    {

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

    }



}