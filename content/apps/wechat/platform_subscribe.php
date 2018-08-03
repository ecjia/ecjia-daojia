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
 * ECJIA粉丝管理
 */
class platform_subscribe extends ecjia_platform
{
    public function __construct()
    {
        parent::__construct();

        RC_Loader::load_app_func('global');
        Ecjia\App\Wechat\Helper::assign_adminlog_content();

        RC_Loader::load_app_class('platform_account', 'platform', false);

        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Style::enqueue_style('bootstrap-responsive');

        RC_Script::enqueue_script('platform_subscribe', RC_App::apps_url('statics/platform-js/platform_subscribe.js', __FILE__), array(), false, true);
        RC_Script::enqueue_script('choose_material', RC_App::apps_url('statics/platform-js/choose_material.js', __FILE__), array(), false, true);

        RC_Style::enqueue_style('platform_subscribe', RC_App::apps_url('statics/platform-css/admin_subscribe.css', __FILE__));
        RC_Style::enqueue_style('admin_material', RC_App::apps_url('statics/platform-css/admin_material.css', __FILE__));
        RC_Script::localize_script('platform_subscribe', 'js_lang', RC_Lang::get('wechat::wechat.js_lang'));

        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.subscribe_manage'), RC_Uri::url('wechat/platform_subscribe/init')));
        ecjia_platform_screen::get_current_screen()->set_subject('粉丝管理');
    }

    public function init()
    {
        $this->admin_priv('wechat_subscribe_manage');

        ecjia_platform_screen::get_current_screen()->remove_last_nav_here();
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.subscribe_manage')));
        ecjia_platform_screen::get_current_screen()->add_help_tab(array(
            'id' => 'overview',
            'title' => RC_Lang::get('wechat::wechat.overview'),
            'content' => '<p>' . RC_Lang::get('wechat::wechat.subscribe_manage_content') . '</p>',
        ));
        ecjia_platform_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . RC_Lang::get('wechat::wechat.more_info') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:用户管理#.E7.94.A8.E6.88.B7.E7.AE.A1.E7.90.86" target="_blank">' . RC_Lang::get('wechat::wechat.subscribe_manage_help') . '</a>') . '</p>'
        );

        $wechat_id = $this->platformAccount->getAccountID();

        $this->assign('ur_here', RC_Lang::get('wechat::wechat.subscribe_manage'));
        $this->assign('form_action', RC_Uri::url('wechat/platform_subscribe/init'));
        $this->assign('action', RC_Uri::url('wechat/platform_subscribe/subscribe_move'));
        $this->assign('label_action', RC_Uri::url('wechat/platform_subscribe/batch'));
        $this->assign('get_checked', RC_Uri::url('wechat/platform_subscribe/get_checked_tag'));

        if (is_ecjia_error($wechat_id)) {
            $this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
        } else {
            $this->assign('warn', 'warn');

            //微信id、标签id、关键字
            $where = "u.wechat_id = $wechat_id";
            $keywords = isset($_GET['keywords']) ? trim($_GET['keywords']) : '';
            $tag_id = isset($_GET['tag_id']) ? $_GET['tag_id'] : '';

            //用户标签列表
            $tag_arr['all'] = RC_DB::table('wechat_user')->where('wechat_id', $wechat_id)->where('subscribe', 1)->where('group_id', '!=', 1)->count();
            $tag_arr['item'] = RC_DB::table('wechat_tag')->select('id', 'tag_id', 'name', 'count')->where('wechat_id', $wechat_id)->orderBy('id', 'desc')->get();

            $this->assign('tag_arr', $tag_arr);

            //关键字搜索
            if (!empty($keywords)) {
                $where .= ' and (u.nickname like "%' . $keywords . '%" or u.province like "%' . $keywords . '%" or u.city like "%' . $keywords . '%")';
            }

            //全部用户
            if (empty($tag_id)) {
                $where .= " and u.subscribe = 1 and u.group_id != 1";
                //标签用户
            } else {
                $user_list = RC_DB::table('wechat_user_tag')->where('tagid', $tag_id)->lists('userid');
                if (empty($user_list)) {
                    $user_list = 0;
                }
                $where .= ' and u.group_id != 1 and u.uid' . ecjia_db_create_in($user_list);
            }

            $total = RC_DB::table('wechat_user as u')->whereRaw($where)->count();
            $page = new ecjia_platform_page($total, 10, 5);

            $list = RC_DB::table('wechat_user as u')
                ->leftJoin('users as us', RC_DB::raw('us.user_id'), '=', RC_DB::raw('u.ect_uid'))
                ->select(RC_DB::raw('u.*'), RC_DB::raw('us.user_name'))
                ->whereRaw($where)
                ->orderBy(RC_DB::raw('u.subscribe_time'), 'desc')
                ->take(10)
                ->skip($page->start_id - 1)
                ->get();

            if (!empty($list)) {
                foreach ($list as $k => $v) {
                    //假如不是黑名单
                    if ($v['group_id'] != 1) {
                        $tag_list = RC_DB::table('wechat_user_tag')->where('userid', $v['uid'])->lists('tagid');
                        $db_wechat_tag = RC_DB::table('wechat_tag');
                        $name_list = [];
                        if (!empty($tag_list)) {
                            $name_list = $db_wechat_tag->whereIn('tag_id', $tag_list)->where('wechat_id', $wechat_id)->orderBy('tag_id', 'desc')->lists('name');
                        }
                        if (!empty($name_list)) {
                            $list[$k]['tag_name'] = implode('，', $name_list);
                        }
                    }
                }
            }
            $arr = array('item' => $list, 'page' => $page->show(5), 'desc' => $page->page_desc());
            $this->assign('list', $arr);

            if (isset($_GET['action']) && $_GET['action'] == 'get_list') {
                //无unionid给提示
                if (!empty($list)) {
                    if (empty($list[0]['unionid'])) {
                        $unionid = 1;
                        $this->assign('unionid', $unionid);
                    }
                }
            }

            //取消关注用户数量
            $num = RC_DB::table('wechat_user')->where('wechat_id', $wechat_id)->where('subscribe', 0)->where('group_id', 0)->count();
            $this->assign('num', $num);

            //获取公众号类型 0未认证 1订阅号 2服务号 3认证服务号 4企业号
            $types = $this->platformAccount->getType();
            $this->assign('type', $types);
            $this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.notice_certification_info'), RC_Lang::get('wechat::wechat.wechat_type.' . $types)));
            $this->assign('custom_type_error', sprintf(RC_Lang::get('wechat::wechat.notice_service_info'), RC_Lang::get('wechat::wechat.wechat_type.' . $type)));

            $customer_list = RC_DB::table('wechat_customer')->where('wechat_id', $wechat_id)->where('online_status', 1)->get();
            $this->assign('customer_list', $customer_list);
        }

