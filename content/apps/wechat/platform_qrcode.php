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
 * ECJIA二维码
 */
class platform_qrcode extends ecjia_platform
{
    public function __construct()
    {
        parent::__construct();

        RC_Loader::load_app_func('global');
        Ecjia\App\Wechat\Helper::assign_adminlog_content();

        RC_Loader::load_app_class('platform_account', 'platform', false);

        /* 加载全局 js/css */
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('wechat_qrcode', RC_App::apps_url('statics/platform-js/wechat_qrcode.js', __FILE__), array(), false, true);

        RC_Script::localize_script('wechat_qrcode', 'js_lang', RC_Lang::get('wechat::wechat.js_lang'));
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.channel_code'), RC_Uri::url('wechat/platform_qrcode/init')));

        ecjia_platform_screen::get_current_screen()->set_subject('渠道二维码');
    }

    /**
     * 二维码列表
     */
    public function init()
    {
        $this->admin_priv('wechat_qrcode_manage');

        ecjia_platform_screen::get_current_screen()->remove_last_nav_here();
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.channel_code')));
        $this->assign('action_link', array('text' => RC_Lang::get('wechat::wechat.add_qr_code'), 'href' => RC_Uri::url('wechat/platform_qrcode/add')));
        $this->assign('ur_here', RC_Lang::get('wechat::wechat.channel_code_list'));

        ecjia_platform_screen::get_current_screen()->add_help_tab(array(
            'id' => 'overview',
            'title' => RC_Lang::get('wechat::wechat.overview'),
            'content' => '<p>' . RC_Lang::get('wechat::wechat.qrcode_content') . '</p>',
        ));

        ecjia_platform_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . RC_Lang::get('wechat::wechat.more_info') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:二维码管理#.E4.BA.8C.E7.BB.B4.E7.A0.81.E7.AE.A1.E7.90.86" target="_blank">' . RC_Lang::get('wechat::wechat.qrcode_help') . '</a>') . '</p>'
        );

        $wechat_id = $this->platformAccount->getAccountID();

        if (is_ecjia_error($wechat_id)) {
            $this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
        } else {
            $this->assign('warn', 'warn');

            $type = $this->platformAccount->getType();
            $this->assign('type', $type);

            $this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.notice_service_info'), RC_Lang::get('wechat::wechat.wechat_type.' . $type)));

            $listdb = $this->get_qrcodelist();
            $this->assign('listdb', $listdb);
            $this->assign('search_action', RC_Uri::url('wechat/platform_qrcode/init'));
        }

