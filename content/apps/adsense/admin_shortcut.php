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

class admin_shortcut extends ecjia_admin {
    
    public function __construct() {
		parent::__construct();
		
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		RC_Loader::load_app_func('global');
		assign_adminlog_contents();
		
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
			
		RC_Script::enqueue_script('shortcut', RC_App::apps_url('statics/js/shortcut.js', __FILE__));

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('快捷菜单管理', RC_Uri::url('adsense/admin_shortcut/init')));
	}
    
    /**
     * 处理菜单组
     */
    public function init() {
		$this->admin_priv('shortcut_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('快捷菜单管理'));
		$this->assign('ur_here', '快捷菜单列表');
		
		ecjia_screen::$current_screen->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('mobile::mobile.open_app_function'),
			'content'	=>
			'<p>'.RC_Lang::get('mobile::mobile.open_discover').'ecjiaopen://app?open_type=discover' .
			'<p>'.RC_Lang::get('mobile::mobile.open_qrcode').'ecjiaopen://app?open_type=qrcode</p>' .
			'<p>'.RC_Lang::get('mobile::mobile.open_qrshare').'ecjiaopen://app?open_type=qrshare</p>' .
			'<p>'.RC_Lang::get('mobile::mobile.open_history').'ecjiaopen://app?open_type=history</p>' .
			'<p>'.RC_Lang::get('mobile::mobile.open_feedback').'ecjiaopen://app?open_type=feedback</p>' .
			'<p>'.RC_Lang::get('mobile::mobile.open_map').'ecjiaopen://app?open_type=map</p>' .
			'<p>'.RC_Lang::get('mobile::mobile.open_message').'ecjiaopen://app?open_type=message</p>' .
			'<p>'.RC_Lang::get('mobile::mobile.open_search').'ecjiaopen://app?open_type=search</p>' .
			'<p>'.RC_Lang::get('mobile::mobile.open_help').'ecjiaopen://app?open_type=help</p>'
		));
		ecjia_screen::$current_screen->add_help_tab(array(
			'id'		=> 'managing-pages',
			'title'		=> RC_Lang::get('mobile::mobile.open_goods_order_user'),
			'content'	=>
			'<p>'.RC_Lang::get('mobile::mobile.open_goods_list').'ecjiaopen://app?open_type=goods_list&category_id={id}, {id}'.RC_Lang::get('mobile::mobile.is_category_id').'</p>' .
			'<p>'.RC_Lang::get('mobile::mobile.open_goods_comment').'ecjiaopen://app?open_type=goods_comment&goods_id={id}, {id}'.RC_Lang::get('mobile::mobile.is_goods_id').'</p>' .
			'<p>'.RC_Lang::get('mobile::mobile.open_goods_detail').'ecjiaopen://app?open_type=goods_detail&goods_id={id}, {id}'.RC_Lang::get('mobile::mobile.is_goods_id').'</p>' .
			'<p>'.RC_Lang::get('mobile::mobile.open_oder_list').'ecjiaopen://app?open_type=orders_list</p>' .
			'<p>'.RC_Lang::get('mobile::mobile.open_order_detail').'ecjiaopen://app?open_type=orders_detail&order_id={id}, {id}'.RC_Lang::get('mobile::mobile.is_order_id').'</p>' .
			'<p>'.RC_Lang::get('mobile::mobile.open_user_wallet').'ecjiaopen://app?open_type=user_wallet</p>' .
			'<p>'.RC_Lang::get('mobile::mobile.open_user_address').'ecjiaopen://app?open_type=user_address</p>' .
			'<p>'.RC_Lang::get('mobile::mobile.open_user_account').'ecjiaopen://app?open_type=user_account</p>' .
			'<p>'.RC_Lang::get('mobile::mobile.open_user_password').'ecjiaopen://app?open_type=user_password</p>' .
			'<p>'.RC_Lang::get('mobile::mobile.open_user_center').'ecjiaopen://app?open_type=user_center</p>'
		));
		
		//获取城市 
		$citymanage = new Ecjia\App\Adsense\CityManage('shortcut');
		
		$city_list = $citymanage->getAllCitys();
		$this->assign('city_list', $city_list);
		
		//获取当前城市ID
		$city_id = $citymanage->getCurrentCity(intval($_GET['city_id']));
		$this->assign('city_id', $city_id);

		//获取菜单组
		$position = new Ecjia\App\Adsense\PositionManage('shortcut', $city_id);
		$data = $position->getAllPositions();
		$this->assign('data', $data);

		$position_id = intval($_GET['position_id']);
		if (empty($position_id) && !empty($data)) {
		    $position_id = head($data)['position_id'];
		    $position_code = head($data)['position_code'];
		}
		$this->assign('position_id', $position_id);
		
		if ($position_id > 0) {
    		//获取投放平台
    		$ad = new Ecjia\App\Adsense\Repositories\AdRepository('shortcut');
    		$client_list = $ad->getAllClients();
    		$available_clients = $ad->getAvailableClients($position_id);
    
    		$this->assign('client_list', $client_list);
    		$this->assign('available_clients', $available_clients);

    		$show_client = intval($_GET['show_client']);
    		if (empty($show_client) && !empty($available_clients)) {
    		    $show_client = $client_list[head(array_keys($available_clients))];
    		}
    		$this->assign('show_client', $show_client);

    		//对应的快捷菜单列表
    	    $shortcut_list = $ad->getSpecialAds($position_id, $show_client);
            $this->assign('shortcut_list', $shortcut_list);
            
            $position_code = RC_DB::TABLE('ad_position')->where('position_id', $position_id)->pluck('position_code');
		}
		
		$this->assign('position_code', $position_code);
		
		$this->display('shortcut_list.dwt');
	}

    public function add_group() {
    	$this->admin_priv('shortcut_update');
    	
    	ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('添加菜单组'));
    	$this->assign('ur_here', '添加菜单组');
    	$this->assign('action_link', array('href' => RC_Uri::url('adsense/admin_shortcut/init'), 'text' => '快捷菜单设置'));
    	
    	$city_list = $this->get_select_city();
    	$this->assign('city_list', $city_list);
    	
    	$this->assign('form_action', RC_Uri::url('adsense/admin_shortcut/insert_group'));
    	
    	$this->display('shortcut_group_info.dwt');
    }
    
    
    public function insert_group() {
    	$this->admin_priv('shortcut_update');
    	
    	$position_name = !empty($_POST['position_name']) ? trim($_POST['position_name']) : '';
    	$position_code = !empty($_POST['position_code_ifnull']) ? trim($_POST['position_code_ifnull']) : '';
    	$position_desc = !empty($_POST['position_desc']) ? nl2br(htmlspecialchars($_POST['position_desc'])) : '';
    	$ad_width      = !empty($_POST['ad_width']) ? intval($_POST['ad_width']) : 0;
    	$ad_height     = !empty($_POST['ad_height']) ? intval($_POST['ad_height']) : 0;
    	$max_number    = !empty($_POST['max_number']) ? intval($_POST['max_number']) : 0;
    	$sort_order    = !empty($_POST['sort_order']) ? intval($_POST['sort_order']) : 0;
    	$city_id       = !empty($_POST['city_id']) ? intval($_POST['city_id']) : 0;
    	$city_name     = RC_DB::TABLE('region')->where('region_id', $city_id)->pluck('region_name');
    	if (!$city_name) {
    		$city_name = '默认';
    	}
    	$query = RC_DB::table('ad_position')->where('position_code', $position_code)->where('city_id', $city_id)->where('type', 'shortcut')->count();
    	if ($query > 0) {
    		return $this->showmessage('该菜单组代号在当前城市中已存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	
    	$data = array(
    		'position_name' => $position_name,
    		'position_code' => $position_code,
    		'ad_width'      => $ad_width,
    		'ad_height'     => $ad_height,
    		'max_number'    => $max_number,
    		'position_desc' => $position_desc,
    		'city_id' 		=> $city_id,
    		'city_name' 	=> $city_name,
    		'type' 			=> 'shortcut',
    		'sort_order' 	=> $sort_order,
    	);
    	$position_id = RC_DB::table('ad_position')->insertGetId($data);
    	ecjia_admin::admin_log($position_name, 'add', 'group_shortcut');
    	return $this->showmessage('添加菜单组成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('adsense/admin_shortcut/edit_group', array('position_id' => $position_id, 'city_id' => $city_id))));
    }    
    
    public function edit_group() {
    	$this->admin_priv('shortcut_update');
    	
    	ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('编辑菜单组'));
    	$this->assign('ur_here', '编辑菜单组');
        	
    	$city_id     = $_GET['city_id'];
    	$position_id = $_GET['position_id'];
    	$this->assign('action_link', array('href' => RC_Uri::url('adsense/admin_shortcut/init',array('city_id' => $city_id, 'position_id' => $position_id)), 'text' => '快捷菜单设置'));
    	$this->assign('city_id', $city_id);
    	$this->assign('position_id', $position_id);
    	
    	$city_list = $this->get_select_city();
    	$this->assign('city_list', $city_list);
   
    	$data = RC_DB::table('ad_position')->where('position_id', $position_id)->first();
    	$this->assign('data', $data);
    	
    	$this->assign('form_action', RC_Uri::url('adsense/admin_shortcut/update_group'));
    	 
    	$this->display('shortcut_group_info.dwt');
    }
    
    public function update_group() {
    	$this->admin_priv('shortcut_update');
    	 
    	$position_name = !empty($_POST['position_name']) ? trim($_POST['position_name']) : '';
    	$position_code_value = !empty($_POST['position_code_value']) ? trim($_POST['position_code_value']) : '';
    	$position_code_ifnull = !empty($_POST['position_code_ifnull']) ? trim($_POST['position_code_ifnull']) : '';
    	if (!empty($position_code_ifnull)) {
    		$position_code = $position_code_ifnull;
    	} else {
    		$position_code = $position_code_value;
    	}
    	
    	$position_desc = !empty($_POST['position_desc']) ? nl2br(htmlspecialchars($_POST['position_desc'])) : '';
    	$ad_width      = !empty($_POST['ad_width']) ? intval($_POST['ad_width']) : 0;
    	$ad_height     = !empty($_POST['ad_height']) ? intval($_POST['ad_height']) : 0;
    	$max_number    = !empty($_POST['max_number']) ? intval($_POST['max_number']) : 0;
    	$sort_order    = !empty($_POST['sort_order']) ? intval($_POST['sort_order']) : 0;
    	
    	$city_id       = intval($_POST['city_id']);
    	$city_name     = RC_DB::TABLE('region')->where('region_id', $city_id)->pluck('region_name');
    	if (!$city_name) {
    		$city_name = '默认';
    	}
    	$position_id   = intval($_POST['position_id']);
    	$query = RC_DB::table('ad_position')->where('position_code', $position_code)->where('type', 'shortcut')->where('city_id', $city_id)->where('position_id', '!=', $position_id)->count();
    	if ($query > 0) {
    		return $this->showmessage('该菜单组代号在当前城市中已存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	
    	$data = array(
    		'position_name' => $position_name,
    		'position_code' => $position_code,
    		'ad_width'      => $ad_width,
    		'ad_height'     => $ad_height,
    		'max_number'    => $max_number,
    		'position_desc' => $position_desc,
    		'city_id' 		=> $city_id,
    		'city_name' 	=> $city_name,
    		'sort_order' 	=> $sort_order,
    	);
    	
    	RC_DB::table('ad_position')->where('position_id', $position_id)->update($data);
    	ecjia_admin::admin_log($position_name, 'edit', 'group_shortcut');
    	return $this->showmessage('编辑菜单组成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('adsense/admin_shortcut/edit_group', array('position_id' => $position_id,'city_id' => $city_id))));
    }
    
    public function delete_group() {
    	$this->admin_priv('shortcut_delete');
    	
    	$position_id = intval($_GET['position_id']);
    	$position_name = RC_DB::TABLE('ad_position')->where('position_id', $position_id)->pluck('position_name');
    	$city_id = intval($_GET['city_id']);
    	if (RC_DB::table('ad')->where('position_id', $position_id)->count() > 0) {
    		return $this->showmessage('该菜单组已存在快捷菜单，暂不能删除！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	} else {
    		RC_DB::table('ad_position')->where('position_id', $position_id)->delete();
    		ecjia_admin::admin_log($position_name, 'remove', 'group_shortcut');
    		$count = RC_DB::TABLE('ad_position')->where('type', 'shortcut')->where('city_id', $city_id)->count();
    		if (!$count) {
    			return $this->showmessage('成功删除菜单组', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array('pjaxurl' => RC_Uri::url('adsense/admin_shortcut/init')));
    		} else {
    			return $this->showmessage('成功删除菜单组', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array('pjaxurl' => RC_Uri::url('adsense/admin_shortcut/init',array('city_id' => $city_id))));
    		}
    	}
    }
    
    public function copy() {
    	$this->admin_priv('shortcut_update');
    	 
    	$position_id = intval($_GET['position_id']);
    	$position_code = RC_DB::TABLE('ad_position')->where('position_id', $position_id)->pluck('position_code');
    	
    	$position_name = trim($_GET['position_name']);
    	$position_desc = $_GET['position_desc'];
    	$ad_width      = intval($_GET['ad_width']);
    	$ad_height     = intval($_GET['ad_height']);
    	$max_number    = intval($_GET['max_number']);
    	$sort_order    = intval($_GET['sort_order']);

    	$city_id = intval($_GET['city_id']);
    	$city_name = RC_DB::TABLE('region')->where('region_id', $city_id)->pluck('region_name');
    	if (!$city_name) {
    		$city_name = '默认';
    	}
    	$position_id   = intval($_POST['position_id']);
    		$query = RC_DB::table('ad_position')->where('position_code', $position_code)->where('city_id', $city_id)->where('type', 'shortcut')->count();
    	if ($query > 0) {
    		return $this->showmessage('请重新选择城市，该菜单组代号在当前城市中已存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	 
    	$data = array(
    		'position_name' => $position_name,
    		'position_code' => $position_code,
    		'position_desc' => $position_desc,
    		'ad_width'      => $ad_width,
    		'ad_height'     => $ad_height,
    		'max_number'    => $max_number,
    		'city_id' 		=> $city_id,
    		'city_name' 	=> $city_name,
    		'type' 			=> 'shortcut',
    		'sort_order' 	=> $sort_order,
    	);

    	$position_id = RC_DB::table('ad_position')->insertGetId($data);
    	ecjia_admin::admin_log($position_name, 'copy', 'group_shortcut');
    	return $this->showmessage('复制成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('adsense/admin_shortcut/edit_group', array('position_id' => $position_id, 'city_id' => $city_id))));
    }
        
    /**
     * 获取热门城市
     */
    private function get_select_city() {
    	$data = explode(',', ecjia::config('mobile_recommend_city'));
    	$data = RC_DB::table('region')->whereIn('region_id', $data)->get();
    	$regions = array ();
    	if (!empty($data)) {
    		foreach ($data as $row) {
    			$regions[$row['region_id']] = addslashes($row['region_name']);
    		}
    	}
    	return $regions;
    }
    
    /**
     * 获取平台
     */
    private function get_show_client(){
    	$client_list = array(
    		'iPhone' => Ecjia\App\Adsense\Client::IPHONE,
    		'Android'=> Ecjia\App\Adsense\Client::ANDROID,
    		'H5' 	 => Ecjia\App\Adsense\Client::H5, 
    		'PC'     => Ecjia\App\Adsense\Client::PC
    	);
    	return $client_list;
    }
    
    /**
     * 处理快捷菜单
     */
    public function add() {
    	$this->admin_priv('shortcut_update');
    	
    	$position_id = intval($_GET['position_id']);
    	$city_id = intval($_GET['city_id']);
    	$this->assign('position_id', $position_id);
    	$this->assign('city_id', $city_id);

    	ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('添加快捷菜单'));
    	$this->assign('ur_here', '添加快捷菜单');
    	$this->assign('action_link', array('href' => RC_Uri::url('adsense/admin_shortcut/init',array('position_id' => $position_id, 'city_id' => $city_id)), 'text' => '快捷菜单列表'));

    	$info = RC_DB::TABLE('ad_position')->where('position_id', $position_id)->select('ad_width', 'ad_height')->first();
    	$data['ad_width'] = $info['ad_width'];
    	$data['ad_height'] = $info['ad_height'];;
    	$data['enabled'] = 1;
		$this->assign('data', $data);
	
		$client_list = $this->get_show_client();
		$this->assign('client_list', $client_list);
		
    	$this->assign('form_action', RC_Uri::url('adsense/admin_shortcut/insert'));
    	 
    	$this->display('shortcut_info.dwt');
        
    }

    public function insert() {
    	$this->admin_priv('shortcut_update');
    	
    	$position_id   = !empty($_POST['position_id']) ? intval($_POST['position_id']) : 0;
    	$ad_name       = !empty($_POST['ad_name']) ? trim($_POST['ad_name']) : '';
    	$sort_order    = !empty($_POST['sort_order']) ? intval($_POST['sort_order']) : 0;
    	
    	if (!empty($_FILES['ad_code']['name'])) {
    		if (isset($_FILES['ad_code']['error']) && $_FILES['ad_code']['error'] == 0 || ! isset($_FILES['ad_code']['error']) && isset($_FILES['ad_code']['tmp_name']) && $_FILES['ad_code']['tmp_name'] != 'none') {
    			$upload = RC_Upload::uploader('image', array('save_path' => 'data/shortcut', 'auto_sub_dirs' => false));
    			$image_info = $upload->upload($_FILES['ad_code']);
    			if (!empty($image_info)) {
    				$ad_code = $upload->get_position($image_info);
    			} else {
    				return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    			}
    		}
    	}else{
    		return $this->showmessage('请上传快捷菜单片', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	
    	if (empty($_POST['show_client'])) {
    		return $this->showmessage('请选择投放平台', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	} else {
    		$show_client = Ecjia\App\Adsense\Client::clientSelected($_POST['show_client']);
    	}
    	
    	$data = array(
			'position_id' 	=> $position_id,
    		'ad_code' 		=> $ad_code,
    		'ad_link' 		=> $_POST['ad_link'],
			'ad_name' 		=> $ad_name,
    		'show_client'   => $show_client,
			'enabled' 		=> $_POST['enabled'],
    		'sort_order' 	=> $sort_order,
		);
    	$id = RC_DB::table('ad')->insertGetId($data);
    	ecjia_admin::admin_log($ad_name, 'add', 'shortcut');
    	$city_id = intval($_POST['city_id']);
    	return $this->showmessage('添加快捷菜单成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('adsense/admin_shortcut/edit', array('id' => $id,'city_id'=>$city_id))));
    }
    
    public function edit() {
    	$this->admin_priv('shortcut_update');
    	
    	ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('编辑快捷菜单'));
    	$this->assign('ur_here', '编辑快捷菜单');
	    	
    	$id = intval($_GET['id']);
    	$data = RC_DB::table('ad')->where('ad_id', $id)->first();
    	
    	$info = RC_DB::TABLE('ad_position')->where('position_id', $data['position_id'])->select('ad_width', 'ad_height')->first();
    	$data['ad_width'] = $info['ad_width'];
    	$data['ad_height'] = $info['ad_height'];
    	
    	$city_id = intval($_GET['city_id']);
    	$show_client = intval($_GET['show_client']);
    	$this->assign('city_id', $city_id);
    	$this->assign('show_client', $show_client);
    	
    	$this->assign('action_link', array('href' => RC_Uri::url('adsense/admin_shortcut/init',array('position_id' => $data['position_id'], 'city_id'=>$city_id, 'show_client' => $show_client)), 'text' => '快捷菜单列表'));
    	
    	$client_list = $this->get_show_client();
    	$this->assign('client_list', $client_list);
    	
    	$data['show_client'] = Ecjia\App\Adsense\Client::clients($data['show_client']);
    	$this->assign('data', $data);
    	
    	$this->assign('form_action', RC_Uri::url('adsense/admin_shortcut/update'));
    	
    	$this->display('shortcut_info.dwt');
    }
    
    public function update() {
    	$this->admin_priv('shortcut_update');
    	
    	$id 		= intval($_POST['id']);
    	$ad_name	= !empty($_POST['ad_name']) 	? trim($_POST['ad_name']) 		: '';
    	$sort_order = !empty($_POST['sort_order']) ? intval($_POST['sort_order']) : 0;
    	
    	$old_pic = RC_DB::TABLE('ad')->where('ad_id', $id)->pluck('ad_code');
    	if (isset($_FILES['ad_code']['error']) && $_FILES['ad_code']['error'] == 0 || ! isset($_FILES['ad_code']['error']) && isset($_FILES['ad_code']['tmp_name']) && $_FILES['ad_code']['tmp_name'] != 'none') {
    		$upload = RC_Upload::uploader('image', array('save_path' => 'data/shortcut', 'auto_sub_dirs' => false));
    		$image_info = $upload->upload($_FILES['ad_code']);
    		if (!empty($image_info)) {
    			$upload->remove($old_pic);
    			$ad_code = $upload->get_position($image_info);
    		} else {
    			return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}
    	} else {
    		$ad_code = $old_pic;
    	}
    	
    	if (empty($_POST['show_client'])) {
    		return $this->showmessage('请选择投放平台', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	} else {
    		$show_client = Ecjia\App\Adsense\Client::clientSelected($_POST['show_client']);
    	}
    	
    	$data = array(
    		'ad_code' 		=> $ad_code,
    		'ad_link' 		=> $_POST['ad_link'],
			'ad_name' 		=> $ad_name,
    		'show_client'   => $show_client,
			'enabled' 		=> $_POST['enabled'],
    		'sort_order' 	=> $sort_order,
		);
    	RC_DB::table('ad')->where('ad_id', $id)->update($data);
    	ecjia_admin::admin_log($ad_name, 'edit', 'shortcut');
    	$city_id = intval($_POST['city_id']);
    	$show_client = intval($_POST['show_client_value']);
    	return $this->showmessage('编辑快捷菜单成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('adsense/admin_shortcut/edit', array('id' => $id, 'city_id' => $city_id, 'show_client' => $show_client))));
    }

    
    
    public function delete() {
    	$this->admin_priv('shortcut_delete');
    	
    	$id = intval($_GET['id']);
    	$data = RC_DB::TABLE('ad')->where('ad_id', $id)->select('ad_name', 'ad_code')->first();
    	$disk = RC_Filesystem::disk();
    	$disk->delete(RC_Upload::upload_path() . $data['ad_code']);
    	RC_DB::table('ad')->where('ad_id', $id)->delete();
    	ecjia_admin::admin_log($data['ad_name'], 'add', 'shortcut');
    	return $this->showmessage('成功删除快捷菜单', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    } 
    
    /**
     * 切换是否显示
     */
    public function toggle_show() {
    	$this->admin_priv('shortcut_update');
    	
    	$id       = intval($_POST['id']);
    	$val      = intval($_POST['val']);
    	$position_id  = intval($_GET['position_id']);
    	$city_id      = intval($_GET['city_id']);
    	$show_client  = intval($_GET['show_client']);
    	
    	RC_DB::table('ad')->where('ad_id', $id)->update(array('enabled'=> $val));
    	return $this->showmessage('切换成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array('pjaxurl' => RC_Uri::url('adsense/admin_shortcut/init', array('position_id' => $position_id, 'city_id' => $city_id, 'show_client' => $show_client))));
    }
    
    /**
     * 编辑排序
     */
    public function edit_sort() {
    	$this->admin_priv('shortcut_update');
    
    	$id    = intval($_POST['pk']);
    	$sort_order   = intval($_POST['value']);
    	$position_id  = intval($_GET['position_id']);
    	$city_id      = intval($_GET['city_id']);
    	$show_client  = intval($_GET['show_client']);
    	
    	RC_DB::table('ad')->where('ad_id', $id)->update(array('sort_order'=> $sort_order));
    	return $this->showmessage('编辑排序成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array('pjaxurl' => RC_Uri::url('adsense/admin_shortcut/init', array('position_id' => $position_id, 'city_id' => $city_id, 'show_client' => $show_client))));
    }
    
}