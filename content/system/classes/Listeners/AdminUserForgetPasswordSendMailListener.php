<?php


namespace Ecjia\System\Listeners;


use Ecjia\System\Events\AdminUserForgetPasswordEvent;
use Ecjia\System\Exceptions\SendMailFailedException;
use Ecjia\System\Mailables\AdminUserForgetPassword;
use RC_Api;

class AdminUserForgetPasswordSendMailListener
{

    /**
     * 处理事件
     *
     * @param AdminUserForgetPasswordEvent $event
     * @return bool
     * @throws SendMailFailedException
     */
    public function handle(AdminUserForgetPasswordEvent $event)
    {
        $admin_model = $event->admin_model;

        $admin_email = $admin_model->email;

        $result = RC_Api::api('mail', 'send_event_mail', [
            'email' => $admin_email,
            'content' => new AdminUserForgetPassword($admin_model),
        ]);

        if (is_ecjia_error($result)) {
            throw new SendMailFailedException($result->get_error_message());
        }

        return true;
    }

}