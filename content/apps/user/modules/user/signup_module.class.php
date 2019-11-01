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

class user_signup_module extends api_front implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {
        $shop_reg_closed = ecjia::config('shop_reg_closed');
        if ($shop_reg_closed == '1') {
            return new ecjia_error('shop_reg_closed', __('会员注册关闭', 'user'));
        }

        $username      = $this->requestData('name');
        $password      = $this->requestData('password', '');
        $email         = $this->requestData('email');
        $fileld        = $this->requestData('field', array());
        $device        = $this->device;
        $mobile        = $this->requestData('mobile');
        $device_client = isset($device['client']) ? $device['client'] : '';
        $invite_code   = $this->requestData('invite_code');
        $api_version   = $this->request->header('api-version');

        $other   = array();
        $filelds = array();

        foreach ($fileld as $val) {
            $filelds[$val['id']] = $val['value'];
        }
        $other['msn']          = isset($filelds[1]) ? $filelds[1] : '';
        $other['qq']           = isset($filelds[2]) ? $filelds[2] : '';
        $other['office_phone'] = isset($filelds[3]) ? $filelds[3] : '';
        $other['home_phone']   = isset($filelds[4]) ? $filelds[4] : '';
        $other['mobile_phone'] = isset($filelds[5]) ? $filelds[5] : '';

        /* 随机生成6位随机数 + 请求客户端类型作为用户名*/
        $code        = '';
        $charset     = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charset_len = strlen($charset) - 1;
        for ($i = 0; $i < 6; $i++) {
            $code .= $charset[rand(1, $charset_len)];
        }

        if (version_compare($api_version, '1.17', '>=')) {
            if (empty($username) && empty($mobile)) {
                return new ecjia_error('invalid_parameter', __('参数无效', 'user'));
            }
            if (!empty($username) && empty($mobile)) {
                /* 判断是否为手机*/
                $check_mobile = Ecjia\App\Sms\Helper::check_mobile($username);
                if ($check_mobile === true) {
                    /* 设置用户手机号*/
                    $other['mobile_phone'] = $username;
                    $mobile                = $username;
                    $username              = substr_replace($username, '****', 3, 4);
                    if (ecjia_integrate::checkUser($username)) {
                        $username = $username . rand(10, 99);
                    }
                }
            } elseif (empty($username) && !empty($mobile)) {
                /* 判断是否为手机*/
                $check_mobile = Ecjia\App\Sms\Helper::check_mobile($mobile);
                if ($check_mobile === true) {
                    /* 设置用户手机号*/
                    $other['mobile_phone'] = $mobile;

                    $username = substr_replace($mobile, '****', 3, 4);
                    if (ecjia_integrate::checkUser($username)) {
                        $username = $username . rand(10, 99);
                    }
                }
            }
        } else {
            /* 判断是否为手机*/
            $check_mobile = Ecjia\App\Sms\Helper::check_mobile($username);
            if ($check_mobile === true) {
                /* 设置用户手机号*/
                $other['mobile_phone'] = $username;
                $mobile                = $username;
                $username              = $device_client . '_' . $code;
                if (ecjia_integrate::checkUser($username)) {
                    $username = $username . rand(10, 99);
                }
            }
        }

        if (empty($email)) {
            $email = $device_client . '_' . $code . '@mobile.com';
        }

        $other['mobile_phone'] = empty($mobile) ? $other['mobile_phone'] : $mobile;
        $check_mobile          = Ecjia\App\Sms\Helper::check_mobile($other['mobile_phone']);
        if ($check_mobile === true) {
            $mobile_count = RC_DB::table('users')->where('mobile_phone', $other['mobile_phone'])->count();
            if ($mobile_count > 0) {
                return new ecjia_error('user_exists', __('用户已存在！', 'user'));
            }
        } else {
            $other['mobile_phone'] = '';
        }

        $other['last_login'] = RC_Time::gmtime();
        $result = $this->register($username, $password, $email, $other['mobile_phone'], $other, $api_version);

