<?php


namespace Ecjia\App\Mail\Events;

use Ecjia\App\Mail\Mailable\MailableAbstract;

class SendMailBeforeEvent
{

    /**
     * @var string
     */
    public $email;

    /**
     * @var MailableAbstract
     */
    public $content;

    /**
     * SendMailBeforeEvent constructor.
     * @param string $email
     * @param array $template_var
     */
    public function __construct(string $email, MailableAbstract $content)
    {
        $this->email        = $email;
        $this->content = $content;
    }

}