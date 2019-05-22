<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-26
 * Time: 11:40
 */

namespace Ecjia\App\Goods\Brand;


use Ecjia\App\Goods\Models\BrandModel;

class BrandCollection
{

    public function __construct()
    {

    }

    /**
     * 查询所有的类
     * @return \Royalcms\Component\Support\Collection
     */
    public static function queryAllBrands()
    {
        $cache_key = 'query_all_brands';

        $collection = ecjia_cache('goods')->get($cache_key);

        if (empty($collection)) {
            $collection = BrandModel::orderBy('sort_order', 'asc')->get();

            ecjia_cache('goods')->put($cache_key, $collection, 60);
        }

        return $collection;
    }


    /**
     * 获取品牌名称 id => name
     */
    public static function getBrandNameKeyBy()
    {
        $collection = self::queryAllBrands();

        $result = $collection->keyBy('brand_id')->map(function($item) {
            return $item['brand_name'];
        })->all();

        return $result;
    }

}