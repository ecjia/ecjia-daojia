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
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 通知
 * by wutifang
 */
class mh_notification extends ecjia_merchant
{
    public function __construct()
    {
        parent::__construct();

        RC_Loader::load_app_func('global');
        Ecjia\App\Notification\Helper::assign_adminlog_content();

        RC_Script::enqueue_script('mh-notification', RC_App::apps_url('statics/js/mh-notification.js', __FILE__), array(), false, 1);
        RC_Style::enqueue_style('mh-notification', RC_App::apps_url('statics/css/mh-notification.css', __FILE__), array());

        RC_Script::localize_script('mh-notification', 'js_lang', config('app-notification::jslang.notification_page'));

    }

    /**
     * 通知逻辑处理
     */
    public function init()
    {
        $this->admin_priv('notification_manage');

        $this->assign('ur_here', __('通知列表', 'notification'));
        ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('通知列表', 'notification')));

        $list = $this->get_notification_list();
        $this->assign('list', $list);

        return $this->display('notification_list.dwt');
    }

    //标记通知为已读
    public function mark_read()
    {
        $this->admin_priv('notification_update', ecjia::MSGTYPE_JSON);

        $time = RC_Time::local_date('Y-m-d H:i:s', RC_Time::gmtime());
        $data = array(
            'read_at' => $time,
        );
        $type      = isset($_POST['type']) ? remove_xss($_POST['type']) : '';
        $status    = !empty($_GET['status']) ? remove_xss($_GET['status']) : 'not_read';
        $page      = !empty($_GET['page']) ? intval($_GET['page']) : 1;
        $page_size = 20;

        $pjax_status = $status;
        //标记全部
        if ($type == 'mark_all') {
            $db_notifications = RC_DB::table('notifications')->where('notifiable_id', $_SESSION['staff_id']);

            if ($status == 'not_read') {
                $db_notifications->whereNull('read_at');
            } elseif ($status != 'all') {
                //按类型筛选
                $status = str_replace('-', "\\", $status);
                $db_notifications->where('type', $status);
            }

            $notice_list = $db_notifications->whereIn('notifiable_type', ['staff_user', 'staff_user_model', 'orm_staff_user_model'])->take($page_size)->skip(($page - 1) * $page_size)->orderby('created_at', 'desc')->get();
            $id_list     = [];
            if (!empty($notice_list)) {
                foreach ($notice_list as $v) {
                    $arr   = json_decode($v['data'], true);
                    $title = $arr['body'];
                    ecjia_merchant::admin_log($title, 'batch_mark', 'notice');
                    $id_list[] = $v['id'];
                }
            }

            $db = RC_DB::table('notifications')->where('notifiable_id', $_SESSION['staff_id']);
            $update = $db->whereIn('notifiable_type', ['staff_user', 'staff_user_model', 'orm_staff_user_model'])->whereNull('read_at')->whereIn('id', $id_list)->update($data);
        } else {
            //标记该类型下全部通知为已读
            if (!empty($type)) {
                $db_notifications = RC_DB::table('notifications')->where('notifiable_id', $_SESSION['staff_id']);
                $notice_list = $db_notifications->whereIn('notifiable_type', ['staff_user', 'staff_user_model', 'orm_staff_user_model'])->whereRaw('type = ' . "'$type'")->whereNull('read_at')->get();
                if (!empty($notice_list)) {
                    foreach ($notice_list as $v) {
                        $arr   = json_decode($v['data'], true);
                        $title = $arr['body'];
                        ecjia_merchant::admin_log($title, 'mark', 'notice');
                    }
                }

                $db = RC_DB::table('notifications')->where('notifiable_id', $_SESSION['staff_id']);
                $update = $db->whereIn('notifiable_type', ['staff_user', 'staff_user_model', 'orm_staff_user_model'])->whereRaw('type = ' . "'$type'")->whereNull('read_at')->update($data);
            } else {
                //标记单个
                $id    = isset($_POST['val']) ? remove_xss($_POST['val']) : '';

                $db_notifications = RC_DB::table('notifications')->where('notifiable_id', $_SESSION['staff_id']);
                $info  = $db_notifications->whereIn('notifiable_type', ['staff_user', 'staff_user_model', 'orm_staff_user_model'])->where('id', $id)->whereNull('read_at')->first();
                $arr   = json_decode($info['data'], true);
                $title = $arr['body'];
                ecjia_merchant::admin_log($title, 'mark', 'notice');

                if (!empty($id)) {
                    $db = RC_DB::table('notifications')->where('notifiable_id', $_SESSION['staff_id']);
                    $update = $db->whereIn('notifiable_type', ['staff_user', 'staff_user_model', 'orm_staff_user_model'])->where('id', $id)->whereNull('read_at')->update($data);
                }
            }
        }
        if ($update) {
            return $this->showmessage(__('标记成功', 'notification'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('notification/mh_notification/init', array('status' => $pjax_status, 'page' => $page))));
        } else {
            return $this->showmessage(__('没有未读通知', 'notification'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    private function get_notification_list()
    {
        $db = RC_DB::table('notifications')->whereIn('notifiable_type', ['staff_user', 'staff_user_model', 'orm_staff_user_model'])->where('notifiable_id', $_SESSION['staff_id']);

        $status = !empty($_GET['status']) ? remove_xss($_GET['status']) : 'not_read';

        $db->whereIn('notifiable_type', ['staff_user', 'staff_user_model', 'orm_staff_user_model']);
        if ($status == 'not_read') {
            $db->whereNull('read_at');
        } elseif ($status != 'all') {
            //按类型筛选
            $status = str_replace('-', "\\", $status);
            $db->where('type', $status);
        }

        $type_count['count'] = RC_DB::table('notifications')->whereIn('notifiable_type', ['staff_user', 'staff_user_model', 'orm_staff_user_model'])->where('notifiable_id', $_SESSION['staff_id'])->count();
        $type_count['not_read'] = RC_DB::table('notifications')->whereIn('notifiable_type', ['staff_user', 'staff_user_model', 'orm_staff_user_model'])->where('notifiable_id', $_SESSION['staff_id'])->whereNull('read_at')->count();

        $page_size = 20;
        $count     = $db->count();
        $page      = new ecjia_merchant_page($count, $page_size, 5);
        $data      = $db->select('*')->take($page_size)->skip($page->start_id - 1)->orderby('created_at', 'desc')->get();

        //通知类型
        $type_list = RC_DB::table('notifications')->whereIn('notifiable_type', ['staff_user', 'staff_user_model', 'orm_staff_user_model'])->where('notifiable_id', $_SESSION['staff_id'])->select(RC_DB::raw('distinct type'))->get();
        if (!empty($type_list)) {
            foreach ($type_list as $k => $v) {
                $list = RC_DB::table('notifications')->whereIn('notifiable_type', ['staff_user', 'staff_user_model', 'orm_staff_user_model'])->where('notifiable_id', $_SESSION['staff_id'])->select('*')->where('type', $v['type'])->orderby('created_at', 'desc')->get();
                if (!empty($list)) {
                    foreach ($list as $key => $val) {
                        $arr                         = json_decode($val['data'], true);
                        $type_list[$k]['type_title'] = $arr['title'];
                    }
                }
                $type_list[$k]['count']             = RC_DB::table('notifications')->whereIn('notifiable_type', ['staff_user', 'staff_user_model', 'orm_staff_user_model'])->where('notifiable_id', $_SESSION['staff_id'])->select('*')->where('type', $v['type'])->count();
                $type_list[$k]['type']              = str_replace("\\", '-', $v['type']);
                $type_list[$k]['notice_type_title'] = mix_substr($type_list[$k]['type_title'], 15);
            }
        }

        if (!empty($data)) {
            foreach ($data as $key => $val) {
                $arr                      = json_decode($val['data'], true);
                $data[$key]['content']    = $arr['body'];
                $data[$key]['type_title'] = $arr['title'];

                $created_time               = $this->format_date($val['created_at']);
                $data[$key]['created_time'] = $created_time;
            }
        }

        return array('item' => $data, 'page' => $page->show(2), 'desc' => $page->page_desc(), 'type_count' => $type_count, 'type_list' => $type_list);
    }

    private function format_date($time)
    {
        $timezone = RC_Time::server_timezone();
        $time     = RC_Time::local_strtotime($time) + (($timezone - 8) * 3600);
        $t        = RC_Time::gmtime() - $time;
        $f        = array(
            '31536000' => __('年', 'notification'),
            '2592000'  => __('月', 'notification'),
            '604800'   => __('周', 'notification'),
            '86400'    => __('天', 'notification'),
            '3600'     => __('小时', 'notification'),
            '60'       => __('分钟', 'notification'),
            '1'        => __('秒', 'notification'),
        );
        foreach ($f as $k => $v) {
            if (0 != $c = floor($t / (int) $k)) {
                return $c . $v . __('前', 'notification');
            }
        }
    }
}

//end
