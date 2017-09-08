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
 * 返回商家某个订单可执行的操作列表，包括权限判断
 * @param   array   $order      订单信息 order_status, shipping_status, pay_status
 * @param   bool    $is_cod     支付方式是否货到付款
 * @return  array   可执行的操作  confirm, pay, unpay, prepare, ship, unship, receive, cancel, invalid, return, drop
 * 格式 array('confirm' => true, 'pay' => true)
 */
function merchant_operable_list($order) {
    /* 取得订单状态、发货状态、付款状态 */
    $os = $order['order_status'];
    $ss = $order['shipping_status'];
    $ps = $order['pay_status'];
    /* 取得订单操作权限 */
    $actions = $_SESSION['action_list'];
    if ($actions == 'all') {
        $priv_list = array('os' => true, 'ss' => true, 'ps' => true, 'edit' => true);
    } else {
        $actions = ',' . $actions . ',';
        $priv_list = array('os' => strpos($actions, ',order_os_edit,') !== false, 'ss' => strpos($actions, ',order_ss_edit,') !== false, 'ps' => strpos($actions, ',order_ps_edit,') !== false, 'edit' => strpos($actions, ',order_edit,') !== false);
    }
    /* 取得订单支付方式是否货到付款 */
//     $payment_method = RC_Loader::load_app_class('payment_method', 'payment');
    $payment = with(new Ecjia\App\Payment\PaymentPlugin)->getPluginDataById($order['pay_id']);
//     if (!empty($payment_method)) {
//         $payment = $payment_method->payment_info($order['pay_id']);
//     }
    $is_cod = $payment['is_cod'] == 1;
    /* 根据状态返回可执行操作 */
    $list = array();
    if (OS_UNCONFIRMED == $os) {
        /* 状态：未确认 => 未付款、未发货 */
        if ($priv_list['os']) {
            $list['confirm'] = true;
            // 确认
            $list['invalid'] = true;
            // 无效
            $list['cancel'] = true;
            // 取消
            if ($is_cod) {
                /* 货到付款 */
                if ($priv_list['ss']) {
                    $list['prepare'] = true;
                    // 配货
                    $list['split'] = true;
                    // 分单
                }
            } else {
                /* 不是货到付款 */
                if ($priv_list['ps']) {
                    $list['pay'] = false;
                    // 付款
                }
            }
        }
    } elseif (OS_CONFIRMED == $os || OS_SPLITED == $os || OS_SPLITING_PART == $os) {
        /* 状态：已确认 */
        if (PS_UNPAYED == $ps) {
            /* 状态：已确认、未付款 */
            if (SS_UNSHIPPED == $ss || SS_PREPARING == $ss) {
                /* 状态：已确认、未付款、未发货（或配货中） */
                if ($priv_list['os']) {
                    $list['cancel'] = true;
                    // 取消
                    $list['invalid'] = true;
                    // 无效
                }
                if ($is_cod) {
                    /* 货到付款 */
                    if ($priv_list['ss']) {
                        if (SS_UNSHIPPED == $ss) {
                            $list['prepare'] = true;
                            // 配货
                        }
                        $list['split'] = true;
                        // 分单
                    }
                } else {
                    /* 不是货到付款 */
                    if ($priv_list['ps']) {
                        $list['pay'] = false;
                        // 付款
                    }
                }
            } elseif (SS_SHIPPED_ING == $ss || SS_SHIPPED_PART == $ss) {
                /* 状态：已确认、未付款、发货中 */
                // 部分分单
                if (OS_SPLITING_PART == $os) {
                    $list['split'] = true;
                    // 分单
                }
                $list['to_delivery'] = true;
                // 去发货
            } else {
                /* 状态：已确认、未付款、已发货或已收货 => 货到付款 */
                if ($priv_list['ps']) {
                    $list['pay'] = false;
                    // 付款
                }
                if ($priv_list['ss']) {
                    if (SS_SHIPPED == $ss) {
                        $list['receive'] = true;
                        // 收货确认
                    }
                    if(SS_RECEIVED != $ss) {
                        $list['unship'] = true;
                        //已收货后不能设未发货
                    }
//                     $list['unship'] = true;
                    // 设为未发货
                    if ($priv_list['os']) {
                        $list['return'] = true;
                        // 退货
                    }
                }
            }
        } else {
            /* 状态：已确认、已付款和付款中 */
            if (SS_UNSHIPPED == $ss || SS_PREPARING == $ss) {
                /* 状态：已确认、已付款和付款中、未发货（配货中） => 不是货到付款 */
                if ($priv_list['ss']) {
                    if (SS_UNSHIPPED == $ss) {
                        $list['prepare'] = true;
                        // 配货
                    }
                    $list['split'] = true;
                    // 分单
                }
                if ($priv_list['ps']) {
                    $list['unpay'] = false;
                    // 设为未付款
                    if ($priv_list['os']) {
                        $list['cancel'] = true;
                        // 取消
                    }
                }
            } elseif (SS_SHIPPED_ING == $ss || SS_SHIPPED_PART == $ss) {
                /* 状态：已确认、未付款、发货中 */
                // 部分分单
                if (OS_SPLITING_PART == $os) {
                    $list['split'] = true;
                    // 分单
                }
                $list['to_delivery'] = true;
                // 去发货
            } else {
                /* 状态：已确认、已付款和付款中、已发货或已收货 */
                if ($priv_list['ss']) {
                    if (SS_SHIPPED == $ss) {
                        $list['receive'] = true;
                        // 收货确认
                    }
                    if (!$is_cod) {
                        if(SS_RECEIVED != $ss) {
                            $list['unship'] = true;
                            //已收货后不能设未发货
                        }
                        // 设为未发货
                    }
                }
                if ($priv_list['ps'] && $is_cod) {
                    $list['unpay'] = false;
                    // 设为未付款
                }
                if ($priv_list['os'] && $priv_list['ss'] && $priv_list['ps']) {
                    $list['return'] = true;
                    // 退货（包括退款）
                }
            }
        }
    } elseif (OS_CANCELED == $os) {
        /* 状态：取消 */
        if ($priv_list['os']) {
            $list['confirm'] = true;
        }
        if ($priv_list['edit']) {
            $list['remove'] = true;
        }
    } elseif (OS_INVALID == $os) {
        /* 状态：无效 无效订单只能删除*/
        if ($priv_list['edit']) {
            $list['remove'] = true;
        }
    } elseif (OS_RETURNED == $os) {
        /* 状态：退货 */
        if ($priv_list['os']) {
            $list['confirm'] = true;
        }
    }
    /* 修正发货操作 */
    if (!empty($list['split'])) {
        /* 如果是团购活动且未处理成功，不能发货 */
        if ($order['extension_code'] == 'group_buy') {
            unset($list['split']);
            unset($list['to_delivery']);
            // 			TODO:团购活动暂时注释，直接不给予发货等操作
            // 			RC_Loader::load_app_func('admin_goods', 'goods');
            // 			$group_buy = group_buy_info(intval($order['extension_id']));
            // 			if ($group_buy['status'] != GBS_SUCCEED) {
            // 				unset($list['split']);
            // 				unset($list['to_delivery']);
            // 			}
        }
        /* 如果部分发货 不允许 取消 订单 */
        if (order_deliveryed($order['order_id'])) {
            $list['return'] = true;
            // 退货（包括退款）
            unset($list['cancel']);
            // 取消
        }
    }
    $list['unpay'] = $list['pay'] = false;
    /* 售后 */
    $list['after_service'] = true;
    return $list;
}

