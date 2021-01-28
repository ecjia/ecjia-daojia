<?php

namespace Ecjia\Resources\Components\SmsEvents;

use Ecjia\App\Sms\EventFactory\EventAbstract;

class SmsOrderShipped extends EventAbstract
{

    protected $code = 'sms_order_shipped';

    protected $name = '订单发货时';

    protected $description = '当商家发货时是否发送短信';
    
    protected $template = '尊敬的${user_name}用户，您的订单${order_sn}已发货，收货人${consignee}，请您及时查收。';

    protected $available_values = [
    	'user_name'    => '会员名称',
    	'order_sn'     => '订单编号',
    	'consignee'    => '收货人',
    	'service_phone'=> '客服电话',
    ];
    
    
}
