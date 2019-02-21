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
 *返回用户列表数据
 * @accesspublic
 * @param
 * @return void
 */

function get_user_list($args = array())
{

    $db_user              = RC_DB::table('users');
    $filter['keywords']   = empty($args['keywords']) ? '' : trim($args['keywords']);
    $filter['rank']       = empty($args['rank']) ? 0 : intval($args['rank']);
    $filter['sort_by']    = empty($args['sort_by']) ? 'user_id' : trim($args['sort_by']);
    $filter['sort_order'] = empty($args['sort_order']) ? 'DESC' : trim($args['sort_order']);

    if ($filter['keywords']) {
        $db_user->whereRaw("(user_name LIKE '%" . mysql_like_quote($filter['keywords']) . "%' or email like '%" . $filter['keywords'] . "%' or mobile_phone like '%" . $filter['keywords'] . "%')");
    }
    if ($filter['rank']) {
        $db_user->where('user_rank', $filter['rank']);
    }

    $count = $db_user->count();

    if ($count != 0) {
        /* 实例化分页 */
        $page = new ecjia_page($count, 15, 6);
        /* 查询所有用户信息*/
        $data = $db_user
            ->orderBy($filter['sort_by'], $filter['sort_order'])
            ->select('user_id', 'user_name', 'email', 'is_validated', 'user_money', 'frozen_money', 'rank_points', 'pay_points', 'reg_time', 'mobile_phone', 'user_rank')
            ->take(15)
            ->skip($page->start_id - 1)
            ->get();

        $user_list = array();
        foreach ($data as $rows) {
            $rows['reg_time']  = RC_Time::local_date(ecjia::config('time_format'), $rows['reg_time']);
            $rank_info         = RC_DB::table('user_rank')->where('rank_id', $rows['user_rank'])->first();
            $rows['rank_name'] = $rank_info['rank_name'];
            $user_list[]       = $rows;
        }
        return array('user_list' => $user_list, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc());
    }
}


/**
 * 获取启用的支付方式下拉列表
 */
function get_payment($cod_fee = 0)
{
    $payment_method = RC_Loader::load_app_class('payment_method', 'payment');
    return $payment_method->get_online_payment_list(false);
}

/**
 * 获取充值和提现申请列表
 * @param unknown $args
 */
function get_account_list($args = array())
{

    $payment_method = RC_Loader::load_app_class('payment_method', 'payment');

    $filter['user_id']      = empty($args['user_id']) ? 0 : intval($args['user_id']);
    $filter['keywords']     = empty($args['keywords']) ? '' : trim($args['keywords']);
    $filter['process_type'] = isset($args['process_type']) ? intval($args['process_type']) : -1;
    $filter['payment']      = empty($args['payment']) ? '' : trim($args['payment']);
    $filter['is_paid']      = isset($args['is_paid']) ? intval($args['is_paid']) : -1;
    $filter['start_date']   = empty($args['start_date']) ? '' : $args['start_date'];
    $filter['end_date']     = empty($args['end_date']) ? '' : $args['end_date'];

    $filter['sort_by']    = empty($_REQUEST['sort_by']) ? 'add_time' : trim($_REQUEST['sort_by']);
    $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);
    $db_user_account      = RC_DB::table('user_account as ua')->leftJoin('users as u', RC_DB::raw('ua.user_id'), '=', RC_DB::raw('u.user_id'));

    if ($filter['user_id'] > 0) {
        $db_user_account->where(RC_DB::raw('ua.user_id'), $filter['user_id']);
    }
    if ($filter['process_type'] != -1) {
        $db_user_account->where(RC_DB::raw('process_type'), $filter['process_type']);
    }
    if ($filter['payment']) {
        $payment = $payment_method->payment_info_by_name($filter['payment']);

        if (!empty($payment) && is_array($payment)) {
            foreach ($payment as $key => $value) {
//                array_push($where['ua.payment'], $value['pay_name'], $value['pay_code']);
                $db_user_account->whereIn(RC_DB::raw('ua.payment'), array($value['pay_name'], $value['pay_code']));
            }
        }
    }
    if ($filter['is_paid'] != -1) {
        $db_user_account->where(RC_DB::raw('is_paid'), $filter['is_paid']);
    }

    if ($filter['keywords']) {
        $db_user_account->where(RC_DB::raw('u.user_name'), 'like', '%' . mysql_like_quote($filter['keywords']) . '%');
    }

    /*　时间过滤　*/
    $start_date = RC_Time::local_strtotime($args['start_date']);
    $end_date   = RC_Time::local_strtotime($args['end_date']) + 86400;

    if (!empty($args['start_date']) && !empty($args['end_date'])) {

        $db_user_account->where('add_time', '>=', $start_date)
            ->where('add_time', '<=', $end_date);
    } else {
        if (!empty($args['start_date'])) {

            $db_user_account->where('add_time', '>=', $start_date);
        } elseif (!empty($args['end_date'])) {

            $db_user_account->where('add_time', '<=', $end_date);
        }
    }

    $count = $db_user_account->count();

    /* 实例化分页 */
    $page = new ecjia_page($count, 15, 6);

    $list = array();
    if ($count != 0) {
        $payment_list = $payment_method->available_payment_list(false);
        $pay_name     = array();
        if (!empty($payment_list) && is_array($payment_list)) {
            foreach ($payment_list as $key => $value) {
                $pay_name[$value['pay_code']] = $value['pay_name'];

            }
        }

        $list = $db_user_account->orderBy($filter['sort_by'], $filter['sort_order'])->take(15)->skip($page->start_id - 1)->select(RC_DB::raw('ua.*'), RC_DB::raw('u.user_name'))->get();

        if (!empty($list)) {
            foreach ($list AS $key => $value) {
                $list[$key]['surplus_amount']    = price_format(abs($value['amount']), false);
                $list[$key]['add_date']          = RC_Time::local_date(ecjia::config('time_format'), $value['add_time']);
                $list[$key]['process_type_name'] = $value['process_type'] == 1 ? __('提现', 'user') : __('充值', 'user');
                /* php 过滤html标签 */
                $list[$key]['payment'] = empty($pay_name[$value['payment']]) ? strip_tags($value['payment']) : strip_tags($pay_name[$value['payment']]);
            }
        }
    }
    return array('list' => $list, 'filter' => $filter, 'page' => $page->show(5), 'desc' => $page->page_desc());
}

