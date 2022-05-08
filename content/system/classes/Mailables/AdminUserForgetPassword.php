<?php


namespace Ecjia\System\Mailables;


use ecjia;
use Ecjia\App\Mail\Mailable\MailableWithTemplateAbstract;
use Ecjia\System\Admins\Users\AdminUserModel;
use ecjia_error;
use ecjia_password;
use RC_Time;
use RC_Uri;

class AdminUserForgetPassword extends MailableWithTemplateAbstract
{

    protected $eventCode = 'admin_forget_password';

    /**
     * 订单实例。
     *
     * @var AdminUserModel
     */
    public $adminModel;

    /**
     * 创建一个消息实例。
     *
     * @return void
     */
    public function __construct($admin_model)
    {
        parent::__construct();

        $this->adminModel = $admin_model;
    }

    /**
     * 构造消息。
     *
     * @return ecjia_error|string
     */
    public function build()
    {
        parent::build();
        
        $content     = $this->templateModel->template_content;
        $reset_email = $this->getResetMailUrl();

        $this->subject($this->templateModel->template_subject);

        $data = [
            'user_name'   => $this->adminModel->user_name,
            'reset_email' => $reset_email,
            'shop_name'   => ecjia::config('shop_name'),
            'send_date'   => RC_Time::local_date(ecjia::config('date_format')),
        ];

        $this->view($content, $data);
    }

    private function getResetMailUrl()
    {
        /* 生成验证的code */
        $rand_code = str_random(10);

        $this->adminModel->setMeta('forget_password_hash', $rand_code);

        $admin_id   = $this->adminModel->user_id;
        $admin_pass = $this->adminModel->password;

        $pm   = ecjia_password::autoCompatibleDriver($admin_pass);
        $code = $pm->generateResetPasswordHash($admin_id, $admin_pass, $rand_code);

        $reset_email = RC_Uri::url('@get_password/reset_pwd_form', array('uid' => $admin_id, 'code' => $code));

        return $reset_email;
    }


}