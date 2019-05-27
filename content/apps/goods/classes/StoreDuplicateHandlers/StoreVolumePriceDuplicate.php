<?php

namespace Ecjia\App\Goods\StoreDuplicateHandlers;

use ecjia_error;
use RC_DB;
use RC_Api;
use ecjia_admin;
use Royalcms\Component\Database\QueryException;

/**
 * 复制店铺中商品阶梯价格数据（无图片字段）
 *
 * Class StoreVolumePriceDuplicate
 * @package Ecjia\App\Goods\StoreDuplicateHandlers
 */
class StoreVolumePriceDuplicate extends StoreProcessAfterDuplicateGoodsAbstract
{
    /**
     * 代号标识
     * @var string
     */
    protected $code = 'store_volume_price_duplicate';

    protected $rank_order = 10;

    protected $sort = 20;

    public function __construct($store_id, $source_store_id)
    {
        parent::__construct($store_id, $source_store_id, '商品阶梯价格');
    }

    protected function getTableName()
    {
        return 'volume_price';
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
                //将数据同步到 volume_price  商品阶梯价格数据
                $this->duplicateVolumePrice($old_goods_id);
            }

            return true;
        } catch (QueryException $e) {
            ecjia_log_warning($e->getMessage());
            return new ecjia_error('duplicate_data_error', $e->getMessage());
        }
    }

    /**
     * 复制 goods_cat 数据
     * @param $old_goods_id
     */
    private function duplicateVolumePrice($old_goods_id)
    {
        RC_DB::table($this->getTableName())->whereIn('goods_id', $old_goods_id)->chunk(50, function ($items) {
            foreach ($items as &$item) {
                //通过 goods 替换数据设置新店铺的 goods_id
                $item['goods_id'] = array_get($this->replacement_goods, $item['goods_id'], $item['goods_id']);
            }

            //将数据插入到新店铺
            RC_DB::table($this->getTableName())->insert($items);
        });
    }

    public function handleAdminLog()
    {
        static $store_merchant_name, $source_store_merchant_name;

        if (empty($store_merchant_name)) {
            $store_info = RC_Api::api('store', 'store_info', ['store_id' => $this->store_id]);
            $store_merchant_name = array_get(empty($store_info) ? [] : $store_info, 'merchants_name');
        }

        if (empty($source_store_merchant_name)) {
            $source_store_info = RC_Api::api('store', 'store_info', ['store_id' => $this->source_store_id]);
            $source_store_merchant_name = array_get(empty($source_store_info) ? [] : $source_store_info, 'merchants_name');
        }

        \Ecjia\App\Store\Helper::assign_adminlog_content();
        $content = sprintf(__('将【%s】店铺所有商品阶梯价格复制到【%s】店铺中', 'goods'), $source_store_merchant_name, $store_merchant_name);
        ecjia_admin::admin_log($content, 'duplicate', 'store_goods');
    }

}