/**
 * 插入会员账目明细
 *
 * @access  public
 * @param   array $surplus 会员余额信息
 * @param   string $amount 金额
 *
 * @return  int
 */
function insert_user_account($surplus, $amount)
{
    $data = array(
        'user_id'          => $surplus['user_id'],
        'order_sn'         => $surplus['order_sn'],
        'admin_user'       => empty($surplus['admin_user']) ? '' : $surplus['admin_user'],
        'amount'           => $amount,
        'add_time'         => RC_Time::gmtime(),
        'paid_time'        => 0,
        'admin_note'       => !empty($surplus['admin_note']) ? $surplus['admin_note'] : '',
        'user_note'        => !empty($surplus['user_note']) ? $surplus['user_note'] : '',
        'process_type'     => $surplus['process_type'],
        'payment'          => $surplus['payment'],
        'payment_name'     => empty($surplus['payment_name']) ? '' : $surplus['payment_name'],
        'is_paid'          => 0,
        'from_type'        => empty($surplus['from_type']) ? '' : $surplus['from_type'],
        'from_value'       => empty($surplus['from_value']) ? '' : $surplus['from_value'],
        'pay_fee'          => empty($surplus['pay_fee']) ? '0.00' : $surplus['pay_fee'],
        'real_amount'      => empty($surplus['real_amount']) ? '0.00' : $surplus['real_amount'],
        'bank_name'        => empty($surplus['bank_name']) ? '' : $surplus['bank_name'],
        'bank_branch_name' => empty($surplus['bank_branch_name']) ? '' : $surplus['bank_branch_name'],
        'bank_card'        => empty($surplus['bank_card']) ? '' : $surplus['bank_card'],
        'cardholder'       => empty($surplus['cardholder']) ? '' : $surplus['cardholder'],
        'bank_en_short'    => empty($surplus['bank_en_short']) ? '' : $surplus['bank_en_short'],
    );
    return RC_DB::table('user_account')->insertGetId($data);
}


/**
 * 更新会员账目明细
 *
 * @access  public
 * @param   array $id 帐目ID
 * @param   array $admin_note 管理员描述
 * @param   array $amount 操作的金额
 * @param   array $is_paid 是否已完成
 *
 * @return  int
 */
function update_user_account($id, $amount, $admin_note, $is_paid)
{
    $data = array(
        'admin_user'  => $_SESSION['admin_name'],
        'amount'      => $amount,
        // 'add_time'		=> RC_Time::gmtime(),
        'paid_time'   => RC_Time::gmtime(),
        'admin_note'  => $admin_note,
        'is_paid'     => $is_paid,
        'review_time' => RC_Time::gmtime(),
    );
    return RC_DB::table('user_account')->where('id', $id)->update($data);
}

/**
 *  删除未确认的会员帐目信息
 *
 * @access  public
 * @param   int $rec_id 会员余额记录的ID
 * @param   int $user_id 会员的ID
 * @return  boolen
 */
function del_user_account($rec_id, $user_id)
{

    return RC_DB::table('user_account')->where('is_paid', 0)
        ->where('id', $rec_id)
        ->where('user_id', $user_id)
        ->delete();
}

