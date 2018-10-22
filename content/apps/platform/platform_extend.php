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
 * ECJIA平台、公众号配置
 */
class platform_extend extends ecjia_platform
{
    public function __construct()
    {
        parent::__construct();

        Ecjia\App\Platform\Helper::assign_adminlog_content();

        /* 加载全局 js/css */
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('bootstrap-placeholder');

        RC_Script::enqueue_script('platform', RC_App::apps_url('statics/platform-js/platform.js', __FILE__), array(), false, true);
        RC_Style::enqueue_style('wechat_extend', RC_App::apps_url('statics/platform-css/platform_extend.css', __FILE__));

        RC_Script::localize_script('platform', 'js_lang', RC_Lang::get('platform::platform.js_lang'));
        RC_Style::enqueue_style('wechat_extend', RC_App::apps_url('statics/css/wechat_extend.css', __FILE__));

        ecjia_platform_screen::get_current_screen()->set_subject('插件管理');
    }

    /**
     * 查看公众号扩展
     */
    public function init()
    {
        $this->admin_priv('platform_extend_manage');

        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here('插件管理'));
        $this->assign('ur_here', '插件库');

        ecjia_platform_screen::get_current_screen()->add_help_tab(array(
            'id' => 'overview',
            'title' => RC_Lang::get('platform::platform.summarize'),
            'content' =>
            '<p>' . RC_Lang::get('platform::platform.welcome_pub_extend') . '</p>',
        ));

