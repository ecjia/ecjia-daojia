<?php
namespace Ecjia\Component\ShippingTemplate;


class ShippingTemplateTest extends ShippingTemplate
{


    public function __construct()
    {
        parent::__construct();

        $this->setTemplateData('shop_country', __('中国', 'ecjia'));
        $this->setTemplateData('shop_province', __('上海市', 'ecjia'));
        $this->setTemplateData('shop_city', __('上海市', 'ecjia'));
        $this->setTemplateData('shop_district', __('普陀区', 'ecjia'));
        $this->setTemplateData('shop_street', __('曹杨新村街道', 'ecjia'));
        $this->setTemplateData('shop_address', __('普陀区中山北路3551号', 'ecjia'));
        $this->setTemplateData('shop_name', __('天天果园', 'ecjia'));
        $this->setTemplateData('shop_tel', '15012345678');
        
        $this->setTemplateData('customer_country', __('中国', 'ecjia'));
        $this->setTemplateData('customer_province', __('上海市', 'ecjia'));
        $this->setTemplateData('customer_city', __('上海市', 'ecjia'));
        $this->setTemplateData('customer_district', __('普陀区', 'ecjia'));
        $this->setTemplateData('customer_street', __('曹杨新村街道', 'ecjia'));
        $this->setTemplateData('customer_tel', '021-12345678');
        $this->setTemplateData('customer_mobel', '13512345678');
        $this->setTemplateData('customer_post', '200000');
        $this->setTemplateData('customer_address', __('普陀区中山北路3559号', 'ecjia'));
        $this->setTemplateData('customer_name', __('张三', 'ecjia'));
        
        $this->setTemplateData('year', '2018');
        $this->setTemplateData('months', '12');
        $this->setTemplateData('day', '15');
        $this->setTemplateData('order_no', '2018121556988');
        $this->setTemplateData('order_amount', '66');
        $this->setTemplateData('order_postscript', __('速度发货', 'ecjia'));
        $this->setTemplateData('order_best_time', '2018-12-18 08:00-09:00');
    }
}

// end