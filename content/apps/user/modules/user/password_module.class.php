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
 * 修改密码
 * @author royalwang
 */
class user_password_module extends api_front implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {

        //如果用户登录获取其session
        $this->authSession();
        $user_id     = $_SESSION['user_id'];
        $api_version = $this->request->header('api-version');
        if ($user_id <= 0) {
            return new ecjia_error(100, __('Invalid session', 'user'));
        }

        //判断用户有没申请注销
        if (version_compare($api_version, '1.25', '>=')) {
            $account_status = Ecjia\App\User\Users::UserAccountStatus($user_id);
            if ($account_status == Ecjia\App\User\Users::WAITDELETE) {
                return new ecjia_error('account_status_error', __('当前账号已申请注销，不可执行此操作！', 'user'));
            }
        }

        $old_password = $this->requestData('password', '');
        $new_password = $this->requestData('new_password', '');
        $code         = $this->requestData('code', '');
        $user_id      = $_SESSION['user_id'];
        $type         = $this->requestData('type', 'use_password');//use_sms,use_password
        $type_array   = array('use_sms', 'use_password');

        if (strlen($new_password) < 6) {
            return new ecjia_error('password_shorter', __('- 登录密码不能少于 6 个字符。', 'user'));
        }

        $user_info = ecjia_integrate::getProfileById($user_id); //论坛记录

        if (version_compare($api_version, '1.14', '<')) {
            if ($old_password == $new_password) {
                return new ecjia_error('password_shorter', __('新密码不能与旧密码相同！', 'user'));
            }

            if (($user_info && (!empty($code) && md5($user_info['user_id'] . ecjia::config('hash_code') . $user_info['reg_time']) == $code))
                || ($_SESSION['user_id'] > 0 && $_SESSION['user_id'] == $user_id && ecjia_integrate::checkUser($_SESSION['user_name'], $old_password))) {

                $username = (empty($code) ? $_SESSION['user_name'] : $user_info['user_name']);

                if (ecjia_integrate::editUser([
                    'username'     => $username,
                    'password'     => $new_password,
                    'old_password' => $old_password,
                ])) {
                    RC_DB::table('users')->where('user_id', $user_id)->update(array('ec_salt' => 0));
                    RC_DB::table('session')->where('user_id', $user_id)->delete();
                    ecjia_integrate::logout();
                    RC_Session::destroy();

                    return array();
                } else {
                    $result = new ecjia_error('edit_password_failure', __('您输入的旧密码不正确！', 'user'));
                }
            } else {
                $result = new ecjia_error('edit_password_failure', __('您输入的旧密码不正确！', 'user'));
            }

            if (is_ecjia_error($result)) {
                return $result;
            }
        } else {
            if (empty($type) || !in_array($type, $type_array)) {
                return new ecjia_error('invalid_parameter', __('参数无效', 'user'));
            }
            if ($type == 'use_sms') {
                $mobile_phone = RC_DB::table('users')->where('user_id', $user_id)->value('mobile_phone');
                if (empty($mobile_phone)) {
                    return new ecjia_error('mobile_unbind', __('请先绑定手机号码！', 'user'));
                }
                if (empty($old_password)) {
                    return new ecjia_error('empty_sms_code', __('请填写验证码', 'user'));
                }
                if (RC_Time::gmtime() > $_SESSION['captcha']['sms']['user_modify_password']['lifetime']) {
                    return new ecjia_error('code_pasted', __('验证码已过期', 'user'));
                }
                if ($old_password != $_SESSION['captcha']['sms']['user_modify_password']['code']) {
                    return new ecjia_error('code_error', __('验证码错误', 'user'));
                }
                if ($mobile_phone != $_SESSION['captcha']['sms']['user_modify_password']['value']) {
                    return new ecjia_error('mobile_error', __('接收和验证的手机号不同', 'user'));
                }
                if (ecjia_integrate::editUser([
                    'username'     => $_SESSION['user_name'],
                    'password'     => $new_password,
                    'old_password' => $old_password,
                ])) {
                    RC_DB::table('users')->where('user_id', $user_id)->update(array('ec_salt' => 0));
                    RC_DB::table('session')->where('user_id', $user_id)->delete();
                    ecjia_integrate::logout();
                    RC_Session::destroy();

                    return array();
                } else {
                    return new ecjia_error('update_password_error', __('修改密码失败！', 'user'));
                }
            } else {
                if ($old_password == $new_password) {
                    return new ecjia_error('password_shorter', __('新密码不能与旧密码相同！', 'user'));
                }
                if (($user_info && (!empty($code) && md5($user_info['user_id'] . ecjia::config('hash_code') . $user_info['reg_time']) == $code))
                    || ($_SESSION['user_id'] > 0 && $_SESSION['user_id'] == $user_id && ecjia_integrate::checkUser($_SESSION['user_name'], $old_password))) {

                    $username = (empty($code) ? $_SESSION['user_name'] : $user_info['user_name']);

                    if (ecjia_integrate::editUser([
                        'username'     => $username,
                        'password'     => $new_password,
                        'old_password' => $old_password,
                    ])) {
                        RC_DB::table('users')->where('user_id', $user_id)->update(array('ec_salt' => 0));
                        RC_DB::table('session')->where('user_id', $user_id)->delete();
                        ecjia_integrate::logout();
                        RC_Session::destroy();

                        return array();
                    } else {
                        $result = new ecjia_error('edit_password_failure', __('您输入的旧密码不正确！', 'user'));
                    }
                } else {
                    $result = new ecjia_error('edit_password_failure', __('您输入的旧密码不正确！', 'user'));
                }

                if (is_ecjia_error($result)) {
                    return $result;
                }
            }
        }
    }
}

// end