<?php

namespace Ecjia\App\Goods\StoreDuplicateHandlers;

use Ecjia\App\Store\StoreDuplicate\StoreDuplicateAbstract;
use ecjia_error;
use RC_DB;

/**
 * 主商品数据复制后的后续操作行为抽象
 *
 * Class StoreProcessAfterDuplicateGoodsAbstract
 * @package Ecjia\App\Goods\StoreDuplicateHandlers
 */
abstract class StoreProcessAfterDuplicateGoodsAbstract extends StoreDuplicateAbstract
{
    protected $dependents = [
        'store_selling_goods_duplicate',
        'store_cashier_goods_duplicate',
        'store_bulk_goods_duplicate'
    ];

    /**
     * 过程数据对象
     * @var null|object
     */
    protected $progress_data;

    /**
     * goods 表中的替换数据
     * @var array
     */
    protected $replacement_goods = [];

    public function __construct($store_id, $source_store_id, $name, $sort = 15)
    {
        parent::__construct($store_id, $source_store_id, $sort);
        $this->name = __($name, 'goods');
    }

    /**
     * 获取源店铺数据操作对象
     */
    public function getSourceStoreDataHandler()
    {
        return RC_DB::table('goods')->where('store_id', $this->source_store_id)->where('is_on_sale', 1)->where('is_delete', 0);
    }

    /**
     * 数据描述及输出显示内容
     */
    public function handlePrintData()
    {
        $text = sprintf(__('店铺内总共有<span class="ecjiafc-red ecjiaf-fs3">%s</span>个%s', 'goods'), $this->handleCount(), $this->name);
        return <<<HTML
<span class="controls-info">{$text}</span>
HTML;
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
        $result = $this->startDuplicateProcedure();
        if (is_ecjia_error($result)) {
            return $result;
        }

        //标记处理完成
        $this->markDuplicateFinished();

        //记录日志
        $this->handleAdminLog();

        return true;
    }

    abstract protected function startDuplicateProcedure();

    /**
     * 设置 goods 替换数据
     * @return $this
     */
    protected function setReplacementGoodsAfterSetProgressData()
    {
        if (empty($this->replacement_goods)) {
            //获取当前依赖下所有商品替换数据
            foreach ($this->dependents as $code) {
                $this->replacement_goods += $this->progress_data->getReplacementDataByCode($code . '.goods');
            }
        }
        return $this;
    }

    /**
     * 设置过程数据
     * @return $this
     */
    protected function setProgressData()
    {
        if (empty($this->progress_data)) {
            //从过程数据中提取需要用到的替换数据
            $this->progress_data = (new \Ecjia\App\Store\StoreDuplicate\ProgressDataStorage($this->store_id))->getDuplicateProgressData();
        }
        return $this;
    }

    /**
     * 获取源店铺中的 goods_id
     * @return array
     */
    protected function getOldGoodsId()
    {
        if (empty($this->replacement_goods)) {

            return $this->getSourceStoreDataHandler()->lists('goods_id');
        }
        return array_keys($this->replacement_goods);
    }


}