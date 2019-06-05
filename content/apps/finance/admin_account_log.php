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
 * 会员帐户变动记录
 */
class admin_account_log extends ecjia_admin
{
    public function __construct()
    {
        parent::__construct();

        RC_Loader::load_app_func('admin_user', 'finance');

        Ecjia\App\Finance\Helper::assign_adminlog_content();

        /* 加载所需js */
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('jquery-chosen');
        RC_Style::enqueue_style('chosen');
        RC_Script::enqueue_script('jquery-peity');

        RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
        RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));

        RC_Script::enqueue_script('account_log', RC_App::apps_url('statics/js/account_log.js', __FILE__));
        RC_Style::enqueue_style('admin_account_log', RC_App::apps_url('statics/css/admin_account_manage.css', __FILE__), array());

        RC_Script::localize_script('account_log', 'js_lang', config('app-finance::jslang.admin_account_log_page'));

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('会员列表', 'finance'), RC_Uri::url('user/admin/init')));
    }

    /**
     * 账户明细列表
     */
    public function init()
    {
        $this->admin_priv('account_manage');

        $user_id      = intval($_GET['user_id']);
        $account_type = trim($_GET['account_type']);

        if(empty($user_id)) {
            return $this->showmessage('参数异常', ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
        }

        $this->assign('form_action', RC_Uri::url('finance/admin_account_log/init', array('account_type' => $account_type, 'user_id' => $user_id)));
        $this->assign('back_link', array('text' => __('会员列表', 'finance'), 'href' => RC_Uri::url('user/admin/init')));

        $nav_here = __('会员账户变动明细', 'finance');
        $link1    = $link2 = $link3 = $link4 = $second_heading = '';

        if ($account_type == 'user_money') {
            $nav_here = __('查看余额变动', 'finance');

            $link1 = array('text' => __('充值', 'finance'), 'href' => RC_Uri::url('finance/admin_account/add', array('user_id' => $user_id)), 'i' => 'fontello-icon-dollar');
            $link2 = array('text' => __('提现', 'finance'), 'href' => RC_Uri::url('withdraw/admin/add', array('user_id' => $user_id)), 'i' => 'fontello-icon-dollar');

            $link3 = array('text' => __('增加余额', 'finance'), 'href' => RC_Uri::url('finance/admin_account_log/add_user_money', array('user_id' => $user_id)), 'i' => 'fontello-icon-plus', 'pjax' => true);
            $link4 = array('text' => __('减少余额', 'finance'), 'href' => RC_Uri::url('finance/admin_account_log/minus_user_money', array('user_id' => $user_id)), 'i' => 'fontello-icon-minus', 'pjax' => true);

            $second_heading = __('资金明细', 'finance');

        } elseif ($account_type == 'pay_points') {
            $nav_here = __('查看积分变动', 'finance');

            $link1 = array('text' => __('增加积分', 'finance'), 'href' => RC_Uri::url('finance/admin_account_log/add_pay_points', array('user_id' => $user_id)), 'i' => 'fontello-icon-plus', 'pjax' => true);
            $link2 = array('text' => __('减少积分', 'finance'), 'href' => RC_Uri::url('finance/admin_account_log/minus_pay_points', array('user_id' => $user_id)), 'i' => 'fontello-icon-minus', 'pjax' => true);

            $second_heading = __('积分明细', 'finance');

        } elseif ($account_type == 'rank_points') {
            $nav_here = __('查看成长值变动', 'finance');

            $link1 = array('text' => __('增加成长值', 'finance'), 'href' => RC_Uri::url('finance/admin_account_log/add_rank_points', array('user_id' => $user_id)), 'i' => 'fontello-icon-plus', 'pjax' => true);
            $link2 = array('text' => __('减少成长值', 'finance'), 'href' => RC_Uri::url('finance/admin_account_log/minus_rank_points', array('user_id' => $user_id)), 'i' => 'fontello-icon-minus', 'pjax' => true);

            $second_heading = __('成长值明细', 'finance');
        }

        $this->assign('ur_here', $nav_here);

        $this->assign('link1', $link1);
        $this->assign('link2', $link2);
        $this->assign('link3', $link3);
        $this->assign('link4', $link4);

        $this->assign('second_heading', $second_heading);

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($nav_here));

        $user = get_user_info($user_id);
        if (empty($user)) {
            return $this->showmessage(__('该会员不存在', 'finance'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
        }

        if ($user['user_rank'] == 0) {
            //重新计算会员等级
            $row_rank = RC_Api::api('user', 'update_user_rank', array('user_id' => $user['user_id']));
        } else {
            $row_rank = RC_DB::table('user_rank')->where('rank_id', $user['user_rank'])->first();
        }
        $user['user_rank_name'] = $row_rank['rank_name'];
        $this->assign('user', $user);

        $date = array(
            'start_date' => trim($_GET['start_date']),
            'end_date'   => trim($_GET['end_date']),
        );

        $account_list = get_account_log_list($user_id, $account_type, $date);

        $this->assign('account_type', $account_type);
        $this->assign('account_list', $account_list);

        return $this->display('account_log_list.dwt');
    }

    public function add_pay_points()
    {
        $this->admin_priv('account_manage');

        $user_id = intval($_GET['user_id']);
        $this->assign('user_id', $user_id);
        $this->assign('type', 'add_pay_points');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('增加账户积分', 'finance')));

        $this->assign('ur_here', __('增加账户积分', 'finance'));
        $this->assign('action_link', array('href' => RC_Uri::url('finance/admin_account_log/init', array('account_type' => 'pay_points', 'user_id' => $user_id)), 'text' => __('查看积分变动', 'finance')));

        $this->assign('form_action', RC_Uri::url('finance/admin_account_log/update'));

        $user = get_user_info($user_id);
        $this->assign('user', $user);

        return $this->display('account_points.dwt');
    }

    public function minus_pay_points()
    {
        $this->admin_priv('account_manage');

        $user_id = intval($_GET['user_id']);
        $this->assign('user_id', $user_id);
        $this->assign('type', 'minus_pay_points');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('减少账户积分', 'finance')));

        $this->assign('ur_here', __('减少账户积分', 'finance'));
        $this->assign('action_link', array('href' => RC_Uri::url('finance/admin_account_log/init', array('account_type' => 'pay_points', 'user_id' => $user_id)), 'text' => __('查看积分变动', 'finance')));

        $this->assign('form_action', RC_Uri::url('finance/admin_account_log/update'));

        $user = get_user_info($user_id);
        $this->assign('user', $user);

        return $this->display('account_points.dwt');
    }

    public function add_rank_points()
    {
        $this->admin_priv('account_manage');

        $user_id = intval($_GET['user_id']);
        $this->assign('user_id', $user_id);
        $this->assign('type', 'add_rank_points');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('增加会员成长值', 'finance')));

        $this->assign('ur_here', __('增加会员成长值', 'finance'));
        $this->assign('action_link', array('href' => RC_Uri::url('finance/admin_account_log/init', array('account_type' => 'rank_points', 'user_id' => $user_id)), 'text' => __('查看成长值变动', 'finance')));

        $this->assign('form_action', RC_Uri::url('finance/admin_account_log/update'));

        $user = get_user_info($user_id);
        if ($user['user_rank'] == 0) {
            //重新计算会员等级
            $row_rank = RC_Api::api('user', 'update_user_rank', array('user_id' => $user['user_id']));
        } else {
            $row_rank = RC_DB::table('user_rank')->where('rank_id', $user['user_rank'])->first();
        }
        $user['user_rank_name'] = $row_rank['rank_name'];

        $this->assign('user', $user);

        return $this->display('account_points.dwt');
    }

    public function minus_rank_points()
    {
        $this->admin_priv('account_manage');

        $user_id = intval($_GET['user_id']);
        $this->assign('user_id', $user_id);
        $this->assign('type', 'minus_rank_points');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('减少会员成长值', 'finance')));

        $this->assign('ur_here', __('减少会员成长值', 'finance'));
        $this->assign('action_link', array('href' => RC_Uri::url('finance/admin_account_log/init', array('account_type' => 'rank_points', 'user_id' => $user_id)), 'text' => __('查看成长值变动', 'finance')));

        $this->assign('form_action', RC_Uri::url('finance/admin_account_log/update'));

        $user = get_user_info($user_id);
        if ($user['user_rank'] == 0) {
            //重新计算会员等级
            $row_rank = RC_Api::api('user', 'update_user_rank', array('user_id' => $user['user_id']));
        } else {
            $row_rank = RC_DB::table('user_rank')->where('rank_id', $user['user_rank'])->first();
        }
        $user['user_rank_name'] = $row_rank['rank_name'];

        $this->assign('user', $user);

        return $this->display('account_points.dwt');
    }

    public function add_user_money()
    {
        $this->admin_priv('account_manage');

        $user_id = intval($_GET['user_id']);
        $this->assign('user_id', $user_id);
        $this->assign('type', 'add_user_money');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('增加余额', 'finance')));

        $this->assign('ur_here', __('增加余额', 'finance'));
        $this->assign('action_link', array('href' => RC_Uri::url('finance/admin_account_log/init', array('account_type' => 'user_money', 'user_id' => $user_id)), 'text' => __('查看余额变动', 'finance')));

        $this->assign('form_action', RC_Uri::url('finance/admin_account_log/update'));

        $user = get_user_info($user_id);
        $this->assign('user', $user);

        return $this->display('account_points.dwt');
    }

    public function minus_user_money()
    {
        $this->admin_priv('account_manage');

        $user_id = intval($_GET['user_id']);
        $this->assign('user_id', $user_id);
        $this->assign('type', 'minus_user_money');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('减少余额', 'finance')));

        $this->assign('ur_here', __('减少余额', 'finance'));
        $this->assign('action_link', array('href' => RC_Uri::url('finance/admin_account_log/init', array('account_type' => 'user_money', 'user_id' => $user_id)), 'text' => __('查看余额变动', 'finance')));

        $this->assign('form_action', RC_Uri::url('finance/admin_account_log/update'));

        $user = get_user_info($user_id);
        $this->assign('user', $user);

        return $this->display('account_points.dwt');
    }

    /**
     * 调节会员账户
     */
    public function update()
    {
        $this->admin_priv('account_manage', ecjia::MSGTYPE_JSON);

        $user_id     = empty($_POST['user_id']) ? 0 : intval($_POST['user_id']);
        $user        = get_user_info($user_id);
        $type        = trim($_POST['type']);
        $change_desc = RC_String::sub_str($_POST['change_desc'], 255, false);

        if (empty($user)) {
            return $this->showmessage(__('该用户不存在', 'finance'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $pay_points  = 0;
        $rank_points = 0;
        $user_money  = 0;
        if ($type == 'add_pay_points' || $type == 'minus_pay_points') {
            $pay_points = !empty($_POST['pay_points']) ? $_POST['pay_points'] : 0;

            if ($pay_points <= 0 || !is_numeric($pay_points) || !isset($pay_points)) {
                return $this->showmessage(__('会员积分填写有误', 'finance'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if ($type == 'add_pay_points') {
                $pay_points = floatval(1) * abs(floatval($pay_points));
                $message    = $user['user_name'] . '，' . '积分增加：' . $pay_points . '，' . '帐户变动原因是：' . $change_desc;
            } else {
                if ($pay_points > $user['pay_points']) {
                    return $this->showmessage(__('减少会员积分数不能大于当前账户积分', 'finance'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
                $message    = $user['user_name'] . '，' . '积分减少：' . $pay_points . '，' . '帐户变动原因是：' . $change_desc;
                $pay_points = floatval(-1) * abs(floatval($pay_points));
            }
            ecjia_admin::admin_log($message, 'edit', 'pay_points');

            $pjax_url = RC_Uri::url('finance/admin_account_log/init', array('account_type' => 'pay_points', 'user_id' => $user_id));

        } elseif ($type == 'add_rank_points' || $type == 'minus_rank_points') {
            $rank_points = !empty($_POST['rank_points']) ? $_POST['rank_points'] : 0;

            if ($rank_points <= 0 || !is_numeric($rank_points) || !isset($rank_points)) {
                return $this->showmessage(__('成长值账户填写有误', 'finance'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            if ($type == 'add_rank_points') {
                $rank_points = floatval(1) * abs(floatval($rank_points));
                $message     = sprintf('%s，成长值增加：%s，账户变动原因是：%s', $user['user_name'], $rank_points, $change_desc);

            } else {
                if ($rank_points > $user['rank_points']) {
                    return $this->showmessage(__('减少会员成长值不能大于当前账户成长值', 'finance'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
                $message = sprintf('%s，成长值减少：%s，账户变动原因是：%s', $user['user_name'], $rank_points, $change_desc);

                $rank_points = floatval(-1) * abs(floatval($rank_points));
            }
            ecjia_admin::admin_log($message, 'edit', 'rank_points');

            $pjax_url = RC_Uri::url('finance/admin_account_log/init', array('account_type' => 'rank_points', 'user_id' => $user_id));
        } elseif ($type == 'add_user_money' || $type == 'minus_user_money') {
            $user_money = !empty($_POST['user_money']) ? $_POST['user_money'] : 0;

            if ($user_money <= 0 || !is_numeric($user_money) || !isset($user_money)) {
                return $this->showmessage(__('金额填写有误', 'finance'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if ($type == 'add_user_money') {
                $user_money = floatval(1) * abs(floatval($user_money));
                $message    = sprintf('%s，余额增加：：%s，账户变动原因是：%s', $user['user_name'], $user_money, $change_desc);

            } else {
                if ($user_money > $user['user_money']) {
                    return $this->showmessage(__('减少余额数不能大于当前账户余额', 'finance'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
                $message = sprintf('%s，余额减少：：%s，账户变动原因是：%s', $user['user_name'], $user_money, $change_desc);

                $user_money = floatval(-1) * abs(floatval($user_money));
            }
            ecjia_admin::admin_log($message, 'edit', 'user_money');

            $pjax_url = RC_Uri::url('finance/admin_account_log/init', array('account_type' => 'user_money', 'user_id' => $user_id));
        }
        change_account_log($user_id, $user_money, 0, $rank_points, $pay_points, $change_desc, ACT_ADJUSTING);

        return $this->showmessage(__('操作成功', 'finance'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $pjax_url));
    }
}

// end
