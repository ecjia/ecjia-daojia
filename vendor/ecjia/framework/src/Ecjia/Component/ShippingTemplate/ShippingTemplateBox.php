<?php
namespace Ecjia\Component\ShippingTemplate;


class ShippingTemplateBox extends ShippingTemplateAbstract
{

    /**
     * ShippingTemplateBox constructor.
     */
    public function __construct()
    {

        $this->default = array(
        	'shop_name'             => __('网店-名称', 'ecjia'),
        	'shop_tel'              => __('网店-联系电话', 'ecjia'),
            'shop_country'          => __('网店-国家', 'ecjia'),
            'shop_province'         => __('网店-省份', 'ecjia'),
            'shop_city'             => __('网店-城市', 'ecjia'),
            'shop_district'         => __('网店-区/县', 'ecjia'),
        	'shop_street'         	=> __('网店-街道', 'ecjia'),
        	'shop_address'          => __('网店-地址', 'ecjia'),

        	'customer_name'         => __('收件人-姓名', 'ecjia'),
        	'customer_tel'          => __('收件人-电话', 'ecjia'),
        	'customer_mobel'        => __('收件人-手机', 'ecjia'),
        	'customer_post'         => __('收件人-邮编', 'ecjia'),
            'customer_country'      => __('收件人-国家', 'ecjia'),
            'customer_province'     => __('收件人-省份', 'ecjia'),
            'customer_city'         => __('收件人-城市', 'ecjia'),
            'customer_district'     => __('收件人-区/县', 'ecjia'),
        	'customer_street'     	=> __('收件人-街道', 'ecjia'),
            'customer_address'      => __('收件人-详细地址', 'ecjia'),
 
        	'order_no'              => __('订单号-订单', 'ecjia'),
        	'order_amount'          => __('订单金额-订单', 'ecjia'),
        	'order_postscript'      => __('备注-订单', 'ecjia'),
        	'order_best_time'       => __('送货时间-订单', 'ecjia'),
            'year'                  => __('年-当日日期', 'ecjia'),
            'months'                => __('月-当日日期', 'ecjia'),
            'day'                   => __('日-当日日期', 'ecjia'),
	
            'pigeon'                => __('√-对号', 'ecjia'),
            'custom_content'        => __('自定义内容', 'ecjia'),
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