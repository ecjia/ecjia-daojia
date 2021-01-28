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
 * 获取红包类型列表 --bonus.func
 * @access  public
 * @return void
 */
function get_type_list() {
	/* 查询条件 */
	$filter['sort_by']    			= !empty($_GET['sort_by']) 				? trim($_GET['sort_by']) 			: 'type_id';
	$filter['sort_order'] 			= !empty($_GET['sort_order']) 			? trim($_GET['sort_order']) 		: 'DESC';
	$filter['merchant_keywords']	= !empty($_GET['merchant_keywords']) 	? trim($_GET['merchant_keywords']) 	: '';
	$filter['type_keywords'] 		= !empty($_GET['type_keywords']) 		? trim($_GET['type_keywords']) 		: '';
	
	$db_bonus_type = RC_DB::table('bonus_type as bt')->leftJoin('store_franchisee as s', RC_DB::raw('bt.store_id'), '=', RC_DB::raw('s.store_id'));
	
	/* 获得所有红包类型的发放数量 */
	$data = RC_DB::table('user_bonus')
		->select('bonus_type_id', RC_DB::raw('COUNT(*) AS sent_count, SUM(IF(used_time > 0, 1, 0)) as used_count'))
		->groupby('bonus_type_id')
		->get();
	
	$sent_arr = array();
	$used_arr = array();
	if (!empty($data)) {
		foreach ($data as $row) {
			$sent_arr[$row['bonus_type_id']] = $row['sent_count'];
			$used_arr[$row['bonus_type_id']] = $row['used_count'];
		}
	}
	$filter['send_type'] = isset($_GET['send_type']) ? intval($_GET['send_type']) : '';

	if ($filter['send_type'] !== '') {
		$db_bonus_type->where('send_type', $filter['send_type']);
	}
	
	if (!empty($filter['merchant_keywords'])) {
		$db_bonus_type->where(RC_DB::raw('s.merchants_name'), 'like', '%'.mysql_like_quote($filter['merchant_keywords']).'%');
	}
	
	if (!empty($filter['type_keywords'])) {
		$db_bonus_type->where(RC_DB::raw('bt.type_name'), 'like', '%'.mysql_like_quote($filter['type_keywords']).'%');
	}
	
	$filter_count = $db_bonus_type
	->select(RC_DB::raw('count(*) as count'), RC_DB::raw('SUM(bt.store_id = 0) as platform'), RC_DB::raw('SUM(IF(s.manage_mode = "self", 1, 0)) as self'), RC_DB::raw('SUM(IF(s.manage_mode = "join", 1, 0)) as merchant'))
		->first();
	
	$filter['type'] = isset($_GET['type']) ? $_GET['type'] : '';
	if (isset($filter['type']) && $filter['type'] == 'self') {
		$db_bonus_type->where(RC_DB::raw('s.manage_mode'), 'self');
	} else if (isset($filter['type']) && $filter['type'] == 'merchant') {
	    $db_bonus_type->where(RC_DB::raw('s.manage_mode'), 'join');
	} else {
	    $db_bonus_type->where(RC_DB::raw('bt.store_id'), 0);
	}
	
	$count = $db_bonus_type->count();
	$page = new ecjia_page($count, 10, 6);
	
	$res = $db_bonus_type
		->select(RC_DB::raw('bt.*, s.merchants_name'))
		->orderby($filter['sort_by'], $filter['sort_order'])
		->take(10)
		->skip($page->start_id-1)
		->get();

    $send_by_arr = array(
        SEND_BY_USER 		=> __('按用户发放', 'bonus'),
        SEND_BY_GOODS 		=> __('按商品发放', 'bonus'),
        SEND_BY_ORDER 		=> __('按订单金额发放', 'bonus'),
        SEND_BY_PRINT 		=> __('线下发放的红包', 'bonus'),
        SEND_BY_REGISTER 	=> __('注册送红包', 'bonus'),
        SEND_COUPON			=> __('优惠券', 'bonus'),
    );
	$arr = array();
	if (!empty($res)) {
		foreach ($res as $row) {
			$row['send_by']    = $send_by_arr[$row['send_type']];
			$row['send_count'] = isset($sent_arr[$row['type_id']]) ? $sent_arr[$row['type_id']] : 0;
			$row['use_count']  = isset($used_arr[$row['type_id']]) ? $used_arr[$row['type_id']] : 0;
			if (empty($row['store_id'])) {
				$row['user_bonus_type'] = 2; //全场通用
			} else {
				$row['user_bonus_type'] = $row['merchants_name']; //商家名称
			}
			$arr[] = $row;
		}
	}
	return array('item' => $arr, 'filter' => $filter, 'page' => $page->show(5), 'desc' => $page->page_desc(), 'count' => $filter_count);
}