        $this->display('wechat_qrcode_list.dwt');
    }

    /**
     * 添加二维码页面
     */
    public function add()
    {
        $this->admin_priv('wechat_qrcode_add');

        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.add_qr_code')));

        $this->assign('ur_here', RC_Lang::get('wechat::wechat.add_qr_code'));
        $this->assign('action_link', array('href' => RC_Uri::url('wechat/platform_qrcode/init'), 'text' => RC_Lang::get('wechat::wechat.channel_code_list')));

        ecjia_platform_screen::get_current_screen()->add_help_tab(array(
            'id' => 'overview',
            'title' => RC_Lang::get('wechat::wechat.overview'),
            'content' => '<p>' . RC_Lang::get('wechat::wechat.qrcode_add_content') . '</p>',
        ));

        ecjia_platform_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . RC_Lang::get('wechat::wechat.more_info') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:二维码管理#.E6.B7.BB.E5.8A.A0.E4.BA.8C.E7.BB.B4.E7.A0.81" target="_blank">' . RC_Lang::get('wechat::wechat.qrcode_add_help') . '</a>') . '</p>'
        );

        $wechat_id = $this->platformAccount->getAccountID();

        if (is_ecjia_error($wechat_id)) {
            $this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
        } else {
            $this->assign('warn', 'warn');

            $type = $this->platformAccount->getType();
            $this->assign('type', $type);

            $this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.notice_service_info'), RC_Lang::get('wechat::wechat.wechat_type.' . $type)));
            $this->assign('form_action', RC_Uri::url('wechat/platform_qrcode/insert'));
        }

        $platform = $this->platformAccount->getPlatform();
        $cmd_word_list = RC_DB::table('platform_command')->where('account_id', $wechat_id)->where('platform', $platform)->lists('cmd_word');
        $rule_keywords_list = RC_DB::table('wechat_rule_keywords as wrk')
            ->leftJoin('wechat_reply as wr', RC_DB::raw('wrk.rid'), '=', RC_DB::raw('wr.id'))
            ->where(RC_DB::raw('wr.wechat_id'), $wechat_id)
            ->limit(50)
            ->orderBy(RC_DB::raw('wrk.id'), 'desc')
            ->lists(RC_DB::raw('wrk.rule_keywords'));

        $key_list = array(
            '插件关键词' => $cmd_word_list,
            '回复关键词' => $rule_keywords_list,
        );
        $this->assign('key_list', $key_list);

        $default_type = isset($_GET['type']) ? intval($_GET['type']) : 1;
        $this->assign('default_type', $default_type);

        $this->display('wechat_qrcode_edit.dwt');
    }

    /**
     * 添加二维码处理
     */
    public function insert()
    {
        $this->admin_priv('wechat_qrcode_add', ecjia::MSGTYPE_JSON);

        $wechat_id = $this->platformAccount->getAccountID();

        $type = isset($_POST['type']) ? intval($_POST['type']) : 0;
        $expire_seconds = !empty($_POST['expire_seconds']) ? intval($_POST['expire_seconds']) * 86400 : 30;
        $functions = isset($_POST['functions']) ? $_POST['functions'] : '';

        $scene_id = $_POST['scene_id'];

        $status = isset($_POST['status']) ? intval($_POST['status']) : 0;
        $sort = isset($_POST['sort']) ? intval($_POST['sort']) : 0;
        $default_type = intval($_POST['default_type']);

        if ($type == 0) {
            if (is_numeric($scene_id)) {
                if ($scene_id < 100001) {
                    return $this->showmessage('临时二维码为整型类型时场景值不能小于100001', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
                if ($scene_id > 4294967295) {
                    return $this->showmessage('临时二维码为整型类型时场景值不能大于4294967295', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            }
        }
        if ($type == 1) {
            if (is_numeric($scene_id)) {
                if ($scene_id < 1) {
                    return $this->showmessage('永久二维码为整型类型时场景值不能小于1', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
                if ($scene_id > 100000) {
                    return $this->showmessage('永久二维码为整型类型时场景值不能大于100000', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            }
        }

        if (is_string($scene_id)) {
            if (mb_strlen($scene_id) < 1) {
                return $this->showmessage('临时二维码为字符串类型时长度不能小于1', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if (mb_strlen($scene_id) > 64) {
                return $this->showmessage('临时二维码为字符串类型时长度不能大于64', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }

        $data = array(
            'wechat_id' => $wechat_id,
            'type' => $type,
            'expire_seconds' => $expire_seconds,
            'function' => $functions,
            'scene_id' => $scene_id,
            'status' => $status,
            'sort' => $sort,
        );
        RC_DB::table('wechat_qrcode')->insert($data);

        ecjia_admin::admin_log(sprintf(RC_Lang::get('wechat::wechat.function_is'), $functions), 'add', 'qrcode');
        return $this->showmessage(RC_Lang::get('wechat::wechat.add_qrcode_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/platform_qrcode/init', array('type' => $default_type))));
    }

    /**
     * 删除二维码
     */
    public function remove()
    {
        $this->admin_priv('wechat_qrcode_delete', ecjia::MSGTYPE_JSON);

        $wechat_id = $this->platformAccount->getAccountID();
        $id = intval($_GET['id']);

        $function = RC_DB::table('wechat_qrcode')->where('wechat_id', $wechat_id)->where('id', $id)->pluck('function');
        RC_DB::table('wechat_qrcode')->where('wechat_id', $wechat_id)->where('id', $id)->delete();

        ecjia_admin::admin_log(sprintf(RC_Lang::get('wechat::wechat.function_is'), $function), 'remove', 'qrcode');
        return $this->showmessage(RC_Lang::get('wechat::wechat.remove_qrcode_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/platform_qrcode/init')));
    }

    /**
     * 批量删除二维码
     */
    public function batch()
    {
        $this->admin_priv('wechat_qrcode_delete', ecjia::MSGTYPE_JSON);

        $wechat_id = $this->platformAccount->getAccountID();
        $id_list = !empty($_POST['id']) ? explode(',', $_POST['id']) : [];

        $info = RC_DB::table('wechat_qrcode')->where('wechat_id', $wechat_id)->whereIn('id', $id_list)->get();
        RC_DB::table('wechat_qrcode')->where('wechat_id', $wechat_id)->whereIn('id', $id_list)->delete();

        $default_type = isset($_GET['type']) ? intval($_GET['type']) : 1;

        foreach ($info as $v) {
            ecjia_admin::admin_log(sprintf(RC_Lang::get('wechat::wechat.function_is'), $v['function']), 'batch_remove', 'qrcode');
        }
        return $this->showmessage(RC_Lang::get('wechat::wechat.batch_operate_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/platform_qrcode/init', array('type' => $default_type))));
    }

    /**
     * 更新并获取二维码
     */
    public function qrcode_get()
    {
        $this->admin_priv('wechat_qrcode_update', ecjia::MSGTYPE_JSON);

        $uuid = $this->platformAccount->getUUID();
        $wechat_id = $this->platformAccount->getAccountID();

        $id = intval($_GET['id']);

        $qrcode = RC_DB::table('wechat_qrcode')
            ->select('type', 'scene_id', 'expire_seconds', 'qrcode_url', 'status', 'function')
            ->where('wechat_id', $wechat_id)
            ->where('id', $id)
            ->first();

        if ($qrcode['status'] == 0) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.pls_restart'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (empty($qrcode['qrcode_url'])) {
            // 获取二维码ticket
            try {
                if ($qrcode['type'] == 0) {
                    $ticket = with(new Ecjia\App\Wechat\WechatQrcode())->temporary($qrcode['scene_id']);
                } else {
                    $ticket = with(new Ecjia\App\Wechat\WechatQrcode())->forever($qrcode['scene_id']);
                }
            } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
                return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $data['ticket'] = $ticket['ticket'];
            $data['expire_seconds'] = $ticket['expire_seconds'];
            if ($qrcode['type'] == 0) {
                $data['endtime'] = RC_Time::gmtime() + $ticket['expire_seconds'];
            }
            // 二维码地址
            $data['qrcode_url'] = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $data['ticket'];
            RC_DB::table('wechat_qrcode')->where('wechat_id', $wechat_id)->where('id', $id)->update($data);

            $qrcode_url = $data['qrcode_url'];

        } else {
            $qrcode_url = $qrcode['qrcode_url'];
        }
        ecjia_admin::admin_log(sprintf(RC_Lang::get('wechat::wechat.function_is'), $qrcode['function']), 'setup', 'qrcode');
        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $qrcode_url));
    }

    /**
     * 切换状态
     */
    public function toggle_show()
    {
        $this->admin_priv('wechat_qrcode_update', ecjia::MSGTYPE_JSON);

        $wechat_id = $this->platformAccount->getAccountID();
        $id = intval($_POST['id']);
        $val = intval($_POST['val']);

        $function = RC_DB::table('wechat_qrcode')->where('wechat_id', $wechat_id)->where('id', $id)->pluck('function');
        RC_DB::table('wechat_qrcode')->where('wechat_id', $wechat_id)->where('id', $id)->update(array('status' => $val));

        if ($val == 1) {
            ecjia_admin::admin_log(sprintf(RC_Lang::get('wechat::wechat.open_function_is'), $function), 'setup', 'qrcode');
        } else {
            ecjia_admin::admin_log(sprintf(RC_Lang::get('wechat::wechat.close_function_is'), $function), 'setup', 'qrcode');
        }
        return $this->showmessage(RC_Lang::get('wechat::wechat.edit_status_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/platform_qrcode/init')));
    }

    /**
     * 手动排序
     */
    public function edit_sort()
    {
        $this->admin_priv('wechat_qrcode_update', ecjia::MSGTYPE_JSON);

        $wechat_id = $this->platformAccount->getAccountID();
        $id = intval($_POST['pk']);
        $sort = trim($_POST['value']);
        $function = RC_DB::table('wechat_qrcode')->where('wechat_id', $wechat_id)->where('id', $id)->pluck('function');

        if (!empty($sort)) {
            if (!is_numeric($sort)) {
                return $this->showmessage(RC_Lang::get('wechat::wechat.qrcode_sort_numeric'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            } else {
                RC_DB::table('wechat_qrcode')->where('wechat_id', $wechat_id)->where('id', $id)->update(array('sort' => $sort));
                ecjia_admin::admin_log(sprintf(RC_Lang::get('wechat::wechat.function_is'), $function), 'edit', 'qrcode');
                return $this->showmessage(RC_Lang::get('wechat::wechat.edit_sort_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_uri::url('wechat/platform_qrcode/init')));
            }
        } else {
            return $this->showmessage(RC_Lang::get('wechat::wechat.qrcode_sort_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 取得二维码信息
     */
    private function get_qrcodelist()
    {

        $wechat_id = $this->platformAccount->getAccountID();

        $db = RC_DB::table('wechat_qrcode')->where('wechat_id', $wechat_id)->where('username', null);

        $filter = array();
        $filter['keywords'] = empty($_GET['keywords']) ? '' : trim($_GET['keywords']);
        $filter['type'] = isset($_GET['type']) ? intval($_GET['type']) : 1;

        if ($filter['keywords']) {
            $db->where('function', 'like', '%' . mysql_like_quote($filter['keywords']) . '%');
        }
        $type_count = $db->select(
            RC_DB::raw('SUM(IF(type = 1, 1, 0)) as forever'),
            RC_DB::raw('SUM(IF(type = 0, 1, 0)) as temporary'))->first();
        if (empty($type_count['forever'])) {
            $type_count['forever'] = 0;
        }
        if (empty($type_count['temporary'])) {
            $type_count['temporary'] = 0;
        }

        if ($filter['type']) {
            $db->where('type', $filter['type']);
        }

        $count = $db->select('*')->count();
        $page = new ecjia_platform_page($count, 10, 5);

        $arr = array();
        $data = $db->orderBy('sort', 'asc')->take(10)->skip($page->start_id - 1)->get();

        return array('qrcode_list' => $data, 'filter' => $filter, 'page' => $page->show(5), 'desc' => $page->page_desc(), 'count' => $type_count);
    }
}

//end