/**
 * 根据会员id查询会员余额
 * @access  public
 * @param   int $user_id 会员ID
 * @return  int
 */
function get_user_surplus($user_id)
{
    return RC_DB::table('account_log')->where('user_id', $user_id)->sum('user_money');
}

/**
 * 查询会员余额的操作记录
 *
 * @access  public
 * @param   int $user_id 会员ID
 * @param   int $num 每页显示数量
 * @param   int $start 开始显示的条数
 * @return  array
 */
function get_account_log($user_id, $num = 15, $start, $process_type = '', $is_paid_arr = array())
{
    $account_log = array();

    $db = RC_DB::table('user_account');
    $db->where('user_id', $user_id);
    if (!empty($process_type)) {
        if ($process_type == 'deposit') {
            $db->where('process_type', SURPLUS_SAVE);
        } else {
            $db->where('process_type', SURPLUS_RETURN);
        }
    } else {
        $db->whereIn('process_type', array(SURPLUS_SAVE, SURPLUS_RETURN));
    }
    if (!empty($is_paid_arr)) {
        $db->whereIn('is_paid', $is_paid_arr);
    }
    $res = $db->take($num)->skip($start->start_id - 1)->orderBy('add_time', 'desc')->get();

    if (!empty($res)) {
        RC_Loader::load_sys_func('global');
        foreach ($res as $key => $rows) {
            $db_payment = RC_DB::table('payment');
            if ($rows['is_paid'] == '1') {
                $pay_status = __('已完成', 'user');
            } elseif ($rows['is_paid'] == '2') {
                $pay_status = __('已取消', 'user');
            } else {
                $pay_status = __('未确认', 'user');
            }
            $rows['add_time']         = RC_Time::local_date(ecjia::config('time_format'), $rows['add_time']);
            $rows['admin_note']       = nl2br(htmlspecialchars($rows['admin_note']));
            $rows['short_admin_note'] = ($rows['admin_note'] > '') ? RC_String::sub_str($rows['admin_note'], 30) : __('暂无', 'user');
            $rows['user_note']        = nl2br(htmlspecialchars($rows['user_note']));
            $rows['short_user_note']  = ($rows['user_note'] > '') ? RC_String::sub_str($rows['user_note'], 30) : __('暂无', 'user');
            //$rows['pay_status']       = ($rows['is_paid'] == 0) ? __('未确认') : __('已完成');
            $rows['pay_status']            = $pay_status;
            $rows['format_amount']         = price_format(abs($rows['amount']), false);
            $rows['pay_code']              = $rows['payment'];
            $rows['real_amount']           = $rows['real_amount'];
            $rows['formatted_real_amount'] = price_format(abs($rows['real_amount']), false);
            $rows['pay_fee']               = $rows['pay_fee'];
            $rows['formatted_pay_fee']     = price_format($rows['pay_fee'], false);

            /* 会员的操作类型： 冲值，提现 */
            if ($rows['process_type'] == 0) {
                $rows['type'] = __('充值', 'user');
            } else {
                $rows['type'] = __('提现', 'user');
            }

            /* 支付方式的ID */
            $db_payment->where('enabled', 1);

            if (substr($rows['payment'], 0, 4) == 'pay_') {
                $db_payment->where('pay_code', $rows['payment']);
            } else {
                $db_payment->where('pay_name', $rows['payment']);
            }
            $payment = $db_payment->first();


            $rows['payment'] = $payment['pay_name'];
            $rows['pid']     = $pid = $payment['pay_id'];
            /* 如果是预付款而且还没有付款, 允许付款 */
            if (($rows['is_paid'] == 0) && ($rows['process_type'] == 0)) {
                $rows['handle'] = '<a href="user.php?act=pay&id=' . $rows['id'] . '&pid=' . $pid . '">' . __('付款', 'user') . '</a>';
            }
            $account_log[] = $rows;
        }
        return $account_log;
    } else {
        return false;
    }
}

/**
 * 取得帐户明细
 * @param   int $user_id 用户id
 * @param   string $account_type 帐户类型：空表示所有帐户，user_money表示可用资金，
 *                  frozen_money表示冻结资金，rank_points表示成长值，pay_points表示消费积分
 * @return  array
 */
