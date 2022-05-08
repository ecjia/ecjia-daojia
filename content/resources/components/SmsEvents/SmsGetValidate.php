<?php

namespace Ecjia\Resources\Components\SmsEvents;

use Ecjia\App\Sms\EventFactory\EventAbstract;

class SmsGetValidate extends EventAbstract
{

    protected $code = 'sms_get_validate';

    protected $name = '获取验证码';

    protected $description = '是否让用户获取验证码';

    protected $template = '您的验证码是：${code}，请不要把验证码泄露给其他人，如非本人操作，可不用理会。';

    protected $available_values = [
    	'code' => '验证码',
    	'service_phone'=>'客服电话',
    ];



}
