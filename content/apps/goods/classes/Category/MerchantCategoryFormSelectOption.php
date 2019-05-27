<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-26
 * Time: 09:57
 */

namespace Ecjia\App\Goods\Category;


use Royalcms\Component\Support\Collection;

class MerchantCategoryFormSelectOption
{
    protected $collection;

    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }


    public function render($selected = 0)
    {
        $select = '';

        $this->recursiveCategroy($this->collection, $select, $selected);

        return $select;
    }

    /**
     * 递归分类数据
     * @param $categories \Royalcms\Component\Support\Collection
     * @param $select
     * @param $selected
     * @return void
     */
    protected function recursiveCategroy($categories, & $select, $selected)
    {
        $categories->each(function ($item) use (& $select, $selected) {

            $select .= '<option value="' . $item['cat_id'] . '"';
            $select .= ($selected == $item['cat_id']) ? " selected='ture'" : '';
            $select .= '>';

            if ($item['level'] > 0) {
                $select .= str_repeat( "&nbsp;", $item['level'] * 4);
            }

            $select .= htmlspecialchars( addslashes($item['cat_name']), ENT_QUOTES) . '</option>' . PHP_EOL;

            if ($item['has_children'] > 0) {
                if ($item['childrens'] instanceof Collection) {
                    $this->recursiveCategroy($item['childrens'], $select, $selected);
                }
            }

        });

    }

    public static function buildTopCategorySelectOption($store_id)
    {
        $cat_list = (new \Ecjia\App\Goods\Category\MerchantCategoryCollection($store_id))->getTopCategories();

        if (empty($cat_list)) {
            $cat_list = collect();
        }

        return new static($cat_list);
    }

}