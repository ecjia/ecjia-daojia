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
 * ECJIA 会员提现管理
 */
class admin extends ecjia_admin
{

    public function __construct()
    {
        parent::__construct();

        RC_Loader::load_app_func('admin_user', 'finance');
        RC_Loader::load_app_func('global', 'goods');

        Ecjia\App\Withdraw\Helper::assign_adminlog_content();

        RC_Loader::load_app_class('user_account', 'user', false);

        /* 加载所需js */
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');

        //时间控件
        RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
        RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));

        RC_Script::enqueue_script('jquery-chosen');
        RC_Style::enqueue_style('chosen');
        RC_Script::enqueue_script('jquery-uniform');
        RC_Style::enqueue_style('uniform-aristo');

        RC_Script::enqueue_script('admin', RC_App::apps_url('statics/js/admin.js', __FILE__));
        RC_Style::enqueue_style('admin', RC_App::apps_url('statics/css/admin.css', __FILE__), array());

        RC_Script::enqueue_script('koala', RC_App::apps_url('statics/js/koala.js', __FILE__));

        $account_jslang = array(
            'keywords_required' => RC_Lang::get('user::user_account.keywords_required'),
            'username_required' => RC_Lang::get('user::user_account.username_required'),
            'amount_required'   => RC_Lang::get('user::user_account.amount_required'),
            'check_time'        => RC_Lang::get('user::user_account.check_time'),
        );
        RC_Script::localize_script('admin', 'account_jslang', $account_jslang);

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::user_account.withdraw_apply'), RC_Uri::url('withdraw/admin/init')));
    }

    /**
     * 提现申请列表
     */
    public function init()
    {
        $this->admin_priv('withdraw_manage');

        ecjia_screen::get_current_screen()->remove_last_nav_here();
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::user_account.withdraw_apply')));

        $this->assign('ur_here', RC_Lang::get('user::user_account.withdraw_apply'));
        $this->assign('action_link', array('text' => '线下提现申请', 'href' => RC_Uri::url('withdraw/admin/add')));

        $list = $this->get_withdraw_list();

        $this->assign('list', $list);
        $this->assign('filter', $list['filter']);
        $this->assign('type_count', $list['type_count']);

        $this->assign('form_action', RC_Uri::url('withdraw/admin/init'));
        $this->assign('batch_action', RC_Uri::url('withdraw/admin/batch_remove'));

        $this->display('admin_account_list.dwt');
    }

    public function add()
    {
        $this->admin_priv('withdraw_manage');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('线下提现申请'));

        $this->assign('ur_here', '线下提现申请');
        $this->assign('action_link', array('href' => RC_Uri::url('withdraw/admin/init'), 'text' => RC_Lang::get('user::user_account.withdraw_apply')));

        $payment     = get_payment();
        $has_payment = $has_pay_bank = false;

        if (!empty($payment)) {
            foreach ($payment as $k => $v) {
                // if (in_array($v['pay_code'], array('pay_wxpay', 'pay_bank'))) {
                if ($v['pay_code'] == 'pay_bank') {
                    $has_payment = true;
                    if ($v['pay_code'] == 'pay_bank') {
                        $has_pay_bank = true;
                    }
                }
            }
        }
        $this->assign('has_payment', $has_payment);
        $this->assign('has_pay_bank', $has_pay_bank);

        if (!$has_pay_bank) {
            $warning = __('您还没有安装银行转账插件，请去插件中心安装。');
            ecjia_screen::get_current_screen()->add_admin_notice(new admin_notice($warning));
        }

        $this->assign('form_action', RC_Uri::url('withdraw/admin/insert'));

        //最小提现金额
        $withdraw_min_amount = ecjia::config('withdraw_min_amount');
        $withdraw_min_amount = !empty($withdraw_min_amount) ? $withdraw_min_amount : 1;
        $this->assign('withdraw_min_amount', $withdraw_min_amount);

        $this->display('admin_account_edit.dwt');
    }

    /**
     * 添加提现申请
     */
    public function insert()
    {
        $this->admin_priv('withdraw_manage');

        /* 初始化变量 */
        $id           = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $apply_amount = !empty($_POST['apply_amount']) ? floatval($_POST['apply_amount']) : 0; //申请金额
        $process_type = 1; //提现
        $user_mobile  = !empty($_POST['user_mobile']) ? trim($_POST['user_mobile']) : '';
        $admin_note   = !empty($_POST['admin_note']) ? trim($_POST['admin_note']) : '';
        $user_note    = !empty($_POST['user_note']) ? trim($_POST['user_note']) : '';
        $payment      = trim($_POST['payment']);

        /* 验证参数有效性  */
        if (!is_numeric($apply_amount) || empty($apply_amount) || $apply_amount <= 0) {
            return $this->showmessage(RC_Lang::get('user::user_account.js_languages.deposit_amount_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $user_info = RC_DB::table('users')->where('mobile_phone', $user_mobile)->first();
        /* 此会员是否存在 */
        if (empty($user_info)) {
            return $this->showmessage(RC_Lang::get('user::user_account.username_not_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        //最小提现金额
        $withdraw_min_amount = ecjia::config('withdraw_min_amount');
        $withdraw_min_amount = !empty($withdraw_min_amount) ? $withdraw_min_amount : 1;
        if (abs($apply_amount) < $withdraw_min_amount) {
            return $this->showmessage('提现金额不能小于最低提现金额：' . $withdraw_min_amount . '元', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (empty($payment)) {
            return $this->showmessage(RC_Lang::get('user::user_account.js_languages.pay_code_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $withdraw_fee = ecjia::config('withdraw_fee');
        if ($withdraw_fee > 0) {
            $pay_fee = $apply_amount * $withdraw_fee / 100;
        } else {
            $pay_fee = 0.00;
        }

        /* 检查余额是否足够 */
        $user_account = user_account::get_user_money($user_info['user_id']);
        if ($apply_amount > ($user_account - $pay_fee)) {
            return $this->showmessage('您要申请提现的金额超过了您现有的余额，此操作将不可进行！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $is_paid = 0;
        if ($payment == 'pay_bank') {
            $is_paid = 1;
        }

        $order_sn = ecjia_order_deposit_sn();

        $data = array(
            'user_id'      => $user_info['user_id'],
            'admin_user'   => $_SESSION['admin_name'],
            'add_time'     => RC_Time::gmtime(),
            'admin_note'   => $admin_note,
            'user_note'    => $user_note,
            'process_type' => $process_type, //1 提现
            'payment'      => $payment,
            'is_paid'      => $is_paid,
            'order_sn'     => $order_sn,
            'pay_fee'      => $pay_fee, //手续费
            'amount'       => (-1) * $apply_amount, //申请金额
            'real_amount'  => $apply_amount - $pay_fee, //到帐金额
            'from_type'    => 'admim',
            'from_value'    => $user_info['user_id'],
        );

        if ($is_paid == 1) {
            $data['paid_time'] = RC_Time::gmtime();
        }
        $account_id = RC_DB::table('user_account')->insertGetId($data);

        if (empty($account_id)) {
            return $this->showmessage('此次操作失败，请返回重试！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        //提现申请成功，记录account_log；从余额中冻结提现金额
        $frozen_money = $apply_amount;
        $user_money   = '-' . $apply_amount;

        $options = array(
            'user_id'      => $_SESSION['user_id'],
            'frozen_money' => $frozen_money,
            'user_money'   => $user_money,
            'change_type'  => ACT_DRAWING,
            'change_desc'  => '【申请提现】，申请金额为：' . $apply_amount,
        );

        RC_Api::api('user', 'account_change_log', $options);

        ecjia_admin::admin_log(RC_Lang::get('user::user_account.log_username') . $user_info['user_name'] . ',' . '提现' . $amount, 'add', 'withdraw_apply');

        $links[0]['text'] = RC_Lang::get('user::user_account.back_withdraw_list');
        $links[0]['href'] = RC_Uri::url('withdraw/admin/init');
        $links[1]['text'] = RC_Lang::get('user::user_account.continue_add');
        $links[1]['href'] = RC_Uri::url('withdraw/admin/add');

        return $this->showmessage(RC_Lang::get('user::user_account.add_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('withdraw/admin/init')));
    }

    /**
     * 更新提现申请
     */
    public function update()
    {
        /* 权限判断 */
        $this->admin_priv('withdraw_manage', ecjia::MSGTYPE_JSON);

        $id          = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $admin_note  = !empty($_POST['admin_note']) ? trim($_POST['admin_note']) : '';
        $user_note   = !empty($_POST['user_note']) ? trim($_POST['user_note']) : '';
        $user_mobile = !empty($_POST['user_mobile']) ? trim($_POST['user_mobile']) : '';

        $info = RC_DB::table('user_account')->where('id', $id)->first();

        if (!empty($info['order_sn'])) {
            $order_sn = $info['order_sn'];
        } else {
            $order_sn = ecjia_order_deposit_sn();
        }

        /* 更新数据表 */
        $data = array(
            'admin_note' => $admin_note,
            'user_note'  => $user_note,
            'order_sn'   => $order_sn,
        );
        RC_DB::table('user_account')->where('id', $id)->update($data);

        if ($info['process_type'] == 0) {
            $account = RC_Lang::get('user::user_account.deposit');
        } else {
            $account        = RC_Lang::get('user::user_account.withdraw');
            $info['amount'] = abs($info['amount']);
        }

        ecjia_admin::admin_log(RC_Lang::get('user::user_account.log_username') . $user_name . ',' . $account . $info['amount'], 'edit', 'withdraw_apply');

        $links[0]['text'] = RC_Lang::get('user::user_account.back_withdraw_list');
        $links[0]['href'] = RC_Uri::url('withdraw/admin/init');

        return $this->showmessage(RC_Lang::get('user::user_account.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('withdraw/admin/check', array('id' => $id))));
    }

    /**
     * 更新会员余额的状态
     */
    public function action()
    {
        /* 检查权限 */
        $this->admin_priv('withdraw_manage', ecjia::MSGTYPE_JSON);

        /* 初始化 */
        $id         = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $is_paid    = isset($_POST['confirm']) ? 1 : 2;
        $admin_note = isset($_POST['admin_note']) ? trim($_POST['admin_note']) : '';

        /* 查询当前的预付款信息 */
        $account           = array();
        $account           = RC_DB::table('user_account')->where('id', $id)->first();
        $amount            = $account['amount'];
        $frozen_money      = $account['amount'];
        $user_frozen_money = user_account::get_frozen_money($account['user_id']);

        //到款状态不能再次修改
        if (!empty($account['is_paid'])) {
            return $this->showmessage('该订单已审核，请勿重复操作', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        /* 如果是退款申请, 并且已完成,更新此条记录,扣除相应的余额 */
        if ($is_paid == 1) {
            if ($account['process_type'] == 1) {
                //$user_account = get_user_surplus($account['user_id']);
                $user_account = user_account::get_user_money($account['user_id']);

                $fmt_amount = str_replace('-', '', $amount);

                /* 如果扣除的余额多于此会员的总冻结金额，提示 */
                if ($fmt_amount > $user_frozen_money) {
                    return $this->showmessage(RC_Lang::get('user::user_account.surplus_amount_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }

                update_user_account($id, $amount, $admin_note, 1);

                /* 更新会员余额数量 */
                // change_account_log($account['user_id'], $amount, 0, 0, 0, RC_Lang::get('user::user_account.surplus_type.1'), ACT_DRAWING); //提现申请时已记录

                //解冻提现时冻结的冻结金额
                $user_account = user_account::change_frozen_money($account['user_id'], $frozen_money);
            } else {
                /* 如果是预付款，并且已完成, 更新此条记录，增加相应的余额 */
                update_user_account($id, $amount, $admin_note, 1);

                /* 更新会员余额数量 */
                change_account_log($account['user_id'], $amount, 0, 0, 0, RC_Lang::get('user::user_account.surplus_type.0'), ACT_SAVING);
            }
        } else {
            /* 否则更新信息 */
            $data = array(
                'admin_user' => $_SESSION['admin_name'],
                'admin_note' => $admin_note,
                'is_paid'    => $is_paid,
                'review_time'=> RC_Time::gmtime()
            );
            //如果是提现且取消；解冻提现时冻结的冻结金额；返还余额
            if ($is_paid == 2 && $account['process_type'] == 1) {
                user_account::change_frozen_money($account['user_id'], $frozen_money); //冻结金额解冻
                user_account::change_user_money($account['user_id'], abs($account['amount'])); //返还余额
            }

            RC_DB::table('user_account')->where('id', $id)->update($data);
        }

        ecjia_admin::admin_log('(' . addslashes(RC_Lang::get('user::user_account.check')) . ')' . $admin_note, 'check', 'user_surplus');

        $links[0]['text'] = RC_Lang::get('user::user_account.back_withdraw_list');
        $links[0]['href'] = RC_Uri::url('withdraw/admin/init');

        return $this->showmessage(RC_Lang::get('user::user_account.attradd_succed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('withdraw/admin/check', array('id' => $id))));
    }

    /**
     * 删除一条信息
     */
    public function remove()
    {
        /* 检查权限 */
        $this->admin_priv('withdraw_manage', ecjia::MSGTYPE_JSON);

        $id = intval($_GET['id']);

        $user_account_info = RC_DB::table('user_account')->where('id', $id)->first();
        if (empty($user_account_info)) {
            return $this->showmessage('该记录不存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $userinfo = RC_DB::table('users')->where('user_id', $user_account_info['user_id'])->first();
        $name     = $userinfo['user_name'];
        //提现申请记录删除；且到款状态是未确认时；解冻提现申请时冻结的资金
        if ($user_account_info['process_type'] == '1') {
            if ($user_account_info['is_paid'] == '0') {
                $frozen_money = $user_account_info['amount'];
                $user_money   = abs($user_account_info['amount']);

                user_account::change_user_money($user_account_info['user_id'], $user_money); //返还余额
                user_account::change_frozen_money($user_account_info['user_id'], $frozen_money); //减掉冻结金额
            }
        }
        $user_name = empty($name) ? RC_Lang::get('user::users.no_name') : $name;

        RC_DB::table('user_account')->where('id', $id)->delete();
        ecjia_admin::admin_log(addslashes($user_name), 'remove', 'withdraw_apply');

        return $this->showmessage(RC_Lang::get('user::user_account.drop_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    /**
     * 批量删除
     */
    public function batch_remove()
    {
        /* 检查权限 */
        $this->admin_priv('withdraw_manage', ecjia::MSGTYPE_JSON);

        if (isset($_POST['checkboxes'])) {
            $idArr = explode(',', $_POST['checkboxes']);
            $count = count($idArr);
            $data  = RC_DB::table('user_account')->whereIn('id', $idArr)->get();
            RC_DB::table('user_account')->whereIn('id', $idArr)->delete();

            if (!empty($data)) {
                foreach ($data as $v) {
                    if ($v['process_type'] == 1) {
                        $amount = (-1) * $v['amount'];
                        //提现且状态为未确认的；返还余额；解冻冻结金额
                        if ($v['is_paid'] == '0') {
                            $frozen_money = $v['amount'];
                            $user_money   = abs($v['amount']);
                            user_account::change_user_money($v['user_id'], $user_money); //返还余额
                            user_account::change_frozen_money($v['user_id'], $frozen_money); //减掉冻结金额
                        }
                        ecjia_admin::admin_log(sprintf(RC_Lang::get('user::user_account.user_name_is'), $v['user_name']) . sprintf(RC_Lang::get('user::user_account.money_is'), price_format($amount)), 'batch_remove', 'withdraw_apply');
                    } else {
                        ecjia_admin::admin_log(sprintf(RC_Lang::get('user::user_account.user_name_is'), $v['user_name']) . sprintf(RC_Lang::get('user::user_account.money_is'), price_format($v['amount'])), 'batch_remove', 'recharge_apply');
                    }
                }
                return $this->showmessage(sprintf(RC_Lang::get('user::user_account.delete_record_count'), $count), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('withdraw/admin/init')));
            }
        } else {
            return $this->showmessage(RC_Lang::get('user::user_account.select_operate_item'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 审核提现详情
     */
    public function check()
    {
        $this->admin_priv('withdraw_manage');

        $text    = '提现申请';
        $ur_here = '提现详情';

        $this->assign('ur_here', $ur_here);
        $this->assign('action_link', array('text' => $text, 'href' => RC_Uri::url('withdraw/admin/init')));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($ur_here));

        $order_sn = isset($_GET['order_sn']) ? $_GET['order_sn'] : '';
        $id       = isset($_GET['id']) ? $_GET['id'] : 0;

        $account_info               = RC_DB::table('user_account')->where('id', $id)->first();
        $account_info['user_name']  = RC_DB::table('users')->where('user_id', $account_info['user_id'])->pluck('user_name');
        $account_info['pay_name']   = RC_DB::table('payment')->where('pay_code', $account_info['payment'])->pluck('pay_name');
        $apply_amount               = $account_info['apply_amount'] != 0 ? $account_info['apply_amount'] : abs($account_info['amount']);

        $account_info['formated_apply_amount']  = ecjia_price_format($apply_amount, false);
        $account_info['formated_pay_fee']       = ecjia_price_format($account_info['pay_fee'], false);
        $account_info['formated_amount']        = ecjia_price_format(abs($account_info['amount']), false);

        $account_info['user_note']  = htmlspecialchars($account_info['user_note']);
        $account_info['add_time']   = RC_Time::local_date(ecjia::config('time_format'), $account_info['add_time']);
        $account_info['pay_time']   = RC_Time::local_date(ecjia::config('time_format'), $account_info['paid_time']);
        $account_info['review_time']= RC_Time::local_date(ecjia::config('time_format'), $account_info['review_time']);

        //订单流程状态
        if ($account_info['is_paid'] == 0) {
            $is_paid = 0;
        } elseif ($account_info['is_paid'] == 1) {
            $is_paid = 1;
        } elseif ($account_info['is_paid'] == 2) {
            $is_paid = 2;
        }
        $this->assign('is_paid', $is_paid);

        $this->assign('check_action', RC_Uri::url('withdraw/admin/action'));
        $this->assign('form_action', RC_Uri::url('withdraw/admin/update'));

        $this->assign('account_info', $account_info);
        $this->assign('order_sn', $order_sn);
        $this->assign('id', $id);

        $this->display('admin_account_info.dwt');
    }

    /**
     * 账户信息ajax验证
     */
    public function validate_acount()
    {
        $user_mobile     = empty($_POST['user_mobile']) ? 0 : $_POST['user_mobile'];
        $user_info       = RC_DB::table('users')->where('mobile_phone', $user_mobile)->first();
        $wechat_nickname = '未绑定';

        if (empty($user_mobile)) {
            return $this->showmessage('会员手机号码不能为空！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } elseif (empty($user_info)) {
            return $this->showmessage('该手机号对应的会员信息不存在！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } else {
            $user_info['formated_user_money'] = ecjia_price_format($user_info['user_money'], false);

            $connect_info = RC_DB::table('connect_user')->where('connect_code', 'sns_wechat')->where('user_id', $user_info['user_id'])->first();

            if (!empty($connect_info)) {
                $ect_uid = RC_DB::table('wechat_user')->where('unionid', $connect_info['open_id'])->pluck('ect_uid');
                //修正绑定信息
                if (empty($ect_uid)) {
                    RC_DB::table('wechat_user')->where('unionid', $connect_info['open_id'])->update(array('ect_uid' => $connect_info['user_id']));
                }
                $wechat_info = RC_DB::table('wechat_user')->where('unionid', $connect_info['open_id'])->where('ect_uid', $connect_info['user_id'])->first();
                if (!empty($wechat_info)) {
                    $wechat_nickname = $wechat_info['nickname'];
                }
            }

            $result = array('status' => 1, 'username' => $user_info['user_name'], 'user_money' => $user_info['formated_user_money'], 'wechat_nickname' => $wechat_nickname);
            return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, $result);
        }
    }

    //计算提现手续费
    public function check_pay_fee()
    {
        $amount = floatval($_POST['val']);
        //提现手续费计算
        $withdraw_fee = ecjia::config('withdraw_fee');
        if ($withdraw_fee > 0) {
            $pay_fee = $amount * $withdraw_fee / 100;
        } else {
            $pay_fee = 0.00;
        }

        $result = array('pay_fee' => ecjia_price_format($pay_fee));
        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, $result);
    }

    public function download()
    {
        $data = $this->get_withdraw_list(true);

        RC_Excel::load(RC_APP_PATH . 'withdraw' . DIRECTORY_SEPARATOR . 'statics/files/withdraw.xls', function ($excel) use ($data) {
            $excel->sheet('First sheet', function ($sheet) use ($data) {
                foreach ($data as $k => $v) {
                    $sheet->appendRow($k + 2, $v);
                }
            });
        })->download('xls');
    }

    /**
     * 获取提现申请列表
     */
    private function get_withdraw_list($return_all = false)
    {
        $filter['start_date'] = empty($_GET['start_date']) ? '' : $_GET['start_date'];
        $filter['end_date']   = empty($_GET['end_date']) ? '' : $_GET['end_date'];
        $filter['keywords']   = trim($_GET['keywords']);
        $filter['type']       = trim($_GET['type']);

        $filter['sort_by']    = empty($_GET['sort_by']) ? 'ua.add_time' : trim($_GET['sort_by']);
        $filter['sort_order'] = empty($_GET['sort_order']) ? 'desc' : trim($_GET['sort_order']);

        $db_user_account = RC_DB::table('user_account as ua')
            ->leftJoin('users as u', RC_DB::raw('ua.user_id'), '=', RC_DB::raw('u.user_id'))
            ->where(RC_DB::raw('ua.process_type'), 1);

        if ($filter['keywords']) {
            $db_user_account->where(RC_DB::raw('u.user_name'), 'like', '%' . mysql_like_quote($filter['keywords']) . '%')
                ->orWhere(RC_DB::raw('u.mobile_phone'), 'like', '%' . mysql_like_quote($filter['keywords']) . '%');
        }

        if (!empty($filter['start_date'])) {
            $start_date = RC_Time::local_strtotime($filter['start_date']);
            $db_user_account->where('add_time', '>=', $start_date);
        }

        if (!empty($filter['end_date'])) {
            $end_date = RC_Time::local_strtotime($filter['end_date']);
            $db_user_account->where('add_time', '<', $end_date);
        }

        if ($return_all) {
            $list = $db_user_account
                ->where(RC_DB::raw('ua.is_paid'), 0)
                ->orderBy(RC_DB::raw($filter['sort_by']), $filter['sort_order'])
                ->select(RC_DB::raw('ua.*'), RC_DB::raw('u.user_name'))
                ->get();
        } else {
            $type_count = $db_user_account->select(RC_DB::raw('SUM(IF(ua.is_paid = 0, 1, 0)) as wait'),
                RC_DB::raw('SUM(IF(ua.is_paid = 1, 1, 0)) as finished'),
                RC_DB::raw('SUM(IF(ua.is_paid = 2, 1, 0)) as canceled'))->first();

            if ($filter['type'] == 'finished') {
                $db_user_account->where(RC_DB::raw('ua.is_paid'), 1);
            } elseif ($filter['type'] == 'canceled') {
                $db_user_account->where(RC_DB::raw('ua.is_paid'), 2);
            } else {
                $db_user_account->where(RC_DB::raw('ua.is_paid'), 0);
            }

            $count = $db_user_account->count();
            $page  = new ecjia_page($count, 15, 6);

            $list = $db_user_account
                ->orderBy(RC_DB::raw('ua.review_time'), 'desc')
                ->orderBy(RC_DB::raw($filter['sort_by']), $filter['sort_order'])
                ->take(15)
                ->skip($page->start_id - 1)
                ->select(RC_DB::raw('ua.*'), RC_DB::raw('u.user_name'))
                ->get();
        }

        $payment_method = RC_Loader::load_app_class('payment_method', 'payment');
        $payment_list   = $payment_method->available_payment_list(false);

        $pay_name = array();
        if (!empty($payment_list) && is_array($payment_list)) {
            foreach ($payment_list as $key => $value) {
                $pay_name[$value['pay_code']] = $value['pay_name'];
            }
        }

        $withdraw_fee = ecjia::config('withdraw_fee');

        $arr = [];
        if (!empty($list)) {
            foreach ($list as $key => $value) {
                $apply_amount               = abs($value['amount']);
                $list[$key]['apply_amount'] = ecjia_price_format($apply_amount);
                $list[$key]['add_date']     = RC_Time::local_date(ecjia::config('time_format'), $value['add_time']);
                $list[$key]['payment']      = empty($pay_name[$value['payment']]) ? '银行转账' : strip_tags($pay_name[$value['payment']]);

                $list[$key]['pay_fee']          = $value['pay_fee'];
                $list[$key]['formated_pay_fee'] = ecjia_price_format($value['pay_fee']);

                $real_amount                    = abs($value['amount']) - $value['pay_fee'];
                $list[$key]['formated_amount']  = ecjia_price_format($real_amount);

                $arr[$key]['order_sn']              = $list[$key]['order_sn'];
                $arr[$key]['user_name']             = $list[$key]['user_name'];
                $arr[$key]['apply_amount']          = $list[$key]['apply_amount'];
                $arr[$key]['formated_pay_fee']      = $list[$key]['formated_pay_fee'];
                $arr[$key]['formated_amount']       = $list[$key]['formated_amount'];
                $arr[$key]['payment']               = $list[$key]['payment'];
                $arr[$key]['add_date']              = $list[$key]['add_date'];
                $arr[$key]['status']                = $list[$key]['is_paid'] == 1 ? '已完成' : ($list[$key]['is_paid'] == 0 ? '待审核' : '已取消');
            }
        }
        

        if ($return_all) {
            return $arr;
        }

        return array('list' => $list, 'filter' => $filter, 'page' => $page->show(5), 'desc' => $page->page_desc(), 'type_count' => $type_count);
    }

}

// end
