<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-02
 * Time: 15:38
 */

namespace Ecjia\App\Goods\GoodsSearch;

use Ecjia\App\Goods\Models\GoodsCatModel;

class GoodsCategory
{

    public static function getChildrenCategoryId($cat_id)
    {
    	\RC_Loader::load_app_class('goods_category', 'goods', false);
    	
    	$children = \goods_category::cat_list($cat_id, 0, false );
    	$children = array_keys($children);
    	$children = array_merge(array($cat_id),$children);
    	
    	return $children;
    	
    }
    
    public static function getExtensionGoods($cat_ids)
    {
    	$extension_goods_array = array();
    	if (!empty($cat_ids) && is_array($cat_ids)) {
    		$data = GoodsCatModel::whereIn('cat_id', $cat_ids)->lists('goods_id');
    		if (!empty($data)) {
    			$extension_goods_array = $data->toArray();
    			$extension_goods_array = array_unique($extension_goods_array);
    		}
    	}
    	return $extension_goods_array;
    }
    
}