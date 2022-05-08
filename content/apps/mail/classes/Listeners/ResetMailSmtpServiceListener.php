<?php

namespace Ecjia\App\Mail\Listeners;

use Ecjia\App\Mail\Events\ResetMailConfigEvent;

class ResetMailSmtpServiceListener
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    /**
     * Handle the event.
     *
     * @param $event
     * @return void
     */
    public function handle(ResetMailConfigEvent $event)
    {
        if ($event->mailer == 'smtp') {
            $config = royalcms('config');

            $config->set('mail.mailers.smtp.host',        array_get($event->config, 'smtp_host'));
            $config->set('mail.mailers.smtp.port',        array_get($event->config, 'smtp_port'));
            $config->set('mail.mailers.smtp.username',    array_get($event->config, 'smtp_user'));
            $config->set('mail.mailers.smtp.password',    array_get($event->config, 'smtp_pass'));

            if (intval(array_get($event->config, 'smtp_ssl')) === 1) {
                $config->set('mail.mailers.smtp.encryption', 'ssl');
            } else {
                $config->set('mail.mailers.smtp.encryption', 'tcp');
            }

            $config->set('mail.from.address', array_get($event->config, 'from_address'));
            $config->set('mail.from.name',   array_get($event->config, 'from_name'));
            $config->set('mail.charset',     array_get($event->config, 'mail_charset'));
        }
    }

}