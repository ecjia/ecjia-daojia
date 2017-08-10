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
 *  ECJIA 管理中心品牌管理
 */
class admin_brand extends ecjia_admin {
	
	public function __construct() {
		parent::__construct();
		
		/* 加载所全局 js/css */
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('goods_brand', RC_Uri::home_url('content/apps/goods/statics/js/goods_brand.js'), array());
		
		RC_Loader::load_app_class('goods_brand', 'goods', false);
	}
	
	/**
	 * 品牌列表
	 */
	public function init() {
	    $this->admin_priv('brand_manage');
	    
		RC_Script::enqueue_script('bootstrap-editable-script', RC_Uri::admin_url() . '/statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js', array(), false, true);
		RC_Style::enqueue_style('bootstrap-editable-css', RC_Uri::admin_url() . '/statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css');
		ecjia_screen::get_current_screen()->remove_last_nav_here();
	    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('goods::brand.goods_brand')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('goods::brand.overview'),
			'content'	=> '<p>' . RC_Lang::get('goods::brand.goods_brand_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('goods::brand.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:商品品牌#.E5.95.86.E5.93.81.E5.93.81.E7.89.8C.E5.88.97.E8.A1.A8" target="_blank">'. RC_Lang::get('goods::brand.about_goods_brand') .'</a>') . '</p>'
		);
		
		$this->assign('ur_here', RC_Lang::get('goods::brand.goods_brand'));
		$this->assign('action_link', array('text' => RC_Lang::get('goods::brand.add_brand'), 'href' => RC_Uri::url('goods/admin_brand/add')));
		
		$brand_list = $this->get_brand_list();
		$this->assign('brand_list', $brand_list);
		
		$this->display('brand_list.dwt');
	}
	
