<?php

namespace Ecjia\Resources\Components\SmsEvents;

use Ecjia\App\Sms\EventFactory\EventAbstract;

class SmsOrderPickup extends EventAbstract
{

    protected $code = 'sms_order_pickup';

    protected $name = '订单收货验证码';

    protected $description = '订单收货验证码是否发送短信';
    
    protected $template = '尊敬的${user_name}，您在我们网站已成功下单。订单号：${order_sn}，收货验证码为：${code}。请保管好您的验证码，以便收货验证。
    ';

    protected $available_values = [
    	'user_name' 	=> '会员名称',
    	'order_sn'		=> '订单号',
    	'code' 			=> '提货码',
    	'service_phone' => '客服电话',
    ];
    
    
}
