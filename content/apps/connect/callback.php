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
        $connect_code = $this->request->query('connect_code');
        if (empty($connect_code)) {
            $link[] = array('text' => RC_Lang::get('system::system.go_back'), 'href' => 'javascript:history.back(-1)');
            return $this->showmessage(RC_Lang::get('connect::connect.not_found'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => $link));
        }
        
        $user_type = $this->request->query('user_type', 'user');
        
        $connect_handle = with(new \Ecjia\App\Connect\ConnectPlugin)->channel($connect_code);
        
        $connect_user = $connect_handle->callback($user_type);
        
        if (is_ecjia_error($connect_user)) {
            $result['connect_user'] = $connect_user;
            $templateStr = RC_Hook::apply_filters(sprintf("connect_callback_%s_template", $user_type), $templateStr, $result);
            //echo 内容
            return $this->displayContent($this->fetch_string($templateStr));
        } else { 
            RC_Logger::getlogger('wechat')->info('callback connect_user user_id:'.$connect_user->getUserId());
            if ($connect_user->checkUser()) {
                $this->userBindedProcessHandle($user_type, $connect_user);
            } else {
                //绑定账号
                $result['bind_url']  = RC_Uri::url('connect/callback/bind_login', array('connect_code' => $connect_code, 'open_id' => $connect_user->getOpenId()));
                //注册登录
                $result['login_url'] = RC_Uri::url('connect/callback/bind_signup', array('connect_code' => $connect_code, 'open_id' => $connect_user->getOpenId()));
                
                $result['connect_user'] = $connect_user;
                
                $templateStr = RC_Hook::apply_filters(sprintf("connect_callback_%s_template", $connect_user->getUserType()), $templateStr, $result);
                //echo 内容
                return $this->displayContent($this->fetch_string($templateStr));
            } 
        }
    }
    
    /**
     * 绑定注册
     */
    public function bind_signup() {
        $user_type = $this->request->query('user_type', 'user');
        $connect_code   = $this->request->query('connect_code');
        $open_id        = $this->request->query('open_id');
        
        $connect_user = new Ecjia\App\Connect\ConnectUser($connect_code, $open_id, $user_type);
        //判断已绑定授权登录用户 直接登录
        if ($connect_user->checkUser()) {
            $this->userBindedProcessHandle($user_type, $connect_user);
        } else {
            //新用户注册并登录
            $username = $connect_user->getGenerateUserName();
            $password = $connect_user->getGeneratePassword();
            $email    = $connect_user->getGenerateEmail();
            
            $user_id = RC_Hook::apply_filters(sprintf("connect_callback_%s_bind_signup", $connect_user->getUserType()), 0, $username, $password, $email);
            $result  = $connect_user->bindUser($user_id);
            
            /**
             * 用户绑定完成后的结果判断处理，用于界面显示 
             * @param $result boolean 判断执行成功与否
             */
            RC_Hook::do_action(sprintf("connect_callback_%s_bind_complete", $connect_user->getUserType()), $result);
        }
    }
    
    /**
     * 绑定登录界面
     */
    public function bind_login() {
        $user_type = $this->request->query('user_type', 'user');
        
        $action_link = RC_Uri::url('connect/callback/bind_signin', array('connect_code' => $_GET['connect_code'], 'open_id' => $_GET['open_id']));
        $this->assign('action_link', $action_link);
        
        $templateStr = RC_Hook::apply_filters(sprintf("connect_callback_%s_signin_template", $user_type), $templateStr);
        //echo 内容
        return $this->displayContent($this->fetch_string($templateStr));
    }
    
    /**
     * 绑定登录
     */
    public function bind_signin() {
        $user_type      = $this->request->query('user_type', 'user');
        $return         = $this->request->query('return');
        $connect_code   = $this->request->query('connect_code');
        $open_id        = $this->request->query('open_id');
        
        $username       = $this->request->input('username');
        $password       = $this->request->input('password');
        
        $connect_user = new Ecjia\App\Connect\ConnectUser($connect_code, $open_id, $user_type);

        //判断已绑定授权登录用户 直接登录
        if ($connect_user->checkUser()) {
            $this->userBindedProcessHandle($user_type, $connect_user);
        } else {
            /**
             * 登录用户绑定
             */
            $user_id = RC_Hook::apply_filters(sprintf("connect_callback_%s_bind_signin", $user_type), 0, $username, $password);
            if ($user_id) {
                $result = $connect_user->bindUser($user_id);
            } else {
                $result = false;
            }

            /**
             * 用户绑定完成后的结果判断处理，用于界面显示
             * @param $result boolean 判断执行成功与否
             */
            RC_Hook::do_action(sprintf("connect_callback_%s_bind_complete", $connect_user->getUserType()), $result);
        }
    }
    
    /**
     * 判断已绑定授权登录用户 直接登录
     */
    protected function userBindedProcessHandle($user_type, $user_id, $connect_user)
    {
        /**
         * 用户登录
         * hook名称有三个：connect_callback_user_signin、connect_callback_merchant_signin、connect_callback_admin_signin
         */
        RC_Hook::do_action(sprintf("connect_callback_%s_signin", $user_type), $user_id, $connect_user);
    }
}

// end