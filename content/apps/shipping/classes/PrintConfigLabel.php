<?php

namespace Ecjia\App\Shipping;

use RC_Lang;

class PrintConfigLabel
{
    
    protected $labels = array(
        'shop_country' 	=> '网店-国家',
        'shop_province' => '网店-省份',
        'shop_city' 	=> '网店-城市',
        'shop_name' 	=> '网店-名称',
        'shop_district' => '网店-区/县',
        'shop_tel' 		=> '网店-联系电话',
        'shop_address' 	=> '网店-地址',
        
        'customer_country' 	=> '收件人-国家',
        'customer_province' => '收件人-省份',
        'customer_city' 	=> '收件人-城市',
        'customer_district' => '收件人-区/县',
        'customer_tel' 		=> '收件人-电话',
        'customer_mobel' 	=> '收件人-手机',
        'customer_post' 	=> '收件人-邮编',
        'customer_address' 	=> '收件人-详细地址',
        'customer_name' 	=> '收件人-姓名',
        
        'year' 		=> '年-当日日期',
        'months' 	=> '月-当日日期',
        'day' 		=> '日-当日日期',
        'order_no' 	=> '订单号-订单',
        
        'order_postscript' 	=> '备注-订单',
        'order_best_time' 	=> '送货时间-订单',
        'pigeon' 			=> '√-对号',
    );
    
    /**
     * 获取全部标签
     * @return \Royalcms\Component\Support\Collection
     */
    public function getLabels()
    {
        return collect($this->labels)->map(function ($itme, $key) {
        	return RC_Lang::get('shipping::shipping.lable_box.'.$key);
        });
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
        $items = explode("||,||", $config);
        
        $transConfig = collect($items)->map(function($item) {
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