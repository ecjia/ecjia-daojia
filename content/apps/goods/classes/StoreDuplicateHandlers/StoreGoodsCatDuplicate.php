<?php

namespace Ecjia\App\Goods\StoreDuplicateHandlers;

use ecjia_error;
use RC_DB;
use RC_Api;
use ecjia_admin;

/**
 * 复制店铺中商品扩展分类数据
 *
 * Class StoreGoodsCatDuplicate
 * @package Ecjia\App\Goods\StoreDuplicateHandlers
 */
class StoreGoodsCatDuplicate extends StoreProcessAfterDuplicateGoodsAbstract
{
    /**
     * 代号标识
     * @var string
     */
    protected $code = 'store_goods_cat_duplicate';

    private $table = 'goods_cat';

    public function __construct($store_id, $source_store_id, $sort = 21)
    {
        parent::__construct($store_id, $source_store_id, '商品扩展分类', $sort);
    }

    /**
     * 统计数据条数并获取
     *
     * @return mixed
     */
    public function handleCount()
    {
        //如果已经统计过，直接返回统计过的条数
        if ($this->count) {
            return $this->count;
        }

        // 统计数据条数
        $old_goods_id = $this->getOldGoodsId();
        if (!empty($old_goods_id)) {
            $this->count = RC_DB::table($this->table)->whereIn('goods_id', $old_goods_id)->count();
        }
        return $this->count;
    }

    /**
     * 店铺复制操作的具体过程
     * @return bool|ecjia_error
     */
    protected function startDuplicateProcedure()
    {
        try {
            $this->setProgressData();

            //设置 goods 相关替换数据
            $this->setReplacementGoodsAfterSetProgressData();

            //取出源店铺 goods_id
            $old_goods_id = $this->getOldGoodsId();

            if (!empty($old_goods_id)) {
                //获取商家商品分类的替换数据
                $merchant_category_replacement = $this->progress_data->getReplacementDataByCode('store_goods_merchant_category_duplicate');

                //将数据同步到 goods_cat  商品扩展分类数据
                $this->duplicateGoodsCat($old_goods_id, $merchant_category_replacement);
            }

            return true;
        } catch (\Royalcms\Component\Repository\Exceptions\RepositoryException $e) {
            return new ecjia_error('duplicate_data_error', $e->getMessage());
        }
    }

    /**
     * 复制 goods_cat 数据
     * @param $old_goods_id
     * @param $merchant_category_replacement
     */
    private function duplicateGoodsCat($old_goods_id, $merchant_category_replacement)
    {
        RC_DB::table($this->table)->whereIn('goods_id', $old_goods_id)->chunk(50, function ($items) use ($merchant_category_replacement) {
            foreach ($items as &$item) {

                //通过 goods 替换数据设置新店铺的 goods_id
                $item['goods_id'] = array_get($this->replacement_goods, $item['goods_id'], $item['goods_id']);

                //通过 merchant_category 替换数据设置新店铺的 cat_id
                $item['cat_id'] = array_get($merchant_category_replacement, $item['cat_id'], $item['cat_id']);
            }

            //将数据插入到新店铺
            RC_DB::table($this->table)->insert($items);
        });
    }

    /**
     * 返回操作日志编写
     *
     * @return mixed
     */
    public function handleAdminLog()
    {
        \Ecjia\App\Store\Helper::assign_adminlog_content();

        $store_info = RC_Api::api('store', 'store_info', array('store_id' => $this->store_id));

        $merchants_name = !empty($store_info) ? sprintf(__('店铺名是%s', 'goods'), $store_info['merchants_name']) : sprintf(__('店铺ID是%s', 'goods'), $this->store_id);

        ecjia_admin::admin_log($merchants_name, 'duplicate', 'store_goods');
    }

}