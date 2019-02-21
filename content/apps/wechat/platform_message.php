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
 * ECJIA消息管理
 */
class platform_message extends ecjia_platform
{
    public function __construct()
    {
        parent::__construct();

        RC_Loader::load_app_func('global');
        Ecjia\App\Wechat\Helper::assign_adminlog_content();

        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Style::enqueue_style('bootstrap-responsive');

        RC_Script::enqueue_script('platform_subscribe', RC_App::apps_url('statics/platform-js/platform_subscribe.js', __FILE__));
        RC_Style::enqueue_style('admin_subscribe', RC_App::apps_url('statics/css/admin_subscribe.css', __FILE__));

        RC_Script::localize_script('platform_subscribe', 'js_lang', config('app-wechat::jslang.platform_message_page'));

        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('消息管理', 'wechat'), RC_Uri::url('wechat/admin_subscribe/init')));
        ecjia_platform_screen::get_current_screen()->set_subject(__('消息管理', 'wechat'));
    }

    public function init()
    {
        $this->admin_priv('wechat_subscribe_message_manage');

        ecjia_platform_screen::get_current_screen()->remove_last_nav_here();
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('消息管理', 'wechat')));
        $this->assign('ur_here', __('消息管理', 'wechat'));

        $wechat_id = $this->platformAccount->getAccountID();

        if (is_ecjia_error($wechat_id)) {
            $this->assign('errormsg', __('请先添加公众号，再进行后续操作', 'wechat'));
        } else {
            $this->assign('warn', 'warn');
            $list = $this->get_message_list();
            $this->assign('list', $list);

            //获取公众号类型 0未认证 1订阅号 2服务号 3认证服务号 4企业号
            $types       = $this->platformAccount->getType();
            $wechat_type = array(__('未认证的公众号', 'wechat'), __('订阅号', 'wechat'), __('服务号', 'wechat'), __('测试账号', 'wechat'), __('企业号', 'wechat'));

            $this->assign('type', $types);
            $this->assign('type_error', sprintf(__('抱歉！您的公众号属于%s类型，该模块目前只支持“认证”和“测试”类型的公众号。', 'wechat'), $wechat_type[$types]));
        }

        $this->display('wechat_message_list.dwt');
    }

    //获取消息列表
    public function get_message_list()
    {
        $wechat_id = $this->platformAccount->getAccountID();

        $where            = 'wu.subscribe = 1 and m.iswechat = 0 and wu.wechat_id = ' . $wechat_id;
        $filter['status'] = !empty($_GET['status']) ? intval($_GET['status']) : 1;

        $m      = RC_Time::local_date('m');
        $d      = RC_Time::local_date('d');
        $y      = RC_Time::local_date('y');
        $time_1 = RC_Time::local_mktime(0, 0, 0, $m, $d - 4, $y);
        $time_2 = RC_Time::local_mktime(0, 0, 0, $m, $d + 1, $y);
        $time_3 = RC_Time::local_mktime(0, 0, 0, $m, $d, $y);
        $time_4 = RC_Time::local_mktime(0, 0, 0, $m, $d + 1, $y);
        $time_5 = RC_Time::local_mktime(0, 0, 0, $m, $d - 1, $y);
        $time_6 = RC_Time::local_mktime(0, 0, 0, $m, $d, $y);
        $time_7 = RC_Time::local_mktime(0, 0, 0, $m, $d - 2, $y);
        $time_8 = RC_Time::local_mktime(0, 0, 0, $m, $d - 1, $y);
        $time_9 = RC_Time::local_mktime(0, 0, 0, $m, $d - 4, $y);

        $where1 = $where . ' and m.send_time > ' . $time_1 . ' and m.send_time < ' . $time_2;
        $where2 = $where . ' and m.send_time > ' . $time_3 . ' and m.send_time < ' . $time_4;
        $where3 = $where . ' and m.send_time > ' . $time_5 . ' and m.send_time < ' . $time_6;
        $where4 = $where . ' and m.send_time > ' . $time_7 . ' and m.send_time < ' . $time_8;
        $where5 = $where . ' and m.send_time > 0' . ' and m.send_time < ' . $time_9;

        switch ($filter['status']) {
            case '1':
                $start_date = $time_1;
                $end_date   = $time_2;
                break;
            case '2':
                $start_date = $time_3;
                $end_date   = $time_4;
                break;
            case '3':
                $start_date = $time_5;
                $end_date   = $time_6;
                break;
            case '4':
                $start_date = $time_7;
                $end_date   = $time_8;
                break;
            case '5':
                $start_date = 0;
                $end_date   = $time_9;
                break;
        }
        $where .= ' and m.send_time > ' . $start_date . ' and m.send_time < ' . $end_date;

        $filter['last_five_days']           = count(
            RC_DB::table('wechat_custom_message as m')->leftJoin('wechat_user as wu', RC_DB::raw('wu.uid'), '=', RC_DB::raw('m.uid'))
                ->select(RC_DB::raw('max(m.id) as id'))
                ->whereRaw($where1)
                ->groupBy(RC_DB::raw('m.uid'))
                ->get()
        );
        $filter['today']                    = count(
            RC_DB::table('wechat_custom_message as m')->leftJoin('wechat_user as wu', RC_DB::raw('wu.uid'), '=', RC_DB::raw('m.uid'))
                ->select(RC_DB::raw('max(m.id) as id'))
                ->whereRaw($where2)
                ->groupBy(RC_DB::raw('m.uid'))
                ->get()
        );
        $filter['yesterday']                = count(
            RC_DB::table('wechat_custom_message as m')->leftJoin('wechat_user as wu', RC_DB::raw('wu.uid'), '=', RC_DB::raw('m.uid'))
                ->select(RC_DB::raw('max(m.id) as id'))
                ->whereRaw($where3)
                ->groupBy(RC_DB::raw('m.uid'))
                ->get()
        );
        $filter['the_day_before_yesterday'] = count(
            RC_DB::table('wechat_custom_message as m')->leftJoin('wechat_user as wu', RC_DB::raw('wu.uid'), '=', RC_DB::raw('m.uid'))
                ->select(RC_DB::raw('max(m.id) as id'))
                ->whereRaw($where4)
                ->groupBy(RC_DB::raw('m.uid'))
                ->get()
        );
        $filter['earlier']                  = count(
            RC_DB::table('wechat_custom_message as m')->leftJoin('wechat_user as wu', RC_DB::raw('wu.uid'), '=', RC_DB::raw('m.uid'))
                ->select(RC_DB::raw('max(m.id) as id'))
                ->whereRaw($where5)
                ->groupBy(RC_DB::raw('m.uid'))
                ->get()
        );

        $count = count(
            RC_DB::table('wechat_custom_message as m')->leftJoin('wechat_user as wu', RC_DB::raw('wu.uid'), '=', RC_DB::raw('m.uid'))
                ->select(RC_DB::raw('max(m.id) as id'))
                ->whereRaw($where)
                ->groupBy(RC_DB::raw('m.uid'))
                ->get()
        );
        $page  = new ecjia_platform_page($count, 10, 5);

        $list = RC_DB::table('wechat_custom_message as m')
            ->leftJoin('wechat_user as wu', RC_DB::raw('wu.uid'), '=', RC_DB::raw('m.uid'))
            ->select(RC_DB::raw('max(m.id) as id'), RC_DB::raw('wu.uid'), RC_DB::raw('wu.nickname'), RC_DB::raw('wu.headimgurl'))
            ->whereRaw($where)
            ->groupBy(RC_DB::raw('m.uid'))
            ->take(10)
            ->skip($page->start_id - 1)
            ->get();

        $row = array();
        if (!empty($list)) {
            foreach ($list as $key => $val) {
                $info                    = RC_DB::table('wechat_custom_message')->where('id', $val['id'])->first();
                $list[$key]['send_time'] = RC_Time::local_date(ecjia::config('time_format'), $info['send_time']);
                $list[$key]['msg']       = $info['msg'];
                $list[$key]['uid']       = $info['uid'];
            }
            $row = $this->array_sequence($list, 'send_time');
        }
        return array('item' => $row, 'page' => $page->show(5), 'desc' => $page->page_desc(), 'filter' => $filter);
    }

    public function get_user_info()
    {

        $wechat_id = $this->platformAccount->getAccountID();

        $uid  = !empty($_GET['uid']) ? intval($_GET['uid']) : 0;
        $info = RC_DB::table('wechat_user as u')
            ->leftJoin('users as us', RC_DB::raw('us.user_id'), '=', RC_DB::raw('u.ect_uid'))
            ->select(RC_DB::raw('u.*'), RC_DB::raw('us.user_name'))
            ->where(RC_DB::raw('u.uid'), $uid)
            ->where(RC_DB::raw('u.wechat_id'), $wechat_id)
            ->first();

        if ($info['subscribe_time']) {
            $info['subscribe_time'] = RC_Time::local_date(ecjia::config('time_format'), $info['subscribe_time'] - 8 * 3600);
            $tag_list               = RC_DB::table('wechat_user_tag')->where('userid', $info['uid'])->lists('tagid');
            $db_wechat_tag          = RC_DB::table('wechat_user_tag');
            $name_list              = [];
            if (!empty($tag_list)) {
                $name_list = $db_wechat_tag->whereIn('tag_id', $tag_list)->where('wechat_id', $wechat_id)->orderBy('tag_id', 'desc')->lists('name');
            }
            if (!empty($name_list)) {
                $info['tag_name'] = implode('，', $name_list);
            } else {
                $info['tag_name'] = __('无标签', 'wechat');
            }
        }

        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $info));
    }

    //排序
    public function array_sequence($array, $field, $sort = 'SORT_DESC')
    {
        $arrSort = array();
        foreach ($array as $uniqid => $row) {
            foreach ($row as $key => $value) {
                $arrSort[$key][$uniqid] = $value;
            }
        }
        if (!empty($array)) {
            array_multisort($arrSort[$field], constant($sort), $array);
        }
        return $array;
    }
}

//end
