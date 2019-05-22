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

    protected $replacement_data = [];

    /**
     * @return array
     */
    public function getDuplicateFinishedItems()
    {
        return $this->duplicate_finished_items;
    }

    /**
     * @param $finished_items
     * @return $this
     */
    public function setDuplicateFinishedItems($finished_items)
    {
        $this->duplicate_finished_items = $finished_items;
        return $this;
    }

    public function addDuplicateFinishedItem($code)
    {
        $this->duplicate_finished_items[] = $code;
    }

    /**
     * @return array
     */
    public function getReplacementData()
    {
        return $this->replacement_data;
    }

    /**
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