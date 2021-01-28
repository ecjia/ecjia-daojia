<?php

namespace Ecjia\App\Mail\Mailable;

use Illuminate\Support\HtmlString;

abstract class MailableAbstract extends \Illuminate\Mail\Mailable
{
    /**
     * @var string
     */
    protected $eventCode;

    public function build()
    {
        $this->from(config('mail.from.address'), config('mail.from.name'));

        $this->withSwiftMessage(function ($message) {
            $message->setCharset(config('mail.charset'));
        });
    }

    /**
     * Build the view for the message.
     *
     * @return array|string
     *
     * @throws \ReflectionException
     */
    protected function buildView()
    {
        return $this->buildSmartyView();
    }

    /**
     * @return array
     */
    protected function buildSmartyView()
    {
        $smarty = royalcms('view')->getSmarty();

        $data = $this->buildViewData();

        $smarty->assign($data);

        $content = $smarty->fetch('string:' . $this->view);

        return [
            'html' => new HtmlString($content),
        ];
    }

    /**
     * @return string
     */
    public function getEventCode(): string
    {
        return $this->eventCode;
    }

    /**
     * @param string $eventCode
     * @return MailableAbstract
     */
    public function setEventCode($eventCode): MailableAbstract
    {
        $this->eventCode = $eventCode;
        return $this;
    }

}