/**
 * 查询红包类型的商品列表 --bonus.func
 * @access public
 * @param integer $type_id        	
 * @return array
 */
function get_bonus_goods($type_id) {
	return RC_DB::table('goods')->select('goods_id', 'goods_name')->where('bonus_type_id', $type_id)->get();
}

/**
 * 获取用户红包列表 --bonus.func
 * @access public
 * @param
 * $page_param
 * @return void
 */
function get_bonus_list() {
	/* 查询条件 */
	$filter ['sort_by']    = empty($_REQUEST['sort_by']) 	? 'user_bonus.bonus_id'	: trim($_REQUEST['sort_by']);
	$filter ['sort_order'] = empty($_REQUEST['sort_order'])	? 'DESC'				: trim($_REQUEST['sort_order']);
	$filter ['bonus_type'] = empty($_REQUEST['bonus_type'])	? 0 					: intval($_REQUEST['bonus_type']);
	
	$db_user_bonus = RC_DB::table('user_bonus');
	if (!empty($filter['bonus_type'])) {
		$db_user_bonus->where('user_bonus.bonus_type_id', '=', $filter['bonus_type']);
	}
	
	$count = $db_user_bonus->count();
	$page = new ecjia_page ($count, 15, 6);

	$row = $db_user_bonus
		->leftJoin('bonus_type', 'bonus_type.type_id', '=', 'user_bonus.bonus_type_id')
		->leftJoin('users', 'users.user_id', '=', 'user_bonus.user_id')
		->leftJoin('order_info', 'order_info.order_id', '=', 'user_bonus.order_id')
		->select('user_bonus.*', 'users.user_name', 'users.email', 'order_info.order_sn', 'bonus_type.type_name')
		->orderby($filter['sort_by'], $filter['sort_order'])
		->take(15)
		->skip($page->start_id-1)
		->get();

	$mail_status_arr = array(
        BONUS_NOT_MAIL 					=> '未发',
        BONUS_INSERT_MAILLIST_FAIL 		=> '插入邮件发送队列失败',
        BONUS_INSERT_MAILLIST_SUCCEED 	=> '插入邮件发送队列成功',
        BONUS_MAIL_FAIL 				=> '发送邮件通知失败',
        BONUS_MAIL_SUCCEED 				=> '发送邮件通知成功',
    );
	if (!empty($row)) {
		foreach($row as $key => $val) {
			$row[$key]['used_time'] = $val['used_time'] == 0 ? __('未使用', 'bonus') : RC_Time::local_date(ecjia::config('date_format'), $val['used_time']);
			$row[$key]['emailed']   = $mail_status_arr[$row[$key]['emailed']];
			$row[$key]['merchants_name'] = RC_DB::table('bonus_type as b')->leftJoin('store_franchisee as s', RC_DB::raw('b.store_id'), '=', RC_DB::raw('s.store_id'))->where(RC_DB::raw('b.type_id'), $val['bonus_type_id'])->value(RC_DB::raw('s.merchants_name'));
		}
	}
	$arr = array('item' => $row, 'filter' => $filter, 'page' => $page->show ( 15 ), 'desc' => $page->page_desc());
	return $arr;
}

/**
 * 取得红包类型信息 --bonus.func
 * @param int $bonus_type_id
 * 红包类型id
 * @return array
 */
function bonus_type_info($bonus_type_id) {
	return RC_DB::table('bonus_type')->where('type_id', $bonus_type_id)->first();
}

/**
 * 插入邮件发送队列 --bonus.func
 * @param unknown $username
 * @param unknown $email
 * @param unknown $subject
 * @param unknown $content
 * @param unknown $is_html
 * @return boolean
 */
function add_to_maillist($username, $email, $subject, $content, $is_html) {
	$time = time ();
	$content = addslashes ( $content );
	$template_id = RC_DB::table('mail_templates')->where('template_code', 'send_bonus')->value('template_id');

	$data = array (
		'email' 		=> $email,
		'template_id' 	=> $template_id,
		'email_content' => $content,
		'pri' 			=> 1,
		'last_send' 	=> $time 
	);
	RC_DB::table('email_sendlist')->insert($data);
	return true;
}