	/**
	 * 添加品牌
	 */
	public function add() {
	    $this->admin_priv('brand_update');
	    
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('goods::brand.add_brand')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'	=> 'overview',
			'title'	=> RC_Lang::get('goods::brand.overview'),
			'content' => '<p>' . RC_Lang::get('goods::brand.add_brand_help') . '</p>'
		));
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('goods::brand.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:商品品牌#.E6.B7.BB.E5.8A.A0.E5.95.86.E5.93.81.E5.93.81.E7.89.8C" target="_blank">'. RC_Lang::get('goods::brand.about_add_brand') .'</a>') . '</p>'
		);
			
		$this->assign('ur_here', RC_Lang::get('goods::brand.add_brand'));
		$this->assign('action_link', array('text' => RC_Lang::get('goods::brand.goods_brand'), 'href' => RC_Uri::url('goods/admin_brand/init')));
		
		$this->assign('brand', array('sort_order' => 50, 'is_show' => 1));
		$this->assign('form_action', RC_Uri::url('goods/admin_brand/insert'));
		
		$this->display('brand_info.dwt');
	}
	
	/**
	 * 处理添加品牌
	 */
	public function insert() {
    	/*检查品牌名是否重复*/
		$this->admin_priv('brand_update', ecjia::MSGTYPE_JSON);
		
		$brand_name = !empty($_POST['brand_name'])	? htmlspecialchars($_POST['brand_name'])		: '';
		$site_url 	= !empty($_POST['site_url'])	? RC_Format::sanitize_url( $_POST['site_url'] ) : '';
		$brand_desc = !empty($_POST['brand_desc'])  ? $_POST['brand_desc']							: '';
		$sort_order = !empty($_POST['sort_order'])	? intval($_POST['sort_order'])					: 0;
		$is_show 	= isset($_REQUEST['is_show']) 	? intval($_REQUEST['is_show'])					: 0;
		
		if (empty($brand_name)) {
			return $this->showmessage(RC_Lang::get('goods::brand.no_brand_name'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$goods_brand = new goods_brand();
		$is_only = $goods_brand->brand_count(array('brand_name' => $brand_name));
		
		if ($is_only != 0) {
			return $this->showmessage(sprintf(RC_Lang::get('goods::brand.brandname_exist'), stripslashes($_POST['brand_name'])),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$brand_logo	= '';
		/* 处理上传的LOGO图片 */
		if ((isset($_FILES['brand_img']['error']) && $_FILES['brand_img']['error'] == 0) || (!isset($_FILES['brand_img']['error']) && isset($_FILES['brand_img']['tmp_name']) && $_FILES['brand_img']['tmp_name'] != 'none')) {
			$upload = RC_Upload::uploader('image', array('save_path' => 'data/brandlogo', 'auto_sub_dirs' => false));
    		$info 	= $upload->upload($_FILES['brand_img']);
    		if (!empty($info)) {
    			$brand_logo = $info['savepath'] . '/' . $info['savename'];
    		} else {
    			return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}
	   }

    	/* 使用远程的LOGO图片 */
    	if (!empty($_POST['url_logo']))	{
    		if (strpos($_POST['url_logo'], 'http://') === false && strpos($_POST['url_logo'], 'https://') === false) {
    			$brand_logo = 'http://' . trim($_POST['url_logo']);
    		} else {
    			$brand_logo = trim($_POST['url_logo']);
    		}
    	}
    	$brand_id = $goods_brand->insert_brand($brand_name, $site_url, $brand_desc, $brand_logo, $sort_order, $is_show);
    
    	$link[0]['text'] = RC_Lang::get('goods::brand.back_list');
    	$link[0]['href'] = RC_Uri::url('goods/admin_brand/init');
    	
    	$link[1]['text'] = RC_Lang::get('goods::brand.continue_add');
    	$link[1]['href'] = RC_Uri::url('goods/admin_brand/add');
    	
    	ecjia_admin::admin_log($brand_name, 'add', 'brand');
    	return $this->showmessage(RC_Lang::get('goods::brand.brandadd_succed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('goods/admin_brand/edit', "id=$brand_id"), 'links' => $link, 'max_id' => $brand_id));
    }

	/**
	 * 编辑品牌
	 */
	public function edit() {
	    $this->admin_priv('brand_update');
	    
	    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('goods::brand.edit_brand')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('goods::brand.overview'),
			'content'	=> '<p>' . RC_Lang::get('goods::brand.edit_brand_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('goods::brand.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:商品品牌#.E7.BC.96.E8.BE.91.E5.95.86.E5.93.81.E5.93.81.E7.89.8C" target="_blank">'. RC_Lang::get('goods::brand.about_edit_brand') .'</a>') . '</p>'
		);
		
		$this->assign('ur_here', RC_Lang::get('goods::brand.edit_brand'));
		$this->assign('action_link', array('text' => RC_Lang::get('goods::brand.goods_brand'), 'href' => RC_Uri::url('goods/admin_brand/init')));
		
		$brand_id = intval($_GET['id']);
		
		$goods_brand = new goods_brand();
		$brand = $goods_brand->brand_info($brand_id);
		
		/* 标记为图片链接还是文字链接 */
		if (!empty($brand['brand_logo'])) {
			if (strpos($brand['brand_logo'], 'http://') === false) {
				$brand['type']	= 1;
				$brand['url']	= RC_Upload::upload_url($brand['brand_logo']);
			} else {
				$brand['type']	= 0;
				$brand['url']	= $brand['brand_logo'];
			}
		} else {
			$brand['type']	= 0;
		}
		
		$this->assign('brand', $brand);
		$this->assign('form_action', RC_Uri::url('goods/admin_brand/update'));
		
		$this->display('brand_info.dwt');
	}
	
	/**
	 * 编辑品牌处理
	 */
	public function update() {
	    $this->admin_priv('brand_update', ecjia::MSGTYPE_JSON);

	    $id         = !empty($_POST['id'])    		? intval($_POST['id'])                         	: 0;
		$brand_name = !empty($_POST['brand_name'])	? htmlspecialchars($_POST['brand_name'])		: '';
		$site_url 	= !empty($_POST['site_url'])	? RC_Format::sanitize_url( $_POST['site_url'] ) : '';
		$brand_desc = !empty($_POST['brand_desc'])  ? $_POST['brand_desc']							: '';
		$sort_order = !empty($_POST['sort_order'])	? intval($_POST['sort_order'])					: 0;
		$is_show 	= isset($_REQUEST['is_show']) 	? intval($_REQUEST['is_show'])					: 0;
	    
	    if (empty($brand_name)) {
	    	return $this->showmessage(RC_Lang::get('goods::brand.no_brand_name'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    
	    $goods_brand = new goods_brand();
	    
		/*检查品牌名是否相同*/
		$is_only = $goods_brand->brand_count(array('brand_name' => $brand_name, 'brand_id' => array('neq' => $id)));
		if ($is_only != 0){
			return $this->showmessage(sprintf(RC_Lang::get('goods::brand.brandname_exist'), stripslashes($brand_name)), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$old_logo = $goods_brand->brand_field($id, 'brand_logo');
		/* 如果有图片LOGO要上传 */
		if ((isset($_FILES['brand_img']['error']) && $_FILES['brand_img']['error'] == 0) || (!isset($_FILES['brand_img']['error']) && isset($_FILES['brand_img']['tmp_name']) && $_FILES['brand_img']['tmp_name'] != 'none')) {
			$upload = RC_Upload::uploader('image', array('save_path' => 'data/brandlogo', 'auto_sub_dirs' => false));
			$info = $upload->upload($_FILES['brand_img']);

			/* 如果要修改链接图片, 删除原来的图片 */
			if (!empty($info)) {
				if ((strpos($old_logo, 'http://') === false) && (strpos($old_logo, 'https://') === false)) {
					$upload->remove($old_logo);
				}
				/* 获取新上传的LOGO的链接地址 */
				$brand_logo = $info['savepath'] . '/' . $info['savename'];
			}
		} elseif (!empty($_POST['url_logo'])) {
			if (strpos($_POST['url_logo'], 'http://') === false && strpos($_POST['url_logo'], 'https://') === false) {
				$brand_logo = 'http://' . $_POST['url_logo'];
			} else {
    			$brand_logo = trim($_POST['url_logo']);
    		}
		} else {
			/* 如果没有修改图片字段，则图片为之前的图片*/
			$brand_logo = $old_logo;
		}

		/* 更新信息 */
		$data = array(
			'brand_name'	=> $brand_name,
			'site_url' 		=> $site_url,
			'brand_logo' 	=> $brand_logo,
			'brand_desc' 	=> $brand_desc,
			'sort_order' 	=> $sort_order,
			'is_show' 		=> $is_show,
		);
		$goods_brand->update_brand($id, $data);
		
		ecjia_admin::admin_log($brand_name, 'edit', 'brand');
		return $this->showmessage(sprintf(RC_Lang::get('goods::brand.brandedit_succed'), $brand_name), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('goods/admin_brand/edit', array('id' => $id))));
    }

	/**
	 * 编辑品牌名称
	 */
	public function edit_brand_name() {
		$this->admin_priv('brand_update', ecjia::MSGTYPE_JSON);
		
		$id     = intval($_POST['pk']);
		$name   = trim($_POST['value']);
		
		if (empty($name)) {
			return $this->showmessage(RC_Lang::get('goods::brand.no_brand_name'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$goods_brand = new goods_brand();
		
		/* 检查名称是否重复 */
		$is_only = $goods_brand->brand_count(array('brand_name' => $name, 'brand_id' => array('neq' => $id)));
		if ($is_only != 0) {
			return $this->showmessage(sprintf(RC_Lang::get('goods::brand.brandname_exist'), $name), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$data = array('brand_id' => $id, 'brand_name' => $name);
			$goods_brand->update_brand($id, $data);
			
			ecjia_admin::admin_log($name,'edit', 'brand');
			return $this->showmessage(sprintf(RC_Lang::get('goods::brand.brandedit_succed'), $name), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content'=> stripslashes($name)));
		}
	}
	
	/**
	 * 编辑排序序号
	 */
	public function edit_sort_order() {
		$this->admin_priv('brand_update', ecjia::MSGTYPE_JSON);
		
		$id     = intval($_POST['pk']);
		$order  = intval($_POST['value']);
		$data 	= array('sort_order' => $order);
		
		$goods_brand = new goods_brand();
		$brand_name = $goods_brand->brand_field($id, 'brand_name');
		
		$goods_brand->update_brand($id, $data);
		
		ecjia_admin::admin_log($brand_name, 'edit', 'brand');
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('goods/admin_brand/init', array('content'=> $order))));
	}
	
	/**
	 * 切换是否显示
	 */
	public function toggle_show() {
		$this->admin_priv('brand_update', ecjia::MSGTYPE_JSON);
	
		$id	 = intval($_POST['id']);
		$val = intval($_POST['val']);
		$data = array('is_show' => $val);
	
		$goods_brand = new goods_brand();
		$goods_brand->update_brand($id, $data);
		
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $val));
	}

	/**
	 * 删除品牌
	 */
	public function remove() {
		$this->admin_priv('brand_delete', ecjia::MSGTYPE_JSON);
		
		$id = intval($_GET['id']);
		$goods_brand = new goods_brand();
		$brand_info = $goods_brand->brand_info($id);
		
		/* 删除该品牌的图标 */
		if (!empty($brand_info['brand_logo'])) {
			$disk = RC_Filesystem::disk();
			$disk->delete(RC_Upload::upload_path() . $brand_info['brand_logo']);
		}

		$goods_brand->brand_delete($id);
		
		/* 更新商品的品牌编号 */
		$data = array(
			'brand_id' => '0'
		);
		RC_DB::table('goods')->where('brand_id', $id)->update($data);
		
		ecjia_admin::admin_log($brand_info['brand_name'], 'remove', 'brand');
		return $this->showmessage(RC_Lang::get('goods::brand.drop_succeed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 删除品牌图片
	 */
	public function drop_logo() {
	    $this->admin_priv('brand_manage', ecjia::MSGTYPE_JSON);

	   	$brand_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		$goods_brand = new goods_brand();
		$brand_info = $goods_brand->brand_info($brand_id);
		
		if (!empty($brand_info['brand_logo'])) {
			$disk = RC_Filesystem::disk();
			$disk->delete(RC_Upload::upload_path() . $brand_info['brand_logo']);
		}
		
		$data = array('brand_logo' => '');
		$goods_brand->update_brand($brand_id, $data);
		
		return $this->showmessage(RC_Lang::get('goods::brand.drop_succeed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('goods/admin_brand/edit', array('id' => $brand_id))));
	}
	
	/**
	 * 获取品牌列表
	 *
	 * @access  public
	 * @return  array
	 */
	private function get_brand_list() {
		$db_brand = RC_DB::table('brand');
	
		/* 分页大小 */
		$keywords = isset($_GET['keywords']) ? trim($_GET['keywords']) : '';
	
		if ($keywords) {
			$db_brand->where('brand_name', 'like', '%' . mysql_like_quote($keywords) . '%');
		}
	
		$count = $db_brand->count();
		$page = new ecjia_page($count, 10, 5);
		$data = $db_brand->orderby('sort_order', 'asc')->take(10)->skip($page->start_id-1)->get();
	
		$arr = array();
		if (!empty($data)) {
			foreach ($data as $key => $rows) {
				if (empty($rows['brand_logo'])) {
					$rows['brand_logo_html'] = "<img src='" . RC_Uri::admin_url('statics/images/nopic.png') . "' style='width:100px;height:100px;' />";
				} else {
					$disk = RC_Filesystem::disk();
					if ((strpos($rows['brand_logo'], 'http://') === false) && (strpos($rows['brand_logo'], 'https://') === false)) {
						$logo_url = RC_Upload::upload_url($rows['brand_logo']);
						$logo_url = $disk->exists(RC_Upload::upload_path($rows['brand_logo'])) ? $logo_url : RC_Uri::admin_url('statics/images/nopic.png');
							
						$rows['brand_logo_html'] = "<img src='" . $logo_url . "' style='width:100px;height:100px;' />";
					} else {
						$rows['brand_logo_html'] = "<img src='" . RC_Uri::admin_url('statics/images/nopic.png') . "' style='width:100px;height:100px;' />";
					}
				}
				$site_url = empty($rows['site_url']) ? 'N/A' : '<a href="'.$rows['site_url'].'" target="_brank">'.$rows['site_url'].'</a>';
				$rows['site_url'] = $site_url;
				$arr[] = $rows;
			}
		}
		return array('brand' => $arr, 'page' => $page->show(2), 'desc' => $page->page_desc());
	}
}

// end