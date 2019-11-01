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

use Ecjia\App\Finance\AccountConstant;
/**
 * 分成订单管理
 * @author wutifang
 */
class admin_separate extends ecjia_admin {
    public function __construct() {
        parent::__construct();

        Ecjia\App\Affiliate\Helper::assign_adminlog_content();

        /* 加载所有全局 js/css */
        RC_Script::enqueue_script('bootstrap-placeholder');
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');
        RC_Script::enqueue_script('jquery-chosen');
        RC_Style::enqueue_style('chosen');
        RC_Script::enqueue_script('jquery-uniform');
        RC_Style::enqueue_style('uniform-aristo');
        RC_Script::enqueue_script('bootstrap-editable-script', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
        RC_Style::enqueue_style('bootstrap-editable-css', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
        RC_Script::enqueue_script('affiliate', RC_App::apps_url('statics/js/affiliate.js', __FILE__), array(), false, 1);

        RC_Script::localize_script('affiliate', 'js_lang', config('app-affiliate::jslang.affiliate_page'));
    }

    /**
     * 分成订单列表页
     */
    public function init() {

        //结算后代理分佣
//        RC_Loader::load_app_func('admin_order', 'orders');
//        $order_info = order_info(97);
//        $order_info['order_type'] = 'buy';
//        $rs = with(new Ecjia\App\Affiliate\AffiliateStoreCommission($order_info['store_id'], $order_info))->run();
//        _dump($rs,1);
////
//	    $order_info = RC_Api::api('orders', 'order_info', ['order_sn' => '102019102117151133315647']);
//        $rs = Ecjia\App\Affiliate\OrderAffiliate::OrderAffiliateDo($order_info);
//        _dump($rs,1);

        $this->admin_priv('affiliate_ck_manage');
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('分成订单', 'affiliate')));
        $this->assign('ur_here', __('分成订单', 'affiliate'));

        $affiliate = unserialize(ecjia::config('affiliate'));
        empty($affiliate) && $affiliate = array();
        $separate_on = $affiliate['on'];
        $this->assign('on', $separate_on);

        $logdb = $this->get_affiliate_ck();
        $this->assign('logdb', $logdb);
        $this->assign('filter', $logdb['filter']);
        $this->assign('type_count', $logdb['type_count']);

//        $order_stats = array(
//            'name' 	=> __('订单状态', 'affiliate'),
//            '0' 	=> __('未确认', 'affiliate'),
//            '1' 	=> __('已确认', 'affiliate'),
//            '2' 	=> __('已取消', 'affiliate'),
//            '3' 	=> __('无效', 'affiliate'),
//            '4' 	=> __('退货', 'affiliate'),
//        );
//		$this->assign('order_stats', $order_stats);

//        $sch_stats = array(
//            'name' 	=> __('操作状态', 'affiliate'),
//            'info' 	=> __('按操作状态查找:', 'affiliate'),
//            'all' 	=> __('全部', 'affiliate'),
//            '0' 	=> __('等待处理', 'affiliate'),
//            '1' 	=> __('已分成', 'affiliate'),
//            '2' 	=> __('取消分成', 'affiliate'),
//            '3' 	=> __('已撤销', 'affiliate')
//        );
//		$this->assign('sch_stats', $sch_stats);

//        $separate_by = array(
//            '0' 	=> __('推荐注册分成', 'affiliate'),
//            '1' 	=> __('推荐订单分成', 'affiliate'),
//            '-1' 	=> __('推荐注册分成', 'affiliate'),
//            '-2' 	=> __('推荐订单分成', 'affiliate')
//        );
//		$this->assign('separate_by', $separate_by);
        $this->assign('search_action', RC_Uri::url('affiliate/admin_separate/init'));

        return $this->display('affiliate_ck_list.dwt');
    }

