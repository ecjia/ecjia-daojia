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
 * ECJIA 会员管理程序
 */
class admin extends ecjia_admin
{
    public function __construct()
    {
        parent::__construct();

        RC_Loader::load_app_func('admin_user');
        RC_Loader::load_app_func('global', 'goods');

        /* 加载所全局 js */
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');
        RC_Style::enqueue_style('chosen');
        RC_Script::enqueue_script('jquery-chosen');
        RC_Style::enqueue_style('uniform-aristo');
        RC_Script::enqueue_script('jquery-uniform');

        RC_Script::enqueue_script('user_info', RC_App::apps_url('statics/js/user_info.js', __FILE__));
        RC_Style::enqueue_style('user_info_css', RC_App::apps_url('statics/css/user_info.css', __FILE__));
        RC_Script::localize_script('user_info', 'js_lang', config('app-user::jslang.admin_page'));

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('会员列表', 'user'), RC_Uri::url('user/admin/init')));
    }

    /**
     * 用户帐号列表
     */
    public function init()
    {
        $this->admin_priv('user_manage');

        if (session('status')) {
            ecjia_screen::get_current_screen()->add_admin_notice(new admin_notice(session('status'), 'alert-success'));
            unset($_SESSION['status']);
        }

        //解决点击左侧菜单 添加会员和会员等级 切换 左侧菜单会收起问题
        RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
        RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));

        ecjia_screen::get_current_screen()->remove_last_nav_here();
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('会员列表', 'user')));
        ecjia_screen::get_current_screen()->add_help_tab(array(
            'id'      => 'overview',
            'title'   => __('概述', 'user'),
            'content' => '<p>' . '欢迎访问ECJia智能后台会员列表页面，系统中所有的会员都会显示在此列表中。' . '</p>',
        ));

        ecjia_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . __('更多信息：', 'user') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:会员列表" target="_blank">' . __('关于会员列表帮助文档', 'user') . '</a>') . '</p>'
        );

        $this->assign('ur_here', __('会员列表', 'user'));
        $this->assign('action_link', array('text' => __('添加会员', 'user'), 'href' => RC_Uri::url('user/admin/add')));

        $ranks     = RC_DB::table('user_rank')->select('rank_id', 'rank_name', 'min_points')->orderBy('min_points', 'asc')->get();
        $user_list = get_user_list($_REQUEST);

        $this->assign('user_ranks', $ranks);
        $this->assign('user_list', $user_list);
        $this->assign('search_action', RC_Uri::url('user/admin/init'));
        $this->assign('form_action', RC_Uri::url('user/admin/batch_remove'));

        $this->display('user_list.dwt');
    }

    /**
     * 添加会员帐号
     */
    public function add()
    {
        $this->admin_priv('user_update');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('添加会员', 'user')));
        ecjia_screen::get_current_screen()->add_help_tab(array(
            'id'      => 'overview',
            'title'   => __('概述', 'user'),
            'content' => '<p>' . __('欢迎访问ECJia智能后台添加会员页面，在此页面可以进行添加会员操作。', 'user') . '</p>',
        ));

        ecjia_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . __('更多信息：', 'user') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:添加会员" target="_blank">' . __('关于添加会员帮助文档', 'user') . '</a>') . '</p>'
        );

        $user = array(
            'rank_points' => ecjia::config('register_points'),
            'pay_points'  => ecjia::config('register_points'),
            'sex'         => 0,
            'credit_line' => 0,
        );

        $this->assign('ur_here', __('添加会员', 'user'));
        $this->assign('action_link', array('text' => __('会员列表', 'user'), 'href' => RC_Uri::url('user/admin/init')));

        /* 取出注册扩展字段 */
        $extend_info_list = RC_DB::table('reg_fields')->where('type', '<', 2)->where('display', 1)->where('id', '!=', 6)->where('id', '!=', 5)
            ->orderBy('dis_order', 'asc')->orderBy('id', 'asc')->get();

        /* 给扩展字段加入key */
        if (!empty($extend_info_list)) {
            foreach ($extend_info_list as $key => $val) {
                $val['key']             = $key + 1;
                $extend_info_list[$key] = $val;
            }
        }

        $rank_list = get_user_rank_list(true);

        $this->assign('form_act', 'insert');
        $this->assign('form_action', RC_Uri::url('user/admin/insert'));
        $this->assign('user', $user);
        $this->assign('special_ranks', $rank_list);
        $this->assign('extend_info_list', $extend_info_list);
        $this->assign('lang_sex', array(__('保密', 'user'), __('男', 'user'), __('女', 'user')));

        $this->display('user_edit.dwt');
    }

    /**
     * 添加会员帐号
     */
    public function insert()
    {
        $this->admin_priv('user_update', ecjia::MSGTYPE_JSON);

        RC_Loader::load_app_class('integrate', 'user', false);

        $username         = empty($_POST['username']) ? '' : trim($_POST['username']);
        $password         = empty($_POST['password']) ? '' : trim($_POST['password']);
        $confirm_password = empty($_POST['confirm_password']) ? '' : trim($_POST['confirm_password']);
        $email            = empty($_POST['email']) ? null : trim($_POST['email']);
        $mobile_phone     = empty($_POST['mobile_phone']) ? '' : trim($_POST['mobile_phone']);

        $sex       = empty($_POST['sex']) ? 0 : intval($_POST['sex']);
        $sex_array = array(0, 1, 2);

        $sex         = in_array($sex, $sex_array) ? $sex : 0;
        $birthday    = empty($_POST['birthday']) ? '1000-01-01' : $_POST['birthday'];
        $rank        = empty($_POST['user_rank']) ? 0 : intval($_POST['user_rank']);
        $credit_line = empty($_POST['credit_line']) ? 0 : trim($_POST['credit_line']);
        $reg_time    = RC_Time::gmtime();

        /* 验证参数的合法性*/
        /* 邮箱*/
        if (!empty($email) && !preg_match('/\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}/', $email)) {
            return $this->showmessage(__('没有输入邮件地址或者输入了一个无效的邮件地址。', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (!empty($password)) {
            if (!preg_match("/^[A-Za-z0-9_\/|\~|\!|\@|\#|\\$|\%|\^|\&|\*|\(|\)|\_|\+|\{|\}|\:|\<|\>|\?|\[|\]|\,|\.|\/|\;|\'|\`|\-|\=|\\\|\|]+$/", $password)) {
                return $this->showmessage(__('密码不能有中文或非法字符。', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if (empty($confirm_password)) {
                return $this->showmessage(__('没有输入确认密码。', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if ($password != $confirm_password) {
                return $this->showmessage(__('确认密码和输入的密码不一致。', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if (strlen($password) < 6 || strlen($confirm_password) < 6) {
                return $this->showmessage(__('密码和确认密码的长度不能小于6。', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if (preg_match("/ /", $password)) {
                return $this->showmessage(__('密码中不能包含空格。', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }

        /* 信用额度*/
        if (!is_numeric($credit_line) || $credit_line < 0) {
            return $this->showmessage(__('信用额度不为空且为数值类型。', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        /* 更新会员的其它信息 */
        $other['credit_line']  = $credit_line;
        $other['user_rank']    = $rank;
        $other['msn']          = isset($_POST['extend_field1']) ? htmlspecialchars(trim($_POST['extend_field1'])) : '';
        $other['qq']           = isset($_POST['extend_field2']) ? htmlspecialchars(trim($_POST['extend_field2'])) : '';
        $other['office_phone'] = isset($_POST['extend_field3']) ? htmlspecialchars(trim($_POST['extend_field3'])) : '';
        $other['home_phone']   = isset($_POST['extend_field4']) ? htmlspecialchars(trim($_POST['extend_field4'])) : '';

        $check_mobile = Ecjia\App\Sms\Helper::check_mobile($mobile_phone);
        if (is_ecjia_error($check_mobile)) {
            return $this->showmessage($check_mobile->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $count = RC_DB::table('users')->where('mobile_phone', $mobile_phone)->count();
        if (!empty($count)) {
            return $this->showmessage(__('手机号码已存在', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (ecjia_integrate::addUser($username, $password, $email, $mobile_phone, $sex, $birthday, $reg_time)) {
            $user_info = ecjia_integrate::getUserInfo($username);

            $max_id = $user_info['user_id'];
            RC_DB::table('users')->where('user_id', $user_info['user_id'])->update($other);

            /*把新注册用户的扩展信息插入数据库*/
            $fields_arr = RC_DB::table('reg_fields')
                ->where('type', 0)
                ->where('display', 1)
                ->orderBy('dis_order', 'asc')
                ->orderBy('id', 'asc')
                ->select('id')
                ->get();

            $extend_field_str = ''; //生成扩展字段的内容字符串

            if (!empty($fields_arr)) {
                foreach ($fields_arr as $val) {
                    $extend_field_index = 'extend_field' . $val['id'];
                    if (!empty($_POST[$extend_field_index])) {
                        $temp_field_content = strlen($_POST[$extend_field_index]) > 100 ? mb_substr($_POST[$extend_field_index], 0, 99) : $_POST[$extend_field_index];
                        $data               = array(
                            'user_id'      => $max_id,
                            'reg_field_id' => $val['id'],
                            'content'      => $temp_field_content,
                        );
                        RC_DB::table('reg_extend_info')->insert($data);
                    }
                }
            }

            /* 注册送积分 */
            if (ecjia_config::has('register_points')) {
                change_account_log($user_info['user_id'], 0, 0, ecjia::config('register_points'), ecjia::config('register_points'), __('注册送积分', 'user'));
            }

            /* 记录管理员操作 */
            ecjia_admin::admin_log($username, 'add', 'users');

            /* 提示信息 */
            $links[] = array('text' => __('返回会员列表', 'user'), 'href' => RC_Uri::url('user/admin/init'));
            $links[] = array('text' => __('继续添加会员', 'user'), 'href' => RC_Uri::url('user/admin/add'));
            return $this->showmessage(__('会员账号添加成功', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('user/admin/edit', array('id' => $max_id))));

        } else {
            return $this->showmessage(ecjia_integrate::getErrorMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 编辑用户帐号
     */
    public function edit()
    {
        $this->admin_priv('user_update');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑会员账号', 'user')));
        ecjia_screen::get_current_screen()->add_help_tab(array(
            'id'      => 'overview',
            'title'   => __('概述', 'user'),
            'content' =>
                '<p>' . __('欢迎访问ECJia智能后台编辑会员页面，在此页面可以进行编辑会员操作。', 'user') . '</p>',
        ));

        ecjia_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . __('更多信息：', 'user') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:会员列表#.E4.BC.9A.E5.91.98.E7.BC.96.E8.BE.91" target="_blank">' . __('关于编辑会员帮助文档', 'user') . '</a>') . '</p>'
        );

        $this->assign('ur_here', __('编辑会员账号', 'user'));
        $this->assign('action_link', array('text' => __('会员列表', 'user'), 'href' => RC_Uri::url('user/admin/init')));

        $row = RC_DB::table('users')->where('user_id', $_GET['id'])->first();

        if ($row) {
            $user['user_id']               = $row['user_id'];
            $user['email']                 = $row['email'];
            $user['user_name']             = $row['user_name'];
            $user['sex']                   = $row['sex'];
            $user['birthday']              = date($row['birthday']);
            $user['pay_points']            = $row['pay_points'];
            $user['rank_points']           = $row['rank_points'];
            $user['user_rank']             = $row['user_rank'];
            $user['user_money']            = $row['user_money'];
            $user['frozen_money']          = $row['frozen_money'];
            $user['credit_line']           = $row['credit_line'];
            $user['formated_user_money']   = price_format($row['user_money']);
            $user['formated_frozen_money'] = price_format($row['frozen_money']);
            $user['qq']                    = $row['qq'];
            $user['msn']                   = $row['msn'];
            $user['office_phone']          = $row['office_phone'];
            $user['home_phone']            = $row['home_phone'];
            $user['mobile_phone']          = $row['mobile_phone'];
        }

        /* 取出注册扩展字段 */
        $extend_info_list = RC_DB::table('reg_fields')
            ->where('type', '<', 2)
            ->where('display', 1)
            ->where('id', '!=', 6)
            ->where('id', '!=', 5)
            ->orderBy('dis_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();
        $extend_info_arr  = RC_DB::table('reg_extend_info')->where('user_id', $user['user_id'])->select('reg_field_id', 'content')->get();

        $temp_arr = array();
        if (isset($extend_info_arr)) {
            foreach ($extend_info_arr as $val) {
                $temp_arr[$val['reg_field_id']] = $val['content'];
            }
        }

        if (!empty($extend_info_list)) {
            foreach ($extend_info_list as $key => $val) {
                switch ($val['id']) {
                    case 1:
                        $extend_info_list[$key]['content'] = $user['msn'];
                        break;
                    case 2:
                        $extend_info_list[$key]['content'] = $user['qq'];
                        break;
                    case 3:
                        $extend_info_list[$key]['content'] = $user['office_phone'];
                        break;
                    case 4:
                        $extend_info_list[$key]['content'] = $user['home_phone'];
                        break;
//                    case 5:
//                        $extend_info_list[$key]['content'] = $user['mobile_phone'];
//                        break;
                    default:
                        $extend_info_list[$key]['content'] = empty($temp_arr[$val['id']]) ? '' : $temp_arr[$val['id']];
                }
            }
        }
        $this->assign('extend_info_list', $extend_info_list);

        /* 当前会员推荐信息 */
        $affiliate = unserialize(ecjia::config('affiliate'));
        $this->assign('affiliate', $affiliate);

        empty($affiliate) && $affiliate = array();
        if (empty($affiliate['config']['separate_by'])) {
            //推荐注册分成
            $affdb  = array();
            $num    = count($affiliate['item']);
            $up_uid = $_GET['id'];
            for ($i = 1; $i <= $num; $i++) {
                $count = 0;
                if ($up_uid) {
                    $up_uid = explode(',', $up_uid);
                    $data   = RC_DB::table('users')->whereIn('parent_id', $up_uid)->select('user_id')->get();

                    $up_uid = '';
                    if (!empty($data)) {
                        foreach ($data as $key => $rt) {
                            $up_uid .= $up_uid ? ",'$rt[user_id]'" : "'$rt[user_id]'";
                            $count++;
                        }
                    }
                }
                $affdb[$i]['num'] = $count;
            }
            if ($affdb[1]['num'] > 0) {
                $this->assign('affdb', $affdb);
            }
        }

        $this->assign('lang_sex', array(__('保密', 'user'), __('男', 'user'), __('女', 'user')));
        $this->assign('special_ranks', get_user_rank_list(true));
        $this->assign('form_act', 'update');
        $this->assign('action', 'edit');
        $this->assign('user', $user);
        $this->assign('form_action', RC_Uri::url('user/admin/update'));

        $this->display('user_edit.dwt');
    }

    /**
     * 更新用户帐号
     */
    public function update()
    {
        $this->admin_priv('user_update', ecjia::MSGTYPE_JSON);

        $username         = empty($_POST['username']) ? '' : trim($_POST['username']);
        $user_id          = trim($_POST['id']);
        $password         = trim($_POST['newpassword']);
        $confirm_password = empty($_POST['confirm_password']) ? '' : trim($_POST['confirm_password']);
        $email            = empty($_POST['email']) ? '' : trim($_POST['email']);
        $mobile_phone     = empty($_POST['mobile_phone']) ? '' : trim($_POST['mobile_phone']);

        $sex         = empty($_POST['sex']) ? 0 : intval($_POST['sex']);
        $sex         = in_array($sex, array(0, 1, 2)) ? $sex : 0;
        $birthday    = empty($_POST['birthday']) ? '' : $_POST['birthday'];
        $rank        = empty($_POST['user_rank']) ? 0 : intval($_POST['user_rank']);
        $credit_line = empty($_POST['credit_line']) ? 0 : trim($_POST['credit_line']);

        /* 验证参数的合法性*/
        /* 邮箱*/
        if (!empty($email) && !preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/", $email)) {
            return $this->showmessage(__('没有输入邮件地址或者输入了一个无效的邮件地址。', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        /* 密码 */
        if (!empty($password)) {
            if (!preg_match("/^[A-Za-z0-9_\/|\~|\!|\@|\#|\\$|\%|\^|\&|\*|\(|\)|\_|\+|\{|\}|\:|\<|\>|\?|\[|\]|\,|\.|\/|\;|\'|\`|\-|\=|\\\|\|]+$/", $password)) {
                return $this->showmessage(__('密码不能有中文或非法字符。', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if (empty($confirm_password)) {
                return $this->showmessage(__('没有输入确认密码。', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if ($password != $confirm_password) {
                return $this->showmessage(__('确认密码和输入的密码不一致。', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if (strlen($password) < 6 || strlen($confirm_password) < 6) {
                return $this->showmessage(__('密码和确认密码的长度不能小于6。', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if (preg_match("/ /", $password)) {
                return $this->showmessage(__('密码中不能包含空格。', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            RC_DB::table('users')->where('user_id', $user_id)->update(array('ec_salt' => '0'));
        }

        /* 信用额度*/
        if (!is_numeric($credit_line) || $credit_line < 0) {
            return $this->showmessage(__('信用额度不为空且为数值类型。', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        /* 更新用户扩展字段的数据 */
        $fields_arr = RC_DB::table('reg_fields')->where('type', 0)->where('display', 1)
            ->orderBy('dis_order', 'asc')->orderBy('id', 'asc')->get();

        /* 循环更新扩展用户信息 */
        if (!empty($fields_arr)) {
            foreach ($fields_arr as $val) {
                $extend_field_index = 'extend_field' . $val['id'];
                if (isset($_POST[$extend_field_index])) {
                    $temp_field_content = strlen($_POST[$extend_field_index]) > 100 ? mb_substr($_POST[$extend_field_index], 0, 99) : $_POST[$extend_field_index];
                    $sql_one            = RC_DB::table('reg_extend_info')->where('reg_field_id', $val['id'])->where('user_id', $user_id)->first();
                    /* 如果之前没有记录，则插入 */
                    if ($sql_one) {
                        $data = array('content' => $temp_field_content);
                        RC_DB::table('reg_extend_info')->where('reg_field_id', $val['id'])->where('user_id', $user_id)->update($data);
                    } else {
                        $data = array(
                            'user_id'      => $user_id,
                            'reg_field_id' => $val['id'],
                            'content'      => $temp_field_content,
                        );
                        RC_DB::table('reg_extend_info')->insert($data);
                    }
                }
            }
        }

        /* 更新会员的其它信息 */
        $other                 = array();
        $other['user_name']    = $username;
        $other['email']        = $email;
        $other['credit_line']  = $credit_line;
        $other['sex']          = $sex;
        $other['birthday']     = $birthday;
        $other['user_rank']    = $rank;
        $other['msn']          = isset($_POST['extend_field1']) ? htmlspecialchars(trim($_POST['extend_field1'])) : '';
        $other['qq']           = isset($_POST['extend_field2']) ? htmlspecialchars(trim($_POST['extend_field2'])) : '';
        $other['office_phone'] = isset($_POST['extend_field3']) ? htmlspecialchars(trim($_POST['extend_field3'])) : '';
        $other['home_phone']   = isset($_POST['extend_field4']) ? htmlspecialchars(trim($_POST['extend_field4'])) : '';
        // $other['mobile_phone']    = isset($_POST['extend_field5']) ? htmlspecialchars(trim($_POST['extend_field5'])) : '';
        $other['mobile_phone'] = $mobile_phone;

        $check_mobile = Ecjia\App\Sms\Helper::check_mobile($other['mobile_phone']);
        if (is_ecjia_error($check_mobile)) {
            return $this->showmessage($check_mobile->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $count = RC_DB::table('users')->where('user_id', '!=', $user_id)->where('mobile_phone', $other['mobile_phone'])->count();
        if (!empty($count)) {
            return $this->showmessage(__('手机号码已存在', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (!ecjia_integrate::editUser([
            'username' => $username,
            'password' => $password,
            'email'    => $email,
            'gender'   => $sex,
            'birthday' => $birthday,
        ])) {
            return $this->showmessage(ecjia_integrate::getErrorMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        RC_DB::table('users')->where('user_id', $user_id)->update($other);

        /* 记录管理员操作 */
        ecjia_admin::admin_log($username, 'edit', 'users');
        //为更新用户购物车数据加标记
        RC_Api::api('cart', 'mark_cart_goods', array('user_id' => $user_id));

        /* 提示信息 */
        $links[0]['text'] = __('返回会员列表', 'user');
        $links[0]['href'] = RC_Uri::url('user/admin/init');
        return $this->showmessage(__('编辑成功！', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('user/admin/edit', array('id' => $user_id))));
    }

    /**
     * 用户详情页面
     */
    public function info()
    {
        $this->admin_priv('user_manage');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('会员详情', 'user'));
        ecjia_screen::get_current_screen()->add_help_tab(array(
            'id'      => 'overview',
            'title'   => __('概述', 'user'),
            'content' =>
                '<p>' . __('欢迎访问ECJia智能后台会员详情页面，在此页面可以进行对会员的详细信息查看。', 'user') . '</p>',
        ));

        ecjia_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . __('更多信息：', 'user') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:会员列表#.E8.AF.A6.E7.BB.86.E4.BF.A1.E6.81.AF" target="_blank">' . __('关于查看会员帮助文档', 'user') . '</a>') . '</p>'
        );
        $this->assign('ur_here', __('会员详情', 'user'));
        $this->assign('action_link', array('text' => __('会员列表', 'user'), 'href' => RC_Uri::url('user/admin/init')));

        $id       = !empty($_GET['id']) ? intval($_GET['id']) : 0;
        $keywords = !empty($_GET['keywords']) ? trim($_GET['keywords']) : '';

        if (!empty($keywords)) {
            $row = RC_DB::table('users')
                ->where('user_id', $keywords)
                ->orWhere('user_name', $keywords)
                ->orWhere('email', $keywords)
                ->first();
        } else {
            $row = RC_DB::table('users')->where('user_id', $id)->first();
        }

        if (empty($row)) {
            return $this->showmessage(__('没有查询到该会员的信息', 'user'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
        }
        if (!empty($row['parent_id'])) {
            $row['parent_username'] = RC_DB::table('users')->where('user_id', $row['parent_id'])->pluck('user_name');
        }

        /* 获得用户等级名 */
        $user = [];
        if ($row['user_rank'] == 0) {
            //重新计算会员等级
            $row_rank = RC_Api::api('user', 'update_user_rank', array('user_id' => $row['user_id']));
        } else {
            $row_rank = RC_DB::table('user_rank')->where('rank_id', $row['user_rank'])->first();
        }
        $user['user_rank_name'] = $row_rank['rank_name'];
        $user['user_rank_id']   = $row_rank['rank_id'];

        if ($row) {
            $user['user_id']               = $row['user_id'];
            $user['user_name']             = $row['user_name'];
            $user['email']                 = $row['email'];
            $user['sex']                   = $row['sex'];
            $user['reg_time']              = RC_Time::local_date(ecjia::config('time_format'), $row['reg_time']);
            $user['birthday']              = date($row['birthday']);
            $user['pay_points']            = $row['pay_points'];
            $user['rank_points']           = $row['rank_points'];
            $user['user_money']            = $row['user_money'];
            $user['frozen_money']          = $row['frozen_money'];
            $user['credit_line']           = $row['credit_line'];
            $user['formated_user_money']   = price_format($row['user_money']);
            $user['formated_frozen_money'] = price_format($row['frozen_money']);
            $user['parent_id']             = $row['parent_id'];
            $user['parent_username']       = isset($row['parent_username']) ? $row['parent_username'] : '';
            $user['qq']                    = $row['qq'];
            $user['msn']                   = $row['msn'];
            $user['office_phone']          = $row['office_phone'];
            $user['home_phone']            = $row['home_phone'];
            $user['mobile_phone']          = $row['mobile_phone'];
            $user['is_validated']          = $row['is_validated'] == 0 ? __('未验证', 'user') : __('已验证', 'user');
            $user['last_time']             = $row['last_login'] == '0' ? __('新用户还未登录', 'user') : RC_Time::local_date(ecjia::config('time_format'), $row['last_login']);
            $user['last_ip']               = $row['last_ip'];

            $row['address_id'] = !empty($row['address_id']) ? intval($row['address_id']) : 0;
            /* 用户地址列表*/
            $field = "ua.*,
					IF(address_id=" . $row['address_id'] . ",1,0) as default_address,
					IFNULL(c.region_name, '') as country_name,
					IFNULL(p.region_name, '') as province_name,
					IFNULL(t.region_name, '') as city_name,
					IFNULL(d.region_name, '') as district_name,
					IFNULL(s.region_name, '') as street_name";

            $address_list = RC_DB::table('user_address as ua')
                ->leftJoin('regions as c', RC_DB::raw('c.region_id'), '=', RC_DB::raw('ua.country'))
                ->leftJoin('regions as p', RC_DB::raw('p.region_id'), '=', RC_DB::raw('ua.province'))
                ->leftJoin('regions as t', RC_DB::raw('t.region_id'), '=', RC_DB::raw('ua.city'))
                ->leftJoin('regions as d', RC_DB::raw('d.region_id'), '=', RC_DB::raw('ua.district'))
                ->leftJoin('regions as s', RC_DB::raw('s.region_id'), '=', RC_DB::raw('ua.street'))
                ->where('user_id', $row['user_id'])
                ->orderBy('default_address', 'desc')
                ->select(RC_DB::raw($field))
                ->take(5)
                ->get();

            /* 查找用户前5条订单 */
            $order = RC_DB::table('order_info')->where('user_id', $row['user_id'])->orderBy('add_time', 'desc')->take(5)->get();

            if (!empty($order)) {
                foreach ($order as $k => $v) {
                    $order[$k]['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $v['add_time']);
                    $is_cod                = $v['pay_code'] == 'pay_cod' ? 1 : 0;
                    $label_status          = with(new Ecjia\App\Orders\OrderStatus())->getOrderStatusLabel($v['order_status'], $v['shipping_status'], $v['pay_status'], $is_cod);
                    $order[$k]['status']   = $label_status[0];
                }
            }
        }

        $this->assign('user', $user);
        $this->assign('order_list', $order);
        $this->assign('address_list', $address_list);

        $qq_info = RC_DB::table('connect_user')->where('connect_code', 'sns_qq')->where('user_id', $id)->where('user_type', 'user')->first();
        if (!empty($qq_info)) {
            $this->assign('qq_info', $qq_info);
        }

        $wechat_info = RC_DB::table('connect_user')->where('connect_platform', 'wechat')->where('user_id', $id)->where('user_type', 'user')->first();
        if (!empty($wechat_info)) {
            $ect_uid = RC_DB::table('wechat_user')->where('unionid', $wechat_info['union_id'])->pluck('ect_uid');
            //修正绑定信息
            if (empty($ect_uid)) {
                RC_DB::table('wechat_user')->where('unionid', $wechat_info['union_id'])->update(array('ect_uid' => $wechat_info['user_id']));
            }

            if (!empty($wechat_info['profile'])) {
                $profile                 = unserialize($wechat_info['profile']);
                $wechat_info['nickname'] = empty($profile['nickname']) ? '' : $profile['nickname'];
            }

            $this->assign('wechat_info', $wechat_info);
        }

        $this->display('user_info.dwt');
    }

    /**
     * 编辑email
     */
    public function edit_email()
    {
        $this->admin_priv('user_update', ecjia::MSGTYPE_JSON);

        $id    = intval($_REQUEST['pk']);
        $email = trim($_REQUEST['value']);

        /* 验证邮箱*/
        if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/", $email)) {
            return $this->showmessage(__('没有输入邮件地址或者输入了一个无效的邮件地址。', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (!empty($email)) {
            if (RC_DB::table('users')->where('email', $email)->where('user_id', '!=', $id)->count() == 0) {
                if (RC_DB::table('users')->where('user_id', $id)->update(array('email' => $email))) {
                    $user_name = RC_DB::table('users')->where('user_id', $id)->pluck('user_name');

                    ecjia_admin::admin_log($user_name . '邮箱信息', 'edit', 'users');

                    return $this->showmessage(__('编辑成功！', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
                }
            } else {
                return $this->showmessage(__('该邮件地址已经存在。', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        } else {
            return $this->showmessage(__('请输入邮箱地址！', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    //删除帐号数据
    public function remove_user()
    {
        $this->admin_priv('user_delete');

        $id = intval($_GET['id']);

        $user_info = RC_Api::api('user', 'user_info', array('user_id' => $id));
        if (empty($user_info)) {
            $links[] = array('text' => __('会员列表', 'user'), 'href' => RC_Uri::url('user/admin/init'));
            return $this->showmessage(__('该用户不存在', 'user'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => $links));
        }

        $user_info_url = RC_Uri::url('user/admin/info', array('id' => $id));

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('会员详情', 'user'), $user_info_url));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('删除帐号数据', 'user')));

        $this->assign('ur_here', __('删除帐号数据', 'user'));
        $this->assign('action_link', array('text' => __('会员详情', 'user'), 'href' => $user_info_url));

        $delete_all = $_SESSION['action_list'] == 'all' ? true : false;
        $this->assign('delete_all', $delete_all);

        $this->assign('id', $id);

        $handles = (new \Ecjia\App\User\UserCleanManager($id))->getFactories();
        $this->assign('handles', $handles);

        $count = 0;
        if (!empty($handles)) {
            foreach ($handles as $k => $v) {
                $count += $v->handleCount();
            }
        }
        $this->assign('count', $count);

        $this->display('user_delete.dwt');
    }

    /**
     * 删除会员帐号
     */
    public function remove()
    {
        $this->admin_priv('user_delete', ecjia::MSGTYPE_JSON);

        $user_id = !empty($_GET['id']) ? intval($_GET['id']) : 0;

        $handles = (new \Ecjia\App\User\UserCleanManager($user_id))->getFactories();

        $count = 0;
        if (!empty($handles)) {
            foreach ($handles as $k => $v) {
                $count += $v->handleCount();
            }
        }

        if (!empty($count)) {
            return $this->showmessage(__('当前还有用户数据未清除，请先清除后再执行删除会员操作', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        RC_DB::table('users')->where('user_id', $user_id)->delete();

        RC_Session::flash('status', __('删除会员成功', 'user'));

        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => RC_Uri::url('user/admin/init')));
    }

    /**
     * 删除会员帐号单项数据
     */
    public function remove_item()
    {
        $this->admin_priv('user_delete', ecjia::MSGTYPE_JSON);

        $user_id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
        $code    = trim($_GET['handle']);

        $handles = (new \Ecjia\App\User\UserCleanManager($user_id))->getFactories();
        $handle  = array_get($handles, $code);

        if (empty($handle)) {
            return $this->showmessage(__('操作失败，当前code无效', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $result = $handle->handleClean();
        if ($result) {
            return $this->showmessage(sprintf(__('%s删除成功', 'user'), $handle->getName()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
        }
        return $this->showmessage(sprintf(__('%s删除失败', 'user'), $handle->getName()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    }

    /**
     * 一键删除会员帐号
     */
    public function remove_all()
    {
        $this->admin_priv('user_delete', ecjia::MSGTYPE_JSON);

        $user_id = !empty($_GET['id']) ? intval($_GET['id']) : 0;

        $handles = (new \Ecjia\App\User\UserCleanManager($user_id))->getFactories();

        if (!empty($handles)) {
            $remove_result = [];
            foreach ($handles as $k => $handle) {
                $handle_result = array(
                    'code'   => $handle->getCode(),
                    'name'   => $handle->getName(),
                    'result' => $handle->handleClean()
                );

                $remove_result[] = $handle_result;
            }

            $filter = [];
            if (!empty($remove_result)) {
                $filter = collect($remove_result)->where('result', false)->all();
            }

            if (!empty($filter)) {
                $error_html = '';
                foreach ($filter as $v) {
                    $error_html .= sprintf(__('%s删除失败；<br>', 'user'), $v['name']);
                }
                return $this->showmessage($error_html, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            RC_DB::table('users')->where('user_id', $user_id)->delete();

            RC_Session::flash('status', __('一键删除会员成功', 'user'));

            return $this->showmessage(__('一键删除会员成功', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => RC_Uri::url('user/admin/init')));
        }

        return $this->showmessage(__('操作失败', 'user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    }

    /**
     * 收货地址查看
     */
    public function address_list()
    {
        $this->admin_priv('user_manage');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('收货地址', 'user')));
        ecjia_screen::get_current_screen()->add_help_tab(array(
            'id'      => 'overview',
            'title'   => __('概述', 'user'),
            'content' =>
                '<p>' . __('欢迎访问ECJia智能后台会员收获地址列表页面，系统中所有的会员收获地址都会显示在此列表中。', 'user') . '</p>',
        ));

        ecjia_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . __('更多信息：', 'user') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:会员列表#.E6.94.B6.E8.B4.A7.E5.9C.B0.E5.9D.80" target="_blank">' . __('关于会员收获地址列表帮助文档', 'user') . '</a>') . '</p>'
        );

        $this->assign('ur_here', __('收货地址', 'user'));
        $this->assign('action_link', array('text' => __('会员列表', 'user'), 'href' => RC_Uri::url('user/admin/init')));

        $id        = !empty($_GET['id']) ? intval($_GET['id']) : 0;
        $user_name = RC_DB::table('users')->where('user_id', $id)->pluck('user_name');

        $act = !empty($_GET['type']) ? intval($_GET['type']) : '';

        /* 取用户默认地址id */
        $address_id = RC_DB::table('user_address as ua')
            ->leftJoin('users as u', RC_DB::raw('ua.address_id'), '=', RC_DB::raw('u.address_id'))
            ->where(RC_DB::raw('u.user_id'), $id)
            ->select(RC_DB::raw('ua.*'))
            ->first();

        $default_address_count = empty($address_id['address_id']) ? 0 : 1;

        /* 用户地址列表*/
        $db_user_address = RC_DB::table('user_address as ua')
            ->leftJoin('regions as c', RC_DB::raw('c.region_id'), '=', RC_DB::raw('ua.country'))
            ->leftJoin('regions as p', RC_DB::raw('p.region_id'), '=', RC_DB::raw('ua.province'))
            ->leftJoin('regions as t', RC_DB::raw('t.region_id'), '=', RC_DB::raw('ua.city'))
            ->leftJoin('regions as d', RC_DB::raw('d.region_id'), '=', RC_DB::raw('ua.district'))
            ->leftJoin('regions as s', RC_DB::raw('s.region_id'), '=', RC_DB::raw('ua.street'));

        if ($address_id) {
            $db_user_address
                ->orderBy('default_address', 'desc')
                ->select(RC_DB::raw("ua.*, IF(address_id=" . $address_id['address_id'] . ", 1, 0) as default_address, IFNULL(c.region_name, '') as country_name, IFNULL(p.region_name, '') as province_name, IFNULL(t.region_name, '') as city_name, IFNULL(d.region_name, '') as district_name, IFNULL(s.region_name, '') as street_name"));
        }

        $row = $db_user_address->where('user_id', $id)->get();

        $count = count($row);

        if ($act) {
            if (!empty($row)) {
                foreach ($row as $k => $v) {
                    if ($address_id['address_id'] != $v['address_id']) {
                        unset($row[$k]);
                    }
                }
            }
        }

        $this->assign('count', $count);
        $this->assign('default_count', $default_address_count);
        $this->assign('address_list', $row);
        $this->assign('id', $id);
        $this->assign('user_name', $user_name);

        $this->display('user_address_list.dwt');
    }

}

// end
