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

class bonus {	
    /**
     * 取得用户等级数组,按用户级别排序
     * @param   bool      $is_special      是否只显示特殊会员组
     * @return  array     rank_id=>rank_name
     */
    public static function get_rank_list($is_special = false) {
    	$db_user_rank = RC_DB::table('user_rank');
    	$db_user_rank->select('rank_id', 'rank_name', 'min_points');
    
    	if ($is_special) {
    		$db_user_rank->where('special_rank', 1);
    	}
    	$data = $db_user_rank->orderby('min_points', 'asc')->get();
    
    	$rank_list = array();
    	if (!empty($data)) {
    		foreach ($data as $row) {
    			$rank_list[$row['rank_id']] = $row['rank_name'];
    		}
    	}
    	return $rank_list;
    }

    /**
     * 查询红包类型的商品列表 --bonus.func
     * @access public
     * @param integer $type_id
     * @return array
     */
    public static function get_bonus_goods($type_id) {
    	return RC_DB::table('goods')->select('goods_id', 'goods_name')->where('bonus_type_id', $type_id)->get();
    }
    
    /**
     * 取得红包类型数组（用于生成下拉列表）
     * @return  array       分类数组 bonus_typeid => bonus_type_name
     */
    public static function get_bonus_type() {
    	$db = RC_DB::table('bonus_type');
    	$bonus = array();
    
    	if (!empty($_SESSION['store_id']) && $_SESSION['store_id'] > 0) {
    		$db->where(RC_DB::raw('store_id'), $_SESSION['store_id']);
    	}
    	$data = $db->selectRaw('type_id, type_name, type_money')
    			->where(RC_DB::raw('send_type'), 3)
    			->get();
    	if (!empty($data)) {
    		foreach ($data as $row) {
    			$bonus[$row['type_id']] = $row['type_name'].' [' .sprintf(ecjia::config('currency_format'), $row['type_money']).']';
    		}
    	}
    	return $bonus;
    }
    
    /**
     * 获取用户红包列表 --bonus.func
     * @access public
     * @param
     * $page_param
     * @return void
     */
    public static function get_bonus_list() {
    	RC_Lang::load('bonus');
    
    	/* 查询条件 */
    	$filter ['sort_by']    = empty($_REQUEST['sort_by']) 	? 'user_bonus.bonus_id'	: trim($_REQUEST['sort_by']);
    	$filter ['sort_order'] = empty($_REQUEST['sort_order'])	? 'DESC'				: trim($_REQUEST['sort_order']);
    	$filter ['bonus_type'] = empty($_REQUEST['bonus_type'])	? 0 					: intval($_REQUEST['bonus_type']);
    
    	$db_user_bonus = RC_DB::table('user_bonus');
    	if (!empty($filter['bonus_type'])) {
    		$db_user_bonus->where('user_bonus.bonus_type_id', '=', $filter['bonus_type']);
    	}
    
    	$count = $db_user_bonus->count();
    	$page = new ecjia_merchant_page ($count, 15, 5);
    
    	$row = $db_user_bonus
	    	->leftJoin('bonus_type', 'bonus_type.type_id', '=', 'user_bonus.bonus_type_id')
	    	->leftJoin('users', 'users.user_id', '=', 'user_bonus.user_id')
	    	->leftJoin('order_info', 'order_info.order_id', '=', 'user_bonus.order_id')
	    	->select('user_bonus.*', 'users.user_name', 'users.email', 'order_info.order_sn', 'bonus_type.type_name')
	    	->orderby($filter['sort_by'], $filter['sort_order'])
	    	->take(15)
	    	->skip($page->start_id-1)
	    	->get();
    
    	if (!empty($row)) {
    		foreach($row as $key => $val) {
    			$row[$key]['used_time'] = $val['used_time'] == 0 ? RC_Lang::get('bonus::bonus.no_use') : RC_Time::local_date(ecjia::config('date_format'), $val['used_time']);
    			$row[$key]['emailed']   = RC_Lang::get('bonus::bonus.mail_status.'.$row[$key]['emailed']);
    		}
    	}
    	$arr = array('item' => $row, 'filter' => $filter, 'page' => $page->show (2), 'desc' => $page->page_desc ());
    	return $arr;
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
    public static function add_to_maillist($username, $email, $subject, $content, $is_html) {
    	$time = time ();
    	$content = addslashes ( $content );
    	$template_id = RC_DB::table('mail_templates')->where('template_code', 'send_bonus')->pluck('template_id');
    
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
    
    /**
     * 取得红包信息
     * @param   int	 $bonus_id   红包id
     * @param   string  $bonus_sn   红包序列号
     * @param   array   红包信息
     */
    public static function bonus_info($bonus_id, $bonus_sn = '') {
    	$db_view = RC_DB::table('user_bonus')->leftJoin('bonus_type', 'bonus_type.type_id', '=', 'user_bonus.bonus_type_id');
    	$db_view->select('user_bonus.*', 'bonus_type.*');
    
    	if ($bonus_id > 0) {
    		return $db_view->where('user_bonus.bonus_id', $bonus_id)->first();
    	} else {
    		return $db_view->where('user_bonus.bonus_sn', $bonus_sn)->first();
    	}
    }
}

// end