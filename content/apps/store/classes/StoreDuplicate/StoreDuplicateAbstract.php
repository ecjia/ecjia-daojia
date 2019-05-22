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
     * 复制对象关联的数据条目
     * @var int
     */
    protected $count = 0;

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

    public function getSourceStoreDataHandler()
    {
        return $this->source_store_data_handler;
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
     * 标记操作完成
     */
    public function markDuplicateFinished()
    {
        $storage = new ProgressDataStorage($this->store_id);

        $duplicate_progress_data = $storage->getDuplicateProgressData();

        $duplicate_progress_data->addDuplicateFinishedItem($this->getCode());

        $storage->save();
    }

    /**
     * 依赖检测
     * 返回依赖未完成的项
     */
    public function dependentCheck()
    {
        $items = (new ProgressDataStorage($this->store_id))->getDuplicateProgressData()->getDuplicateFinishedItems();

        $factory = new StoreDuplicateManager($this->store_id, $this->source_store_id);

        $diff = collect($this->dependents)->diff($items)->filter(function ($item) use ($factory) {
            //判断依赖项是否有数据
            $handle = $factory->handler($item);

            return $handle->handleCount() > 0 ? true : false;
        });

        return $diff->all();
    }

    /**
     * 检查当前复制项是否完成
     */
    public function isCheckFinished()
    {
        $storage = new ProgressDataStorage($this->store_id);

        $duplicate_progress_data = $storage->getDuplicateProgressData();

        $items = $duplicate_progress_data->getDuplicateFinishedItems();

        if (in_array($this->getCode(), $items)) {
            return true;
        }

        return false;
    }

    /**
     * @return array
     */
    public function getReplacementData($code)
    {
        $storage = new ProgressDataStorage($this->store_id);

        $duplicate_progress_data = $storage->getDuplicateProgressData();

        $data = $duplicate_progress_data->getReplacementData($code);

        return $data;
    }

    /**
     * @param array $replacement_data
     * @return bool
     */
    public function setReplacementData($code, $replacement_data)
    {
        $storage = new ProgressDataStorage($this->store_id);

        $duplicate_progress_data = $storage->getDuplicateProgressData();

        $duplicate_progress_data->setReplacementDataByCode($code, $replacement_data);

        $storage->save();

        return true;
    }

}