        if (is_ecjia_error($result)) {
            return $result;
        } else {
            /*把新注册用户的扩展信息插入数据库*/
            $fields_arr = RC_DB::table('reg_fields')->select('id')->where('type', 0)->where('display', 1)->orderBy('dis_order', 'asc')->orderBy('id', 'asc')->get();

            $extend_field_str = '';    //生成扩展字段的内容字符串
            if (!empty($fields_arr)) {
                foreach ($fields_arr AS $val) {
                    $extend_field_index = $val['id'];
                    if (!empty($filelds[$extend_field_index])) {
                        $temp_field_content = strlen($filelds[$extend_field_index]) > 100 ? mb_substr($filelds[$extend_field_index], 0, 99) : $filelds[$extend_field_index];
                        $extend_field_str   .= " ('" . $_SESSION['user_id'] . "', '" . $val['id'] . "', '" . $temp_field_content . "'),";
                    }
                }
            }

            $extend_field_str = substr($extend_field_str, 0, -1);
            //插入注册扩展数据
            if ($extend_field_str) {
                $data = array(
                    'user_id'      => $_SESSION['user_id'],
                    'reg_field_id' => $val['id'],
                    'content'      => empty($temp_field_content) ? '' : $temp_field_content
                );
                RC_DB::table('reg_extend_info')->insert($data);
            }

            /*注册送红包*/
            //RC_Api::api('bonus', 'send_bonus', array('type' => SEND_BY_REGISTER));
            /*客户端没传invite_code时，判断手机号码有没被邀请过*/
            if (empty($invite_code)) {
                /*获取邀请记录信息*/
                $is_invitedinfo = RC_DB::table('invitee_record')
                    ->where('invitee_phone', $mobile)
                    ->where('invite_type', 'signup')
                    ->where('expire_time', '>', RC_Time::gmtime())
                    ->first();
                if (!empty($is_invitedinfo)) {
                    /*获取邀请者的邀请码*/
                    $invite_code = RC_DB::table('term_meta')
                        ->where('object_type', 'ecjia.affiliate')
                        ->where('object_group', 'user_invite_code')
                        ->where('meta_key', 'invite_code')
                        ->where('object_id', $is_invitedinfo['invite_id'])
                        ->value('meta_value');
                }
            }
            $result = ecjia_app::validate_application('affiliate');
            if (!is_ecjia_error($result) && !empty($invite_code)) {
                RC_Api::api('affiliate', 'invite_bind', array('invite_code' => $invite_code, 'mobile' => $mobile));
            }

            //ecjia账号同步登录用户信息更新
            $connect_options = [
                'connect_code'  => 'app',
                'user_id'       => $_SESSION['user_id'],
                'is_admin'      => '0',
                'user_type'     => 'user',
                'open_id'       => md5(RC_Time::gmtime() . $_SESSION['user_id']),
                'access_token'  => RC_Session::session_id(),
                'refresh_token' => md5($_SESSION['user_id'] . 'user_refresh_token'),
            ];
            $ecjiaAppUser    = RC_Api::api('connect', 'ecjia_syncappuser_add', $connect_options);
            if (is_ecjia_error($ecjiaAppUser)) {
                return $ecjiaAppUser;
            }

            RC_Loader::load_app_func('admin_user', 'user');
            $user_info = EM_user_info($_SESSION['user_id']);

            $out = array(
                'session' => array(
                    'sid' => RC_Session::session_id(),
                    'uid' => $_SESSION['user_id']
                ),
                'user'    => $user_info
            );

            //修正咨询信息
            if ($_SESSION['user_id'] > 0) {
                $device_id     = isset($device['udid']) ? $device['udid'] : '';
                $device_client = isset($device['client']) ? $device['client'] : '';
                RC_DB::table('term_relationship')->where('item_key2', 'device_udid')->where('item_value2', $device_id)->update(array('item_key2' => '', 'item_value2' => ''));
                //修正关联设备号
                $result = ecjia_app::validate_application('mobile');
                if (!is_ecjia_error($result)) {
                    if (!empty($device['udid']) && !empty($device['client']) && !empty($device['code'])) {
                        RC_DB::table('mobile_device')->where('device_udid', $device['udid'])->where('device_client', $device['client'])->where('device_code', $device['code'])->where('user_type', 'user')->update(array('user_id' => $_SESSION['user_id']));
                    }
                }
            }

            return $out;
        }
    }


    /**
     * 用户注册，登录函数
     *
     * @access public
     * @param string $username
     *            注册用户名
     * @param string $password
     *            用户密码
     * @param string $email
     *            注册email
     * @param array $other
     *            注册的其他信息
     *
     * @return bool $bool
     */
    private function register($username, $password = null, $email, $mobile, $other = array(), $api_version = '')
    {
        $db_user = RC_Loader::load_app_model('users_model', 'user');

        /* 检查注册是否关闭 */
        $shop_reg_closed = ecjia::config('shop_reg_closed');
        if ($shop_reg_closed == '1') {
            return new ecjia_error('shop_reg_closed', __('会员注册关闭', 'user'));
        }

        if (empty($username)) {
            return new ecjia_error('username_not_empty', __('用户名不能为空！', 'user'));
        } else {
            if (version_compare($api_version, '1.17', '>=')) {
                if (preg_match('/\'\/^\\s*$|^c:\\\\con\\\\con$|[%,\\\"\\s\\t\\<\\>\\&\'\\\\]/', $username)) {
                    return new ecjia_error('username_error', __('用户名有敏感字符', 'user'));
                }
            } else {
                if (preg_match('/\'\/^\\s*$|^c:\\\\con\\\\con$|[%,\\*\\"\\s\\t\\<\\>\\&\'\\\\]/', $username)) {
                    return new ecjia_error('username_error', __('用户名有敏感字符', 'user'));
                }
            }
        }

        if (!ecjia_integrate::addUser($username, $password, $email, $mobile)) {
            // 注册失败
            return new ecjia_error('signup_error', ecjia_integrate::getErrorMessage());
        } else {
            // 注册成功
            /* 设置成登录状态 */
            ecjia_integrate::setSession($username);
            ecjia_integrate::setCookie($username);

            /* 注册送积分 */
            if (ecjia_config::has('register_points')) {
                $options = array(
                    'user_id'     => $_SESSION['user_id'],
                    'rank_points' => ecjia::config('register_points'),
                    'pay_points'  => ecjia::config('register_points'),
                    'change_desc' => __('注册送积分', 'user')
                );
                $result  = RC_Api::api('user', 'account_change_log', $options);
            }

            // 定义other合法的变量数组
            $other_key_array         = array(
                'msn',
                'qq',
                'office_phone',
                'home_phone',
                'mobile_phone'
            );
            $update_data['reg_time'] = RC_Time::gmtime();
            if ($other) {
                foreach ($other as $key => $val) {
                    // 删除非法key值
                    if (!in_array($key, $other_key_array)) {
                        unset($other[$key]);
                    } else {
                        $other[$key] = htmlspecialchars(trim($val)); // 防止用户输入javascript代码
                    }
                }
                $update_data = array_merge($update_data, $other);
            }

            $db_user->where(array('user_id' => $_SESSION['user_id']))->update($update_data);

            \Ecjia\App\User\UserInfoFunction::update_user_info(); // 更新用户信息

            return true;
        }
    }
}



// end