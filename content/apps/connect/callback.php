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
 * 第三方登录回调处理
 */
class callback extends ecjia_front {
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * 返回值参考
     * open_id       唯一标示
     * username     昵称
     */
    public function init() {
    	if (isset($_COOKIE['h5_index'])) {
    		header("location: ".RC_Uri::url('touch/index/init'));exit();
    	}
        $connect_code = $_GET['connect_code'];
        unset($_GET['connect_code']);
        if (empty($connect_code)) {
            $link[] = array('text' => RC_Lang::get('system::system.go_back'), 'href' => 'javascript:history.back(-1)');
            return $this->showmessage(RC_Lang::get('connect::connect.not_found'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => $link));
        }
        $connect_method = RC_Loader::load_app_class('connect_method', 'connect');
        $connect_handle = $connect_method->get_connect_instance($connect_code);
        $result         = $connect_handle->callback();
        
        if (!is_ecjia_error($result)) {
            RC_Loader::load_app_class('connect_user', 'connect', false);
            $connect_user = new connect_user($result['connect_code'], $result['open_id']);
            if ($connect_user->check_openid_exist() && $connect_user->user_id) {
                if ($connect_user->is_admin == 1) {
                    RC_Hook::do_action('connect_callback_admin_signin', $connect_user->user_id);
                } else {
                    //普通用户登录
                    RC_Hook::do_action('connect_callback_user_signin', $connect_user->user_id);
                }
            } else {
                //绑定账号
                $result['bind_url']  = RC_Uri::url('connect/callback/bind_login', array('connect_code' => $connect_code, 'open_id' => $result['open_id']));
                //注册登录
                $result['login_url'] = RC_Uri::url('connect/callback/bind_signup', array('connect_code' => $connect_code, 'open_id' => $result['open_id']));
                
                $string = RC_Hook::apply_filters('connect_callback_template', $result);
                echo $this->fetch_string($string);
            } 
        } else {
            $string = RC_Hook::apply_filters('connect_callback_template', $result);
            echo $this->fetch_string($string);
        }
    }
    
    /**
     * 绑定注册
     */
    public function bind_signup() {
        $connect_code   = $_GET['connect_code'];
        $open_id        = $_GET['open_id'];
        RC_Loader::load_app_class('connect_user', 'connect', false);
        $connect_user = new connect_user($connect_code, $open_id);
        //判断已绑定授权登录用户 直接登录
        if ($connect_user->check_openid_exist() && $connect_user->user_id) {
            if ($connect_user->is_admin == 1) {
                RC_Hook::do_action('connect_callback_admin_signin', $connect_user->user_id);
            } else {
                //普通用户登录
                RC_Hook::do_action('connect_callback_user_signin', $connect_user->user_id);
            }
        } else {
            //新用户注册并登录
            $username = $connect_user->get_username();
            $password = md5(rc_random(9, 'abcdefghijklmnopqrstuvwxyz0123456789'));
            $email    = $connect_user->get_email();
            $user_id = RC_Hook::apply_filters('connect_callback_bind_signup', 0, $username, $password, $email);
            $result  = $connect_user->bind_user($user_id, 0);
            if ($result) {
//               return $this->redirect(RC_Uri::url('touch/my/init'));
              header("location: ".RC_Uri::url('touch/my/init'));exit();
            } else {
                $link[] = array('text' => RC_Lang::get('system::system.go_back'), 'href' => 'javascript:history.back(-1)');
                return $this->showmessage(RC_Lang::get('connect::connect.regist_fail'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => $link));
            }
        }
    }
    
    /**
     * 绑定登录界面
     */
    public function bind_login() {
        $action_link = RC_Uri::url('connect/callback/bind_signin', array('connect_code' => $_GET['connect_code'], 'open_id' => $_GET['open_id']));
        $this->assign('action_link', $action_link);
        $this->assign('action_link_ajax', $action_link . '&return=ajax');
        $string = RC_Hook::apply_filters('connect_callback_signin_template', $_GET);
        echo $this->fetch_string($string);
    }
    
    /**
     * 绑定登录
     */
    public function bind_signin() {
        $return         = $_GET['return'];
        $connect_code   = $_GET['connect_code'];
        $open_id        = $_GET['open_id'];
        
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        RC_Loader::load_app_class('connect_user', 'connect', false);
        $connect_user = new connect_user($connect_code, $open_id);

        //判断已绑定授权登录用户 直接登录
        if ($connect_user->check_openid_exist() && $connect_user->user_id) {
            if ($connect_user->is_admin == 1) {
                RC_Hook::do_action('connect_callback_admin_signin', $connect_user->user_id);
            } else {
                //普通用户登录
                RC_Hook::do_action('connect_callback_user_signin', $connect_user->user_id);
            }
        } else {
            $user_id = RC_Hook::apply_filters('connect_callback_bind_signin', 0, $username, $password);
            if ($user_id) {
                $result = $connect_user->bind_user($user_id, 0);
            } else {
                $result = false;
            }

            if ($return == 'ajax') {
                if ($result) {
                    $link[] = array(RC_Lang::get('connect::connect.back_member'), 'href' => RC_Uri::url('touch/my/init'));
                    return $this->showmessage(RC_Lang::get('connect::connect.bind_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $link));
                } else {
                    $link[] = array('text' => RC_Lang::get('system::system.go_back'), 'href' => 'javascript:history.back(-1)');
                    return $this->showmessage(RC_Lang::get('connect::connect.bind_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('links' => $link));
                }
            } else {
                if ($result) {
                   return $this->redirect(RC_Uri::url('touch/my/init'));
                } else {
                    $link[] = array('text' => RC_Lang::get('system::system.go_back'), 'href' => 'javascript:history.back(-1)');
                    return $this->showmessage(RC_Lang::get('connect::connect.bind_fail'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => $link));
                }
            }
        }
    }
}

// end