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
 * 红包类型的处理
 */
class merchant extends ecjia_merchant {
	public function __construct() {
		parent::__construct();
		RC_Loader::load_app_class('bonus', 'bonus');
		RC_Loader::load_app_func('merchant_goods', 'goods');

		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');

		/* 红包类型编辑页面 js/css */
		RC_Script::enqueue_script('bonus_type', RC_App::apps_url('statics/js/bonus_merchant_type.js', __FILE__), array(), false, true);
		RC_Script::enqueue_script('bonus', RC_App::apps_url('statics/js/bonus_merchant.js', __FILE__), array(), false, true);

        // select 选择框
        RC_Style::enqueue_style('chosen_style', dirname(RC_App::app_dir_url(__FILE__)) .'/merchant/statics/assets/chosen/chosen.css', array());
        RC_Script::enqueue_script('chosen_script', dirname(RC_App::app_dir_url(__FILE__)) .'/merchant/statics/assets/chosen/chosen.jquery.min.js', array(), false, false);

		//时间控件
        RC_Script::enqueue_script('bootstrap-datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.js'));
		RC_Style::enqueue_style('datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.min.css'));

        RC_Script::enqueue_script('jq_quicksearch', RC_Uri::admin_url() . '/statics/lib/multi-select/js/jquery.quicksearch.js', array('jquery'), false, true);

        /*快速编辑*/
        RC_Script::enqueue_script('bootstrap-editable-script', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/x-editable/bootstrap-editable/js/bootstrap-editable.min.js', array());
		RC_Style::enqueue_style('bootstrap-editable-css', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/x-editable/bootstrap-editable/css/bootstrap-editable.css', array(), false, false);

		$js_lang = array(
			'edit_bonus_type_name'		=> RC_Lang::get('bonus::bonus.edit_bonus_type_name'),
			'edit_bonus_money'			=> RC_Lang::get('bonus::bonus.edit_bonus_money'),
			'edit_order_limit'			=> RC_Lang::get('bonus::bonus.edit_order_limit'),
			'type_name_required'		=> RC_Lang::get('bonus::bonus.type_name_required'),
			'type_name_minlength'		=> RC_Lang::get('bonus::bonus.type_name_minlength'),
			'type_money_required'		=> RC_Lang::get('bonus::bonus.type_money_required'),
			'min_goods_amount_required'	=> RC_Lang::get('bonus::bonus.min_goods_amount_required'),
		);
		RC_Script::localize_script('bonus_type', 'js_lang', $js_lang);

		$bonus_js_lang = array(
			'bonus_sum_required'	=> RC_Lang::get('bonus::bonus.bonus_sum_required'),
			'bonus_number_required'	=> RC_Lang::get('bonus::bonus.bonus_number_required'),
			'select_goods_empty'	=> RC_Lang::get('bonus::bonus.select_goods_empty'),
			'select_user_empty'		=> RC_Lang::get('bonus::bonus.select_user_empty'),
		);
		RC_Script::localize_script('bonus', 'bonus_js_lang', $bonus_js_lang);
		
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('红包管理'), RC_Uri::url('bonus/merchant/init')));
		ecjia_merchant_screen::get_current_screen()->set_parentage('promotion', 'promotion/merchant.php');
	}

	/**
	 * 红包类型列表页面
	 */
	public function init() {
		$this->admin_priv('bonus_type_manage');

		$this->assign('ur_here',    RC_Lang::get('bonus::bonus.bonustype_list'));
		$this->assign('action_link', array('text' => RC_Lang::get('system::system.bonustype_add'), 'href' => RC_Uri::url('bonus/merchant/add')));
		$list = $this->get_type_list();
		$this->assign('type_list',   $list);
		$this->assign('bonustype',   $list['filter']);

		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('bonus::bonus.bonus_type')));

		$this->assign('search_action', RC_Uri::url('bonus/merchant/init'));
		$this->assign('admin_url', RC_Uri::admin_url());

		$this->display('bonus_type.dwt');
	}

	/**
	 * 红包类型添加页面
	 */
	public function add() {
		$this->admin_priv('bonus_type_update');
		$this->assign('ur_here', RC_Lang::get('bonus::bonus.add_bonus_type'));
		$this->assign('action_link', array('href' => RC_Uri::url('bonus/merchant/init'), 'text' => RC_Lang::get('bonus::bonus.bonustype_list')));


		$next_month = RC_Time::local_strtotime('+1 months');
		$bonus_arr['send_start_date']	= RC_Time::local_date('Y-m-d H:i', RC_Time::gmtime());
		$bonus_arr['send_end_date']		= RC_Time::local_date('Y-m-d H:i',RC_Time::local_strtotime("+1 month"));
		$bonus_arr['use_start_date']	= RC_Time::local_date('Y-m-d H:i', RC_Time::gmtime());
		$bonus_arr['use_end_date']		= RC_Time::local_date('Y-m-d H:i',RC_Time::local_strtotime("+1 month"));

		$this->assign('bonus_arr',    $bonus_arr);
     	$this->assign('form_action',  RC_Uri::url('bonus/merchant/insert'));

     	ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('bonus::bonus.add_bonus_type')));

		$this->assign_lang();
		$this->display('bonus_type_info.dwt');
	}


	/**
	 * 红包类型添加的处理
	 */
	public function insert() {
		$this->admin_priv('bonus_type_update', ecjia::MSGTYPE_JSON);

		$type_name 	= !empty($_POST['type_name']) 	? trim($_POST['type_name']) 	: '';
		$type_id   	= !empty($_POST['type_id'])    	? intval($_POST['type_id'])    	: 0;
		$min_amount	= !empty($_POST['min_amount']) 	? floatval($_POST['min_amount']): 0;
		$send_type	= !empty($_POST['send_type'])	? intval($_POST['send_type'])	: 0;
        $store_id 	= !empty($_SESSION['store_id'])	? $_SESSION['store_id'] 		: 0;

		$count = RC_DB::table('bonus_type')->where('type_name', $type_name)->where('store_id', $store_id)->count();
		
	    if ($count != 0) {
            return $this->showmessage(RC_Lang::get('bonus::bonus.type_name_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$send_startdate = RC_Time::local_strtotime($_POST['send_start_date']);
		$send_enddate   = RC_Time::local_strtotime($_POST['send_end_date']);
		$use_startdate  = RC_Time::local_strtotime($_POST['use_start_date']);
		$use_enddate    = RC_Time::local_strtotime($_POST['use_end_date']);

		if ($send_type != 0 && $send_type != 3) {
			if (empty($send_startdate)) {
				return $this->showmessage(RC_Lang::get('bonus::bonus.send_startdate_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			if (empty($send_enddate)) {
				return $this->showmessage(RC_Lang::get('bonus::bonus.send_enddate_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			if ($send_startdate >= $send_enddate) {
				return $this->showmessage(RC_Lang::get('bonus::bonus.send_start_lt_end'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}

		if (empty($use_startdate)) {
			return $this->showmessage(RC_Lang::get('bonus::bonus.use_startdate_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		if (empty($use_enddate)) {
			return $this->showmessage(RC_Lang::get('bonus::bonus.use_enddate_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		if ($use_startdate >= $use_enddate) {
			return $this->showmessage(RC_Lang::get('bonus::bonus.use_start_lt_end'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

        $data = array(
     		'type_name'        => $type_name,
     		'type_money'       => floatval($_POST['type_money']),
     		'send_start_date'  => $send_startdate,
     		'send_end_date'    => $send_enddate,
     		'use_start_date'   => $use_startdate,
     		'use_end_date'     => $use_enddate,
     		'send_type'        => $send_type,
        	'usebonus_type'    => 0,
        	'store_id'         => $store_id,
        	'min_amount'       => $min_amount,
     		'min_goods_amount' => floatval($_POST['min_goods_amount']),
    	);
	    
        $id = RC_DB::table('bonus_type')->insertGetId($data);
		
		if(intval($_POST['send_type']) == 0){
			$send = '按用户发放';
		}elseif(intval($_POST['send_type']) == 3){
			$send = '线下发放的红包';
		}elseif(intval($_POST['send_type']) == 1){
			$send = '按商品发放';
		}elseif(intval($_POST['send_type']) == 2){
			$send = '按订单金额发放';
		}
		/* 记录日志 */
		ecjia_merchant::admin_log(RC_Lang::get('bonus::bonus.send_type_is').$send.'，'.RC_Lang::get('bonus::bonus.bonustype_name_is').$type_name, 'add', 'bonustype');

		$links[] = array('text' => RC_Lang::get('bonus::bonus.back_list'), 'href' => RC_Uri::url('bonus/merchant/init'));
		$links[] = array('text' => RC_Lang::get('bonus::bonus.continus_add'), 'href' => RC_Uri::url('bonus/merchant/add'));
		return $this->showmessage(RC_Lang::get('bonus::bonus.add_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('bonus/merchant/edit', array('type_id' => $id))));
	}

	/**
	 * 红包类型编辑页面
	 */
	public function edit() {
		$this->admin_priv('bonus_type_update');
		
        ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('bonus::bonus.bonustype_edit')));
        $type_id	= !empty($_GET['type_id']) 		? intval($_GET['type_id'])	: 0;
        $store_id 	= !empty($_SESSION['store_id'])	? $_SESSION['store_id']		: 0;
        
		$bonus_type_db = RC_DB::table('bonus_type');

		$bonus_arr = $bonus_type_db->where(RC_DB::raw('type_id'), $type_id)->where('store_id', $store_id)->first();
		if (empty($bonus_arr)) {
			$links[] = array('text' => '返回红包类型列表', 'href' => RC_Uri::url('bonus/merchant/init'));
			return $this->showmessage('该红包类型不存在', ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => $links));
		}
		
		$bonus_arr['send_start_date'] = RC_Time::local_date('Y-m-d H:i:s', $bonus_arr['send_start_date']);
		$bonus_arr['send_end_date']   = RC_Time::local_date('Y-m-d H:i:s', $bonus_arr['send_end_date']);
		$bonus_arr['use_start_date']  = RC_Time::local_date('Y-m-d H:i:s', $bonus_arr['use_start_date']);
		$bonus_arr['use_end_date']    = RC_Time::local_date('Y-m-d H:i:s', $bonus_arr['use_end_date']);

		$this->assign('ur_here',    RC_Lang::get('bonus::bonus.bonustype_edit'));
		$this->assign('action_link', array('href' => RC_Uri::url('bonus/merchant/init'), 'text' => RC_Lang::get('bonus::bonus.bonustype_list')));
		$this->assign('bonus_arr',   $bonus_arr);
		$this->assign('form_action', RC_Uri::url('bonus/merchant/update'));
		$this->display('bonus_type_info.dwt');
	}

	/**
	 * 红包类型编辑的处理
	 */
	public function update() {
		$this->admin_priv('bonus_type_update', ecjia::MSGTYPE_JSON);

		$type_name 		= !empty($_POST['type_name']) 		? trim($_POST['type_name']) 	: '';
		$store_id 		= !empty($_SESSION['store_id']) 	? $_SESSION['store_id'] 		: 0;
		$type_id     	= !empty($_POST['type_id'])    		? intval($_POST['type_id'])    	: 0;
		$min_amount  	= !empty($_POST['min_amount']) 		? intval($_POST['min_amount']) 	: 0;
		
		$use_startdate  = !empty($_POST['use_start_date']) 	? RC_Time::local_strtotime($_POST['use_start_date']) 	: '';
		$use_enddate    = !empty($_POST['use_end_date']) 	? RC_Time::local_strtotime($_POST['use_end_date']) 		: '';
		
		$count = RC_DB::table('bonus_type')->where('type_name', $type_name)->where('store_id', $store_id)->where('type_id', '!=', $type_id)->count();
		if ($count != 0) {
			return $this->showmessage(RC_Lang::get('bonus::bonus.type_name_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$data = array(
			'type_name'        => $type_name,
			'type_money'       => floatval($_POST['type_money']),
			'use_start_date'   => $use_startdate,
			'use_end_date'     => $use_enddate,
			'send_type'        => intval($_POST['send_type']),
			'min_amount'       => $min_amount,
			'min_goods_amount' => floatval($_POST['min_goods_amount']),
		);
		
		if( isset($_POST['send_start_date']) && !empty($_POST['send_start_date'])) {
			$send_startdate = RC_Time::local_strtotime($_POST['send_start_date']);
			$data['send_start_date'] = $send_startdate;
		}
		if( isset($_POST['send_end_date']) && !empty($_POST['send_end_date'])) {
			$send_enddate   = RC_Time::local_strtotime($_POST['send_end_date']);
			$data['send_end_date'] = $send_enddate;
		}

		RC_DB::table('bonus_type')->where('type_id', $type_id)->where('store_id', $store_id)->update($data);

		if (intval($_POST['send_type']) == 0) {
			$send = '按用户发放';
		} elseif(intval($_POST['send_type']) == 3) {
			$send = '线下发放的红包';
		} elseif (intval($_POST['send_type']) == 1) {
			$send = '按商品发放';
		} elseif(intval($_POST['send_type']) == 2) {
			$send = '按订单金额发放';
        }
		/* 记录日志 */
		ecjia_merchant::admin_log('发放类型是'.$send.',红包名是'.$type_name, 'edit', 'bonustype');
		ecjia_merchant::admin_log(RC_Lang::get('bonus::bonus.send_type_is').$send.'，'.RC_Lang::get('bonus::bonus.bonustype_name_is').$type_name, 'edit', 'bonustype');

		$links[] = array('text' => RC_Lang::get('bonus::bonus.back_list'), 'href' => RC_Uri::url('bonus/merchant/init'));
		$links[] = array('text' => RC_Lang::get('bonus::bonus.continus_add'), 'href' => RC_Uri::url('bonus/merchant/add'));
		return $this->showmessage(RC_Lang::get('bonus::bonus.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('bonus/merchant/edit', array('type_id' => $type_id))));
	}

	/**
	 * 删除红包类型
	 */
	public function remove() {
		$this->admin_priv('bonus_type_delete', ecjia::MSGTYPE_JSON);

		$id 		= intval($_GET['id']);
		$store_id	= !empty($_SESSION['store_id']) ? $_SESSION['store_id'] : 0;
		
		$info = RC_DB::table('bonus_type')->where('type_id', $id)->where('store_id', $store_id)->first();
		
		if ($info['send_type'] == 0) {
			$send = '按用户发放';
		} elseif ($info['send_type'] == 3) {
			$send = '线下发放的红包';
		} elseif ($info['send_type'] == 1) {
			$send = '按商品发放';
		} elseif ($info['send_type'] == 2) {
			$send = '按订单金额发放';
		} elseif ($info['send_type'] == 5) {
			$send = '优惠券';
		}

		if (!empty($info)) {
			//删除红包类型
			RC_DB::table('bonus_type')->where('type_id', $id)->where('store_id', $store_id)->delete();
			
			//删除用户红包
			RC_DB::table('user_bonus')->where('bonus_type_id', $id)->delete();
			
			//更新该红包类型的商品为0
			RC_DB::table('goods')->where('bonus_type_id', $id)->where('store_id', $store_id)->update(array('bonus_type_id' => 0));
			/* 记录日志 */
			ecjia_merchant::admin_log('发放类型是'.$send.',红包名是'.$info['type_name'], 'remove', 'bonustype');
			ecjia_merchant::admin_log(RC_Lang::get('bonus::bonus.send_type_is').$send.'，'.RC_Lang::get('bonus::bonus.bonustype_name_is').$info['type_name'], 'remove', 'bonustype');
		}

		return $this->showmessage(RC_Lang::get('bonus::bonus.del_bonustype_succed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}

	/**
	 * 编辑红包类型名称
	 */
	public function edit_type_name() {
	    $this->admin_priv('bonus_type_update', ecjia::MSGTYPE_JSON);
	
	    $typename 		= trim($_POST['value']);
	    $id				= intval($_POST['pk']);
	    $store_id 		= !empty($_SESSION['store_id'])	? $_SESSION['store_id']	: 0;
	    $bonus_type = RC_Api::api('bonus', 'bonus_type_info', array('type_id', $id));
	
	    if($bonus_type['send_type'] == 0){
	        $send = '按用户发放';
	    }elseif($bonus_type['send_type'] == 3){
	        $send = '线下发放的红包';
	    }elseif($bonus_type['send_type'] == 1){
	        $send = '按商品发放';
	    }elseif($bonus_type['send_type'] == 2){
	        $send = '按订单金额发放';
	    }
	    if (empty($typename)) {
	        return $this->showmessage('请输红包类型名称！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR );
	    }
	
	    if (RC_DB::table('bonus_type')->where('type_name', $typename)->where('store_id', $store_id)->where('type_id', '!=', $id)->count() == 0) {
	        RC_DB::table('bonus_type')
		        ->where('type_id', $id)
		        ->where('store_id', $store_id)
		        ->update(array('type_name' => $typename));
	        /* 记录日志 */
	        ecjia_merchant::admin_log('发放类型是'.$send.',红包名是'.$typename, 'edit', 'bonustype');
	        return $this->showmessage(RC_Lang::get('bonus::bonus.attradd_succed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	    } else {
	        return $this->showmessage(RC_Lang::get('bonus::bonus.type_name_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR );
	    }
	}
	
	/**
	 * 编辑红包金额
	 */
	public function edit_type_money() {
	    $this->admin_priv('bonus_type_update', ecjia::MSGTYPE_JSON);
	
	    $id  = !empty($_POST['pk']) 	? intval($_POST['pk']) 		: 0;
	    $val = !empty($_POST['value']) 	? floatval($_POST['value']) : 0;
	    $bonus_type = RC_DB::table('bonus_type')
		    ->select(RC_DB::Raw('type_name, send_type'))
		    ->where(RC_DB::Raw('type_id'), $id)
		    ->where(RC_DB::Raw('store_id'), $_SESSION['store_id'])
		    ->first();
	    if ($bonus_type['send_type'] == 0) {
	        $send = '按用户发放';
	    } elseif ($bonus_type['send_type'] == 3) {
	        $send = '线下发放的红包';
	    } elseif ($bonus_type['send_type'] == 1) {
	        $send = '按商品发放';
	    } elseif ($bonus_type['send_type'] == 2) {
	        $send = '按订单金额发放';
	    }
	    if ($val <= 0) {
	        return $this->showmessage(RC_Lang::get('bonus::bonus.type_money_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    } else {
	        RC_DB::table('bonus_type')
		        ->where(RC_DB::Raw('type_id'), $id)
		        ->where(RC_DB::Raw('store_id'), $_SESSION['store_id'])
		        ->update(array('type_money' => $val));
	        /* 记录日志 */
	        ecjia_merchant::admin_log('发放类型是'.$send.',红包名是'.$bonus_type['type_name'], 'edit', 'bonustype');
	        return $this->showmessage(RC_Lang::get('bonus::bonus.attradd_succed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('bonus/merchant/init')));
	    }
	}
	
	/**
	 * 编辑订单下限
	 */
	public function edit_min_amount() {
	    $this->admin_priv('bonus_type_update', ecjia::MSGTYPE_JSON);
	
	    $id  = intval($_POST['pk']);
	    $val = floatval($_POST['value']);
	    /* 可为0 */
	    if ($val <= 0 && !($_POST['value'] === '0')) {
	        return $this->showmessage(RC_Lang::get('bonus::bonus.min_amount_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    else {
	        RC_DB::table('bonus_type')
		        ->where(RC_DB::Raw('type_id'), $id)
		        ->where(RC_DB::Raw('store_id'), $_SESSION['store_id'])
		        ->update(array('min_amount' => $val));
	        return $this->showmessage(RC_Lang::get('bonus::bonus.attradd_succed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('bonus/merchant/init')));
	    }
	}
	
	/**
	 * 红包发送页面
	 */
	public function send() {
		$this->admin_priv('bonus_send');
		
		/* 取得参数 */
		$id = !empty($_GET['id'])  ? intval($_GET['id'])  : 0;
		$send_by = intval($_GET['send_by']);

		$this->assign('ur_here',   RC_Lang::get('bonus::bonus.send_bonus'));
		$this->assign('action_link',  array('href' => RC_Uri::url('bonus/merchant/init', array('bonus_type' => $id)), 'text' => RC_Lang::get('bonus::bonus.bonustype_list')));
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('bonus::bonus.send_bonus')));
		$this->assign('admin_url', RC_Uri::admin_url());
		$db_bonus_type = RC_DB::table('bonus_type');

		if ($send_by == SEND_BY_USER) {
			//用户发放
			if ($_SESSION['store_id'] > 0) {
				$bonus_type = $db_bonus_type->where(RC_DB::raw('type_id '), $id)->where(RC_DB::raw('store_id'), $_SESSION['store_id'])->select(RC_DB::raw('type_id, type_name'))->first();
			} else {
				$bonus_type = $db_bonus_type->where(RC_DB::raw('type_id '), $id)->select(RC_DB::raw('type_id, type_name'))->first();
			}
			$this->assign('id',               $id);
			$this->assign('ranklist',         bonus::get_rank_list());
			$this->assign('bonus_type',       $bonus_type);
			$this->assign('form_action',      RC_Uri::url('bonus/merchant/send_by_user_rank'));
			$this->assign('form_user_action', RC_Uri::url('bonus/merchant/send_by_user'));
			$this->display('bonus_by_user.dwt');

		} elseif ($send_by == SEND_BY_GOODS) {
			if (!empty($_SESSION['store_id']) && $_SESSION['store_id'] > 0) {
				$bonus_type = $db_bonus_type
				->selectRaw('type_id, type_name')
				->where(RC_DB::raw('type_id '), $id )
				->where(RC_DB::raw('store_id'), $_SESSION['store_id'])
				->first();
			} else {
				$bonus_type = $db_bonus_type
				->selectRaw('type_id, type_name')
				->where(RC_DB::raw('type_id'), $id )
				->first();
			}
			$goods_list = bonus::get_bonus_goods($id);
			$db_goods = RC_DB::table('goods');
			if (!empty($_SESSION['store_id']) && $_SESSION['store_id'] > 0) {
				$other_goods_list = $db_goods->select('goods_id')
					->where(RC_DB::raw('store_id'), $_SESSION['store_id'])
					->where(RC_DB::raw('bonus_type_id'), '>', 0)
					->where(RC_DB::raw('bonus_type_id'), '<>', $id)->get();
			} else {
				$other_goods_list = $db_goods->select('goods_id')
				->where(RC_DB::raw('bonus_type_id'), '>', 0)
				->where(RC_DB::raw('bonus_type_id'), '<>', $id)->get();
			}
			$this->assign('other_goods', join(',', $other_goods_list));

			/* 模板赋值 */
			$this->assign('bonus_type_id',    $id);
			$this->assign('merchant_cat_list', merchant_cat_list());
			$this->assign('bonus_type',  $bonus_type);
			$this->assign('goods_list',  $goods_list);
			$this->assign('form_search', RC_Uri::url('bonus/merchant/get_goods_list'));
			$this->assign('form_action', RC_Uri::url('bonus/merchant/send_by_goods'));
			$this->display('bonus_by_goods.dwt');
		}
		elseif ($send_by == SEND_BY_PRINT) {
			//线下发放
			$this->assign('type_list',   bonus::get_bonus_type());
			$this->assign('form_action', RC_Uri::url('bonus/merchant/send_by_print'));

			$this->display('bonus_by_print.dwt');
		} elseif ($send_by == SEND_COUPON) {//优惠券
			//发放优惠券
			RC_Loader::load_app_class('goods_category', 'goods', false);
			/* 模板赋值 */
			$this->assign('bonus_type_id', $id);
			$this->assign('merchant_cat_list',	merchant_cat_list());

			$bonus_relation = RC_DB::table('term_meta');
			$goods_group = $bonus_relation
				->where(RC_DB::raw('object_type'), 'ecjia.goods')
				->where(RC_DB::raw('object_group'), 'goods_bonus_coupon')
				->where(RC_DB::raw('meta_key'), 'bonus_type_id')
				->where(RC_DB::raw('meta_value'), $id)
				->lists('object_id');

			if (!empty($goods_group)) {
				$goods_list = RC_DB::table('goods')
					->select(RC_DB::raw('goods_id, goods_name'))
					->whereIn('goods_id', $goods_group)
					->get();
			} else {
				$goods_list = array();
			}
			$this->assign('goods_list', $goods_list);
			$this->assign('form_search', RC_Uri::url('bonus/merchant/get_goods_list'));
			$this->assign('form_action', RC_Uri::url('bonus/merchant/send_by_coupon'));

			$this->display('bonus_by_goods.dwt');
		}
	}

	/**
	 * 处理红包的发送页面
	 */
	public function send_by_user_rank() {
		$this->admin_priv('bonus_send', ecjia::MSGTYPE_JSON);

		$user_list = array();
		$send_count = 0;
		/* 按等级发放红包时-只给通过邮件验证的用户发放红包 */
		$validated_email = empty($_POST['validated_email']) ? 0 : intval($_POST['validated_email']);
		/* 按会员等级来发放红包 */
		$rank_id = intval($_POST['rank_id']);
		if ($rank_id > 0) {
			$row = RC_DB::table('user_rank')
					->selectRaw('min_points, max_points, special_rank')
					->where(RC_DB::raw('rank_id'), $rank_id)
					->first();
			$db_user = RC_DB::table('users');
			if ($row['special_rank']) {
				/* 特殊会员组处理 */
				if($validated_email) {
					$user_list = $db_user
						->selectRaw('user_id, email, user_name')
						->where(RC_DB::raw('user_rank'), $rank_id)
						->where(RC_DB::raw('is_validated'), 1)
						->get();
				} else {
					$user_list = $db_user
						->selectRaw('user_id, email, user_name')
						->where(RC_DB::raw('user_rank'), $rank_id)
						->get();
				}
			} else {
				if($validated_email) {
					$user_list = $db_user
						->where(RC_DB::raw('rank_points'), '>=', intval($row['min_points']))
						->where(RC_DB::raw('rank_points'), '<', intval($row['max_points']))
						->where(RC_DB::raw('is_validated'), 1)
						->selectRaw('user_id, email, user_name')
						->get();
				} else {
					$user_list = $db_user
						->selectRaw('user_id, email, user_name')
						->where(RC_DB::raw('rank_points'), '>=', intval($row['min_points']))
						->where(RC_DB::raw('rank_points'), '<', intval($row['max_points']))
						->get();
				}
			}
		}

		/* 发送红包 */
		$loop       = 0;
		$loop_faild = 0;
		$bonus_type_id = intval($_POST['id']);
		$bonus_type = RC_Api::api('bonus', 'bonus_type_info', array('type_id' => $bonus_type_id));

		$tpl_name = 'send_bonus';
		$tpl   = RC_Api::api('mail', 'mail_template', $tpl_name);

		$today = RC_Time::local_date(ecjia::config('date_format'));

        foreach ($user_list AS $key => $val) {
			/* 发送邮件通知 */
			/* 读取邮件配置项 */
        	$db_config = RC_Model::model('shop_config_model');
        	$arr 	   = $db_config->get_email_setting();
			$email_cfg = array_merge($val, $arr);
			$email_cfg['reply_email'] = $arr['smtp_user'];
			$this->assign('user_name', $val['user_name']);
			$this->assign('shop_name', ecjia::config('shop_name'));
			$this->assign('send_date', $today);
			$this->assign('count',     1);
			$this->assign('money',     price_format($bonus_type['type_money']));
			$content = $this->fetch_string($tpl['template_content']);
			if (bonus::add_to_maillist($val['user_name'], $email_cfg['email'], $tpl['template_subject'], $content, $tpl['is_html'])) {
				/* 向会员红包表录入数据 */
				$data = array(
					'bonus_type_id' => $bonus_type_id,
					'bonus_sn'  => 0,
					'user_id'   => $val['user_id'],
					'used_time' => 0,
					'order_id'  => 0,
					'emailed'   => BONUS_INSERT_MAILLIST_SUCCEED,
				);
				RC_DB::table('user_bonus')->insert($data);
				$name = RC_DB::table('users')->where(RC_DB::raw('user_id'), $val['user_id'])->pluck('user_name');
				$content = '发放红包,发放类型是按用户发放, 红包名是'.$bonus_type['type_name'].', 发放目标是'.$name;
				ecjia_merchant::admin_log($content, 'setup', 'bonustype');
				$loop++;
			} else {
				/* 邮件发送失败，更新数据库 */
				$data = array(
					'bonus_type_id' => $bonus_type_id,
					'bonus_sn'  => 0,
					'user_id'   => $val[user_id],
					'used_time' => 0,
					'order_id'  => 0,
					'emailed'   => BONUS_INSERT_MAILLIST_FAIL,
				);
				RC_DB::table('user_bonus')->insert($data);
				$loop_faild++;
			}
		}
		return $this->showmessage(sprintf(RC_Lang::get('bonus::bonus.sendbonus_count'), $loop), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('max_id' => $bonus_type_id));
	}


	/**
	 * 处理红包的发送页面 post
	 */
	public function send_by_user() {
		$this->admin_priv('bonus_send', ecjia::MSGTYPE_JSON);

		$user_list = array();
		$user_ids = $_GET['linked_array'];
		if (empty($user_ids)) {
			return $this->showmessage(RC_Lang::get('bonus::bonus.send_user_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$user_array = (is_array($user_ids)) ? $user_ids : explode(',', $user_ids);
		$new_ids = array();
		foreach ($user_array as $value){
			$new_ids[] = $value['user_id'];
		}
		/* 根据会员ID取得用户名和邮件地址 */
		$user_list = RC_DB::table('users')->select(RC_DB::raw('user_id, email, user_name'))->whereIn('user_id', $new_ids)->get();
		$count = count($user_list);

		/* 发送红包 */
		$bonus_type_id = intval($_GET['bonus_type_id']);
		$bonus_type =  RC_Api::api('bonus', 'bonus_type_info', array('type_id', $bonus_type_id));
		$tpl_name = 'send_bonus';
		$tpl   = RC_Api::api('mail', 'mail_template', $tpl_name);

		$today = RC_Time::local_date(ecjia::config('date_format'));

		foreach ($user_list as $key => $val) {
			/* 发送邮件通知 */
			/* 读取邮件配置项 */
			$db_config = RC_Loader::load_model('shop_config_model');
			$arr       = $db_config->get_email_setting();
			$email_cfg = array_merge($val, $arr);
			$email_cfg['reply_email'] = $arr['smtp_user'];
			$this->assign('user_name', $val['user_name']);
			$this->assign('shop_name', ecjia::config('shop_name'));
			$this->assign('send_date', $today);
			$this->assign('count',     1);
			$this->assign('money',     price_format($bonus_type['type_money']));
			$content = $this->fetch_string($tpl['template_content']);
			if (bonus::add_to_maillist($val['user_name'], $email_cfg['email'], $tpl['template_subject'], $content, $tpl['is_html'])) {
				$data = array(
					'bonus_type_id' => $bonus_type_id,
					'bonus_sn'      => 0,
					'user_id' 	    => $val['user_id'],
					'used_time' 	=> 0,
					'order_id' 		=> 0,
					'emailed' 		=> BONUS_INSERT_MAILLIST_SUCCEED,
				);
				RC_DB::table('user_bonus')->insert($data);
			} else {
				$data = array(
					'bonus_type_id' => $bonus_type_id,
					'bonus_sn' 	    => 0,
					'user_id' 		=> $val[user_id],
					'used_time' 	=> 0,
					'order_id' 		=> 0,
					'emailed' 		=> BONUS_INSERT_MAILLIST_FAIL,
				);
				RC_DB::table('user_bonus')->insert($data);
			}
		}
		return $this->showmessage(sprintf(RC_Lang::get('bonus::bonus.sendbonus_count'), $count), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}

	/**
	 * 按指定商品发送红包
	 */
	public function send_by_goods() {
		$this->admin_priv('bonus_send', ecjia::MSGTYPE_JSON);
		
		$db_goods = RC_DB::table('goods');
		$db_bonus_type = RC_DB::table('bonus_type');
		if (!empty($_SESSION['store_id']) && $_SESSION['store_id'] > 0) {
			$db_goods->where(RC_DB::raw('store_id'), $_SESSION['store_id']);
			$db_bonus_type->where(RC_DB::raw('store_id'), $_SESSION['store_id']);
		}
		/* 商品的权限判断 START */
		if(!empty($_POST['linked_array'])){
			$goods_id_temp = $db_goods
				->selectRaw('goods_id')
				->whereIn(RC_DB::raw('goods_id'), $_POST['linked_array'])
				->get();
			$_POST['linked_array'] = array_column($goods_id_temp, 'goods_id');
		}
		/* 商品的权限判断 END */

		$goods_id = $_GET['linked_array'];
		$type_id = intval($_GET['bonus_type_id']);
		$data = array(
			'bonus_type_id' => 0
		);
		$db_goods->where(RC_DB::raw('bonus_type_id'), $type_id)->update($data);
		$bonus_type = $db_bonus_type->where(RC_DB::raw('type_id'), $type_id)->pluck('type_name');

		$goods_array = (is_array($goods_id)) ? $goods_id : explode(',', $goods_id);
		$new_ids = array();
		foreach ($goods_array as $value){
			$new_ids[] = $value['goods_id'];
			$goods_name = $db_goods->where(RC_DB::raw('goods_id'), $value['goods_id'])->pluck('goods_name');
			$content = '发放红包，发放类型是按商品发放红包，红包名是'.$bonus_type.' ，发放目标是'.$goods_name;
			ecjia_merchant::admin_log($content, 'setup', 'bonustype');
		}
		$data = array( 'bonus_type_id' => $type_id );
		$db_goods->whereIn(RC_DB::raw('goods_id'), $new_ids)->update($data);
		return $this->showmessage(RC_Lang::get('bonus::bonus.attradd_succed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}

	/**
	 * 按线下发放红包
	 */
	public function send_by_print() {
		$this->admin_priv('bonus_send', ecjia::MSGTYPE_JSON);

		@set_time_limit(0);
		/* 线下红包的类型ID和生成的数量的处理 */
		$bonus_typeid = !empty($_POST['bonus_type_id']) ? intval($_POST['bonus_type_id']) : 0;
		$bonus_sum    = !empty($_POST['bonus_sum'])     ? intval($_POST['bonus_sum'])    : 1;
		$bonus_type = RC_DB::table('bonus_type')->where(RC_DB::raw('type_id'), $bonus_typeid)->pluck('type_name');
		/* 生成红包序列号 */
		$num = RC_DB::table('user_bonus')->max('bonus_sn');
		$num = $num ? floor($num / 10000) : 100000;

		for ($i = 0, $j = 0; $i < $bonus_sum; $i++) {
			$bonus_sn = ($num + $i) . str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
			$data = array(
				'bonus_type_id' => $bonus_typeid,
				'bonus_sn' => $bonus_sn
			);
			RC_DB::table('user_bonus')->insert($data);
			$j++;
		}
		$content = '发放红包,发放类型是线下红包,红包名是'.$bonus_type;
		ecjia_merchant::admin_log($content, 'setup', 'userbonus');
		return $this->showmessage(RC_Lang::get('bonus::bonus.creat_bonus') . $j . RC_Lang::get('bonus::bonus.creat_bonus_num'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('max_id' => $bonus_typeid));
	}

	/**
	 * 搜索用户
	 */
	public function search_users() {
		$this->admin_priv('bonus_send', ecjia::MSGTYPE_JSON);
		
		$json = $_POST['JSON'];
		$keywords = !empty($json) && isset($json['keyword']) ? trim($json['keyword']) : '';
		if(!empty($keywords)){
			$db_user = RC_DB::table('users');
			$row = $db_user
				->selectRaw('user_id, user_name')
				->where(RC_DB::raw('user_name'), 'like', '%'.$keywords.'%')
				->orWhere(RC_DB::raw('user_id'), 'like', '%'.$keywords.'%')
				->get();
		}
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content'=>$row));
	}

	/**
	 * 红包列表
	 */
	public function bonus_list() {
		$this->admin_priv('bonus_manage');

		$this->assign('full_page',   1);
		$this->assign('ur_here',    RC_Lang::get('bonus::bonus.bonus_list'));
		$this->assign('action_link', array('href' => RC_Uri::url('bonus/merchant/init'), 'text' => '红包类型列表'));
        ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('红包列表')));
        $list = bonus::get_bonus_list();
		$bonus_type_id = intval($_GET['bonus_type']);
        $bonus_type = RC_DB::table('bonus_type')->where('type_id', $bonus_type_id)->first();
		if ($bonus_type['send_type'] == SEND_BY_PRINT) {
			$this->assign('show_bonus_sn', 1);
		} elseif ($bonus_type['send_type'] == SEND_BY_USER) {
			$this->assign('show_mail', 1);
		}
		$this->assign('bonus_type_id', $bonus_type_id);
		$this->assign('bonus_list',    $list);
		$this->assign('form_action',   RC_Uri::url('bonus/merchant/batch'));
		$this->display('bonus_list.dwt');
	}

	/**
	 * 删除红包
	 */
	public function remove_bonus() {
		$this->admin_priv('bonus_delete', ecjia::MSGTYPE_JSON);
		
        $id = intval($_GET['id']);
		$bonus_type = RC_DB::table('user_bonus')->where(RC_DB::raw('bonus_id'), $id)->pluck('bonus_type_id');
		if (RC_DB::table('bonus_type')->where('type_id', $bonus_type)->where('store_id', $_SESSION['store_id'])->count()) {
			RC_DB::table('user_bonus')->where('bonus_id', $id)->delete();
		}
		return $this->showmessage(RC_Lang::get('bonus::bonus.attradd_succed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}

	/**
	 * 批量操作
	 */
	public function batch() {
	    $sel_action = trim($_GET['sel_action']);
		$action = !empty($sel_action) ? $sel_action : 'send';
		if ($action == 'remove') {
		    $this->admin_priv('bonus_delete', ecjia::MSGTYPE_JSON);
		} else {
		    $this->admin_priv('bonus_send', ecjia::MSGTYPE_JSON);
		}
		
		$bonus_type_id = intval($_GET['bonus_type_id']);
		
		$ids = $_POST['checkboxes'];
		$ids = explode(',', $ids);
		if ( !empty($ids) ) {
			switch ($action) {
				case 'remove':
					if(!is_array($ids)){
						$idsArray = explode(',', $ids);
						$count = count($idsArray);
					} else {
						$count = count($ids);
					}

					RC_DB::table('user_bonus')->whereIn(RC_DB::raw('bonus_id'), $ids)->delete();
					return $this->showmessage(sprintf(RC_Lang::get('bonus::bonus.batch_drop_success'), $count), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('bonus/merchant/bonus_list', array('bonus_type' => $bonus_type_id))));
					break;

				case 'send' :
					$this->send_bonus_mail($bonus_type_id, $ids);
					return $this->showmessage(RC_Lang::get('bonus::bonus.success_send_mail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('bonus/merchant/bonus_list', array('bonus_type' => $bonus_type_id))));
					break;

				default :
					break;
			}
		}
    }

    /**
     * 发送邮件
     */
    public function send_mail() {
    	$this->admin_priv('bonus_send', ecjia::MSGTYPE_JSON);

    	$bonus_id = intval($_GET['bonus_id']);
    	if ($bonus_id <= 0) {
    		return $this->showmessage(RC_Lang::get('bonus::bonus.invalid_parameter'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	$bonus = bonus::bonus_info($bonus_id);

    	if (empty($bonus)) {
    		return $this->showmessage(RC_Lang::get('bonus::bonus.bonus_not_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	$count = $this->send_bonus_mail($bonus['bonus_type_id'], array($bonus_id));

    	return $this->showmessage(sprintf(RC_Lang::get('bonus::bonus.success_send_mail'), $count), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    /**
     * 发送红包邮件
     * @param   int     $bonus_type_id  红包类型id
     * @param   array   $bonus_id_list  红包id数组
     * @return  int     成功发送数量
     */
    private function send_bonus_mail($bonus_type_id, $bonus_id_list){
    	$bonus_type = RC_Api::api('bonus', 'bonus_type_info', array('type_id', $bonus_type_id));
    	if ($bonus_type['send_type'] != SEND_BY_USER) {
    		return 0;
    	}
    	if (!is_array($bonus_id_list)) {
    		$bonus_id_list = explode(',', $bonus_id_list);
    	}
    	$db_view = RC_DB::table('user_bonus')
    		->leftJoin('users', 'users.user_id', '=', 'user_bonus.user_id')
    		->select('user_bonus.bonus_id', 'users.user_name', 'users.email');

    	$bonus_list = $db_view
	    	->where('user_bonus.order_id', 0)
	    	->where('users.email', '!=', '')
	    	->whereIn('user_bonus.bonus_id', $bonus_id_list)
	    	->get();

    	if (empty($bonus_list)) {
    		return 0;
    	}

    	$send_count = 0;
    	/* 发送邮件 */
    	$tpl_name = 'send_bonus';
    	$tpl = RC_Api::api('mail', 'mail_template', $tpl_name);

    	$today = RC_Time::local_date(ecjia::config('date_format'));
    	foreach ($bonus_list AS $bonus) {
    		$this->assign('user_name', $bonus['user_name']);
    		$this->assign('shop_name', ecjia::config('shop_name'));
    		$this->assign('send_date', $today);
    		$this->assign('count',     1);
    		$this->assign('money',     price_format($bonus_type['type_money']));
    		$content = $this->fetch_string($tpl['template_content']);
    		if (bonus::add_to_maillist($bonus['user_name'], $bonus['email'], $tpl['template_subject'], $content, $tpl['is_html'], false)) {
    			$data =array( 'emailed' => BONUS_INSERT_MAILLIST_SUCCEED);
    			RC_DB::table('user_bonus')->where(RC_DB::raw('bonus_id'), $bonus[bonus_id])->update($data);
    			$send_count++;
    		}
    		else {
    			$data = array( 'emailed' => BONUS_INSERT_MAILLIST_FAIL);
    			RC_DB::table('user_bonus')->where('bonus_id', $bonus['bonus_id'])->update($data);
    		}
    	}
    	return $send_count;
    }

    /**
     * 导出线下发放的信息 excel
     */
    public function gen_excel() {
    	$this->admin_priv('bonus_manage', ecjia::MSGTYPE_JSON);

    	@set_time_limit(0);
    	$tid  = !empty($_GET['tid']) ? intval($_GET['tid']) : 0;
    	$type_name = RC_DB::table('bonus_type')->where('type_id', $tid)->where('store_id', $_SESSION['store_id'])->pluck('type_name');
    	$bonus_filename = $type_name .'_bonus_list';
    	header("Content-type: application/vnd.ms-excel; charset=utf-8");
    	header("Content-Disposition: attachment; filename=$bonus_filename.xls");

    	echo mb_convert_encoding(RC_Lang::get('bonus::bonus.bonus_excel_file')."\t\n", "GBK", "UTF-8");
    	echo mb_convert_encoding(RC_Lang::get('bonus::bonus.bonus_sn')."\t" ,"GBK", "UTF-8");
    	echo mb_convert_encoding(RC_Lang::get('bonus::bonus.type_money')."\t","GBK", "UTF-8") ;
    	echo mb_convert_encoding(RC_Lang::get('bonus::bonus.type_name')."\t" ,"GBK", "UTF-8");
    	echo mb_convert_encoding(RC_Lang::get('bonus::bonus.use_enddate')."\t\n","GBK", "UTF-8") ;
    	$val = array();
    	$db_view = RC_DB::table('user_bonus')
    		->leftJoin('bonus_type', 'bonus_type.type_id', '=', 'user_bonus.bonus_type_id')
    		->select('user_bonus.bonus_id', 'user_bonus.bonus_type_id', 'user_bonus.bonus_sn', 'bonus_type.type_name', 'bonus_type.type_money', 'bonus_type.use_end_date');
    	$data = $db_view->where('user_bonus.bonus_type_id', $tid)->orderby('user_bonus.bonus_id', 'desc')->get();
    	$code_table = array();
    	if(!empty($data)) {
    		foreach ($data as $val) {
    			echo mb_convert_encoding($val['bonus_sn']. "\t" ,"GBK", "UTF-8");
    			echo mb_convert_encoding($val['type_money']. "\t","GBK", "UTF-8");
    			if (!isset($code_table[$val['type_name']])) {
    				$code_table[$val['type_name']] = $val['type_name'];
    			}
    			echo mb_convert_encoding($code_table[$val['type_name']]. "\t" ,"GBK", "UTF-8");
    			echo mb_convert_encoding(RC_Time::local_date('Y-m-d', $val['use_end_date']),"GBK", "UTF-8");
    			echo "\t\n";
    		}
    	}
    }

	/**
	 * 获取红包类型列表 --bonus.func
	 * @access  public
	 * @return void
	 */
	private function get_type_list() {
		$db_user_bonus = RC_DB::table('user_bonus');
		
		/* 获得所有红包类型的发放数量 */
		$data = $db_user_bonus
			->select(RC_DB::raw('bonus_type_id'), RC_DB::raw('COUNT(*) AS sent_count'), RC_DB::raw('SUM(IF(used_time>0,1,0)) as used_count'))
			->groupBy(RC_DB::raw('bonus_type_id'))
			->get();

		$sent_arr = array();
		$used_arr = array();
		if(!empty($data)) {
			foreach ($data as $row) {
				$sent_arr[$row['bonus_type_id']] = $row['sent_count'];
				$used_arr[$row['bonus_type_id']] = $row['used_count'];
			}
		}

		$bonustype_id = empty($_GET['bonustype_id']) ? 0 : $_GET['bonustype_id'];
		$filter['send_type'] = '';
		if(!empty($_GET['bonustype_id']) || (isset($_GET['bonustype_id']) && trim($_GET['bonustype_id'])==='0' )){
			$filter['send_type']	= $bonustype_id;

		}
		/* 查询条件 */
		$filter['sort_by']    = empty($_GET['sort_by']) ? 'type_id' : trim($_GET['sort_by']);
		$filter['sort_order'] = empty($_GET['sort_order']) ? 'DESC' : trim($_GET['sort_order']);

		/*初始化红包类型数量*/
		$bonus_type_count = array(
			'count' => 0,//全部
		);

		$bonus_type_count['count'] = RC_Api::api('bonus', 'bonus_type_count', array('bonustype_id' => $_GET['bonustype_id']));
		$page = new ecjia_merchant_page($bonus_type_count['count'], 15, 5);

		$filter['skip']		= $page->start_id-1;
		$filter['limit']	= 15;
		$res = RC_Api::api('bonus', 'merchant_bonus_type_list', array('skip' => $filter['skip'], 'limit' => $filter['limit'], 'bonustype_id' => $_GET['bonustype_id'], 'sort_by' => $filter['sort_by'], 'sort_order' => $filter['sort_order']));
		$arr = array();
		if(!empty($res)) {
			foreach ($res as $row){
				$row['send_by']    = RC_Lang::get('bonus::bonus.send_by.'.$row['send_type']);
				$row['send_count'] = isset($sent_arr[$row['type_id']]) ? $sent_arr[$row['type_id']] : 0;
				$row['use_count']  = isset($used_arr[$row['type_id']]) ? $used_arr[$row['type_id']] : 0;
				$arr[] = $row;
			}
		}
		$arr = array('item' => $arr, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc());
		return $arr;
	}
}

//end