function get_account_log_list($user_id, $account_type = '')
{

    //$db_account_log = RC_Model::model('user/account_log_model');
    /* 检查参数 */
    //$where['user_id'] = $user_id;
    //if (in_array($account_type, array('user_money', 'frozen_money', 'rank_points', 'pay_points'))) {
    //	$where[$account_type] = array('neq' => 0);
    //}
    $db_account_log = RC_DB::table('account_log');
    if (in_array($account_type, array('user_money', 'frozen_money', 'rank_points', 'pay_points'))) {
        $db_account_log->where(function ($query) use ($account_type) {
            $query->where($account_type, '>', 0)->orWhere($account_type, '<', 0);
        });
    }

    /* 查询记录总数，计算分页数 */
    $count = $db_account_log->where('user_id', $user_id)->count();

    if ($count != 0) {
        /* 实例化分页 */
        $page = new ecjia_page($count, 15, 6);

        /* 查询记录 */
        $res = $db_account_log->where('user_id', $user_id)->orderBy('log_id', 'DESC')->take(15)->skip($page->start_id - 1)->get();

        $arr = array();
        if (!empty($res)) {
            foreach ($res as $row) {
                $row['change_time'] = RC_Time::local_date(ecjia::config('time_format'), $row['change_time']);
                $arr[]              = $row;
            }
        }
        return array('account' => $arr, 'page' => $page->show(5), 'desc' => $page->page_desc());
    }
}

/**
 * 获得账户变动金额
 * @param string $type 0,充值 1,提现
 * @return    array
 */
function get_total_amount($start_date, $end_date, $type = 0)
{
    $end_date += 86400;
    $data     = RC_DB::table('user_account AS ua')
        ->leftJoin('users as u', RC_DB::raw('ua.user_id'), '=', RC_DB::raw('u.user_id'))
        ->select(RC_DB::raw('IFNULL(SUM(amount), 0) as total_amount'))
        ->where('process_type', $type)
        ->where('is_paid', 1)
        ->where('paid_time', '>=', $start_date)
        ->where('paid_time', '<', $end_date)
        ->first();

    $amount = $data['total_amount'];
    $amount = $type ? price_format(abs($amount)) : price_format($amount);
    return $amount;
}

/**
 *返回用户订单列表数据
 *
 * @accesspublic
 * @param
 *
 * @return void
 */
function get_user_order($args = array())
{
    //$dbview = RC_Model::model('user/order_user_viewmodel');

    $filter['keywords']   = empty($_REQUEST['keywords']) ? '' : trim($_REQUEST['keywords']);
    $filter['start_date'] = empty($args['start_date']) ? '' : $args['start_date'];
    $filter['end_date']   = empty($args['end_date']) ? '' : $args['end_date'];
    $filter['sort_by']    = empty($_REQUEST['sort_by']) ? 'order_id' : trim($_REQUEST['sort_by']);
    $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);

    $where = ' 1 ';
    if ($filter['keywords']) {
        $where .= " AND u.user_name LIKE '%" . mysql_like_quote($filter['keywords']) . "%' or o.order_sn LIKE '%" . mysql_like_quote($filter['keywords']) . "%'";
    }

    /*　时间过滤　*/
    if (!empty($args['start_date'])) {
        $where .= " AND add_time >= " . RC_Time::local_strtotime($args['start_date']);
    }
    if (!empty($args['end_date'])) {
        $where .= " AND add_time <= " . (RC_Time::local_strtotime($args['end_date']) + 86400);
    }

    $count = RC_DB::table('order_info as o')
        ->leftJoin('users as u', RC_DB::raw('o.user_id'), '=', RC_DB::raw('u.user_id'))
        ->select(RC_DB::raw('o.order_sn, o.is_separate, (o.goods_amount - o.discount) AS goods_amount, o.user_id'))
        ->whereRaw($where)
        ->count();

    if ($count != 0) {
        /* 实例化分页 */
        $page = new ecjia_page($count, 15, 6);

        $data = RC_DB::table('order_info as o')
            ->leftJoin('users as u', RC_DB::raw('o.user_id'), '=', RC_DB::raw('u.user_id'))
            ->select(RC_DB::raw('o.order_id'), RC_DB::raw('o.order_sn'), RC_DB::raw('u.user_name'), RC_DB::raw('o.surplus'), RC_DB::raw('o.integral_money'), RC_DB::raw('o.add_time'))
            ->whereRaw($where)
            ->orderBy($filter['sort_by'], $filter['sort_order'])
            ->take(15)
            ->skip($page->start_id - 1)
            ->get();

        $order_list = array();
        foreach ($data as $rows) {
            $rows['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $rows['add_time']);
            $order_list[]     = $rows;
        }

        return array('order_list' => $order_list, 'filter' => $filter, 'page' => $page->show(5), 'desc' => $page->page_desc());
    }
}

/**
 * 取得用户信息
 * @param   int $user_id 用户id
 * @return  array   用户信息
 */
function get_user_info($user_id)
{
    $user = RC_DB::table('users')->where('user_id', $user_id)->first();

    unset($user['question']);
    unset($user['answer']);

    /* 格式化帐户余额 */
    if ($user) {
        $user['formated_user_money']   = price_format($user['user_money'], false);
        $user['formated_frozen_money'] = price_format($user['frozen_money'], false);
    }
    return $user;
}

