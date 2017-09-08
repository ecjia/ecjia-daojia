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
 * ECJIA自定义菜单
 */
class admin_menus extends ecjia_admin {
	private $db_menu;
	private $db_platform_account;

	public function __construct() {
		parent::__construct();
		
		RC_Lang::load('wechat');
		RC_Loader::load_app_func('global');
		assign_adminlog_content();

		$this->db_menu = RC_Loader::load_app_model('wechat_menu_model');
		$this->db_platform_account = RC_Loader::load_app_model('platform_account_model', 'platform');
		RC_Loader::load_app_class('platform_account', 'platform', false);
		RC_Loader::load_app_class('wechat_method', 'wechat', false);

		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('wechat_menus', RC_App::apps_url('statics/js/wechat_menus.js', __FILE__), array(), false, true);
		
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js') );
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		
		RC_Script::localize_script('wechat_menus', 'js_lang', RC_Lang::get('wechat::wechat.js_lang'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.wechat_menu'), RC_Uri::url('wechat/admin_menus/init')));
	}

	/**
	 * 微信菜单页面
	 */
	public function init() {
		$this->admin_priv('wechat_menus_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.wechat_menu')));
		$this->assign('ur_here', RC_Lang::get('wechat::wechat.wechat_menu_list'));
		$this->assign('action_link', array('text' => RC_Lang::get('wechat::wechat.add_wechat_menu'), 'href'=> RC_Uri::url('wechat/admin_menus/add')));
	
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('wechat::wechat.overview'),
			'content'	=> '<p>' . RC_Lang::get('wechat::wechat.wechat_menu_content') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('wechat::wechat.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:自定义菜单#.E8.87.AA.E5.AE.9A.E4.B9.89.E8.8F.9C.E5.8D.95" target="_blank">'.RC_Lang::get('wechat::wechat.wechat_menu_help').'</a>') . '</p>'
		);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();

		if (is_ecjia_error($wechat_id)) {
			$this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
		} else {
			$this->assign('warn', 'warn');
			
			$type = $this->db_platform_account->where(array('id' => $wechat_id))->get_field('type');
			$this->assign('type', $type);
			$this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.notice_subscribe_nonsupport'), RC_Lang::get('wechat::wechat.wechat_type.'.$type)));
			
			$listdb = $this->get_menuslist();
			$this->assign('listdb', $listdb);
		}
		