/********从order.func移出的有关红包的方法---start************/
/**
 * 取得用户当前可用红包
 * @param   int	 $user_id		用户id
 * @param   float   $goods_amount   订单商品金额
 * @return  array   红包数组
 */
function user_bonus($user_id, $goods_amount = 0, $cart_id = array(), $store_id = 0) {
	$db_cart = RC_DB::table('cart as c')->leftJoin('goods as g', RC_DB::raw('c.goods_id'), '=', RC_DB::raw('g.goods_id'));
	
    if (!empty($cart_id)) {
        $db_cart->where(RC_DB::raw('c.rec_id'), $cart_id);
    }
    $db_cart->where(RC_DB::raw('c.user_id'), $_SESSION['user_id'])->where('rec_type', \Ecjia\App\Cart\Enums\CartEnum::CART_GENERAL_GOODS);
	$today = RC_Time::gmtime();
	
	$dbview = RC_DB::table('user_bonus as ub')
		->leftJoin('bonus_type as bt', RC_DB::raw('ub.bonus_type_id'), '=', RC_DB::raw('bt.type_id'));
		if (!empty($store_id)) {
			$dbview->whereIn(RC_DB::raw('bt.store_id'), array($store_id, 0));
		}
		$row = $dbview->select(RC_DB::raw('ub.bonus_sn, bt.type_id, bt.store_id, bt.type_name, bt.type_money, ub.bonus_id, bt.usebonus_type,bt.min_goods_amount,bt.use_start_date,bt.use_end_date'))
		->where(RC_DB::raw('bt.use_start_date'), '<=', $today)
		->where(RC_DB::raw('bt.use_end_date'), '>=', $today)
		->where(RC_DB::raw('bt.min_goods_amount'), '<=', $goods_amount)
		->where(RC_DB::raw('ub.user_id'), '!=', 0)
		->where(RC_DB::raw('ub.user_id'), $user_id)
		->where(RC_DB::raw('ub.order_id'), 0)
		->whereRaw('(ub.order_sn is null or ub.order_sn ="" )')
		->get();
	return $row;
}

/**
* 取得红包信息
* @param   int	 $bonus_id   红包id
* @param   string  $bonus_sn   红包序列号
* @param   array   红包信息
*/
function bonus_info($bonus_id, $bonus_sn = '') {
	$db_view = RC_DB::table('user_bonus')->leftJoin('bonus_type', 'bonus_type.type_id', '=', 'user_bonus.bonus_type_id');
	$db_view->select('user_bonus.*', 'bonus_type.*');
	
	if ($bonus_id > 0) {
		return $db_view->where('user_bonus.bonus_id', $bonus_id)->first();
	} else {
		return $db_view->where('user_bonus.bonus_sn', $bonus_sn)->first();
	}
}

/**
* 检查红包是否已使用
* @param   int $bonus_id   红包id
* @return  bool
*/
function bonus_used($bonus_id) {
	$order_id = RC_DB::table('user_bonus')->where('bonus_id', $bonus_id)->value('order_id');
	return $order_id > 0;
}

/**
* 设置红包为已使用
* @param   int	 $bonus_id   红包id
* @param   int	 $order_id   订单id
* @return  bool
*/
function use_bonus($bonus_id, $order_id) {
	$data = array(
		'order_id'	=> $order_id,
		'used_time' => RC_Time::gmtime()
	);
	return RC_DB::table('user_bonus')->where('bonus_id', $bonus_id)->update($data);
}

/**
* 设置红包为未使用
* @param   int	 $bonus_id   红包id
* @param   int	 $order_id   订单id
* @return  bool
*/
function unuse_bonus($bonus_id) {
	$data = array('order_id' => 0, 'used_time'	=> 0, 'order_sn' => '');
	return RC_DB::table('user_bonus')->where('bonus_id', $bonus_id)->update($data);
}

/**
 * 取得当前用户应该得到的红包总额
 */
