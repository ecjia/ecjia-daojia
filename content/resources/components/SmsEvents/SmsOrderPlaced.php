<?php


namespace Ecjia\Resources\Components\SmsEvents;

use Ecjia\App\Sms\EventFactory\EventAbstract;

class SmsOrderPlaced extends EventAbstract
{

    protected $code = 'sms_order_placed';

    protected $name = '客户下单时';

    protected $description = '当客户下单时是否发送短信';
    
    protected $template = '有客户下单啦！快去看看吧！订单编号：${order_sn}，收货人：${consignee}，联系电话：${telephone}，订单金额：${order_amount}。';

    protected $available_values = [
        'order_sn'		=> '订单编号',
    	'consignee' 	=> '收货人',
    	'telephone'      => '联系电话',
    	'order_amount'  => '订单金额',
    	'service_phone' => '客服电话',
    ];
    
    
}
