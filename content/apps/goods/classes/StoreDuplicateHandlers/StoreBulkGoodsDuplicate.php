<?php

namespace Ecjia\App\Goods\StoreDuplicateHandlers;

use ecjia_error;
use RC_DB;
use RC_Api;
use ecjia_admin;

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

    public function __construct($store_id, $source_store_id, $sort = 16)
    {
        parent::__construct($store_id, $source_store_id, '在售散装商品', $sort);
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
        } catch (\Royalcms\Component\Repository\Exceptions\RepositoryException $e) {
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
        \Ecjia\App\Store\Helper::assign_adminlog_content();

        $store_info = RC_Api::api('store', 'store_info', array('store_id' => $this->store_id));

        $merchants_name = !empty($store_info) ? sprintf(__('店铺名是%s', 'goods'), $store_info['merchants_name']) : sprintf(__('店铺ID是%s', 'goods'), $this->store_id);

        ecjia_admin::admin_log($merchants_name, 'duplicate', 'store_goods');
    }

}