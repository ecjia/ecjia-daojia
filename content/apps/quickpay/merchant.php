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
 * 买单管理
 */
class merchant extends ecjia_merchant {
	public function __construct() {
		parent::__construct();
		
		Ecjia\App\Quickpay\Helper::assign_adminlog_content();
		
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
		
		RC_Script::enqueue_script('mh_quickpay', RC_App::apps_url('statics/js/mh_quickpay.js', __FILE__));
		RC_Script::localize_script('mh_quickpay', 'js_lang', config('app-quickpay::jslang.quickpay_page'));
	
		RC_Style::enqueue_style('mh_quickpay', RC_App::apps_url('statics/css/mh_quickpay.css', __FILE__), array(), false, false);
		
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('买单','quickpay'), RC_Uri::url('quickpay/merchant/init')));
		ecjia_merchant_screen::get_current_screen()->set_parentage('quickpay', 'quickpay/merchant.php');
	}

	
	/**
	 * 优惠买单规则列表页面
	 */
	public function init() {
	    $this->admin_priv('mh_quickpay_manage');
	    
	    ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('优惠买单规则', 'quickpay')));
	    $this->assign('ur_here', __('优惠买单规则列表', 'quickpay'));
	    $this->assign('action_link', array('text' => __('添加优惠买单规则', 'quickpay'), 'href' => RC_Uri::url('quickpay/merchant/add')));
	    
	    $quickpay_enabled = RC_DB::table('merchants_config')->where('store_id', $_SESSION['store_id'])->where('code', 'quickpay_enabled')->pluck('value');
	    $this->assign('quickpay_enabled', $quickpay_enabled);
	    
	    $type_list = $this->get_quickpay_type();
	    $this->assign('type_list', $type_list);
	    
	    $quickpay_list = $this->quickpay_list($_SESSION['store_id']);
	    $this->assign('quickpay_list', $quickpay_list);
	    $this->assign('now', RC_Time::local_date(ecjia::config('time_format'), RC_Time::gmtime()));
	    $this->assign('search_action', RC_Uri::url('quickpay/merchant/init'));
	    
	    $this->display('quickpay_list.dwt');
	}
	

	/**
	 * 开启买单
	 */
	public function open() {
		$this->admin_priv('mh_quickpay_update');
		
		$count= RC_DB::table('merchants_config')->where('store_id', $_SESSION['store_id'])->where('code', 'quickpay_enabled')->count();
		if ($count > 0) {
			RC_DB::table('merchants_config')->where('store_id', $_SESSION['store_id'])->where('code', 'quickpay_enabled')->update(array('value' => 1));
		} else {
			RC_DB::table('merchants_config')->insert(array('store_id' => $_SESSION['store_id'], 'code' => 'quickpay_enabled', 'value' => '1'));
		}
		
		ecjia_merchant::admin_log(__('成功', 'quickpay'), 'open', 'quickpay');
		
		return $this->showmessage(__('开启买单成功', 'quickpay'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('quickpay/merchant/init')));
	}
	
	/**
	 * 关闭买单
	 */
	public function close() {
		$this->admin_priv('mh_quickpay_update');
		
		RC_DB::table('merchants_config')->where('store_id', $_SESSION['store_id'])->where('code', 'quickpay_enabled')->update(array('value' => 0));
		
		ecjia_merchant::admin_log(__('成功', 'quickpay'), 'close', 'quickpay');
		
		return $this->showmessage(__('关闭买单成功', 'quickpay'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('quickpay/merchant/init')));
	}
	
	/**
	 * 添加买单页面
	 */
	public function add() {
		$this->admin_priv('mh_quickpay_update');
		
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('优惠买单规则', 'quickpay')));
		$this->assign('ur_here', __('添加优惠买单规则', 'quickpay'));
		$this->assign('action_link',array('href' => RC_Uri::url('quickpay/merchant/init'),'text' => __('优惠买单规则列表', 'quickpay')));
		
		$type_list = $this->get_quickpay_type();
		$this->assign('type_list', $type_list);
		
		$week_list = $this->get_week_list();
		$this->assign('week_list', $week_list);
		 
		$data = array (
			'enabled'       => 1,
			'start_time'    => date('Y-m-d'),
			'end_time'      => date('Y-m-d', time() + 30 * 86400),
			'use_bonus'     => 'close',	
			'use_integral'  => 'close',
		);
		$this->assign('data', $data);
		
		$this->assign('form_action', RC_Uri::url('quickpay/merchant/insert'));
		
		$this->display('quickpay_info.dwt');
	}

	/**
	 * 处理添加买单
	 */
	public function insert() {
		
		$this->admin_priv('mh_quickpay_update');
		
		$store_id = $_SESSION['store_id'];
		$title    = trim($_POST['title']);
		$description = trim($_POST['description']);

		if (RC_DB::table('quickpay_activity')->where('title', $title)->where('store_id', $store_id)->count() > 0) {
			return $this->showmessage(__('当前店铺下已存在该买单标题', 'quickpay'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		$start_time = RC_Time::local_strtotime($_POST['start_time']);
		$end_time   = RC_Time::local_strtotime($_POST['end_time']);
		
		if ($start_time >= $end_time) {
			return $this->showmessage(__('开始时间不能大于或等于结束时间', 'quickpay'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		//相对应的买单优惠类型活动参数处理
		$activity_discount_value = $_POST['activity_discount_value'];
		if (!empty($activity_discount_value)) {
			$activity_value = $activity_discount_value;
		} else {
			if (is_array($_POST['activity_value'])) {
				foreach($_POST['activity_value'] as $row){
					if (empty($row)){
						return $this->showmessage(__('活动参数不能为空', 'quickpay'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
					}
				}
				$activity_value = implode(",", $_POST['activity_value']);
			}
		}

		//时间规则处理
		$limit_time_type = trim($_POST['limit_time_type']);//限制时间类型类型
		$limit_time_weekly = 0;
		if ($limit_time_type == 'customize') {
			//每周星期0x1111111代表7天
			if (!empty($_POST['limit_time_weekly'])){
				$limit_time_weekly = Ecjia\App\Quickpay\Weekly::weeklySelected($_POST['limit_time_weekly']);
			}
				
			//每天时间段
			$time_quantum = array();
			foreach ($_POST['start_ship_time'] as $k => $v) {
				$time_quantum[$k]['start']	= $v;
				$time_quantum[$k]['end']	= $_POST['end_ship_time'][$k];
			}
			$limit_time_daily = serialize($time_quantum);
				
			//排除日期
			$limit_time_exclude_data = $_POST['limit_time_exclude'];
			$limit_time_exclude = implode(",", $limit_time_exclude_data);
		} 

		
		//是否可参与红包抵现
		$use_bonus_enabled = trim($_POST['use_bonus_enabled']);
		if ($use_bonus_enabled == 'close') {
			$use_bonus = $use_bonus_enabled;
		} else{
			$use_bonus_select = trim($_POST['use_bonus_select']);
			if ($use_bonus_select == 'nolimit') {
				$use_bonus = $use_bonus_select;
			} else{
				if (!empty($_POST['act_range_ext'])) {
					$use_bonus = implode(",", $_POST['act_range_ext']);
				}else{
					return $this->showmessage(__('请选择您要指定的红包项', 'quickpay'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			}
		}
		
		//是否可参与积分抵现
		$use_integral_enabled = trim($_POST['use_integral_enabled']);
		if ($use_integral_enabled == 'close') {
			$use_integral = $use_integral_enabled;
		} else{
			$use_integral_select = trim($_POST['use_integral_select']);
			if ($use_integral_select == 'nolimit') {
				$use_integral = $use_integral_select;
			} else{
				if (!empty($_POST['integral_keyword'])) {
					$use_integral = $_POST['integral_keyword'];
				}else{
					return $this->showmessage(__('设置最大可用积分数', 'quickpay'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			}
		}
		$data = array(
			'store_id'		=> $store_id,
			'title'      	=> $title,
			'description'	=> $description,
			'activity_type' => $_POST['activity_type'],
			'activity_value'	=> $activity_value,	
				
			'limit_time_type'	=> $limit_time_type,
			'limit_time_weekly'	=> $limit_time_weekly,
			'limit_time_daily'	=> $limit_time_daily,	
			'limit_time_exclude'=> $limit_time_exclude,	
				
			'start_time'	=> $start_time,
			'end_time'		=> $end_time,
					
			'use_bonus'		=> $use_bonus,
			'use_integral'	=> $use_integral,
			
			'enabled' 		=> intval($_POST['enabled']),
		);
		
		ecjia_merchant::admin_log($title, 'add', 'quickpay');
		
		$id = RC_DB::table('quickpay_activity')->insertGetId($data);
		return $this->showmessage(__('添加优惠买单规则成功', 'quickpay'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('quickpay/merchant/edit', array('id' => $id))));
	}
	
	/**
	 * 编辑买单活动页面
	 */
	public function edit() {
		$this->admin_priv('quickpay_update');

		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑优惠买单规则', 'quickpay')));
		$this->assign('ur_here', __('编辑优惠买单规则', 'quickpay'));
		$this->assign('action_link', array('text' => '优惠买单规则列表', 'href' => RC_Uri::url('quickpay/merchant/init')));
		
		$type_list = $this->get_quickpay_type();
		$this->assign('type_list', $type_list);
		
		$week_list = $this->get_week_list();
		$this->assign('week_list', $week_list);
		
		$id = intval($_GET['id']);
		$data = RC_DB::table('quickpay_activity')->where('id', $id)->first();
		
		$data['start_time']   = RC_Time::local_date('Y-m-d', $data ['start_time']);
		$data['end_time']     = RC_Time::local_date('Y-m-d', $data ['end_time']);
		
		//买单活动参数处理
		if (strpos($data['activity_value'],',') !== false){
			$data['activity_value']  = explode(",",$data['activity_value']);
		}

		//具体时间处理
		$data['limit_time_weekly']  = Ecjia\App\Quickpay\Weekly::weeks($data['limit_time_weekly']);
		$data['limit_time_daily']   = unserialize($data['limit_time_daily']);
		$data['limit_time_exclude'] = explode(",", $data['limit_time_exclude']);
		
		//红包处理
		if ($data['use_bonus'] != 'close' && $data['use_bonus'] != 'nolimit') {
			$data['use_bonus'] = explode(',', $data['use_bonus']);
			$use_bonus = RC_DB::table('bonus_type')
			->whereIn('type_id', $data['use_bonus'])
			->select(RC_DB::raw('type_id'), RC_DB::raw('type_name'))
			->get();
			$this->assign('act_range_ext', $use_bonus);
		}
		$this->assign('data', $data);

		$this->assign('form_action', RC_Uri::url('quickpay/merchant/update'));

		$this->display('quickpay_info.dwt');
	}
	
	/**
	 * 编辑买单活动处理
	 */
	public function update() {
		$this->admin_priv('mh_quickpay_update');
		
		$store_id = $_SESSION['store_id'];
		$id = intval($_POST['id']);
		$title    = trim($_POST['title']);
		$description = trim($_POST['description']);

		if (RC_DB::table('quickpay_activity')->where('title', $title)->where('store_id', $store_id)->where('id', '!=', $id)->count() > 0) {
			return $this->showmessage(__('当前店铺下已存在该买单标题', 'quickpay'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		$start_time = RC_Time::local_strtotime($_POST['start_time']);
		$end_time   = RC_Time::local_strtotime($_POST['end_time']);
		
		if ($start_time >= $end_time) {
			return $this->showmessage(__('开始时间不能大于或等于结束时间', 'quickpay'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		//相对应的买单优惠类型活动参数处理
		$activity_discount_value = $_POST['activity_discount_value'];
		if (!empty($activity_discount_value)) {
			$activity_value = $activity_discount_value;
		} else {
			if (is_array($_POST['activity_value'])) {
				foreach($_POST['activity_value'] as $row){
					if (empty($row)){
						return $this->showmessage(_('活动参数不能为空', 'quickpay'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
					}
				}
				$activity_value = implode(",", $_POST['activity_value']);
			}
		}

		//时间规则处理
		$limit_time_type = trim($_POST['limit_time_type']);//限制时间类型类型
		$limit_time_weekly = 0;
		if ($limit_time_type == 'customize') {
			//每周星期0x1111111代表7天
			if (!empty($_POST['limit_time_weekly'])){
				$limit_time_weekly = Ecjia\App\Quickpay\Weekly::weeklySelected($_POST['limit_time_weekly']);
			}
				
			//每天时间段
			$time_quantum = array();
			foreach ($_POST['start_ship_time'] as $k => $v) {
				$time_quantum[$k]['start']	= $v;
				$time_quantum[$k]['end']	= $_POST['end_ship_time'][$k];
			}
			$limit_time_daily = serialize($time_quantum);
				
			//排除日期
			$limit_time_exclude_data = $_POST['limit_time_exclude'];
			$limit_time_exclude = implode(",", $limit_time_exclude_data);
		} 
		
		//是否可参与红包抵现
		$use_bonus_enabled = trim($_POST['use_bonus_enabled']);
		if ($use_bonus_enabled == 'close') {
			$use_bonus = $use_bonus_enabled;
		} else{
			$use_bonus_select = trim($_POST['use_bonus_select']);
			if ($use_bonus_select == 'nolimit') {
				$use_bonus = $use_bonus_select;
			} else{
				if (!empty($_POST['act_range_ext'])) {
					$use_bonus = implode(",", $_POST['act_range_ext']);
				}else{
					return $this->showmessage(__('请选择您要指定的红包项', 'quickpay'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			}
		}
		
		
		//是否可参与积分抵现
		$use_integral_enabled = trim($_POST['use_integral_enabled']);
		if ($use_integral_enabled == 'close') {
			$use_integral = $use_integral_enabled;
		} else{
			$use_integral_select = trim($_POST['use_integral_select']);
			if ($use_integral_select == 'nolimit') {
				$use_integral = $use_integral_select;
			} else{
				if (!empty($_POST['integral_keyword'])) {
					$use_integral = $_POST['integral_keyword'];
				}else{
					return $this->showmessage(__('设置最大可用积分数', 'quickpay'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			}
		}
		
		$data = array(
			'title'      	=> $title,
			'description'	=> $description,
			'activity_type' => $_POST['activity_type'],
			'activity_value'=> $activity_value,	
				
			'limit_time_type'	=> $limit_time_type,
			'limit_time_weekly'	=> $limit_time_weekly,
			'limit_time_daily'	=> $limit_time_daily,	
			'limit_time_exclude'=> $limit_time_exclude,	
				
			'start_time'	=> $start_time,
			'end_time'		=> $end_time,		
				
			'use_integral'	=> $use_integral,
			'use_bonus'		=> $use_bonus,	
				
			'enabled' 		=> intval($_POST['enabled']),
		);
		ecjia_merchant::admin_log($title, 'edit', 'quickpay');
		
		RC_DB::table('quickpay_activity')->where('id', $id)->update($data);
		return $this->showmessage(__('编辑优惠买单规则成功', 'quickpay'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('quickpay/merchant/edit', array('id' => $id))));
	}
	
	/**
	 * 删除买单活动
	 */
	public function remove() {
    	$this->admin_priv('mh_quickpay_delete');
    	 
    	$id = intval($_GET['id']);
    	$title = RC_DB::table('quickpay_activity')->where('id', $id)->pluck('title');
    	
    	RC_DB::table('quickpay_activity')->where('id', $id)->delete();
    	
    	ecjia_merchant::admin_log($title, 'remove', 'quickpay');
    	 
    	return $this->showmessage(__('成功删除该优惠买单规则', 'quickpay'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }
    
    /**
     * 搜索红包
     */
    public function search() {
    	$this->admin_priv('mh_quickpay_manage');
    
    	$keyword = trim($_POST['keyword']);
    	$db_bonus = RC_DB::table('bonus_type')->where('store_id', $_SESSION['store_id'])->select(RC_DB::raw('type_id'), RC_DB::raw('type_name'));
    	if (!empty($keyword)) {
    		$db_bonus->where('type_name', 'like', '%'.mysql_like_quote($keyword).'%');
    	}
    	$arr = $db_bonus->get();
    	if (empty($arr)) {
    		$arr = array(
    			0 => array(
		    		'type_id'   => 0,
		    		'type_name' => __('没有找到相应的红包记录，请重新搜索', 'quickpay')
    			)
    		);
    	}
    	return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $arr));
    }
	
	/**
	 * 获取优惠买单规则列表
	 */
	private function quickpay_list($store_id) {
		$db_quickpay_activity = RC_DB::table('quickpay_activity');

		$filter['keywords'] = empty($_GET['keywords']) ? '' : trim($_GET['keywords']);
		if ($filter['keywords']) {
			$db_quickpay_activity->where('title', 'like', '%'.mysql_like_quote($filter['keywords']).'%');
		}
		$filter['activity_type'] = empty($_GET['activity_type']) ? '' : trim($_GET['activity_type']);
		if ($filter['activity_type']) {
			$db_quickpay_activity->where('activity_type', $filter['activity_type']);
		}
		
		$db_quickpay_activity->where('store_id', $store_id);
		
		$count = $db_quickpay_activity->count();
		$page = new ecjia_merchant_page($count,10, 5);
		$data = $db_quickpay_activity
    		->select(RC_DB::raw('id,title,activity_type,start_time,end_time'))
    		->orderby('id', 'asc')
    		->take(10)
    		->skip($page->start_id-1)
    		->get();
		$res = array();
		if (!empty($data)) {
			foreach ($data as $row) {
				$row['start_time'] = RC_Time::local_date(ecjia::config('date_format'), $row['start_time']);
				$row['end_time'] = RC_Time::local_date(ecjia::config('date_format'), $row['end_time']);
				$res[] = $row;
			}
		}

		return array('list' => $res, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc());
	}
	
	
	/**
	 * 获取买单优惠类型
	 */
	private function get_quickpay_type(){
		$type_list = array(
			'discount'	=> __('价格折扣', 'quickpay'),
			'reduced'   => __('满多少减多少', 'quickpay'),
			'everyreduced' 	 => __('每满多少减多少,最高减多少', 'quickpay'),
		);
		return $type_list;
	}
	
	/**
	 * 获取周
	 */
	private function get_week_list(){//TODO语言包翻译
		$week_list = array(
			'星期一'	=> Ecjia\App\Quickpay\Weekly::Monday,
			'星期二'	=> Ecjia\App\Quickpay\Weekly::Tuesday,
			'星期三'	=> Ecjia\App\Quickpay\Weekly::Wednesday,
			'星期四' => Ecjia\App\Quickpay\Weekly::Thursday,
			'星期五' => Ecjia\App\Quickpay\Weekly::Friday,
			'星期六' => Ecjia\App\Quickpay\Weekly::Saturday,
			'星期日' => Ecjia\App\Quickpay\Weekly::Sunday,
		);
		return $week_list;
	}
}

//end