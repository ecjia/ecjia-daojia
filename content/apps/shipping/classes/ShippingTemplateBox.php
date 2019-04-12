<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-21
 * Time: 16:09
 */

namespace Ecjia\App\Shipping;


class ShippingTemplateBox extends ShippingTemplateAbstract
{

    /**
     * ShippingTemplateBox constructor.
     */
    public function __construct()
    {

        $this->default = array(
        	'shop_name'             => __('网店-名称', 'shipping'),
        	'shop_tel'              => __('网店-联系电话', 'shipping'),
            'shop_country'          => __('网店-国家', 'shipping'),
            'shop_province'         => __('网店-省份', 'shipping'),
            'shop_city'             => __('网店-城市', 'shipping'),
            'shop_district'         => __('网店-区/县', 'shipping'),
        	'shop_street'         	=> __('网店-街道', 'shipping'),
        	'shop_address'          => __('网店-地址', 'shipping'),

        	'customer_name'         => __('收件人-姓名', 'shipping'),
        	'customer_tel'          => __('收件人-电话', 'shipping'),
        	'customer_mobel'        => __('收件人-手机', 'shipping'),
        	'customer_post'         => __('收件人-邮编', 'shipping'),
            'customer_country'      => __('收件人-国家', 'shipping'),
            'customer_province'     => __('收件人-省份', 'shipping'),
            'customer_city'         => __('收件人-城市', 'shipping'),
            'customer_district'     => __('收件人-区/县', 'shipping'),
        	'customer_street'     	=> __('收件人-街道', 'shipping'),
            'customer_address'      => __('收件人-详细地址', 'shipping'),
 
        	'order_no'              => __('订单号-订单', 'shipping'),
        	'order_amount'          => __('订单金额-订单', 'shipping'),
        	'order_postscript'      => __('备注-订单', 'shipping'),
        	'order_best_time'       => __('送货时间-订单', 'shipping'),
            'year'                  => __('年-当日日期', 'shipping'),
            'months'                => __('月-当日日期', 'shipping'),
            'day'                   => __('日-当日日期', 'shipping'),
	
            'pigeon'                => __('√-对号', 'shipping'),
            'custom_content'        => __('自定义内容', 'shipping'),
        );

    }

    /**
     * 转换打印模板数据
     */
    public function transformPrintData($labels)
    {
        //标签替换
        $temp_config_lables = explode('||,||', $labels);

        if (!is_array($temp_config_lables)) {
            $temp_config_lables[] = $labels;
        }

        $transform_labels = collect($temp_config_lables)->map(function($item) {
            $temp = explode(',', $item);

            if (is_array($temp)) {
                $key = str_replace('t_', '', $temp[0]);
                $temp[1] = $this->setting[$key];
            }

            return implode(',', $temp);
        })->implode('||,||');

        return $transform_labels;
    }

}