/**
 * 取得用户等级数组,按用户级别排序
 * @param   bool $is_special 是否只显示特殊会员组
 * @return  array     rank_id=>rank_name
 */
function get_user_rank_list($is_special = false)
{
    $db_user_rank = RC_DB::table('user_rank');

    $rank_list = array();
    if ($is_special) {
        $db_user_rank->where('special_rank', 1);
    }

    $data = $db_user_rank->select('rank_id', 'rank_name')->orderBy('min_points', 'asc')->get();

    if (!empty($data)) {
        foreach ($data as $row) {
            $rank_list[$row['rank_id']] = $row['rank_name'];
        }
    }
    return $rank_list;
}

/**
 * 获取用户等级列表数组
 */
function get_rank_list()
{
    return RC_DB::table('user_rank')->orderBy('min_points', 'asc')->get();
}

/**
 * 记录帐户变动
 *
 * @param int $user_id
 *            用户id
 * @param float $user_money
 *            可用余额变动
 * @param float $frozen_money
 *            冻结余额变动
 * @param int $rank_points
 *            成长值变动
 * @param int $pay_points
 *            消费积分变动
 * @param string $change_desc
 *            变动说明
 * @param int $change_type
 *            变动类型：参见常量文件
 * @return void
 */
function change_account_log($user_id, $user_money = 0, $frozen_money = 0, $rank_points = 0, $pay_points = 0, $change_desc = '', $change_type = ACT_OTHER)
{
    // 链接数据库
    /* 插入帐户变动记录 */
    $account_log = array(
        'user_id'      => $user_id,
        'user_money'   => $user_money,
        'frozen_money' => $frozen_money,
        'rank_points'  => 0,
        'pay_points'   => $pay_points,
        'change_time'  => RC_Time::gmtime(),
        'change_desc'  => $change_desc,
        'change_type'  => $change_type
    );

    RC_DB::table('account_log')->insertGetId($account_log);

    /* 更新用户信息 */
    RC_DB::table('users')
        ->where('user_id', $user_id)
        ->increment('user_money', $user_money, [
            'frozen_money' => RC_DB::raw('`frozen_money` + ' . $frozen_money),
            'pay_points'   => RC_DB::raw('`pay_points` + ' . $pay_points),
        ]);

    if ($rank_points) {
        $data = array(
            'user_id'     => $user_id,
            'rank_points' => $rank_points,
            'change_desc' => $change_desc,
            'change_type' => $change_type,
        );
        RC_Api::api('user', 'rank_points_change_log', $data);
    }

}

// TODO:以下从api移入
/**
 * 更新用户SESSION,COOKIE及登录时间、登录次数。
 *
 * @access public
 * @return void
 */
function update_user_info()
{
    // 链接数据库
    $dbview       = RC_Model::model('user/user_viewmodel');
    $db_users     = RC_Model::model('user/users_model');
    $db_user_rank = RC_Model::model('user/user_rank_model');

    if (!$_SESSION['user_id']) {
        return false;
    }

    /* 查询会员信息 */
    $time = RC_Time::gmtime();

    $dbview->view = array(
        'user_bonus' => array(
            'type'  => Component_Model_View::TYPE_LEFT_JOIN,
            'alias' => 'ub',
            'on'    => 'ub.user_id = u.user_id AND ub.used_time = 0'
        ),
        'bonus_type' => array(
            'type'  => Component_Model_View::TYPE_LEFT_JOIN,
            'alias' => 'b',
            'on'    => "b.type_id = ub.bonus_type_id AND b.use_start_date <= '$time' AND b.use_end_date >= '$time'"
        )
    );
    $row          = $dbview->find('u.user_id = ' . $_SESSION['user_id'] . '');
    if ($row) {
        /* 更新SESSION */
        $_SESSION['last_time']  = RC_Time::local_date('Y-m-d H:i:s', $row['last_login']);
        $_SESSION['last_ip']    = $row['last_ip'];
        $_SESSION['login_fail'] = 0;
        $_SESSION['email']      = $row['email'];

        /* 判断是否是特殊等级，可能后台把特殊会员组更改普通会员组 */
        if ($row['user_rank'] > 0) {
            $special_rank = $db_user_rank->where('rank_id = "' . $row[user_rank] . '"')->get_field('special_rank');
            if ($special_rank === '0' || $special_rank === null) {
                $data = array(
                    'user_rank' => '0'
                );
                $db_users->where('user_id = ' . $_SESSION[user_id] . '')->update($data);
                $row['user_rank'] = 0;
            }
        }

        /* 取得用户等级和折扣 */
        if ($row['user_rank'] == 0) {
            // 非特殊等级，根据成长值计算用户等级（注意：不包括特殊等级）
            $row = $db_user_rank->field('rank_id, discount')->find('special_rank = "0" AND min_points <= "' . intval($row['rank_points']) . '" AND max_points > "' . intval($row['rank_points']) . '"');
            if ($row) {
                $_SESSION['user_rank'] = $row['rank_id'];
                $_SESSION['discount']  = $row['discount'] / 100.00;
            } else {
                $_SESSION['user_rank'] = 0;
                $_SESSION['discount']  = 1;
            }
        } else {
            // 特殊等级
            $row = $db_user_rank->field('rank_id, discount')->find('rank_id = "' . $row[user_rank] . '"');
            if ($row) {
                $_SESSION['user_rank'] = $row['rank_id'];
                $_SESSION['discount']  = $row['discount'] / 100.00;
            } else {
                $_SESSION['user_rank'] = 0;
                $_SESSION['discount']  = 1;
            }
        }
        if (empty($_SESSION['user_rank'])) {
            $_SESSION['user_rank'] = 0;
        }
    }

    /* 更新登录时间，登录次数及登录ip */
    $data = array(
        'visit_count' => visit_count + 1,
        'last_ip'     => RC_Ip::client_ip(),
        'last_login'  => RC_Time::gmtime()
    );
    $db_users->where('user_id = ' . $_SESSION[user_id] . '')->update($data);
}


