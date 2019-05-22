<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-26
 * Time: 16:31
 */

namespace Ecjia\App\User\UserRank;


use Ecjia\App\User\Models\UserRankModel;
use Royalcms\Component\Support\Collection;

class UserRankCollection
{

    /**
     * 获取用户等级列表数组
     * @return Collection
     */
    public static function queryAllRanks()
    {
        $cache_key = 'query_all_user_ranks';

        $collection = ecjia_cache('user')->get($cache_key);

        if (empty($collection)) {
            $collection = UserRankModel::orderBy('min_points', 'asc')->get();

            ecjia_cache('user')->put($cache_key, $collection, 60);
        }

        return $collection;
    }

    /**
     * 取得用户等级数组,按用户级别排序
     * @param   bool $is_special 是否只显示特殊会员组
     * @return  array rank_id => rank_name
     */
    public static function getBrandNameKeyBy($is_special = false)
    {
        $collection = self::queryAllRanks();

        if ($is_special) {
            $collection = $collection->where('is_special', 1);
        }

        $result = $collection->keyBy('rank_id')->map(function($item) {
            return $item['rank_name'];
        })->all();

        return $result;
    }

}