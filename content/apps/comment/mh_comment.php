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
 * 评论管理
 */
class mh_comment extends ecjia_merchant {
	public function __construct() {
		parent::__construct();
		
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		RC_Style::enqueue_style('jquery-placeholder');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-ui');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('jquery-colorbox');
		RC_Style::enqueue_style('jquery-colorbox');
		
		RC_Script::enqueue_script('bootstrap-editable-script', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/bootstrap-fileupload/bootstrap-fileupload.js', array());
		RC_Style::enqueue_style('bootstrap-fileupload', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/bootstrap-fileupload/bootstrap-fileupload.css', array(), false, false);
		RC_Style::enqueue_style('mh_comment', RC_App::apps_url('statics/css/mh_comment.css', __FILE__), array());
		RC_Script::enqueue_script('mh_comment', RC_App::apps_url('statics/js/mh_comment.js', __FILE__), array(), false, true);
		
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here('评论管理', RC_Uri::url('comment/mh_comment/init')));
		ecjia_merchant_screen::get_current_screen()->set_parentage('comment', 'comment/mh_comment.php');
	}

	
	/**
	 * 评论列表页面
	 */
	public function init() {
	    $this->admin_priv('mh_comment_manage');
	    
	    ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here('评论列表'));
	    $this->assign('ur_here', '评论列表');
	    $goods_id = $_GET['goods_id'];
	    $data = $this->comment_list($goods_id);
	    $this->assign('data', $data);
	    
	    if(!empty($goods_id)){
	    	$goods_info = RC_DB::TABLE('goods')->where('goods_id', $goods_id)->select('goods_name', 'shop_price', 'goods_thumb')->first();
	    	$goods_rank = RC_DB::TABLE('goods_data')->where('goods_id', $goods_id)->pluck('goods_rank');
	    	if(empty($goods_rank)){
	    		$goods_rank === 10000;
	    	}
	    	$goods_info['goods_rank'] = $goods_rank / 100;
	    	$this->assign('goods_info', $goods_info);
	    	$this->assign('goods_id',  $goods_id);
	    }

	    $this->assign('select_rank', $_GET['select_rank']);
	    $this->assign('select_img',  $_GET['select_img']);
	    
	    $this->display('mh_comment_list.dwt');
	}