/**
 *  添加或更新指定用户收货地址
 *
 * @access  public
 * @param   array $address
 * @return  bool
 */
function update_address($address)
{
    $db_user         = RC_DB::table('users');
    $db_user_address = RC_DB::table('user_address');

    $address_id = intval($address['address_id']);
    unset($address['address_id']);

    if ($address_id > 0) {
        $address['district'] = empty($address['district']) ? '' : $address['district'];
        /* 更新指定记录 */
        $db_user_address
            ->where('address_id', $address_id)
            ->where('user_id', $address['user_id'])
            ->update($address);
    } else {
        /* 插入一条新记录 */
        $address_id = $db_user_address->insertGetId($address);
    }

    if (isset($address['default']) && $address['default'] > 0 && isset($address['user_id'])) {
        $db_user->where('user_id', $address['user_id'])->update(array('address_id', $address_id));
    }

    return true;
}

function EM_user_info($user_id, $mobile = '')
{
    RC_Loader::load_app_func('admin_order', 'orders');
    $user_info = user_info($user_id, $mobile);

    if (is_ecjia_error($user_info)) {
        return $user_info;
    }

    $collection_num = RC_DB::table('collect_goods')->where('user_id', $user_id)->orderBy('add_time', 'desc')->count();
    //收藏店铺数
    $collect_store_num = RC_DB::table('collect_store')->where('user_id', $user_id)->count();

    $db1 = RC_DB::table('order_info');
    /*货到付款订单不在待付款里显示*/
    $pay_cod_id = RC_DB::table('payment')->where('pay_code', 'pay_cod')->pluck('pay_id');
    if (!empty($pay_cod_id)) {
        $db1->where('pay_id', '!=', $pay_cod_id);
    }
    $await_pay  = $db1->where('user_id', $user_id)->where('extension_code', '!=', "group_buy")->where('pay_status', PS_UNPAYED)->whereIn('order_status', array(OS_UNCONFIRMED, OS_CONFIRMED, OS_SPLITED))->count();
    $await_ship = RC_DB::table('order_info')->where('user_id', $user_id)->where('extension_code', '!=', "group_buy")->whereRaw(EM_order_query_sql('await_ship', ''))->count();
    $shipped    = RC_DB::table('order_info')->where('user_id', $user_id)->where('extension_code', "!=", "group_buy")->whereRaw(EM_order_query_sql('shipped', ''))->count();
    $finished   = RC_DB::table('order_info')->where('user_id', $user_id)->whereIn('order_status', array(OS_CONFIRMED, OS_SPLITED))
        ->whereIn('shipping_status', array(SS_RECEIVED))
        ->whereIn('pay_status', array(PS_PAYED, PS_PAYING))
        ->where('extension_code', "!=", "group_buy")
        ->count();

    $db_allow_comment = RC_DB::table('order_info as oi')
        ->leftJoin('order_goods as og', RC_DB::raw('oi.order_id'), '=', RC_DB::raw('og.order_id'))
        ->leftJoin('goods as g', RC_DB::raw('g.goods_id'), '=', RC_DB::raw('og.goods_id'))
        ->leftJoin('comment as c', function ($join) {
            $join->on(RC_DB::raw('c.id_value'), '=', RC_DB::raw('og.goods_id'))
                ->on(RC_DB::raw('og.rec_id'), '=', RC_DB::raw('c.rec_id'))
                ->on(RC_DB::raw('c.order_id'), '=', RC_DB::raw('oi.order_id'))
                ->where(RC_DB::raw('c.parent_id'), '=', 0)
                ->where(RC_DB::raw('c.comment_type'), '=', 0);
        });

    $allow_comment_count = $db_allow_comment
        ->where(RC_DB::raw('oi.user_id'), $user_id)
        ->where(RC_DB::raw('oi.extension_code'), "!=", "group_buy")
        ->where(RC_DB::raw('oi.shipping_status'), SS_RECEIVED)
        ->whereIn(RC_DB::raw('oi.order_status'), array(OS_CONFIRMED, OS_SPLITED))
        ->whereIn(RC_DB::raw('oi.pay_status'), array(PS_PAYED, PS_PAYING))
        ->whereRaw(RC_DB::raw('c.comment_id is null'))
        ->select(RC_DB::Raw('count(DISTINCT oi.order_id) as counts'))->get();
    $allow_comment_count = $allow_comment_count['0']['counts'];
    //申请售后数
    $refund_order = RC_DB::table('refund_order')->where('user_id', $_SESSION['user_id'])
        ->whereRaw('status != 10 and refund_status != 2')
        ->count();

    if ($user_info['user_rank'] == 0) {
        //重新计算会员等级
        $now_rank = RC_Api::api('user', 'update_user_rank', array('user_id' => $user_id));
    } else {
        //用户等级更新，不用计算，直接读取
        $now_rank = RC_DB::table('user_rank')->where('rank_id', $user_info['user_rank'])->first();
    }

    $user_info['user_rank_name'] = $now_rank['rank_name'];
    $user_info['user_rank_id']   = $now_rank['rank_id'];
    $level                       = 1;
    if ($now_rank['special_rank'] == 0 && $now_rank['min_points'] == 0) {
        $level = 0;
    }

    if (empty($user_info['avatar_img'])) {
        $avatar_img = '';
    } else {
        $avatar_img = RC_Upload::upload_url($user_info['avatar_img']);
    }

    $user_info['user_name'] = preg_replace('/<span(.*)span>/i', '', $user_info['user_name']);

    /* 获取可使用的红包数量*/
    $dbview = RC_DB::table('bonus_type as bt')->leftJoin('user_bonus as ub', RC_DB::raw('bt.type_id'), '=', RC_DB::raw('ub.bonus_type_id'));
    $time   = RC_Time::gmtime();

    $bonus_count = $dbview->where(RC_DB::raw('ub.user_id'), $user_id)
        ->where(RC_DB::raw('use_start_date'), '<', $time)
        ->where(RC_DB::raw('use_end_date'), '>', $time)
        ->where(RC_DB::raw('ub.order_id'), 0)
        ->count(RC_DB::raw('ub.bonus_id'));
    /* 判断会员名更改时间*/
    $username_update_time = RC_DB::table('term_meta')->where('object_type', 'ecjia.user')
        ->where('object_group', 'update_user_name')
        ->where('object_id', $user_id)
        ->where('meta_key', 'update_time')
        ->first();


    $address              = $user_info['address_id'] > 0 ? RC_DB::table('user_address')->where('address_id', $user_info['address_id'])->first() : '';
    $user_info['address'] = $user_info['address_id'] > 0 ? ecjia_region::getRegionName($address['city']) . ecjia_region::getRegionName($address['district']) . ecjia_region::getRegionName($address['street']) . $address['address'] : '';

    /*返回connect_user表中open_id和token*/
    $open_id         = RC_DB::table('connect_user')->where('user_id', $user_id)->where('user_type', 'user')->where('connect_code', 'app')->pluck('open_id');
    $connect_appuser = (new Ecjia\App\Connect\Plugins\EcjiaSyncAppUser($open_id, 'user'))->setUserId($user_id)->getEcjiaAppUser();

    return array(
        'id'                   => $user_info['user_id'],
        'name'                 => $user_info['user_name'],
        'rank_id'              => $user_info['user_rank_id'],
        'rank_name'            => $user_info['user_rank_name'],
        'rank_level'           => $level,
        'collection_num'       => $collection_num,
        'collect_store_num'    => $collect_store_num,
        'email'                => $user_info['email'],
        'mobile_phone'         => $user_info['mobile_phone'],
        'address'              => $user_info['address'],
        'avatar_img'           => $avatar_img,
        'order_num'            => array(
            'await_pay'     => $await_pay,
            'await_ship'    => $await_ship,
            'shipped'       => $shipped,
            'finished'      => $finished,
            'allow_comment' => $allow_comment_count,
            'refund_order'  => $refund_order
        ),
        'user_money'           => $user_info['user_money'],
        'formated_user_money'  => price_format($user_info['user_money'], false),
        'user_points'          => $user_info['pay_points'],
        'user_bonus_count'     => $bonus_count,
        'reg_time'             => empty($user_info['reg_time']) ? '' : RC_Time::local_date(ecjia::config('time_format'), $user_info['reg_time']),
        'update_username_time' => empty($username_update_time) ? '' : RC_Time::local_date(ecjia::config('time_format'), $username_update_time['meta_value']),
        'open_id'              => $connect_appuser->open_id ? $connect_appuser->open_id : '',
        'access_token'         => $connect_appuser->access_token ? $connect_appuser->access_token : '',
        'refresh_token'        => $connect_appuser->refresh_token ? $connect_appuser->refresh_token : '',
        'user_type'            => 'user',
        'has_paypassword'      => empty($user_info['pay_password']) ? 0 : 1,
        'account_status'       => $user_info['account_status'],
        'delete_time'          => $user_info['delete_time'] > 0 ? RC_Time::local_date('Y/m/d H:i:s O', $user_info['delete_time']) : '',
    );
}

