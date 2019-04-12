<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-08
 * Time: 15:00
 */

namespace Ecjia\App\Weapp;


use Ecjia\App\Weapp\Models\WechatOptionsModel;

class WeappOptions
{

    protected $weapp_id;

    protected $options = [];

    public function __construct($weapp_id)
    {
        $this->weapp_id = $weapp_id;
    }


    public function getOption($key, $default = null)
    {
        if (isset($this->options[$key])) {
            return $this->options[$key];
        }

        return $this->loadOption($key) ?: $default;
    }

    /**
     * @param $key
     * @return mixed
     */
    protected function loadOption($key)
    {
        $option = WechatOptionsModel::wechat($this->weapp_id)->where('option_name', $key)->first();

        if ($option->option_type == 'serialize') {
            $option_value = unserialize($option->option_value);
        }
        else {
            $option_value = $option->option_value;
        }

        if ($option_value) {
            $this->options[$key] = $option_value;
        }

        return $option_value;
    }


}