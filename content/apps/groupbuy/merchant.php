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

class merchant extends ecjia_merchant
{
    public function __construct()
    {
        parent::__construct();

        RC_Loader::load_app_func('admin_category', 'goods');
        RC_Loader::load_app_func('admin_order', 'orders');
        RC_Loader::load_app_func('global', 'goods');
        
        /* 加载全局 js/css */
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');

        /*快速编辑*/
        RC_Script::enqueue_script('bootstrap-editable-script', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/x-editable/bootstrap-editable/js/bootstrap-editable.min.js', array());
        RC_Style::enqueue_style('bootstrap-editable-css', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/x-editable/bootstrap-editable/css/bootstrap-editable.css', array(), false, false);

        //时间控件
        RC_Script::enqueue_script('bootstrap-datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.js'));
        RC_Style::enqueue_style('datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.min.css'));

        RC_Script::enqueue_script('groupbuy', RC_App::apps_url('statics/mh-js/groupbuy.js', __FILE__), array(), false, true);
        RC_Script::localize_script('groupbuy', 'js_lang', RC_Lang::get('groupbuy::group_buy.js_lang'));

        RC_Style::enqueue_style('mh_groupbuy', RC_App::apps_url('statics/css/mh_groupbuy.css', __FILE__), array());

        ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('团购活动管理'), RC_Uri::url('groupbuy/merchant/init')));
        ecjia_merchant_screen::get_current_screen()->set_parentage('groupbuy', 'groupbuy/merchant.php');
    }

    /**
     * 团购活动列表
     */
    public function init()
    {
        $this->admin_priv('groupbuy_manage', ecjia::MSGTYPE_JSON);

        $this->assign('ur_here', '团购活动列表');
        $this->assign('action_link', array('href' => RC_Uri::url('groupbuy/merchant/add'), 'text' => '添加团购活动'));

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('团购活动列表')));

        $groupbuy_list = $this->group_buy_list();
        $this->assign('groupbuy_list', $groupbuy_list);

        $this->assign('priv_ru', 1);
        $this->assign('search_action', RC_Uri::url('groupbuy/merchant/init'));
        $this->assign_lang();

        $this->display('group_buy_list.dwt');
    }

    /**
     * 添加团购活动页面
     */
    public function add()
    {
        $this->admin_priv('groupbuy_add', ecjia::MSGTYPE_JSON);

        $this->assign('ur_here', '添加团购商品');
        $this->assign('ur_here2', '设置团购信息');
        $this->assign('action_link', array('href' => RC_Uri::url('groupbuy/merchant/init'), 'text' => '团购活动列表'));

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('添加团购活动')));

        $group_buy = array(
            'start_time' => RC_Time::local_date('Y-m-d H:i:s', RC_Time::gmtime()),
            'end_time' => RC_Time::local_date('Y-m-d H:i:s', (RC_Time::gmtime() + (3 * 3600 * 24))),
            'act_type' => GAT_GROUP_BUY,
            'price_ladder' => array(array('amount' => 0, 'price' => 0)),
        );
        $this->assign('group_buy', $group_buy);
        $this->assign('cat_list', cat_list());
