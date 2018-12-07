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
 * ECJIA客服聊天记录
 */
class platform_record extends ecjia_platform
{
    public function __construct()
    {
        parent::__construct();

        RC_Loader::load_app_func('global');
        Ecjia\App\Wechat\Helper::assign_adminlog_content();


        /* 加载全局 js/css */
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('bootstrap-placeholder');

        RC_Script::enqueue_script('admin_record', RC_App::apps_url('statics/platform-js/admin_record.js', __FILE__));
        RC_Style::enqueue_style('admin_subscribe', RC_App::apps_url('statics/css/admin_subscribe.css', __FILE__));
        RC_Script::localize_script('admin_record', 'js_lang', RC_Lang::get('wechat::wechat.js_lang'));

        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.customer_chat_record'), RC_Uri::url('wechat/platform_record/init')));
        ecjia_platform_screen::get_current_screen()->set_subject('客服聊天记录');
    }

    //客服消息记录列表
    public function init()
    {
        $this->admin_priv('wechat_record_manage');

        ecjia_platform_screen::get_current_screen()->remove_last_nav_here();
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.customer_chat_record')));
        $this->assign('ur_here', RC_Lang::get('wechat::wechat.customer_chat_record'));

        $wechat_id = $this->platformAccount->getAccountID();

        if (is_ecjia_error($wechat_id)) {
            $this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
        } else {
            $this->assign('warn', 'warn');
            $this->assign('action', RC_Uri::url('wechat/platform_record/init'));
            $kf_list = RC_DB::table('wechat_customer')->where('wechat_id', $wechat_id)->orderBy('id', 'asc')->select('id', 'kf_nick', 'kf_account')->where('status', 1)->get();
            $this->assign('kf_list', $kf_list);

            $list = $this->get_record_list();
            $this->assign('list', $list);
            //获取公众号类型 0未认证 1订阅号 2服务号 3认证服务号 4企业号
            $types = $this->platformAccount->getType();
            $this->assign('type', $types);
            $this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.notice_service_info'), RC_Lang::get('wechat::wechat.wechat_type.' . $types)));
        }

        $recordStorage = new Ecjia\App\Wechat\Synchronizes\CustomerRecordStorage($wechat_id);

        list($start_time, $end_time) = $recordStorage->getStartTimeAndEndTime();

        $time['start_time'] = date('Y-m-d H:i', $start_time);
        $time['end_time'] = date('Y-m-d H:i', $end_time);
        $this->assign('time', $time);

        $this->display('wechat_record_list.dwt');
    }

    //查看用户客服消息记录
    public function record_message()
    {
        $this->admin_priv('wechat_record_manage', ecjia::MSGTYPE_JSON);

        $wechat_id = $this->platformAccount->getAccountID();

        if (is_ecjia_error($wechat_id)) {
            $this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
        } else {
            $this->assign('warn', 'warn');
            //获取公众号类型 0未认证 1订阅号 2服务号 3认证服务号 4企业号
            $type = $this->platformAccount->getType();
            $this->assign('type', $type);

            $this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.notice_subscribe_info'), RC_Lang::get('wechat::wechat.wechat_type.' . $type)));
        }
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.customer_message_record')));

        $uid = !empty($_GET['uid']) ? $_GET['uid'] : '';
        $page = !empty($_GET['page']) ? intval($_GET['page']) : 1;
        $status = !empty($_GET['status']) ? intval($_GET['status']) : 1;
        $kf_account = !empty($_GET['kf_account']) ? $_GET['kf_account'] : '';

        $this->assign('ur_here', RC_Lang::get('wechat::wechat.customer_message_record'));
        $this->assign('action_link', array('text' => RC_Lang::get('wechat::wechat.customer_chat_record'), 'href' => RC_Uri::url('wechat/platform_record/init', array('status' => $status, 'kf_account' => $kf_account, 'page' => $page))));
        $this->assign('chat_action', RC_Uri::url('wechat/platform_record/send_message'));
        $this->assign('last_action', RC_Uri::url('wechat/platform_record/read_message'));

        if (empty($uid)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.pls_select_user'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
        }

        $info = RC_DB::table('wechat_user as u')
            ->leftJoin('users as us', RC_DB::raw('us.user_id'), '=', RC_DB::raw('u.ect_uid'))
            ->select(RC_DB::raw('u.*'), RC_DB::raw('us.user_name'))
            ->where(RC_DB::raw('u.uid'), $uid)
            ->where(RC_DB::raw('u.wechat_id'), $wechat_id)
            ->first();

        if ($info['subscribe_time']) {
            $info['subscribe_time'] = date(ecjia::config('time_format'), $info['subscribe_time']);
        }
        $info['platform_name'] = $this->platformAccount->getAccountName();
        $this->assign('info', $info);
        $message = $this->get_message_list();
        $this->assign('message', $message);

        //最后发送时间
        $last_send_time = RC_DB::table('wechat_customer_record')->where('openid', $info['openid'])->where('opercode', 2002)->where('wechat_id', $wechat_id)->orderBy('id', 'desc')->take(1)->pluck('time');

        $time = time();
        if ($time - $last_send_time > 48 * 3600) {
            $this->assign('disabled', '1');
        }
        $this->display('wechat_record_message.dwt');
    }