        $this->display('wechat_subscribe_list.dwt');
    }

    public function edit_tag()
    {
        $uuid = $this->platformAccount->getUUID();
        $wechat = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();

        $wechat_id = $this->platformAccount->getAccountID();

        if (is_ecjia_error($wechat_id)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.add_platform_first'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $id = !empty($_POST['id']) ? intval($_POST['id']) : 0;
        $name = !empty($_POST['new_tag']) ? $_POST['new_tag'] : '';
        if (empty($name)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.tag_name_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        try {
            if (!empty($id)) {
                $this->admin_priv('wechat_subscribe_update', ecjia::MSGTYPE_JSON);

                $data = array('name' => $name);
                $is_only = RC_DB::table('wechat_tag')->where('id', '!=', $id)->where('name', $name)->where('wechat_id', $wechat_id)->count();
                if ($is_only != 0) {
                    return $this->showmessage(RC_Lang::get('wechat::wechat.tag_name_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }

                $tag_id = RC_DB::table('wechat_tag')->where('id', $id)->pluck('tag_id');
                //微信端更新
                $wechat->user_tag->update($tag_id, $name);

                //本地更新
                RC_DB::table('wechat_tag')->where('wechat_id', $wechat_id)->where('id', $id)->update($data);

                //记录日志
                ecjia_admin::admin_log($name, 'edit', 'users_tag');
                return $this->showmessage(RC_Lang::get('wechat::wechat.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/platform_subscribe/tag')));
            } else {
                $this->admin_priv('wechat_subscribe_add', ecjia::MSGTYPE_JSON);

                $count = RC_DB::table('wechat_tag')->where('wechat_id', $wechat_id)->count();
                if ($count == 100) {
                    return $this->showmessage(RC_Lang::get('wechat::wechat.up_tag_info'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }

                $is_only = RC_DB::table('wechat_tag')->where('name', $name)->where('wechat_id', $wechat_id)->count();
                if ($is_only != 0) {
                    return $this->showmessage(RC_Lang::get('wechat::wechat.tag_name_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }

                //微信端添加
                $rs = $wechat->user_tag->create($name);
                $tag_id = $rs['tag']['id'];

                //本地添加
                $data = array('name' => $name, 'wechat_id' => $wechat_id, 'tag_id' => $tag_id);
                $id = RC_DB::table('wechat_tag')->insertGetId($data);
                //记录日志
                ecjia_admin::admin_log($name, 'add', 'users_tag');
                if ($id) {
                    return $this->showmessage(RC_Lang::get('wechat::wechat.add_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/platform_subscribe/tag')));
                } else {
                    return $this->showmessage(RC_Lang::get('wechat::wechat.add_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            }
        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 删除标签
     */
    public function remove()
    {
        $this->admin_priv('wechat_subscribe_delete', ecjia::MSGTYPE_JSON);

        $tag_id = !empty($_GET['tag_id']) ? intval($_GET['tag_id']) : 0;
        $id = !empty($_GET['id']) ? intval($_GET['id']) : 0;

        $uuid = $this->platformAccount->getUUID();
        $wechat = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();

        $wechat_id = $this->platformAccount->getAccountID();
        if (is_ecjia_error($wechat_id)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.add_platform_first'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        try {
            //微信端删除
            $wechat->user_tag->delete($tag_id);
        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        //本地删除
        $name = RC_DB::table('wechat_tag')->where('id', $id)->pluck('name');
        RC_DB::table('wechat_tag')->where('id', $id)->where('tag_id', $tag_id)->where('wechat_id', $wechat_id)->delete();

        //记录日志
        ecjia_admin::admin_log($name, 'remove', 'users_tag');
        RC_DB::table('wechat_user')->where('wechat_id', $wechat_id)->where('group_id', $tag_id)->update(array('group_id' => 0));
        return $this->showmessage(RC_Lang::get('wechat::wechat.remove_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    /**
     * 获取全部标签
     */
    public function get_usertag()
    {
        $this->admin_priv('wechat_subscribe_manage', ecjia::MSGTYPE_JSON);

        $result = $this->get_user_tags();
        if ($result === true) {
            //记录日志
            ecjia_admin::admin_log(RC_Lang::get('wechat::wechat.get_user_tag'), 'setup', 'users_tag');
            return $this->showmessage(RC_Lang::get('wechat::wechat.get_tag_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/platform_subscribe/tag')));
        }
    }

    /**
     * 获取用户信息
     */
    public function get_userinfo()
    {
        $this->admin_priv('wechat_subscribe_manage', ecjia::MSGTYPE_JSON);

        $uuid = $this->platformAccount->getUUID();
        $wechat_id = $this->platformAccount->getAccountID();
        $wechat = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();

        if (is_ecjia_error($wechat_id)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.add_platform_first'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        //读取上次获取用户位置
        $p = RC_Cache::app_cache_get('wechat_user_position_' . $wechat_id, 'wechat');

        if ($p == false) {
            $p = !empty($_GET['p']) ? intval($_GET['p']) : 0;
        }
        //删除缓存
        if (empty($p)) {
            RC_Cache::app_cache_delete('wechat_user_list_' . $wechat_id, 'wechat');
        }

        //读取缓存
        $wechat_user_list = RC_Cache::app_cache_get('wechat_user_list_' . $wechat_id, 'wechat');
        if ($wechat_user_list == false) {

            try {
                $wechat_user = $wechat->user->lists()->toArray();
                if ($wechat_user['total'] <= 10000) {
                    $wechat_user_list = $wechat_user['data']['openid'];
                } else {
                    $num = ceil($wechat_user['total'] / 10000);
                    for ($i = 1; $i < $num; $i++) {
                        $wechat_user1 = $wechat->user->lists($wechat_user['next_openid'])->toArray();
                        $wechat_user['next_openid'] = $wechat_user1['next_openid'];
                        $wechat_user['data']['openid'] = array_merge($wechat_user['data']['openid'], $wechat_user1['data']['openid']);
                    }
                }
                $wechat_user_list = $wechat_user['data']['openid'];
                //设置缓存
                RC_Cache::app_cache_set('wechat_user_list_' . $wechat_id, $wechat_user_list, 'wechat');

            } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
                return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

        }

        $user_list = RC_DB::table('wechat_user')->where('wechat_id', $wechat_id)->lists('openid');
        if (empty($user_list)) {
            $user_list = array();
        }

        //比较微信端获取的用户列表 与 本地数据表用户列表
        if (empty($_GET['p'])) {
            foreach ($user_list as $v) {
                if (!in_array($v, $wechat_user_list)) {
                    $unsubscribe_list[] = $v;
                }
            }
            //更新取消关注用户
            if (!empty($unsubscribe_list)) {
                $where = array(
                    'wechat_id' => $wechat_id,
                    'openid' . ecjia_db_create_in($unsubscribe_list),
                );
                RC_DB::table('wechat_user')->where('wechat_id', $wechat_id)->whereRaw('openid' . ecjia_db_create_in($unsubscribe_list))->update(array('subscribe' => 0));

                //删除取消关注用户的标签
                $uid_list = RC_DB::table('wechat_user')->where('wechat_id', $wechat_id)->whereRaw('openid' . ecjia_db_create_in($unsubscribe_list))->lists('uid');
                RC_DB::table('wechat_user_tag')->whereIn('userid', $uid_list)->delete();
            }
        }

        $arr1 = $arr2 = array();
        $list = array_slice($wechat_user_list, $p, 100);

        $total = count($wechat_user_list);
        $counts = count($list);

        $p += $counts;

        $where = array();
        if (!empty($list)) {
            foreach ($list as $k => $vs) {
                //不在表中为新关注用户、添加用户信息
                if (!in_array($vs, $user_list)) {
                    $arr1[] = $vs;

                } else {
                    //在表中为原来关注用户、更新用户信息
                    $arr2[] = $vs;
                }
            }
        }

        //添加
        if (!empty($arr1)) {

            try {
                $info2 = $wechat->user->batchGet($arr1)->toArray();

                foreach ($info2['user_info_list'] as $key => $v) {
                    $info2['user_info_list'][$key]['wechat_id'] = $wechat_id;
                    $info2['user_info_list'][$key]['headimgurl'] = is_ssl() && !empty($v['headimgurl']) ? str_replace('http://', 'https://', $v['headimgurl']) : $v['headimgurl'];
                    $info2['user_info_list'][$key]['group_id'] = $v['groupid'];
                    unset($info2['user_info_list'][$key]['groupid']);
                    unset($info2['user_info_list'][$key]['tagid_list']);

                    $uid = RC_DB::table('wechat_user')->insertGetId($info2['user_info_list'][$key]);
                    if (!empty($v['tagid_list'])) {
                        foreach ($v['tagid_list'] as $val) {
                            if (!empty($val)) {
                                RC_DB::table('wechat_user_tag')->insert(array('userid' => $uid, 'tagid' => $val));
                            }
                        }
                    }
                }

            } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
                return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

        }
        //更新
        if (!empty($arr2)) {

            try {
                $info3 = $wechat->user->batchGet($arr2)->toArray();
                foreach ($info3['user_info_list'] as $key => $v) {
                    $info3['user_info_list'][$key]['subscribe'] = 1;
                    $info3['user_info_list'][$key]['headimgurl'] = is_ssl() && !empty($v['headimgurl']) ? str_replace('http://', 'https://', $v['headimgurl']) : $v['headimgurl'];
                    $where['wechat_id'] = $wechat_id;
                    $where['openid'] = $v['openid'];

//                     $info3['user_info_list'][$key]['group_id'] = $v['groupid'];
                    unset($info3['user_info_list'][$key]['groupid']);
                    unset($info3['user_info_list'][$key]['tagid_list']);

                    RC_DB::table('wechat_user')->where('wechat_id', $wechat_id)->where('openid', $v['openid'])->update($info3['user_info_list'][$key]);

                    $uid = RC_DB::table('wechat_user')->where('wechat_id', $wechat_id)->where('openid', $v['openid'])->pluck('uid');
                    if (!empty($v['tagid_list'])) {
                        RC_DB::table('wechat_user_tag')->where('userid', $uid)->delete();

                        foreach ($v['tagid_list'] as $val) {
                            if (!empty($val)) {
                                RC_DB::table('wechat_user_tag')->insert(array('userid' => $uid, 'tagid' => $val));
                            }
                        }
                    }
                }

            } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
                return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

        }

        if ($p < $total) {
            RC_Cache::app_cache_set('wechat_user_position_' . $wechat_id, $p, 'wechat');
            return $this->showmessage(sprintf(RC_Lang::get('wechat::wechat.get_user_already'), $p), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => RC_Uri::url("wechat/platform_subscribe/get_userinfo"), 'notice' => 1, 'p' => $p));
        } else {
            RC_Cache::app_cache_delete('wechat_user_position_' . $wechat_id, 'wechat');
            RC_Cache::app_cache_delete('wechat_user_list_' . $wechat_id, 'wechat');

            ecjia_admin::admin_log(RC_Lang::get('wechat::wechat.get_user_info'), 'setup', 'users_info');
            return $this->showmessage(RC_Lang::get('wechat::wechat.get_userinfo_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/platform_subscribe/init', array('action' => 'get_list'))));
        }
    }

    /**
     * 获取黑名单用户信息
     */
    public function get_blackuserinfo()
    {
        $this->admin_priv('wechat_subscribe_manage', ecjia::MSGTYPE_JSON);

        $uuid = $this->platformAccount->getUUID();
        $wechat_id = $this->platformAccount->getAccountID();
        $wechat = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();

        if (is_ecjia_error($wechat_id)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.add_platform_first'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        //读取上次获取用户位置
        $p = RC_Cache::app_cache_get('wechat_blackuser_position_' . $wechat_id, 'wechat');

        if ($p == false) {
            $p = !empty($_GET['p']) ? intval($_GET['p']) : 0;
        }
        //删除缓存
        if (empty($p)) {
            RC_Cache::app_cache_delete('wechat_blackuser_list_' . $wechat_id, 'wechat');
        }

        //读取缓存
        $wechat_user_list = RC_Cache::app_cache_get('wechat_blackuser_list_' . $wechat_id, 'wechat');
        if ($wechat_user_list == false) {

            try {
                $wechat_user = $wechat->user_tag->usersOfBlack()->toArray();
                if ($wechat_user['total'] <= 10000) {
                    $wechat_user_list = $wechat_user['data']['openid'];
                } else {
                    $num = ceil($wechat_user['total'] / 10000);
                    for ($i = 1; $i < $num; $i++) {
                        $wechat_user1 = $wechat->user_tag->usersOfBlack($wechat_user['next_openid'])->toArray();
                        $wechat_user['next_openid'] = $wechat_user1['next_openid'];
                        $wechat_user['data']['openid'] = array_merge($wechat_user['data']['openid'], $wechat_user1['data']['openid']);
                    }
                }
                $wechat_user_list = $wechat_user['data']['openid'];
                //设置缓存
                RC_Cache::app_cache_set('wechat_blackuser_list_' . $wechat_id, $wechat_user_list, 'wechat');

            } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
                return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

        }

        $user_list = RC_DB::table('wechat_user')->where('wechat_id', $wechat_id)->lists('openid');
        if (empty($user_list)) {
            $user_list = array();
        }

        $arr1 = $arr2 = array();
        $list = array_slice($wechat_user_list, $p, 100);

        $total = count($wechat_user_list);
        $counts = count($list);
        $p += $counts;

        if (!empty($list)) {
            RC_DB::table('wechat_user')->whereIn('openid', $list)->update(array('group_id' => 1));
        }

        if ($p < $total) {
            RC_Cache::app_cache_set('wechat_blackuser_position_' . $wechat_id, $p, 'wechat');
            return $this->showmessage(sprintf(RC_Lang::get('wechat::wechat.get_user_already'), $p), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => RC_Uri::url("wechat/platform_subscribe/get_blackuserinfo"), 'notice' => 1, 'p' => $p));
        } else {
            RC_Cache::app_cache_delete('wechat_blackuser_position_' . $wechat_id, 'wechat');
            RC_Cache::app_cache_delete('wechat_blackuser_list_' . $wechat_id, 'wechat');

            ecjia_admin::admin_log(RC_Lang::get('wechat::wechat.get_user_info'), 'setup', 'users_info');
            return $this->showmessage(RC_Lang::get('wechat::wechat.get_userinfo_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/platform_subscribe/back_list', array('action' => 'get_list'))));
        }
    }

    //用户消息记录
    public function subscribe_message()
    {
        $this->admin_priv('wechat_subscribe_message_manage');

        $wechat_id = $this->platformAccount->getAccountID();
        $account_name = $this->platformAccount->getAccountName();
        $this->assign('account_name', $account_name);

        $page = !empty($_GET['page']) ? intval($_GET['page']) : 1;
        $this->assign('ur_here', RC_Lang::get('wechat::wechat.user_message_record'));

        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.user_message_record')));
        $this->assign('action_link', array('text' => RC_Lang::get('wechat::wechat.subscribe_manage'), 'href' => RC_Uri::url('wechat/platform_subscribe/init', array('page' => $page))));

        if (is_ecjia_error($wechat_id)) {
            $this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
        } else {
            $this->assign('warn', 'warn');

            //获取公众号类型 0未认证 1订阅号 2服务号 3认证服务号 4企业号
            $type = $this->platformAccount->getType();
            $this->assign('type', $type);
            $this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.notice_certification_info'), RC_Lang::get('wechat::wechat.wechat_type.' . $type)));

            $tag_arr['item'] = RC_DB::table('wechat_tag')
                ->select('id', 'tag_id', 'name', 'count')
                ->where('wechat_id', $wechat_id)
                ->orderBy('id', 'desc')
                ->where('sort', 'desc')
                ->get();

            $this->assign('tag_arr', $tag_arr);

            $uid = !empty($_GET['uid']) ? intval($_GET['uid']) : 0;
            $this->assign('chat_action', RC_Uri::url('wechat/platform_subscribe/send_message'));
            $this->assign('last_action', RC_Uri::url('wechat/platform_subscribe/read_message'));
            $this->assign('label_action', RC_Uri::url('wechat/platform_subscribe/batch'));
            $this->assign('get_checked', RC_Uri::url('wechat/platform_subscribe/get_checked_tag'));

            if (empty($uid)) {
                return $this->showmessage(RC_Lang::get('wechat::wechat.pls_select_user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            $info = RC_DB::table('wechat_user as u')
                ->leftJoin('users as us', RC_DB::raw('us.user_id'), '=', RC_DB::raw('u.ect_uid'))
                ->select(RC_DB::raw('u.*'), RC_DB::raw('us.user_name'))
                ->where(RC_DB::raw('u.uid'), $uid)
                ->where(RC_DB::raw('u.wechat_id'), $wechat_id)
                ->first();

            if (!empty($info)) {
                if ($info['subscribe_time']) {
                    $info['subscribe_time'] = RC_Time::local_date(ecjia::config('time_format'), $info['subscribe_time'] - 8 * 3600);
                }
                $tag_list = RC_DB::table('wechat_user_tag')->where('userid', $info['uid'])->lists('tagid');

                $name_list = RC_DB::table('wechat_tag')
                    ->where('tag_id', $tag_list)
                    ->where('wechat_id', $wechat_id)
                    ->orderBy('tag_id', 'desc')
                    ->lists('name');

                if (!empty($name_list)) {
                    $info['tag_name'] = implode('，', $name_list);
                }
            }
            $this->assign('info', $info);
            $message = $this->get_message_list();
            $this->assign('message', $message);

            //最后发送时间
            $last_send_time = RC_DB::table('wechat_custom_message')
                ->where('uid', $uid)
                ->where('iswechat', 0)
                ->orderBy('id', 'desc')
                ->take(1)
                ->pluck('send_time');

            $time = RC_Time::gmtime();
            if ($time - $last_send_time > 48 * 3600) {
                $this->assign('disabled', '1');
            }
        }
        $this->display('wechat_subscribe_message.dwt');
    }

    //获取信息
    public function read_message()
    {
        $this->admin_priv('wechat_subscribe_message_manage', ecjia::MSGTYPE_JSON);

        $list = $this->get_message_list();
        $message = count($list['item']) < 10 ? RC_Lang::get('wechat::wechat.no_more_message') : RC_Lang::get('wechat::wechat.searched');
        if (!empty($list['item'])) {
            foreach ($list['item'] as $k => $v) {
                if ($v['type'] != 'text') {
                    $this->assign('type', $v['type']);
                    if ($v['type'] == 'voice') {
                        $v['media_content']['img_url'] = RC_App::apps_url('statics/images/voice.png', __FILE__);
                    }
                    if ($v['type'] == 'video') {
                        $v['media_content']['img_url'] = RC_App::apps_url('statics/images/video.png', __FILE__);
                    }
                    $this->assign('media_content', $v['media_content']);
                    $list['item'][$k]['media_content_html'] = $this->fetch('library/wechat_subscribe_message.lbi');
                }
            }
            return $this->showmessage($message, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('msg_list' => $list['item'], 'last_id' => $list['last_id']));
        } else {
            return $this->showmessage($message, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    //发送信息
    public function send_message()
    {
        $this->admin_priv('wechat_subscribe_message_add', ecjia::MSGTYPE_JSON);

        $openid = $this->request->input('openid');
        $msg = $this->request->input('message');
        $uid = $this->request->input('uid');
        $media_id = $this->request->input('media_id');

        if (empty($openid)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.pls_select_user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (empty($media_id) && empty($msg)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.message_content_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $model = \Ecjia\App\Wechat\Models\WechatCustomMessageModel::where('uid', $uid)->where('iswechat', 0)->orderBy('send_time', 'DESC')->first();
        if (!empty($model) && (RC_Time::gmtime() - $model->send_time) > 48 * 3600) {
            return $this->showmessage('由于该用户48小时未与你互动，你不能再主动发消息给他。直到用户下次主动发消息给你才可以对其进行回复。', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        try {
            $wechat_id = $this->platformAccount->getAccountID();
            $uuid = $this->platformAccount->getUUID();
            $wechat = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();

            if ($media_id) {
                with(new Ecjia\App\Wechat\Sends\SendCustomMessage($wechat, $wechat_id, $openid))->sendMediaMessage($media_id);
            } else {
                with(new Ecjia\App\Wechat\Sends\SendCustomMessage($wechat, $wechat_id, $openid))->sendTextMessage($msg);
            }

            ecjia_admin::admin_log($msg, 'send', 'subscribe_message');
            return $this->showmessage(RC_Lang::get('wechat::wechat.send_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('send_time' => RC_Time::local_date(ecjia::config('time_format'), RC_Time::gmtime())));

        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    public function edit_remark()
    {
        $this->admin_priv('wechat_subscribe_update', ecjia::MSGTYPE_JSON);

        $uuid = $this->platformAccount->getUUID();
        $wechat_id = $this->platformAccount->getAccountID();

        $wechat = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();

        if (is_ecjia_error($wechat_id)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.add_platform_first'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        // 数据更新
        $remark = !empty($_POST['remark']) ? trim($_POST['remark']) : '';
        $openid = !empty($_POST['openid']) ? trim($_POST['openid']) : '';
        $page = !empty($_POST['page']) ? intval($_POST['page']) : 1;
        $uid = !empty($_POST['uid']) ? intval($_POST['uid']) : 0;

        if (strlen($remark) > 30) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.up_remark_count'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $info = RC_DB::table('wechat_user')->where('openid', $openid)->where('wechat_id', $wechat_id)->first();

        try {
            //微信端更新
            $wechat->user->remark($openid, $remark);
        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $data = array('remark' => $remark);
        RC_DB::table('wechat_user')->where('openid', $openid)->where('wechat_id', $wechat_id)->update($data);

        ecjia_admin::admin_log(sprintf(RC_Lang::get('wechat::wechat.edit_remark_to'), $info['nickname'], $remark), 'edit', 'users_info');
        return $this->showmessage(RC_Lang::get('wechat::wechat.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/platform_subscribe/subscribe_message', array('uid' => $uid, 'page' => $page))));
    }

    //添加/移出黑名单
    public function black_user()
    {
        $this->admin_priv('wechat_subscribe_update', ecjia::MSGTYPE_JSON);

        $uuid = $this->platformAccount->getUUID();
        $wechat_id = $this->platformAccount->getAccountID();

        if (is_ecjia_error($wechat_id)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.add_platform_first'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $wechat = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();

        $type = !empty($_GET['type']) ? trim($_GET['type']) : '';
        $page = !empty($_GET['page']) ? intval($_GET['page']) : 1;
        $openid = !empty($_GET['openid']) ? trim($_GET['openid']) : '';
        $uid = !empty($_GET['uid']) ? trim($_GET['uid']) : '';
        $from = !empty($_GET['from']) ? trim($_GET['from']) : '';

        if ($type == 'remove_out') {
            $data['group_id'] = 0;
            $sn = RC_Lang::get('wechat::wechat.remove_blacklist');
            $success_msg = RC_Lang::get('wechat::wechat.remove_blacklist_success');
            $error_msg = RC_Lang::get('wechat::wechat.remove_blacklist_error');
        } else {
            $data['group_id'] = 1;
            $sn = RC_Lang::get('wechat::wechat.add_blacklist');
            $success_msg = RC_Lang::get('wechat::wechat.add_blacklist_success');
            $error_msg = RC_Lang::get('wechat::wechat.add_blacklist_error');
        }

        try {
            //微信端更新
            $rs = $wechat->user_tag->batchBlackUsers(array($openid));
        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        ecjia_admin::admin_log($sn, 'setup', 'users_info');
        RC_DB::table('wechat_user')->where('openid', $openid)->where('wechat_id', $wechat_id)->update($data);

//         $this->get_user_tags();
        $pjaxurl = RC_Uri::url('wechat/platform_subscribe/subscribe_message', array('uid' => $uid, 'page' => $page));
        if ($from == 'list') {
            $pjaxurl = RC_Uri::url('wechat/platform_subscribe/init', array('page' => $page));
        }
        return $this->showmessage($success_msg, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $pjaxurl));
    }

    public function unblack_user()
    {
        $this->admin_priv('wechat_subscribe_update', ecjia::MSGTYPE_JSON);

        $uuid = $this->platformAccount->getUUID();
        $wechat_id = $this->platformAccount->getAccountID();

        if (is_ecjia_error($wechat_id)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.add_platform_first'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $wechat = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();

        $openid = !empty($_GET['openid']) ? trim($_GET['openid']) : '';

        $data['group_id'] = 0;
        $sn = RC_Lang::get('wechat::wechat.remove_blacklist');
        $success_msg = RC_Lang::get('wechat::wechat.remove_blacklist_success');
        $error_msg = RC_Lang::get('wechat::wechat.remove_blacklist_error');

        try {
            //微信端更新
            $rs = $wechat->user_tag->batchUnblackUsers(array($openid));
        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        ecjia_admin::admin_log($sn, 'setup', 'users_info');
        RC_DB::table('wechat_user')->where('openid', $openid)->where('wechat_id', $wechat_id)->update($data);

        return $this->showmessage($success_msg, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/platform_subscribe/back_list')));
    }

    //获取消息列表
    public function get_message_list()
    {
        $db_custom_message = RC_DB::table('wechat_custom_message as m')
            ->leftJoin('wechat_user as wu', RC_DB::raw('wu.uid'), '=', RC_DB::raw('m.uid'));

        $wechat_id = $this->platformAccount->getAccountID();
        $platform_name = $this->platformAccount->getAccountName();

        $uid = !empty($_GET['uid']) ? intval($_GET['uid']) : 0;
        $last_id = !empty($_GET['last_id']) ? intval($_GET['last_id']) : 0;
        $chat_id = !empty($_GET['chat_id']) ? intval($_GET['chat_id']) : 0;

        if (!empty($last_id)) {
            $db_custom_message->where(RC_DB::raw('m.uid'), $chat_id)->where(RC_DB::raw('m.id'), '<', $last_id);
        } else {
            $db_custom_message->where(RC_DB::raw('m.uid'), $uid);
        }
        $count = $db_custom_message->count();

        $page = new ecjia_platform_page($count, 10, 5);
        $list = $db_custom_message->select(RC_DB::raw('m.*'), RC_DB::raw('wu.nickname'))->orderBy(RC_DB::raw('m.id'), 'desc')->take(10)->skip($page->start_id - 1)->get();

        if (!empty($list)) {
            foreach ($list as $key => $val) {
                $list[$key]['send_time'] = RC_Time::local_date(ecjia::config('time_format'), $val['send_time']);
                if (!empty($val['iswechat'])) {
                    $list[$key]['nickname'] = $platform_name;
                }
                $list[$key]['media_content'] = unserialize($val['media_content']);
                if ($val['type'] == 'voice') {
                    $list[$key]['media_content']['img_url'] = RC_App::apps_url('statics/images/voice.png', __FILE__);
                }

                if ($val['type'] == 'video') {
                    $list[$key]['media_content']['img_url'] = RC_App::apps_url('statics/images/video.png', __FILE__);
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

    //批量操作
    public function batch()
    {
        $uuid = $this->platformAccount->getUUID();

        $wechat_id = $this->platformAccount->getAccountID();

        if (is_ecjia_error($wechat_id)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.add_platform_first'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $wechat = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();

        $action = !empty($_GET['action']) ? $_GET['action'] : '';
        $uid = !empty($_POST['uid']) ? $_POST['uid'] : '';
        $openid = !empty($_POST['openid']) ? $_POST['openid'] : '';
        $tag_id = !empty($_POST['tag_id']) ? $_POST['tag_id'] : '';

        if (count($tag_id) > 3) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.up_tag_count'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $openid_list = explode(',', $openid);
        $tag = array();
        $openids_no_tag = $openids_tag = array();

        foreach ($openid_list as $k => $v) {
            $tag = RC_DB::table('wechat_user as u')
                ->leftJoin('wechat_user_tag as ut', RC_DB::raw('ut.userid'), '=', RC_DB::raw('u.uid'))
                ->select(RC_DB::raw('ut.tagid'), RC_DB::raw('u.uid'), RC_DB::raw('u.openid'))
                ->where(RC_DB::raw('u.openid'), $v)
                ->where(RC_DB::raw('u.wechat_id'), $wechat_id)
                ->get();

            foreach ($tag as $key => $val) {
                if (empty($val['tagid'])) {
                    //没有标签的用户
                    $openids_no_tag['openid'][] = $val['openid'];
                    $openids_no_tag['uid'][] = $val['uid'];
                } else {
                    //有标签的用户
                    $openids_tag['openid'][] = $val['openid'];
                    $openids_tag['uid'][] = $val['uid'];
                    $openids_tag['tagid'][] = $val['tagid'];
                }
            }
        }

        try {
            if (!empty($openids_no_tag)) {
                //添加用户标签
                if (!empty($tag_id)) {
                    foreach ($tag_id as $v) {
                        $wechat->user_tag->batchTagUsers($openids_no_tag['openid'], $v);
                        foreach ($openids_no_tag['uid'] as $val) {
                            RC_DB::table('wechat_user_tag')->insert(array('userid' => $val, 'tagid' => $v));
                        }
                    }
                }
            }

            //取消用户标签
            if (!empty($openids_tag['tagid'])) {
                foreach ($openids_tag['tagid'] as $k => $v) {
                    if (!empty($openids_tag['openid'])) {
                        $wechat->user_tag->batchUntagUsers($openids_tag['openid'], $v);
                    }
                }
                if (!empty($openids_tag['uid'])) {
                    RC_DB::table('wechat_user_tag')->whereIn('userid', $openids_tag['uid'])->delete();
                }

                if (!empty($tag_id)) {
                    foreach ($tag_id as $v) {
                        $wechat->user_tag->batchTagUsers($openids_tag['openid'], $v);
                        foreach ($openids_tag['uid'] as $val) {
                            RC_DB::table('wechat_user_tag')->insert(array('userid' => $val, 'tagid' => $v));
                        }
                    }
                }
            }
        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $this->get_user_tags();
        if ($action == 'set_label') {
            $url = RC_Uri::url('wechat/platform_subscribe/init', array('type' => 'all'));
        } elseif ($action == 'set_user_label') {
            $url = RC_Uri::url('wechat/platform_subscribe/subscribe_message', array('uid' => $uid));
        }
        return $this->showmessage(RC_Lang::get('wechat::wechat.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $url));
    }

    //获取选择用户的标签
    public function get_checked_tag()
    {
        $wechat_id = $this->platformAccount->getAccountID();

        $uid = !empty($_POST['uid']) ? intval($_POST['uid']) : '';
        $tag_arr = RC_DB::table('wechat_tag')
            ->select('id', 'tag_id', 'name', 'count')
            ->where('wechat_id', $wechat_id)
            ->orderBy('id', 'desc')
            ->where('sort', 'desc')
            ->get();

        $user_tag_list = array();
        if (!empty($uid)) {
            $user_tag_list = RC_DB::table('wechat_user_tag')->where('userid', $uid)->lists('tagid');

            if (empty($user_tag_list)) {
                $user_tag_list = array();
            }
        }
        foreach ($tag_arr as $k => $v) {
            if (in_array($v['tag_id'], $user_tag_list)) {
                $tag_arr[$k]['checked'] = 1;
            }
            if ($v['tag_id'] == 1) {
                unset($tag_arr[$k]);
            }
        }
        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $tag_arr));
    }

    public function tag()
    {
        $this->admin_priv('wechat_subscribe_manage');

        ecjia_platform_screen::get_current_screen()->remove_last_nav_here();
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here('标签管理'));

        $wechat_id = $this->platformAccount->getAccountID();

        $count = RC_DB::table('wechat_tag')->where('wechat_id', $wechat_id)->count();
        $page = new ecjia_platform_page($count, 10, 5);
        $data = RC_DB::table('wechat_tag')->select('id', 'tag_id', 'name', 'count')->where('wechat_id', $wechat_id)->orderBy('id', 'desc')->take(10)->skip($page->start_id - 1)->get();

        $list = array('item' => $data, 'page' => $page->show(5), 'desc' => $page->page_desc());
        $this->assign('list', $list);

        $this->assign('ur_here', '标签管理');
        $this->assign('action_link', array('text' => '添加标签', 'href' => 'javascript:;'));

        if (is_ecjia_error($wechat_id)) {
            $this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
        } else {
            $this->assign('warn', 'warn');

            //获取公众号类型 0未认证 1订阅号 2服务号 3认证服务号 4企业号
            $types = $this->platformAccount->getType();
            $this->assign('type', $types);
            $this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.notice_certification_info'), RC_Lang::get('wechat::wechat.wechat_type.' . $types)));
        }

        $this->display('wechat_subscribe_tag.dwt');
    }

    //已取消关注列表
    public function cancel_list()
    {
        $this->admin_priv('wechat_subscribe_manage');

        ecjia_platform_screen::get_current_screen()->remove_last_nav_here();
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here('取消关注'));

        $this->assign('ur_here', '取消关注');
        $this->assign('form_action', RC_Uri::url('wechat/platform_subscribe/cancel_list'));

        $wechat_id = $this->platformAccount->getAccountID();
        //微信id、type、关键字
        $where = "u.wechat_id = $wechat_id";
        $type = isset($_GET['type']) ? $_GET['type'] : 'all';
        $keywords = isset($_GET['keywords']) ? trim($_GET['keywords']) : '';

        //关键字搜索
        if (!empty($keywords)) {
            $where .= ' and (u.nickname like "%' . $keywords . '%" or u.province like "%' . $keywords . '%" or u.city like "%' . $keywords . '%")';
        }

        $where .= " and u.subscribe = 0 and u.group_id = 0";
        //用户列表
        $total = RC_DB::table('wechat_user as u')->whereRaw($where)->count();
        $page = new ecjia_platform_page($total, 10, 5);

        $list = RC_DB::table('wechat_user as u')
            ->leftJoin('users as us', RC_DB::raw('us.user_id'), '=', RC_DB::raw('u.ect_uid'))
            ->select(RC_DB::raw('u.*'), RC_DB::raw('us.user_name'))
            ->whereRaw($where)
            ->orderBy(RC_DB::raw('u.subscribe_time'), 'desc')
            ->take(10)
            ->skip($page->start_id - 1)
            ->get();

        if (!empty($list)) {
            foreach ($list as $k => $v) {
                //假如不是黑名单
                if ($v['group_id'] != 1) {
                    $tag_list = RC_DB::table('wechat_user_tag')->where('userid', $v['uid'])->lists('tagid');
                    $db_wechat_tag = RC_DB::table('wechat_tag');
                    $name_list = [];
                    if (!empty($tag_list)) {
                        $name_list = $db_wechat_tag->whereIn('tag_id', $tag_list)->where('wechat_id', $wechat_id)->orderBy('tag_id', 'desc')->lists('name');
                    }
                    if (!empty($name_list)) {
                        $list[$k]['tag_name'] = implode('，', $name_list);
                    }
                }
            }
        }
        $arr = array('item' => $list, 'page' => $page->show(5), 'desc' => $page->page_desc());
        $this->assign('list', $arr);

        $this->display('wechat_unsubscribe_list.dwt');
    }

    public function back_list()
    {
        $this->admin_priv('wechat_subscribe_manage');

        ecjia_platform_screen::get_current_screen()->remove_last_nav_here();
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here('黑名单'));

        $this->assign('ur_here', '黑名单');
        $this->assign('form_action', RC_Uri::url('wechat/platform_subscribe/back_list'));

        $wechat_id = $this->platformAccount->getAccountID();
        //微信id、type、关键字
        $where = "u.wechat_id = $wechat_id";
        $type = isset($_GET['type']) ? $_GET['type'] : 'all';
        $keywords = isset($_GET['keywords']) ? trim($_GET['keywords']) : '';

        //关键字搜索
        if (!empty($keywords)) {
            $where .= ' and (u.nickname like "%' . $keywords . '%" or u.province like "%' . $keywords . '%" or u.city like "%' . $keywords . '%")';
        }

        $where .= " and u.subscribe = 1 and u.group_id = 1";
        //用户列表
        $total = RC_DB::table('wechat_user as u')->whereRaw($where)->count();
        $page = new ecjia_platform_page($total, 10, 5);

        $list = RC_DB::table('wechat_user as u')
            ->leftJoin('users as us', RC_DB::raw('us.user_id'), '=', RC_DB::raw('u.ect_uid'))
            ->select(RC_DB::raw('u.*'), RC_DB::raw('us.user_name'))
            ->whereRaw($where)
            ->orderBy(RC_DB::raw('u.subscribe_time'), 'desc')
            ->take(10)
            ->skip($page->start_id - 1)
            ->get();

        if (!empty($list)) {
            foreach ($list as $k => $v) {
                if ($v['group_id'] == 1) {
                    $tag_list = RC_DB::table('wechat_user_tag')->where('userid', $v['uid'])->lists('tagid');
                    $db_wechat_tag = RC_DB::table('wechat_tag');
                    $name_list = [];
                    if (!empty($tag_list)) {
                        $name_list = $db_wechat_tag->whereIn('tag_id', $tag_list)->where('wechat_id', $wechat_id)->orderBy('tag_id', 'desc')->lists('name');
                    }
                    if (!empty($name_list)) {
                        $list[$k]['tag_name'] = implode('，', $name_list);
                    }
                }
            }
        }
        $arr = array('item' => $list, 'page' => $page->show(5), 'desc' => $page->page_desc());
        $this->assign('list', $arr);

        $this->display('wechat_black_list.dwt');
    }

    //获取用户标签
    private function get_user_tags()
    {
        $uuid = $this->platformAccount->getUUID();

        $wechat_id = $this->platformAccount->getAccountID();

        if (is_ecjia_error($wechat_id)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.add_platform_first'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        try {
            $wechat = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();
            $list = $wechat->user_tag->lists()->toArray();
            if (!empty($list['tags'])) {
                RC_DB::table('wechat_tag')->where('wechat_id', $wechat_id)->delete();

                foreach ($list['tags'] as $key => $val) {
                    $data['wechat_id'] = $wechat_id;
                    $data['tag_id'] = $val['id'];
                    $data['name'] = $val['name'] == RC_Lang::get('wechat::wechat.star_group') ? RC_Lang::get('wechat::wechat.star_user') : $val['name'];
                    $data['count'] = $val['count'];
                    RC_DB::table('wechat_tag')->insert($data);
                }
            }
            return true;
        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

}

//end