//         $this->assign('brand_list', get_brand_list());
        $this->assign('action', 'insert');
        $this->assign('form_action', RC_Uri::url('groupbuy/merchant/insert'));
        $this->assign_lang();

        $this->display('group_buy_info.dwt');
    }

    /**
     * 添加团购活动处理
     */
    public function insert()
    {
        $this->admin_priv('groupbuy_add', ecjia::MSGTYPE_JSON);

        $goods_id = intval($_POST['goods_id']);
        $info = $this->goods_group_buy($goods_id);
        if ($info && $info['goods_id'] == $goods_id) {
            return $this->showmessage('您选择的商品目前有一个团购活动正在进行,请选择其他商品！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $goods_name = RC_DB::table('goods')->where('store_id', $_SESSION['store_id'])->where('goods_id', $goods_id)->pluck('goods_name');
        $act_name = $goods_name;

        RC_Loader::load_app_func('admin_goods', 'goods');
        $properties = get_goods_properties($goods_id);
        if (isset($properties['spe']) && !empty($properties['spe'])) {
            return $this->showmessage('商品有属性价格时，不可添加未团购商品！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $act_desc = !empty($_POST['act_desc']) ? trim($_POST['act_desc']) : '';
        $price_ladder = !empty($_POST['price_ladder']) ? $_POST['price_ladder'] : '';
        $restrict_amount = !empty($_POST['restrict_amount']) ? $_POST['restrict_amount'] : '';
        $gift_integral = !empty($_POST['gift_integral']) ? $_POST['gift_integral'] : 0;
        $deposit = (!empty($_POST['deposit']) && intval($_POST['deposit']) > 0) ? intval($_POST['deposit']) : 0;

        $price_ladder = array();
        $count = count($_POST['ladder_amount']);
        for ($i = $count - 1; $i >= 0; $i--) {
            $amount = intval($_POST['ladder_amount'][$i]);
            if ($amount <= 0) {
                continue;
            }
            $price = round(floatval($_POST['ladder_price'][$i]), 2);
            if ($price < $deposit) {
                return $this->showmessage('阶梯价格不能小于保证金金额！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if ($price <= 0) {
                continue;
            }
            $price_ladder[$amount] = array('amount' => $amount, 'price' => $price);
        }
        if (count($price_ladder) < 1) {
            return $this->showmessage('请输入有效的价格阶梯！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $amount_list = array_keys($price_ladder);
        if ($restrict_amount > 0 && max($amount_list) > $restrict_amount) {
            return $this->showmessage('限购数量不能小于价格阶梯中的最大数量！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        ksort($price_ladder);
        $price_ladder = array_values($price_ladder);

        $start_time = !empty($_POST['start_time']) ? RC_Time::local_strtotime($_POST['start_time']) : '';
        $end_time = !empty($_POST['end_time']) ? RC_Time::local_strtotime($_POST['end_time']) : '';

        if ($start_time >= $end_time) {
            return $this->showmessage('请输入一个有效的团购时间！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $data = array(
            'store_id' => $_SESSION['store_id'],
            'act_name' => $act_name,
            'act_desc' => $act_desc,
            'act_type' => GAT_GROUP_BUY,
            'goods_id' => $goods_id,
            'goods_name' => $goods_name,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'ext_info' => serialize(array(
                'price_ladder' => $price_ladder,
                'restrict_amount' => intval($restrict_amount),
                'gift_integral' => intval($gift_integral),
                'deposit' => intval($deposit),
            )),
        );

        $groupbuy_id = RC_DB::table('goods_activity')->insertGetId($data);

        $links[] = array('text' => __('返回团购活动列表'), 'href' => RC_Uri::url('groupbuy/merchant/init'));
        $links[] = array('text' => '继续添加团购活动', 'href' => RC_Uri::url('groupbuy/merchant/add'));
        ecjia_merchant::admin_log($goods_name, 'add', 'group_buy');
        return $this->showmessage('添加团购活动成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('groupbuy/merchant/edit', array('id' => $groupbuy_id))));
    }

    /**
     * 编辑团购活动页面
     */
    public function edit()
    {
        $this->admin_priv('groupbuy_update', ecjia::MSGTYPE_JSON);

        $this->assign('ur_here', '编辑团购商品');
        $this->assign('ur_here2', '编辑团购信息');
        
        $page = !empty($_GET['page']) ? intval($_GET['page']) : 1;
        $action_link = array('href' => RC_Uri::url('groupbuy/merchant/init'), 'text' => '团购活动列表');
        if ($page > 1) {
      		$action_link = array('href' => RC_Uri::url('groupbuy/merchant/init', array('page' => $page)), 'text' => '团购活动列表');
        }
        $this->assign('action_link', $action_link);
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('更新团购活动')));
        ecjia_screen::get_current_screen()->add_help_tab(array(
            'id' => 'overview',
            'title' => __('概述'),
            'content' =>
            '<p>' . __('欢迎访问ECJia智能后台编辑团购活动页面，可以在此页面编辑相应的团购活动信息。') . '</p>',
        ));

        ecjia_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . __('更多信息:') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:团购活动#.E7.BC.96.E8.BE.91.E5.9B.A2.E8.B4.AD.E6.B4.BB.E5.8A.A8" target="_blank">关于编辑团购活动帮助文档</a>') . '</p>'
        );

        $act_id = intval($_GET['id']);
        $group_buy = $this->group_buy_info($act_id);

        $this->assign('group_buy', $group_buy);
        
        $url = RC_Uri::url('groupbuy/merchant/update');
        if ($page > 1) {
        	$url = RC_Uri::url('groupbuy/merchant/update', array('page' => $page));
        }
        $this->assign('form_action', $url);

        $shop_price = RC_DB::table('goods')->where('store_id', $_SESSION['store_id'])->where('goods_id', $group_buy['goods_id'])->pluck('shop_price');
        $this->assign('shop_price', $shop_price);

        $this->display('group_buy_info.dwt');
    }

    /**
     * 编辑团购活动处理
     */
    public function update()
    {
        $this->admin_priv('groupbuy_update', ecjia::MSGTYPE_JSON);

        $group_buy_id = !empty($_POST['act_id']) ? intval($_POST['act_id']) : 0;
        $group_buy = $this->group_buy_info($group_buy_id);
        $page = intval($_GET['page']);

        $submitname = isset($_POST['submitname']) ? $_POST['submitname'] : '';

        $edit_url = RC_Uri::url('groupbuy/merchant/edit', array('id' => $group_buy_id));
        if ($page > 1) {
        	$edit_url = RC_Uri::url('groupbuy/merchant/edit', array('id' => $group_buy_id, 'page' => $page));
        }
        if ($submitname == 'finish') {
            if ($group_buy['status'] != GBS_UNDER_WAY) {
                return $this->showmessage(RC_Lang::get('groupbuy::groupbuy.error_status'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $data = array(
                'end_time' => RC_Time::gmtime() - 1,
            );
            RC_DB::table('goods_activity')->where('store_id', $_SESSION['store_id'])->where('act_id', $group_buy_id)->update($data);

            return $this->showmessage(RC_Lang::get('groupbuy::groupbuy.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $edit_url));
        } elseif ($submitname == 'succeed') {
            if ($group_buy['status'] != GBS_FINISHED) {
                return $this->showmessage(RC_Lang::get('groupbuy::groupbuy.error_status'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if ($group_buy['total_order'] > 0) {
//                 $list = RC_DB::table('order_info as oi')
//                 	->leftJoin('order_goods as og', RC_DB::raw('oi.order_id'), '=', RC_DB::raw('og.order_id'))
//                     ->where(RC_DB::raw('oi.extension_code'), 'group_buy')
//                     ->where(RC_DB::raw('oi.extension_id'), $group_buy_id)
//                     ->whereIn(RC_DB::raw('oi.order_status'), array(OS_CONFIRMED, OS_UNCONFIRMED))
//                     ->select(RC_DB::raw('oi.order_id'), RC_DB::raw('og.goods_number'))
//                     ->get();
//                 if (!empty($list)) {
//                 	foreach ($list as $k => $v) {
//                 		$price = $this->group_buy_price($group_buy_id, $v['goods_number']);
//                 		$data = array(
//                 			'goods_price' => $price,
//                 		);
//                 		RC_DB::table('order_goods')->where('order_id', $v['order_id'])->update($data);
//                 		$order_id_list[] = $v['order_id'];
//                 	}
//                 }
//                 $res = RC_DB::table('order_goods')->select('order_id', RC_DB::raw('SUM(goods_number * goods_price) AS goods_amount'))->whereRaw("order_id " . ecjia_db_create_in($order_id_list))->groupBy('order_id')->get();
				
            	$order_id_list = RC_DB::table('order_info')
	            	->where('extension_code', 'group_buy')
	            	->where('extension_id', $group_buy_id)
	            	->whereIn('order_status', array(OS_CONFIRMED, OS_UNCONFIRMED))
	            	->lists('order_id');
            	$final_price = $group_buy['trans_price'];
            	
            	$data = array(
            		'goods_price' => $final_price,
            	);
            	RC_DB::table('order_goods')->whereRaw("order_id " . db_create_in($order_id_list))->update($data);
            	
            	$res = RC_DB::table('order_goods')->select('order_id', RC_DB::raw('SUM(goods_number * goods_price) AS goods_amount'))->whereRaw("order_id " . db_create_in($order_id_list))->groupBy('order_id')->get();
            	
                if (!empty($res)) {
                    foreach ($res as $row) {
                        $order_id = $row['order_id'];
                        $goods_amount = floatval($row['goods_amount']);

                        /* 取得订单信息 */
                        $order = RC_Api::api('orders', 'merchant_order_info', array('order_id' => $order_id, 'order_sn' => ''));

                        /* 判断订单是否有效：余额支付金额 + 已付款金额 >= 保证金 */
                        if ($order['surplus'] + $order['money_paid'] >= $group_buy['deposit']) {
                            $order['goods_amount'] = $goods_amount;
                            if ($order['insure_fee'] > 0) {
                                $shipping = ecjia_shipping::getPluginDataById($order['shipping_id']);
                                $order['insure_fee'] = ecjia_shipping::insureFee($shipping['shipping_code'], $goods_amount, $shipping['insure']);
                            }
                            // 重算支付费用
                            $order['order_amount'] = $order['goods_amount'] + $order['shipping_fee'] + $order['tax']
                                 + $order['insure_fee'] + $order['pack_fee'] + $order['card_fee']
                                 - $order['money_paid'] - $order['surplus'];
//                             if ($order['order_amount'] > 0) {
                                $order['pay_fee'] = pay_fee($order['pay_id'], $order['order_amount']);
//                             } else {
//                                 $order['pay_fee'] = 0;
//                             }

                            $order['order_amount'] += $order['pay_fee'];
                            if ($order['order_amount'] > 0) {
                                $order['pay_status'] = PS_UNPAYED;
                                $order['pay_time'] = 0;
                            } else {
                                $order['pay_status'] = PS_PAYED;
                                $order['pay_time'] = RC_Time::gmtime();
                            }

                            if ($order['order_amount'] < 0) {
                                // todo （现在手工退款）
                            }
                            $order['order_status'] = OS_CONFIRMED;
                            $order['confirm_time'] = RC_Time::gmtime();
                            update_order($order_id, $order);
                        } else {
                            $order['order_status'] = OS_CANCELED;
                            $order['to_buyer'] = RC_Lang::get('groupbuy::groupbuy.cancel_order_reason');
                            $order['pay_status'] = PS_UNPAYED;
                            $order['pay_time'] = 0;
                            $money = $order['surplus'] + $order['money_paid'];
                            if ($money > 0) {
                                $order['surplus'] = 0;
                                $order['money_paid'] = 0;
                                $order['order_amount'] = $money;
                                order_refund($order, 1, RC_Lang::get('groupbuy::groupbuy.cancel_order_reason') . ':' . $order['order_sn']);
                            }
                            /* 更新订单 */
                            update_order($order['order_id'], $order);
                        }
                    }
                }
            }

            $data = array(
                'is_finished' => GBS_SUCCEED,
            );

            RC_DB::table('goods_activity')->where('store_id', $_SESSION['store_id'])->where('act_id', $group_buy_id)->update($data);
            /* 提示信息 */
            $links[] = array('href' => RC_Uri::url('groupbuy/merchant/init'), 'text' => RC_Lang::get('groupbuy::groupbuy.back_list'));
            return $this->showmessage(RC_Lang::get('groupbuy::groupbuy.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => $edit_url));
        } elseif ($submitname == 'fail') {
            if ($group_buy['status'] != GBS_FINISHED) {
                return $this->showmessage(RC_Lang::get('groupbuy::groupbuy.error_status'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if ($group_buy['valid_order'] > 0) {
                $res = RC_DB::table('order_info')
                    ->where('extension_code', 'group_buy')
                    ->where('extension_id', $group_buy_id)
                    ->where('order_status', OS_CONFIRMED)
                    ->orWhere('order_status', OS_UNCONFIRMED)
                    ->get();

                if (!empty($res)) {
                    foreach ($res as $order) {
                        // 修改订单状态为已取消，付款状态为未付款
                        $order['order_status'] = OS_CANCELED;
                        $order['to_buyer'] = RC_Lang::get('groupbuy::groupbuy.cancel_order_reason');
                        $order['pay_status'] = PS_UNPAYED;
                        $order['pay_time'] = 0;
                        /* 如果使用余额或有已付款金额，退回帐户余额 */
                        $money = $order['surplus'] + $order['money_paid'];
                        if ($money > 0) {
                            $order['surplus'] = 0;
                            $order['money_paid'] = 0;
                            $order['order_amount'] = $money;
                            // 退款到帐户余额
                            order_refund($order, 1, RC_Lang::get('groupbuy::groupbuy.cancel_order_reason') . ':' . $order['order_sn'], $money);
                        }
                        /* 更新订单 */
                        update_order($order['order_id'], $order);
                    }
                }
            }

            $data = array(
                'is_finished' => GBS_FAIL,
                'act_desc' => $_POST['act_desc'],
            );
            RC_DB::table('goods_activity')->where('store_id', $_SESSION['store_id'])->where('act_id', $group_buy_id)->update($data);

            return $this->showmessage(RC_Lang::get('groupbuy::groupbuy.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $edit_url));
        } elseif ($submitname == 'sms') {
            if ($group_buy['status'] != GBS_SUCCEED) {
                return $this->showmessage(RC_Lang::get('groupbuy::groupbuy.error_status'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            $res = RC_DB::table('order_info as o')->leftJoin('order_goods as g', RC_DB::raw('o.order_id'), '=', RC_DB::raw('g.order_id'))
                ->selectRaw('o.consignee, g.goods_name')
                ->where(RC_DB::raw('o.extension_code'), 'group_buy')
                ->where(RC_DB::raw('o.extension_id'), $group_buy_id)
                ->where(RC_DB::raw('o.order_status'), OS_CONFIRMED)
                ->get();

            if (!empty($res)) {
                foreach ($res as $order) {
                    $options = array(
                        'user_name' => $order['consignee'],
                        'store_name' => $_SESSION['store_name'],
                    	'goods_name' => $order['goods_name']
                    );
                    RC_Api::api('sms', 'sms_groupbuy_activity_succeed', $options);
                }
            }
            return $this->showmessage('短信发送成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $edit_url));

        } else {
            $goods_id = intval($_POST['goods_id']);

            $info = $this->goods_group_buy($goods_id);
            if ($info && $info['act_id'] != $group_buy_id) {
                return $this->showmessage('您选择的商品目前有一个团购活动正在进行,请选择其他商品！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            RC_Loader::load_app_func('admin_goods', 'goods');
            $properties = get_goods_properties($goods_id);
            if (isset($properties['spe']) && !empty($properties['spe'])) {
                return $this->showmessage('商品有属性价格时，不可添加未团购商品！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $goods_name = RC_DB::table('goods')->where('store_id', $_SESSION['store_id'])->where('goods_id', $goods_id)->pluck('goods_name');
            $act_name = $goods_name;

            $act_desc = !empty($_POST['act_desc']) ? trim($_POST['act_desc']) : '';
            $price_ladder = !empty($_POST['price_ladder']) ? $_POST['price_ladder'] : '';
            $restrict_amount = !empty($_POST['restrict_amount']) ? $_POST['restrict_amount'] : '';
            $gift_integral = !empty($_POST['gift_integral']) ? $_POST['gift_integral'] : 0;
            $deposit = (!empty($_POST['deposit']) && intval($_POST['deposit']) > 0) ? intval($_POST['deposit']) : 0;

            $price_ladder = array();
            $count = count($_POST['ladder_amount']);
            for ($i = $count - 1; $i >= 0; $i--) {
                $amount = intval($_POST['ladder_amount'][$i]);
                if ($amount <= 0) {
                    continue;
                }
                $price = round(floatval($_POST['ladder_price'][$i]), 2);
                if ($price < $deposit) {
                    return $this->showmessage('阶梯价格不能小于保证金金额！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
                if ($price <= 0) {
                    continue;
                }
                $price_ladder[$amount] = array('amount' => $amount, 'price' => $price);
            }

            if (count($price_ladder) < 1) {
                return $this->showmessage('请输入有效的价格阶梯！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $amount_list = array_keys($price_ladder);
            if ($restrict_amount > 0 && max($amount_list) > $restrict_amount) {
                return $this->showmessage('限购数量不能小于价格阶梯中的最大数量！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            ksort($price_ladder);
            $price_ladder = array_values($price_ladder);

            $start_time = !empty($_POST['start_time']) ? RC_Time::local_strtotime($_POST['start_time']) : '';
            $end_time = !empty($_POST['end_time']) ? RC_Time::local_strtotime($_POST['end_time']) : '';

            if ($start_time >= $end_time) {
                return $this->showmessage('请输入一个有效的团购时间！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

            $data = array(
                'act_name' => $act_name,
                'act_desc' => $act_desc,
                'act_type' => GAT_GROUP_BUY,
                'goods_id' => $goods_id,
                'goods_name' => $goods_name,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'ext_info' => serialize(array(
                    'price_ladder' => $price_ladder,
                    'restrict_amount' => $restrict_amount,
                    'gift_integral' => $gift_integral,
                    'deposit' => $deposit,
                )),
            );
            RC_DB::table('goods_activity')->where('store_id', $_SESSION['store_id'])->where('act_id', $group_buy_id)->update($data);

            ecjia_merchant::admin_log($goods_name, 'edit', 'group_buy');
            return $this->showmessage('编辑团购商品成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $edit_url));
        }
    }

    /**
     * 批量操作
     */
    public function batch()
    {
        $this->admin_priv('groupbuy_delete', ecjia::MSGTYPE_JSON);

        if (!empty($_SESSION['ru_id'])) {
            return $this->showmessage(__('入驻商家没有操作权限，请登陆商家后台操作！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $group_buy_id = $_POST['act_id'];
        $group_buy = $this->group_buy_info($group_buy_id);

        if ($group_buy['valid_order'] > 0) {
            return $this->showmessage('该团购活动已经有订单，不能删除！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } else {
            $arr = explode(',', $group_buy_id);
            foreach ($arr as $val) {
                $goods_name = RC_DB::table('goods_activity')->where('store_id', $_SESSION['store_id'])->where('act_id', $val)->pluck('goods_name');
                ecjia_merchant::admin_log('团购商品名称是' . $goods_name, 'batch_remove', 'group_buy');
            }
            RC_DB::table('goods_activity')->where('store_id', $_SESSION['store_id'])->whereIn('act_id', $group_buy_id)->delete();

            return $this->showmessage('批量删除操作成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('groupbuy/merchant/init')));
        }
    }

    /**
     * 删除团购活动
     */
    public function remove()
    {
        $this->admin_priv('groupbuy_delete', ecjia::MSGTYPE_JSON);

        $group_buy_id = intval($_GET['id']);
        $group_buy = $this->group_buy_info($group_buy_id);

        if ($group_buy['valid_order'] > 0) {
            return $this->showmessage('该团购活动已经有订单，不能删除！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } else {
            RC_DB::table('goods_activity')->where('store_id', $_SESSION['store_id'])->where('act_id', $group_buy_id)->delete();

            ecjia_merchant::admin_log($group_buy['act_name'], 'remove', 'group_buy');
            return $this->showmessage('删除成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
        }
    }

    /**
     * 添加/编辑页搜索商品
     */
    public function search_goods()
    {
        $goods_list = array();
        $row = RC_Api::api('goods', 'get_goods_list', array('keyword' => $_POST['keyword'], 'store_id' => $_SESSION['store_id'], 'is_on_sale' => 1));
        if (!is_ecjia_error($row)) {
            if (!empty($row)) {
                foreach ($row as $key => $val) {
                    $goods_list[] = array(
                        'value' => $val['goods_id'],
                        'text' => $val['goods_name'],
                        'data' => $val['shop_price'],
                    );
                }
            }
        }
        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $goods_list));
    }

    /**
     * 获取团购商品列表
     * @access  public
     * @return void
     */
    private function group_buy_list()
    {
        $db_goods = RC_DB::table('goods_activity as g')
            ->leftJoin('store_franchisee as s', RC_DB::raw('s.store_id'), '=', RC_DB::raw('g.store_id'));

        $filter = array();
        $filter['keywords'] = empty($_GET['keywords']) ? '' : trim($_GET['keywords']);
        $filter['type'] = !empty($_GET['type']) ? trim($_GET['type']) : '';

        $where = array();
        if ($filter['keywords']) {
            $db_goods->where(RC_DB::raw('g.act_name'), 'like', '%' . mysql_like_quote($filter['keywords']) . '%');
        }
        $time = RC_Time::gmtime();
        $db_goods->where(RC_DB::raw('g.store_id'), $_SESSION['store_id']);
        $db_goods->where(RC_DB::raw('g.act_type'), GAT_GROUP_BUY);

        $msg_count = $db_goods->select(RC_DB::raw('count(*) as count'),
            RC_DB::raw('SUM(IF(g.is_finished = 0 and g.start_time < ' . $time . ' and g.end_time > ' . $time . ', 1, 0)) as on_going'),
            RC_DB::raw('SUM(IF(g.is_finished = 0 and g.start_time < ' . $time . ' and g.end_time < ' . $time . ', 1, 0)) as uncheck'),
            RC_DB::raw('SUM(IF(g.is_finished = 3, 1, 0)) as successed'),
            RC_DB::raw('SUM(IF(g.is_finished = 4, 1, 0)) as failed')
        )->first();

        $msg_count = array(
            'count' => empty($msg_count['count']) ? 0 : $msg_count['count'],
            'on_going' => empty($msg_count['on_going']) ? 0 : $msg_count['on_going'],
            'uncheck' => empty($msg_count['uncheck']) ? 0 : $msg_count['uncheck'],
            'successed' => empty($msg_count['successed']) ? 0 : $msg_count['successed'],
            'failed' => empty($msg_count['failed']) ? 0 : $msg_count['failed'],
        );

        if ($filter['type'] == 'on_going') {
            $db_goods->where(RC_DB::raw('g.is_finished'), 0)->where(RC_DB::raw('g.start_time'), '<', $time)->where(RC_DB::raw('g.end_time'), '>', $time);
        }
        if ($filter['type'] == 'uncheck') {
            $db_goods->where(RC_DB::raw('g.is_finished'), 0)->where(RC_DB::raw('g.start_time'), '<', $time)->where(RC_DB::raw('g.end_time'), '<', $time);
        }
        if ($filter['type'] == 'successed') {
            $db_goods->where(RC_DB::raw('g.is_finished'), 3);
        }
        if ($filter['type'] == 'failed') {
            $db_goods->where(RC_DB::raw('g.is_finished'), 4);
        }

        $count = $db_goods->count();
        $page = new ecjia_merchant_page($count, 10, 5);
        $res = array();

        $data_content = $db_goods
            ->select(RC_DB::raw('g.*'), RC_DB::raw('s.merchants_name'))
            ->take(10)
            ->skip($page->start_id - 1)
            ->orderBy(RC_DB::raw('g.act_id'), 'desc')
            ->get();

        if (!empty($data_content)) {
            foreach ($data_content as $row) {
                $ext_info = unserialize($row['ext_info']);
                $stat = $this->group_buy_stat($row['act_id'], $ext_info['deposit']);
                if (is_array($ext_info)) {
                    $arr = array_merge($row, $stat, $ext_info);
                } else {
                    $arr = array_merge($row, $stat);
                }
                $price_ladder = $arr['price_ladder'];
                if (!is_array($price_ladder) || empty($price_ladder)) {
                    $price_ladder = array(array('amount' => 0, 'price' => 0));
                } else {
                    foreach ($price_ladder as $key => $amount_price) {
                        $price_ladder[$key]['formated_price'] = price_format($amount_price['price']);
                    }
                }

                $cur_price = $price_ladder[0]['price']; // 初始化
                $cur_amount = $stat['valid_goods']; // 当前数量
                foreach ($price_ladder as $amount_price) {
                    if ($cur_amount >= $amount_price['amount']) {
                        $cur_price = $amount_price['price'];
                    } else {
                        break;
                    }
                }
                $arr['cur_price'] = $cur_price;
                $status = $this->group_buy_status($arr);

                $arr['start_time'] = RC_Time::local_date('Y-m-d H:i:s', $arr['start_time']);
                $arr['end_time'] = RC_Time::local_date('Y-m-d H:i:s', $arr['end_time']);
                $arr['cur_status'] = RC_Lang::get('groupbuy::groupbuy.gbs.' . $status);
                $arr['merchants_name'] = $row['merchants_name'];
                $arr['status'] = $status;
                $res[] = $arr;
            }
        }
        $arr = array('groupbuy' => $res, 'filter' => $filter, 'page' => $page->show(5), 'desc' => $page->page_desc(), 'msg_count' => $msg_count);
        return $arr;
    }

    /**
     * 取得某商品的团购活动
     * @param   int     $goods_id   商品id
     * @return  array
     */
    private function goods_group_buy($goods_id)
    {
        $time = RC_Time::gmtime();
        return RC_DB::table('goods_activity')
            ->where('store_id', $_SESSION['store_id'])
            ->where('goods_id', $goods_id)
            ->where('act_type', GAT_GROUP_BUY)
            ->where('start_time', '<=', $time)
            ->where('end_time', '>=', $time)
            ->first();
    }

    /*
     * 取得某团购活动统计信息 @param int $group_buy_id 团购活动id
     * @param float $deposit 保证金
     *  @return array 统计信息
     *  total_order总订单数
     *  total_goods总商品数
     *  valid_order有效订单数
     *  valid_goods 有效商品数
     */
    private function group_buy_stat($group_buy_id, $deposit)
    {
        $group_buy_id = intval($group_buy_id);
        $group_buy_goods_id = RC_DB::table('goods_activity')->where('store_id', $_SESSION['store_id'])->where('act_id', $group_buy_id)->where('act_type', GAT_GROUP_BUY)->pluck('goods_id');

        /* 取得总订单数和总商品数 */
        $stat = RC_DB::table('order_info as o')->leftJoin('order_goods as g', RC_DB::raw('o.order_id'), '=', RC_DB::raw('g.order_id'))
            ->select(RC_DB::raw('COUNT(*) AS total_order'), RC_DB::raw('SUM(g.goods_number) AS total_goods'))
            ->where(RC_DB::raw('o.extension_code'), 'group_buy')
            ->where(RC_DB::raw('o.extension_id'), $group_buy_id)
            ->where(RC_DB::raw('g.goods_id'), $group_buy_goods_id)
            ->whereRaw("(order_status = '" . OS_CONFIRMED . "' OR order_status = '" . OS_UNCONFIRMED . "')")
            ->first();

        if ($stat['total_order'] == 0) {
            $stat['total_goods'] = 0;
        }

        /* 取得有效订单数和有效商品数 */
        $deposit = floatval($deposit);
        if ($deposit > 0 && $stat['total_order'] > 0) {
            $row = RC_DB::table('order_info as o')->leftJoin('order_goods as g', RC_DB::raw('o.order_id'), '=', RC_DB::raw('g.order_id'))
                ->select(RC_DB::raw('COUNT(*) AS total_order'), RC_DB::raw('SUM(g.goods_number) AS total_goods'))
                ->where(RC_DB::raw('o.extension_code'), 'group_buy')
                ->where(RC_DB::raw('o.extension_id'), $group_buy_id)
                ->where(RC_DB::raw('g.goods_id'), $group_buy_goods_id)
                ->whereRaw("(order_status = '" . OS_CONFIRMED . "' OR order_status = '" . OS_UNCONFIRMED . "')")
                ->whereRaw("(o.money_paid + o.surplus) >= '$deposit'")
                ->first();
            $stat['valid_order'] = $row['total_order'];
            if ($stat['valid_order'] == 0) {
                $stat['valid_goods'] = 0;
            } else {
                $stat['valid_goods'] = $row['total_goods'];
            }

        } else {
            $stat['valid_order'] = $stat['total_order'];
            $stat['valid_goods'] = $stat['total_goods'];
        }
        return $stat;
    }

    /**
     * 获得团购的状态
     *
     * @access public
     * @param
     *            array
     * @return integer
     */
    private function group_buy_status($group_buy)
    {
        $now = RC_Time::gmtime();
        if ($group_buy['is_finished'] == 0) {
            /* 未处理 */
            if ($now < $group_buy['start_time']) {
                $status = GBS_PRE_START;
            } elseif ($now > $group_buy['end_time']) {
                $status = GBS_FINISHED;
            } else {
                if ($group_buy['restrict_amount'] == 0 || $group_buy['valid_goods'] < $group_buy['restrict_amount']) {
                    $status = GBS_UNDER_WAY;
                } else {
                    $status = GBS_FINISHED;
                }
            }
        } elseif ($group_buy['is_finished'] == GBS_SUCCEED) {
            /* 已处理，团购成功 */
            $status = GBS_SUCCEED;
        } elseif ($group_buy['is_finished'] == GBS_FAIL) {
            /* 已处理，团购失败 */
            $status = GBS_FAIL;
        }
        return $status;
    }

    /**
     * 取得团购活动信息
     *
     * @param int $group_buy_id
     *            团购活动id
     * @param int $current_num
     *            本次购买数量（计算当前价时要加上的数量）
     * @return array status 状态：
     */
    private function group_buy_info($group_buy_id, $current_num = 0)
    {
        /* 取得团购活动信息 */
        $group_buy_id = intval($group_buy_id);
        $group_buy = RC_DB::table('goods_activity')
            ->where('store_id', $_SESSION['store_id'])
            ->where('act_id', $group_buy_id)
            ->where('act_type', GAT_GROUP_BUY)
            ->selectRaw('*, act_id as group_buy_id, act_desc as group_buy_desc, start_time as start_date, end_time as end_date')
            ->first();

        /* 如果为空，返回空数组 */
        if (empty($group_buy)) {
            return array();
        }

        $ext_info = unserialize($group_buy['ext_info']);
        $group_buy = array_merge($group_buy, $ext_info);

        /* 格式化时间 */
        $group_buy['formated_start_date'] = RC_Time::local_date('Y-m-d H:i:s', $group_buy['start_time']);
        $group_buy['formated_end_date'] = RC_Time::local_date('Y-m-d H:i:s', $group_buy['end_time']);

        /* 格式化保证金 */
        $group_buy['formated_deposit'] = price_format($group_buy['deposit'], false);

        /* 处理价格阶梯 */
        $price_ladder = $group_buy['price_ladder'];
        if (!is_array($price_ladder) || empty($price_ladder)) {
            $price_ladder = array(
                array('amount' => 0, 'price' => 0),
            );
        } else {
            foreach ($price_ladder as $key => $amount_price) {
                $price_ladder[$key]['formated_price'] = price_format($amount_price['price'], false);
            }
        }
        $group_buy['price_ladder'] = $price_ladder;

        /* 统计信息 */
        $stat = $this->group_buy_stat($group_buy_id, $group_buy['deposit']);
        $group_buy = array_merge($group_buy, $stat);

        /* 计算当前价 */
        $cur_price = $price_ladder[0]['price']; // 初始化
        $cur_amount = $stat['valid_goods'] + $current_num; // 当前数量
        foreach ($price_ladder as $amount_price) {
            if ($cur_amount >= $amount_price['amount']) {
                $cur_price = $amount_price['price'];
            } else {
                break;
            }
        }
        $group_buy['cur_price'] = $cur_price;
        $group_buy['formated_cur_price'] = price_format($cur_price, false);

        /* 最终价 */
        $group_buy['trans_price'] = $group_buy['cur_price'];
        $group_buy['formated_trans_price'] = $group_buy['formated_cur_price'];
        $group_buy['trans_amount'] = $group_buy['valid_goods'];

        /* 状态 */
        $group_buy['status'] = $this->group_buy_status($group_buy);

        if (RC_Lang::get('goods::goods.gbs.' . $group_buy['status'])) {
            $group_buy['status_desc'] = RC_Lang::get('goods::goods.gbs.' . $group_buy['status']);
        }

        $group_buy['start_time'] = $group_buy['formated_start_date'];
        $group_buy['end_time'] = $group_buy['formated_end_date'];

        return $group_buy;
    }
    
	/**
     * 取得团购商品价格
     *
     * @param int $group_buy_id
     *            团购活动id
     * @param int $current_num
     *            本次购买数量（计算当前价时要加上的数量）
     * @return array status 状态：
     */
    private function group_buy_price($group_buy_id, $current_num = 0) {
    	/* 取得团购活动信息 */
    	$group_buy_id = intval($group_buy_id);
    	$group_buy = RC_DB::table('goods_activity')
	    	->where('store_id', $_SESSION['store_id'])
	    	->where('act_id', $group_buy_id)
	    	->where('act_type', GAT_GROUP_BUY)
	    	->select('*')
	    	->first();
    	
    	/* 如果为空，返回空数组 */
    	if (empty($group_buy)) {
    		return 0;
    	}
    	
    	$ext_info = unserialize($group_buy['ext_info']);
    	$group_buy = array_merge($group_buy, $ext_info);
    	
    	/* 处理价格阶梯 */
    	$price_ladder = $group_buy['price_ladder'];
    	if (!is_array($price_ladder) || empty($price_ladder)) {
    		$price_ladder = array(
    			array('amount' => 0, 'price' => 0),
    		);
    	} else {
    		foreach ($price_ladder as $key => $amount_price) {
    			$price_ladder[$key]['formated_price'] = price_format($amount_price['price'], false);
    		}
    	}
    	/* 计算当前价 */
    	$cur_price = $price_ladder[0]['price']; // 初始化
    	$cur_amount = $current_num; // 当前数量
    	foreach ($price_ladder as $amount_price) {
    		if ($cur_amount >= $amount_price['amount']) {
    			$cur_price = $amount_price['price'];
    		} else {
    			break;
    		}
    	}
    	return $cur_price;
    }
}

//end