    //获取消息列表
    public function get_record_list()
    {
        $wechat_id = $this->platformAccount->getAccountID();
        $platform_name = $this->platformAccount->getAccountName();

        $openid_list = RC_DB::table('wechat_user')->where('wechat_id', $wechat_id)->lists('openid');
        $where = 'cr.opercode = 2003 and cr.wechat_id =' . $wechat_id;

        $filter['kf_account'] = !empty($_GET['kf_account']) ? $_GET['kf_account'] : '';
        $filter['status'] = !empty($_GET['status']) ? intval($_GET['status']) : 1;

        if ($filter['kf_account']) {
            $where .= " and cr.kf_account = " . "'$filter[kf_account]'";
        }

        $time_1 = mktime(0, 0, 0, date('m'), date('d') - 4, date('Y'));
        $time_2 = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y'));
        $time_3 = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $time_4 = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y'));

        $time_5 = mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'));
        $time_6 = mktime(0, 0, 0, date('m'), date('d'), date('Y'));

        $time_7 = mktime(0, 0, 0, date('m'), date('d') - 2, date('Y'));
        $time_8 = mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'));

        $time_9 = mktime(0, 0, 0, date('m'), date('d') - 4, date('Y'));

        $where1 = $where . ' and cr.time > ' . $time_1 . ' and cr.time < ' . $time_2;
        $where2 = $where . ' and cr.time > ' . $time_3 . ' and cr.time < ' . $time_4;
        $where3 = $where . ' and cr.time > ' . $time_5 . ' and cr.time < ' . $time_6;
        $where4 = $where . ' and cr.time > ' . $time_7 . ' and cr.time < ' . $time_8;
        $where5 = $where . ' and cr.time > 0' . ' and cr.time < ' . $time_9;

        switch ($filter['status']) {
            case '1':
                $start_date = $time_1;
                $end_date = $time_2;
                break;
            case '2':
                $start_date = $time_3;
                $end_date = $time_4;
                break;
            case '3':
                $start_date = $time_5;
                $end_date = $time_6;
                break;
            case '4':
                $start_date = $time_7;
                $end_date = $time_8;
                break;
            case '5':
                $start_date = 0;
                $end_date = $time_9;
                break;
        }
        $where .= ' and cr.time > ' . $start_date . ' and cr.time < ' . $end_date;

        $filter['last_five_days'] = count(RC_DB::table('wechat_customer_record as cr')
                ->leftJoin('wechat_user as wu', RC_DB::raw('wu.openid'), '=', RC_DB::raw('cr.openid'))
                ->leftJoin('wechat_customer as c', RC_DB::raw('c.kf_account'), '=', RC_DB::raw('cr.kf_account'))
                ->select(RC_DB::raw('max(cr.id) as id'))
                ->whereRaw($where1)
                ->groupBy(RC_DB::raw('cr.openid'))
                ->get()
        );
        $filter['today'] = count(RC_DB::table('wechat_customer_record as cr')
                ->leftJoin('wechat_user as wu', RC_DB::raw('wu.openid'), '=', RC_DB::raw('cr.openid'))
                ->leftJoin('wechat_customer as c', RC_DB::raw('c.kf_account'), '=', RC_DB::raw('cr.kf_account'))
                ->select(RC_DB::raw('max(cr.id) as id'))
                ->whereRaw($where2)
                ->groupBy(RC_DB::raw('cr.openid'))
                ->get()
        );
        $filter['yesterday'] = count(RC_DB::table('wechat_customer_record as cr')
                ->leftJoin('wechat_user as wu', RC_DB::raw('wu.openid'), '=', RC_DB::raw('cr.openid'))
                ->leftJoin('wechat_customer as c', RC_DB::raw('c.kf_account'), '=', RC_DB::raw('cr.kf_account'))
                ->select(RC_DB::raw('max(cr.id) as id'))
                ->whereRaw($where3)
                ->groupBy(RC_DB::raw('cr.openid'))
                ->get()
        );
        $filter['the_day_before_yesterday'] = count(RC_DB::table('wechat_customer_record as cr')
                ->leftJoin('wechat_user as wu', RC_DB::raw('wu.openid'), '=', RC_DB::raw('cr.openid'))
                ->leftJoin('wechat_customer as c', RC_DB::raw('c.kf_account'), '=', RC_DB::raw('cr.kf_account'))
                ->select(RC_DB::raw('max(cr.id) as id'))
                ->whereRaw($where4)
                ->groupBy(RC_DB::raw('cr.openid'))
                ->get()
        );
        $filter['earlier'] = count(RC_DB::table('wechat_customer_record as cr')
                ->leftJoin('wechat_user as wu', RC_DB::raw('wu.openid'), '=', RC_DB::raw('cr.openid'))
                ->leftJoin('wechat_customer as c', RC_DB::raw('c.kf_account'), '=', RC_DB::raw('cr.kf_account'))
                ->select(RC_DB::raw('max(cr.id) as id'))
                ->whereRaw($where5)
                ->groupBy(RC_DB::raw('cr.openid'))
                ->get()
        );

        $total = RC_DB::table('wechat_customer_record as cr')
            ->leftJoin('wechat_user as wu', RC_DB::raw('wu.openid'), '=', RC_DB::raw('cr.openid'))
            ->leftJoin('wechat_customer as c', RC_DB::raw('c.kf_account'), '=', RC_DB::raw('cr.kf_account'))
            ->select(RC_DB::raw('max(cr.id) as id'))
            ->whereRaw($where)
            ->groupBy(RC_DB::raw('cr.openid'))
            ->get();

        $count = count($total);
        $page = new ecjia_platform_page($count, 10, 5);

        $list = RC_DB::table('wechat_customer_record as cr')
            ->leftJoin('wechat_user as wu', function ($join_w) {
                $join_w->on(RC_DB::raw('wu.openid'), '=', RC_DB::raw('cr.openid'))
                    ->on(RC_DB::raw('wu.wechat_id'), '=', RC_DB::raw('cr.wechat_id'));
            })
            ->leftJoin('wechat_customer as c', function ($join_c) {
                $join_c->on(RC_DB::raw('c.kf_account'), '=', RC_DB::raw('cr.kf_account'))
                    ->on(RC_DB::raw('c.wechat_id'), '=', RC_DB::raw('cr.wechat_id'));
            })
            ->select(RC_DB::raw('max(cr.id) as id'), RC_DB::raw('wu.*'))
            ->whereRaw($where)
            ->groupBy(RC_DB::raw('cr.openid'))
            ->orderBy(RC_DB::raw('cr.time'), 'desc')
            ->take(10)
            ->skip($page->start_id - 1)
            ->get();

        $row = array();
        if (!empty($list)) {
            foreach ($list as $key => $val) {
                $info = RC_DB::table('wechat_customer_record')->where('wechat_id', $wechat_id)->where('id', $val['id'])->first();

                $list[$key]['time'] = date(ecjia::config('time_format'), $info['time']);
                $list[$key]['text'] = $info['text'];
                $list[$key]['openid'] = $info['openid'];
            }
            $row = $this->array_sequence($list, 'time');
        }
        return array('item' => $row, 'page' => $page->show(5), 'desc' => $page->page_desc(), 'filter' => $filter);
    }

