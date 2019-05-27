<?php

namespace Ecjia\App\Goods\StoreDuplicateHandlers;

use ecjia_admin;
use ecjia_error;
use RC_Api;
use RC_DB;
use Royalcms\Component\Database\QueryException;

/**
 * 复制店铺中的散装商品
 *
 * Class StoreBulkGoodsDuplicate
 * @package Ecjia\App\Goods\StoreDuplicateHandlers
 */
class StoreBulkGoodsDuplicate extends StoreSellingGoodsDuplicate
{
    /**
     * 代号标识
     * @var string
     */
    protected $code = 'store_bulk_goods_duplicate';

    protected $rank_order = 6;

    protected $sort = 16;

    public function __construct($store_id, $source_store_id)
    {
        parent::__construct($store_id, $source_store_id, '在售散装商品');
    }

    /**
     * 重写获取源店铺数据操作对象
     * @return mixed
     */
    public function getSourceStoreDataHandler()
    {
        return RC_DB::table('goods')->where('store_id', $this->source_store_id)->where('is_on_sale', 1)->where('is_delete', 0)->where('extension_code', 'bulk');
    }

    /**
     *  重写店铺复制操作的具体过程
     * @return bool|ecjia_error
     */
    protected function startDuplicateProcedure()
    {
        try {
            //初始化过程数据中该复制操作需要用到的依赖数据
            $this->initRelationDataFromProgressData();

            //将数据复制到 goods
            $this->duplicateGoods();

            //存储 goods 相关替换数据
            $this->setReplacementData($this->getCode(), ['goods' => $this->replacement_goods]);

            return true;
        } catch (QueryException $e) {
            ecjia_log_warning($e->getMessage());
            return new ecjia_error('duplicate_data_error', $e->getMessage());
        }
    }

    /**
     * 返回操作日志编写
     *
     * @return mixed
     */
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
        $content = sprintf(__('将【%s】店铺所有在售散装商品复制到【%s】店铺中', 'goods'), $source_store_merchant_name, $store_merchant_name);
        ecjia_admin::admin_log($content, 'duplicate', 'store_goods');
    }
}