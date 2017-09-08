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
class admin_region extends ecjia_admin {

	public function __construct() {
		parent::__construct();
		
		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('admin_region_manage', RC_App::apps_url('statics/js/admin_region_manage.js', __FILE__), array(), false, true);
		RC_Script::enqueue_script('setting', RC_App::apps_url('statics/js/setting.js', __FILE__), array(), false, true);
		RC_Script::localize_script('setting', 'js_lang', RC_Lang::get('setting::setting.js_lang'));
	}

	/**
	 * 列出某地区下的所有地区列表
	 */
	public function init() {
		$this->admin_priv('region_manage');
		
		$this->assign('ur_here', __('地区列表'));
		//ecjia_screen::get_current_screen()->add_help_tab(array(
		//	'id'        => 'overview',
		//	'title'     => __('概述'),
		//	'content'   => '<p>' . __('欢迎访问ECJia智能后台地区设置页面，用户可以在此进行设置地区。') . '</p>'
		//));
		
		//ecjia_screen::get_current_screen()->set_help_sidebar(
		//'<p><strong>' . __('更多信息：') . '</strong></p>' .
		//'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:系统设置#.E5.9C.B0.E5.8C.BA.E5.88.97.E8.A1.A8" target="_blank">关于地区设置帮助文档</a>') . '</p>'
		//);

		$id = isset($_GET['id']) ? trim($_GET['id']) : 'CN';
		
		$region_arr = RC_DB::table('region_cn')->where('parent_id', $id)->get();
		
		if ($id != 'CN') {
			$p_info = RC_DB::table('region_cn')->where('region_id', $id)->first();
		}
		
		if ($id == 'CN') {
			$region_type = 1;
		} else {
			$region_type = $p_info['region_type'] + 1;
		}
		
		//面包屑显示当前地区
		$re_ids = array();
		if ($region_type == 2){
			$re_id2 = $id;
			$re_ids = array($re_id2);
		} elseif ($region_type == 3){
			$re_id2 = substr(trim($_GET['id']), 0, 4);
			$re_id3 = $id;
			$re_ids = array($re_id2, $re_id3);
		} elseif ($region_type == 4) {
			$re_id2 = substr(trim($_GET['id']), 0, 4);
			$re_id3 = substr(trim($_GET['id']), 0, 6);
			$re_id4 = $id; 
			$re_ids = array($re_id2, $re_id3, $re_id4);
		} elseif ($region_type == 5) {
			$re_id2 = substr(trim($_GET['id']), 0, 4);
			$re_id3 = substr(trim($_GET['id']), 0, 6);
			$re_id4 = substr(trim($_GET['id']), 0, 8 );
			$re_id5 = $id;
			$re_ids = array($re_id2, $re_id3, $re_id4, $re_id5);
		}
		
		$str_last = '';
		if ($region_type != 1) {
			$current_name = RC_DB::table('region_cn')->whereIn('region_id', $re_ids)->lists('region_name');
			if (count($current_name >= 2)) {
				$end = array_slice($current_name,-1,1);
				$current_name_new = array_diff($current_name, $end);
				foreach ($current_name_new as $key => $val) {
					$str .= '<li>'.$val.'</li>';
				}
				$str_last .= $str.'<li class="last">'.$end['0'].'</li>';
				
			} else {
				$end = array_slice($current_name,-1,1);
				$str_last .= '<li class="last">'.$end['0'].'</li>';
			}
			ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('<li>地区列表</li>'.$str_last)));
		} else {
			ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('地区列表')));
		}
	
		$this->assign('region_arr',   $region_arr);
		$this->assign('parent_id',    $id);
		$this->assign('region_type',  $region_type);

		if ($id != 'CN' ) {
			$this->assign('action_link', array('href'=>RC_Uri::url('setting/admin_region/init', 'id='.$p_info['parent_id']), 'text' => __('返回上级')));
		}

		$this->display('region_list.dwt');
	}


	/**
	 * 添加新的地区
	 */
	public function add_area() {
		$this->admin_priv('region_manage', ecjia::MSGTYPE_JSON);
		
		$parent_id      = trim($_POST['parent_id']);
		$region_name    = trim($_POST['region_name']);
		$region_type    = intval($_POST['region_type']);
		$index_letter   = trim($_POST['index_letter']);
		$region_id   	= trim($_POST['region_id']);
		$index_letter   = strtoupper($index_letter);
		$region_id_length = strlen($region_id);
		
		if (($region_type === 4) || ($region_type === 5)) {
			if($region_id_length != 3) {
				$this->showmessage(__('当前级地区码只能填3位数字！'),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		} else {
			if ($region_id_length != 2) {
				$this->showmessage(__('当前级地区码只能填2位数字！'),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		
		$region_id = trim($parent_id.$region_id);

		if (empty($region_name)) {
			$this->showmessage(__('区域名称不能为空！'),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		/* 查看地区码是否重复 */		
		$is_only = RC_DB::table('region_cn')->where('region_id', $region_id)->where('region_type', $region_type)->count();
		if ($is_only) {
			$this->showmessage(__('抱歉，当前级已经有相同的地区码存在！'),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$data = array(
				'region_id'	  => $region_id,
				'parent_id'   => $parent_id,
				'region_name' => $region_name,
				'region_type' => $region_type,
				'index_letter'=> $index_letter,
				'country'	  => 'CN'
			);
			
			$region_id = RC_DB::table('region_cn')->insert($data);
			if ($region_id) {
				$region_href = RC_Uri::url('setting/admin_region/drop_area',array('id' => $region_id));
				//日志
				ecjia_admin::admin_log($region_name, 'add','area');
				//更新地区版本
// 				$region_cn_version = ecjia::config('region_cn_version');
// 				$version = substr(trim($region_cn_version), -6) + 1;
// 				$new_version = sprintf("%06d", $version);
// 				$last_version = substr(trim($region_cn_version), 0, 9).$new_version;
// 				ecjia_config::instance()->write_config('region_cn_version', $last_version);
				if ($parent_id == 'CN') {
					$this->showmessage(__('添加新地区成功！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array('pjaxurl' => RC_Uri::url('setting/admin_region/init')));
				} else {
					$this->showmessage(__('添加新地区成功！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array('pjaxurl' => RC_Uri::url('setting/admin_region/init', array('id' => $parent_id))));
				}
				
			} else {
				$this->showmessage(__('添加新地区失败！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
	}

	/**
	 * 编辑区域名称
	 */
	public function edit_area_name() {
		$this->admin_priv('region_manage', ecjia::MSGTYPE_JSON);

		$region_id          = trim($_POST['region_id']);
		$region_name 		= trim($_POST['region_name']);
		$index_letter 		= trim($_POST['index_letter']);
		$index_letter		= strtoupper($index_letter);
		
		if (empty($region_name)) {
			$this->showmessage(__('区域名称不能为空！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$old = RC_DB::table('region_cn')->selectRaw('region_name,parent_id')->where('region_id', $region_id)->first();
		$parent_id = $old['parent_id'];
		$old_name  = $old['region_name'];
		
		$data = array(
				'region_name' => $region_name,
				'index_letter'=> $index_letter,
		);
		$region_id = RC_DB::table('region_cn')->where('region_id', $region_id)->update($data);
		
		if ($region_id) {
			//日志
			ecjia_admin::admin_log(sprintf(__('更新地区名称为 %s'), $region_name), 'edit', 'area');
			
			//更新地区版本
// 			$region_cn_version = ecjia::config('region_cn_version');
// 			$version = substr(trim($region_cn_version), -6) + 1;
// 			$new_version = sprintf("%06d", $version);
// 			$last_version = substr(trim($region_cn_version), 0, 9).$new_version;
// 			ecjia_config::instance()->write_config('region_cn_version', $last_version);
			
			$this->showmessage(__('修改名称成功！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('setting/admin_region/init', array('id' => $parent_id))));
		} else {
			$this->showmessage(__('修改名称失败！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
	}

	/**
	 * 删除区域
	 */
	public function drop_area() {
		$this->admin_priv('region_manage', ecjia::MSGTYPE_JSON);

		$id = trim($_GET['id']);
		
		$region = RC_DB::table('region_cn')->where('region_id', $id)->first();		
		$regionname      = $region['region_name'];
		
		//含id自己
		$parent_ids = $this->GetIds($id);
		
		if (!empty($parent_ids) && is_array($parent_ids)) {
			$delete_region = array_merge(array($id), $parent_ids);
		}
		
		RC_DB::table('region_cn')->whereIn('region_id', $delete_region)->delete();
		//日志
		ecjia_admin::admin_log(addslashes($regionname), 'remove', 'area');
		//更新地区版本
// 		$region_cn_version = ecjia::config('region_cn_version');
// 		$version = substr(trim($region_cn_version), -6) + 1;
// 		$new_version = sprintf("%06d", $version);
// 		$last_version = substr(trim($region_cn_version), 0, 9).$new_version;
// 		ecjia_config::instance()->write_config('region_cn_version', $last_version);
		$this->showmessage(sprintf(__('成功删除地区 %s'), $regionname), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}


	/**
	 * 子集ids
	 * @return array
	 */
	public static function GetIds($parent_id){
		if($parent_id){
			if(is_array($parent_id)){
				$data = RC_DB::table('region_cn')->whereIn('parent_id', $parent_id)->lists('region_id');
			}else{
				$data = RC_DB::table('region_cn')->where('parent_id', $parent_id)->lists('region_id');
			}
			
			if(!empty($data)){
				$datas = self::GetIds($data) ? array_merge($data,self::GetIds($data)) : $data;
			}else{
				$datas = array('0' =>$parent_id);
			}
		}
		return $datas;
	}
	
	
	/**
	 * 获取地区信息
	 */
	public function get_regioninfo() {
		$this->admin_priv('region_manage', ecjia::MSGTYPE_JSON);
		//本地当前版本和检测时间
		$region_cn_version = ecjia::config('region_cn_version');
		$region_last_checktime = ecjia::config('region_last_checktime');
		$time = \RC_Time::gmtime();
		$time_last_format = RC_Time::local_date(ecjia::config('time_format'), $region_last_checktime);
		
		//同步检测时间间隔不能小于7天
		if ($time - $region_last_checktime < 7*24*60*60) {
			//更新检测时间
			ecjia_config::instance()->write_config('region_last_checktime', $time);
			$this->showmessage(__('当前版本已是最新版本，上次更新时间是（'.$time_last_format.'）'),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('setting/admin_region/init')));
		}
		

		$page = !empty($_GET['page']) ? intval($_GET['page']) + 1 : 1;
		$params = array(
				'pagination' => array('page' => $page, 'count' => 1500),
				'region_cn_version' => $region_cn_version,
		);
		
		//获取ecjia_cloud对象
		$cloud = ecjia_cloud::instance()->api('region/synchrony')->data($params)->run();
		//判断是否有错误返回
		if (is_ecjia_error($cloud->getError())) {
		    $this->showmessage($cloud->getError()->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('setting/admin_region/init')));
		}

		//获取每页可更新数		
		$data = $cloud->getReturnData();

		//获取分页信息
		$pageinfo = $cloud->getPaginated();

		if (!empty($data['last_regions'])) {
			$region_cn_version_new = $data['region_cn_version'];
			if ($pageinfo['more'] == 1) {
				$count = count($data['last_regions'])*$page;
			} else{
				$count = count($data['last_regions'])*($page -1) +  count($data['last_regions']);
			}
			$update_data = $data['last_regions'];
			
			//首次先清空本地地区表
			$first_page = intval($_GET['page']);
			if ($first_page == 0) {
				RC_DB::table('region_cn')->where('country', 'CN')->delete();
			}
			
			//批量插入
			RC_DB::table('region_cn')->insert($update_data);
		}

		if ($pageinfo['more'] > 0) {
			return $this->showmessage(sprintf(RC_Lang::get('setting::setting.get_region_already'), $count), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => RC_Uri::url("setting/admin_region/get_regioninfo"), 'notice' => 1, 'page' => $page, 'more' => $pageinfo['more']));
		} else {
			//更新地区表最后检查日期和本地版本
			ecjia_config::instance()->write_config('region_last_checktime', \RC_Time::gmtime());
			ecjia_config::instance()->write_config('region_cn_version', $region_cn_version_new);
			return $this->showmessage(RC_Lang::get('setting::setting.get_regioninfo_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('setting/admin_region/init')));
		}
	}
}

// end