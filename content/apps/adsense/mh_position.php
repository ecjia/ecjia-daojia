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

class mh_position extends ecjia_merchant {
    
    public function __construct() {
		parent::__construct();
		RC_Style::enqueue_style('merchant', RC_App::apps_url('statics/styles/merchant.css', __FILE__), array());
		
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('ecjia-mh-editable-js');
		RC_Style::enqueue_style('ecjia-mh-editable-css');

		RC_Script::enqueue_script('bootstrap-editable-script', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/bootstrap-fileupload/bootstrap-fileupload.js', array());
		RC_Style::enqueue_style('bootstrap-fileupload', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/bootstrap-fileupload/bootstrap-fileupload.css', array(), false, false);
		
		RC_Script::enqueue_script('mh_ad_position', RC_App::apps_url('statics/js/mh_ad_position.js', __FILE__));
		RC_Script::enqueue_script('mh_adsense', RC_App::apps_url('statics/js/mh_adsense.js', __FILE__));	
		RC_Script::enqueue_script('mh_group', RC_App::apps_url('statics/js/mh_group.js', __FILE__));
		
		ecjia_merchant_screen::get_current_screen()->set_parentage('adsense', 'adsense/mh_position.php');
	}
    
    public function init() {
    	$this->admin_priv('mh_adsense_position_manage');
    		
    	ecjia_screen::get_current_screen()->remove_last_nav_here();
    	ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('广告位管理'));
    	
    	$this->assign('ur_here', '广告位置列表 ');
    	$this->assign('action_link', array('text' => '添加广告位', 'href' => RC_Uri::url('adsense/mh_position/add')));
    	
    	$sort_by   = trim($_GET['sort_by']);
    	$sort_order= trim($_GET['sort_order']);
    	if (!empty($sort_by)) {
    		$orderBy = array($sort_by => $sort_order);
    	} else {
    		$orderBy = array();
    	}
    	 
    	//获取广告位列表
    	$position = new Ecjia\App\Adsense\Merchant\PositionManage('adsense', $_SESSION['store_id']);
    	$data = $position->getAllPositions($orderBy);
    	$this->assign('data', $data);
    	 
    	$this->assign('search_action', RC_Uri::url('adsense/mh_position/init'));
    	 
    	$this->display('mh_adsense_position_list.dwt');
    }
    
    public function add() {
    	$this->admin_priv('mh_adsense_position_update');
    
    	ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('添加广告位'));
    	$this->assign('ur_here', '添加广告位置');
    	$this->assign('action_link', array('href' => RC_Uri::url('adsense/mh_position/init'), 'text' => '广告位列表'));
    	
    	$this->assign('form_action', RC_Uri::url('adsense/mh_position/insert'));
    	
    	$this->display('mh_adsense_position_info.dwt');
    }

