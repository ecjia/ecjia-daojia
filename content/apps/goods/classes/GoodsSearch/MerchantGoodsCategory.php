<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-02
 * Time: 15:38
 */

namespace Ecjia\App\Goods\GoodsSearch;

use Ecjia\App\Goods\Models\MerchantCategoryModel;

class MerchantGoodsCategory
{

    public static function getChildrenCategoryId($merchant_cat_id, $store_id)
    {
    	$children_cat = MerchantCategoryModel::where('store_id', $store_id)->where('parent_id', $merchant_cat_id)->where('is_show', 1)->lists('cat_id');
    	
    	if (!empty($children_cat)) {
    		$children_cat = $children_cat->toArray();
    		$children_cat = array_merge([$merchant_cat_id], $children_cat);
    	} else {
    		$children_cat = [$merchant_cat_id];
    	}
    	
    	return $children_cat;
    	
    }
    
    public static function getAdminChildrenCategoryId($merchant_cat_id, $store_id)
    {
    	$children_cat = MerchantCategoryModel::where('store_id', $store_id)->where('parent_id', $merchant_cat_id)->lists('cat_id');
    	 
    	if (!empty($children_cat)) {
    		$children_cat = $children_cat->toArray();
    		$children_cat = array_merge([$merchant_cat_id], $children_cat);
    	} else {
    		$children_cat = [$merchant_cat_id];
    	}
    	 
    	return $children_cat;
    	 
    }
    
    
}