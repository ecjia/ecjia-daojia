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
 * ECJIA自定义菜单
 */
class platform_menus extends ecjia_platform
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
        RC_Script::enqueue_script('wechat_menus', RC_App::apps_url('statics/platform-js/wechat_menus.js', __FILE__), array(), false, true);
        RC_Style::enqueue_style('menu', RC_App::apps_url('statics/platform-css/wechat_menu.css', __FILE__));

        RC_Script::localize_script('wechat_menus', 'js_lang', RC_Lang::get('wechat::wechat.js_lang'));
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.wechat_menu'), RC_Uri::url('wechat/platform_menus/init')));

        ecjia_platform_screen::get_current_screen()->set_subject('微信菜单');
    }

    public function init()
    {
        $this->admin_priv('wechat_menus_manage');

        ecjia_platform_screen::get_current_screen()->remove_last_nav_here();
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.wechat_menu')));
        $this->assign('ur_here', RC_Lang::get('wechat::wechat.wechat_menu_list'));
        $this->assign('action_link', array('text' => RC_Lang::get('wechat::wechat.add_wechat_menu'), 'href' => RC_Uri::url('wechat/platform_menus/add')));

        ecjia_platform_screen::get_current_screen()->add_help_tab(array(
            'id' => 'overview',
            'title' => RC_Lang::get('wechat::wechat.overview'),
            'content' => '<p>' . RC_Lang::get('wechat::wechat.wechat_menu_content') . '</p>',
        ));

        ecjia_platform_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . RC_Lang::get('wechat::wechat.more_info') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:自定义菜单#.E8.87.AA.E5.AE.9A.E4.B9.89.E8.8F.9C.E5.8D.95" target="_blank">' . RC_Lang::get('wechat::wechat.wechat_menu_help') . '</a>') . '</p>'
        );

        $wechat_id = $this->platformAccount->getAccountID();

        if (is_ecjia_error($wechat_id)) {
            $this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
        } else {
            $this->assign('warn', 'warn');

            $type = $this->platformAccount->getType();
            $this->assign('type', $type);
            $this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.notice_subscribe_nonsupport'), RC_Lang::get('wechat::wechat.wechat_type.' . $type)));

            $listdb = $this->get_menuslist();
            $this->assign('menu_list', $listdb['menu_list']);

            $count = count($listdb['menu_list']);
            $this->assign('count', $count);
        }
        $this->assign('form_action', RC_Uri::url('wechat/platform_menus/insert'));
        $this->assign('edit_url', RC_Uri::url('wechat/platform_menus/get_menu_info'));
        $this->assign('del_url', RC_Uri::url('wechat/platform_menus/remove'));
        $this->assign('check_url', RC_Uri::url('wechat/platform_menus/check'));

        $this->display('wechat_menus_list.dwt');
    }

    /**
     * 添加菜单页面
     */
    public function add()
    {
        $this->admin_priv('wechat_menus_add');

        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.add_wechat_menu')));
        $this->assign('ur_here', RC_Lang::get('wechat::wechat.add_wechat_menu'));
        $this->assign('action_link', array('href' => RC_Uri::url('wechat/platform_menus/init'), 'text' => RC_Lang::get('wechat::wechat.wechat_menu_list')));

        ecjia_platform_screen::get_current_screen()->add_help_tab(array(
            'id' => 'overview',
            'title' => RC_Lang::get('wechat::wechat.overview'),
            'content' => '<p>' . RC_Lang::get('wechat::wechat.wechat_menu_add_content') . '</p>',
        ));

        ecjia_platform_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . RC_Lang::get('wechat::wechat.more_info') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:自定义菜单#.E6.B7.BB.E5.8A.A0.E5.BE.AE.E4.BF.A1.E8.8F.9C.E5.8D.95" target="_blank">' . RC_Lang::get('wechat::wechat.wechat_menu_add_help') . '</a>') . '</p>'
        );

        $wechat_id = $this->platformAccount->getAccountID();

        if (is_ecjia_error($wechat_id)) {
            $this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
        } else {
            $this->assign('warn', 'warn');
            $type = $this->platformAccount->getType();
            $this->assign('type', $type);
            $this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.notice_subscribe_nonsupport'), RC_Lang::get('wechat::wechat.wechat_type.' . $type)));

            $pmenu = RC_DB::table('wechat_menu')->where('pid', 0)->where('wechat_id', $wechat_id)->get();
            $this->assign('pmenu', $pmenu);

            $wechatmenus['type'] = 'click';
            $wechatmenus['status'] = 1;
            $this->assign('wechatmenus', $wechatmenus);

            $weapplist = $this->get_weapplist();
            $this->assign('weapplist', $weapplist);

            $this->assign('form_action', RC_Uri::url('wechat/platform_menus/insert'));
        }

        $this->display('wechat_menus_edit.dwt');
    }

    /**
     * 添加菜单处理
     */
    public function insert()
    {
        $this->admin_priv('wechat_menus_add', ecjia::MSGTYPE_JSON);

        $wechat_id = $this->platformAccount->getAccountID();

        $pid = !empty($_POST['pid']) ? intval($_POST['pid']) : 0;
        $name = !empty($_POST['name']) ? trim($_POST['name']) : !empty($pid) ? '子菜单名称' : '菜单名称';

        $type = !empty($_POST['type']) ? $_POST['type'] : 'click';
        $key = !empty($_POST['key']) ? $_POST['key'] : '';
        $web_url = !empty($_POST['url']) ? $_POST['url'] : '';

        $status = !empty($_POST['status']) ? intval($_POST['status']) : 1;
        $sort = !empty($_POST['sort']) ? intval($_POST['sort']) : 0;

        if ($type == 'view') {
            if (!empty($web_url)) {
                $url = $web_url;
            }
        } else {
            //小程序配置信息
            $h5_url = RC_Uri::home_url() . '/sites/m/';
            $weapp_appid = $_POST['weapp_appid'];
            if (!empty($weapp_appid)) {
                $miniprogram_config = array(
                    'url' => $h5_url,
                    'appid' => $weapp_appid,
                    'pagepath' => 'pages/ecjia-store/ecjia',
                );
                $url = serialize($miniprogram_config);
            }
        }

        $data = array(
            'wechat_id' => $wechat_id,
            'pid' => $pid,
            'name' => $name,
            'type' => $type,
            'key' => $key,
            'url' => $url,
            'status' => $status,
            'sort' => $sort,
        );
        $id = RC_DB::table('wechat_menu')->insertGetId($data);
        ecjia_admin::admin_log($_POST['name'], 'add', 'menu');

        if (!empty($pid)) {
            RC_DB::table('wechat_menu')->where('wechat_id', $wechat_id)->where('id', $pid)->update(array('type' => '', 'key' => '', 'url' => ''));
        }

        $listdb = $this->get_menuslist();
        $this->assign('menu_list', $listdb['menu_list']);

        $count = count($listdb['menu_list']);
        $this->assign('count', $count);

        $this->assign('id', $id);
        $this->assign('pid', $pid);

        $res = $this->fetch('library/wechat_menu_menu.lbi');

        if ($type == 'miniprogram') {
            $config_url = unserialize($data['url']);
            $data['app_id'] = $config_url['appid'];
        }
        $this->assign('wechat_menus', $data);

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

        $result = $this->fetch('library/wechat_menu_sub.lbi');
        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('data' => $res, 'result' => $result));
    }

    /**
     * 编辑菜单页面
     */
    public function edit()
    {
        $this->admin_priv('wechat_menus_update');

        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.edit_wechat_menu')));
        $this->assign('ur_here', RC_Lang::get('wechat::wechat.edit_wechat_menu'));
        $this->assign('action_link', array('href' => RC_Uri::url('wechat/platform_menus/init'), 'text' => RC_Lang::get('wechat::wechat.wechat_menu_list')));

        ecjia_platform_screen::get_current_screen()->add_help_tab(array(
            'id' => 'overview',
            'title' => RC_Lang::get('wechat::wechat.overview'),
            'content' => '<p>' . RC_Lang::get('wechat::wechat.wechat_menu_edit_content') . '</p>',
        ));

        ecjia_platform_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . RC_Lang::get('wechat::wechat.more_info') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:自定义菜单#.E7.BC.96.E8.BE.91.E5.BE.AE.E4.BF.A1.E8.8F.9C.E5.8D.95" target="_blank">' . RC_Lang::get('wechat::wechat.wechat_menu_edit_help') . '</a>') . '</p>'
        );

        $wechat_id = $this->platformAccount->getAccountID();

        $type = $this->platformAccount->getType();
        $this->assign('type', $type);
        $this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.notice_subscribe_nonsupport'), RC_Lang::get('wechat::wechat.wechat_type.' . $type)));

        $id = intval($_GET['id']);
        $wechatmenus = RC_DB::table('wechat_menu')->where('id', $id)->where('wechat_id', $wechat_id)->first();

        if ($wechatmenus['type'] == 'miniprogram') {
            $config_url = unserialize($wechatmenus['url']);
            $wechatmenus['app_id'] = $config_url['appid'];
        }
        $this->assign('wechatmenus', $wechatmenus);

        $pmenu = RC_DB::table('wechat_menu')->where('pid', 0)->where('id', '!=', $id)->where('wechat_id', $wechat_id)->get();
        $this->assign('pmenu', $pmenu);

        $child = RC_DB::table('wechat_menu')->where('wechat_id', $wechat_id)->where('id', $id)->pluck('pid');
        $this->assign('child', $child);

        $weapplist = $this->get_weapplist();
        $this->assign('weapplist', $weapplist);

        $this->assign('form_action', RC_Uri::url('wechat/platform_menus/update'));

        $this->display('wechat_menus_edit.dwt');
    }

    /**
     * 编辑菜单处理
     */
    public function update()
    {
        $this->admin_priv('wechat_menus_update', ecjia::MSGTYPE_JSON);

        $wechat_id = $this->platformAccount->getAccountID();

        $id = !empty($_POST['id']) ? intval($_POST['id']) : 0;
        $name = !empty($_POST['name']) ? trim($_POST['name']) : '';
        $type = !empty($_POST['type']) ? $_POST['type'] : '';
        $key = !empty($_POST['key']) ? $_POST['key'] : '';
        $web_url = !empty($_POST['url']) ? $_POST['url'] : '';
        $status = !empty($_POST['status']) ? intval($_POST['status']) : 0;
        $sort = !empty($_POST['sort']) ? intval($_POST['sort']) : 0;

        if (empty($name)) {
            return $this->showmessage('菜单名称不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
//         if (strlen($name) > 16) {
//             return $this->showmessage('字数不超过8个汉字或16个字母', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
//         }

        if ($type == 'view') {
            if (empty($web_url)) {
                return $this->showmessage('外链url不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            } else {
                if (strpos($web_url, 'http://') === false && strpos($web_url, 'https://') === false) {
                    return $this->showmessage('外链url格式错误', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
                $url = $web_url;
            }
        } elseif ($type == 'miniprogram') {
            //小程序配置信息
            $h5_url = RC_Uri::home_url() . '/sites/m/';
            $weapp_appid = $_POST['weapp_appid'];
            if (empty($weapp_appid)) {
                return $this->showmessage('请选择小程序', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            } else {
                $miniprogram_config = array(
                    'url' => $h5_url,
                    'appid' => $weapp_appid,
                    'pagepath' => 'pages/ecjia-store/ecjia',
                );
                $url = serialize($miniprogram_config);
            }
        }
        $data = array(
            'name' => $name,
            'type' => $type,
            'key' => $key,
            'url' => $url,
            'status' => $status,
            'sort' => $sort,
        );
        RC_DB::table('wechat_menu')->where('id', $id)->where('wechat_id', $wechat_id)->update($data);

        ecjia_admin::admin_log($name, 'edit', 'menu');

        $listdb = $this->get_menuslist();
        $menu_list = $listdb['menu_list'];
        $count = count($listdb['menu_list']);

        $this->assign('menu_list', $menu_list);
        $this->assign('count', $count);

        $info = RC_DB::table('wechat_menu')->where('id', $id)->where('wechat_id', $wechat_id)->first();
        if ($type == 'miniprogram') {
            $config_url = unserialize($info['url']);
            $info['app_id'] = $config_url['appid'];
        }

        $count = RC_DB::table('wechat_menu')->where('wechat_id', $wechat_id)->where('pid', $info['id'])->count();

        $this->assign('id', $id);
        $this->assign('pid', $info['pid']);
        $this->assign('wechat_menus', $info);

        $weapplist = $this->get_weapplist();
        $this->assign('weapplist', $weapplist);

        $res = $this->fetch('library/wechat_menu_menu.lbi');

        if ($wechat_menus['pid'] == 0 && $count != 0) {
            $result = $this->fetch('library/wechat_menu_second.lbi');
        } else {
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

            $result = $this->fetch('library/wechat_menu_sub.lbi');
        }

        return $this->showmessage('保存成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('data' => $res, 'result' => $result));
    }

    /**
     * 生成自定义菜单
     */
    public function sys_menu()
    {
        $this->admin_priv('wechat_menus_manage', ecjia::MSGTYPE_JSON);

        $wechat_id = $this->platformAccount->getAccountID();
        if (is_ecjia_error($wechat_id)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.add_platform_first'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } else {
            $list = RC_DB::table('wechat_menu')->where('status', 1)->where('wechat_id', $wechat_id)->orderBy('sort', 'asc')->get();
            if (empty($list)) {
                return $this->showmessage(RC_Lang::get('wechat::wechat.check_menu_status'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $data = array();
            if (is_array($list)) {
                foreach ($list as $val) {
                    if ($val['pid'] == 0) {
                        $sub_button = array();
                        foreach ($list as $v) {
                            if ($v['pid'] == $val['id']) {
                                $sub_button[] = $v;
                            }
                        }
                        $val['sub_button'] = $sub_button;
                        $data[] = $val;
                    }
                }
            }

            $menu = array();
            foreach ($data as $key => $val) {
                if (empty($val['sub_button'])) {
                    $menu[$key]['type'] = $val['type'];
                    $menu[$key]['name'] = $val['name'];
                    if ($val['type'] == 'click') {
                        $menu[$key]['key'] = $val['key'];
                    } elseif ($val['type'] == 'view') {
                        $menu[$key]['url'] = $this->html_out($val['url']);
                    } else {
                        $url_config = unserialize($val['url']);
                        $menu[$key]['url'] = $this->html_out($url_config['url']);
                        $menu[$key]['appid'] = $url_config['appid'];
                        $menu[$key]['pagepath'] = $url_config['pagepath'];
                    }
                } else {
                    $menu[$key]['name'] = $val['name'];
                    foreach ($val['sub_button'] as $k => $v) {
                        $menu[$key]['sub_button'][$k]['type'] = $v['type'];
                        $menu[$key]['sub_button'][$k]['name'] = $v['name'];
                        if ($v['type'] == 'click') {
                            $menu[$key]['sub_button'][$k]['key'] = $v['key'];
                        } elseif ($v['type'] == 'view') {
                            $menu[$key]['sub_button'][$k]['url'] = $this->html_out($v['url']);
                        } else {
                            $child_url = unserialize($v['url']);
                            $menu[$key]['sub_button'][$k]['url'] = $this->html_out($child_url['url']);
                            $menu[$key]['sub_button'][$k]['appid'] = $child_url['appid'];
                            $menu[$key]['sub_button'][$k]['pagepath'] = $child_url['pagepath'];
                        }
                    }
                }
            }

            $uuid = $this->platformAccount->getUUID();
            try {
                $wechat = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();
                $rs = $wechat->menu->add($menu);

                ecjia_admin::admin_log(RC_Lang::get('wechat::wechat.make_menu'), 'setup', 'menu');
                return $this->showmessage(RC_Lang::get('wechat::wechat.make_menu_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);

            } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
                return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }
    }

    /**
     * 获取自定义菜单
     */
    public function get_menu()
    {
        $this->admin_priv('wechat_menus_manage', ecjia::MSGTYPE_JSON);

        $uuid = $this->platformAccount->getUUID();

        $wechat_id = $this->platformAccount->getAccountID();
        if (is_ecjia_error($wechat_id)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.add_platform_first'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } else {

            try {
                $wechat = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();
                $list = $wechat->menu->all()->toArray();

                if ($list) {
                    RC_DB::table('wechat_menu')->where('wechat_id', $wechat_id)->delete();
                }

                //一级菜单处理
                foreach ($list['menu']['button'] as $key => $value) {
                    $value['type'] = isset($value['type']) ? $value['type'] : '';
                    $value['url'] = isset($value['url']) ? $value['url'] : '';
                    $value['key'] = isset($value['key']) ? $value['key'] : '';

                    if ($value['type'] == 'view') {
                        $array = array('name' => $value['name'], 'status' => 1, 'type' => 'view', 'url' => $value['url'], 'wechat_id' => $wechat_id);
                    } elseif ($value['type'] == 'click') {
                        $array = array('name' => $value['name'], 'status' => 1, 'type' => 'click', 'key' => $value['key'], 'wechat_id' => $wechat_id);
                    } elseif ($value['type'] == 'miniprogram') {
                        $config_url = array(
                            'url' => $value['url'],
                            'appid' => $value['appid'],
                            'pagepath' => $value['pagepath'],
                        );
                        $array = array('name' => $value['name'], 'status' => 1, 'type' => 'miniprogram', 'url' => serialize($config_url), 'wechat_id' => $wechat_id);
                    } else {
                        $array = array('name' => $value['name'], 'status' => 1, 'type' => $value['type'], 'url' => $value['url'], 'key' => $value['key'], 'wechat_id' => $wechat_id);
                    }

                    $id = RC_DB::table('wechat_menu')->insertGetId($array);

                    //子集菜单处理
                    if ($value['sub_button']) {
                        $data = array();
                        foreach ($value['sub_button'] as $k => $v) {
                            $v['name'] = isset($v['name']) ? $v['name'] : '';
                            $v['type'] = isset($v['type']) ? $v['type'] : '';
                            $v['url'] = isset($v['url']) ? $v['url'] : '';
                            $v['key'] = isset($v['key']) ? $v['key'] : '';

                            if ($v['type'] == 'miniprogram') {
                                $child_url = array(
                                    'url' => $v['url'],
                                    'appid' => $v['appid'],
                                    'pagepath' => $v['pagepath'],
                                );
                                $data['url'] = serialize($child_url);
                            } else {
                                $data['url'] = $v['url'];
                            }
                            $data['wechat_id'] = $wechat_id;
                            $data['name'] = $v['name'];
                            $data['type'] = $v['type'];
                            $data['key'] = $v['key'];
                            $data['status'] = 1;
                            $data['pid'] = $id;
                            RC_DB::table('wechat_menu')->insert($data);
                        }
                    }
                }

                ecjia_admin::admin_log(RC_Lang::get('wechat::wechat.get_menu'), 'setup', 'menu');
                return $this->showmessage(RC_Lang::get('wechat::wechat.get_menu_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/platform_menus/init')));
            } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
                return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }
    }

    /**
     * 删除自定义菜单
     */
    public function delete_menu()
    {
        $this->admin_priv('wechat_menus_delete', ecjia::MSGTYPE_JSON);

        $uuid = $this->platformAccount->getUUID();

        $wechat_id = $this->platformAccount->getAccountID();
        if (is_ecjia_error($wechat_id)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.add_platform_first'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } else {

            try {
                $wechat = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();
                $rs = $wechat->menu->destroy();

                ecjia_admin::admin_log(RC_Lang::get('wechat::wechat.clear_menu'), 'setup', 'menu');
                RC_DB::table('wechat_menu')->where('wechat_id', $wechat_id)->where('id', '>', 0)->update(array('status' => 0));

                return $this->showmessage(RC_Lang::get('wechat::wechat.clear_menu_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/platform_menus/init')));
            } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
                return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }
    }

    /**
     * 删除菜单
     */
    public function remove()
    {
        $this->admin_priv('wechat_menus_delete', ecjia::MSGTYPE_JSON);

        $wechat_id = $this->platformAccount->getAccountID();

        $id = intval($_POST['id']);
        $info = RC_DB::table('wechat_menu')->where('wechat_id', $wechat_id)->where('id', $id)->first();

        if ($info['pid'] == 0) {
            RC_DB::table('wechat_menu')->where('wechat_id', $wechat_id)->where('pid', $info['id'])->delete();
        } else {
            RC_DB::table('wechat_menu')->where('wechat_id', $wechat_id)->where('id', $info['pid'])->update(array('type' => 'click'));
        }
        RC_DB::table('wechat_menu')->where('wechat_id', $wechat_id)->where('id', $id)->delete();

        ecjia_admin::admin_log($info['name'], 'remove', 'menu');
        return $this->showmessage(RC_Lang::get('wechat::wechat.remove_menu_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/platform_menus/init')));
    }

    /**
     * 手动排序
     */
    public function edit_sort()
    {
        $this->admin_priv('wechat_menus_update', ecjia::MSGTYPE_JSON);

        $wechat_id = $this->platformAccount->getAccountID();

        $id = intval($_POST['pk']);
        $sort = trim($_POST['value']);
        $name = RC_DB::table('wechat_menu')->where('wechat_id', $wechat_id)->where('id', $id)->pluck('name');
        if (!empty($sort)) {
            if (!is_numeric($sort)) {
                return $this->showmessage(RC_Lang::get('wechat::wechat.sort_numeric'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            } else {
                RC_DB::table('wechat_menu')->where('wechat_id', $wechat_id)->where('id', $id)->update(array('sort' => $sort));
                ecjia_admin::admin_log($name, 'edit', 'menu');
                return $this->showmessage(RC_Lang::get('wechat::wechat.edit_sort_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_uri::url('wechat/platform_menus/init')));
            }
        } else {
            return $this->showmessage(RC_Lang::get('wechat::wechat.menu_sort_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 切换是否显示
     */
    public function toggle_show()
    {
        $this->admin_priv('wechat_menus_update', ecjia::MSGTYPE_JSON);

        $wechat_id = $this->platformAccount->getAccountID();

        $id = intval($_POST['id']);
        $val = intval($_POST['val']);
        RC_DB::table('wechat_menu')->where('wechat_id', $wechat_id)->where('id', $id)->update(array('status' => $val));

        return $this->showmessage(RC_Lang::get('wechat::wechat.switch_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_uri::url('wechat/platform_menus/init')));
    }

    public function get_menu_info()
    {
        $wechat_id = $this->platformAccount->getAccountID();

        $id = intval($_POST['id']);
        $this->assign('id', $id);

        $wechat_menus = RC_DB::table('wechat_menu')->where('wechat_id', $wechat_id)->where('id', $id)->first();
        if ($wechat_menus['type'] == 'miniprogram') {
            $config_url = unserialize($wechat_menus['url']);
            $wechat_menus['app_id'] = $config_url['appid'];
        }
        $this->assign('wechat_menus', $wechat_menus);

        $count = RC_DB::table('wechat_menu')->where('wechat_id', $wechat_id)->where('pid', $wechat_menus['id'])->count();

        $weapplist = $this->get_weapplist();
        $this->assign('weapplist', $weapplist);

        if ($count != 0) {
            $data = $this->fetch('library/wechat_menu_second.lbi');
        } else {
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
            $data = $this->fetch('library/wechat_menu_sub.lbi');
        }
        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('data' => $data));
    }

    public function check()
    {
        $wechat_id = $this->platformAccount->getAccountID();

        $listdb = $this->get_menuslist();
        $menu_list = $listdb['menu_list'];

        $id = 0;
        if (!empty($menu_list)) {
            foreach ($menu_list as $k => $v) {
                if ($v['type'] == 'click') {
                    if (empty($v['key']) && empty($v['sub_button'])) {
                        $id = $v['id'];
                        break;
                    } else if (!empty($v['sub_button'])) {
                        foreach ($v['sub_button'] as $key => $val) {
                            if ($val['type'] == 'click') {
                                if (empty($val['key'])) {
                                    $id = $val['id'];
                                    break;
                                }
                            } else if ($val['type'] == 'view' || $val['type'] == 'miniprogram') {
                                if (empty($val['url'])) {
                                    $id = $val['id'];
                                    break;
                                }
                            }
                        }
                    }
                } else if (($v['type'] == 'view' || $v['type'] == 'miniprogram')) {
                    if (empty($v['url']) && empty($v['sub_button'])) {
                        $id = $v['id'];
                        break;
                    }
                    if (!empty($v['sub_button'])) {
                        foreach ($v['sub_button'] as $key => $val) {
                            if ($val['type'] == 'click') {
                                if (empty($val['key'])) {
                                    $id = $val['id'];
                                    break;
                                }
                            } else if ($val['type'] == 'view' || $val['type'] == 'miniprogram') {
                                if (empty($val['url'])) {
                                    $id = $val['id'];
                                    break;
                                }
                            }
                        }
                    }
                }
            }
            $count = count($listdb['menu_list']);
            $data = RC_DB::table('wechat_menu')->where('wechat_id', $wechat_id)->where('id', $id)->first();
            if ($data['type'] == 'miniprogram') {
                $config_url = unserialize($data['url']);
                $data['app_id'] = $config_url['appid'];
            }

            $this->assign('menu_list', $listdb['menu_list']);
            $this->assign('count', $count);

            $this->assign('id', $id);
            $this->assign('pid', $data['pid']);
            $this->assign('wechat_menus', $data);

            $weapplist = $this->get_weapplist();
            $this->assign('weapplist', $weapplist);

            $res = $this->fetch('library/wechat_menu_menu.lbi');

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

            $result = $this->fetch('library/wechat_menu_sub.lbi');
            return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('data' => $res, 'result' => $result, 'id' => $id));
        }
    }

    /**
     * 取得菜单信息
     */
    private function get_menuslist()
    {

        $wechat_id = $this->platformAccount->getAccountID();

        $list = RC_DB::table('wechat_menu')->where('wechat_id', $wechat_id)->orderBy('sort', 'asc')->get();
        $result = array();

        if (!empty($list)) {
            foreach ($list as $vo) {
                if ($vo['type'] == 'miniprogram') {
                    $config_url = unserialize($vo['url']);
                    $vo['url'] = $config_url['pagepath'];
                }
                if ($vo['pid'] == 0) {
                    $sub_button = array();
                    foreach ($list as $val) {
                        if ($vo['id'] == $val['pid']) {
                            if ($val['type'] == 'miniprogram') {
                                $child_url = unserialize($val['url']);
                                $val['url'] = $child_url['pagepath'];
                            }
                            $sub_button[] = $val;
                        }
                    }
                    $vo['sub_button'] = $sub_button;
                    $result[] = $vo;
                }
            }
        }

        if (!empty($result)) {
            foreach ($result as $k => $v) {
                $result[$k]['count'] = 0;
                if (!empty($v['sub_button'])) {
                    $result[$k]['count'] = count($v['sub_button']);
                }
            }
        }

        return array('menu_list' => $result);
    }

    /**
     * 取得小程序
     */
    private function get_weapplist()
    {
        $data = RC_DB::table('platform_account')->where('shop_id', $_SESSION['store_id'])->where('platform', 'weapp')->select('appid', 'name')->get();
        $list = array();
        if (!empty($data)) {
            foreach ($data as $row) {
                $list[$row['appid']] = $row['name'];
            }
        }
        return $list;
    }

    /**
     * html代码输出
     * @param unknown $str
     * @return string
     */
    private function html_out($str)
    {
        if (function_exists('htmlspecialchars_decode')) {
            $str = htmlspecialchars_decode($str);
        } else {
            $str = html_entity_decode($str);
        }
        $str = stripslashes($str);
        return $str;
    }
}

//end
