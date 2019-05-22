<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/12
 * Time: 14:04
 */

namespace Ecjia\App\Goods\StoreDuplicateHandlers;

use Ecjia\App\Store\StoreDuplicate\StoreDuplicateAbstract;
use ecjia_error;
use RC_Uri;
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

    protected $dependents = [
        'store_goods_merchant_category_duplicate',
    ];

    public function __construct($store_id, $source_store_id, $sort = 21)
    {
        parent::__construct($store_id, $source_store_id, '在售散装商品', $sort);
    }

    public function getSourceStoreDataHandler()
    {
        return RC_DB::table('goods')->where('store_id', $this->source_store_id)->where('is_on_sale', 1)->where('is_delete', '!=', 1)->where('extension_code', 'bulk');
    }

    /**
     * 数据描述及输出显示内容
     */
    public function handlePrintData()
    {
        $count = $this->handleCount();
        $text = sprintf(__('店铺内总共有<span class="ecjiafc-red ecjiaf-fs3">%s</span>件散装商品', 'goods'), $count);

        return <<<HTML
<span class="controls-info">{$text}</span>
HTML;
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
        if (!empty($this->source_store_data_handler)) {
            $this->count = $this->source_store_data_handler->count();
        }
        return $this->count;
    }

    /**
     * 执行复制操作
     *
     * @return mixed
     */
    public function handleDuplicate()
    {
        //检测当前对象是否已复制完成
        if ($this->isCheckFinished()) {
            return true;
        }

        //如果当前对象复制前仍存在依赖，则需要先复制依赖对象才能继续复制
        if (!empty($this->dependents)) { //如果设有依赖对象
            //检测依赖
            $items = $this->dependentCheck();
            if (!empty($items)) {
                return new ecjia_error('handle_duplicate_error', __('复制依赖检测失败！', 'store'), $items);
            }
        }

        //执行具体任务
        $this->startDuplicateProcedure();

        //标记处理完成
        $this->markDuplicateFinished();

        //记录日志
        $this->handleAdminLog();

        return true;
    }

    /**
     * 店铺复制操作的具体过程
     */
    protected function startDuplicateProcedure()
    {
        $this->source_store_data_handler->chunk(50, function ($items) {
            //构造可用于复制的数据
            $this->buildDuplicateData($items);

            dd($items);
            //插入数据到新店铺
            RC_DB::table('goods')->insert($items);
        });
    }

    protected function buildDuplicateData(&$items)
    {
        foreach ($items as &$item) {
            unset($item['goods_id']);

            //将源店铺ID设为新店铺的ID
            $item['store_id'] = $this->store_id;


        }


        //解决外键带来的问题数据


    }

    /**
     * 返回操作日志编写
     *
     * @return mixed
     */
    public function handleAdminLog()
    {

    }

}