/**
 *  获取指定用户的收藏商品列表
 *
 * @access  public
 * @param   int $user_id 用户ID
 * @param   int $num 列表最大数量
 * @param   int $start 列表其实位置
 *
 * @return  array   $arr
 */
function EM_get_collection_goods($user_id, $num = 10, $start = 1, $rec_id = 0)
{
    $user_rank        = $_SESSION['user_rank'];
    $db_collect_goods = RC_DB::table('collect_goods as c')
        ->leftJoin('goods as g', RC_DB::raw('g.goods_id'), '=', RC_DB::raw('c.goods_id'))
        ->leftJoin('member_price as mp', function ($join) use ($user_rank) {
            $join->on(RC_DB::raw('mp.goods_id'), '=', RC_DB::raw('g.goods_id'))->on(RC_DB::raw('mp.user_rank'), '=', RC_DB::raw($user_rank));
        });
    $db_collect_goods->where(RC_DB::raw('c.user_id'), $user_id);

    if ($rec_id) {
        $db_collect_goods->where(RC_DB::raw('c.rec_id'), '<=', $rec_id);
    }
    $res = $db_collect_goods
        ->select(RC_DB::raw("g.original_img, g.goods_id, g.goods_name, g.market_price, g.shop_price, g.goods_thumb, g.goods_img, g.original_img, g.goods_brief, g.goods_type AS org_price, IFNULL(mp.user_price, g.shop_price * '" . $_SESSION['discount'] . "') AS shop_price, g.promote_price, g.promote_start_date, g.promote_end_date, c.rec_id, c.is_attention, g.click_count"))
        ->orderby(RC_DB::raw('c.rec_id'), 'desc')
        ->take($num)
        ->skip(($start - 1) * $num)
        ->get();

    $goods_list = array();
    if (!empty($res)) {
        foreach ($res as $row) {
            if ($row['promote_price'] > 0) {
                RC_Loader::load_app_func('admin_goods', 'goods');
                $promote_price = bargain_price($row['promote_price'], $row['promote_start_date'], $row['promote_end_date']);
            } else {
                $promote_price = 0;
            }

            $goods_list[$row['goods_id']]['rec_id']        = $row['rec_id'];
            $goods_list[$row['goods_id']]['is_attention']  = $row['is_attention'];
            $goods_list[$row['goods_id']]['goods_id']      = $row['goods_id'];
            $goods_list[$row['goods_id']]['goods_name']    = $row['goods_name'];
            $goods_list[$row['goods_id']]['market_price']  = $row['market_price'] > 0 ? price_format($row['market_price']) : '';
            $goods_list[$row['goods_id']]['shop_price']    = $row['shop_price'] > 0 ? price_format($row['shop_price']) : __('免费');
            $goods_list[$row['goods_id']]['promote_price'] = ($promote_price > 0) ? price_format($promote_price) : '';
            $goods_list[$row['goods_id']]['url']           = build_uri('goods', array('gid' => $row['goods_id']), $row['goods_name']);
            $goods_list[$row['goods_id']]['original_img']  = $row['original_img'];
            $goods_list[$row['goods_id']]['goods_thumb']   = $row['goods_thumb'];
            $goods_list[$row['goods_id']]['goods_brief']   = $row['goods_brief'];
            $goods_list[$row['goods_id']]['goods_type']    = $row['goods_type'];
            $goods_list[$row['goods_id']]['goods_img']     = $row['goods_img'];
            $goods_list[$row['goods_id']]['click_count']   = $row['click_count'];

            $goods_list[$row['goods_id']]['unformatted_shop_price']    = $row['shop_price'];
            $goods_list[$row['goods_id']]['unformatted_promote_price'] = $promote_price;
        }
    }
    return $goods_list;
}

// end