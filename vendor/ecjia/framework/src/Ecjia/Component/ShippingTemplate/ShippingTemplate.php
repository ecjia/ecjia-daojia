<?php
namespace Ecjia\Component\ShippingTemplate;


class ShippingTemplate extends ShippingTemplateAbstract
{

    public function __construct()
    {
        
        $this->default = [
        	'shop_name'             => __('表示网店名称', 'ecjia'),
        	'shop_tel'              => __('表示网店联系电话', 'ecjia'),
	        'shop_country'          => __('表示网店所属国家', 'ecjia'),
	        'shop_province'         => __('表示网店所属省份', 'ecjia'),
	        'shop_city'             => __('表示网店所属城市', 'ecjia'),
	        'shop_district'         => __('表示网店所属区/县','ecjia'),
	        'shop_street'         	=> __('表示网店所属街道', 'ecjia'),
	        'shop_address'          => __('表示网店地址', 'ecjia'),
	        
	        'customer_name'         => __('表示收件人姓名', 'ecjia'),
	        'customer_tel'          => __('表示收件人电话', 'ecjia'),
	        'customer_mobel'        => __('表示收件人手机', 'ecjia'),
	        'customer_post'         => __('表示收件人邮编', 'ecjia'),
	        'customer_country'      => __('表示收件人所属国家', 'ecjia'),
	        'customer_province'     => __('表示收件人所属省份', 'ecjia'),
	        'customer_city'         => __('表示收件人所属城市', 'ecjia'),
	        'customer_district'     => __('表示收件人所属区/县', 'ecjia'),
	        'customer_street'     	=> __('表示收件人所属街道', 'ecjia'),
	        'customer_address'      => __('表示收件人详细地址', 'ecjia'),
	        
	        'order_no'              => __('表示订单号', 'ecjia'),
	        'order_amount'          => __('表示订单金额', 'ecjia'),
	        'order_postscript'      => __('表示订单备注', 'ecjia'),
	        'order_best_time'       => __('表示最佳送货时间', 'ecjia'),
	        'year'                  => __('年-当日日期', 'ecjia'),
	        'months'                => __('月-当日日期', 'ecjia'),
	        'day'                   => __('日-当日日期', 'ecjia'),
        ];
    }
    
    /**
     * 获取默认选项，并格式化输出
     */
    public function getDefaultsWithFormatted()
    {
    	return collect($this->default)->map(function($item, $key) {
    		return '<span class="ecjiafc-blue">{$'. $key .'}</span> ' . $item;
    	})->all();
    }
}