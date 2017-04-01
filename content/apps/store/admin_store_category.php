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
 * 商家分类管理
 */
class admin_store_category extends ecjia_admin {
	private $seller_category_db;
	private $seller_shopinfo_db;
	
	public function __construct() {
		
		parent::__construct();
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		RC_Loader::load_app_func('merchant_store_category', 'store');
		
		//全局JS和CSS
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('bootstrap-editable.min',RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		
		RC_Script::enqueue_script('jquery.toggle.buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/jquery.toggle.buttons.js'));
		RC_Style::enqueue_style('bootstrap-toggle-buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/bootstrap-toggle-buttons.css'));
		
		RC_Script::enqueue_script('store_category', RC_App::apps_url('statics/js/store_category.js', __FILE__), array(), false, true);
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商家分类'), RC_Uri::url('store/admin_store_category/init')));
	}
	
	/**
	 * 商家分类列表
	 */
	public function init() {
	    $this->admin_priv('store_category_manage');
		
	    ecjia_screen::get_current_screen()->remove_last_nav_here();
	    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商家分类')));
	   
	    $cat_list = cat_list(0, 0, false);
	    $this->assign('cat_info', $cat_list);
	    $this->assign('ur_here',__('商家分类'));
	    $this->assign('action_link', array('text' => __('添加分类'),'href'=>RC_Uri::url('store/admin_store_category/add')));
	    $this->display('store_category_list.dwt');
	}
	
	/**
	 * 添加商家分类
	 */
	public function add() {
	    $this->admin_priv('store_category_manage');
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('添加商家分类')));
		$this->assign('ur_here', __('添加分类'));
		$this->assign('action_link',  array('href' => RC_Uri::url('store/admin_store_category/init'), 'text' => __('商家分类')));
		
		$this->assign('cat_select', cat_list(0, 0, true));
		$this->assign('form_action', RC_Uri::url('store/admin_store_category/insert'));

		$this->display('store_category_info.dwt');
	}

	/**
	 * 商家分类添加时的处理
	 */
	public function insert() {
		$this->admin_priv('store_category_manage', ecjia::MSGTYPE_JSON);
		
		$cat['cat_name']     = !empty($_POST['cat_name'])     ? trim($_POST['cat_name'])        : '';
		$cat['parent_id'] 	 = !empty($_POST['store_cat_id']) ? intval($_POST['store_cat_id'])  : 0;
		$cat['sort_order']   = !empty($_POST['sort_order'])   ? intval($_POST['sort_order'])    : 0;
		$cat['is_show'] 	 = isset($_POST['is_show'])       ? 1                               : 0;
		$cat['keywords']     = !empty($_POST['keywords'])     ? trim($_POST['keywords'])        : '';
		$cat['cat_desc']     = !empty($_POST['cat_desc'])     ? $_POST['cat_desc']              : '';
	
		if (cat_exists($cat['cat_name'], $cat['parent_id'])) {
			return $this->showmessage('已存在相同的分类名称!', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		/*分类图片上传*/
		$upload = RC_Upload::uploader('image', array('save_path' => 'data/store_category', 'auto_sub_dirs' => true));
		if (isset($_FILES['cat_image']) && $upload->check_upload_file($_FILES['cat_image'])) {
			$image_info = $upload->upload($_FILES['cat_image']);
			if (empty($image_info)) {
				return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			$cat['cat_image'] = $upload->get_position($image_info);
		}
		
		/* 入库的操作 */
		$insert_id = RC_DB::table('store_category')->insertGetId($cat);
		if ($insert_id) {
			ecjia_admin::admin_log($_POST['cat_name'], 'add', 'store_category');   // 记录管理员操作
			/*添加链接*/
			$links[] = array('text' => '商家分类列表', 'href'=> RC_Uri::url('store/admin_store_category/init'));
			$links[] = array('text' => '继续添加分类', 'href'=> RC_Uri::url('store/admin_store_category/add'));
			return $this->showmessage('添加商家分类成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links ,'pjaxurl' => RC_Uri::url('store/admin_store_category/edit', array('cat_id' => $insert_id))));
		} else {
			return $this->showmessage('添加商家分类失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	
	/**
	 * 编辑商家分类信息
	 */
	public function edit() {
		$this->admin_priv('store_category_manage');
		$cat_id = intval($_GET['cat_id']);
		$cat_info = get_cat_info($cat_id);  // 查询分类信息数据
		
		if(!empty($cat_info['cat_image'])) {
			$cat_info['cat_image'] =  RC_Upload::upload_url($cat_info['cat_image']);
		} else {
			$cat_info['cat_image'] = '';
		}
	
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑商家分类')));
		$this->assign('ur_here', __('编辑商家分类'));
		$this->assign('action_link', array('text' => __('编辑商家分类'), 'href' => RC_Uri::url('store/admin_store_category/init')));

		$this->assign('cat_info', $cat_info);
		$this->assign('cat_select', cat_list(0, $cat_info['parent_id'], true));
		
		$this->assign('form_action', RC_Uri::url('store/admin_store_category/update'));

		$this->display('store_category_info.dwt');
	}
	
	/**
	 * 编辑商品分类信息
	 */
	public function update() {
		$this->admin_priv('store_category_manage', ecjia::MSGTYPE_JSON);
		
		$cat_id              = !empty($_POST['cat_id'])       ? intval($_POST['cat_id'])        : 0;
		$cat['cat_name']     = !empty($_POST['cat_name'])     ? trim($_POST['cat_name'])        : '';
		$cat['parent_id']	 = !empty($_POST['store_cat_id']) ? intval($_POST['store_cat_id'])  : 0;
		$cat['sort_order']   = !empty($_POST['sort_order'])   ? intval($_POST['sort_order'])    : 0;
		$cat['is_show'] 	 = isset($_POST['is_show'])       ? 1                               : 0;
		$cat['keywords']     = !empty($_POST['keywords'])     ? trim($_POST['keywords'])        : '';
		$cat['cat_desc']     = !empty($_POST['cat_desc'])     ? $_POST['cat_desc']              : '';
		
		$old_cat_name     	 = !empty($_POST['old_cat_name '])     ? trim($_POST['old_cat_name '])     : '';
		
		/* 判断分类名是否重复 */
		if ($cat['cat_name'] != $old_cat_name) {
			if (cat_exists($cat['cat_name'], $cat['parent_id'], $cat_id)) {
				return $this->showmessage('已存在相同的分类名称!', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}	
		/* 判断上级目录是否合法 */
		$children = array_keys(cat_list($cat_id, 0, false));     // 获得当前分类的所有下级分类
		if (in_array($cat['parent_id'], $children)) {
			/* 选定的父类是当前分类或当前分类的下级分类 */
			return $this->showmessage(__('所选择的上级分类不能是当前分类或者当前分类的下级分类!'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		/* 更新分类图片 */
		$upload = RC_Upload::uploader('image', array('save_path' => 'data/category', 'auto_sub_dirs' => true));
		
		if (isset($_FILES['cat_image']) && $upload->check_upload_file($_FILES['cat_image'])) {
			$image_info = $upload->upload($_FILES['cat_image']);
			if (empty($image_info)) {
				return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			$cat['cat_image'] = $upload->get_position($image_info);
		}
		RC_DB::table('store_category')
						->where('cat_id', $cat_id)
						->update($cat);
		/*记录log */
		ecjia_admin::admin_log($_POST['cat_name'], 'edit', 'store_category');
		$link[] = array('text' => __('返回商家分类列表'), 'href' => RC_Uri::url('store/admin_store_category/init'));
		return $this->showmessage('编辑商家分类成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $link, 'id' => $cat_id));
	}
	
	/**
	 * 删除商家分类
	 */
	public function remove() {
		$this->admin_priv('store_category_drop', ecjia::MSGTYPE_JSON);
		/* 初始化分类ID并取得分类名称 */
		$cat_id   = intval($_GET['id']);

		$cat_name = RC_DB::table('store_category')->where('cat_id', $cat_id)->pluck('cat_name');

		/* 当前分类下是否有子分类 */
		$cat_count = RC_DB::table('store_category')->where('parent_id', $cat_id)->count();
		
		/* 当前分类下是否存在商家 */
		$franchisee_count = RC_DB::table('store_franchisee')->where('cat_id', $cat_id)->count();
		$preaudit_count   = RC_DB::table('store_preaudit')->where('cat_id', $cat_id)->count();
		
		/* 如果不存在下级子分类和商品，则删除之 */
		if ($cat_count == 0 && $franchisee_count == 0 && $preaudit_count == 0) {
			/* 删除分类 */
			RC_DB::table('store_category')->where('cat_id', $cat_id)->delete();
			//记录log
			ecjia_admin::admin_log($cat_name, 'remove', 'store_category');
			return $this->showmessage(__('删除商家分类成功！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
			return $this->showmessage($cat_name .' '. '不是末级分类或者此分类下还存在有商家，您不能删除!', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 切换是否显示
	 */
	public function toggle_is_show() {
		$this->admin_priv('store_category_manage', ecjia::MSGTYPE_JSON);
	
		$id = intval($_POST['id']);
		$val = intval($_POST['val']);
		
		$cat_name = RC_DB::table('store_category')->where('cat_id', $id)->pluck('cat_name');
		if (cat_update($id, array('is_show' => $val))) {
			//记录log
			ecjia_admin::admin_log($cat_name, 'edit', 'store_category');
			return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $val));
		} else {
			return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 编辑排序序号
	 */
	public function edit_sort_order() {
		$this->admin_priv('store_category_manage', ecjia::MSGTYPE_JSON);
	
		$id       = intval($_POST['pk']);
		$val      = intval($_POST['value']);
		$cat_name = RC_DB::table('store_category')->where('cat_id', $id)->pluck('cat_name');
		if (cat_update($id, array('sort_order' => $val))) {
			//记录log
			ecjia_admin::admin_log($cat_name, 'edit', 'store_category');
			return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('store/admin_store_category/init')));
		} else {
			return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 删除上传文件
	 */
	public function del() {
		$this->admin_priv('store_category_drop', ecjia::MSGTYPE_JSON);	
		$cat_id     = trim($_GET['cat_id']);
	
		$cat_image = RC_DB::table('store_category')->where('cat_id', $cat_id)->select('cat_image')->first();
		$disk = RC_Filesystem::disk();
		if (!empty($cat_image['cat_image'])) {
			$disk->delete(RC_Upload::upload_path() . $cat_image['cat_image']);
		}
		
		ecjia_admin::admin_log('', 'remove', 'store_category');
		RC_DB::table('store_category')->where('cat_id', $cat_id)->update(array('cat_image' => ''));
		return $this->showmessage(RC_Lang::get('store::store.del_store_cat_img_ok') , ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
}

//end