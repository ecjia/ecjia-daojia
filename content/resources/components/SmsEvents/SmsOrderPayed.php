<?php

namespace Ecjia\Resources\Components\SmsEvents;

use Ecjia\App\Sms\EventFactory\EventAbstract;

class SmsOrderPayed extends EventAbstract
{

    protected $code = 'sms_order_payed';

    protected $name = '客户付款时';

    protected $description = '当客户付款时是否发送短信';
    
    protected $template = '订单编号：${order_sn}已付款。 收货人：${consignee}，联系电话：${telephone}，订单金额：${order_amount}。';

    protected $available_values = [
    	'order_sn'		=> '订单编号',
    	'consignee' 	=> '收货人',
    	'telephone'  	=> '联系方式',
    	'order_amount'  => '订单金额',
    	'service_phone' => '客服电话',
    ];
    
}