function get_total_bonus() {
	$day		= RC_Time::local_getdate();
	$today		= RC_Time::local_mktime(23, 59, 59, $day['mon'], $day['mday'], $day['year']);

	if ($_SESSION['user_id']) {
		$total_money = RC_DB::table('cart as c')
			->leftJoin('goods as g', RC_DB::raw('c.goods_id'), '=', RC_DB::raw('g.goods_id'))
			->leftJoin('bonus_type as t', RC_DB::raw('g.bonus_type_id'), '=', RC_DB::raw('t.type_id'))
			->where(RC_DB::raw('c.user_id'), $_SESSION['user_id'])
			->where(RC_DB::raw('c.is_gift'), 0)
			->where(RC_DB::raw('t.send_type'), SEND_BY_GOODS)
			->where(RC_DB::raw('t.send_start_date'), '<=', $today)
			->where(RC_DB::raw('t.send_end_date'), '>=', $today)
			->where(RC_DB::raw('c.rec_type'), \Ecjia\App\Cart\Enums\CartEnum::CART_GENERAL_GOODS)
			->SUM(RC_DB::raw('c.goods_number * t.type_money'));
		$goods_total = floatval($total_money);

	    /* 取得购物车中非赠品总金额 */
	    $goods_amount = RC_DB::table('cart')
	        ->where('user_id', $_SESSION['user_id'])
	        ->where('is_gift', 0)
	        ->where('rec_type', \Ecjia\App\Cart\Enums\CartEnum::CART_GENERAL_GOODS)
	        ->SUM(RC_DB::raw('goods_price * goods_number'));
		$amount = floatval($goods_amount);

	} else {
		$total_money = RC_DB::table('cart as c')
			->leftJoin('goods as g', RC_DB::raw('c.goods_id'), '=', RC_DB::raw('g.goods_id'))
			->leftJoin('bonus_type as t', RC_DB::raw('g.bonus_type_id'), '=', RC_DB::raw('t.type_id'))
			->where(RC_DB::raw('c.session_id'), SESS_ID)
			->where(RC_DB::raw('c.is_gift'), 0)
			->where(RC_DB::raw('t.send_type'), SEND_BY_GOODS)
			->where(RC_DB::raw('t.send_start_date'), '<=', $today)
			->where(RC_DB::raw('t.send_end_date'), '>=', $today)
			->where(RC_DB::raw('c.rec_type'), \Ecjia\App\Cart\Enums\CartEnum::CART_GENERAL_GOODS)
			->SUM(RC_DB::raw('c.goods_number * t.type_money'));
		$goods_total = floatval($total_money);

	    /* 取得购物车中非赠品总金额 */
		$goods_amount = RC_DB::table('cart')
	        ->where('session_id', SESS_ID)
	        ->where('is_gift', 0)
	        ->where('rec_type', \Ecjia\App\Cart\Enums\CartEnum::CART_GENERAL_GOODS)
	        ->SUM(RC_DB::raw('goods_price * goods_number'));
		$amount = floatval($goods_amount);
	}
	/* 按订单发的红包 */
	$order_amount = RC_DB::table('bonus_type')
		->select(RC_DB::raw('FLOOR('.$amount.' / min_amount) * type_money'))
		->whereRaw('send_type = "'. SEND_BY_ORDER . '" AND send_start_date <= '.$today.'  AND send_end_date >= '.$today.' AND min_amount > 0')
		->first();
	$order_total = floatval($order_amount);

	return $goods_total + $order_total;
}

/**
* 处理红包（下订单时设为使用，取消（无效，退货）订单时设为未使用
* @param   int	 $bonus_id   红包编号
* @param   int	 $order_id   订单号
* @param   int	 $is_used	是否使用了
*/
function change_user_bonus($bonus_id, $order_id, $is_used = true) {
	if ($is_used) {
		$data = array(
			'used_time'	=> RC_Time::gmtime(),
			'order_id'	=> $order_id,
		);
	} else {
		$data = array(
			'used_time'	=> 0,
			'order_id'	=> 0,
            'order_sn'  => ''
		);
	}
	RC_DB::table('user_bonus')->where('bonus_id', $bonus_id)->update($data);
}
/********从order.func移出的有关红包的方法---end************/

/********从system.func移出的有关红包的方法---start************/
/**
 * 取得红包类型数组（用于生成下拉列表）
 *
 * @return  array       分类数组 bonus_typeid => bonus_type_name
 */
function get_bonus_type() {
	$data = RC_DB::table('bonus_type')->select('type_id', 'type_name', 'type_money')->where('send_type', 3)->get();
	
	$bonus = array();
	if (!empty($data)) {
		foreach ($data as $row) {
			$bonus[$row['type_id']] = $row['type_name'].' [' .sprintf(ecjia::config('currency_format'), $row['type_money']).']';
		}
	}
	return $bonus;
}
/********从system.func移出的有关红包的方法---start************/

// end