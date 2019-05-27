<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-05-15
 * Time: 18:33
 */

namespace Ecjia\App\Store\StoreDuplicate;


use Royalcms\Component\Support\Str;

class StoreDuplicateProgressData
{

    /**
     * 存储已经完成的复制项
     *
     * @var array
     */
    protected $duplicate_finished_items = [];

    /**
     * 存储复制任务的状态
     * @var array
     */
    protected $duplicating_items = [];

    /**
     * 复制过程的临时转换数据存储
     * @var array
     */
    protected $replacement_data = [];

    /**
     * Don't Modify
     * @return array
     */
    public function getDuplicateFinishedItems()
    {
        return $this->duplicate_finished_items;
    }

    /**
     * Don't Modify
     * @param $finished_items
     * @return $this
     */
    public function setDuplicateFinishedItems($finished_items)
    {
        $this->duplicate_finished_items = $finished_items;
        return $this;
    }

    /**
     * @param $code
     */
    public function addDuplicateFinishedItem($code)
    {
        $this->duplicate_finished_items[] = $code;
    }


    /**
     * Don't Modify
     * @return array
     */
    public function getDuplicatingItems()
    {
        return $this->duplicating_items;
    }

    /**
     * Don't Modify
     * @param array $duplicating_items
     * @return StoreDuplicateProgressData
     */
    public function setDuplicatingItems($duplicating_items)
    {
        $this->duplicating_items = $duplicating_items;
        return $this;
    }

    /**
     * 添加正在进行中项目
     * @param $code
     * @return $this
     */
    public function addDuplicatingItem($code)
    {
        $this->duplicating_items[$code] = 'copying';
        return $this;
    }

    /**
     * 查看正在进行中项目
     * @param $code
     * @return bool
     */
    public function hasDuplicatingItem($code)
    {
        return isset($this->duplicating_items[$code]);
    }

    /**
     * 移除正在进行中项目
     * @param $code
     * @return $this
     */
    public function removeDuplicatingItem($code)
    {
        if (isset($this->duplicating_items[$code])) {
            unset($this->duplicating_items[$code]);
        }

        return $this;
    }

    /**
     * Don't Modify
     * @return array
     */
    public function getReplacementData()
    {
        return $this->replacement_data;
    }

    /**
     * Don't Modify
     * @param array $replacement_data
     * @return StoreDuplicateProgressData
     */
    public function setReplacementData($replacement_data)
    {
        $this->replacement_data = $replacement_data;
        return $this;
    }

    /**
     * @param null $code
     * @param array $default
     * @return array|mixed
     */
    public function getReplacementDataByCode($code = null, $default = [])
    {
        if (!is_null($code)) {
            return array_get($this->replacement_data, $code, $default);
        }

        return $this->replacement_data;
    }

    /**
     * @param string $code
     * @param array $replacement_data
     * @return StoreDuplicateProgressData
     */
    public function setReplacementDataByCode($code, $replacement_data)
    {
        $this->replacement_data[$code] = $replacement_data;

        return $this;
    }


    public function toArray()
    {
        return [
            'duplicate_finished_items' => $this->duplicate_finished_items,
            'duplicating_items' => $this->duplicating_items,
            'replacement_data' => $this->replacement_data,
        ];

    }

    /**
     * @param array|null $data
     * @return StoreDuplicateProgressData
     */
    public static function createStoreDuplicateProgressData(array $data = null)
    {
        $duplicate = new static();
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $method = Str::camel('set_' . $key);
                if (method_exists($duplicate, $method)) {
                    $duplicate->{$method}($value);
                }
            }
        }

        return $duplicate;
    }


}