    //获取信息
    public function read_message()
    {
        $this->admin_priv('wechat_record_manage', ecjia::MSGTYPE_JSON);

        $list = $this->get_message_list();
        $message = count($list['item']) < 10 ? RC_Lang::get('wechat::wechat.no_more_message') : RC_Lang::get('wechat::wechat.searched');
        if (!empty($list['item'])) {
            return $this->showmessage($message, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('msg_list' => $list['item'], 'last_id' => $list['last_id']));
        } else {
            return $this->showmessage($message, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    //获取用户客服消息列表
    public function get_message_list()
    {
        $wechat_id = $this->platformAccount->getAccountID();
        $platform_name = $this->platformAccount->getAccountName();

        $uid = !empty($_GET['uid']) ? $_GET['uid'] : '';
        $last_id = !empty($_GET['last_id']) ? intval($_GET['last_id']) : 0;
        $chat_id = !empty($_GET['chat_id']) ? $_GET['chat_id'] : 0;

        $openid = RC_DB::table('wechat_user')->where('wechat_id', $wechat_id)->where('uid', $uid)->pluck('openid');
        if (!empty($last_id)) {
            $where = "cr.openid = '" . $chat_id . "' AND cr.id <" . $last_id;
        } else {
            $where = "cr.openid = '" . $openid . "' ";
        }

        $count = RC_DB::table('wechat_customer_record as cr')->where(RC_DB::raw('cr.wechat_id'), $wechat_id)->whereRaw($where)->count();
        $page = new ecjia_platform_page($count, 10, 5);
        $list = RC_DB::table('wechat_customer_record as cr')
            ->leftJoin('wechat_user as wu', RC_DB::raw('wu.openid'), '=', RC_DB::raw('cr.openid'))
            ->leftJoin('wechat_customer as c', RC_DB::raw('c.kf_account'), '=', RC_DB::raw('cr.kf_account'))
            ->select(RC_DB::raw('cr.*'), RC_DB::raw('c.kf_nick'), RC_DB::raw('wu.nickname'))
            ->whereRaw($where)
            ->orderBy(RC_DB::raw('cr.time'), 'desc')
            ->take(10)
            ->skip($page->start_id - 1)
            ->get();

        if (!empty($list)) {
            foreach ($list as $key => $val) {
                $list[$key]['time'] = date(ecjia::config('time_format'), $val['time']);
                if (!empty($val['iswechat'])) {
                    $list[$key]['nickname'] = $platform_name;
                }
            }
            $end_list = end($list);
            $reverse_list = array_reverse($list);
        } else {
            $end_list = null;
            $reverse_list = null;
        }
        return array('item' => $reverse_list, 'page' => $page->show(5), 'desc' => $page->page_desc(), 'last_id' => $end_list['id']);
    }

    //排序
    public function array_sequence($array, $field, $sort = 'SORT_DESC')
    {
        $arrsort = array();
        foreach ($array as $uniqid => $row) {
            foreach ($row as $key => $value) {
                $arrsort[$key][$uniqid] = $value;
            }
        }
        if (!empty($array)) {
        	array_multisort($arrsort[$field], constant($sort), $array);
        }
        return $array;
    }

    //获取用户信息
    public function get_user_info()
    {
        $wechat_id = $this->platformAccount->getAccountID();

        $uid = !empty($_GET['uid']) ? intval($_GET['uid']) : 0;
        $info = RC_DB::table('wechat_user as u')
            ->leftJoin('users as us', RC_DB::raw('us.user_id'), '=', RC_DB::raw('u.ect_uid'))
            ->select(RC_DB::raw('u.*'), RC_DB::raw('us.user_name'))
            ->where(RC_DB::raw('u.uid'), $uid)
            ->where(RC_DB::raw('u.wechat_id'), $wechat_id)
            ->first();

        if ($info['subscribe_time']) {
            $info['subscribe_time'] = date(ecjia::config('time_format'), $info['subscribe_time']);
            $tag_list = RC_DB::table('wechat_user_tag')->where('userid', $info['uid'])->lists('tagid');
            $name_list = [];
            $db_wechat_tag = RC_DB::table('wechat_tag');
            if (!empty($tag_list)) {
                $name_list = $db_wechat_tag->whereIn('tag_id', $tag_list)->where('wechat_id', $wechat_id)->orderBy('tag_id', 'desc')->lists('name');
            }
            if (!empty($name_list)) {
                $info['tag_name'] = implode('，', $name_list);
            } else {
                $info['tag_name'] = RC_Lang::get('wechat::wechat.no_tag');
            }
        }
        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $info));
    }

    //获取客服会话聊天记录
    public function get_customer_record()
    {
        $this->admin_priv('wechat_record_manage', ecjia::MSGTYPE_JSON);

        $uuid = $this->platformAccount->getUUID();
        $wechat = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();

        $wechat_id = $this->platformAccount->getAccountID();

        try {
            $recordStorage = new Ecjia\App\Wechat\Synchronizes\CustomerRecordStorage($wechat_id);

            list($start_time, $end_time) = $recordStorage->getStartTimeAndEndTime();

            $list = $wechat->staff->records($start_time, $end_time, 1, 10000)->toArray();

            $recordStorage->setData(collect($list));

            if ($list['number'] > 0) {
                $recordStorage->save();
            } else {
                if ($start_time < SYS_TIME && SYS_TIME < $end_time) {
                    return $this->showmessage('当前没有更多数据', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/platform_record/init')));
                }

                if ($end_time > SYS_TIME) {
                    $end_time = SYS_TIME;
                }

                $recordStorage->setNextStartTime($end_time);
            }

            return $this->showmessage('获取完成', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/platform_record/init')));

        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }
}

//end
