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
 * 插件使用方法
 * @author royalwang
 */
class integrate
{

    /**
     *  返回字符集列表数组
     *
     * @access  public
     * @param
     *
     * @return void
     */
    public static function charset_list()
    {
        $charset_list = array(
            'UTF8'   => 'UTF-8',
            'GB2312' => 'GB2312/GBK',
            'BIG5'   => 'BIG5',
        );
        return RC_Hook::apply_filters('user_integrate_charset_list', $charset_list);
    }


    private static $instance = null;

    /**
     * 初始化会员数据整合类
     *
     * @access public
     * @return object
     */
    public static function init_users()
    {
        if (self::$instance != null) {
            return self::$instance;
        }

        $cfg = unserialize(ecjia::config('integrate_config'));

        if (ecjia::config('integrate_code') == 'ecjia' || ecjia::config('integrate_code') == 'ecshop') {
            RC_Loader::load_app_class('integrate_ecjia', 'user', false);
            self::$instance = new integrate_ecjia($cfg);
        } else {
            RC_Loader::load_app_class('integrate_factory', 'user', false);
            self::$instance = new integrate_factory(ecjia::config('integrate_code'), $cfg);
        }

        return self::$instance;
    }

    public function __construct()
    {

    }

    /**
     * 获取所有可用的验证码
     */
    public function integrate_list()
    {
        $plugins         = RC_Plugin::get_plugins();
        $captcha_plugins = ecjia_config::instance()->get_addon_config('user_integrate_plugins', true);

        $list = array();
        foreach ($captcha_plugins as $code => $plugin) {
            if (isset($plugins[$plugin])) {
                $list[$code] = $plugins[$plugin];

                $list[$code]['code']               = $code;
                $list[$code]['format_name']        = $list[$code]['Name'];
                $list[$code]['format_description'] = $list[$code]['Description'];
            }
        }

        return $list;
    }

    /**
     *
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function save_integrate_config($code, $cfg)
    {
        ecjia_config::instance()->write_config('integrate_code', $code);

        /* 当前的域名 */
        if (isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
            $cur_domain = $_SERVER['HTTP_X_FORWARDED_HOST'];
        } elseif (isset($_SERVER['HTTP_HOST'])) {
            $cur_domain = $_SERVER['HTTP_HOST'];
        } else {
            if (isset($_SERVER['SERVER_NAME'])) {
                $cur_domain = $_SERVER['SERVER_NAME'];
            } elseif (isset($_SERVER['SERVER_ADDR'])) {
                $cur_domain = $_SERVER['SERVER_ADDR'];
            }
        }

        /* 整合对象的域名 */
        $int_domain = str_replace(array('http://', 'https://'), array('', ''), $cfg['integrate_url']);
        if (strrpos($int_domain, '/')) {
            $int_domain = substr($int_domain, 0, strrpos($int_domain, '/'));
        }

        if ($cur_domain != $int_domain) {
            $same_domain = true;
            $domain      = '';

            /* 域名不一样，检查是否在同一域下 */
            $cur_domain_arr = explode(".", $cur_domain);
            $int_domain_arr = explode(".", $int_domain);

            if (count($cur_domain_arr) != count($int_domain_arr) || $cur_domain_arr[0] == '' || $int_domain_arr[0] == '') {
                /* 域名结构不相同 */
                $same_domain = false;
            } else {
                /* 域名结构一致，检查除第一节以外的其他部分是否相同 */
                $count = count($cur_domain_arr);

                for ($i = 1; $i < $count; $i++) {
                    if ($cur_domain_arr[$i] != $int_domain_arr[$i]) {
                        $domain      = '';
                        $same_domain = false;
                        break;
                    } else {
                        $domain .= ".$cur_domain_arr[$i]";
                    }
                }
            }

            if ($same_domain == false) {
                /* 不在同一域，设置提示信息 */
                $cfg['cookie_domain'] = '';
                $cfg['cookie_path']   = '/';
            } else {
                $cfg['cookie_domain'] = $domain;
                $cfg['cookie_path']   = '/';
            }
        } else {
            $cfg['cookie_domain'] = '';
            $cfg['cookie_path']   = '/';
        }

        ecjia_config::instance()->write_config('integrate_config', serialize($cfg));

