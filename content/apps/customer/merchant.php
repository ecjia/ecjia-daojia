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
 * 商家会员（购买过用户） 商家粉丝（关注用户）
 * 时间格式：年-月-日 时:分
 * 详情两种：自营商家看全部信息，非自营看部分信息
 * 粉丝分两种：会员和非会员（会员可查看会员详情，非会员不可查看）
 */
class merchant extends ecjia_merchant {
    public function __construct() {
        parent::__construct();

        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');
        RC_Style::enqueue_style('uniform-aristo');


        RC_Script::enqueue_script('bootstrap-fileupload-script', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/bootstrap-fileupload/bootstrap-fileupload.js', array());
        RC_Style::enqueue_style('bootstrap-fileupload', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/bootstrap-fileupload/bootstrap-fileupload.css', array(), false, false);


        //时间控件
        RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));
        RC_Style::enqueue_style('datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.min.css'));
        RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
        RC_Script::enqueue_script('bootstrap-datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.js'));

        RC_Script::enqueue_script('merchant_list', RC_App::apps_url('statics/js/merchant_list.js', __FILE__), array(), false, 1);

    }

    /**
     * 商家会员
     */
    public function init() {
        $this->admin_priv('store_member');
        ecjia_screen::get_current_screen()->remove_last_nav_here();
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商家会员', 'customer')));
        $this->assign('ur_here', __('商家会员', 'customer'));

        $url_parames = RC_Uri::url('customer/merchant/download');
        if(!empty($_GET['keywords'])) {
            $url_parames .= '&keywords='.$_GET['keywords'];
        }
        if(!empty($_GET['start_date'])) {
            $url_parames .= '&start_date='.$_GET['start_date'];
        }
        if(!empty($_GET['end_date'])) {
            $url_parames .= '&end_date='.$_GET['end_date'];
        }
        if(!empty($_GET['rank_id'])) {
            $url_parames .= '&rank_id='.$_GET['rank_id'];
        }
        $action_link = array(
            'href' => $url_parames,
            'text' => '导出报表'
        );

        $this->assign('action_link', $action_link);

        /* 时间参数 */
        $start_time = !empty($_GET['start_time']) ? $_GET['start_time'] : '';
        $end_time   = !empty($_GET['end_time']) ? $_GET['end_time'] : '';

        $this->assign('start_time', $start_time);
        $this->assign('end_time', $end_time);

        RC_Loader::load_app_func('admin_user', 'user');

        $rank_list = get_user_rank_list();
        $this->assign('rank_list', $rank_list);

        $user_list = $this->get_store_user_list();

        $this->assign('user_list', $user_list);
        $this->assign('form_action', RC_Uri::url('customer/merchant/init'));
        $this->assign('search_action', RC_Uri::url('customer/merchant/init'));

        return $this->display('member_list.dwt');
    }

    public function download()
    {

        $act = $_GET['act'];

        $data = array();
        $file = '';

        if (empty($act))
        {
            $data = $this->get_store_user_list(99999);

            $list = array();
            foreach ($data['list'] as $key => $value)
            {
                $list[$key]['user_name'] = $value['user_name'];
                $list[$key]['mobile_phone'] = $value['mobile_phone'];
                $list[$key]['buy_times'] = $value['buy_times'];
                $list[$key]['buy_amount'] = $value['buy_amount'];
                $list[$key]['rank_name'] = $value['rank_name'];
                if ($value['join_scene'] == 'qrcode')
                {
                    $list[$key]['join_scene'] = '推广二维码';
                }
                elseif ($value['join_scene'] == 'quickpay')
                {
                    $list[$key]['join_scene'] = '门店买单';
                }
                elseif ($value['join_scene'] == 'cashier_suggest')
                {
                    $list[$key]['join_scene'] = '收银员推荐';
                }
                elseif ($value['join_scene'] == 'buy')
                {
                    $list[$key]['join_scene'] = '店铺消费';
                }
                else{
                    $list[$key]['join_scene'] = '其他方式';
                }

                $list[$key]['last_buy_time_format'] = !empty($value['last_buy_time_format']) ? $value['last_buy_time_format'] : '无';
                $list[$key]['add_time_format'] = $value['add_time_format'];

            }
            $file = '商家会员列表.xls';
        }

        $item = $list;

        RC_Excel::load(RC_APP_PATH . 'customer' . DIRECTORY_SEPARATOR . 'statics/files/' . $file, function ($excel) use ($item) {
            $excel->sheet('First sheet', function ($sheet) use ($item) {
                foreach ($item as $k => $v) {
                    $sheet->appendRow($k + 2, $v);
                }
            });
        })->download('xls');
    }

    public function fans() {
        $this->admin_priv('store_fans');
        ecjia_screen::get_current_screen()->remove_last_nav_here();
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商家粉丝', 'customer')));
        $this->assign('ur_here', __('商家粉丝', 'customer'));

        $user_list = $this->get_collect_store_user_list();
        $this->assign('user_list', $user_list);
        $this->assign('search_action', RC_Uri::url('customer/merchant/fans'));

        return $this->display('fans_list.dwt');
    }

    /* 详情两种：自营商家看全部信息，非自营看部分信息
    * 粉丝分两种：会员和非会员（会员可查看会员详情，非会员不可查看）
    */
    public function info() {
        $this->admin_priv('store_member_info');

        $user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
        if($user_id < 1) {
            return $this->showmessage(__('参数无效', 'customer'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $store_user = RC_DB::table('store_users')->where('user_id', $user_id)->where('store_id', $_SESSION['store_id'])->first();
        if(empty($store_user)) {
            return $this->showmessage(__('非会员不能查看详情', 'customer'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商家会员', 'customer'), RC_Uri::url('customer/merchant/init')));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商家会员详情', 'customer')));
        $this->assign('ur_here', __('商家会员详情', 'customer'));
        $this->assign('action_link', array('text' => __('返回会员列表', 'customer'), 'href' => RC_Uri::url('customer/merchant/init')));

        //用户信息
        $user_info = $this->get_store_user_info($user_id);

        $manage_mode = RC_DB::table('store_franchisee')->where('store_id', $_SESSION['store_id'])->pluck('manage_mode');
        $this->assign('manage_mode', $manage_mode);

        if($manage_mode == 'self') {
            //收货地址
            $address_list = $this->get_user_address($user_id);
            $this->assign('address_list', $address_list);
        }

        //订单列表
        $order_list = $this->get_user_order_list($user_id);
        $this->assign('order_list', $order_list);
        if($order_list) {
            //最新订单位置
            $user_info['province_name']  = ecjia_region::getRegionName($order_list['list'][0]['province']);
            $user_info['city_name']    	= ecjia_region::getRegionName($order_list['list'][0]['city']);
        }
// 	    _dump($order_list,1);
        $this->assign('user_info', $user_info);

        return $this->display('member_info.dwt');
    }

    private function get_user_order_list($user_id, $page_size = 10) {

// 	    $_GET['sss'] = '#order';
        $db_order = RC_DB::table('order_info')->where('user_id', $user_id)->where('store_id', $_SESSION['store_id']);
        $count = $db_order->count();
        $page = new ecjia_merchant_page($count, $page_size, 5);

        $order = $db_order
            ->orderBy('add_time', 'desc')
            ->take($page_size)
            ->skip($page->start_id-1)
            ->get();

        if (!empty($order)) {
            foreach ($order as $k => $v) {
                $order[$k]['add_time']	 = RC_Time::local_date(ecjia::config('time_format'), $v['add_time']);
                $is_cod = $v['pay_code'] == 'pay_cod' ? 1 : 0;
                $label_status = with(new Ecjia\App\Orders\OrderStatus())->getOrderStatusLabel($v['order_status'], $v['shipping_status'], $v['pay_status'], $is_cod);
                $order[$k]['status'] = $label_status[0];
            }
        }

        return array('list' => $order, 'page' => $page->show(2), 'desc' => $page->page_desc(), 'count' => $count);
    }

    /**
     * 获取列表
     */
    private function get_store_user_list($page_size=10) {

        $filter = array();
        $filter['keywords']   = empty($_GET['keywords'])      ? ''                : remove_xss($_GET['keywords']);
        $filter['rank_id']     = empty($_GET['rank_id'])        ? 0                 : intval($_GET['rank_id']);

        $filter['start_time']     = empty($_GET['start_time'])        ? 0                 : $_GET['start_time'];
        $filter['end_time']     = empty($_GET['end_time'])        ? 0                 : $_GET['end_time'];


        $filter['sort_order'] = empty($_GET['sort_order'])    ? 'DESC'            : remove_xss($_GET['sort_order']);
        $filter['type']   	  = empty($_GET['type'])      	  ? 'buy'             : remove_xss($_GET['type']);
        $filter['sort_by'] 	  = 's.add_time';

        if (!empty($_GET['sort_by'])) {
            if ($_GET['sort_by'] == 'buy_times') {
                $filter['sort_by'] = 'buy_times';
            }
            if ($_GET['sort_by'] == 'buy_amount') {
                $filter['sort_by'] = 'buy_amount';
            }
        }

        $db_store_users = RC_DB::table('store_users as s')
            ->where(RC_DB::raw('s.store_id'), $_SESSION['store_id'])
            ->leftJoin('users as u', RC_DB::raw('u.user_id'), '=', RC_DB::raw('s.user_id'));

        if (!empty($filter['keywords'])) {
            $db_store_users ->whereRaw('(u.user_name  like  "%'.mysql_like_quote($filter['keywords']).'%" or u.mobile_phone = "'.mysql_like_quote($filter['keywords']).'")');
        }
        if ($filter['rank_id'] && ($filter['rank_id'] > 0)) {
            $db_store_users ->where(RC_DB::raw('u.user_rank'), $filter['rank_id']);
        }

        if ($filter['start_time']) {
            $start_time = RC_Time::local_strtotime($filter['start_time']);
            $db_store_users->where('add_time', '>=', $start_time);

        }

        if ($filter['end_time']) {
            $end_time = RC_Time::local_strtotime($filter['end_time']) + 65535;
            $db_store_users->where('add_time', '<=', $end_time);

        }

        $type_count = $db_store_users->select(RC_DB::raw("SUM(join_scene = 'affiliate') as affiliate"),
            RC_DB::raw("SUM(join_scene = 'buy') as buy"))->first();

        if ($filter['type']) {
            $db_store_users->where(RC_DB::raw('s.join_scene'), $filter['type']);
        }




        $count = $db_store_users->count();
        $page = new ecjia_merchant_page($count, $page_size, 5);

        $result = $db_store_users->select(RC_DB::raw('s.*'), RC_DB::raw('u.user_name,u.mobile_phone,u.avatar_img,user_rank'))
            ->orderby(RC_DB::raw($filter['sort_by']), $filter['sort_order'])
            ->take($page_size)
            ->skip($page->start_id-1)
            ->get();

        $users = array();
        if (!empty($result)) {
            foreach ($result as $rows) {
                $rows['add_time_format'] = !empty($rows['add_time']) ? RC_Time::local_date('Y-m-d H:i', $rows['add_time']) : '';
                $rows['last_buy_time_format'] = !empty($rows['last_buy_time']) ? RC_Time::local_date('Y-m-d H:i', $rows['last_buy_time']): '';
                if ($rows['user_rank'] == 0 && !empty($rows['user_name'])) {
                    //重新计算会员等级
                    $rank = RC_Api::api('user', 'update_user_rank', array('user_id' => $rows['user_id']));
                } else {
                    $rank = RC_DB::table('user_rank')->select('rank_id', 'rank_name')->where('rank_id', $rows['user_rank'])->first();
                }
                $rows['avatar_img'] = !empty($rows['avatar_img']) ? RC_Upload::upload_url($rows['avatar_img']) : '';
                $rows['rank_name'] = $rank['rank_name'];
                $rows['mobile_phone'] = !empty($rows['mobile_phone']) ? substr_replace($rows['mobile_phone'],'****',3,4) : '';
                //订单总金额（普通配送订单，不含退款）
                $rows['buy_amount'] = price_format($rows['buy_amount']);
                $users[] = $rows;
            }
        }
        return array('list' => $users, 'filter' => $filter, 'count' => $type_count, 'page' => $page->show(2), 'desc' => $page->page_desc());
    }

    private function get_store_user_info($user_id) {

        $db_store_users = RC_DB::table('store_users as s')
            ->where(RC_DB::raw('s.store_id'), $_SESSION['store_id'])
            ->where(RC_DB::raw('s.user_id'), $user_id)
            ->leftJoin('users as u', RC_DB::raw('u.user_id'), '=', RC_DB::raw('s.user_id'));

        $rows = $db_store_users->select(RC_DB::raw('s.*'), RC_DB::raw('u.user_name,u.mobile_phone,u.avatar_img,user_rank,email,pay_points,user_money,reg_time'))
            ->first();

        $rows['reg_time_format'] = !empty($rows['reg_time']) ? RC_Time::local_date('Y-m-d H:i', $rows['reg_time']) : '';
        $rows['last_buy_time_format'] = !empty($rows['last_buy_time']) ? RC_Time::local_date('Y-m-d H:i', $rows['last_buy_time']): '';
        if ($rows['user_rank'] == 0) {
            // 非特殊等级，根据成长值计算用户等级（注意：不包括特殊等级）
            $rank = RC_DB::table('user_rank')->select('rank_id', 'rank_name')->where('special_rank', 0)->where('min_points', '<=', intval($rows['rank_points']))->where('max_points', '>', intval($rows['rank_points']))->first();
        } else {
            // 特殊等级
            $rank = RC_DB::table('user_rank')->select('rank_id', 'rank_name')->where('rank_id', $rows['user_rank'])->first();
        }
        $rows['avatar_img'] = !empty($rows['avatar_img']) ? RC_Upload::upload_url($rows['avatar_img']) : '';
        $rows['rank_name'] = $rank['rank_name'];
        $rows['mobile_phone_format'] = !empty($rows['mobile_phone']) ? substr_replace($rows['mobile_phone'],'****',3,4) : '';
        $rows['user_money'] = !empty($rows['user_money']) ? price_format($rows['user_money']) : '0';
        //订单总金额（普通配送订单，不含退款）
        $rows['buy_amount'] = price_format($rows['buy_amount']);

        return $rows;
    }

    private function get_collect_store_user_list($page_size = 10) {


        $filter = array();
        $filter['keywords']   = empty($_GET['keywords'])      ? ''                : remove_xss($_GET['keywords']);

        $filter['sort_order'] = empty($_GET['sort_order'])    ? 'DESC'            : remove_xss($_GET['sort_order']);
        $filter['type']   	  = empty($_GET['type'])      	  ? ''                : remove_xss($_GET['type']);
        $filter['sort_by'] 	  = 's.rec_id';

        if (!empty($_GET['sort_by'])) {
            if ($_GET['sort_by'] == 'visit_times') {
                $filter['sort_by'] = 'visit_times';
            }
        }

        $db_collect_store = RC_DB::table('collect_store as s')
            ->where(RC_DB::raw('s.store_id'), $_SESSION['store_id'])
            ->leftJoin('users as u', RC_DB::raw('u.user_id'), '=', RC_DB::raw('s.user_id'));

        if (!empty($filter['keywords'])) {
            $db_collect_store ->where(RC_DB::raw('u.user_name'), 'like', '%' . mysql_like_quote($filter['keywords']) . '%');
        }

        $count = $db_collect_store->count();
        $page = new ecjia_merchant_page($count, $page_size, 5);

        $result = $db_collect_store->select(RC_DB::raw('s.*'), RC_DB::raw('u.user_name,u.avatar_img'))
            ->orderby(RC_DB::raw($filter['sort_by']), $filter['sort_order'])
            ->take($page_size)
            ->skip($page->start_id-1)
            ->get();

        $users = array();
        if (!empty($result)) {
            $fans_config = RC_Loader::load_app_config('fans', 'customer');
            foreach ($result as $rows) {
                $rows['add_time_format'] = !empty($rows['add_time']) ? RC_Time::local_date('Y-m-d H:i', $rows['add_time']) : '';
                $rows['last_visit_time_format'] = !empty($rows['last_visit_time']) ? RC_Time::local_date('Y-m-d H:i', $rows['last_visit_time']): '';
                $rows['avatar_img'] = !empty($rows['avatar_img']) ? RC_Upload::upload_url($rows['avatar_img']) : '';
                $rows['referer'] = isset($fans_config['referer'][$rows['referer']]) ? $fans_config['referer'][$rows['referer']] : '未知';
                $users[] = $rows;
            }
        }

        return array('list' => $users, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc());

    }

    private function get_user_address($user_id) {
        /* 取用户默认地址id */
        $address_id = RC_DB::table('user_address as ua')
            ->leftJoin('users as u', RC_DB::raw('ua.address_id'), '=', RC_DB::raw('u.address_id'))
            ->where(RC_DB::raw('u.user_id'), $user_id)
            ->select(RC_DB::raw('ua.*'))
            ->first();

        $default_address_count = empty($address_id['address_id']) ? 0 : 1;

        /* 用户地址列表*/
        $db_user_address = RC_DB::table('user_address as ua');
        if ($address_id) {
            $db_user_address
                ->orderBy('default_address', 'desc')
                ->select(RC_DB::raw("ua.*, IF(address_id=".$address_id['address_id'].", 1, 0) as default_address"));
        }

        $row = $db_user_address->where('user_id', $user_id)->get();
        foreach ($row as $key => $val) {
            $row[$key]['country_name']   = ecjia_region::getRegionName($val['country']);
            $row[$key]['province_name']  = ecjia_region::getRegionName($val['province']);
            $row[$key]['city_name']    	= ecjia_region::getRegionName($val['city']);
            $row[$key]['district_name']  = ecjia_region::getRegionName($val['district']);
            $row[$key]['street_name']    = ecjia_region::getRegionName($val['street']);
        }

        return $row;
    }

    private function get_rank_list() {
        return RC_DB::table('user_rank')->select('rank_id', 'rank_name', 'min_points')->orderBy('min_points', 'asc')->get();
    }

}

//end