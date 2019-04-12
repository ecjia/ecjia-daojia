<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-20
 * Time: 17:59
 */

namespace Ecjia\App\Shipping;


class ShippingTemplate extends ShippingTemplateAbstract
{

    public function __construct()
    {
        
        $this->default = [
        	'shop_name'             => __('表示网店名称', 'shipping'),
        	'shop_tel'              => __('表示网店联系电话', 'shipping'),
	        'shop_country'          => __('表示网店所属国家', 'shipping'),
	        'shop_province'         => __('表示网店所属省份', 'shipping'),
	        'shop_city'             => __('表示网店所属城市', 'shipping'),
	        'shop_district'         => __('表示网店所属区/县','shipping'),
	        'shop_street'         	=> __('表示网店所属街道', 'shipping'),
	        'shop_address'          => __('表示网店地址', 'shipping'),
	        
	        'customer_name'         => __('表示收件人姓名', 'shipping'),
	        'customer_tel'          => __('表示收件人电话', 'shipping'),
	        'customer_mobel'        => __('表示收件人手机', 'shipping'),
	        'customer_post'         => __('表示收件人邮编', 'shipping'),
	        'customer_country'      => __('表示收件人所属国家', 'shipping'),
	        'customer_province'     => __('表示收件人所属省份', 'shipping'),
	        'customer_city'         => __('表示收件人所属城市', 'shipping'),
	        'customer_district'     => __('表示收件人所属区/县', 'shipping'),
	        'customer_street'     	=> __('表示收件人所属街道', 'shipping'),
	        'customer_address'      => __('表示收件人详细地址', 'shipping'),
	        
	        'order_no'              => __('表示订单号', 'shipping'),
	        'order_amount'          => __('表示订单金额', 'shipping'),
	        'order_postscript'      => __('表示订单备注', 'shipping'),
	        'order_best_time'       => __('表示最佳送货时间', 'shipping'),
	        'year'                  => __('年-当日日期', 'shipping'),
	        'months'                => __('月-当日日期', 'shipping'),
	        'day'                   => __('日-当日日期', 'shipping'),
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