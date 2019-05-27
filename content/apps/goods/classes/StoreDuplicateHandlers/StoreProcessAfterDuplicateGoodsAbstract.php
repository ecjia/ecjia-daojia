<?php

namespace Ecjia\App\Goods\StoreDuplicateHandlers;

use Ecjia\App\Store\StoreDuplicate\StoreDuplicateAbstract;
use ecjia_error;
use RC_DB;
use Royalcms\Component\Database\QueryException;

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
     * @var \Ecjia\App\Store\StoreDuplicate\StoreDuplicateProgressData
     */
    protected $progress_data;

    /**
     * goods 表中的替换数据
     * @var array
     */
    protected $replacement_goods = [];

    protected $rank_order = 1;

    protected $rank_total = 11;

    protected static $old_goods_ids;

    public function __construct($store_id, $source_store_id, $name)
    {
        parent::__construct($store_id, $source_store_id);
        $this->name = __($name, 'goods');
    }

    abstract protected function getTableName();

    abstract protected function startDuplicateProcedure();

    public function getName()
    {
        return $this->name . sprintf('(%d/%d)', $this->rank_order, $this->rank_total);
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

        if ($this->isCheckStarting()){
            return new ecjia_error('duplicate_started_error', sprintf(__('%s复制已开始，请耐心等待！', 'store'), $this->getName()));
        }

        //如果当前对象复制前仍存在依赖，则需要先复制依赖对象才能继续复制
        if (!empty($this->dependents)) { //如果设有依赖对象
            //检测依赖
            $items = $this->dependentCheck();
            if (!empty($items)) {
                return new ecjia_error('handle_duplicate_error', __('复制依赖检测失败！', 'store'), $items);
            }
        }

        //标记复制正在进行中
        $this->markStartingDuplicate();

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
            $this->progress_data = $this->handleDuplicateProgressData();
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

            if (is_null(static::$old_goods_ids)) {
                try {
                    static::$old_goods_ids = $this->getSourceStoreDataHandler()->lists('goods_id');
                    return static::$old_goods_ids;
                } catch (QueryException $e) {
                    ecjia_log_warning($e->getMessage());
                }
            }
            else {
                return static::$old_goods_ids;
            }
        }

        return array_keys($this->replacement_goods);
    }

    /**
     * 统计数据条数并获取
     *
     * @return mixed
     */
    public function handleCount()
    {
        static $count;
        if (is_null($count)) {
            // 统计数据条数
            $old_goods_id = $this->getOldGoodsId();
            if (!empty($old_goods_id)) {
                try {
                    $count = RC_DB::table($this->getTableName())->whereIn('goods_id', $old_goods_id)->count();
                } catch (QueryException $e) {
                    ecjia_log_warning($e->getMessage());
                }
            }
        }
        return $count;
    }
}