/**
 *  获取商家退货单列表信息
 * @access  public
 * @param
 * @return void
 */
function get_merchant_back_list() {
	$args = $_GET;
	/* 过滤信息 */
	$filter['delivery_sn'] = empty($args['delivery_sn']) ? '' : trim($args['delivery_sn']);
	$filter['order_sn'] = empty($args['order_sn']) ? '' : trim($args['order_sn']);
	$filter['order_id'] = empty($args['order_id']) ? 0 : intval($args['order_id']);
	$filter['consignee'] = empty($args['consignee']) ? '' : trim($args['consignee']);
	$filter['sort_by'] = empty($args['sort_by']) ? 'update_time' : trim($args['sort_by']);
	$filter['sort_order'] = empty($args['sort_order']) ? 'DESC' : trim($args['sort_order']);
	$filter['keywords'] = empty($args['keywords']) ? '' : trim($args['keywords']);
	$db_back_order = RC_DB::table('back_order as bo')->leftJoin('order_info as oi', RC_DB::raw('bo.order_id'), '=', RC_DB::raw('oi.order_id'));
	isset($_SESSION['store_id']) ? $db_back_order->where(RC_DB::raw('bo.store_id'), $_SESSION['store_id']) : '';
	$where = array();
	if ($filter['keywords']) {
		$db_back_order->whereRaw('(bo.order_sn like "%' . mysql_like_quote($filter['keywords']) . '%" or bo.consignee like "%' . mysql_like_quote($filter['keywords']) . '%")');
	}
	if ($filter['order_sn']) {
		$db_back_order->where(RC_DB::raw('bo.order_sn'), 'like', '%' . mysql_like_quote($filter['order_sn']) . '%');
	}
	if ($filter['consignee']) {
		$db_back_order->where(RC_DB::raw('bo.consignee'), 'like', '%' . mysql_like_quote($filter['consignee']) . '%');
	}
	if ($filter['delivery_sn']) {
		$db_back_order->where(RC_DB::raw('bo.delivery_sn'), 'like', '%' . mysql_like_quote($filter['delivery_sn']) . '%');
	}
	/* 记录总数 */
	$count = RC_DB::table('back_order as bo')->leftJoin('order_info as oi', RC_DB::raw('bo.order_id'), '=', RC_DB::raw('oi.order_id'))->count();
	$filter['record_count'] = $count;
	//加载分页类
	RC_Loader::load_sys_class('ecjia_page', false);
	//实例化分页
	$page = new ecjia_merchant_page($count, 15, 6);
	/* 查询 */
	$row = $db_back_order->selectRaw('bo.back_id, bo.order_id, bo.delivery_sn, bo.order_sn, bo.order_id, bo.add_time, bo.action_user, bo.consignee, bo.country,bo.province, bo.city, bo.district, bo.tel, bo.status, bo.update_time, bo.email, bo.return_time')->orderBy($filter['sort_by'], $filter['sort_order'])->take(15)->skip($page->start_id - 1)->groupBy('back_id')->get();
	if (!empty($row) && is_array($row)) {
		/* 格式化数据 */
		foreach ($row as $key => $value) {
			$row[$key]['return_time'] = RC_Time::local_date(ecjia::config('time_format'), $value['return_time']);
			$row[$key]['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $value['add_time']);
			$row[$key]['update_time'] = RC_Time::local_date(ecjia::config('time_format'), $value['update_time']);
			if ($value['status'] == 1) {
				$row[$key]['status_name'] = RC_Lang::get('orders::order.delivery_status.1');
			} else {
				$row[$key]['status_name'] = RC_Lang::get('orders::order.delivery_status.0');
			}
		}
	}
	return array('back' => $row, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc());
}

/**
 *  获取商家发货单列表信息
 *
 * @access  public
 * @param
 *
 * @return void
 */
function get_merchant_delivery_list() {
	$db_delivery_order = RC_DB::table('delivery_order as do')->leftJoin('order_info as oi', RC_DB::raw('do.order_id'), '=', RC_DB::raw('oi.order_id'));
	isset($_SESSION['store_id']) ? $db_delivery_order->where(RC_DB::raw('do.store_id'), $_SESSION['store_id']) : '';
	$args = $_GET;
	/* 过滤信息 */
	$filter['delivery_sn'] = empty($args['delivery_sn']) ? '' : trim($args['delivery_sn']);
	$filter['order_sn'] = empty($args['order_sn']) ? '' : trim($args['order_sn']);
	$filter['order_id'] = empty($args['order_id']) ? 0 : intval($args['order_id']);
	$filter['consignee'] = empty($args['consignee']) ? '' : trim($args['consignee']);
	$filter['sort_by'] = empty($args['sort_by']) ? 'update_time' : trim($args['sort_by']);
	$filter['sort_order'] = empty($args['sort_order']) ? 'DESC' : trim($args['sort_order']);
	$filter['keywords'] = empty($args['keywords']) ? '' : trim($args['keywords']);
	if ($filter['order_sn']) {
		$db_delivery_order->where(RC_DB::raw('do.order_sn'), 'like', '%' . mysql_like_quote($filter['order_sn']) . '%');
	}
	if ($filter['consignee']) {
		$db_delivery_order->where(RC_DB::raw('do.consignee'), 'like', '%' . mysql_like_quote($filter['consignee']) . '%');
	}
	if ($filter['delivery_sn']) {
		$db_delivery_order->where(RC_DB::raw('do.delivery_sn'), 'like', '%' . mysql_like_quote($filter['delivery_sn']) . '%');
	}
	if ($filter['keywords']) {
		$db_delivery_order->whereRaw('(do.order_sn like "%' . mysql_like_quote($filter['keywords']) . '%" or do.consignee like "%' . mysql_like_quote($filter['keywords']) . '%")');
	}
	/* 记录总数 */
	$type_count = $db_delivery_order->select(RC_DB::raw('count(*) as count_goods_num'), RC_DB::raw('SUM(IF(status = 0, 1, 0)) as already_shipped'), RC_DB::raw('SUM(IF(status = 1, 1, 0)) as op_return'), RC_DB::raw('SUM(IF(status = 2, 1, 0)) as normal'))->first();
	if (empty($type_count['already_shipped'])) {
		$type_count['already_shipped'] = 0;
	}
	if (empty($type_count['op_return'])) {
		$type_count['op_return'] = 0;
	}
	if (empty($type_count['normal'])) {
		$type_count['normal'] = 0;
	}
	if (empty($args['type'])) {
		$delivery_status = 0;
	} else {
		$delivery_status = $args['type'];
	}
	if ($delivery_status == 0) {
		$count = $type_count['already_shipped'];
		$filter['record_count'] = $count;
	} elseif ($delivery_status == 1) {
		$count = $type_count['op_return'];
		$filter['record_count'] = $count;
	} elseif ($delivery_status == 2) {
		$count = $type_count['normal'];
		$filter['record_count'] = $count;
	}
	/* 查询 */
	$status = $_GET['type'];
	if (empty($status)) {
		$status = 0;
	}
	$page = new ecjia_merchant_page($count, 15, 3);
	$row = $db_delivery_order->selectRaw('delivery_id, do.order_id, delivery_sn, do.order_sn, do.add_time, action_user, do.consignee, do.country, do.province, do.city, do.district, do.tel, do.status, do.update_time, do.email, do.suppliers_id')->orderBy($filter['sort_by'], $filter['sort_order'])->where(RC_DB::Raw('do.status'), $status)->take(15)->skip($page->start_id - 1)->get();
	/* 格式化数据 */
	if (!empty($row)) {
		foreach ($row as $key => $value) {
			$row[$key]['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $value['add_time']);
			$row[$key]['update_time'] = RC_Time::local_date(ecjia::config('time_format'), $value['update_time']);
			if ($value['status'] == 1) {
				$row[$key]['status_name'] = RC_Lang::get('orders::order.delivery_status.1');
			} elseif ($value['status'] == 2) {
				$row[$key]['status_name'] = RC_Lang::get('orders::order.delivery_status.2');
			} else {
				$row[$key]['status_name'] = RC_Lang::get('orders::order.delivery_status.0');
			}
		}
	}
	return array('delivery' => $row, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc(), 'type_count' => $type_count);
}

/**
 * 获取当天订单不同状态数量
 * @return array
 */
function get_merchant_order_count() {
	$keywords = trim($_GET['keywords']);
	$db	= RC_Loader::load_app_model('order_info_viewmodel', 'orders');
	$db->view = array(
		'order_goods' => array(
			'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
			'alias' => 'g',
			'on' 	=> 'oi.order_id = g.order_id'
		)
	);
	
	$t = RC_Time::gmtime();
	$start_time = RC_Time::local_mktime(0, 0, 0, RC_Time::local_date("m", $t), RC_Time::local_date("d", $t), RC_Time::local_date("Y", $t));  //当天开始时间
	$end_time = RC_Time::local_mktime(23, 59, 59, RC_Time::local_date("m", $t), RC_Time::local_date("d", $t), RC_Time::local_date("Y", $t)); //当天结束时间

	$array = array('oi.store_id'  => $_SESSION['store_id'], 'oi.add_time' => array('gt'=> $start_time, 'lt' => $t), 'oi.is_delete' => 0);
	if (!empty($keywords)) {
		$array[] = "(oi.order_sn like '%".mysql_like_quote($keywords)."%' or oi.consignee like '%".mysql_like_quote($keywords)."%')"; 
	}
	$order_all = $db->field('oi.order_id')
		->where($array)
		->group('oi.order_id')
		->select();
	$today['all'] = count($order_all);
	
	$order_query = RC_Loader::load_app_class('merchant_order_query', 'orders');
	$await_pay = $db->field('oi.order_id')
		->where(array_merge($order_query->order_await_pay('oi.'), $array))
		->group('oi.order_id')
		->select();
	$today['await_pay'] = count($await_pay);
	
	$await_confirm = $db->field('oi.order_id')
		->where(array_merge($order_query->order_unconfirmed('oi.'), $array))
		->group('oi.order_id')
		->select();
	$today['await_confirm'] = count($await_confirm);
	
	$payed = $db->field('oi.order_id')
		->where(array_merge($order_query->order_payed('oi.'), $array))
		->group('oi.order_id')
		->select();
	$today['payed'] = count($payed);
	
	$await_ship = $db->field('oi.order_id')
		->where(array_merge($order_query->order_await_ship('oi.'), $array))
		->group('oi.order_id')
		->select();
	$today['await_ship'] = count($await_ship);
	
// 	$order_shipped = $db->field('oi.order_id')
// 		->where(array_merge($order_query->order_shipped('oi.'), $array))
// 		->group('oi.order_id')
// 		->select();
// 	$today['order_shipped'] = count($order_shipped);
	
	$order_finished = $db->field('oi.order_id')
		->where(array_merge($order_query->order_finished('oi.'), $array))
		->group('oi.order_id')
		->select();
	$today['order_finished'] = count($order_finished);
	
	return $today;
}

//end