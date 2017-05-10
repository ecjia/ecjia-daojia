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
 * ECJIA 用户评论管理程序
 */
class admin extends ecjia_admin {
	private $db_comment;
	private $db_goods;
	
	public function __construct() {
		parent::__construct();
		
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		$this->db_comment = RC_Loader::load_app_model('comment_model');
		$this->db_goods	  =	RC_Loader::load_app_model('comment_goods_model');
		
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		
		RC_Script::enqueue_script('jquery.toggle.buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/jquery.toggle.buttons.js'));
		RC_Style::enqueue_style('bootstrap-toggle-buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/bootstrap-toggle-buttons.css'));
		
		RC_Script::enqueue_script('comment_manage', RC_App::apps_url('statics/js/comment_manage.js', __FILE__), array(), false, false);
		RC_Script::enqueue_script('appeal', RC_App::apps_url('statics/js/appeal.js', __FILE__), array(), false, false);
		RC_Style::enqueue_style('comment', RC_App::apps_url('statics/css/comment.css', __FILE__));
		//RC_Style::enqueue_style('start', RC_App::apps_url('statics/css/start.css', __FILE__));
		
		RC_Script::localize_script('comment_manage', 'js_lang', RC_Lang::get('comment::comment_manage.js_lang'));
	}
	
	/**
	 * 获取商品评论列表
	 */
	public function init() {
		$this->admin_priv('comment_manage');
		
		$_GET['list'] = !empty($_GET['list']) ?  $_GET['list'] : 1;
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('comment::comment_manage.goods_comment_list')));
		$this->assign('ur_here', RC_Lang::get('comment::comment_manage.goods_comment'));
		
		$this->assign('action_link', array('text' => RC_Lang::get('comment::comment_manage.check_trash_comment'), 'href'=> RC_Uri::url('comment/admin/trash', array('list' => 2))));
		
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('comment::comment_manage.overview'),
			'content'	=> '<p>' . RC_Lang::get('comment::comment_manage.goods_comment_list_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('comment::comment_manage.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:商品评论" target="_blank">'.RC_Lang::get('comment::comment_manage.about_goods_comment_list').'</a>') . '</p>'
		);
		
		$list = $this->get_comment_list();
		$this->assign('comment_list', $list);
		
		$this->assign('select_status', $_GET['select_status']);
		$this->assign('select_rank', $_GET['select_rank']);
		$this->assign('select_img', $_GET['select_img']);
		
		$this->assign('form_action', RC_Uri::url('comment/admin/batch'));
		$this->assign('form_search', RC_Uri::url('comment/admin/init'));
		//$this->assign('dropback_comment', $this->admin_priv('dropback_comment', '', false));
		$this->display('comment_list.dwt');		
	}
	
	/**
	 * 管理员快捷回复评论处理
	 */
	public function quick_reply() {
		$this->admin_priv('comment_update', ecjia::MSGTYPE_JSON);
		
		$list 			  = !empty($_GET['list']) ? $_GET['list'] : 1;
		$comment_id 	  = $_GET['comment_id'];
		$reply_content    = $_GET['reply_content'];
		$status			  = $_GET['status'];
		$db_comment_reply = RC_DB::table('comment_reply');
		if(empty($reply_content)){
			$reply_content='感谢您对本店的支持！我们会更加的努力，为您提供更优质的服务。';
		}
		$data = array(
				'comment_id' 	=> $comment_id,
				'content' 		=> $reply_content,
				'user_type'		=> 'admin',
				'user_id'		=> $_SESSION['admin_id'],
				'add_time'		=> RC_Time::gmtime(),
		);
		$db_comment_reply->insertGetId($data);
		
		ecjia_admin::admin_log('评论ID：'.$comment_id, 'reply', 'users_comment');
		if (isset($_GET['status']) && (!empty($_GET['status']) || $_GET['status'] == '0')) {
			if ($list == 3) {
				$pjaxurl = RC_Uri::url('comment/admin/store_goods_comment_list', array('status' => $_GET['status']));
			} else {
				$pjaxurl = RC_Uri::url('comment/admin/init', array('status' => $_GET['status']));   
			}
		} else {
			if ($list == 3) {
				$pjaxurl = RC_Uri::url('comment/admin/store_goods_comment_list');
			} else {
				$pjaxurl = RC_Uri::url('comment/admin/init');
			}
		}
		return $this->showmessage('回复成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, $pjaxurl);
	}
	
	/**
	 * 回复用户评论(同时查看评论详情)
	 */
	public function reply() {		
		$this->admin_priv('comment_update');
		
		$comment_id = !empty($_GET['comment_id']) ? $_GET['comment_id'] : 0;
		$comment_info = RC_DB::TABLE('comment')->where('comment_id', $comment_id)->first();

		if (empty($comment_info)) {
			return $this->showmessage(RC_Lang::get('comment::comment_manage.no_comment_info'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR );
		}

		/*获取用户头像*/
		$img_url = RC_DB::TABLE('users')->where('user_id', $comment_info['user_id'])->pluck('avatar_img');
		if ($img_url) {
		    $avatar_img = RC_Upload::upload_url().'/'.$img_url;
		} else {
		    $avatar_img = RC_App::apps_url('statics/images/admin_pic.jpg', __FILE__);
		}

		/* 获得评论回复条数 */
		$reply_info = RC_DB::TABLE('comment_reply')->where('comment_id', $comment_id)->get();
		
		if (!empty($reply_info)) {
			foreach ($reply_info as $key => $val) {
				if (($val['user_type'] === 'merchant') && ($val['user_id'] > 0)) {
					$staff_info = RC_DB::table('staff_user')->where('user_id', $val['user_id'])->selectRaw('name,avatar')->first();
					$reply_info[$key]['staff_img'] = RC_Upload::upload_url().'/'.$staff_info['avatar'];
					$reply_info[$key]['staff_name'] = $staff_info['name'];
				}
				if (($val['user_type'] === 'admin') && ($val['user_id'] > 0)) {
					$reply_info[$key]['admin_name'] = RC_DB::table('admin_user')->where('user_id', $val['user_id'])->pluck('user_name');
					$reply_info[$key]['admin_img']  = RC_App::apps_url('statics/images/admin_pic.jpg', __FILE__);
				}
				$reply_info[$key]['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $val['add_time']);
			}
			$reply_info[$key]['content']  = nl2br(htmlspecialchars($reply_info[$key]['content']));
		}
		
		//转换时间
		$comment_info['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $comment_info['add_time']);
		
		//获取评论图片
		$comment_pic_list = RC_DB::TABLE('term_attachment')
                		->where('object_id', $comment_info['comment_id'])
                		->where('object_group', 'comment')
                		->where('object_app', 'ecjia.comment')
                		->select('file_path')
                		->get();

		$shop_info['logo'] = RC_DB::TABLE('merchants_config')
                		->where('store_id', $comment_info['store_id'])
                		->where('code', 'shop_logo')
                		->pluck('value');
        $shop_info['no_logo'] = RC_Uri::admin_url('statics/images/nopic.png');
        
		$shop_info['name'] = RC_DB::TABLE('store_franchisee')
                		->where('store_id', $comment_info['store_id'])
                		->pluck('merchants_name');

		$shop_info['amount'] = RC_DB::TABLE('comment')->where('store_id', $comment_info['store_id'])->count();

		$shop_info['logo_img']  = RC_Upload::upload_url().'/'.$shop_info['logo'];
		//统计该用户其他待审核评论
		$nochecked = RC_DB::TABLE('comment')
		              ->where('store_id', $comment_info['store_id'])
		              ->where('comment_id', '!=', $comment_info['comment_id'])
		              ->where('status', 0)
		              ->count();

		$other_comment = RC_DB::TABLE('comment')
            		->where('store_id', $comment_info['store_id'])
            		->where('comment_id', '!=', $comment_info['comment_id'])
            		->where('status', 0)
            		->take(4)
            		->get();

		//计算好评率、综合评分
		$shop_info['comment_number'] = RC_DB::table('comment')
                		      ->select(RC_DB::raw('count(*) as "all"'), RC_DB::raw('SUM(IF(comment_rank > 3, 1, 0)) as "good"'))
                		      ->where('status', '<>', 3)
                		      ->where('parent_id', 0)
                		      ->where('comment_type', 0)
                		      ->where('store_id', $comment_info['store_id'])
                		      ->first();
		
		if ($shop_info['comment_number']['all'] != 0) {
		    if ($shop_info['comment_number']['good'] == 0) {
		        $shop_info['comment_percent'] = 100;
		    } else {
		        $shop_info['comment_percent'] = round(($shop_info['comment_number']['good'] / $shop_info['comment_number']['all']) * 100);
		    }
		} else {
		    $shop_info['comment_percent'] = 100;
		}
		
		if ($shop_info['comment_percent'] == '100') {
		    $shop_info['composite'] = 5;
		} elseif (($shop_info['comment_percent'] >= 95) && ($shop_info['comment_percent'] < 100)) {
		    $shop_info['composite'] = 4;
		} else {
		    $shop_info['composite'] = 3;
		}
		$here = RC_Lang::get('comment::comment_manage.comment_list');
		$url = RC_Uri::url('comment/admin/init', array('list' => 1));
		/* 模板赋值 */
		$this->assign('comment_info', $comment_info); 		//评论信息
		$this->assign('replay_admin_list', $reply_info); 		//管理员回复信息
		$this->assign('avatar_img', $avatar_img);     //用户头像
		$this->assign('admin_info', $staff_info);   //管理员信息
		$this->assign('comment_pic_list', $comment_pic_list);     //评论图片
		$this->assign('shop_info', $shop_info);     //店铺信息
		$this->assign('nochecked', $nochecked);     
		$this->assign('other_comment', $other_comment);
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($here, $url));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('comment::comment_manage.comment_info')));
		
		$this->assign('ur_here', '评论详情');
		$this->assign('action_link', array('text' => $here, 'href' => $url));
		$this->assign('form_action', RC_Uri::url('comment/admin/action'));
		$this->assign('store_url', RC_Uri::url('comment/admin/store_goods_comment_list', array('store_id' => $comment_info['store_id'], 'list' => 3)));
		
		$this->display('comment_info.dwt');
	}
	
	/**
	 * 处理 回复用户评论
	 */
	public function action() {		
		$this->admin_priv('comment_update', ecjia::MSGTYPE_JSON);

		$ip = RC_Ip::client_ip();
		$comment_id 	= $_POST['comment_id'];
		$reply_content  = $_POST['reply_content'];

		if(empty($reply_content)){
			 return $this->showmessage('请输入回复内容', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		$data = array(
			'comment_id' 	=> $comment_id,
			'content' 		=> $reply_content,
			'user_type'		=> 'admin',
			'user_id'		=> $_SESSION['admin_id'],
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
				
				ecjia_admin::admin_log('评论ID：'.$comment_id, 'reply', 'users_comment');
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
			ecjia_admin::admin_log('评论ID：'.$comment_id, 'reply', 'users_comment');
		}
	    return $this->showmessage('回复成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('comment/admin/reply', array('comment_id' => $comment_id))));
	}
	
	/**
	 * 列表更新评论的状态为批准或者驳回
	 */
	public function check() {
		$this->admin_priv('comment_update', ecjia::MSGTYPE_JSON);
		
		$list		= !empty($_GET['list']) ? $_GET['list'] : '';
		$id		 	= !empty($_GET['comment_id']) 		? intval($_GET['comment_id'])		: 0;
		$page		= !empty($_GET['page']) 		? intval($_GET['page'])		: 1;
		$allow 		= !empty($_POST['check']) 	? $_POST['check']			: '';
		$status		= $_POST['status'];
		$appeal_id = $_GET['id'];
		$store_id = $_GET['store_id'];
		
		if ($status === '') {
			if ($list == 3) {
				$pjaxurl = RC_Uri::url('comment/admin/store_goods_comment_list', array('page' => $page, 'store_id' => $store_id));
			} elseif ($list == 4) {
				$pjaxurl = RC_Uri::url('comment/appeal/detail', array('id' => $appeal_id, 'comment_id' => $id));
			}elseif ($list == 1) {
				$pjaxurl = RC_Uri::url('comment/admin/init', array('page' => $page, 'list' => 1));
			}elseif ($list == 5) {
				$pjaxurl = RC_Uri::url('comment/admin/reply', array('comment_id' => $id));
			}
		} else {
			if ($list == 3) {
			    $pjaxurl = RC_Uri::url('comment/admin/store_goods_comment_list', array('page' => $page, 'status' => $status, 'store_id' => $store_id));
			}elseif ($list == 4) {
				$pjaxurl = RC_Uri::url('comment/admin/init', array('id' => $appeal_id, 'comment_id' => $id));
			}elseif ($list == 1) {
			    $pjaxurl = RC_Uri::url('comment/admin/init', array('status' => $status, 'page' => $page, 'list' => 1));
			} elseif ($list == 5) {
				$pjaxurl = RC_Uri::url('comment/admin/reply', array('comment_id' => $id));
			}
		} 
		
		$db_comment = RC_DB::table('comment');
		
		if ($allow == 'allow') {
			/*允许评论显示 */
			$data = array(
				'status'     => '1'
			);
			$db_comment->where('comment_id', $id)->update($data);
			/*审核通过后更新商品等级*/
			if (!empty($id)) {
				$goods_id = RC_DB::table('comment')->where('comment_id', $id)->pluck('id_value');
			}
			RC_Api::api('comment', 'update_goods_comment', array('goods_id' => $goods_id));
			/*审核通过后送积分*/
			RC_Api::api('comment', 'comment_award', array('comment_id' => $id));
			
			$message = RC_Lang::get('comment::comment_manage.show_success');
		} elseif ($allow == 'forbid') {
			/*禁止评论显示 */
			$data = array(
				'status'     => '0'
			);
			$db_comment->where('comment_id', $id)->update($data);
			if (!empty($id)) {
				$goods_id = RC_DB::table('comment')->where('comment_id', $id)->pluck('id_value');
			}
			RC_Api::api('comment', 'update_goods_comment', array('goods_id' => $goods_id));
		}
		 elseif ($allow == "trashed_comment") {
			/* 移到回收站 */
			$data = array(
				'status'     => '3'
			);
			
			$db_comment->where('comment_id', $id)->update($data);
			$message = RC_Lang::get('comment::comment_manage.trashed_success');
		} 
        
		if ($data['status'] == '3') {
		    ecjia_admin::admin_log('评论ID：'.$id, 'to_trash', 'users_comment');
		} elseif($data['status'] == '0' || $data['status'] == '1') {
		    ecjia_admin::admin_log('评论ID：'.$id, 'comment_status', 'users_comment');
		}
		return $this->showmessage($message, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $pjaxurl));
	}
	
	/**
	 * 删除某一条评论
	 */
	public function remove() {
		$this->admin_priv('comment_delete', ecjia::MSGTYPE_JSON);
		$id = intval($_GET['id']);
		$res = $this->db_comment->comment_delete("comment_id=".$id." or parent_id=".$id);
		
		ecjia_admin::admin_log('', 'remove', 'users_comment');
		return $this->showmessage(RC_Lang::get('comment::comment_manage.drop_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 批量删除用户评论
	 */
	public function batch() {
		$this->admin_priv('comment_delete', ecjia::MSGTYPE_JSON);
		$action = isset($_GET['sel_action']) ? trim($_GET['sel_action']) : 'deny';
		if (!empty($_GET['store_id'])) {
			$store_id = $_GET['store_id'];
		}
		$list = !empty($_GET['list']) ? $_GET['list'] : 1;
		$comment_ids = explode(',', $_POST['checkboxes']);
		$db_comment = RC_DB::table('comment'); 
		
		if (!empty($comment_ids)) {
			switch ($action) {
				case 'allow' :
					$data = array(
						'status' => '1'
					);
					$db_comment->whereIn('comment_id', $comment_ids)->update($data);
					/*审核通过后更新商品等级*/
					if (!empty($comment_ids)) {
						$goods_ids = RC_DB::table('comment')->whereIn('comment_id', $comment_ids)->select('id_value')->get();
						if (!empty($goods_ids)) {
							foreach ($goods_ids as $key => $val) {
								if (!empty($val['id_value'])) {
									RC_Api::api('comment', 'update_goods_comment', array('goods_id' => $val['id_value']));
								}
							}
						}
					}
					/*审核通过后送积分*/
					if (!empty($comment_ids)) {
						foreach ($comment_ids as $v) {
							RC_Api::api('comment', 'comment_award', array('comment_id' => $v));
						}
					}
					
				break;

				case 'deny' :
					$data = array(
						'status' => '0'
					);
					$db_comment->whereIn('comment_id', $comment_ids)->update($data);
					/*驳回后更新商品等级*/
					if (!empty($comment_ids)) {
						$goods_ids = RC_DB::table('comment')->whereIn('comment_id', $comment_ids)->select('id_value')->get();
						if (!empty($goods_ids)) {
							foreach ($goods_ids as $key => $val) {
								if (!empty($val['id_value'])) {
									RC_Api::api('comment', 'update_goods_comment', array('goods_id' => $val['id_value']));
								}
							}
						}
					}
				break;
				
				case 'trashed_comment' :
					$data = array(
						'status' => '3'
					);
				break;
				
				default :
				break;
			}
			$db_comment->whereIn('comment_id', $comment_ids)->update($data);
			
			if ($data['status'] == '3') {
			    ecjia_admin::admin_log('', 'batch_trash', 'users_comment');
			}
			
			$page = empty($_GET['page']) ? '' : $_GET['page'];
			$status = $_GET['status'];
			
			if ($status === 'null') {
				if ($list == 3) {
					$pjaxurl = RC_Uri::url('comment/admin/store_goods_comment_list', array('page' => $page, 'store_id' => $store_id));
				} else {
					$pjaxurl = RC_Uri::url('comment/admin/init', array('page' => $page, 'list' => 1));
				}
			} else {
				if ($list == 3) {
					$pjaxurl = RC_Uri::url('comment/admin/store_goods_comment_list', array('status' => $status, 'page' => $page, 'store_id' => $store_id));
				} else {
					$pjaxurl = RC_Uri::url('comment/admin/init', array('status' => $status, 'page' => $page, 'list' => 1));
				}
			}
			return $this->showmessage(sprintf(RC_Lang::get('comment::comment_manage.operation_success'), count($comment_ids)), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $pjaxurl));
		} else {
			/* 错误信息  */
			return $this->showmessage(RC_Lang::get('system::system.no_select_message'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}

	/**
	 * 商品评论回收站
	 */
	public function trash() {
	    $this->admin_priv('comment_trash_list');
	    $_GET['list'] = !empty($_GET['list']) ?  $_GET['list'] : 2;
	    
	    $this->assign('action_link', array('href'=> RC_Uri::url('comment/admin/init',  array('list' => 1))));
	    ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('评论回收站'));
	    $this->assign('ur_here', '评论回收站');
	     
	    $list = $this->get_comment_list();
	    
	    $this->assign('comment_list', $list);
	    $this->display('comment_trash.dwt');
	}
	
	/**
	 * 获取某一店铺所有商品评论列表
	 */
	public function store_goods_comment_list() {
		$this->admin_priv('comment_manage');
	
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('comment::comment_manage.store_goods_comment_list')));
		$this->assign('ur_here', RC_Lang::get('comment::comment_manage.store_goods_comment'));
	
		$this->assign('action_link', array('text' => RC_Lang::get('comment::comment_manage.comment_list'), 'href'=> RC_Uri::url('comment/admin/init', array('list' => 1))));
	
		ecjia_screen::get_current_screen()->add_help_tab(array(
		'id'		=> 'overview',
		'title'		=> RC_Lang::get('comment::comment_manage.overview'),
		'content'	=> '<p>' . RC_Lang::get('comment::comment_manage.goods_comment_list_help') . '</p>'
				));
		ecjia_screen::get_current_screen()->set_help_sidebar(
		'<p><strong>' . RC_Lang::get('comment::comment_manage.more_info') . '</strong></p>' .
		'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:商品评论" target="_blank">'.RC_Lang::get('comment::comment_manage.about_goods_comment_list').'</a>') . '</p>'
				);
		$_GET['list'] = !empty($_GET['list']) ? $_GET['list'] : 3;		
		$store_id = isset($_GET['store_id']) ? $_GET['store_id'] : 0;	

		$shop_logo = RC_DB::table('merchants_config')->where(RC_DB::raw('store_id'), $store_id)->where(RC_DB::raw('code'), 'shop_logo')->pluck('value');
		if (!empty($shop_logo)) {
			$shop_logo = RC_Upload::upload_url().'/'.$shop_logo;
		} else {
			$shop_logo = RC_Uri::admin_url('statics/images/nopic.png');
		}
		$list_storeinfo = array();
		$list_storeinfo['comment_number'] = RC_DB::table('comment')
		->select(RC_DB::raw('count(*) as "all"'),
				RC_DB::raw('SUM(IF(comment_rank > 3, 1, 0)) as "good"'))
				->where('status', '<>', 3)
				->where('parent_id', 0)
				->where('comment_type', 0)
				->where('store_id', $store_id)
				->first();
				
		if ($list_storeinfo['comment_number']['all'] != 0) {
			if ($list_storeinfo['comment_number']['good'] == 0) {
				$list_storeinfo['comment_percent'] = 100;
			} else {
				$list_storeinfo['comment_percent'] = round(($list_storeinfo['comment_number']['good'] / $list_storeinfo['comment_number']['all']) * 100);
			}
		} else {
			$list_storeinfo['comment_percent'] = 100;
		}
		
		if ($list_storeinfo['comment_percent'] === '100') {
			$comment = array('comment_rank' => 5);
		} elseif (($list_storeinfo['comment_percent'] >= 95) && ($list_storeinfo['comment_percent'] < 100)) {
			$comment = array('comment_rank' => 4);
		} else {
			$comment = array('comment_rank' => 3);
		}
		
		$merchants_name = RC_DB::table('store_franchisee')->where(RC_DB::raw('store_id'), '=', $store_id)->pluck('merchants_name');
		$total_count = $list_storeinfo['comment_number']['all'];
		$comment_percent = $list_storeinfo['comment_percent'];
		
		$list = $this->get_comment_list($store_id);
		$this->assign('comment_list', $list);
		
		$this->assign('comment_percent', $comment_percent);
		$this->assign('comment', $comment);
		$this->assign('total_count', $total_count);
		$this->assign('merchants_name', $merchants_name);
		$this->assign('shop_logo', $shop_logo);
		
		$this->assign('select_status', $_GET['select_status']);
		$this->assign('select_rank', $_GET['select_rank']);
		$this->assign('select_img', $_GET['select_img']);
		$this->assign('store_id', $store_id);
	
		$this->assign('form_action', RC_Uri::url('comment/admin/batch', array('list' => 3, 'store_id' => $store_id)));
		$this->assign('form_search', RC_Uri::url('comment/admin/store_goods_comment_list', array('list' => 3)));
		//$this->assign('dropback_comment', $this->admin_priv('dropback_comment', '', false));
		$this->display('store_goods_comment_list.dwt');
	}
	
	/**
	 * 获取商品评论列表
	 * @access  public
	 * @return  array
	 */
	private function get_comment_list($store_id) {
		/* 查询条件 */
		$filter['keywords'] = empty($_GET['keywords']) ? '' : stripslashes(trim($_GET['keywords']));
	
		$db_comment = RC_DB::table('comment as c');
		
		if (!empty($store_id)) {
			$db_comment->where(RC_DB::raw('c.store_id'), '=', $store_id);
		}
		
		if ($_GET['list'] == '1' || $_GET['list'] == '3') {
			$db_comment->where(RC_DB::raw('c.status'), '<>','3');
		} elseif ($_GET['list'] == 2) {
			$db_comment->where(RC_DB::raw('c.status'), '=','3');
		}
	
		if (!empty($filter['keywords'])) {
			$db_comment->where(RC_DB::raw('c.content'), 'like', '%'.mysql_like_quote($filter['keywords']).'%');
		}
	
		if (isset($_GET['status']) && (!empty($_GET['status']) || $_GET['status'] == '0')) {
			$db_comment->where(RC_DB::raw('c.status'), '=', $_GET['status']);
			$filter['status'] = $_GET['status'];
		}
	
		if (isset($_GET['rank'])) {
			if ($_GET['rank'] == '1') {
				$db_comment->where(RC_DB::raw('c.comment_rank'), '=', '5');
			} elseif ($_GET['rank'] == '2') {
				$db_comment->whereIn(RC_DB::raw('c.comment_rank'), array('3','4'));
			} elseif ($_GET['rank'] == '3') {
				$db_comment->where(RC_DB::raw('c.comment_rank'), '<=', '2');
			}
		}
		if (isset($_GET['has_img']) && (!empty($_GET['has_img']) || $_GET['has_img'] == '0')) {
			$db_comment->where(RC_DB::raw('c.has_image'), '=', $_GET['has_img']);
			$filter['has_img'] = $_GET['has_img'];
		}
		
		$count = $db_comment->count();
		$filter['current_count'] = $count;
				
		$page = new ecjia_page($count, 10, 5);
		$data = $db_comment
		->leftJoin('store_franchisee as sf', RC_DB::raw('c.store_id'), '=', RC_DB::raw('sf.store_id'))
		->leftJoin('goods as g', RC_DB::raw('c.id_value'), '=', RC_DB::raw('g.goods_id'))
		->selectRaw('c.comment_id,c.user_name,c.content,c.add_time,c.id_value,c.comment_rank,c.status,c.has_image,sf.merchants_name,g.goods_name')
		->orderby(RC_DB::raw('c.add_time'), 'desc')
		->take(10)
		->skip($page->start_id-1)
		->get();
		
		$list = array();
		if (!empty($data)) {
			foreach ($data as $row) {
				$row['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $row['add_time']);
				if ($row['has_image'] == '1') {
					$row['imgs'] = RC_DB::table('term_attachment')
					->where(RC_DB::raw('object_id'), '=', $row['comment_id'])
					->where(RC_DB::raw('object_group'), '=', 'comment')
					->where(RC_DB::raw('object_app'), '=', 'ecjia.comment')
					->select('file_path')->get();
					if (!empty($row['imgs'])) {
						foreach ($row['imgs'] as $key => $val) {
							$row['imgs'][$key]['file_path'] =  RC_Upload::upload_url().'/'.$val['file_path'];
						}
					}
				}
				$list[] = $row;
			}
		}
		return array('item' => $list, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc());
	}
}

// end