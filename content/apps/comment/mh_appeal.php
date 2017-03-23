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
 * 申诉管理
 */
class mh_appeal extends ecjia_merchant {
	public function __construct() {
		parent::__construct();
		
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Style::enqueue_style('uniform-aristo');
		
		RC_Script::enqueue_script('mh_appeal', RC_App::apps_url('statics/js/mh_appeal.js', __FILE__));
		RC_Style::enqueue_style('mh_appeal', RC_App::apps_url('statics/css/mh_appeal.css', __FILE__), array());
		RC_Style::enqueue_style('bootstrap-fileupload', RC_App::apps_url('statics/bootstrap-fileupload/bootstrap-fileupload.css', __FILE__), array());
		RC_Script::enqueue_script('bootstrap-fileupload', RC_App::apps_url('statics/bootstrap-fileupload/bootstrap-fileupload.js', __FILE__), array(), false, true);
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here('申诉管理', RC_Uri::url('comment/mh_appeal/init')));
		ecjia_merchant_screen::get_current_screen()->set_parentage('comment', 'comment/mh_appeal.php');
		
	}

	/**
	 *申诉列表页面加载
	 */
	public function init() {
	    $this->admin_priv('mh_appeal_manage');
	    
	    ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here('申诉列表'));
	    $this->assign('ur_here', '申诉列表');
	    
	    $data = $this->appeal_list($_SESSION['store_id']);
	    $this->assign('count', $data['count']);
	    $this->assign('data', $data);
	    
	    $this->assign('search_action',RC_Uri::url('comment/mh_appeal/init'));
	   
	    $this->display('mh_appeal_list.dwt');
	}
	
	/**
	 *发起申诉
	 */
	public function add_appeal() {
		$this->admin_priv('mh_appeal_update');
			
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here('申诉'));
		$this->assign('ur_here', '申诉');

		$comment_id = $_GET['comment_id'];
		$comment_pic_list = RC_DB::TABLE('term_attachment')->where('object_id', $comment_id)->where('object_app', 'ecjia.comment')->where('object_group','comment')->select('file_path')->get();
		
		$comment_info = RC_DB::table('comment')->where('comment_id', $comment_id)->first();
		$comment_info['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $comment_info['add_time']);
		
		$avatar_img = RC_DB::TABLE('users')->where('user_id', $comment_info['user_id'])->pluck('avatar_img');
	
		$this->assign('comment_pic_list', $comment_pic_list);
		$this->assign('comment_info', $comment_info);
		$this->assign('avatar_img', $avatar_img);
		$this->assign('check_status', -1);
		
		$this->assign('form_action',RC_Uri::url('comment/mh_appeal/insert_appeal'));
		
		$this->display('mh_appeal_info.dwt');
	}
	
	/**
	 *发起申诉处理
	 */
	public function insert_appeal() {
		$this->admin_priv('mh_appeal_update', ecjia::MSGTYPE_JSON);
		
		$store_id = $_SESSION['store_id'];
		$comment_id= $_POST['comment_id'];
		$appeal_content = trim($_POST['appeal_content']);
		$appeal_time = RC_Time::gmtime();
		$appeal_sn_six = rand(100000, 999999);
		$appeal_sn = RC_Time::local_date('Ymd', $appeal_time).$appeal_sn_six;
		if(empty($appeal_content)){
			return $this->showmessage('请输入申诉理由', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		};
		$data = array(
			'store_id' 	    => $store_id,
			'appeal_sn' 	=> $appeal_sn,
			'comment_id' 	=> $comment_id,
			'appeal_content'=> $appeal_content,
			'check_status'	=> 1,
			'appeal_time'	=> $appeal_time,
		);
		$appeal_id = RC_DB::table('comment_appeal')->insertGetId($data);
		//处理图片
		$save_path = 'merchant/' . $_SESSION['store_id'] . '/data/appeal/'.RC_Time::local_date('Ymd');
		$upload = RC_Upload::uploader('image', array('save_path' => $save_path, 'auto_sub_dirs' => true));
		$image_info = null;
		if (!empty($_FILES)) {
			$count = count($_FILES['picture']['name']);
			for ($i = 0; $i < $count; $i++) {
				$picture = array(
					'name' 		=> 	$_FILES['picture']['name'][$i],
					'type' 		=> 	$_FILES['picture']['type'][$i],
					'tmp_name' 	=> 	$_FILES['picture']['tmp_name'][$i],
					'error'		=> 	$_FILES['picture']['error'][$i],
					'size'		=> 	$_FILES['picture']['size'][$i],
				);
				if (!empty($picture['name'])) {
					if (!$upload->check_upload_file($picture)) {
						return new ecjia_error('picture_error', $upload->error());
					}
				}
			}
			$image_info	= $upload->batch_upload($_FILES);
		}
		
		if (!empty($image_info)) {
			foreach ($image_info as $image) {
				if (!empty($image)) {
					$image_url	= $upload->get_position($image);
					$data = array(
						'attach_label'  => $image['name'],
						'attach_description' => '申诉图片',
						'object_app'	=> 'ecjia.comment',
						'object_group'	=> 'appeal',
						'object_id'		=> $appeal_id,
						'file_name'     => $image['name'],
						'file_path'		=> $image_url,
						'file_size'     => $image['size'] / 1000,
						'file_mime'     => $image['type'],
						'file_ext'      => $image['ext'],
						'file_hash'     => $image['sha1'],
						'user_id'		=> $_SESSION['staff_id'],
						'user_type'     => 'staff',
						'add_ip'	    => RC_Ip::client_ip(),
						'add_time'		=> RC_Time::gmtime(),
						'in_status'     => 0,
						'is_image'		=> 1,
					);
					RC_DB::table('term_attachment')->insertGetId($data);
				}
			}
		}
		ecjia_merchant::admin_log('发起申诉处理', 'add', 'merchant_appeal');
		return $this->showmessage('申诉提交成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('comment/mh_appeal/detail', array('check_status' => 1,'appeal_sn'=>$appeal_sn))));
	}
	
	/**
	 *申诉-查看详情
	 */
	public function detail() {
		$this->admin_priv('mh_appeal_manage');
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here('申诉详情'));
		$this->assign('ur_here', '申诉详情');
		
		$appeal_sn 		= $_GET['appeal_sn'];
		$appeal = RC_DB::table('comment_appeal')->where('appeal_sn', $appeal_sn)->first();
		$appeal['appeal_time'] = RC_Time::local_date(ecjia::config('time_format'), $appeal['appeal_time']);
		$appeal['process_time'] = RC_Time::local_date(ecjia::config('time_format'), $appeal['process_time']);
		
		$comment_pic_list = RC_DB::TABLE('term_attachment')->where('object_id',  $appeal['comment_id'])->where('object_app', 'ecjia.comment')->where('object_group','comment')->select('file_path')->get();
	
		$comment_info = RC_DB::table('comment')->where('comment_id', $appeal['comment_id'])->first();
		$comment_info['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $comment_info['add_time']);
		$avatar_img = RC_DB::TABLE('users')->where('user_id', $comment_info['user_id'])->pluck('avatar_img');
		$apple_img_list = RC_DB::TABLE('term_attachment')->where('object_id', $appeal['id'])->where('object_app', 'ecjia.comment')->where('object_group','appeal')->select('file_path')->get();
		
		$this->assign('check_status', $appeal['check_status']);
		$this->assign('appeal', $appeal);
		$this->assign('comment_pic_list', $comment_pic_list);
		$this->assign('comment_info', $comment_info);
		$this->assign('avatar_img', $avatar_img);
		$this->assign('apple_img_list', $apple_img_list);

		$this->display('mh_appeal_detail.dwt');
	}
	
	/**
	 * 申诉-撤销
	 */
	public function revoke() {
		$this->admin_priv('mh_appeal_remove', ecjia::MSGTYPE_JSON);
	
		$appeal_sn = $_GET['appeal_sn'];
		$appeal_id = RC_DB::TABLE('comment_appeal')->where('appeal_sn', $appeal_sn)->pluck('id');
		RC_DB::table('term_attachment')->where('object_id', $appeal_id)->where('object_group', 'appeal')->delete();
		RC_DB::table('comment_appeal')->where('appeal_sn', $appeal_sn)->delete();
		
		ecjia_merchant::admin_log('撤销序号:'.$appeal_sn, 'revoke', 'merchant_appeal');
		return $this->showmessage('申诉撤销成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array('pjaxurl' => RC_Uri::url('comment/mh_appeal/init')));
	}
	
	/**
	 * 申诉-列表信息
	 */
	private function appeal_list($store_id) {
		$db_comment_appeal = RC_DB::table('comment_appeal');
		$type = $_GET['type'];
		$filter['keywords'] = empty($_GET['keywords']) ? '' : trim($_GET['keywords']);
		if ($filter['keywords']) {
			$db_comment_appeal->where('appeal_content', 'like', '%'.mysql_like_quote($filter['keywords']).'%');
		}
	
		$db_comment_appeal->where(RC_DB::raw('store_id'), $_SESSION['store_id']);
	
		$type_count = $db_comment_appeal->select(RC_DB::raw('count(*) as count'),
				RC_DB::raw('SUM(IF(check_status = 1,1,0)) as untreated'),
				RC_DB::raw('SUM(IF(check_status != 1,1,0)) as already'))->first();
		
		if ($type == 'untreated') {
			$db_comment_appeal->where('check_status', '=', 1);
		}
		
		if ($type == 'already') {
			$db_comment_appeal->where('check_status', '<>', 1);
		}

		$count = $db_comment_appeal->count();
		$page = new ecjia_merchant_page($count, 10, 5);
		$data = $db_comment_appeal
		->selectRaw('id,appeal_sn,comment_id,appeal_content,check_status,appeal_time,process_time')
		->orderby('appeal_time', 'desc')
		->take(10)
		->skip($page->start_id-1)
		->get();
		
		$list = array();
		if (!empty($data)) {
			foreach ($data as $row) {
				$row['appeal_time'] = RC_Time::local_date(ecjia::config('time_format'), $row['appeal_time']);
				if($row['check_status'] == 1){
					$row['check_status_name'] = '待处理';
				}elseif ($row['check_status'] == 2){
					$row['check_status_name'] = '通过';
				}elseif ($row['check_status'] == 3){
					$row['check_status_name'] = '驳回';
				}
				$row['appeal_pic_list'] = RC_DB::TABLE('term_attachment')->where('object_id',  $row['id'])->where('object_app', 'ecjia.comment')->where('object_group','appeal')->select('file_path')->get();
				$list[] = $row;
			}
		}
		return array('appeal_list' => $list, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc(), 'count' => $type_count);
	}
}

//end