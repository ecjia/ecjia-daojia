<?php

namespace Ecjia\App\Goods\StoreDuplicateHandlers;


use ecjia_error;
use RC_Uri;
use RC_DB;
use RC_Api;
use ecjia_admin;

/**
 * 复制店铺中的收银台商品
 *
 * Class StoreCashierGoodsDuplicate
 * @package Ecjia\App\Goods\StoreDuplicateHandlers
 */
class StoreCashierGoodsDuplicate extends StoreSellingGoodsDuplicate
{
    /**
     * 代号标识
     * @var string
     */
    protected $code = 'store_cashier_goods_duplicate';

    public function __construct($store_id, $source_store_id, $sort = 15)
    {
        parent::__construct($store_id, $source_store_id, '在售收银台商品', $sort);
    }

    /**
     * 重写获取源店铺数据操作对象
     * @return mixed
     */
    public function getSourceStoreDataHandler()
    {
        return RC_DB::table('goods')->where('store_id', $this->source_store_id)->where('is_on_sale', 1)->where('is_delete', 0)->where('extension_code', 'cashier');
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

}