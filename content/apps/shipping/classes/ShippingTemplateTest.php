<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-20
 * Time: 18:05
 */

namespace Ecjia\App\Shipping;


class ShippingTemplateTest extends ShippingTemplate
{


    public function __construct()
    {
        parent::__construct();

        $this->setTemplateData('shop_country', '中国');
        $this->setTemplateData('shop_province', '上海市');
        $this->setTemplateData('shop_city', '上海市');
        $this->setTemplateData('shop_district', '普陀区');
        $this->setTemplateData('shop_street', '曹杨新村街道');
        $this->setTemplateData('shop_address', '普陀区中山北路3551号');
        $this->setTemplateData('shop_name', '天天果园');
        $this->setTemplateData('shop_tel', '15012345678');
        
        $this->setTemplateData('customer_country', '中国');
        $this->setTemplateData('customer_province', '上海市');
        $this->setTemplateData('customer_city', '上海市');
        $this->setTemplateData('customer_district', '普陀区');
        $this->setTemplateData('customer_street', '曹杨新村街道');
        $this->setTemplateData('customer_tel', '021-12345678');
        $this->setTemplateData('customer_mobel', '13512345678');
        $this->setTemplateData('customer_post', '200000');
        $this->setTemplateData('customer_address', '普陀区中山北路3559号');
        $this->setTemplateData('customer_name', '张三');
        
        $this->setTemplateData('year', '2018');
        $this->setTemplateData('months', '12');
        $this->setTemplateData('day', '15');
        $this->setTemplateData('order_no', '2018121556988');
        $this->setTemplateData('order_amount', '66');
        $this->setTemplateData('order_postscript', '速度发货');
        $this->setTemplateData('order_best_time', '2018-12-18 08:00-09:00');
    }
}

// end