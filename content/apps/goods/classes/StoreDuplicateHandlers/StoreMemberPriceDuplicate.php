<?php

namespace Ecjia\App\Goods\StoreDuplicateHandlers;

use ecjia_admin;
use ecjia_error;
use RC_Api;
use RC_DB;
use Royalcms\Component\Database\QueryException;

/**
 * 复制店铺中商品会员价格数据
 *
 * Class StoreMemberPriceDuplicate
 * @package Ecjia\App\Goods\StoreDuplicateHandlers
 */
class StoreMemberPriceDuplicate extends StoreProcessAfterDuplicateGoodsAbstract
{
    /**
     * 代号标识
     * @var string
     */
    protected $code = 'store_member_price_duplicate';

    private $replacement_member_price = [];

    protected $rank_order = 8;

    protected $sort = 18;

    public function __construct($store_id, $source_store_id)
    {
        parent::__construct($store_id, $source_store_id, '商品会员价格');
    }

    protected function getTableName()
    {
        return 'member_price';
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
                //将数据同步到 member_price
                //$this->duplicateMemberPrice($old_goods_id);
                RC_DB::table($this->getTableName())->whereIn('goods_id', $old_goods_id)->chunk(50, function ($items) {
                    foreach ($items as $item) {
                        $price_id = $item['price_id'];
                        unset($item['price_id']);

                        //通过 goods 替换数据设置新店铺的 goods_id
                        $item['goods_id'] = array_get($this->replacement_goods, $item['goods_id'], $item['goods_id']);

                        try {
                            //将数据插入到新店铺
                            $new_price_id = RC_DB::table($this->getTableName())->insertGetId($item);

                            //存储替换记录
                            $this->replacement_member_price[$price_id] = $new_price_id;
                        } catch (QueryException $e) {
                            ecjia_log_warning($e->getMessage());
                        }
                    }
                });

                //存储 member_price 相关替换数据
                $this->setReplacementData($this->getCode(), $this->replacement_member_price);
            }
            return true;
        } catch (QueryException $e) {
            ecjia_log_warning($e->getMessage());
            return new ecjia_error('duplicate_data_error', $e->getMessage());
        }
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
        $content = sprintf(__('将【%s】店铺所有商品会员价格复制到【%s】店铺中', 'goods'), $source_store_merchant_name, $store_merchant_name);
        ecjia_admin::admin_log($content, 'duplicate', 'store_goods');
    }
}