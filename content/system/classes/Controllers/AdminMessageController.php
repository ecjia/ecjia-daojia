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

namespace Ecjia\System\Controllers;

use admin_nav_here;
use ecjia;
use Ecjia\System\Admins\Users\AdminUserModel;
use Ecjia\System\Models\AdminMessageModel;
use ecjia_admin;
use ecjia_screen;
use RC_Script;
use RC_Style;
use RC_Time;
use RC_Uri;

class AdminMessageController extends ecjia_admin
{
    public function __construct()
    {
        parent::__construct();
    }

    public function init()
    {
        /* 加载所需js */
        RC_Script::enqueue_script('smoke');
        RC_Script::enqueue_script('jquery-chosen');
        RC_Script::enqueue_script('ecjia-admin_cleditor', RC_Uri::admin_url() . '/statics/lib/CLEditor/jquery.cleditor.js', array('ecjia-admin'), false, true);
        RC_Script::enqueue_script('ecjia-admin_message_list');

        /* 页面所需CSS加载 */
        RC_Style::enqueue_style('chosen');
        RC_Style::enqueue_style('bootstrap-responsive');
        RC_Style::enqueue_style('admin_cleditor_style', RC_Uri::admin_url() . '/statics/lib/CLEditor/jquery.cleditor.css');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('管理员留言')));
        $this->assign('ur_here', __('管理员留言'));

        ecjia_screen::get_current_screen()->add_help_tab(array(
            'id' => 'overview',
            'title' => __('概述'),
            'content' =>
                '<p>' . __('欢迎访问ECJia智能后台管理员留言页面，所有管理员可以在此进行留言交谈方便管理。') . '</p>'
        ));

        ecjia_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . __('更多信息：') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:管理员留言" target="_blank">关于管理员留言帮助文档</a>') . '</p>'
        );

        //交谈用户id
        $chat_id = intval($this->request->input('chat_id'));

        $chat_list = $this->get_admin_chat();

        //获取管理员列表
        $admin_list = AdminUserModel::select('user_id', 'user_name')->get();

        $admin_online = [$_SESSION['admin_id']];

        $chat_name = $admin_list->where('user_id', $chat_id)->first()['user_name'];

        $admin_list = $admin_list->map(function ($model) use ($admin_online) {
            $model->is_online = in_array($model->user_id, $admin_online) ? 1 : 0;
            $model->icon = in_array($model->user_id, $admin_online) ? RC_Uri::admin_url('statics/images/humanoidIcon_online.png') : RC_Uri::admin_url('statics/images/humanoidIcon.png');
            return $model;
        })->toArray();

        $this->assign('admin_list', $admin_list);
        $this->assign('message_list', $chat_list['item']);
        $this->assign('message_lastid', $chat_list['last_id']);
        $this->assign('chat_name', $chat_name);
        $chat_id = $this->request->input('chat_id');
        $refresh_url = RC_Uri::url('admin_message/init', empty($chat_id) ? [] : ['chat_id' => $chat_id]);
        $this->assign('refresh_url', $refresh_url);
        $this->assign('filter', $chat_list['filter']);
        return $this->display('message_list.dwt');
    }

    /**
     * 获取已读的留言
     */
    public function readed_message()
    {
        /* 获取留言 */
        $list = $this->get_admin_chat();

        if (!empty($list['item']) && count($list['item']) > 10) {
            return $this->showmessage(__('搜索到了', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR));
        }

        return $this->showmessage(__('没有更多消息了', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR));
    }

    /**
     * 处理留言的发送
     */
    public function insert()
    {
        $message = remove_xss($this->request->input('message'));
        if (empty($message) OR empty($_SESSION['admin_id'])) {
            return $this->showmessage(__('发送失败'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $id = intval($this->request->input('chat_id'));

        $gmtime = RC_Time::gmtime();

        $model = new AdminMessageModel();
        $model->sender_id = $_SESSION['admin_id'];
        $model->receiver_id = $id;
        $model->sent_time = $gmtime;
        $model->read_time = 0;
        $model->readed = 0;
        $model->deleted = 0;
        $model->title = remove_xss($this->request->input('title', ''));
        $model->message = $message;
        $model->save();

        //回复消息之前，所有收到的消息设为已读
        $this->read_meg($id);
        ecjia_admin::admin_log(__('发送留言'), 'add', 'admin_message');
        return $this->showmessage(__('发送成功'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('sent_time' => RC_Time::local_date(ecjia::config('time_format'), $gmtime)));
    }

    /**
     *  更改留言为已读状态
     *
     * @return void
     */
    private function read_meg($chatid)
    {
        $query = AdminMessageModel::where('receiver_id', $_SESSION['admin_id'])->where('readed', 0);

        if (!empty($chatid)) {
            //更新阅读日期和阅读状态
            $query->where('sender_id', intval($chatid));
        }

        $query->update([
            'read_time' => RC_Time::gmtime(),
            'readed' => '1'
        ]);
    }

    /**
     *  获取管理员未读消息
     *
     * @return array
     */
    private function get_admin_chat($filters = [])
    {
        /* 查询条件 */
        $filter['chat_id'] = intval($this->request->input('chat_id', 0));
        $filter['msg_type'] = intval($this->request->input('msg_type'));
        $filter['sort_by-id'] = remove_xss($this->request->input('sort_by', 'sent_time'));
        $filter['sort_order'] = remove_xss($this->request->input('sort_order', 'DESC'));

        //群聊的状态
        empty($filter['chat_id']) && $filter = array_merge($filter, array('msg_type' => 1, 'start' => 0, 'page_size' => 10));

        //与自己交谈的状态
        $filter['chat_id'] == $_SESSION['admin_id'] && $filter = array_merge($filter, array('msg_type' => 2, 'start' => 0, 'page_size' => 10));

        //获取已读留言的状态
        $filter['last_id'] = intval($this->request->input('last_id'));
        !empty($filter['last_id']) && $filter = array_merge($filter, array('start' => 0, 'page_size' => 10));

        $filter = array_merge($filter, $filters);

        $query = AdminMessageModel::where('deleted', 0);

        /* 查询条件 */
        switch ($filter['msg_type']) {
            case 1:
                $query->where('receiver_id', 0);
                break;
            case 2 :
                $query->where('receiver_id', $_SESSION['admin_id']);
                break;
            case 3:
                $query->where('receiver_id', $_SESSION['admin_id'])->where('readed', 0)->where('deleted', 0);
                break;
            default:
                $query->where('readed', empty($filter['last_id']) ? 0 : 1)->where(function ($query) use ($filter) {
                    $query->where('sender_id', $filter['chat_id'])
                        ->where('receiver_id', $filter['chat_id'])
                        ->where('receiver_id', $_SESSION['admin_id'])
                        ->orWhere('sender_id', $_SESSION['admin_id']);
                });
                break;
        }

        if (!empty($filter['last_id'])) {
            $query->where('message_id', '<', $filter['last_id']);
        }

        $count = $query->count();

        $items = $query->with(['admin_user_model' => function ($query) {
            $query->select('user_id', 'user_name');
        }])->get();

        if (empty($items)) {
            return null;
        }

        $items = $items->map(function ($model) {
            $model->user_name = empty($model->admin_user_model) ? __('佚名') . $model->admin_user_model->user_id : $model->admin_user_model->user_name;
            $model->sent_time = RC_Time::local_date(ecjia::config('time_format'), $model->sent_time);
            $model->read_time = RC_Time::local_date(ecjia::config('time_format'), $model->read_time);
            return $model;
        })->toArray();

        return [
            'item' => array_reverse($items),
            'filter' => $filter,
            'record_count' => $count,
            'last_id' => end($items)['message_id']
        ];
    }
}