	/**
	 * 管理员快捷回复评论处理
	 */
	public function comment_reply() {
	    $this->admin_priv('mh_comment_manage', ecjia::MSGTYPE_JSON);
	    
	    $comment_id 	= $_GET['comment_id'];
	    $reply_content  = $_GET['reply_content'];
	    if(empty($reply_content)){
	    	$reply_content='感谢您对本店的支持！我们会更加的努力，为您提供更优质的服务。';
	    }
	    $data = array(
	    	'comment_id' 	=> $comment_id,
	    	'content' 		=> $reply_content,
	    	'user_type'		=> 'merchant',
	    	'user_id'		=> $_SESSION['staff_id'],
	    	'add_time'		=> RC_Time::gmtime(),
	    );
	    RC_DB::table('comment_reply')->insertGetId($data);
	    
		$id_value = RC_DB::TABLE('comment')->where('comment_id', $comment_id)->where('status', 0)->pluck('id_value');
		if(!empty($id_value)){
			$data = array(
				'status' => 1
			);
			RC_DB::table('comment')->where('comment_id', $comment_id)->update($data);
			RC_Api::api('comment', 'update_goods_comment', array('goods_id' => $id_value));
			RC_Api::api('comment', 'comment_award', array('comment_id' => $comment_id));
		}

	    ecjia_merchant::admin_log('评论ID:'.$comment_id, 'reply', 'users_comment');
	   	return $this->showmessage('回复成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('comment/mh_comment/init')));
	}
	
	/**
	 * 评论详情页面
	 */
	public function comment_detail() {
	    $this->admin_priv('mh_comment_manage');
	    
	    ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here('评论详情'));
	    $this->assign('ur_here', '评论详情');
	    
		$comment_id = $_GET['comment_id'];
		$comment_info = RC_DB::table('comment')->where('comment_id', $comment_id)->first();
		$comment_info['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $comment_info['add_time']);
		
		$avatar_img = RC_DB::TABLE('users')->where('user_id', $comment_info['user_id'])->pluck('avatar_img');
		
		$replay_admin_list = RC_DB::TABLE('comment_reply')->where('comment_id', $comment_id)->select('content', 'add_time', 'user_id', 'user_type')->get();
		foreach ($replay_admin_list as $key => $val) {
			$replay_admin_list[$key]['add_time_new'] = RC_Time::local_date(ecjia::config('time_format'), $val['add_time']);
			$staff_info = RC_DB::TABLE('staff_user')->where('user_id', $val['user_id'])->select('name', 'avatar')->first();
			$replay_admin_list[$key]['staff_name'] = $staff_info['name'];
			$replay_admin_list[$key]['staff_img']  =  $staff_info['avatar'];
			$replay_admin_list[$key]['admin_user_name']  = RC_DB::TABLE('admin_user')->where('user_id', $val['user_id'])->pluck('user_name');
		};
		
		$goods_info = RC_DB::TABLE('goods')->where('goods_id', $comment_info['id_value'])->select('goods_name', 'shop_price', 'goods_thumb')->first();
		$order_time = RC_DB::TABLE('order_info')->where('order_id',  $comment_info['order_id'])->pluck('add_time');
		$order_add_time = RC_Time::local_date(ecjia::config('time_format'), $order_time);
	
		$other_comment = RC_DB::TABLE('comment')->where('store_id', $_SESSION['store_id'])->where('id_value', $comment_info['id_value'])->where('comment_id', '!=', $comment_info['comment_id'])->select('user_name', 'content', 'comment_rank', 'comment_id','id_value')->take(4)->get();
		
		$comment_pic_list = RC_DB::TABLE('term_attachment')->where('object_id', $comment_info['comment_id'])->where('object_app', 'ecjia.comment')->where('object_group','comment')->select('file_path')->get();

		$appeal_count = RC_DB::TABLE('comment_appeal')->where('comment_id', $comment_id)->where('check_status', 1)->count();
		if($appeal_count > 0 ){
			$this->assign('go_on_appeal', 'go_on_appeal');
		}

		$this->assign('comment_info', $comment_info);
		$this->assign('avatar_img', $avatar_img);
		$this->assign('replay_admin_list', $replay_admin_list);
		$this->assign('goods_info', $goods_info);
		$this->assign('order_add_time', $order_add_time);
		$this->assign('other_comment', $other_comment);
		$this->assign('comment_pic_list', $comment_pic_list);
		
		$this->assign('from_action',RC_Uri::url('comment/mh_comment/comment_detail_reply'));
		
	    $this->display('mh_comment_detail.dwt');
	}
	
	/**
	 * 管理员详情页面回复处理
	 */
	public function comment_detail_reply() {
		$this->admin_priv('mh_comment_manage', ecjia::MSGTYPE_JSON);
		 
		$comment_id 	= $_POST['comment_id'];
		$reply_content  = $_POST['reply_content'];
		if(empty($reply_content)){
			 return $this->showmessage('请输入回复内容', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$data = array(
			'comment_id' 	=> $comment_id,
			'content' 		=> $reply_content,
			'user_type'		=> 'merchant',
			'user_id'		=> $_SESSION['staff_id'],
			'add_time'		=> RC_Time::gmtime(),
		);
		$email_status = $_POST['is_ok'];
		if($email_status){
			$reply_email = $_POST['reply_email'];
			$comment_info = RC_DB::TABLE('comment')->where('comment_id', $comment_id)->select('user_name', 'content')->first();
			$user_name 			= $comment_info['user_name'];
			$message_content 	= $comment_info['content'];
			$message_note 		= $reply_content;
			
			if(!empty($reply_email)){
				RC_DB::table('comment_reply')->insertGetId($data);
				
				ecjia_merchant::admin_log('评论ID:'.$comment_id, 'reply', 'users_comment');
				$tpl_name = 'user_message';
				$template   = RC_Api::api('mail', 'mail_template', $tpl_name);
				if (!empty($template)) {
					$this->assign('user_name', 	$user_name);
					$this->assign('message_content', $message_content);
					$this->assign('message_note',   $message_note);
					$this->assign('shop_name',   ecjia::config('shop_name'));
					$this->assign('send_date',   RC_Time::local_date(ecjia::config('date_format')));
					RC_Mail::send_mail('', $reply_email, $template['template_subject'], $this->fetch_string($template['template_content']), $template['is_html']);
				}
			}else{
				return $this->showmessage('请输入邮件地址', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}else{
			RC_DB::table('comment_reply')->insertGetId($data);
			ecjia_merchant::admin_log('评论ID:'.$comment_id, 'reply', 'users_comment');
		}
		$id_value = RC_DB::TABLE('comment')->where('comment_id', $comment_id)->where('status', 0)->pluck('id_value');
		if(!empty($id_value)){
			$data = array(
				'status' => 1
			);
			RC_DB::table('comment')->where('comment_id', $comment_id)->update($data);
			RC_Api::api('comment', 'update_goods_comment', array('goods_id' => $id_value));
			RC_Api::api('comment', 'comment_award', array('comment_id' => $comment_id));
		}
		
	    return $this->showmessage('回复成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('comment/mh_comment/comment_detail',array('comment_id' => $comment_id))));
	}

	/**
	 * 评论-列表信息
	 */
	private function comment_list($goods_id) {
		$db_comment = RC_DB::table('comment');
		$db_comment->where(RC_DB::raw('store_id'), $_SESSION['store_id']);
		$db_comment->where(RC_DB::raw('status'), '<>','3');
		
		if(!empty($goods_id)){
			$db_comment->where(RC_DB::raw('id_value'), $goods_id);
		}
		
		$filter['keywords'] = empty($_GET['keywords']) ? '' : trim($_GET['keywords']);
		if ($filter['keywords']) {
			$db_comment->where('user_name', 'like', '%'.mysql_like_quote($filter['keywords']).'%');
		}
		
		//评分级别
		if (isset($_GET['rank'])) {
		    if ($_GET['rank'] == '1') {
		        $db_comment->where(RC_DB::raw('comment_rank'), '5');
		    } elseif ($_GET['rank'] == '2') {
		        $db_comment->whereIn(RC_DB::raw('comment_rank'), array('3','4'));
		    } elseif ($_GET['rank'] == '3') {
		        $db_comment->where(RC_DB::raw('comment_rank'), '<=', '2');
		    }
		}
		
		//有无晒图
		if (isset($_GET['has_img']) && (!empty($_GET['has_img']) || $_GET['has_img'] == '0')) {
		    $db_comment->where(RC_DB::raw('has_image'), '=', $_GET['has_img']);
		    $filter['has_img'] = $_GET['has_img'];
		}
		
		$count = $db_comment->count();
		$page = new ecjia_merchant_page($count, 10, 5);
		$data = $db_comment
		->selectRaw('comment_id,user_name,content,add_time,id_value,comment_rank,id_value')
		->orderby('add_time', 'desc')
		->take(10)
		->skip($page->start_id-1)
		->get();
	
		$list = array();
		if (!empty($data)) {
			foreach ($data as $row) {
				$row['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $row['add_time']);
				$row['goods_name'] = RC_DB::TABLE('goods')->where('goods_id', $row['id_value'])->pluck('goods_name');
				$row['comment_pic_list'] = RC_DB::TABLE('term_attachment')->where('object_id',  $row['comment_id'])->where('object_app', 'ecjia.comment')->where('object_group','comment')->select('file_path')->get();
				$list[] = $row;
			}
		}
		return array('comment_list' => $list, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc());
	}
}

//end