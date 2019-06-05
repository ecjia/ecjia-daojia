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

        RC_Script::localize_script('admin', 'js_lang', config('app-withdraw::jslang.admin_page'));

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('提现申请', 'withdraw'), RC_Uri::url('withdraw/admin/init')));
    }

    /**
     * 提现申请列表
     */
    public function init()
    {
        $this->admin_priv('withdraw_manage');

        ecjia_screen::get_current_screen()->remove_last_nav_here();
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('提现申请', 'withdraw')));

        $this->assign('ur_here', __('提现申请', 'withdraw'));
        $this->assign('action_link', array('text' => __('线下提现申请', 'withdraw'), 'href' => RC_Uri::url('withdraw/admin/add')));

        $list = $this->get_withdraw_list();

        $this->assign('list', $list);
        $this->assign('filter', $list['filter']);
        $this->assign('type_count', $list['type_count']);

        $this->assign('form_action', RC_Uri::url('withdraw/admin/init'));
        $this->assign('batch_action', RC_Uri::url('withdraw/admin/batch_remove'));

        return $this->display('admin_account_list.dwt');
    }

    public function add()
    {
        $this->admin_priv('withdraw_update');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('线下提现申请', 'withdraw')));

        $this->assign('ur_here', __('线下提现申请', 'withdraw'));
        $this->assign('action_link', array('href' => RC_Uri::url('withdraw/admin/init'), 'text' => __('提现申请', 'withdraw')));

        $withdraw_bank = new \Ecjia\App\Withdraw\WithdrawBankType();
        $plugins       = $withdraw_bank->getPlugins();

        if (empty($plugins)) {
            $url     = RC_Uri::url('@admin_plugin/init', array('usepluginsnum' => 2));
            $warning = sprintf(__('您还没有安装银行转账插件，请去插件中心安装。%s点击去安装%s', 'article'), '<a target="_blank" href=' . $url . '>', "</a>");

            ecjia_screen::get_current_screen()->add_admin_notice(new admin_notice($warning));
        }

        $this->assign('plugins', $plugins->toArray());

        $this->assign('form_action', RC_Uri::url('withdraw/admin/insert'));

        //最小提现金额
        $withdraw_min_amount = ecjia::config('withdraw_min_amount');
        $withdraw_min_amount = !empty($withdraw_min_amount) ? $withdraw_min_amount : 1;
        $this->assign('withdraw_min_amount', $withdraw_min_amount);

        $id = intval($_GET['user_id']);

        if (!empty($id)) {
            $user_info = get_user_info($id);

            if (!empty($user_info)) {
                $this->assign('user', $user_info);

                $content = $this->get_card_content($user_info);

                $this->assign('content', $content);
            }
        }

        return $this->display('admin_account_edit.dwt');
    }

    /**
     * 添加提现申请
     */
    public function insert()
    {
        $this->admin_priv('withdraw_update', ecjia::MSGTYPE_JSON);

        /* 初始化变量 */
        $id           = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $apply_amount = !empty($_POST['apply_amount']) ? floatval($_POST['apply_amount']) : 0; //申请金额
        $user_id      = !empty($_POST['user_id']) ? intval($_POST['user_id']) : '';
        $admin_note   = !empty($_POST['admin_note']) ? trim($_POST['admin_note']) : '';
        $payment      = trim($_POST['payment']);

        //银行信息
        $bank_card = trim($_POST['bank_card']);

        /* 验证参数有效性  */
        if (!is_numeric($apply_amount) || empty($apply_amount) || $apply_amount <= 0) {
            return $this->showmessage(__('请按正确的格式输入充值的金额！', 'withdraw'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $user_info = RC_DB::table('users')->where('user_id', $user_id)->first();
        /* 此会员是否存在 */
        if (empty($user_info)) {
            return $this->showmessage(__('该会员信息不存在', 'withdraw'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (empty($payment)) {
            return $this->showmessage(__('请选择提现方式', 'withdraw'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $UserAccountBalance = new \Ecjia\App\Finance\UserAccountBalance($user_info['user_id']);

        /* 检查余额是否足够 */
        $user_balance = $UserAccountBalance->getUserMoney();
        if ($apply_amount > $user_balance) {
            return $this->showmessage(__('您要申请提现的金额超过了您现有的余额，此操作将不可进行！', 'withdraw'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $withdraw_plugin = new \Ecjia\App\Withdraw\WithdrawPlugin();
        $plugin          = $withdraw_plugin->channel($payment);
        if (is_ecjia_error($plugin)) {
            return $this->showmessage($plugin->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $order_sn = ecjia_order_deposit_sn();

        $UserAccountRepository = new Ecjia\App\Withdraw\Repositories\UserAccountRepository();

        //现金提现
        if ($payment == 'withdraw_cash') {
            $data = array(
                'user_id'      => $user_info['user_id'],
                'order_sn'     => $order_sn,
                'admin_user'   => $_SESSION['admin_name'],
                'admin_note'   => $admin_note,
                'payment'      => $payment,
                'payment_name' => $plugin->getName(),
                'from_type'    => 'admim',
                'from_value'   => $user_info['user_id'],
                'user_note'    => ''
            );
        } else {
            $user_bank_card = $plugin->getUserBankcard($user_id)->where('bank_card', $bank_card)->first();
            if (empty($user_bank_card)) {
                return $this->showmessage(__('没有绑定提现账户信息', 'withdraw'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $user_bank_card = $user_bank_card->toArray();

            $data = array(
                'user_id'          => $user_info['user_id'],
                'order_sn'         => $order_sn,
                'admin_user'       => $_SESSION['admin_name'],
                'admin_note'       => $admin_note,
                'payment'          => $payment,
                'payment_name'     => $plugin->getName(),
                'from_type'        => 'admim',
                'from_value'       => $user_info['user_id'],
                'bank_name'        => $user_bank_card['bank_name'],
                'bank_branch_name' => $user_bank_card['bank_branch_name'],
                'bank_card'        => $user_bank_card['bank_card'],
                'cardholder'       => $user_bank_card['cardholder'],
                'bank_en_short'    => $user_bank_card['bank_en_short'],
                'user_note'        => ''
            );
        }

        $model = $UserAccountRepository->insertUserAccount($data, $apply_amount);

        $UserAccountBalance->withdrawApply($apply_amount, sprintf(__('【申请提现】，申请金额为：%s', 'withdraw'), $apply_amount));

        if (empty($model)) {
            return $this->showmessage(__('此次操作失败，请返回重试！', 'withdraw'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        ecjia_admin::admin_log(sprintf(__('会员名称是：%s，提现金额：%s', 'withdraw'), $user_info['user_name'], $apply_amount), 'add', 'withdraw_apply');

        $links = [
            [
                'text' => __('返回提现申请', 'withdraw'),
                'href' => RC_Uri::url('withdraw/admin/init'),
            ],
            [
                'text' => __('继续添加申请', 'withdraw'),
                'href' => RC_Uri::url('withdraw/admin/add')
            ]
        ];

        $pjaxurl = RC_Uri::url('withdraw/admin/init');

        return $this->showmessage(__('添加成功！', 'withdraw'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => $pjaxurl));
    }

    /**
     * 审核提现详情
     */
    public function check()
    {
        $this->admin_priv('withdraw_manage');

        $text    = __('提现申请', 'withdraw');
        $ur_here = __('提现详情', 'withdraw');

        $this->assign('ur_here', $ur_here);
        $this->assign('action_link', array('text' => $text, 'href' => RC_Uri::url('withdraw/admin/init')));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($ur_here));

        $order_sn = isset($_GET['order_sn']) ? $_GET['order_sn'] : '';
        $id       = isset($_GET['id']) ? $_GET['id'] : 0;

        $account_info              = RC_DB::table('user_account')->where('id', $id)->first();
        $account_info['user_name'] = RC_DB::table('users')->where('user_id', $account_info['user_id'])->pluck('user_name');

        $apply_amount = $account_info['apply_amount'] != 0 ? $account_info['apply_amount'] : abs($account_info['amount']);

        $account_info['formated_apply_amount'] = ecjia_price_format($apply_amount, false);
        $account_info['formated_pay_fee']      = ecjia_price_format($account_info['pay_fee'], false);
        $account_info['formated_real_amount']  = ecjia_price_format(abs($account_info['real_amount']), false);

        $account_info['user_note']   = htmlspecialchars($account_info['user_note']);
        $account_info['add_time']    = RC_Time::local_date(ecjia::config('time_format'), $account_info['add_time']);
        $account_info['pay_time']    = RC_Time::local_date(ecjia::config('time_format'), $account_info['paid_time']);
        $account_info['review_time'] = RC_Time::local_date(ecjia::config('time_format'), $account_info['review_time']);

        //订单流程状态
        if ($account_info['is_paid'] == 0) {
            $is_paid = 0;
        } elseif ($account_info['is_paid'] == 1) {
            $is_paid = 1;
        } elseif ($account_info['is_paid'] == 2) {
            $is_paid = 2;
        }
        $this->assign('is_paid', $is_paid);

        $this->assign('form_action', RC_Uri::url('withdraw/admin/action'));

        if ($account_info['bank_en_short'] !== 'WECHAT') {
            $account_info['formated_payment_name'] = !empty($account_info['bank_name']) ? $account_info['bank_name'] . ' (' . $account_info['bank_card'] . ')' : '';
        } else {
            $account_info['formated_payment_name'] = $account_info['bank_name'] . ' (' . $account_info['cardholder'] . ')';
        }
        $this->assign('account_info', $account_info);
        $this->assign('order_sn', $order_sn);
        $this->assign('id', $id);

        $record_info = (new \Ecjia\App\Withdraw\Repositories\WithdrawRecordRepository())->findWithdrawOrderSn($account_info['order_sn']);

        if (!empty($record_info)) {
            $record_info = $record_info->toArray();

            $record_info['create_time']   = !empty($record_info['create_time']) ? RC_Time::local_date(ecjia::config('time_format'), $record_info['create_time']) : '';
            $record_info['payment_time']  = !empty($record_info['payment_time']) ? RC_Time::local_date(ecjia::config('time_format'), $record_info['payment_time']) : '';
            $record_info['transfer_time'] = !empty($record_info['create_time']) ? RC_Time::local_date(ecjia::config('time_format'), $record_info['transfer_time']) : '';

            $record_info['label_withdraw_status'] = \Ecjia\App\Withdraw\WithdrawConstant::getWithdrawRecordStatus($record_info['withdraw_status']);
        }
        $this->assign('record_info', $record_info);

        return $this->display('admin_account_info.dwt');
    }

    /**
     * 更新会员余额的状态
     */
    public function action()
    {
        /* 检查权限 */
        $this->admin_priv('withdraw_check', ecjia::MSGTYPE_JSON);

        /* 初始化 */
        $id         = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $is_paid    = isset($_POST['confirm']) ? 1 : 2;
        $admin_note = isset($_POST['admin_note']) ? trim($_POST['admin_note']) : '';

        try {

            /* 查询当前的预付款信息 */
            $account = (new Ecjia\App\Withdraw\Repositories\UserAccountRepository)->findWithdraw($id);
            //到款状态不能再次修改
            if (!empty($account['is_paid'])) {
                return $this->showmessage(__('该订单已审核，请勿重复操作', 'withdraw'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            /* 同意,更新此条记录,扣除相应的余额 */
            if ($is_paid == 1) {
                $amount            = $account['amount'];
                $user_frozen_money = user_account::get_frozen_money($account['user_id']);
                $fmt_amount        = abs($amount);
                /* 如果扣除的余额多于此会员的总冻结金额，提示 */
                if ($fmt_amount > $user_frozen_money) {
                    return $this->showmessage(__('要提现的金额超过了此会员的帐户余额，此操作将不可进行！', 'withdraw'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }

                $WithdrawRecordRepository = new \Ecjia\App\Withdraw\Repositories\WithdrawRecordRepository();
                $WithdrawRecordRepository->createWithdrawRecord([
                    'order_sn'           => $account['order_sn'],
                    'withdraw_code'      => $account['payment'],
                    'withdraw_name'      => $account['payment_name'],
                    'withdraw_amount'    => $account['real_amount'],
                    'transfer_bank_no'   => $account['bank_card'],
                    'transfer_true_name' => $account['cardholder'],
                	'transfer_bank_code' => $account['bank_branch_name'],
                ]);

                $result = (new \Ecjia\App\Withdraw\Transfers\TransferManager($account['order_sn']))->transfer();

                if (is_ecjia_error($result)) {
                    //返回错误信息到页面上
                    return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }

                (new \Ecjia\App\Withdraw\Orders\WithdrawOrderSuccessProcess($account['order_sn']))->process($_SESSION['admin_name'], $admin_note);

            } else {
                //取消提现后，返还用户资金
                (new \Ecjia\App\Withdraw\Orders\WithdrawOrderFailedProcess($account['order_sn']))->process($_SESSION['admin_name'], $admin_note);
            }

            ecjia_admin::admin_log($admin_note, 'check', 'user_surplus');

            $links = [
                [
                    'text' => __('返回提现申请', 'withdraw'),
                    'href' => RC_Uri::url('withdraw/admin/init'),
                ]
            ];

            $pjaxurl = RC_Uri::url('withdraw/admin/check', array('id' => $id));

            return $this->showmessage(__('您此次操作已成功！', 'withdraw'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => $pjaxurl));

        } catch (\Royalcms\Component\Database\QueryException $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

    }

    //对账查询
    public function query()
    {

        /* 检查权限 */
        $this->admin_priv('withdraw_update', ecjia::MSGTYPE_JSON);

        /* 初始化 */
        $id = $this->request->input('id');

        try {
            /* 查询当前的预付款信息 */
            $account = (new Ecjia\App\Withdraw\Repositories\UserAccountRepository)->findWithdraw($id);

            //到款状态不能再次修改
            if (empty($account)) {
                return $this->showmessage(__('该订单不存在', 'withdraw'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $result = (new \Ecjia\App\Withdraw\Transfers\TransferQueryManager($account['order_sn']))->transfer();

            if (is_ecjia_error($result)) {
                return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            return $this->showmessage(__('与支付机构对账成功，状态正常', 'withdraw'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);

        } catch (\Royalcms\Component\Database\QueryException $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 删除一条信息
     */
    public function remove()
    {
        /* 检查权限 */
        $this->admin_priv('withdraw_delete', ecjia::MSGTYPE_JSON);

        $id = intval($_GET['id']);

        try {
            $user_account_info = RC_DB::table('user_account')->where('id', $id)->first();
            if (empty($user_account_info)) {
                return $this->showmessage(__('该记录不存在', 'withdraw'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $userinfo = RC_DB::table('users')->where('user_id', $user_account_info['user_id'])->first();
            $name     = $userinfo['user_name'];

            //提现申请记录删除；且到款状态是未确认时；解冻提现申请时冻结的资金
            if ($user_account_info['process_type'] == 1) {
                if (empty($user_account_info['is_paid'])) {
                    $frozen_money = $user_account_info['amount'];
                    $user_money   = abs($user_account_info['amount']);

                    user_account::change_user_money($user_account_info['user_id'], $user_money); //返还余额
                    user_account::change_frozen_money($user_account_info['user_id'], $frozen_money); //减掉冻结金额
                }
            }
            $user_name = empty($name) ? __('匿名购买', 'withdraw') : $name;

            RC_DB::table('user_account')->where('id', $id)->delete();
            ecjia_admin::admin_log(addslashes($user_name), 'remove', 'withdraw_apply');

            return $this->showmessage(__('删除成功', 'withdraw'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);

        } catch (\Royalcms\Component\Database\QueryException $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 批量删除
     */
    public function batch_remove()
    {
        /* 检查权限 */
        $this->admin_priv('withdraw_delete', ecjia::MSGTYPE_JSON);

        try {
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
                            if (empty($v['is_paid'])) {
                                $frozen_money = $v['amount'];
                                $user_money   = abs($v['amount']);
                                user_account::change_user_money($v['user_id'], $user_money); //返还余额
                                user_account::change_frozen_money($v['user_id'], $frozen_money); //减掉冻结金额
                            }
                            ecjia_admin::admin_log(sprintf(__('会员名称是%s，金额是%s', 'withdraw'), $v['user_name'], ecjia_price_format($amount)), 'batch_remove', 'withdraw_apply');
                        } else {
                            ecjia_admin::admin_log(sprintf(__('会员名称是%s，金额是%s', 'withdraw'), $v['user_name'], ecjia_price_format($v['amount'])), 'batch_remove', 'recharge_apply');
                        }
                    }
                    return $this->showmessage(sprintf(__('本次删除了%s条记录', 'withdraw'), $count), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('withdraw/admin/init')));
                }
            } else {
                return $this->showmessage(__('请先选择需要操作的项', 'withdraw'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

        } catch (\Royalcms\Component\Database\QueryException $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 账户信息ajax验证
     */
    public function validate_acount()
    {
        $user_mobile = empty($_POST['user_mobile']) ? 0 : $_POST['user_mobile'];
        $user_info   = RC_DB::table('users')->where('mobile_phone', $user_mobile)->first();

        try {
            if (empty($user_mobile)) {
                return $this->showmessage(__('会员手机号码不能为空！', 'withdraw'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            } elseif (empty($user_info)) {
                return $this->showmessage(__('该手机号对应的会员信息不存在！', 'withdraw'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            } else {
                $user_info['formated_user_money'] = ecjia_price_format($user_info['user_money'], false);

                $result = array(
                    'status'  => 1,
                    'user_id' => $user_info['user_id']
                );

                $content = $this->get_card_content($user_info);

                return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('result' => $result, 'content' => $content));
            }
        } catch (\Royalcms\Component\Database\QueryException $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
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

        RC_Excel::load(RC_APP_PATH . 'withdraw' . DIRECTORY_SEPARATOR . 'statics/files/withdraw.xlsx', function ($excel) use ($data) {
            $excel->sheet('First sheet', function ($sheet) use ($data) {
                foreach ($data as $k => $v) {
                    $sheet->appendRow($k + 2, $v);
                }
            });
        })->download('xlsx');
    }

    public function get_user_bank()
    {
        $code    = trim($_POST['code']);
        $user_id = intval($_POST['user_id']);

        $withdraw_plugin = new \Ecjia\App\Withdraw\WithdrawPlugin();

        $plugin = $withdraw_plugin->channel($code);

        if (is_ecjia_error($plugin)) {
            return $this->showmessage($plugin->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        try {

            $user_bank_card = $plugin->getUserBankcard($user_id)->first();

        } catch (\Royalcms\Component\Database\QueryException $e) {

            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $content = '';
        if ($code != 'withdraw_cash') {

            if (empty($user_bank_card)) {
                return $this->showmessage(__('没有绑定提现账户信息', 'withdraw'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $user_bank_card = $user_bank_card->toArray();

            $this->assign('user_bank_card', $user_bank_card);

            $content = $this->fetch('library/user_bank_card.lbi');
        }

        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $content));
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
            $keywords = $filter['keywords'];
            $db_user_account->where(function ($query) use ($keywords) {
                $query->where(RC_DB::raw('u.user_name'), 'like', '%' . mysql_like_quote($keywords) . '%')
                    ->orWhere(RC_DB::raw('u.mobile_phone'), 'like', '%' . mysql_like_quote($keywords) . '%');
            });
        }

        if (!empty($filter['start_date'])) {
            $start_date = RC_Time::local_strtotime($filter['start_date']);
            $db_user_account->where('add_time', '>=', $start_date);
        }

        if (!empty($filter['end_date'])) {
            $end_date = RC_Time::local_strtotime($filter['end_date']);
            $db_user_account->where('add_time', '<', $end_date);
        }

        $type_count = [];
        if ($return_all) {
            $list = $db_user_account
                ->where(RC_DB::raw('ua.is_paid'), 0)
                ->orderBy(RC_DB::raw($filter['sort_by']), $filter['sort_order'])
                ->select(RC_DB::raw('ua.*'), RC_DB::raw('u.user_name'))
                ->get();

            $arr = [];
            if (!empty($list)) {
                foreach ($list as $key => $value) {
                    $apply_amount              = abs($value['amount']);
                    $value['apply_amount']     = ecjia_price_format($apply_amount);
                    $value['add_date']         = RC_Time::local_date(ecjia::config('time_format'), $value['add_time']);
                    $value['formated_pay_fee'] = ecjia_price_format($value['pay_fee']);
                    $real_amount               = abs($value['amount']) - $value['pay_fee'];
                    $value['formated_amount']  = ecjia_price_format($real_amount);

                    $arr[$key]['order_sn']         = $value['order_sn'];
                    $arr[$key]['user_name']        = !empty($value['user_name']) ? RC_Format::filterEmoji($value['user_name']) : __('匿名购买', 'withdraw');
                    $arr[$key]['apply_amount']     = $value['apply_amount'];
                    $arr[$key]['formated_pay_fee'] = $value['formated_pay_fee'];
                    $arr[$key]['formated_amount']  = $value['formated_amount'];
                    $arr[$key]['payment_name']     = !empty($value['payment_name']) ? $value['payment_name'] : __('银行转账提现', 'withdraw');
                    $arr[$key]['add_date']         = $value['add_date'];
                    $arr[$key]['status']           = $value['is_paid'] == 1 ? __('已完成', 'withdraw') : ($value['is_paid'] == 0 ? __('待审核', 'withdraw') : __('已取消', 'withdraw'));
                }
            }
            return $arr;
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
                ->orderBy(RC_DB::raw($filter['sort_by']), $filter['sort_order'])
                ->take(15)
                ->skip($page->start_id - 1)
                ->select(RC_DB::raw('ua.*'), RC_DB::raw('u.user_name'))
                ->get();
        }


        if (!empty($list)) {
            foreach ($list as $key => $value) {
                $apply_amount                   = abs($value['amount']);
                $list[$key]['apply_amount']     = ecjia_price_format($apply_amount);
                $list[$key]['add_date']         = RC_Time::local_date(ecjia::config('time_format'), $value['add_time']);
                $list[$key]['payment_name']     = $value['payment_name'];
                $list[$key]['pay_fee']          = $value['pay_fee'];
                $list[$key]['formated_pay_fee'] = ecjia_price_format($value['pay_fee']);

                $real_amount                   = abs($value['amount']) - $value['pay_fee'];
                $list[$key]['formated_amount'] = ecjia_price_format($real_amount);
            }
        }
        return array('list' => $list, 'filter' => $filter, 'page' => $page->show(5), 'desc' => $page->page_desc(), 'type_count' => $type_count);
    }

    private function get_card_content($user_info = [])
    {
        $user_info['avatar_img'] = !empty($user_info['avatar_img']) ? RC_Upload::upload_url($user_info['avatar_img']) : RC_App::apps_url('statics/images/default-avatar-60.png', __FILE__);

        if ($user_info['user_rank'] == 0) {
            //重新计算会员等级
            $row_rank = RC_Api::api('user', 'update_user_rank', array('user_id' => $user_info['user_id']));
        } else {
            $row_rank = RC_DB::table('user_rank')->where('rank_id', $user_info['user_rank'])->first();
        }

        $user_binded_list = [];
        $bank_list        = RC_DB::table('withdraw_user_bank')->where('user_id', $user_info['user_id'])->where('user_type', 'user')->get();
        if ($bank_list) {
            foreach ($bank_list as $val) {
                $formated_pay_name = $val['bank_name'];

                if ($val['bank_type'] == 'bank') {
                    $bank      = Ecjia\App\Setting\BankWithdraw::getBankInfoByEnShort($val['bank_en_short']);
                    $bank_icon = $bank['bank_icon'];

                    if (!empty($val['bank_name']) && !empty($val['bank_card'])) {
                        $bank_card_str = substr($val['bank_card'], -4);

                        $formated_pay_name = $val['bank_name'] . ' (' . $bank_card_str . ')';
                    }

                } elseif ($val['bank_type'] == 'wechat') {
                    $bank_icon = RC_App::apps_url('statics/images/wechat.png', __FILE__);

                    if (!empty($val['bank_name']) && !empty($val['cardholder'])) {
                        $formated_pay_name = $val['bank_name'] . ' (' . $val['cardholder'] . ')';
                    }

                }

                $user_binded_list[] = [
                    'id'                => intval($val['id']),
                    'bank_icon'         => $bank_icon,
                    'formated_pay_name' => $formated_pay_name,
                ];
            }
        }

        $data = array(
            'user_id'             => $user_info['user_id'],
            'avatar_img'          => $user_info['avatar_img'],
            'user_name'           => $user_info['user_name'],
            'formated_user_money' => $user_info['formated_user_money'],
            'rank_name'           => $row_rank['rank_name'],
            'user_binded_list'    => $user_binded_list,
            'unbind_icon'         => RC_App::apps_url('statics/images/unbind.png', __FILE__)
        );
        $this->assign('data', $data);
        $content = $this->fetch('library/user_card.lbi');

        return $content;
    }
}

// end