    public function insert() {
    	$this->admin_priv('mh_adsense_position_update');
    	 
    	$position_name = !empty($_POST['position_name']) ? trim($_POST['position_name']) : '';
    	$position_code = !empty($_POST['position_code']) ? trim($_POST['position_code']) : '';
    	$position_desc = !empty($_POST['position_desc']) ? nl2br(htmlspecialchars($_POST['position_desc'])) : '';
    	$ad_width      = !empty($_POST['ad_width']) ? intval($_POST['ad_width']) : 0;
    	$ad_height     = !empty($_POST['ad_height']) ? intval($_POST['ad_height']) : 0;
    	$max_number    = !empty($_POST['max_number']) ? intval($_POST['max_number']) : 0;
    	$sort_order    = !empty($_POST['sort_order']) ? intval($_POST['sort_order']) : 0;
    	
    	$query = RC_DB::table('merchants_ad_position')->where('position_code', $position_code)->where('store_id', $_SESSION['store_id'])->where('type', 'adsense')->count();
    	if ($query > 0) {
    		return $this->showmessage('该广告位代号在当前店铺中已存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	$data = array(
    		'store_id'		=> $_SESSION['store_id'],
    		'position_name' => $position_name,
    		'position_code' => $position_code,
    		'position_desc' => $position_desc,
    		'ad_width'      => $ad_width,
    		'ad_height'     => $ad_height,
    		'max_number'    => $max_number,
    		'type' 			=> 'adsense',
    		'sort_order' 	=> $sort_order,
    	);
    	$position_id = RC_DB::table('merchants_ad_position')->insertGetId($data);
    	
    	ecjia_merchant::admin_log($position_name, 'add', 'ads_position');
    	return $this->showmessage('添加广告位成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('adsense/mh_position/edit', array('position_id' => $position_id))));
    }
    
    public function edit() {
    	$this->admin_priv('mh_adsense_position_update');
    
    	ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('编辑广告位'));
    	$this->assign('ur_here', '编辑广告位');
    	$this->assign('action_link', array('href' => RC_Uri::url('adsense/mh_position/init'), 'text' => '广告位列表'));
    	
    	$position_id = intval($_GET['position_id']);
    	$data = RC_DB::table('merchants_ad_position')->where('position_id', $position_id)->first();
    	$this->assign('data', $data);
    	
    	$this->assign('form_action', RC_Uri::url('adsense/mh_position/update'));
    	
    	$this->display('mh_adsense_position_info.dwt');
    }
    
    public function update() {
    	$this->admin_priv('mh_adsense_position_update');
    
    	$position_id   = intval($_POST['position_id']);
    	$position_name = !empty($_POST['position_name']) ? trim($_POST['position_name']) : '';
    	$position_desc = !empty($_POST['position_desc']) ? nl2br(htmlspecialchars($_POST['position_desc'])) : '';
    	$max_number    = !empty($_POST['max_number']) ? intval($_POST['max_number']) : 0;
    	$sort_order    = !empty($_POST['sort_order']) ? intval($_POST['sort_order']) : 0;
    	$ad_width      = !empty($_POST['ad_width']) ? intval($_POST['ad_width']) : 0;
    	$ad_height     = !empty($_POST['ad_height']) ? intval($_POST['ad_height']) : 0;
    
    	$data = array(
    		'position_name' => $position_name,
    		'position_desc' => $position_desc,
    		'max_number'    => $max_number,
    		'sort_order' 	=> $sort_order,
    		'ad_width'      => $ad_width,
    		'ad_height'     => $ad_height,
    	);
    	
    	RC_DB::table('merchants_ad_position')->where('position_id', $position_id)->update($data);
    	
    	ecjia_merchant::admin_log($position_name, 'edit', 'ads_position');
    	return $this->showmessage('编辑广告位成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('adsense/mh_position/edit', array('position_id' => $position_id, 'city_id' => $city_id))));
    }

    public function remove() {
    	$this->admin_priv('ad_position_delete');
    
    	$id = intval($_GET['id']);
    	if (RC_DB::table('merchants_ad')->where('position_id', $id)->count() != 0) {
    		return $this->showmessage('该广告位已经有广告存在，不能删除！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	} else {
    		$position_name = RC_DB::table('merchants_ad_position')->where('position_id', $id)->pluck('position_name');
    		ecjia_merchant::admin_log($position_name, 'remove', 'ads_position');
    		RC_DB::table('merchants_ad_position')->where('position_id', $id)->delete();
    		return $this->showmessage('删除广告位成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('adsense/mh_position/init')));
    	}
    }
    
    
    /**
     * 编辑广告位置名称
     */
    public function edit_position_name() {
    	$this->admin_priv('mh_adsense_position_update');
    
    	$id = intval($_POST['pk']);
    	$position_name = trim($_POST['value']);
    	if (!empty($position_name)) {
    		$data = array('position_name' => $position_name);
    		RC_DB::table('merchants_ad_position')->where('position_id', $id)->update($data);
    		ecjia_admin::admin_log($position_name, 'edit', 'ads_position');
    		return $this->showmessage('编辑广告位名称成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('adsense/mh_position/init')));
    	} else {
    		return $this->showmessage('请输入广告位名称', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    }
    
    /**
     * 编辑排序
     */
    public function edit_sort() {
    	$this->admin_priv('mh_adsense_position_update');
    
    	$id    = intval($_POST['pk']);
    	$sort_order   = intval($_POST['value']);
    	RC_DB::table('merchants_ad_position')->where('position_id', $id)->update(array('sort_order'=> $sort_order));
    	
    	$group_position_id  = intval($_GET['group_position_id']);
    	if ($group_position_id) {
    		return $this->showmessage('编辑排序成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array('pjaxurl' => RC_Uri::url('adsense/mh_group/init', array('position_id' => $group_position_id))));
    	} else {
    		return $this->showmessage('编辑排序成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array('pjaxurl' => RC_Uri::url('adsense/mh_position/init', array('position_id' => $id))));
    	}
    
    }
}