    /**
     * 分成
     */
    public function separate()
    {
        $this->admin_priv('affiliate_ck_update', ecjia::MSGTYPE_JSON);

        $log_id = intval($_GET['id']);

        $affiliate_log = RC_DB::table('affiliate_log')->where('log_id', $log_id)->first();
        if ($affiliate_log['separate_type'] == 1) {
            return $this->showmessage('该订单已分成', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $change_type = AccountConstant::BALANCE_AFFILIATE;
        $order_info = RC_Api::api('orders', 'order_info', array('order_id' => $affiliate_log['order_id'], 'order_sn' => ''));
        if($order_info['agencysale_store_id']) {
            $change_type = AccountConstant::BALANCE_AGENCYSALE_AFFILIATE;
        }
        Ecjia\App\Affiliate\OrderAffiliate::OrderAffiliateChangeAccount($affiliate_log, $change_type);

        return $this->showmessage('操作成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    public function batch() {
        $this->admin_priv('affiliate_ck_update', ecjia::MSGTYPE_JSON);

        $ids = !empty($_POST['id']) ? $_POST['id'] : '';
        $page = $_GET['page'] ? intval($_GET['page']) : 1;

        $ids = explode(',', $ids);
        if(empty($ids)) {
            return $this->showmessage('请选择要操作的记录', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        foreach ($ids as $log_id) {
            $affiliate_log = RC_DB::table('affiliate_log')->where('log_id', $log_id)->first();
            if ($affiliate_log['separate_type'] == 1) {
                return $this->showmessage('该订单已分成', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            $change_type = AccountConstant::BALANCE_AFFILIATE;
            $order_info = RC_Api::api('orders', 'order_info', array('order_id' => $affiliate_log['order_id'], 'order_sn' => ''));
            if($order_info['agencysale_store_id']) {
                $change_type = AccountConstant::BALANCE_AGENCYSALE_AFFILIATE;
            }
            Ecjia\App\Affiliate\OrderAffiliate::OrderAffiliateChangeAccount($affiliate_log, $change_type);
        }

        $pjaxurl = RC_Uri::url('affiliate/admin_separate/init', ['page' => $page]);
        return $this->showmessage('操作成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $pjaxurl));
    }


    /**
     * 取消分成，不再能对该订单进行分成
     */
    public function cancel() {
        $this->admin_priv('affiliate_ck_update', ecjia::MSGTYPE_JSON);

        $id = (int)$_GET['id'];
        $oid = (int)$_GET['order_id'];
        $info = RC_DB::table('order_info')->where('order_id', $oid)->first();

        if (empty($info['is_separate'])) {
            $data = array(
                'is_separate' => '2'
            );
            ecjia_admin::admin_log(__('订单号为 ', 'affiliate').$info['order_sn'], 'cancel', 'affiliate');
            RC_DB::table('order_info')->where('order_id', $oid)->update($data);
        }
        //更新分成记录金额状态
        RC_DB::table('affiliate_log')->where('log_id', $id)->update(array('separate_type' => 2));
        return $this->showmessage(__('取消成功', 'affiliate'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    /**
     * 撤销某次分成，将已分成的收回来
     */
    public function rollback() {
        $this->admin_priv('affiliate_ck_update', ecjia::MSGTYPE_JSON);

        $logid = (int)$_GET['id'];
        $stat = RC_DB::table('affiliate_log')->where('log_id', $logid)->first();
        $change_type = AccountConstant::BALANCE_AFFILIATE_REFUND;
        $order_info = RC_Api::api('orders', 'order_info', array('order_id' => $stat['order_id'], 'order_sn' => ''));
        if($order_info['agencysale_store_id']) {
            $change_type = AccountConstant::BALANCE_AGENCYSALE_AFFILIATE_REFUND;
        }
        if (!empty($stat)) {
            $change_desc = '取消推荐订单分成';

            $order_sn = ecjia_order_affiliate_sn();

            /* 变量初始化 */
            $surplus = array(
                'user_id'      => $stat['user_id'],
                'order_sn'     => $order_sn,
                'process_type' => SURPLUS_AFFILIATE,
                'payment_id'   => 0,
                'user_note'    => $change_desc,
                'amount'       => $stat['money'] * -1,
                'from_type'    => 'system',
                'from_value'   => '',
                'is_paid'      => 1,
            );
            RC_Loader::load_app_func('admin_user', 'finance');
            //插入会员账目明细
            $surplus['account_id'] = insert_user_account($surplus, $surplus['amount']);

            $arr = array(
                'user_id'		=> $stat['user_id'],
                'user_money'	=> $stat['money'] * -1,
                'rank_points'	=> -$stat['point'],
                'change_type'   => $change_type,
                'change_desc'	=> __('分成被管理员取消！', 'affiliate')
            );
            RC_Api::api('user', 'account_change_log', $arr);

            $data = array(
                'is_separate' => 2,
            );
            RC_DB::table('order_info')->where('order_id', $stat['order_id'])->update($data);

            $data = array(
                'separate_type' => 2
            );
            ecjia_admin::admin_log(__('订单号为 ', 'affiliate').$order_info['order_sn'], 'rollback', 'affiliate');
            RC_DB::table('affiliate_log')->where('log_id', $logid)->update($data);
            //分成统计更新
            Ecjia\App\Affiliate\OrderAffiliate::update_affiliate_count($stat['user_id']);
        }
        return $this->showmessage(__('撤销成功', 'affiliate'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    public function download() {
        $this->admin_priv('affiliate_ck_manage');

        $logdb = $this->get_affiliate_ck('all');
        $list = [];
        if($logdb['item']) {
            foreach ($logdb['item'] as $row) {
//              订单编号	商家名称	购买人	订单金额	佣金	付款时间	操作状态	操作信息
                $list[] = [
                    $row['order_sn'],$row['merchants_name'],$row['consignee'],$row['total_fee_formatted']
                    ,$row['money_formatted'],$row['pay_time_formatted'],$row['separate_type_label'],$row['info']
                ];
            }
        }

        RC_Excel::load(RC_APP_PATH . 'affiliate' . DIRECTORY_SEPARATOR .'statics/files/order_affiliate.xls', function($excel) use ($list){
            $excel->sheet('Sheet1', function($sheet) use ($list) {
                foreach ($list as $key => $item) {
                    $sheet->appendRow($key+3, $item);
                }
            });
        })->download('xls');

    }

    /**
     * 获取分成列表
     * 新规则确认收货+付款时间7天后
     * @return array
     */
    private function get_affiliate_ck($page_size = 50) {
        $affiliate = unserialize(ecjia::config('affiliate'));
        empty($affiliate) && $affiliate = array();
        $affiliate_order_pass_days = $affiliate['affiliate_order_pass_days'];//订单多久后分成

        $filter['status'] = isset($_GET['status']) ? intval($_GET['status']) : 0;
        $filter['order_sn'] = isset($_GET['order_sn']) ? remove_xss($_GET['order_sn']) : null;
        $filter['auid'] = isset($_GET['auid']) ? intval($_GET['auid']) : 0;

        $db_order_info_view = RC_DB::table('affiliate_log as a')
            ->leftJoin('order_info as o', RC_DB::raw('o.order_id'), '=', RC_DB::raw('a.order_id'))
            ->leftJoin('store_franchisee as s', RC_DB::raw('s.store_id'), '=', RC_DB::raw('o.store_id'))
            ->leftJoin('users as u', RC_DB::raw('o.user_id'), '=', RC_DB::raw('u.user_id'));


        $separate_by = $affiliate['config']['separate_by'];

        $sqladd = '';
//        $sqladd .= ' AND o.is_separate = ' . $filter['status'];

        if (!empty($filter['order_sn'])) {
            $sqladd .= ' AND o.order_sn LIKE \'%' . trim($filter['order_sn']) . '%\'';
        }

        if (!empty($filter['auid'])) {
            $sqladd .= ' AND a.user_id=' . $filter['auid'];
        }

        //TODO
        if (!empty($affiliate['on'])) {
            if (empty($separate_by)) {
                $where = "o.user_id > 0 AND (u.parent_id > 0 AND o.is_separate = 0 OR o.is_separate > 0) $sqladd";
            } else {
                $where = "o.user_id > 0 AND (o.parent_id > 0 AND o.is_separate = 0 OR o.is_separate > 0) $sqladd";
            }
        } else {
            $where = "o.user_id > 0 AND o.is_separate > 0 $sqladd";
        }
        $db_order_info_view->whereRaw($where)->where( RC_DB::raw('o.shipping_status'), SS_RECEIVED);
        if($affiliate_order_pass_days) {
            $db_order_info_view->where( RC_DB::raw('a.time'), '<', RC_Time::gmtime() - 86400 * $affiliate_order_pass_days);
        }

        if($page_size != 'all') {
            $type_count = $db_order_info_view->select(RC_DB::raw('count(*) as count'),
                RC_DB::raw('SUM(separate_type = 0) as await_pay'),
                RC_DB::raw('SUM(separate_type = 1) as payed'),
                RC_DB::raw('SUM(separate_type = 2) as canceled'))->first();
        }

        $db_order_info_view->where(RC_DB::raw('separate_type'), $filter['status']);

        if($page_size != 'all') {
            $count = $db_order_info_view->count();

            $page = new ecjia_page($count, $page_size, 5);
        }

        $logdb = array();

        $field = "o.*, (o.goods_amount + o.shipping_fee + o.insure_fee + o.pay_fee + o.pack_fee + o.card_fee + o.tax - o.integral_money - o.bonus - o.discount) as total_fee,
		 s.merchants_name, s.manage_mode, a.log_id, a.user_id as suid, a.money, a.point, a.separate_type, u.parent_id as up";
        $db_order_info_view->select(RC_DB::raw($field));
        if($page_size == 'all') {
            $db_order_info_view->orderBy(RC_DB::raw('o.order_id'), 'desc');
        } else {
            $db_order_info_view->take($page_size)->skip($page->start_id-1)->orderBy(RC_DB::raw('o.order_id'), 'desc');
        }
        $data = $db_order_info_view->get();

        $sch_stats = array(
            'name' 	=> __('操作状态', 'affiliate'),
            'info' 	=> __('按操作状态查找:', 'affiliate'),
            'all' 	=> __('全部', 'affiliate'),
            '0' 	=> __('等待处理', 'affiliate'),
            '1' 	=> __('已分成', 'affiliate'),
            '2' 	=> __('取消分成', 'affiliate'),
            '3' 	=> __('已撤销', 'affiliate')
        );

        if (!empty($data)) {
            foreach ($data as $rt) {
                $rt['total_fee_formatted'] = ecjia_price_format($rt['total_fee']);
                $rt['money_formatted'] = ecjia_price_format($rt['money']);
                $rt['pay_time_formatted'] = RC_Time::local_date(ecjia::config('time_format'), $rt['pay_time']);
                if($rt['agencysale_store_id']) {
                    $rt['agencysale'] = 1;
                }

                if (!empty($rt['suid'])) {
                    //在affiliate_log有记录
                    $user_name = RC_DB::table('users')->where('user_id', $rt['suid'])->value('user_name');
                    $rt['info'] = sprintf(__('用户ID %s ( %s ), 分成:金钱 %s', 'affiliate'), $rt['suid'], $user_name, $rt['money']);
                    if ($rt['separate_type'] == -1 || $rt['separate_type'] == -2) {
                        //已被撤销
//						$rt['is_separate'] = 3;
                        $rt['info'] = "<s>" . $rt['info'] . "</s>";
                    }
                }
                $rt['separate_type_label'] = $sch_stats[$rt['separate_type']];
                $logdb[] = $rt;
            }
        }
        if($page_size == 'all') {
            return array('item' => $logdb);
        }
        return array('item' => $logdb, 'page' => $page->show(5), 'type_count' => $type_count, 'filter' => $filter, 'desc' => $page->page_desc(), 'current_page' => $page->current_page);
    }


    /**
     * 记录分成日志
     */
    private function write_affiliate_log($oid, $uid, $username, $money, $point, $separate_by) {
        $time = RC_Time::gmtime();
        $data = array(
            'order_id' 		=> $oid,
            'user_id' 		=> $uid,
            'user_name' 	=> $username,
            'time' 			=> $time,
            'money' 		=> $money,
            'point' 		=> $point,
            'separate_type' => $separate_by
        );
        if ($oid) {
            RC_DB::table('affiliate_log')->insert($data);
        }
    }
}

//end