        return true;
    }

    /**
     * 用户注册
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
    public function register($username, $password, $email, $other = array())
    {
        $db_user = RC_Model::model('user/users_model');

        /* 检查注册是否关闭 */
        if (ecjia_config::has('shop_reg_closed')) {
            return new ecjia_error('99999', __('该网店暂停注册', 'user'));
        }
        /* 检查username */
        if (empty($username)) {
            return new ecjia_error('200', __('用户名不能为空', 'user'));
        } else {
            if (preg_match('/\'\/^\\s*$|^c:\\\\con\\\\con$|[%,\\*\\"\\s\\t\\<\\>\\&\'\\\\]/', $username)) {
                return new ecjia_error('201', __('用户名含有敏感字符', 'user'));
            }
        }

        /* 检查email */
        if (empty($email)) {
            return new ecjia_error('203', __('email不能为空', 'user'));
        } else {
            if (!is_email($email)) {
                return new ecjia_error('204', __('不是合法的email地址', 'user'));
            }
        }

        if ($this->check_admin_registered($username)) {
            return new ecjia_error('202', __('用户名已经存在', 'user'));
        }

        RC_Loader::load_app_class('integrate', 'user', false);
        $user = &integrate::init_users();
        if (!$user->add_user($username, $password, $email)) {
            if ($user->error == ERR_INVALID_USERNAME) {
                return new ecjia_error('username_invalid', sprintf(__("用户名 %s 含有敏感字符", 'user'), $username));
            } elseif ($user->error == ERR_USERNAME_NOT_ALLOW) {
                return new ecjia_error('username_not_allow', sprintf(__("用户名 %s 不允许注册", 'user'), $username));
            } elseif ($user->error == ERR_USERNAME_EXISTS) {
                return new ecjia_error('username_exist', sprintf(__("用户名 %s 已经存在", 'user'), $username));
            } elseif ($user->error == ERR_INVALID_EMAIL) {
                return new ecjia_error('email_invalid', sprintf(__("%s 不是合法的email地址", 'user'), $email));
            } elseif ($user->error == ERR_EMAIL_NOT_ALLOW) {
                return new ecjia_error('email_not_allow', sprintf(__("Email %s 不允许注册", 'user'), $email));
            } elseif ($user->error == ERR_EMAIL_EXISTS) {
                return new ecjia_error('email_exist', sprintf(__("%s 已经存在", 'user'), $email));
            } else {
                return new ecjia_error('unknown_error', __('未知错误！', 'user'));
            }
        } else {
            // 注册成功
            /* 设置成登录状态 */
            $user->set_session($username);
            $user->set_cookie($username);
            /* 注册送积分 */
            if (ecjia_config::has('register_points')) {
                $options = array(
                    'user_id'     => $_SESSION['user_id'],
                    'rank_points' => ecjia::config('register_points'),
                    'pay_points'  => ecjia::config('register_points'),
                    'change_desc' => RC_Lang::get('user::user.register_points')
                );
                $result  = RC_Api::api('user', 'account_change_log', $options);
            }

            RC_Loader::load_app_func('admin_user', 'user');
            update_user_info(); // 更新用户信息
            RC_Loader::load_app_func('cart', 'cart');
            recalculate_price(); // 重新计算购物车中的商品价格

            return true;
        }
    }

    /**
     * 登录函数
     *
     * @access public
     * @param string $username
     *            注册用户名
     * @param string $password
     *            用户密码
     *
     * @return bool $bool
     */
    public function login($username, $password)
    {
        /* 检查username */
        if (empty($username)) {
            return new ecjia_error('200', __('用户名不能为空', 'user'));
        } else {
            if (preg_match('/\'\/^\\s*$|^c:\\\\con\\\\con$|[%,\\*\\"\\s\\t\\<\\>\\&\'\\\\]/', $username)) {
                return new ecjia_error('201', __('用户名含有敏感字符', 'user'));
            }
        }

        RC_Loader::load_app_class('integrate', 'user', false);
        $user = &integrate::init_users();

        if (!$user->login($username, $password)) {
            return new ecjia_error('login_failure', __('登录失败', 'user'));
        }

        RC_Loader::load_app_func('admin_user', 'user');
        update_user_info(); // 更新用户信息
        RC_Loader::load_app_func('cart', 'cart');
        recalculate_price(); // 重新计算购物车中的商品价格

        return true;
    }

    /**
     * 判断超级管理员用户名是否存在
     *
     * @param string $adminname
     *            超级管理员用户名
     * @return boolean
     */
    public function check_admin_registered($adminname)
    {
        return RC_DB::table('admin_user')->where('user_name', $adminname)->count();
    }
}

// end