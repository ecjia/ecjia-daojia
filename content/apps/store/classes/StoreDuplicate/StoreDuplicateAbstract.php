<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/12
 * Time: 12:05
 */

namespace Ecjia\App\Store\StoreDuplicate;

abstract class StoreDuplicateAbstract
{
    /**
     * 当前店铺的ID
     * @var int
     */
    protected $store_id;

    /**
     * 复制来源的店铺ID
     * @var int
     */
    protected $source_store_id;

    /**
     * 代号标识
     * @var string
     */
    protected $code;

    /**
     * 名称
     * @var string
     */
    protected $name;

    /**
     * 描述
     * @var string
     */
    protected $description;

    /**
     * 排序
     * @var int
     */
    protected $sort = 0;

    /**
     * 依赖关联code
     * @var array
     */
    protected $dependents = [];

    /**
     * StoreDuplicateAbstract constructor.
     * @param $store_id
     * @param $source_store_id
     */
    public function __construct($store_id, $source_store_id)
    {
        $this->store_id = $store_id;
        $this->source_store_id = $source_store_id;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getSort()
    {
        return $this->sort;
    }

    public function setSort($sort)
    {
        $this->sort = $sort;
        return $this;
    }

    /**
     * 数据描述及输出显示内容
     */
    abstract public function handlePrintData();

    /**
     * 获取数据统计条数
     *
     * @return mixed
     */
    abstract public function handleCount();

    /**
     * 执行复制操作
     *
     * @return mixed
     */
    abstract public function handleDuplicate();

    /**
     * 返回操作日志编写
     *
     * @return mixed
     */
    abstract public function handleAdminLog();

    /**
     * @return ProgressDataStorage
     */
    protected function handleProgressDataStorage()
    {
        return ProgressDataStorage::makeStaticInstance($this->store_id);
    }

    /**
     * @return StoreDuplicateProgressData
     */
    public function handleDuplicateProgressData()
    {
        return $duplicate_progress_data = $this->handleProgressDataStorage()->getDuplicateProgressData();
    }

    /**
     * 标记开始复制
     */
    public function markStartingDuplicate()
    {
        $this->handleDuplicateProgressData()->addDuplicatingItem($this->getCode());

        $this->handleProgressDataStorage()->save();
    }

    /**
     * 标记操作完成
     */
    public function markDuplicateFinished()
    {
        $this->handleDuplicateProgressData()->removeDuplicatingItem($this->getCode());
        $this->handleDuplicateProgressData()->addDuplicateFinishedItem($this->getCode());

        $this->handleProgressDataStorage()->save();
    }

    /**
     * 依赖检测，返回依赖未完成的项
     * @return mixed
     */
    public function dependentCheck()
    {
        $items = $this->handleDuplicateProgressData()->getDuplicateFinishedItems();

        $factory = new StoreDuplicateManager($this->store_id, $this->source_store_id);

        $diff = collect($this->dependents)->diff($items)->filter(function ($item) use ($factory) {
            //判断依赖项是否有数据
            $handle = $factory->handler($item);

            return $handle->handleCount() > 0 ? true : false;
        });

        return $diff->all();
    }

    /**
     * 检查当前复制项是否开始
     * @return bool
     */
    public function isCheckStarting()
    {
        return $this->handleDuplicateProgressData()->hasDuplicatingItem($this->getCode());
    }

    /**
     * 检查当前复制项是否完成
     * @return bool
     */
    public function isCheckFinished()
    {
        if (in_array($this->getCode(), $this->handleDuplicateProgressData()->getDuplicateFinishedItems())) {
            return true;
        }
        return false;
    }

    /**
     * @param $code
     * @return array
     */
    public function getReplacementData($code)
    {
        return $this->handleDuplicateProgressData()->getReplacementDataByCode($code);
    }

    /**
     * @param $code
     * @param $replacement_data
     * @return bool
     */
    public function setReplacementData($code, $replacement_data)
    {
        $this->handleDuplicateProgressData()->setReplacementDataByCode($code, $replacement_data);

        $this->handleProgressDataStorage()->save();

        return true;
    }

}