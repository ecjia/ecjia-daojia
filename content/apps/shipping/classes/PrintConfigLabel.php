<?php

namespace Ecjia\App\Shipping;

class PrintConfigLabel
{
    
    protected $labels;

    public function __construct()
    {
        $this->labels = (new ShippingTemplateBox())->getDefaults();
    }

    /**
     * 获取全部标签
     * @return \Royalcms\Component\Support\Collection
     */
    public function getLabels()
    {
        return collect($this->labels);
    }
    
    /**
     * 获取单个标签名称
     * @param string $label
     * @return string|null
     */
    public function getLabel($label) 
    {
        return $this->getLabels()->get($label);
    }
    
    /**
     * 转换打印配置
     * 坐标定位：上左下右
     * @param string $config
     */
    public function translantConfigLabel($config)
    {
        $transConfig = collect($config)->map(function($item) {
        	$subItems = explode(',', $item);
        	$subItems = collect($subItems)->map(function ($item, $key) {
        		if ($key === 1) {
        		    return $this->getLabel($item);
        		} else {
        		    return $item;
        		}
        	})->implode(',');
        	return $subItems;
        })->implode("||,||");
        
        return $transConfig;
    }
    
}