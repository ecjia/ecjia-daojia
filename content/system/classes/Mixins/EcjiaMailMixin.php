<?php


namespace Ecjia\System\Mixins;


use Ecjia\App\Mail\MailManager;
use Ecjia\System\Mailables\CustomUniversalMailabel;

class EcjiaMailMixin
{

    /**
     * @return \Closure
     */
    public function send_mail()
    {
        return function ($name, $email, $subject, $content, $type = 0, $notification = false) {
            $custom = new CustomUniversalMailabel();
            $custom->to($email, $name);
            $custom->subject($subject);
            $custom->withSwiftMessage(function ($message) use ($content, $type, $notification) {
                // Set email format to HTML
                if ($type) {
                    $message->setBody($content, 'text/html');
                } else {
                    $message->setBody($content, 'text/plain');
                }

                if ($notification) {
                    $message->setReadReceiptTo(config('mail.from.address'));
                }
            });

            $result = MailManager::make()
                ->send($email, $custom);

            return $result;
        };
    }

}