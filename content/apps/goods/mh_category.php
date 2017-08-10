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
 * ECJIA 商品分类管理程序
 */
class mh_category extends ecjia_merchant {
	public function __construct() {
		parent::__construct();
		
		RC_Loader::load_app_func('admin_goods');
		RC_Loader::load_app_func('merchant_goods');
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');

		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Style::enqueue_style('uniform-aristo');
		// input file 长传
		RC_Style::enqueue_style('bootstrap-fileupload', RC_App::apps_url('statics/assets/bootstrap-fileupload/bootstrap-fileupload.css', __FILE__), array());
		RC_Script::enqueue_script('bootstrap-fileupload', RC_App::apps_url('statics/assets/bootstrap-fileupload/bootstrap-fileupload.js', __FILE__), array(), false, true);
		
		
		RC_Script::enqueue_script('goods_category', RC_App::apps_url('statics/js/merchant_goods_category.js',__FILE__), array());
		RC_Script::localize_script('goods_category_list', 'js_lang', RC_Lang::get('goods::goods.js_lang'));

		RC_Script::enqueue_script('bootstrap-editable-script', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/x-editable/bootstrap-editable/js/bootstrap-editable.min.js', array());
		RC_Style::enqueue_style('bootstrap-editable-css', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/x-editable/bootstrap-editable/css/bootstrap-editable.css', array(), false, false);
		
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here('商品管理', RC_Uri::url('goods/merchant/init')));
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('goods::category.goods_category'), RC_Uri::url('goods/mh_category/init')));
		ecjia_merchant_screen::get_current_screen()->set_parentage('goods', 'goods/mh_category.php');
	}

	/**
	 * 商品分类列表
	 */
	public function init() {
	    $this->admin_priv('merchant_category_manage');

		$cat_list = merchant_cat_list(0, 0, false);

		ecjia_merchant_screen::get_current_screen()->remove_last_nav_here();
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__(RC_Lang::get('goods::category.goods_category'))));

		$this->assign('ur_here', RC_Lang::get('goods::category.goods_category'));
		$this->assign('action_link', array('href' => RC_Uri::url('goods/mh_category/add'), 'text' => RC_Lang::get('goods::category.add_goods_cat')));
		$this->assign('action_link1', array('href' => RC_Uri::url('goods/mh_category/move'), 'text' => RC_Lang::get('goods::category.move_goods')));
		$this->assign('cat_info', $cat_list);

		ecjia_merchant_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('goods::category.overview'),
            'content'	=> '<p>' . RC_Lang::get('goods::category.goods_category_help') . '</p>'
		));

		ecjia_merchant_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('goods::category.more_info') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:商品分类#.E5.95.86.E5.93.81.E5.88.86.E7.B1.BB.E5.88.97.E8.A1.A8" target="_blank">'. RC_Lang::get('goods::category.about_goods_category') .'</a>') . '</p>'
		);

		$this->display('category_list.dwt');
	}

	/**
	 * 添加商品分类
	 */
	public function add() {
	    $this->admin_priv('merchant_category_update');

		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('goods::category.add_goods_cat')));
		
		$this->assign('ur_here', RC_Lang::get('goods::category.add_goods_cat'));
		$this->assign('action_link', array('href' => RC_Uri::url('goods/mh_category/init'), 'text' => RC_Lang::get('goods::category.goods_category')));
		
		$this->assign('attr_list', get_category_attr_list()); // 取得商品属性
		
		$this->assign('cat_select', merchant_cat_list(0, 0, true, 1));
		$this->assign('cat_info', array('is_show' => 1));
		$this->assign('form_action', RC_Uri::url('goods/mh_category/insert'));

		$this->display('category_info.dwt');
	}

	/**
	 * 商品分类添加时的处理
	 */
	public function insert() {
		$this->admin_priv('merchant_category_update', ecjia::MSGTYPE_JSON);
		
		$cat['cat_id']       = !empty($_POST['cat_id'])       ? intval($_POST['cat_id'])     : 0;
		$cat['parent_id']    = !empty($_POST['parent_id'])    ? intval($_POST['parent_id'])  : 0;
		$cat['sort_order']   = !empty($_POST['sort_order'])   ? intval($_POST['sort_order']) : 0;
		$cat['cat_desc']     = !empty($_POST['cat_desc'])     ? $_POST['cat_desc']           : '';
		$cat['cat_name']     = !empty($_POST['cat_name'])     ? trim($_POST['cat_name'])     : '';
		$cat['is_show']      = !empty($_POST['is_show'])      ? intval($_POST['is_show'])    : 0;
		$cat['store_id']	 = !empty($_SESSION['store_id'])  ? $_SESSION['store_id']		 : 0;
		
		if (merchant_cat_exists($cat['cat_name'], $cat['parent_id'])) {
		    return $this->showmessage(RC_Lang::get('goods::category.catname_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		if ($cat['grade'] > 10 || $cat['grade'] < 0) {
			return $this->showmessage(RC_Lang::get('goods::category.grade_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if(!empty($_FILES['cat_image']) && empty($_FILES['cat_image']['error']) && !empty($_FILES['cat_image']['name'])){
		    $cat['cat_image'] = goods_file_upload_info('category', 'cat_image', '');
		}
		
		/* 入库的操作 */
		$cat_id = RC_DB::table('merchants_category')->insertGetId($cat);

		ecjia_merchant::admin_log($_POST['cat_name'], 'add', 'category');   // 记录管理员操作

		$link[0]['text'] = RC_Lang::get('goods::category.continue_add');
		$link[0]['href'] = RC_Uri::url('goods/mh_category/add');
            
		$link[1]['text'] = RC_Lang::get('goods::category.back_list');
		$link[1]['href'] = RC_Uri::url('goods/mh_category/init');
			
		return $this->showmessage(RC_Lang::get('goods::category.catadd_succed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $link, 'pjaxurl' => RC_Uri::url('goods/mh_category/edit', array('cat_id' => $cat_id))));
	}

	/**
	 * 编辑商品分类信息
	 */
	public function edit() {
		$this->admin_priv('merchant_category_update');

		$cat_id = intval($_GET['cat_id']);
		$cat_info = get_merchant_cat_info($cat_id);  // 查询分类信息数据
		if (empty($cat_info)) {
			return $this->showmessage('未检测到该商品分类', ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => RC_Lang::get('goods::goods.return_last_page'), 'href' => 'javascript:history.go(-1)'))));
		}

		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('goods::category.category_edit')));
		$this->assign('ur_here',RC_Lang::get('goods::category.category_edit'));
		$this->assign('action_link', array('text' => RC_Lang::get('goods::category.goods_category'), 'href' => RC_Uri::url('goods/mh_category/init')));

		
		$this->assign('cat_info', $cat_info);
		$this->assign('cat_select', merchant_cat_list(0, $cat_info['parent_id'], true, 1));
		$this->assign('form_action', RC_Uri::url('goods/mh_category/update'));

		$this->display('category_info.dwt');
	}

	public function add_category() {
	    $this->admin_priv('merchant_category_update', ecjia::MSGTYPE_JSON);
	    
		$parent_id 	= empty($_REQUEST['parent_id'])	? 0		: intval($_REQUEST['parent_id']);
		$category 	= empty($_REQUEST['cat']) 		? '' 	: trim($_REQUEST['cat']);
		
		if (merchant_cat_exists($category, $parent_id)) {
			return $this->showmessage(RC_Lang::get('goods::category.catname_exist'));
		} else {
			$data = array(
				'cat_name' 	=> $category,
				'parent_id'	=> $parent_id,
				'is_show' 	=> '1',
			);
			$category_id = RC_DB::table('merchants_category')->insertGetId($data);
			
			$arr = array("parent_id" => $parent_id, "id" => $category_id, "cat" => $category);
			return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $arr));
		}
	}

	/**
	 * 编辑商品分类信息
	 */
	public function update() {
		$this->admin_priv('merchant_category_update', ecjia::MSGTYPE_JSON);

		$cat_id           	= !empty($_POST['cat_id'])       ? intval($_POST['cat_id'])     : 0;
		$cat['parent_id']	= !empty($_POST['parent_id'])    ? intval($_POST['parent_id'])  : 0;
		$cat['sort_order']	= !empty($_POST['sort_order'])   ? intval($_POST['sort_order']) : 0;
		$cat['cat_desc'] 	= !empty($_POST['cat_desc'])     ? $_POST['cat_desc']           : '';
		$cat['cat_name']  	= !empty($_POST['cat_name'])     ? trim($_POST['cat_name'])     : '';
		$cat['is_show'] 	= !empty($_POST['is_show'])      ? intval($_POST['is_show'])    : 0;
		$cat['store_id']	= !empty($_SESSION['store_id'])  ? $_SESSION['store_id']		: 0;
		
		/* 判断分类名是否重复 */
		if (merchant_cat_exists($cat['cat_name'], $cat['parent_id'], $cat_id)) {
			$link[] = array('text' => RC_Lang::get('system::system.go_back'), 'href' => 'javascript:history.back(-1)');
			return $this->showmessage(RC_Lang::get('goods::category.catname_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('links' => $link));
		}

		/* 判断上级目录是否合法 */
		$children = array_keys(merchant_cat_list($cat_id, 0, false));     // 获得当前分类的所有下级分类
		if (in_array($cat['parent_id'], $children)) {
			/* 选定的父类是当前分类或当前分类的下级分类 */
			$link[] = array('text' => RC_Lang::get('system::system.go_back'), 'href' => 'javascript:history.back(-1)');
			return $this->showmessage(RC_Lang::get('goods::category.is_leaf_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('links' => $link));
		}
		if(!empty($_FILES['cat_image']) && empty($_FILES['cat_image']['error']) && !empty($_FILES['cat_image']['name'])){
		    $cat_info = get_merchant_cat_info($cat_id);
		    $cat['cat_image'] = goods_file_upload_info('category', 'cat_image', $cat_info['cat_image_base']);
		}

		RC_DB::table('merchants_category')->where('cat_id', $cat_id)->where('store_id', $_SESSION['store_id'])->update($cat);

		ecjia_merchant::admin_log($cat['cat_name'], 'edit', 'category');
		
		return $this->showmessage(RC_Lang::get('goods::category.catedit_succed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('goods/mh_category/edit', array('cat_id' => $cat_id))));
	}
	
	public function drop_cat_image(){
	    $this->admin_priv('merchant_category_update');
	    
	    $cat_id = !empty($_REQUEST['cat_id']) ? intval($_REQUEST['cat_id']) : 0;
	    if (empty($cat_id)) {
	        return $this->showmessage('参数错误', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    $cat_info = get_merchant_cat_info($cat_id);
	    $file = !empty($cat_info['cat_image_base'])? RC_Upload::upload_path($cat_info['cat_image_base']) : '';
	    $disk = RC_Filesystem::disk();
	    $disk->delete($file);
	    RC_DB::table('merchants_category')->where('cat_id', $cat_id)->where('store_id', $_SESSION['store_id'])->update(array('cat_image' => ''));
	    
	    return $this->showmessage('成功删除', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('goods/mh_category/edit', array('cat_id' => $cat_id))));
	}

	/**
	 * 批量转移商品分类页面
	 */
	public function move() {
		$this->admin_priv('merchant_category_update');

		$cat_id = !empty($_REQUEST['cat_id']) ? intval($_REQUEST['cat_id']) : 0;
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('goods::category.move_goods')));
		ecjia_merchant_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('goods::category.overview'),
			'content'	=> '<p>' . RC_Lang::get('goods::category.move_category_help') . '</p>'
		));
		
		ecjia_merchant_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('goods::category.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:商品分类#.E8.BD.AC.E7.A7.BB.E5.95.86.E5.93.81" target="_blank">'. RC_Lang::get('goods::category.about_move_category') .'</a>') . '</p>'
		);
		
		$this->assign('ur_here', RC_Lang::get('goods::category.move_goods'));
		$this->assign('action_link', array('href' => RC_Uri::url('goods/mh_category/init'), 'text' => RC_Lang::get('goods::category.goods_category')));

		$this->assign('cat_select', merchant_cat_list(0, $cat_id, false));
		$this->assign('form_action', RC_Uri::url('goods/mh_category/move_cat'));

		$this->display('category_move.dwt');
	}

	/**
	 * 处理批量转移商品分类的处理程序
	 */
	public function move_cat() {
		$this->admin_priv('merchant_category_update', ecjia::MSGTYPE_JSON);

		$cat_id        = !empty($_POST['cat_id'])        ? intval($_POST['cat_id'])        : 0;
		$target_cat_id = !empty($_POST['target_cat_id']) ? intval($_POST['target_cat_id']) : 0;

		/* 商品分类不允许为空 */
		if ($cat_id == 0 || $target_cat_id == 0) {
			return $this->showmessage(RC_Lang::get('goods::category.cat_move_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		/* 更新商品分类 */
		$data = array('merchant_cat_id' => $target_cat_id);
		
		$new_cat_name = RC_DB::table('merchants_category')->where('cat_id', $target_cat_id)->pluck('cat_name');
		$old_cat_name = RC_DB::table('merchants_category')->where('cat_id', $cat_id)->pluck('cat_name');
		
		RC_DB::table('goods')->where('merchant_cat_id', $cat_id)->where('store_id', $_SESSION['store_id'])->update($data);

		ecjia_merchant::admin_log('从'.$old_cat_name.'转移到'.$new_cat_name, 'move', 'category_goods');
		
		return $this->showmessage(RC_Lang::get('goods::category.move_cat_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}

	/**
	 * 编辑排序序号
	 */
	public function edit_sort_order() {
		$this->admin_priv('merchant_category_update', ecjia::MSGTYPE_JSON);
		
		$id = intval($_POST['pk']);
		$val = intval($_POST['value']);

		if (merchant_cat_update($id, array('sort_order' => $val))) {
			return $this->showmessage(RC_Lang::get('goods::category.sort_edit_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('goods/mh_category/init')));
		} else {
			return $this->showmessage(RC_Lang::get('goods::category.sort_edit_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}

	/**
	 * 编辑数量单位
	 */
	public function edit_measure_unit() {
		$this->admin_priv('merchant_category_update', ecjia::MSGTYPE_JSON);
		
		$id = intval($_POST['pk']);
		$val = $_POST['value'];
		
		if (merchant_cat_update($id, array('measure_unit' => $val))) {
			return $this->showmessage(RC_Lang::get('goods::category.number_edit_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $val));
		} else {
			return $this->showmessage(RC_Lang::get('goods::category.number_edit_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}

	/**
	 * 编辑价格分级
	 */
	public function edit_grade() {
		$this->admin_priv('merchant_category_update', ecjia::MSGTYPE_JSON);
		
		$id = intval($_POST['pk']);
		$val = !empty($_POST['val']) ? intval($_POST['value']) : 0;

		if ($val > 10 || $val < 0) {
			/* 价格区间数超过范围 */
			return $this->showmessage(RC_Lang::get('goods::category.grade_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		if (merchant_cat_update($id, array('grade' => $val))) {
			return $this->showmessage(RC_Lang::get('goods::category.grade_edit_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $val));
		} else {
			return $this->showmessage(RC_Lang::get('goods::category.grade_edit_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}

	/**
	 * 切换是否显示
	 */
	public function toggle_is_show() {
		$this->admin_priv('merchant_category_update', ecjia::MSGTYPE_JSON);
		
		$id = intval($_POST['id']);
		$val = intval($_POST['val']);
		$name = RC_DB::table('merchants_category')->where('cat_id', $id)->pluck('cat_name');
		
		if (merchant_cat_update($id, array('is_show' => $val))) {
			return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $val));
		} else {
			return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}

	/**
	 * 删除商品分类
	 */
	public function remove() {
    	$this->admin_priv('merchant_category_delete', ecjia::MSGTYPE_JSON);

		$cat_id = intval($_GET['id']);
		
		$cat_name = RC_DB::table('merchants_category')->where('cat_id', $cat_id)->pluck('cat_name');
		$cat_count = RC_DB::table('merchants_category')->where('parent_id', $cat_id)->count();
		
		$goods_count = RC_DB::table('goods')->where('merchant_cat_id', $cat_id)->count();
		if ($cat_count == 0 && $goods_count == 0) {
			RC_DB::table('merchants_category')->where('cat_id', $cat_id)->where('store_id', $_SESSION['store_id'])->delete();
			
			ecjia_merchant::admin_log($cat_name, 'remove', 'category');
			return $this->showmessage(RC_Lang::get('goods::category.catdrop_succed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
			return $this->showmessage($cat_name .' '. RC_Lang::get('goods::category.cat_isleaf'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
}

// end