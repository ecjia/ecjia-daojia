<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//
namespace Ecjia\App\Mail\Controllers;

use admin_nav_here;
use ecjia;
use Ecjia\App\Mail\Models\EmailSendlistModel;
use Ecjia\App\Mail\Models\MailTemplateModel;
use ecjia_admin;
use ecjia_page;
use ecjia_screen;
use RC_App;
use RC_DB;
use RC_Mail;
use RC_Script;
use RC_Style;
use RC_Uri;

/**
 * ECJia 邮件队列管理
 * @author songqian
 */
class AdminMailSendlistController extends AdminBase
{

    public function __construct()
    {
        parent::__construct();

        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');
        RC_Style::enqueue_style('chosen');
        RC_Style::enqueue_style('uniform-aristo');
        RC_Script::enqueue_script('jquery-uniform');
        RC_Script::enqueue_script('jquery-chosen');

        RC_Script::enqueue_script('mail_sendlist', RC_App::apps_url('statics/js/mail_sendlist.js', $this->__FILE__));
        RC_Script::localize_script('mail_sendlist', 'js_lang_mail_sendlist', config('app-mail::jslang.mail_sendlist_page'));
    }

    public function init()
    {
        $this->admin_priv('email_sendlist_manage');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('邮件发送队列', 'mail')));
        ecjia_screen::get_current_screen()->add_help_tab(array(
            'id'      => 'overview',
            'title'   => __('概述', 'mail'),
            'content' => '<p>' . __('欢迎访问ECJia智能后台邮件队列管理页面，系统中所有准备发送的邮件都会显示在此队列中。', 'mail') . '</p>'
        ));

        ecjia_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . __('更多信息：', 'mail') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:邮件对列管理" target="_blank">关于邮件队列管理帮助文档</a>', 'mail') . '</p>'
        );

        $this->assign('ur_here', __('邮件发送队列', 'mail'));
        $pri  = config('app-mail::mail_config.pri');
        $this->assign('pri', $pri);

        $send_list = $this->get_send_list();

        $this->assign('send_list', $send_list);

        $this->assign('form_action', RC_Uri::url('mail/admin_mail_sendlist/all_send'));
        $this->assign('search_action', RC_Uri::url('mail/admin_mail_sendlist/init'));

        return $this->display('mail_sendlist.dwt');
    }

    /**
     * 删除单个
     */
    public function remove()
    {
        try {
            $this->admin_priv('email_sendlist_delete', ecjia::MSGTYPE_JSON);

            $id = intval($_GET['id']);

            EmailSendlistModel::where('id', $id)->delete();

            ecjia_admin::admin_log(sprintf(__('删除邮件记录，编号是 %s', 'mail'), $id), 'remove', 'email_sendlist');

            return $this->showmessage(sprintf(__('共删除 %d 条记录，删除成功！', 'mail'), 1), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
        } catch (\Exception $exception) {
            return $this->showmessage($exception->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 批量操作
     */
    public function batch()
    {
        $this->admin_priv('email_sendlist_delete', ecjia::MSGTYPE_JSON);

        $action = isset($_GET['sel_action']) ? trim($_GET['sel_action']) : '';
        $ids    = $_POST['checkboxes'];

        if (empty($action)) {
            return $this->showmessage(__('请选择要进行的操作', 'mail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (!is_array($ids)) {
            $ids = explode(',', $ids);
        }

        if (empty($ids)) {
            return $this->showmessage(__('没有选择消息', 'mail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        switch ($action) {
            case 'batchdel':
                MailTemplateModel::whereIn('id', $ids)->delete();

                foreach ($ids as $id) {
                    ecjia_admin::admin_log(sprintf(__('删除邮件记录，编号是 %s', 'mail'), $id), 'remove', 'email_sendlist');
                }

                return $this->showmessage(sprintf(__('共删除 %d 条记录，删除成功！', 'mail'), count($ids)), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mail/admin_mail_sendlist/init')));
            default :
                break;
        }
    }

    /**
     * 获取邮件队列
     */
    private function get_send_list()
    {
        $pri_id = $this->request->input('pri_id', null);

        $query = function ($query) use ($pri_id) {
            if (!is_null($pri_id)) {
                return $query->where('pri', $pri_id);
            }
            return $query;
        };

        $filter['sort_by']    = empty($_GET['sort_by']) ? 'pri' : trim($_GET['sort_by']);
        $filter['sort_order'] = empty($_GET['sort_order']) ? 'DESC' : trim($_GET['sort_order']);

        $count = EmailSendlistModel::where($query)->count();

        $page  = new ecjia_page($count, 15, 5);

        $row = EmailSendlistModel::with('mail_template_model')
            ->select('id', 'template_id', 'email', 'pri', 'error', RC_DB::raw('FROM_UNIXTIME(last_send) AS last_send'))
            ->where($query)
            ->orderBy($filter['sort_by'], $filter['sort_order'])->orderBy('last_send', 'desc')
            ->take(15)
            ->skip($page->start_id - 1)
            ->get();

        if ($row->isNotEmpty()) {
            $row = $row->map(function ($item) {
                $data = $item;
                $data['template_subject'] = $item->mail_template_model->template_subject ?: __('临时邮件', 'mail');
                return $data;
            });
        }

        $item = $row->toArray();

        return array('item' => $item, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc());
    }

}

//end