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
 * 公众平台命令速查
 */
class platform_command extends ecjia_platform
{
    public function __construct()
    {
        parent::__construct();

        Ecjia\App\Platform\Helper::assign_adminlog_content();

        /* 加载全局 js/css */
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');

        RC_Script::enqueue_script('platform', RC_App::apps_url('statics/platform-js/platform.js', __FILE__), array(), false, true);
        RC_Script::localize_script('platform', 'js_lang', config('app-platform::jslang.platform_command_page'));

        RC_Style::enqueue_style('wechat_extend', RC_App::apps_url('statics/css/wechat_extend.css', __FILE__));

        ecjia_platform_screen::get_current_screen()->set_subject(__('关键词命令', 'platform'));
    }

    /**
     * 查看公众号扩展下的命令
     */
    public function init()
    {
        $this->admin_priv('platform_command_manage');

        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('关键词命令', 'platform')));
        $this->assign('ur_here', __('关键词命令', 'platform'));

        $account_id = $this->platformAccount->getAccountID();

        $this->assign('ur_here', __('关键词列表', 'platform'));
        $this->assign('search_action', RC_Uri::url('platform/platform_command/init'));
        $this->assign('action_link', array('text' => __('添加关键词', 'platform'), 'href' => RC_Uri::url('platform/platform_command/add')));

        $modules = $this->get_command_list();
        $this->assign('modules', $modules);

        $this->display('wechat_extend_command.dwt');
    }

    public function add()
    {
        $this->admin_priv('platform_command_add');

        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('关键词命令', 'platform'), RC_Uri::url('platform/platform_command/init')));
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('添加关键词', 'platform')));

        $this->assign('ur_here', __('添加关键词', 'platform'));
        $this->assign('action_link', array('text' => __('关键词列表', 'platform'), 'href' => RC_Uri::url('platform/platform_command/init')));
        $this->assign('form_action', RC_Uri::url('platform/platform_command/insert'));

        $account_id = $this->platformAccount->getAccountID();
        $platform   = $this->platformAccount->getPlatform();

        $arr       = [];
        $code_list = RC_DB::table('platform_command')->where('account_id', $account_id)->where('platform', $platform)->select(RC_DB::raw('distinct ext_code'))->get();
        if (!empty($code_list)) {
            foreach ($code_list as $key => $value) {
                $arr[] = $value['ext_code'];
            }
        }

        $platform_extend = RC_DB::table('platform_config')->where('account_id', $account_id)->lists('ext_code');

        $extend_list = RC_DB::table('platform_extend')->where('enabled', 1)->get();
        if (!empty($extend_list)) {
            foreach ($extend_list as $key => $value) {
                if (in_array($value['ext_code'], $arr) || !in_array($value['ext_code'], $platform_extend)) {
                    unset($extend_list[$key]);
                }
            }
        }
        $this->assign('extend_list', $extend_list);

        $account_id = $this->platformAccount->getAccountID();
        $platform   = $this->platformAccount->getPlatform();

        $this->display('wechat_command_add.dwt');
    }

    /**
     * 添加公众号扩展下的命令
     */
    public function insert()
    {
        $this->admin_priv('platform_command_add', ecjia::MSGTYPE_JSON);

        $code = !empty($_POST['ext_code']) ? trim($_POST['ext_code']) : '';
        if (empty($code)) {
            return $this->showmessage(__('请选择插件', 'platform'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $account_id = $this->platformAccount->getAccountID();
        $platform   = $this->platformAccount->getPlatform();

        $val = [];
        if (!empty($_POST['cmd_word'])) {
            foreach ($_POST['cmd_word'] as $key => $value) {
                if (empty($value)) {
                    return $this->showmessage(__('关键词不能为空！', 'platform'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
                //判断关键词是否重复
                $count = RC_DB::table('platform_command')->where('account_id', $account_id)->where('cmd_word', $value)->count();
                if ($count != 0) {
                    return $this->showmessage(sprintf(__('关键词[%s]已存在', 'platform'), $value), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
                $val[] = $value;
            }
        }

        $count = array_count_values($val);
        foreach ($count as $c) {
            if ($c > 1) {
                return $this->showmessage(__('关键词不能重复！', 'platform'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }

        $code_count = RC_DB::table('platform_command')->where('account_id', $account_id)->where('platform', $platform)->where('ext_code', $code)->count();
        if ($code_count > 0) {
            return $this->showmessage(__('该插件已存在', 'platform'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $data = [];
        foreach ($val as $k => $v) {
            $data[$k]['cmd_word']   = $v;
            $data[$k]['account_id'] = $account_id;
            $data[$k]['platform']   = $platform;
            $data[$k]['ext_code']   = $code;
            $data[$k]['sub_code']   = !empty($_POST['sub_code'][$k]) ? $_POST['sub_code'][$k] : '';
        }
        RC_DB::table('platform_command')->insert($data);

        $ext_name = RC_DB::table('platform_extend')->where('ext_code', $code)->pluck('ext_name');

        foreach ($data as $v) {
            $this->admin_log(sprintf(__('扩展名称为 %s，' . '关键词为 %s', 'platform'), $ext_name, $v['cmd_word']), 'add', 'keyword');
        }
        return $this->showmessage(__('添加成功', 'platform'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('platform/platform_command/edit', array('ext_code' => $code))));
    }

    /**
     * 编辑
     */
    public function edit()
    {
        $this->admin_priv('platform_command_update');

        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('关键词命令', 'platform'), RC_Uri::url('platform/platform_command/init')));
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑关键词', 'platform')));

        $this->assign('ur_here', __('编辑关键词', 'platform'));
        $this->assign('action_link', array('text' => __('关键词列表', 'platform'), 'href' => RC_Uri::url('platform/platform_command/init')));
        $this->assign('form_action', RC_Uri::url('platform/platform_command/update'));

        $extend_list = RC_DB::table('platform_extend')->where('enabled', 1)->get();
        $this->assign('extend_list', $extend_list);

        $account_id = $this->platformAccount->getAccountID();
        $platform   = $this->platformAccount->getPlatform();

        $ext_code = trim($_GET['ext_code']);
        $this->assign('ext_code', $ext_code);

        $handler  = with(new Ecjia\App\Platform\Plugin\PlatformPlugin)->channel($ext_code);
        $sub_code = $handler->getSubCode();
        $this->assign('sub_code', $sub_code);

        $data = RC_DB::table('platform_command')->where('account_id', $account_id)->where('platform', $platform)->where('ext_code', $ext_code)->get();
        $this->assign('data', $data);

        $this->display('wechat_command_add.dwt');
    }

    /**
     * 添加公众号扩展下的命令
     */
    public function update()
    {
        $this->admin_priv('platform_command_update', ecjia::MSGTYPE_JSON);

        $code = !empty($_POST['ext_code']) ? trim($_POST['ext_code']) : '';

        $account_id = $this->platformAccount->getAccountID();
        $platform   = $this->platformAccount->getPlatform();
        $cmd_word   = $_POST['cmd_word'];

        $val = [];
        if (!empty($cmd_word)) {
            foreach ($cmd_word as $key => $value) {
                if (empty($value)) {
                    return $this->showmessage(__('关键词不能为空！', 'platform'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
                //判断关键词是否重复
                $count = RC_DB::table('platform_command')->where('account_id', $account_id)->where('cmd_word', $value)->count();
                if ($count != 0) {
                    return $this->showmessage(sprintf(__('关键词[%s]已存在', 'platform'), $value), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
                $val[] = $value;
            }
        }

        $count = array_count_values($val);
        foreach ($count as $c) {
            if ($c > 1) {
                return $this->showmessage(__('关键词不能重复！', 'platform'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }

        if (empty($code)) {
            return $this->showmessage(__('请选择插件', 'platform'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $data = [];
        foreach ($val as $k => $v) {
            $data[$k]['cmd_word']   = $v;
            $data[$k]['account_id'] = $account_id;
            $data[$k]['platform']   = $platform;
            $data[$k]['ext_code']   = $code;
            $data[$k]['sub_code']   = !empty($_POST['sub_code'][$k]) ? $_POST['sub_code'][$k] : '';
        }
        RC_DB::table('platform_command')->insert($data);

        $ext_name = RC_DB::table('platform_extend')->where('ext_code', $code)->pluck('ext_name');

        foreach ($data as $v) {
            $this->admin_log(sprintf(__('扩展名称为 %s，' . '关键词为 %s', 'platform'), $ext_name, $v['cmd_word']), 'edit', 'keyword');
        }
        return $this->showmessage(__('编辑成功', 'platform'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('platform/platform_command/edit', array('ext_code' => $code))));
    }

    /**
     * 删除公众号扩展下的命令
     */
    public function remove()
    {
        $this->admin_priv('platform_command_delete', ecjia::MSGTYPE_JSON);

        $ext_code = trim($_GET['ext_code']);
        $cmd_id   = intval($_GET['cmd_id']);

        $account_id = $this->platformAccount->getAccountID();
        $platform   = $this->platformAccount->getPlatform();

        $db = RC_DB::table('platform_command')->where('platform', $platform);

        if (!empty($ext_code)) {
            $db->where('ext_code', $ext_code);
        }
        if (!empty($cmd_id)) {
            $db->where('cmd_id', $cmd_id);
        }
        $db->where('account_id', $account_id)->delete();

        return $this->showmessage(__('删除成功', 'platform'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    public function get_sub_code()
    {
        $ext_code = trim($_POST['ext_code']);
        $handler  = with(new Ecjia\App\Platform\Plugin\PlatformPlugin)->channel($ext_code);
        $sub_code = $handler->getSubCode();

        $this->assign('sub_code', $sub_code);

        $lbi = $this->fetch('library/sub_code.lbi');
        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('data' => $sub_code, 'lbi' => $lbi));
    }

    /**
     * 扩展下的命令列表
     */
    private function get_command_list()
    {
        $db_command_view = RC_DB::table('platform_command as c')
            ->leftJoin('platform_extend as e', RC_DB::raw('e.ext_code'), '=', RC_DB::raw('c.ext_code'));

        $type     = !empty($_GET['platform']) ? $_GET['platform'] : '';
        $keywords = empty($_GET['keywords']) ? '' : trim($_GET['keywords']);

        if (!empty($type)) {
            $db_command_view->where(RC_DB::raw('c.platform'), $type);
        }
        if ($keywords) {
            $db_command_view->where(RC_DB::raw('c.cmd_word'), 'like', '%' . $keywords . '%');
        }
        $account_id = $this->platformAccount->getAccountID();

        $count = $db_command_view->where(RC_DB::raw('c.account_id'), $account_id)->groupBy(RC_DB::raw('c.ext_code'))->count();
        $page  = new ecjia_platform_page($count, 15, 5);

        $data = $db_command_view->select(RC_DB::raw('c.ext_code'), RC_DB::raw('e.ext_name'))->groupBy(RC_DB::raw('c.ext_code'))->orderBy(RC_DB::raw('c.cmd_id'), 'asc')->take(15)->skip($page->start_id - 1)->get();

        if (!empty($data)) {
            foreach ($data as $k => $v) {
                $cmd_list                = RC_DB::table('platform_command')->where('account_id', $account_id)->where('ext_code', $v['ext_code'])->orderBy('cmd_id', 'asc')->get();
                $data[$k]['cmd_list']    = $cmd_list;
                $data[$k]['has_subcode'] = 0;
                if (!empty($cmd_list)) {
                    foreach ($cmd_list as $key => $val) {
                        if (!empty($val['sub_code'])) {
                            $data[$k]['has_subcode'] = 1;
                        }
                    }
                }
            }
        }
        return array('module' => $data, 'page' => $page->show(5), 'desc' => $page->page_desc());
    }
}

//end
