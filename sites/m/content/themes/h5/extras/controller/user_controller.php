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
 * 会员中心模块控制器代码
 */
RC_Loader::load_app_class('integrate', 'user', false);

class user_controller
{
    /**
     * 会员中心欢迎页
     */
    public static function init()
    {
        $user_img = RC_Theme::get_template_directory_uri() . '/images/user_center/icon-login-in2x.png';
        $signin   = ecjia_touch_user::singleton()->isSignin();

        $token             = ecjia_touch_user::singleton()->getToken();
        $signup_reward_url = RC_Uri::url('market/mobile_reward/init', array('token' => $token));

        if ($signin) {
            $user = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->data(array('token' => $token))->run();
            $user = is_ecjia_error($user) ? array() : $user;
            if ($user) {
                if (!empty($user['avatar_img'])) {
                    $user_img = $user['avatar_img'];
                }
                ecjia_front::$controller->assign('order_num', $user['order_num']);
                ecjia_front::$controller->assign('user', $user);
            } else {
                ecjia_touch_user::singleton()->signout();
            }
        }

        ecjia_front::$controller->assign('user_img', $user_img);
        ecjia_front::$controller->assign('signup_reward_url', $signup_reward_url);

        //网店信息
        $shop        = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_INFO)->run();
        $shop        = is_ecjia_error($shop) ? array() : $shop;
        $shop_config = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_CONFIG)->run();
        $shop_config = is_ecjia_error($shop_config) ? array() : $shop_config;

        ecjia_front::$controller->assign('shop', $shop);
        ecjia_front::$controller->assign('shop_config', $shop_config);

        $config = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_CONFIG)->run();
        if (!is_ecjia_error($config)) {
            ecjia_front::$controller->assign('merchant_join_close', $config['merchant_join_close']);
        }

        ecjia_front::$controller->assign('active', 'mine');
        ecjia_front::$controller->assign_title('个人中心');

        $login_str = user_function::return_login_str();
        ecjia_front::$controller->assign('login_url', RC_Uri::url($login_str));

        ecjia_front::$controller->display('user.dwt');
    }

    /**
     * 推广页面
     */
    public static function spread()
    {
        $token     = ecjia_touch_user::singleton()->getToken();
        $user_info = ecjia_touch_user::singleton()->getUserinfo();

        $cache_id = $_SERVER['QUERY_STRING'] . '-' . $token . '-' . $user_info['id'] . '-' . $user_info['name'];
        $cache_id = sprintf('%X', crc32($cache_id));

        if (!ecjia_front::$controller->is_cached('spread.dwt', $cache_id)) {
            $name                                 = trim($_GET['name']);
            $invite_user_detail                   = ecjia_touch_manager::make()->api(ecjia_touch_api::INVITE_USER)->data(array('token' => $token))->run();
            $invite_user_detail                   = is_ecjia_error($invite_user_detail) ? array() : $invite_user_detail;
            $invite_user_detail['invite_explain'] = explode("\n", $invite_user_detail['invite_explain']);

            $invite_user_detail['invite_url'] = RC_Uri::url('affiliate/index/init', array('invite_code' => $invite_user_detail['invite_code']));
            ecjia_front::$controller->assign('share_title', $name . '推荐这个实用的App给你~');
            ecjia_front::$controller->assign_title('我的推广');
            ecjia_front::$controller->assign('invite_user', $invite_user_detail);
            ecjia_front::$controller->assign('url', RC_Uri::url('user/index/wxconfig'));

            $image = ecjia::config('mobile_app_icon') != '' ? RC_Upload::upload_url(ecjia::config('mobile_app_icon')) : '';
            ecjia_front::$controller->assign('image', $image);

            if (user_function::is_weixin()) {
                $spread_url = RC_Uri::url('user/index/spread', array('name' => $name));
                $config     = user_function::get_wechat_config($spread_url);

                ecjia_front::$controller->assign('config', $config);
            }

        }
        ecjia_front::$controller->display('spread.dwt', $cache_id);
    }

    public static function wxconfig()
    {
        $url = trim($_POST['url']);
        if (empty($url)) {
            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $uuid = with(new Ecjia\App\Platform\Frameworks\Platform\AccountManager(0))->getDefaultUUID('wechat');
        if (empty($uuid)) {
            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $wechat = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();
        if (empty($wechat)) {
            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $apis = array('onMenuShareTimeline', 'onMenuShareAppMessage', 'onMenuShareQQ');
        $wechat->js->setUrl($url);
        $config = $wechat->js->config($apis, false);
        $config = json_decode($config, true);

        return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('data' => $config));
    }

    public static function sync_avatar($connect_user)
    {
        $user_id = $connect_user->getUserId();
        if (empty($user_id)) {
            return false;
        }

        $token = ecjia_touch_user::singleton()->getToken();
        $user  = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->data(array('token' => $token))->run();

        $user = is_ecjia_error($user) ? array() : $user;
        if (array_get($user, 'avatar_img')) {
            return false;
        }

        $head_img = $connect_user->getUserHeaderImg();
        if ($head_img) {
            RC_Api::api('user', 'update_user_avatar', array('avatar_url' => $head_img, 'user_id' => $user_id));
        }
    }

    public static function follow_list()
    {
        ecjia_front::$controller->assign_title('关注店铺');
        ecjia_front::$controller->display('follow_list.dwt');
    }

    public static function ajax_follow_list()
    {
        $token = ecjia_touch_user::singleton()->getToken();
        $limit = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $page  = intval($_GET['page']) ? intval($_GET['page']) : 1;

        $param = array(
            'token'      => $token,
            'pagination' => array('count' => $limit, 'page' => $page),
            'location'   => array('longitude' => $_COOKIE['longitude'], 'latitude' => $_COOKIE['latitude']),
        );

        $response = ecjia_touch_manager::make()->api(ecjia_touch_api::STORE_COLLECT_LIST)->data($param)->hasPage()->run();
        if (!is_ecjia_error($response)) {
            list($data, $paginated) = $response;
            $data = merchant_function::format_distance($data);

            ecjia_front::$controller->assign('data', $data);
            ecjia_front::$controller->assign_lang();
            $sayList = ecjia_front::$controller->fetch('follow_list.dwt');

            if (isset($paginated['more']) && $paginated['more'] == 0) {
                $data['is_last'] = 1;
            }

            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('list' => $sayList, 'is_last' => $data['is_last']));
        }
    }

    //我的团队
    public static function team_list()
    {
        $title = '我的团队';
        ecjia_front::$controller->assign_title($title);

        $token = ecjia_touch_user::singleton()->getToken();

        $param  = array(
            'token'      => $token,
            'pagination' => array('count' => 10, 'page' => 1),
        );
        $result = ecjia_touch_manager::make()->api(ecjia_touch_api::AFFILIATE_USER_INVITE)->data($param)->hasPage()->run();
        $result = is_ecjia_error($result) ? [] : $result;

        if (!empty($result)) {
            list($data, $page) = $result;
            ecjia_front::$controller->assign('data', $data);
        }

        ecjia_front::$controller->display('personal_reward_team.dwt');
    }

    //获取我的团队
    public static function ajax_team_list()
    {
        $limit = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $pages = intval($_GET['page']) ? intval($_GET['page']) : 1;

        $token = ecjia_touch_user::singleton()->getToken();

        $param  = array(
            'token'      => $token,
            'pagination' => array('count' => $limit, 'page' => $pages),
        );
        $result = ecjia_touch_manager::make()->api(ecjia_touch_api::AFFILIATE_USER_INVITEE)->data($param)->hasPage()->run();
        if (!is_ecjia_error($result)) {
            list($data, $page) = $result;
            if (isset($page['more']) && $page['more'] == 0) {
                $is_last = 1;
            }

            $say_list = '';
            if (!empty($data['list'])) {
                ecjia_front::$controller->assign('list', $data['list']);
            }
            $say_list = ecjia_front::$controller->fetch('personal_reward_team.dwt');

            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('list' => $say_list, 'is_last' => $is_last));
        }
    }
}

// end
