<?php


namespace Ecjia\App\Mail\FormRequests;

use Ecjia\System\Frameworks\FormRequests\CustomFormRequest;

class MailSendRequest extends CustomFormRequest
{

    /**
     * 验证规则
     */
    public function rules()
    {
        return [
            'email' => 'required|email:rfc,dns',
        ];
    }

    /**
     * 验证消息
     */
    public function messages()
    {
        return [
            'email.required'  => __('邮箱不能为空', 'mail'),
            'email.email'     => __('必须输入合法的邮箱', 'mail'),
        ];
    }

}