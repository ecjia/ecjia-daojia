<?php


namespace Ecjia\App\Mail\Mailables;


use Ecjia\App\Mail\Mailable\MailableAbstract;

class TestSendMailService extends MailableAbstract
{

    protected $eventCode = 'send_test_email';


    /**
     * 创建一个消息实例。
     */
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * 构造消息。
     *
     * @return void
     */
    public function build()
    {
        parent::build();

        $this->subject(__('测试邮件', 'mail'));

        $content = __('您好！这是一封检测邮件服务器设置的测试邮件。收到此邮件，意味着您的邮件服务器设置正确！您可以进行其它邮件发送的操作了！', 'mail');

        $this->view($content);
    }


}