<?php


namespace Ecjia\App\Mail\Events;

use Ecjia\App\Mail\Mailable\MailableAbstract;

class SendMailAfterEvent
{

    /**
     * 邮箱
     * @var string
     */
    public $email;

    /**
     * 模板变量
     * @var MailableAbstract
     */
    public $content;

    /**
     * 发送结果
     * @var array
     */
    public $result;

    /**
     * SendMailAfterEvent constructor.
     * @param string $email
     * @param MailableAbstract $content
     * @param mixed $result
     */
    public function __construct(string $email, MailableAbstract $content, $result)
    {
        $this->email   = $email;
        $this->content = $content;
        $this->result  = $result;
    }


}