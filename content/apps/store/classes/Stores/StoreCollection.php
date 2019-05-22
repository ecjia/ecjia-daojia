<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-26
 * Time: 11:58
 */

namespace Ecjia\App\Store\Stores;


use Ecjia\App\Store\Models\StoreFranchiseeModel;

class StoreCollection
{

    public function __construct()
    {

    }

    /**
     * 查询所有的类
     * @return \Royalcms\Component\Support\Collection
     */
    public static function queryAllStores()
    {
        $cache_key = 'query_all_store_franchisees';

        $collection = ecjia_cache('store')->get($cache_key);

        if (empty($collection)) {
            $collection = StoreFranchiseeModel::orderBy('store_id', 'asc')->get();

            ecjia_cache('store')->put($cache_key, $collection, 60);
        }

        return $collection;
    }


    /**
     * 获取品牌名称 id => name
     */
    public static function getStoreNameKeyBy()
    {
        $collection = self::queryAllStores();

        $result = $collection->keyBy('store_id')->map(function($item) {
            return $item['merchants_name'];
        })->all();

        return $result;
    }

}