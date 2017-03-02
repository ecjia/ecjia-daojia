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
 * ECJIA 地区列表管理文件
 */
class admin_area_manage extends ecjia_admin {
	private $db;
	public function __construct() {
		parent::__construct();

		$this->db = RC_Loader::load_model('region_model');		
		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		$this->assign('_FILE_STATIC', RC_Uri::admin_url('statics/'));
		RC_Script::enqueue_script('admin_region', RC_App::apps_url('statics/js/admin_region.js', __FILE__), array(), false, true);
		
	}

	/**
	 * 列出某地区下的所有地区列表
	 */
	public function init() {
		$this->admin_priv('area_manage');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('地区列表')));
		$this->assign('ur_here', __('地区列表'));
		
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'        => 'overview',
			'title'     => __('概述'),
			'content'   => '<p>' . __('欢迎访问ECJia智能后台地区设置页面，用户可以在此进行设置地区。') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
		'<p><strong>' . __('更多信息：') . '</strong></p>' .
		'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:系统设置#.E5.9C.B0.E5.8C.BA.E5.88.97.E8.A1.A8" target="_blank">关于地区设置帮助文档</a>') . '</p>'
		);

		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		$region_arr = $this->db->where(array('parent_id'=>$id))->select();
		if ($id == 0) {
			$region_type = 0;
		} else {
			$region_type = $this->db->where(array('region_id'=>$id))->get_field('region_type');
			$region_type++;
		}
		$this->assign('region_arr',   $region_arr);
		$this->assign('parent_id',    $id);
		$this->assign('region_type',  $region_type);

		if (!empty($id)) {
			$parent_id = $this->db->where(array('region_id'=>$id))->get_field('parent_id');
			$this->assign('action_link', array('href'=>RC_Uri::url('setting/admin_area_manage/init', 'id='.$parent_id), 'text' => __('返回上级')));
		}

		$this->display('area_list.dwt');
	}


	public function area_info(){
		$id         = intval($_POST['id']);
		$region_arr = ecjia_area::area_list('parent_id ='.$id);

		header('Content-type: text/json');
		echo json_encode($region_arr);die;
	}

	/**
	 * 添加新的地区
	 */
	public function add_area() {
		$this->admin_priv('area_manage', ecjia::MSGTYPE_JSON);

		$parent_id      = intval($_POST['parent_id']);
		$region_name    = trim($_POST['region_name']);
		$region_type    = intval($_POST['region_type']);
		
		if (empty($region_name)) {
			$this->showmessage(__('区域名称不能为空！'),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		/* 查看区域是否重复 */		
		$is_only = $this->db->where(array('region_name' => $region_name, 'parent_id'=>$parent_id))->count();
		if ($is_only) {
			 $this->showmessage(__('抱歉，已经有相同的地区名存在！'),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$data = array(
				'parent_id'   => $parent_id,
				'region_name' => $region_name,
				'region_type' => $region_type,
			);
			
			$region_id = $this->db->insert($data);
			
			if ($region_id) {
				$region_href=RC_Uri::url('setting/admin_area_manage/drop_area',array('id' => $region_id));
				ecjia_admin::admin_log($region_name, 'add','area');
				$this->showmessage(__('添加新地区成功！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array('pjaxurl' => RC_Uri::url('setting/admin_area_manage/init', 'id='.$parent_id)));
			} else {
				$this->showmessage(__('添加新地区失败！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
	}

	/**
	 * 编辑区域名称
	 */
	public function edit_area_name() {
		$this->admin_priv('area_manage', ecjia::MSGTYPE_JSON);

		$id          = intval($_POST['id']);
		$region_name = trim($_POST['region_name']);
		if (empty($region_name)) {
			$this->showmessage(__('区域名称不能为空！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
        $old =$this->db->field('region_name,parent_id')->where(array('region_id' => $id))->find();
		$parent_id = $old['parent_id'];
		$old_name = $old['region_name'];
		
		/* 查看区域是否重复 */
		$is_only = $this->db->where(array('region_name' => $region_name, 'parent_id'=>$parent_id))->count();
		if ($is_only) {
			$this->showmessage(__('抱歉，已经有相同的地区名存在！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {		
			if ($this->db->where(array('region_id' => $id))->update(array('region_name' => $region_name))) {
				ecjia_admin::admin_log(sprintf(__('更新地区名称为 %s'), $region_name), 'edit', 'area');
				$this->showmessage(__('修改名称成功！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('setting/admin_area_manage/init', 'id='.$parent_id)));
			} else {
				$this->showmessage($this->db->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
	}

	/**
	 * 删除区域
	 */
	public function drop_area() {
		$this->admin_priv('area_manage', ecjia::MSGTYPE_JSON);

		$id = intval($_REQUEST['id']);

		$region = $this->db->where('region_id = '.$id.'')->find();

		$region_type_max = $this->db->max('region_type');
		$region_type     = $region['region_type'];
		$regionname      = $region['region_name'];
		$delete_region[] = $id;
		$new_region_id   = $id;

		for ($i=0; $i<=$region_type_max-$region_type; $i++) {
			$new_region_id = $this->new_region_id($new_region_id);
			if(count($new_region_id)) {
				$delete_region = array_merge($delete_region, $new_region_id);
			} else {
				continue;
			}
		}

		$this->db->in(array('region_id' => $delete_region))->delete();

		ecjia_admin::admin_log(addslashes($regionname), 'remove', 'area');

		$this->showmessage(sprintf(__('成功删除地区 %s'), $regionname), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}

	private function new_region_id($region_id) {
	    $db = RC_Loader::load_model('region_model');

	    $regions_id = array();
	    if (empty($region_id)) {
	        return $regions_id;
	    }

	    $result = $db->field('region_id')->in(array('parent_id' => $region_id))->select();

	    if (!empty($result)) {
	        foreach($result as $val) {
	            $regions_id[]=$val['region_id'];
	        }
	    }
	    return $regions_id;
	}


	/**
	 * 格式化地区
	 * @param array $list
	 * @param number $pid
	 * @return multitype:unknown
	 */
	private function formart_area(&$list, $pid = 0) {
	    $tree = array();
	    foreach ($list as $v) {
	        if ($v['parent_id'] == $pid) {
	            //是否有子项
	            $v['has_child'] = 1;
	            $v['child'] = $this->formart_area($list, $v['region_id']);
	            $tree[] = $v;
	        }
	    }
	    return $tree;
	}


	/**
	 * 格式化出HTML的地区
	 * @param unknown $list
	 * @param number $pid
	 * @return string
	 */
	private function formart_html(&$list, $pid = 0) {
	    $html = '';
	    foreach ($list as $v) {
	        if ($v['parent_id'] == $pid) {
	            $html .= '<div style="padding-left:10px;">';
	            $html .= '<p class="pid'. $v['parent_id'] .' id'. $v['region_id'] .' type'. $v['region_type'] .'">' . $v['region_name'] . '</p>';
	            $html .= $this->formart_html($list, $v['region_id']);
	            $html .= '</div>';
	        }
	    }
	    return $html;
	}
}

// end