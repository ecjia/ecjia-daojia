<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-21
 * Time: 16:15
 */

namespace Ecjia\App\Shipping;


abstract class ShippingTemplateAbstract
{
    protected $default = [];

    protected $setting = [];


    /**
     * 设置变量数据
     * @param $key
     * @param $value
     * @return $this
     */
    public function setTemplateData($key, $value)
    {
        $keys = array_keys($this->default);
        if (in_array($key, $keys)) {
            $this->setting[$key] = $value;
        }

        return $this;
    }

    /**
     * 获取已经成功设置过的数据
     * @return array
     */
    public function getTemplateData()
    {
        return $this->setting;
    }

    public function getTemplateDataWithCallback(\Closure $callback)
    {
        return collect($this->setting)->map($callback)->all();
    }

    /**
     * 获取默认选项
     */
    public function getDefaults()
    {
        return $this->default;
    }



}