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
 * 后台推荐设置
 * @author wutifang
 */
class admin extends ecjia_admin {
	private $db_shop_config;
	public function __construct() {
		parent::__construct();
		
		$this->db_shop_config = RC_Loader::load_app_model('affiliate_shop_config_model');
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		/* 加载所有全局 js/css */
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		
		RC_Script::enqueue_script('bootstrap-editable-script', RC_Uri::admin_url() . '/statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js', array(), false, true);
		RC_Style::enqueue_style('bootstrap-editable-css', RC_Uri::admin_url() . '/statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css');
		RC_Script::enqueue_script('affiliate', RC_App::apps_url('statics/js/affiliate.js', __FILE__));
		
		$js_lang = array(
			'ok'		=> RC_Lang::get('affiliate::affiliate.ok'),
			'cancel'	=> RC_Lang::get('affiliate::affiliate.cancel'),
		);
		RC_Script::localize_script('affiliate', 'js_lang', $js_lang);
	}
	
	/**
	 * 推荐设置
	 */
	public function init() {
		$this->admin_priv('affiliate_percent_manage');
		
		RC_Style::enqueue_style('affiliate-css', RC_App::apps_url('statics/css/affiliate.css', __FILE__));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('affiliate::affiliate.affiliate_percent_list')));
		
		$this->assign('ur_here', RC_Lang::get('affiliate::affiliate.affiliate_percent_list'));
		
		$config = unserialize(ecjia::config('affiliate'));

		if (count($config['item']) < 5) {
			$this->assign('add_percent', array('href' => RC_Uri::url('affiliate/admin/add'), 'text' => RC_Lang::get('affiliate::affiliate.add_affiliate_percent')));
		}
		
		$this->assign('config', $config);
		$this->assign('form_action', RC_Uri::url('affiliate/admin/update'));
		
		$this->display('affiliate_list.dwt');
	}
	
	public function add() {
		$this->admin_priv('affiliate_percent_manage');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('affiliate::affiliate.add_affiliate_percent')));
		
		$this->assign('ur_here', RC_Lang::get('affiliate::affiliate.add_affiliate_percent'));
		$this->assign('action_link', array('href' =>RC_Uri::url('affiliate/admin/init'), 'text' => RC_Lang::get('affiliate::affiliate.affiliate_percent_list')));
		$config = unserialize(ecjia::config('affiliate'));
		
		if (count($config['item']) >= 5) {
			return $this->showmessage(RC_Lang::get('affiliate::affiliate.level_error'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
			
		}
		
		$this->assign('level', count($config['item'])+1);
		
		$this->assign('form_action', RC_Uri::url('affiliate/admin/insert'));
		$this->display('affiliate_info.dwt');
	}
	
	/**
	 * 增加下线分配方案
	 */
	public function insert() {
		$this->admin_priv('affiliate_percent_update', ecjia::MSGTYPE_JSON);
		
		//检查输入值是否正确
		if (empty($_POST['level_point'])) {
			return $this->showmessage(RC_Lang::get('affiliate::affiliate.level_point_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			if (substr($_POST['level_point'], -1, 1) == '%') {
				$intval = substr($_POST['level_point'], 0, strlen($_POST['level_point'])-1);
				if (!preg_match("/^[0-9]+$/", $intval)) {
					return $this->showmessage(RC_Lang::get('affiliate::affiliate.level_point_wrong'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			} elseif (!preg_match("/^[0-9]+$/", $_POST['level_point'])) {
				return $this->showmessage(RC_Lang::get('affiliate::affiliate.level_point_wrong'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		
		if (empty($_POST['level_money'])) {
			return $this->showmessage(RC_Lang::get('affiliate::affiliate.level_money_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			if (substr($_POST['level_money'], -1, 1) == '%') {
				$intval = substr($_POST['level_money'], 0, strlen($_POST['level_money'])-1);
				if (!preg_match("/^[0-9]+$/", $intval)) {
					return $this->showmessage(RC_Lang::get('affiliate::affiliate.level_money_wrong'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			} elseif (!preg_match("/^[0-9]+$/", $_POST['level_money'])) {
				return $this->showmessage(RC_Lang::get('affiliate::affiliate.level_money_wrong'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		
		$config = unserialize(ecjia::config('affiliate'));
		//下线不能超过5层
		if (count($config['item']) < 5) {
			$_POST['level_point'] = (float)$_POST['level_point'];
			$_POST['level_money'] = (float)$_POST['level_money'];
			$maxpoint = $maxmoney = 100;
			foreach ($config['item'] as $key => $val) {
				$maxpoint -= $val['level_point'];
				$maxmoney -= $val['level_money'];
			}
			$_POST['level_point'] > $maxpoint && $_POST['level_point'] = $maxpoint;
			$_POST['level_money'] > $maxmoney && $_POST['level_money'] = $maxmoney;
// 			if (!empty($_POST['level_point']) && strpos($_POST['level_point'], '%') === false) {
				$_POST['level_point'] .= '%';
// 			}
// 			if (!empty($_POST['level_money']) && strpos($_POST['level_money'], '%') === false) {
				$_POST['level_money'] .= '%';
// 			}
			$items = array('level_point' => $_POST['level_point'], 'level_money' => $_POST['level_money']);
			$config['item'][] = $items;
			$config['on'] = 1;
			$config['config']['separate_by'] = 0;
			
			ecjia_config::instance()->write_config('affiliate', serialize($config));
			ecjia_admin::admin_log(RC_Lang::get('affiliate::affiliate.level_point_is').$_POST['level_point'].'，'.RC_Lang::get('affiliate::affiliate.level_money_is').$_POST['level_money'], 'add', 'affiliate_percent');
			
			return $this->showmessage(RC_Lang::get('affiliate::affiliate.add_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('affiliate/admin/init')));
			
		} else {
			return $this->showmessage(RC_Lang::get('affiliate::affiliate.level_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 编辑分成比例
	 */
	public function edit() {
		$this->admin_priv('affiliate_percent_manage');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('affiliate::affiliate.update_affiliate_percent')));
		
		$this->assign('ur_here', RC_Lang::get('affiliate::affiliate.update_affiliate_percent'));
		$this->assign('action_link', array('href' =>RC_Uri::url('affiliate/admin/init'), 'text' => RC_Lang::get('affiliate::affiliate.affiliate_percent_list')));
		$config = unserialize(ecjia::config('affiliate'));

		$id = intval($_GET['id']);
		$this->assign('level', $id);
		
		$config['item'][$id-1]['level_point'] = str_replace('%', '', $config['item'][$id-1]['level_point']);
		$config['item'][$id-1]['level_money'] = str_replace('%', '', $config['item'][$id-1]['level_money']);
		$this->assign('affiliate_percent', $config['item'][$id-1]);
		
		$this->assign('form_action', RC_Uri::url('affiliate/admin/update'));
		$this->display('affiliate_info.dwt');
	}
	
	
	/**
	 * 编辑分成比例处理
	 */
	public function update() {
		$this->admin_priv('affiliate_percent_update', ecjia::MSGTYPE_JSON);

		//检查输入值是否正确
		if (empty($_POST['level_point'])) {
			return $this->showmessage(RC_Lang::get('affiliate::affiliate.level_point_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			if (substr($_POST['level_point'], -1, 1) == '%') {
				$intval = substr($_POST['level_point'], 0, strlen($_POST['level_point'])-1);
				if (!preg_match("/^[0-9]+$/", $intval)) {
					return $this->showmessage(RC_Lang::get('affiliate::affiliate.level_point_wrong'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			} elseif (!preg_match("/^[0-9]+$/", $_POST['level_point'])) {
				return $this->showmessage(RC_Lang::get('affiliate::affiliate.level_point_wrong'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		
		if (empty($_POST['level_money'])) {
			return $this->showmessage(RC_Lang::get('affiliate::affiliate.level_money_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			if (substr($_POST['level_money'], -1, 1) == '%') {
				$intval = substr($_POST['level_money'], 0, strlen($_POST['level_money'])-1);
				if (!preg_match("/^[0-9]+$/", $intval)) {
					return $this->showmessage(RC_Lang::get('affiliate::affiliate.level_money_wrong'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			} elseif (!preg_match("/^[0-9]+$/", $_POST['level_money'])) {
				return $this->showmessage(RC_Lang::get('affiliate::affiliate.level_money_wrong'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		
		//读取分成配置
		$config = unserialize(ecjia::config('affiliate'));
		
		$key = intval($_POST['id'])-1;
		$level_point = (float)trim($_POST['level_point']);
		$level_money = (float)trim($_POST['level_money']);
		
		$maxpoint = $maxmoney = 100;
		foreach ($config['item'] as $k => $v) {
			if ($k != $key) {
				$maxpoint -= $v['level_point'];
				$maxmoney -= $v['level_money'];
			}
		}

		$level_point > $maxpoint && $level_point = $maxpoint;
		$level_money > $maxmoney && $level_money = $maxmoney;
		
		if (!empty($level_point) && strpos($level_point,'%') === false) {
			$level_point .= '%';
		}
		if (!empty($level_money) && strpos($level_money,'%') === false) {
			$level_money .= '%';
		}
		
		$config['item'][$key]['level_point'] = $level_point;
		$config['item'][$key]['level_money'] = $level_money;
		
		ecjia_config::instance()->write_config('affiliate', serialize($config));
		ecjia_admin::admin_log(RC_Lang::get('affiliate::affiliate.level_point_is').$level_point.'，'.RC_Lang::get('affiliate::affiliate.level_money_is').$level_money, 'edit', 'affiliate_percent');
		
		return $this->showmessage(RC_Lang::get('affiliate::affiliate.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('affiliate/admin/init')));
	}
	
	/**
	 * 编辑积分分成百分比
	 */
	public function edit_point() {
		$this->admin_priv('affiliate_percent_update', ecjia::MSGTYPE_JSON);
		
		$config = unserialize(ecjia::config('affiliate'));
		/* 取得参数 */
		$key = trim($_POST['pk']) - 1;
		$val = (float)trim($_POST['value']);
		
		//检查输入值是否正确
		if (empty($_POST['value']) && $val != 0) {
			return $this->showmessage(RC_Lang::get('affiliate::affiliate.level_point_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			if (substr($_POST['value'], -1, 1) == '%') {
				$intval = substr($_POST['value'], 0, strlen($_POST['value'])-1);
				if (!preg_match("/^[0-9]+$/", $intval)) {
					return $this->showmessage(RC_Lang::get('affiliate::affiliate.level_point_wrong'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			} elseif (!preg_match("/^[0-9]+$/", $_POST['value'])) {
				return $this->showmessage(RC_Lang::get('affiliate::affiliate.level_point_wrong'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		
		if (empty($val)) {
			$val = 0;
		}
		$maxpoint = 100;
		foreach ($config['item'] as $k => $v) {
			if ($k != $key) {
				$maxpoint -= $v['level_point'];
			}
		}
		
		$val > $maxpoint && $val = $maxpoint;
		if (!empty($val) && strpos($val, '%') === false) {
			$val .= '%';
		}
		$config['item'][$key]['level_point'] = $val;
		$config['on'] = 1;
		
		ecjia_config::instance()->write_config('affiliate', serialize($config));
		
		ecjia_admin::admin_log(RC_Lang::get('affiliate::affiliate.level_point_is').$val, 'edit', 'affiliate_percent');
		return $this->showmessage(RC_Lang::get('affiliate::affiliate.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $val, 'pjaxurl' => RC_Uri::url('affiliate/admin/init')));
	}
	
	/**
	 * 编辑现金分成百分比
	 */
	public function edit_money() {
		$this->admin_priv('affiliate_percent_update', ecjia::MSGTYPE_JSON);
		
		$config = unserialize(ecjia::config('affiliate'));
		$key = trim($_POST['pk']) - 1;
		$val = (float)trim($_POST['value']);
		
		//检查输入值是否正确
		if (empty($_POST['value']) && $val != 0) {
			return $this->showmessage(RC_Lang::get('affiliate::affiliate.level_money_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			if (substr($_POST['value'], -1, 1) == '%') {
				$intval = substr($_POST['value'], 0, strlen($_POST['value'])-1);
				if (!preg_match("/^[0-9]+$/", $intval)) {
					return $this->showmessage(RC_Lang::get('affiliate::affiliate.level_money_wrong'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			} elseif (!preg_match("/^[0-9]+$/", $_POST['value'])) {
				return $this->showmessage(RC_Lang::get('affiliate::affiliate.level_money_wrong'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		
		if (empty($val)) {
			$val = 0;
		}
		$maxmoney = 100;
		foreach ($config['item'] as $k => $v) {
			if ($k != $key) {
				$maxmoney -= $v['level_money'];
			}
		}
		$val > $maxmoney && $val = $maxmoney;
		if (!empty($val) && strpos($val, '%') === false) {
			$val .= '%';
		}
		$config['item'][$key]['level_money'] = $val;
		$config['on'] = 1;
		
		ecjia_config::instance()->write_config('affiliate', serialize($config));
		
		ecjia_admin::admin_log(RC_Lang::get('affiliate::affiliate.level_money_is').$val, 'edit', 'affiliate_percent');
		return $this->showmessage(RC_Lang::get('affiliate::affiliate.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $val, 'pjaxurl' => RC_Uri::url('affiliate/admin/init')));
	}
	
	/**
	 * 删除分成
	 */
	public function remove() {
		$this->admin_priv('affiliate_percent_drop', ecjia::MSGTYPE_JSON);
		
		$config = unserialize(ecjia::config('affiliate'));
		$key = trim($_GET['id']) - 1;
		$info = $config['item'][$key];
		
		unset($config['item'][$key]);
		$temp = array();
		
		if (!empty($config['item'])) {
			foreach ($config['item'] as $key => $val) {
				$temp[] = $val;
			}
		}
		
		$config['item'] = $temp;
		$config['on'] = 1;
		$config['config']['separate_by'] = 0;
		
		ecjia_config::instance()->write_config('affiliate', serialize($config));
		ecjia_admin::admin_log(RC_Lang::get('affiliate::affiliate.level_point_is').$info['level_point'].'，'.RC_Lang::get('affiliate::affiliate.level_money_is').$info['level_money'], 'remove', 'affiliate_percent');
		
		return $this->showmessage(RC_Lang::get('affiliate::affiliate.remove_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}	
}

//end