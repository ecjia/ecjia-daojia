<?php


namespace Ecjia\App\Mail\Events;


class ResetMailConfigEvent
{

    /**
     * 邮件服务名称
     * @var string
     */
    public $mailer;

    /**
     * 邮件配置
     * @var array
     */
    public $config;

    /**
     * ResetMailConfigEvent constructor.
     * @param string $mailer
     * @param array $config
     */
    public function __construct(string $mailer, array $config)
    {
        $this->mailer = $mailer;
        $this->config = $config;
    }


}