		$this->assign_lang();
		$this->display('wechat_menus_list.dwt');
	}
	
	/**
	 * 添加菜单页面
	 */
	public function add() {
		$this->admin_priv('wechat_menus_add');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.add_wechat_menu')));
		$this->assign('ur_here', RC_Lang::get('wechat::wechat.add_wechat_menu'));
		$this->assign('action_link', array('href' => RC_Uri::url('wechat/admin_menus/init'), 'text' => RC_Lang::get('wechat::wechat.wechat_menu_list')));

		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('wechat::wechat.overview'),
			'content'	=> '<p>' . RC_Lang::get('wechat::wechat.wechat_menu_add_content') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('wechat::wechat.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:自定义菜单#.E6.B7.BB.E5.8A.A0.E5.BE.AE.E4.BF.A1.E8.8F.9C.E5.8D.95" target="_blank">'.RC_Lang::get('wechat::wechat.wechat_menu_add_help').'</a>') . '</p>'
		);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		if (is_ecjia_error($wechat_id)) {
			$this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
		} else {
			$this->assign('warn', 'warn');
			$type = $this->db_platform_account->where(array('id' => $wechat_id))->get_field('type');
			$this->assign('type', $type);
			$this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.notice_subscribe_nonsupport'), RC_Lang::get('wechat::wechat.wechat_type.'.$type)));
			
			$pmenu = $this->db_menu->where(array('pid' => 0, 'wechat_id' => $wechat_id))->select();
			$this->assign('pmenu', $pmenu);
			
			$wechatmenus['type'] 	= 'click';
			$wechatmenus['status'] 	= 0;
			$this->assign('wechatmenus', $wechatmenus);
			
			$weapplist = $this->get_weapplist();
			$this->assign('weapplist', $weapplist);
			
			$this->assign('form_action', RC_Uri::url('wechat/admin_menus/insert'));
		}
		
		$this->assign_lang();
		$this->display('wechat_menus_edit.dwt');
	}
	
	/**
	 * 添加菜单处理
	 */
	public function insert() {
		$this->admin_priv('wechat_menus_add');
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$pid	= !empty($_POST['pid'])		? intval($_POST['pid']) : 0	;
		$name 	= !empty($_POST['name']) 	? trim($_POST['name']) 	: '';
		
		$type 	= !empty($_POST['type']) 	? $_POST['type'] 		: '';
		$key	= !empty($_POST['key']) 	? $_POST['key'] 		: '';
		$web_url= !empty($_POST['url']) 	? $_POST['url'] 		: '';
				
		$status = !empty($_POST['status']) 	? intval($_POST['status']) 	: 0;
		$sort 	= !empty($_POST['sort']) 	? intval($_POST['sort']) 	: 0;

		if (empty($name)) {
			return $this->showmessage('菜单名称不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if ($type == 'click') {
			if (empty($key)) {
				return $this->showmessage('当菜单类型为click时，菜单关键词不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		} elseif ($type == 'view') {
			if (empty($web_url)) {
				return $this->showmessage('当菜单类型为view 时，外链url不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} else {
				$url = $web_url;
			}
		} else {
			//小程序配置信息
			$h5_url = RC_Uri::home_url().'/sites/m/';
			$weapp_appid = $_POST['weapp_appid'];
			if(empty($weapp_appid)) {
				return $this->showmessage('请选择小程序', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} else {
				$miniprogram_config = array(
					'url'      => $h5_url,
					'appid'    => $weapp_appid,
					'pagepath' => 'pages/ecjia-store/ecjia'
				);
				$url = serialize($miniprogram_config);
			}
		}
		
		$data = array(
			'wechat_id'	=> $wechat_id,
			'pid'		=>	$pid,
		    'name'		=>	$name,
		    'type'		=>	$type,
			'key'		=>	$key,
			'url'		=>	$url,
			'status'	=>	$status,
			'sort'		=>	$sort,
		);
		$id = $this->db_menu->insert($data);
		ecjia_admin::admin_log($_POST['name'], 'add', 'menu');
		
		return $this->showmessage(RC_Lang::get('wechat::wechat.add_menu_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/admin_menus/edit', array('id' => $id))));
	}
	
	/**
	 * 编辑菜单页面
	 */
	public function edit() {
		$this->admin_priv('wechat_menus_update');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.edit_wechat_menu')));
		$this->assign('ur_here', RC_Lang::get('wechat::wechat.edit_wechat_menu'));
		$this->assign('action_link', array('href' => RC_Uri::url('wechat/admin_menus/init'), 'text' => RC_Lang::get('wechat::wechat.wechat_menu_list')));
		
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('wechat::wechat.overview'),
			'content'	=> '<p>' . RC_Lang::get('wechat::wechat.wechat_menu_edit_content') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('wechat::wechat.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:自定义菜单#.E7.BC.96.E8.BE.91.E5.BE.AE.E4.BF.A1.E8.8F.9C.E5.8D.95" target="_blank">'.RC_Lang::get('wechat::wechat.wechat_menu_edit_help').'</a>') . '</p>'
		);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$type = $this->db_platform_account->where(array('id' => $wechat_id))->get_field('type');
		$this->assign('type', $type);
		$this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.notice_subscribe_nonsupport'), RC_Lang::get('wechat::wechat.wechat_type.'.$type)));

	    $id = intval($_GET['id']);
	  	$wechatmenus = $this->db_menu->find(array('id' => $id));
	  	if ($wechatmenus['type'] == 'miniprogram') {
	  		$config_url = unserialize($wechatmenus['url']);
	  		$wechatmenus['app_id'] = $config_url['appid'];
	  	}
		$this->assign('wechatmenus', $wechatmenus);
	
		
		$where['pid'] = 0;
		$where[] = "id <> $id";
		$where['wechat_id'] = $wechat_id;
		
		$pmenu = $this->db_menu->where($where)->select();
		$this->assign('pmenu', $pmenu);
		
		$child = $this->db_menu->where(array('id' => $id))->get_field('pid');
		$this->assign('child', $child);
		
		$weapplist = $this->get_weapplist();
		$this->assign('weapplist', $weapplist);
		
		$this->assign('form_action', RC_Uri::url('wechat/admin_menus/update'));
	
		$this->assign_lang();
		$this->display('wechat_menus_edit.dwt');
	}
	
	/**
	 * 编辑菜单处理
	 */
	public function update() {
		$this->admin_priv('wechat_menus_update', ecjia::MSGTYPE_JSON);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$menu_id = !empty($_POST['menu_id']) ? intval($_POST['menu_id']) 	: 0;

		$pid	= !empty($_POST['pid'])		? intval($_POST['pid']) : 0	;
		$name 	= !empty($_POST['name']) 	? trim($_POST['name']) 	: '';
		
		$type 	= !empty($_POST['type']) 	? $_POST['type'] 		: '';
		$key	= !empty($_POST['key']) 	? $_POST['key'] 		: '';
		$web_url= !empty($_POST['url']) 	? $_POST['url'] 		: '';
		
		$status = !empty($_POST['status']) 	? intval($_POST['status']) 	: 0;
		$sort 	= !empty($_POST['sort']) 	? intval($_POST['sort']) 	: 0;
		
		
		if (empty($name)) {
			return $this->showmessage('菜单名称不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if ($type == 'click') {
			if (empty($key)) {
				return $this->showmessage('当菜单类型为click时，菜单关键词不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		} elseif ($type == 'view') {
			if (empty($web_url)) {
				return $this->showmessage('当菜单类型为view 时，外链url不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} else {
				$url = $web_url;
			}
		} else {
			//小程序配置信息
			$h5_url = RC_Uri::home_url().'/sites/m/';
			$weapp_appid = $_POST['weapp_appid'];
			if(empty($weapp_appid)) {
				return $this->showmessage('请选择小程序', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} else {
				$miniprogram_config = array(
					'url'      => $h5_url,
					'appid'    => $weapp_appid,
					'pagepath' => 'pages/ecjia-store/ecjia'
				);
				$url = serialize($miniprogram_config);
			}
		}
		$data = array(
			'pid'		=>	$pid,
			'name'		=>	$name,
			'type'		=>	$type,
			'key'		=>	$key,
			'url'		=>	$url,
			'status'	=>	$status,
			'sort'		=>	$sort
		);
		
		$this->db_menu->where(array('id' => $menu_id))->update($data);
		
		ecjia_admin::admin_log($name, 'edit', 'menu');
		return $this->showmessage(RC_Lang::get('wechat::wechat.edit_menu_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/admin_menus/edit', array('id' => $menu_id))));
	}
	
	
	/**
	 * 生成自定义菜单
	 */
	public function sys_menu() {
		$this->admin_priv('wechat_menus_manage', ecjia::MSGTYPE_JSON);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		if (is_ecjia_error($wechat_id)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.add_platform_first'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$list = $this->db_menu->where(array('status' => 1, 'wechat_id' => $wechat_id))->order('sort asc')->select();
			if (empty($list)) {
				return $this->showmessage(RC_Lang::get('wechat::wechat.check_menu_status'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			
			$data = array();
			if (is_array($list)) {
				foreach ($list as $val) {
					if ($val['pid'] == 0) {
						$sub_button = array();
						foreach ($list as $v) {
							if ($v['pid'] == $val['id']) {
								$sub_button[] = $v;
							}
						}
						$val['sub_button'] = $sub_button;
						$data[] = $val;
					}
				}
			}
			
			$menu = array();
			foreach ($data as $key => $val) {
				if (empty($val['sub_button'])) {
					$menu[$key]['type'] = $val['type'];
					$menu[$key]['name'] = $val['name'];
					if ($val['type'] == 'click') {
						$menu[$key]['key'] = $val['key'];
					} elseif ($val['type'] == 'view') {
						$menu[$key]['url'] = $this->html_out($val['url']);
					} else {
						$url_config = unserialize($val['url']);
						$menu[$key]['url'] 		= $this->html_out($url_config['url']);
						$menu[$key]['appid'] 	= $url_config['appid'];
						$menu[$key]['pagepath'] = $url_config['pagepath'];
					}
				} else {
					$menu[$key]['name'] = $val['name'];
					foreach ($val['sub_button'] as $k => $v) {
						$menu[$key]['sub_button'][$k]['type'] = $v['type'];
						$menu[$key]['sub_button'][$k]['name'] = $v['name'];
						if ($v['type'] == 'click') {
							$menu[$key]['sub_button'][$k]['key'] = $v['key'];
						} elseif ($v['type'] == 'view') {
							$menu[$key]['sub_button'][$k]['url'] = $this->html_out($v['url']);
						} else {
							$child_url = unserialize($v['url']);
							$menu[$key]['sub_button'][$k]['url']     = $this->html_out($child_url['url']);
							$menu[$key]['sub_button'][$k]['appid']   = $child_url['appid'];
							$menu[$key]['sub_button'][$k]['pagepath']= $child_url['pagepath'];
						}
					}
				}
			}
			
			$uuid = platform_account::getCurrentUUID('wechat');
			try {
                $wechat = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();
                $rs = $wechat->menu->add($menu);
                
                ecjia_admin::admin_log(RC_Lang::get('wechat::wechat.make_menu'), 'setup', 'menu');
                return $this->showmessage(RC_Lang::get('wechat::wechat.make_menu_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
                
			} catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
			    
			    return $this->showmessage(Ecjia\App\Wechat\ErrorCodes::getError($e->getCode()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
	}
	
	/**
	 * 获取自定义菜单
	 */
	public function get_menu() {
		$this->admin_priv('wechat_menus_manage', ecjia::MSGTYPE_JSON);
		
		$uuid = platform_account::getCurrentUUID('wechat');
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		if (is_ecjia_error($wechat_id)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.add_platform_first'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {

			try {
			    $wechat = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();
			    $list = $wechat->menu->all()->toArray();
			    $info = $this->db_menu->select();
			    if ($info) {
			        $this->db_menu->where(array('wechat_id' => $wechat_id))->delete();
			    }
			    
			    //一级菜单处理
			    foreach ($list['menu']['button'] as $key => $value) {
			        $value['type'] = isset($value['type']) ? $value['type'] : '';
			        $value['url']  = isset($value['url'])  ? $value['url'] : '';
			        $value['key']  = isset($value['key'])  ? $value['key'] : '';
			        
			        if ($value['type'] == 'view') {
			            $array = array('name' => $value['name'], 'status' => 1, 'type' => 'view', 'url' => $value['url'], 'wechat_id' => $wechat_id);
			        } elseif ($value['type'] == 'click') {
			            $array = array('name' => $value['name'], 'status' => 1, 'type' => 'click', 'key' => $value['key'], 'wechat_id'=> $wechat_id);
			        } elseif ($value['type'] == 'miniprogram')  {
			        	$config_url =array(
			        		'url'      => $value['url'],
			        		'appid'    => $value['appid'],
			        		'pagepath' => $value['pagepath']
			        	);
			        	$array = array('name' => $value['name'], 'status' => 1, 'type' => 'miniprogram', 'url' => serialize($config_url), 'wechat_id'=> $wechat_id);
			        } else {
			        	$array = array('name' => $value['name'], 'status' => 1, 'type' => $value['type'], 'url' => $value['url'], 'key' => $value['key'], 'wechat_id'=> $wechat_id);
			        }
			        
			        $id = $this->db_menu->insert($array);
			        
			        
			        //子集菜单处理
			        if ($value['sub_button']) {
			        	$data = array();
			            foreach ($value['sub_button'] as $k => $v) {
			                $v['name']   = isset($v['name']) ? $v['name'] : '';
			                $v['type']   = isset($v['type']) ? $v['type'] : '';
			                $v['url']    = isset($v['url'])  ? $v['url']  : '';
			                $v['key']    = isset($v['key'])  ? $v['key']  : '';
			                
			                if($v['type'] == 'miniprogram'){
			                	$child_url =array(
		                			'url'      => $v['url'],
		                			'appid'    => $v['appid'],
		                			'pagepath' => $v['pagepath']
			                	);
			                	$data['url'] = serialize($child_url);
			                } else {
			                	$data['url']  = $v['url'];
			                }	
			                $data['wechat_id']   = $wechat_id;
			                $data['name']        = $v['name'];
			                $data['type']        = $v['type'];
			                $data['key']         = $v['key'];
			                $data['status']      = 1;
			                $data['pid']         = $id;
			                $this->db_menu->insert($data);
			            }
			        }
			    }
			    
			    ecjia_admin::admin_log(RC_Lang::get('wechat::wechat.get_menu'), 'setup', 'menu');
			    return $this->showmessage(RC_Lang::get('wechat::wechat.get_menu_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/admin_menus/init')));
			} catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
			    
			    return $this->showmessage(Ecjia\App\Wechat\ErrorCodes::getError($e->getCode()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
	}
	
	/**
	 * 删除自定义菜单
	 */
	public function delete_menu() {
		$this->admin_priv('wechat_menus_delete', ecjia::MSGTYPE_JSON);
		
		$uuid = platform_account::getCurrentUUID('wechat');
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		if (is_ecjia_error($wechat_id)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.add_platform_first'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else { 
            
		    try {
		        $wechat = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();
		        $rs = $wechat->menu->destroy();
		        
		        ecjia_admin::admin_log(RC_Lang::get('wechat::wechat.clear_menu'), 'setup', 'menu');
		        $this->db_menu->where(array('id' => array('gt' => 0), 'wechat_id'=>$wechat_id))->update(array('status' => 0));
		        return $this->showmessage(RC_Lang::get('wechat::wechat.clear_menu_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/admin_menus/init')));
	        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
	             
	            return $this->showmessage(Ecjia\App\Wechat\ErrorCodes::getError($e->getCode()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	        }
		}
	}
	
	/**
	 * 删除菜单
	 */
	public function remove()  {
		$this->admin_priv('wechat_menus_delete', ecjia::MSGTYPE_JSON);
		
		$id = intval($_GET['id']);
		$name = $this->db_menu->where(array('id' =>$id))->get_field('name');
		$field='id, pid';
		$minfo = $this->db_menu->field($field)->find(array('id' =>$id));
		
		if ($minfo['pid'] == 0) {
			$this->db_menu->where(array('pid' =>$minfo['id']))->delete();
		}
		$this->db_menu->where(array('id' => $id))->delete();

		ecjia_admin::admin_log($name, 'remove', 'menu');
		return $this->showmessage(RC_Lang::get('wechat::wechat.remove_menu_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
		
	/**
	 * 手动排序
	 */
	public function edit_sort() {
		$this->admin_priv('wechat_menus_update', ecjia::MSGTYPE_JSON);
		
		$id    = intval($_POST['pk']);
		$sort  = trim($_POST['value']);
		$name = $this->db_menu->where(array('id' => $id))->get_field('name');
		if (!empty($sort)) {
			if (!is_numeric($sort)) {
				return $this->showmessage(RC_Lang::get('wechat::wechat.sort_numeric'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} else {
				if ($this->db_menu->where(array('id' => $id))->update(array('sort' => $sort))) {
					ecjia_admin::admin_log($name, 'edit', 'menu');
					return $this->showmessage(RC_Lang::get('wechat::wechat.edit_sort_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_uri::url('wechat/admin_menus/init')) );
				}
			}
		} else {
			return $this->showmessage(RC_Lang::get('wechat::wechat.menu_sort_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	
	/**
	 * 切换是否显示
	 */
	public function toggle_show() {
		$this->admin_priv('wechat_menus_update', ecjia::MSGTYPE_JSON);
	
		$id     = intval($_POST['id']);
		$val    = intval($_POST['val']);
		$this->db_menu->where(array('id' => $id))->update(array('status' => $val));
	
		return $this->showmessage(RC_Lang::get('wechat::wechat.switch_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_uri::url('wechat/admin_menus/init')));
	}
	
	/**
	 * 取得菜单信息
	 */
	private function get_menuslist() {
		$db_menu = RC_Loader::load_app_model('wechat_menu_model');
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$list = $db_menu->order('sort asc')->where(array('wechat_id' => $wechat_id))->select();
		$result = array();
		
		if (!empty($list)) {
			foreach ($list as $vo) {
				if ($vo['type'] == 'miniprogram') {
					$config_url = unserialize($vo['url']);
					$vo['url'] = $config_url['pagepath'];
				}
				if ($vo['pid'] == 0) {
					$sub_button = array();
					foreach ($list as $val) {
						
						if ($vo['id'] == $val['pid']) {
							if ($val['type'] == 'miniprogram') {
								$child_url = unserialize($val['url']);
								$val['url'] = $child_url['pagepath'];
							}
							$sub_button[] = $val;
						}
					}
					$vo['sub_button'] = $sub_button;
					$result[] = $vo;
				}
			}
		}
		
		return array ('menu_list' => $result);
	}
	
	
	/**
	 * 取得小程序
	 */
	private function get_weapplist() {
		$data = RC_DB::table('platform_account')->where('platform','weapp')->select('appid','name')->get();
		$list = array();
		if (!empty($data)) {
			foreach ($data as $row) {
				$list[$row['appid']] = $row['name'];
			}
		}
		return $list;
	}
	
	/**
	 * html代码输出
	 * @param unknown $str
	 * @return string
	 */
	private function html_out($str) {
		if (function_exists('htmlspecialchars_decode')) {
			$str = htmlspecialchars_decode($str);
		} else {
			$str = html_entity_decode($str);
		}
		$str = stripslashes($str);
		return $str;
	}
}

//end