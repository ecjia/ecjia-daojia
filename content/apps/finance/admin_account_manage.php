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
 * ECJIA 会员资金管理程序
 */
class admin_account_manage extends ecjia_admin
{

    public function __construct()
    {
        parent::__construct();

        RC_Loader::load_app_func('admin_user');
        RC_Loader::load_app_func('global', 'goods');

        RC_Script::enqueue_script('smoke');
        RC_Script::enqueue_script('jquery-chosen');
        RC_Style::enqueue_style('chosen');
        RC_Script::enqueue_script('jquery-uniform');
        RC_Style::enqueue_style('uniform-aristo');

        //时间控件
        RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
        RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));

        RC_Script::enqueue_script('user_surplus', RC_App::apps_url('statics/js/user_surplus.js', __FILE__));

        //百度图表
        RC_Script::enqueue_script('echarts-min-js', RC_App::apps_url('statics/js/echarts.min.js', __FILE__));

        RC_Script::enqueue_script('jquery-peity');

        RC_Style::enqueue_style('admin_account_manage', RC_App::apps_url('statics/css/admin_account_manage.css', __FILE__), array());

        $surplus_jslang = array(
            'keywords_required' => RC_Lang::get('user::user_account_manage.keywords_required'),
            'check_time'        => RC_Lang::get('user::user_account_manage.check_time'),
        );
        RC_Script::localize_script('user_surplus', 'surplus_jslang', $surplus_jslang);
    }

    /**
     * 资金管理
     */
    public function init()
    {
        $this->admin_priv('account_manage');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::user_account_manage.user_account_manage')));
        ecjia_screen::get_current_screen()->add_help_tab(array(
            'id'      => 'overview',
            'title'   => RC_Lang::get('user::users.overview'),
            'content' => '<p>' . RC_Lang::get('user::users.user_account_manage_help') . '</p>',
        ));

        ecjia_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . RC_Lang::get('user::users.more_info') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:资金管理" target="_blank">' . RC_Lang::get('user::users.about_user_account_manage') . '</a>') . '</p>'
        );

        $this->assign('ur_here', RC_Lang::get('user::user_account_manage.user_account_manage'));

        $current_year = RC_Time::local_date('Y', RC_Time::gmtime());
        $year_list    = [];
        for ($i = 0; $i < 6; $i++) {
            $year_list[] = ($current_year - $i);
        }
        $month_list = [];
        for ($i = 12; $i > 0; $i--) {
            $month_list[] = $i;
        }
        $year  = !empty($_GET['year']) ? intval($_GET['year']) : $current_year;
        $month = !empty($_GET['month']) ? intval($_GET['month']) : 0;

        $this->assign('store_id', $store_id);
        $this->assign('year_list', $year_list);
        $this->assign('month_list', $month_list);
        $this->assign('year', $year);
        $this->assign('month', $month);

        //获取统计信息
        $account = $this->get_stats();
        $this->assign('account', $account);

        $data = array(
            'unformated_surplus'        => $account['unformated_surplus'],
            'unformated_voucher_amount' => $account['unformated_voucher_amount'],
            'unformated_return_money'   => $account['unformated_return_money'],
            'unformated_to_cash_amount' => $account['unformated_to_cash_amount'],
            'unformated_frozen_money'   => $account['unformated_frozen_money'],
        );
        $this->assign('data', json_encode($data));

        $right_data = array(
            'pay_points'   => $account['pay_points'],
            'integral'     => $account['integral'],
            'total_points' => $account['total_points'],
        );
        $this->assign('right_data', json_encode($right_data));

        $this->assign('form_action', RC_Uri::url('finance/admin_account_manage/init'));

        $log_list = $this->get_account_log();
        $this->assign('log_list', $log_list);

        $this->display('admin_account_manage.dwt');
    }

    /**
     * 积分余额订单
     */
    public function surplus()
    {
        $this->admin_priv('account_manage');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::user_account_manage.user_account_manage'), RC_Uri::url('finance/admin_account_manage/init')));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::user_account_manage.integral_order')));

        $this->assign('ur_here', RC_Lang::get('user::user_account_manage.integral_order'));
        $this->assign('action_link', array('text' => RC_Lang::get('user::user_account_manage.user_account_manage'), 'href' => RC_Uri::url('finance/admin_account_manage/init')));

        $order_list = get_user_order($_REQUEST);
        /* 赋值到模板 */
        $this->assign('order_list', $order_list);
        $this->assign('form_action', RC_Uri::url('finance/admin_account_manage/surplus'));

        $this->display('user_surplus_list.dwt');
    }

    private function get_stats()
    {
        $current_year = RC_Time::local_date('Y', RC_Time::gmtime());
        $year         = !empty($_GET['year']) ? intval($_GET['year']) : $current_year;
        $month        = !empty($_GET['month']) ? intval($_GET['month']) : 0;

        if (empty($month)) {
            $start_time = $year . '-1-1 00:00:00';
            $em         = $year + 1 . '-1-1 00:00:00';
            $end_time   = RC_Time::local_date('Y-m-d H:i:s', RC_Time::local_strtotime($em) - 1);
        } else {
            $start_time = $year . '-' . $month . '-1 00:00:00';
            $end_time   = RC_Time::local_date('Y-m-d 23:59:59', RC_Time::local_strtotime("$start_time +1 month -1 day"));
        }
        $start_date = RC_Time::local_strtotime($start_time);
        $end_date   = RC_Time::local_strtotime($end_time);

        $money = RC_DB::table('order_info')
            ->select(RC_DB::raw('IFNULL(SUM(surplus), 0) AS surplus, IFNULL(SUM(integral), 0) AS integral'))
            ->where('add_time', '>=', $start_date)
            ->where('add_time', '<', $end_date)
            ->whereIn('order_status', array(OS_CONFIRMED, OS_SPLITED))
            ->where('shipping_status', SS_RECEIVED)
            ->first();

        //会员消费
        $data['surplus']            = ecjia_price_format($money['surplus']);
        $data['unformated_surplus'] = $money['surplus'];

        //积分抵现
        $data['integral'] = $money['integral'];

        $amount = RC_DB::table('user_account AS ua')
            ->leftJoin('users as u', RC_DB::raw('ua.user_id'), '=', RC_DB::raw('u.user_id'))
            ->select(RC_DB::raw('IFNULL(SUM(amount), 0) as total_amount'))
            ->where('process_type', 0)
            ->where('is_paid', 1)
            ->where('paid_time', '>=', $start_date)
            ->where('paid_time', '<', $end_date)
            ->first();

        //会员充值总额
        $data['voucher_amount']            = ecjia_price_format($amount['total_amount']);
        $data['unformated_voucher_amount'] = $amount['total_amount'];

        $money_paid = RC_DB::table('refund_payrecord')
            ->where('add_time', '>=', $start_date)
            ->where('add_time', '<', $end_date)
            ->where('action_back_time', '>', 0)
            ->whereNotNull(RC_DB::raw('action_back_type'))
            ->select(RC_DB::raw('IFNULL(SUM(order_money_paid), 0) as order_money_paid'))
            ->first();

        //退款存入
        $data['return_money']            = ecjia_price_format($money_paid['order_money_paid']);
        $data['unformated_return_money'] = $money_paid['order_money_paid'];

        $amount = RC_DB::table('user_account AS ua')
            ->leftJoin('users as u', RC_DB::raw('ua.user_id'), '=', RC_DB::raw('u.user_id'))
            ->select(RC_DB::raw('IFNULL(SUM(amount), 0) as total_amount'))
            ->where('process_type', 1)
            ->where('is_paid', 1)
            ->where('paid_time', '>=', $start_date)
            ->where('paid_time', '<', $end_date)
            ->first();

        //提现总额
        $data['to_cash_amount']            = ecjia_price_format(abs($amount['total_amount']));
        $data['unformated_to_cash_amount'] = abs($amount['total_amount']);

        $money_list = RC_DB::table('account_log')
            ->select(RC_DB::raw('IFNULL(SUM(user_money), 0) AS user_money,
            IFNULL(SUM(frozen_money), 0) AS frozen_money'))
            ->where('change_time', '>=', $start_date)
            ->where('change_time', '<', $end_date)
            ->first();

        //用户冻结金额
        $data['frozen_money']            = ecjia_price_format($money_list['frozen_money']);
        $data['unformated_frozen_money'] = abs($money_list['frozen_money']);

        //用户剩余总余额
        $data['user_money']            = ecjia_price_format($money_list['user_money']);
        $data['unformated_user_money'] = $money_list['user_money'];

        $points = RC_DB::table('account_log')
            ->select(RC_DB::raw('IFNULL(SUM(pay_points), 0) as pay_points'))
            ->where('pay_points', '!=', 0)
            ->where('from_type', 'order_give_integral')
            ->where('change_time', '>=', $start_date)
            ->where('change_time', '<', $end_date)
            ->first();
        $data['pay_points'] = $points['pay_points'];

        $points = RC_DB::table('account_log')
            ->select(RC_DB::raw('IFNULL(SUM(pay_points), 0) as pay_points'))
            ->where('pay_points', '!=', 0)
            ->where('change_time', '>=', $start_date)
            ->where('change_time', '<', $end_date)
            ->first();
        $data['total_points'] = $points['pay_points'];

        return $data;
    }

    private function get_account_log()
    {
        $current_year = RC_Time::local_date('Y', RC_Time::gmtime());
        $year         = !empty($_GET['year']) ? intval($_GET['year']) : $current_year;
        $month        = !empty($_GET['month']) ? intval($_GET['month']) : 0;

        if (empty($month)) {
            $start_time = $year . '-1-1 00:00:00';
            $em         = $year + 1 . '-1-1 00:00:00';
            $end_time   = RC_Time::local_date('Y-m-d H:i:s', RC_Time::local_strtotime($em) - 1);
        } else {
            $start_time = $year . '-' . $month . '-1 00:00:00';
            $end_time   = RC_Time::local_date('Y-m-d 23:59:59', RC_Time::local_strtotime("$start_time +1 month -1 day"));
        }
        $start_date = RC_Time::local_strtotime($start_time);
        $end_date   = RC_Time::local_strtotime($end_time);

        $db_account_log = RC_DB::table('account_log as a')
            ->where(RC_DB::raw('a.change_time'), '>=', $start_date)
            ->where(RC_DB::raw('a.change_time'), '<', $end_date);

        $count = $db_account_log->count();

        $page = new ecjia_page($count, 15, 6);

        $res = $db_account_log
            ->leftJoin('users as u', RC_DB::raw('a.user_id'), '=', RC_DB::raw('u.user_id'))
            ->select(RC_DB::raw('a.*, u.user_name'))
            ->orderBy(RC_DB::raw('a.log_id'), 'DESC')
            ->take(15)
            ->skip($page->start_id - 1)
            ->get();

        $arr = array();
        if (!empty($res)) {
            foreach ($res as $row) {
                $row['change_time'] = RC_Time::local_date(ecjia::config('time_format'), $row['change_time']);
                $arr[]              = $row;
            }
        }
        return array('item' => $arr, 'page' => $page->show(5), 'desc' => $page->page_desc());
    }
}

// end
