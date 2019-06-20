<?php
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台管理员添加会员
 * @author zrl
 *
 */
class admin_user_add_module extends api_admin implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {
        $this->authadminSession();
        if ($_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, __('Invalid session', 'user'));
        }
        $device   = $this->device;
        $username = $this->requestData('user_name');
        $mobile   = $this->requestData('mobile');
        $birthday = $this->requestData('birthday');
        $email    = $this->requestData('email');

        if ($_SESSION['staff_id'] > 0) {
            $store_id = $_SESSION['store_id'];
        }

        if (empty($username) || empty($mobile) || empty($store_id)) {
            return new ecjia_error('invalid_parameter', sprintf(__('请求接口%s参数无效', 'user'), __CLASS__));
        }

        $other = [];
        if (!empty($mobile)) {
            $other['mobile_phone'] = $mobile;
        }
        if (!empty($birthday)) {
            $other['birthday'] = $birthday;
        }
        if (!empty($email)) {
            $other['email'] = $email;
        } else {
            $device_client = isset($device['client']) ? $device['client'] : '';
            /* 随机生成6位随机数 + 请求客户端类型作为用户名*/
            $code        = '';
            $charset     = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $charset_len = strlen($charset) - 1;
            for ($i = 0; $i < 6; $i++) {
                $code .= $charset[rand(1, $charset_len)];
            }
            $email = $device_client . '_' . $code . '@mobile.com';
        }
        //用户名过滤
        if (preg_match('/\'\/^\\s*$|^c:\\\\con\\\\con$|[%,\\*\\"\\s\\t\\<\\>\\&\'\\\\]/', $username)) {
            return new ecjia_error('username_error', __('用户名有敏感字符', 'user'));
        }
        //用户名是否重复
        $username_count = RC_DB::table('users')->where('user_name', $username)->count();
        if ($username_count > 0) {
            return new ecjia_error('user_exists', __('用户名已存在！', 'user'));
        }
        //手机号码是否重复
        $mobile_count = RC_DB::table('users')->where('mobile_phone', $mobile)->count();
        if ($mobile_count > 0) {
            return new ecjia_error('mobile_exists', __('手机号已存在！', 'user'));
        }
        $userinfo = [];
        if (ecjia_integrate::addUser($username, null, $email, $mobile)) {
            $user_info         = ecjia_integrate::getUserInfo($username);
            $max_id            = $user_info['user_id'];
            $other['reg_time'] = RC_Time::gmtime();
            RC_DB::table('users')->where('user_id', $user_info['user_id'])->update($other);
            //店铺会员表同步记录
            $store_name      = RC_DB::table('store_franchisee')->where('store_id', $store_id)->pluck('merchants_name');
            $store_user_data = array(
                'store_id'   => $store_id,
                'user_id'    => $user_info['user_id'],
                'store_name' => empty($store_name) ? '' : $store_name,
                'join_scene' => 'cashier_suggest',
                'add_time'   => RC_Time::gmtime()
            );
            RC_DB::table('store_users')->insertGetId($store_user_data);
            $userinfo = array(
                'user_id'   => intval($user_info['user_id']),
                'user_name' => $user_info['user_name']
            );
        } else {
            return new ecjia_error('add_user_fail', __('添加会员失败！', 'user'));
        }

        return $userinfo;
    }
}
// end