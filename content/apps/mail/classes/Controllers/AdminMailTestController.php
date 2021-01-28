<?php


namespace Ecjia\App\Mail\Controllers;

use admin_nav_here;
use ecjia;
use Ecjia\App\Mail\Mailables\TestSendMailService;
use Ecjia\App\Mail\MailManager;
use ecjia_screen;
use RC_Script;
use RC_Style;
use RC_Uri;

class AdminMailTestController extends AdminBase
{

    public function __construct()
    {
        parent::__construct();

        RC_Style::enqueue_style('chosen');
        RC_Style::enqueue_style('uniform-aristo');
        RC_Script::enqueue_script('jquery-chosen');
        RC_Script::enqueue_script('jquery-uniform');
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');
    }

    /**
     * 邮件服务器设置
     */
    public function init()
    {
        $this->admin_priv('mail_settings_manage');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('发送测试邮件', 'mail')));

        $this->assign('ur_here',      __('测试邮件', 'mail'));

        ecjia_screen::get_current_screen()->add_help_tab( array(
            'id'        => 'overview',
            'title'     => __('概述', 'mail'),
            'content'   =>
                '<p>' . __('欢迎访问ECJia智能后台邮件服务器设置页面，可通过以下两种方式进行配置。', 'mail') . '</p>'
        ) );

        ecjia_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . __('更多信息：', 'mail') . '</strong></p>' .
            '<p><a href="https://ecjia.com/wiki/帮助:ECJia智能后台:系统设置#.E9.82.AE.E4.BB.B6.E6.9C.8D.E5.8A.A1.E5.99.A8.E8.AE.BE.E7.BD.AE" target="_blank">' . __('关于邮件服务器设置帮助文档', 'mail') . '</a></p>'
        );

        $this->assign('form_action', RC_Uri::url('mail/admin_mail_test/send_test_email'));

        return $this->display('mail_test.dwt');
    }


    /**
     * 发送测试邮件
     */
    public function send_test_email()
    {
        try {
            $this->admin_priv('mail_settings_manage', ecjia::MSGTYPE_JSON);

            $test_mail_address = trim($_POST['test_mail_address']);
            if (empty($test_mail_address)) {
                return $this->showmessage(__('测试邮件地址不能为空！', 'mail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $result = MailManager::make()
                ->send($test_mail_address, new TestSendMailService());

            if (is_ecjia_error($result)) {
                return $this->showmessage(sprintf(__('测试邮件发送失败！%s', 'mail'), $result->get_error_message()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            } else {
                return $this->showmessage(sprintf(__('恭喜！测试邮件已成功发送到 %s。', 'mail'), $test_mail_address), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
            }
        } catch (\Exception $exception) {
            return $this->showmessage($exception->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } catch (\Error $exception) {
            return $this->showmessage($exception->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }


}