        ecjia_platform_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . RC_Lang::get('platform::platform.more_info') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:公众号扩展#.E5.85.AC.E4.BC.97.E5.8F.B7.E6.89.A9.E5.B1.95" target="_blank">' . RC_Lang::get('platform::platform.pub_extend_help') . '</a>') . '</p>'
        );

        $this->assign('form_action', RC_Uri::url('platform/platform_extend/wechat_extend_insert'));

        $id = $this->platformAccount->getAccountID();

        $ext_code_list = RC_DB::table('platform_config')->where('account_id', $id)->lists('ext_code');

        $plugins = with(new Ecjia\App\Platform\Plugin\PluginManager($this->platformAccount))->getEnabledPlugins(function($extend_handle, $plugin) use ($ext_code_list) {
            if (!empty($ext_code_list) && in_array($plugin['ext_code'], $ext_code_list)) {
                $plugin['added'] = 1;
            } else {
                $plugin['added'] = 0;
            }
            $plugin['icon'] = $extend_handle->getPluginIconUrl();

            return $plugin;
        });
        
        $this->assign('arr', $plugins);

        $this->assign('img_url', RC_App::apps_url('statics/image/', __FILE__));

        $this->assign_lang();
        $this->display('wechat_extend.dwt');
    }

    /**
     * 公众号扩展插入
     */
    public function wechat_extend_insert()
    {
        $this->admin_priv('platform_extend_add', ecjia::MSGTYPE_JSON);

        $wechat_id = $this->platformAccount->getAccountID();
        $platform = $this->platformAccount->getPlatform();

        $code = trim($_POST['code']);
        $info = RC_DB::table('platform_extend')->where('ext_code', $code)->where('enabled', 1)->first();

        $data = array(
            'ext_code' => $code,
            'account_id' => $wechat_id,
            'ext_config' => $info['ext_config'],
        );
        RC_DB::table('platform_config')->insert($data);

        //添加该插件的默认命令
        $extend_handle = with(new Ecjia\App\Platform\Plugin\PlatformPlugin)->channel($code);
        $default_commands = $extend_handle->getDefaultCommands();

        $cmd_word = '';
        if (!empty($default_commands)) {
            $arr = [];
            foreach ($default_commands as $k => $v) {
                //查询关键词是否存在
                $count = RC_DB::table('platform_command')->where('account_id', $wechat_id)->where('cmd_word', $v)->count();
                if ($count == 0) {
                    $arr['cmd_word'] = $v;
                    $arr['account_id'] = $wechat_id;
                    $arr['platform'] = $platform;
                    $arr['ext_code'] = $code;
                    $arr['sub_code'] = '';
                    RC_DB::table('platform_command')->insert($arr);
                } else {
                    if (empty($cmd_word)) {
                        $cmd_word = $v;
                    } else {
                        $cmd_word .= '、'.$v;
                    }
                }
            }
        }
        $this->admin_log(RC_Lang::get('platform::platform.extend_name_is') . $info['ext_name'] . '，' . RC_Lang::get('platform::platform.public_name_is') . $info['name'], 'add', 'wechat_extend');

        if (empty($cmd_word)) {
            $message = '开通成功';
        } else {
            $message = '开通成功，关键词 '.$cmd_word.' 已存在，无法添加。';
        }
        return $this->showmessage($message, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('platform/platform_extend/wechat_extend_view', array('code' => $code))));
    }

    /**
     * 编辑扩展功能页面
     */
    public function wechat_extend_view()
    {
        $this->admin_priv('platform_extend_update');

        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here('功能详情'));

        $id = $this->platformAccount->getAccountID();

        $this->assign('action_link', array('text' => '插件库', 'href' => RC_Uri::url('platform/platform_extend/init')));
        $this->assign('form_action', RC_Uri::url('platform/platform_extend/wechat_extend_save'));
        $this->assign('ur_here', '功能详情');

        $code = !empty($_GET['code']) ? trim($_GET['code']) : '';
        $name = $this->platformAccount->getAccountName();

        $info = RC_DB::table('platform_extend')->where('ext_code', $code)->where('enabled', 1)->first();
        if (empty($info)) {
            return $this->showmessage('该扩展不存在或未启用', ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => '返回插件库', 'href' => RC_Uri::url('platform/platform_extend/init')))));
        }
        $extend_handle = with(new Ecjia\App\Platform\Plugin\PlatformPlugin)->channel($code);
        $info['icon'] = $extend_handle->getPluginIconUrl();
        $this->assign('info', $info);

        $bd = RC_DB::table('platform_config')->where('ext_code', $code)->where('account_id', $id)->first();
        if (!empty($bd)) {
            /* 取得配置信息 */
            if (is_string($bd['ext_config'])) {
                $ext_config = unserialize($bd['ext_config']);
                /* 取出已经设置属性的code */
                $code_list = array();
                if (!empty($ext_config)) {
                    foreach ($ext_config as $key => $value) {
                        $code_list[$value['name']] = $value['value'];
                    }
                }
                $bd['ext_config'] = $extend_handle->makeFormData($code_list);
            }
        }
        $default_commands = $extend_handle->getDefaultCommands();
        $this->assign('default_commands', $default_commands);

        $sub_codes = $extend_handle->getSubCode();
        $this->assign('sub_codes', $sub_codes);

        $this->assign('bd', $bd);
        $this->assign('images_url', RC_App::apps_url('statics/image/', __FILE__));

        $this->assign_lang();
        $this->display('wechat_extend_view.dwt');
    }

    /**
     * 编辑扩展功能处理
     */
    public function wechat_extend_save()
    {
        $this->admin_priv('platform_extend_update', ecjia::MSGTYPE_JSON);

        $account_id = $this->platformAccount->getAccountID();
        $ext_code = !empty($_POST['ext_code']) ? trim($_POST['ext_code']) : '';

        /* 取得配置信息 */
        $ext_config = array();
        if (isset($_POST['cfg_value']) && is_array($_POST['cfg_value'])) {
            for ($i = 0; $i < count($_POST['cfg_value']); $i++) {
                $ext_config[] = array(
                    'name' => trim($_POST['cfg_name'][$i]),
                    'type' => trim($_POST['cfg_type'][$i]),
                    'value' => trim($_POST['cfg_value'][$i]),
                );
            }
        }
        $data['ext_config'] = serialize($ext_config);
        RC_DB::table('platform_config')->where('ext_code', $ext_code)->where('account_id', $account_id)->update($data);

        $info = RC_DB::table('platform_config as c')
            ->leftJoin('platform_extend as e', RC_DB::raw('e.ext_code'), '=', RC_DB::raw('c.ext_code'))
            ->leftJoin('platform_account as a', RC_DB::raw('a.id'), '=', RC_DB::raw('c.account_id'))
            ->select(RC_DB::raw('a.name'), RC_DB::raw('e.ext_name'))
            ->where(RC_DB::raw('c.account_id'), $id)
            ->first();

        $this->admin_log(RC_Lang::get('platform::platform.extend_name_is') . $info['ext_name'] . '，' . RC_Lang::get('platform::platform.public_name_is') . $info['name'], 'edit', 'wechat_extend');

        return $this->showmessage(RC_Lang::get('platform::platform.edit_pub_extend_succeed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('platform/platform_extend/wechat_extend_view', array('code' => $ext_code))));
    }

    /**
     * 删除公众号扩展
     */
    public function wechat_extend_remove()
    {
        $this->admin_priv('platform_extend_delete', ecjia::MSGTYPE_JSON);

        $id = $this->platformAccount->getAccountID();
        $ext_code = !empty($_POST['code']) ? trim($_POST['code']) : '';

        $info = RC_DB::table('platform_config as c')
            ->leftJoin('platform_extend as e', RC_DB::raw('e.ext_code'), '=', RC_DB::raw('c.ext_code'))
            ->leftJoin('platform_account as a', RC_DB::raw('a.id'), '=', RC_DB::raw('c.account_id'))
            ->select(RC_DB::raw('a.name'), RC_DB::raw('e.ext_name'))
            ->where(RC_DB::raw('c.account_id'), $id)
            ->first();

        RC_DB::table('platform_config')->where('account_id', $id)->where('ext_code', $ext_code)->delete();

        //删除公众号扩展下的命令
        RC_DB::table('platform_command')->where('account_id', $id)->where('ext_code', $ext_code)->delete();

        $this->admin_log(RC_Lang::get('platform::platform.extend_name_is') . $info['ext_name'] . '，' . RC_Lang::get('platform::platform.public_name_is') . $info['name'], 'remove', 'wechat_extend');
        return $this->showmessage('关闭成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('platform/platform_extend/wechat_extend_view', array('code' => $ext_code))));
    }

    /**
     * 批量删除
     */
    public function batch_remove()
    {
        $this->admin_priv('platform_extend_delete', ecjia::MSGTYPE_JSON);

        $idArr = explode(',', $_POST['id']);
        $count = count($idArr);

        $info = RC_DB::table('platform_account')->whereIn('id', $idArr)->select('name')->get();
        foreach ($info as $v) {
            $this->admin_log($v['name'], 'batch_remove', 'wechat');
        }
        RC_DB::table('platform_account')->whereIn('id', $idArr)->delete();
        return $this->showmessage(RC_Lang::get('platform::platform.deleted') . "[ " . $count . " ]" . RC_Lang::get('platform::platform.record_account'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('platform/platform_extend/init')));
    }

    /**
     * 生成token
     */
    public function generate_token()
    {
        $key = rc_random(16, 'abcdefghijklmnopqrstuvwxyz0123456789');
        $key = 'ecjia' . $key;
        return $this->showmessage('生成token成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('token' => $key));
    }

    /**
     * 公众号列表
     */
    private function wechat_list()
    {
        $db_platform_account = RC_DB::table('platform_account');

        $filter = array();
        $filter['keywords'] = empty($_GET['keywords']) ? '' : trim($_GET['keywords']);

        $where = '';
        if ($filter['keywords']) {
            $db_platform_account->where('name', 'like', '%" . mysql_like_quote("' . $filter['keywords'] . '") . "%');
        }
        $db_platform_account->where('platform', '!=', 'weapp');

        $platform = !empty($_GET['platform']) ? $_GET['platform'] : '';
        if (!empty($platform)) {
            $db_platform_account->where('platform', $platform);
        }

        $count = $db_platform_account->count();
        $filter['record_count'] = $count;
        $page = new ecjia_platform_page($count, 10, 5);

        $arr = array();
        $data = $db_platform_account->orderBy('sort', 'asc')->orderBy('add_time', 'desc')->take(10)->skip($page->start_id - 1)->get();
        if (isset($data)) {
            foreach ($data as $rows) {
                $rows['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $rows['add_time']);
                if (empty($rows['logo'])) {
                    $rows['logo'] = RC_Uri::admin_url('statics/images/nopic.png');
                } else {
                    $rows['logo'] = RC_Upload::upload_url($rows['logo']);
                }
                $arr[] = $rows;
            }
        }
        return array('item' => $arr, 'filter' => $filter, 'page' => $page->show(5), 'desc' => $page->page_desc());
    }

    /**
     * 获取扩展列表
     */
    public function get_extend_list()
    {
        $id = $this->platformAccount->getAccountID();
        $keywords = trim($_GET['JSON']['keywords']);

        $db_platform_extend = RC_DB::table('platform_extend');
        if ($keywords) {
            $db_platform_extend->where('ext_name', 'like', '%" .$keywords. "%')->orWhere('ext_code', 'like', '%" .$keywords. "%');

        }
        //已禁用的扩展搜索不显示
        $db_platform_extend->where('enabled', '!=', 0);

        //查找已关联的扩展
        $ext_code_list = RC_DB::table('platform_config')->where('account_id', $id)->lists('ext_code');
        $platform_list = $db_platform_extend->select('ext_id', 'ext_name', 'ext_code', 'ext_config')->orderBy('ext_id', 'desc')->get();

        if ($ext_code_list) {
            if (!empty($platform_list)) {
                foreach ($platform_list as $k => $v) {
                    if (in_array($v['ext_code'], $ext_code_list)) {
                        unset($platform_list[$k]);
                    }
                }
            }
        }

        $opt = array();
        if (!empty($platform_list)) {
            foreach ($platform_list as $key => $val) {
                $opt[] = array(
                    'ext_id' => $val['ext_id'],
                    'ext_name' => $val['ext_name'],
                    'ext_code' => $val['ext_code'],
                    'ext_config' => $val['ext_config'],
                );
            }
        }
        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $opt));
    }
}

//end
