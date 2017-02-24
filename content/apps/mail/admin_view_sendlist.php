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
 * ECJia 邮件队列管理
 * @author songqian
 */
class admin_view_sendlist extends ecjia_admin {
	private $db_email_sendlist;
	private $db_mail_temp;
	private $email_sendlist_view;
	
	public function __construct() {
		parent::__construct();
		
		RC_Lang::load('view_sendlist');
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		$this->db_email_sendlist	= RC_Model::model('mail/email_sendlist_model');
		$this->db_mail_temp 		= RC_Model::model('mail/mail_templates_model');
		$this->email_sendlist_view 	= RC_Model::model('mail/email_sendlist_viewmodel');

		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('view_sendlist', RC_App::apps_url('statics/js/view_sendlist.js', __FILE__));
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');	
		
		RC_Script::localize_script('view_sendlist', 'js_lang', RC_Lang::get('mail::view_sendlist.js_lang'));
	}
	
	public function init() {
		$this->admin_priv('email_sendlist_manage');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mail::view_sendlist.email_send_list')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('mail::view_sendlist.overview'),
			'content'	=> '<p>' . RC_Lang::get('mail::view_sendlist.send_list_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('mail::view_sendlist.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:邮件对列管理" target="_blank">'. RC_Lang::get('mail::view_sendlist.about_send_list') .'</a>') . '</p>'
		);
		
		$this->assign('ur_here', RC_Lang::get('mail::view_sendlist.email_send_list'));
		$this->assign('pri', RC_Lang::get('mail::view_sendlist.pri'));
		$this->assign('type', RC_Lang::get('mail::view_sendlist.type'));
		
		$listdb = $this->get_send_list();
		if (count($listdb['item']) > 0) {
			$this->assign('isSendAll', 1);
		}
		$this->assign('listdb', $listdb);
		
		$this->assign('form_action', RC_Uri::url('mail/admin_view_sendlist/all_send'));
		$this->assign('search_action', RC_Uri::url('mail/admin_view_sendlist/init'));
		
		$this->display('view_sendlist.dwt');
	}
	
	/**
	 * 删除单个
	 */
	public function remove() {
		$this->admin_priv('email_sendlist_delete', ecjia::MSGTYPE_JSON);
		
		$id   = intval($_GET['id']);
		$info = $this->db_email_sendlist->email_sendlist_find($id);

		$this->db_email_sendlist->email_sendlist_delete($id);

		ecjia_admin::admin_log(sprintf(RC_Lang::get('mail::view_sendlist.email_title'), $info['template_subject']).'，'.sprintf(RC_Lang::get('mail::view_sendlist.email_address'), $info['email']), 'remove', 'subscription_email');
		return $this->showmessage(sprintf(RC_Lang::get('mail::view_sendlist.del_ok'), 1), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }
	
	/**
	 * 批量操作
	 */
	public function batch() {
		$this->admin_priv('email_sendlist_delete', ecjia::MSGTYPE_JSON);
		
		$action = isset($_GET['sel_action']) ? trim($_GET['sel_action']) : '';
		$ids 	= $_POST['checkboxes'];
		
		if (empty($action)) {
			return $this->showmessage(RC_Lang::get('mail::view_sendlist.select_operate'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} elseif ($action == 'batchsend') {
			$this->admin_priv('email_sendlist_update', ecjia::MSGTYPE_JSON);
		}
		if (!is_array($ids)) {
			$ids = explode(',', $ids);
		}
		if (!empty($ids)){
			$info = $this->email_sendlist_view->email_sendlist_select($ids);

			switch ($action) {
				case 'batchdel':
					$this->db_email_sendlist->email_sendlist_delete($ids, true);

					foreach ($info as $key => $v) {
						ecjia_admin::admin_log(sprintf(RC_Lang::get('mail::view_sendlist.email_title'), $v['template_subject']).'，'.sprintf(RC_Lang::get('mail::view_sendlist.email_address'), $v['email']), 'batch_remove', 'email');
					}
					
					return $this->showmessage(sprintf(RC_Lang::get('mail::view_sendlist.del_ok'), count($ids)), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mail/admin_view_sendlist/init')));
					break;
				case 'batchsend' :
					$data = $this->db_email_sendlist->email_sendlist_select($ids, array('pri' => 'DESC', 'last_send' => 'ASC'));
					
					if (!empty($data)) {
						$record_count = array('empty_mail' => 0, 'send_success' => 0, 'send_error' => 0, 'noeffect' => 0);
						foreach ($data as $key => $row) {
							//发送列表不为空，邮件地址为空
							if (!empty($row['id']) && empty($row['email'])) {
								$this->db_email_sendlist->email_sendlist_delete($row['id']);
								$record_count['empty_mail'] ++;
								continue;
							}
								
							//查询相关模板
							$rt = $this->db_mail_temp->mail_templates_find($row['template_id']);
							//如果是模板，则将已存入email_sendlist的内容作为邮件内容
							//否则即是杂质，将mail_templates调出的内容作为邮件内容
							if ($rt['type'] == 'template') {
								$rt['template_content'] = $row['email_content'];
							}
							$arr                 = $this->get_email_setting();
							$row['reply_email']  = $arr['smtp_mail'];
							$row                 = array_merge($row, $arr);
							if ($rt['template_id'] && $rt['template_content']) {
								if (RC_Mail::send_mail('', $row['email'], $rt['template_subject'], $rt['template_content'], $rt['is_html'])) {
									ecjia_admin::admin_log(sprintf(RC_Lang::get('mail::view_sendlist.email_title'), $rt['template_subject']).'，'.sprintf(RC_Lang::get('mail::view_sendlist.email_address'), $row['email']), 'batch_send', 'email');
									//发送成功,从列表中删除
									$this->db_email_sendlist->email_sendlist_delete($row['id']);
									$record_count['send_success'] ++;
								} else {
									//发送出错
									if ($row['error'] < 3) {
										$time = time();
										$data = array(
											'error'     => error + 1,
											'pri'       => 0,
											'last_send' => $time
										);
										$this->db_email_sendlist->email_sendlist_update($row['id'], $data);
									} else {
										//将出错超次的纪录删除
										$this->db_email_sendlist->email_sendlist_delete($row['id']);
									}
									$record_count['send_error'] ++;
								}
							} else {
								//无效的邮件队列
								$this->db_email_sendlist->email_sendlist_delete($row['id']);
								$record_count['noeffect'] ++;
							}
						}
						return $this->showmessage(sprintf(RC_Lang::get('mail::view_sendlist.mailsend_finished'), $record_count['send_success']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('refresh_url' => RC_Uri::url('mail/admin_view_sendlist/init')));
					}
					break;
				default :
					break;
			}
		} else {
			return $this->showmessage(RC_Lang::get('system::system.no_select_message'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}

	/**
	 * 全部发送
	 */
	public function all_send() {
		$this->admin_priv('email_sendlist_send', ecjia::MSGTYPE_JSON);

		$data = $this->db_email_sendlist->email_sendlist_select('', array('pri' => 'DESC', 'last_send' => 'ASC'));

		if (!empty($data)) {
			$record_count = array('empty_mail' => 0, 'send_success' => 0, 'send_error' => 0, 'noeffect' => 0);
			foreach ($data as $key => $row) {
				//发送列表不为空，邮件地址为空
				if (!empty($row['id']) && empty($row['email'])) {
					$this->db_email_sendlist->email_sendlist_delete($row['id']);
					$record_count['empty_mail'] ++;
					continue;
				}
				//查询相关模板
				$rt = $this->db_mail_temp->mail_templates_find($row['template_id']);
				//如果是模板，则将已存入email_sendlist的内容作为邮件内容
				//否则即是杂质，将mail_templates调出的内容作为邮件内容
				if ($rt['type'] == 'template') {
					$rt['template_content'] = $row['email_content'];
				}
				$arr = $this->get_email_setting();
				
				$row['reply_email'] = $arr['smtp_mail'];
				$row = array_merge($row, $arr);
				if ($rt['template_id'] && $rt['template_content']) {
					if (RC_Mail::send_mail('', $row['email'], $rt['template_subject'], $rt['template_content'], $rt['is_html'])) {
						//发送成功,从列表中删除
						ecjia_admin::admin_log(sprintf(RC_Lang::get('mail::view_sendlist.email_title'), $rt['template_subject']).'，'.sprintf(RC_Lang::get('mail::view_sendlist.email_address'), $row['email']), 'all_send', 'email');
						$this->db_email_sendlist->email_sendlist_delete($row['id']);
						$record_count['send_success'] ++;
					} else {
						//发送出错
						if ($row['error'] < 3) {
							$time = time();
							$data = array(
								'error'     => error + 1,
								'pri'       => 0,
								'last_send' => $time
							);
							$this->db_email_sendlist->email_sendlist_update($row['id'], $data);
							$record_count['send_error'] ++;
						} else {
							//将出错超次的纪录删除
							$this->db_email_sendlist->email_sendlist_delete($row['id']);
							$record_count['send_error'] ++;
						}
					}
				} else {
					//无效的邮件队列
					$this->db_email_sendlist->email_sendlist_delete($row['id']);
					$record_count['noeffect'] ++;
				}
			}
		}
		return $this->showmessage(sprintf(RC_Lang::get('mail::view_sendlist.mailsend_finished'), $record_count['send_success']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('refresh_url' => RC_Uri::url('mail/admin_view_sendlist/init')));
	}
	
	/**
	 * 获取邮件队列
	 */
	private function get_send_list() {
		$db_email_sendlist = RC_DB::table('email_sendlist as e');
		
		$typemail_id = isset($_GET['typemail_id']) ? $_GET['typemail_id'] : 0;
		
		if ($typemail_id == 1) {
			$db_email_sendlist->where('type', 'magazine');
		} elseif ($typemail_id == 2) {
			$db_email_sendlist->where('type', 'template');
		}
		$filter['type'] = $typemail_id;
		if (!empty($_GET['pri_id']) || (isset($_GET['pri_id']) && trim($_GET['pri_id'])==='0' )) {
			$db_email_sendlist->where('pri', $_GET['pri_id']);
		}
		
		$filter['sort_by']    = empty($_GET['sort_by']) 	? 'pri' 	: trim($_GET['sort_by']);
		$filter['sort_order'] = empty($_GET['sort_order']) 	? 'DESC' 	: trim($_GET['sort_order']);
		
		$count = $db_email_sendlist->leftJoin('mail_templates as m', RC_DB::raw('m.template_id'), '=', RC_DB::raw('e.template_id'))->count(RC_DB::raw('e.id'));
		$page = new ecjia_page($count, 15, 5);
		
		$row = $db_email_sendlist
			->select(RC_DB::raw('e.id, e.email, e.pri, e.error, FROM_UNIXTIME(e.last_send) AS last_send, m.template_subject, m.type'))
			->orderby($filter['sort_by'], $filter['sort_order'])
			->orderby('last_send', 'desc')
            ->take(15)
        	->skip($page->start_id-1)
       		->get();

		return array('item' => $row, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc());
	}
	
	private function get_email_setting() {
		$mail_config = RC_DB::table('shop_config')->where('parent_id', 5)->orderby('id', 'asc')->get();
		$arr = array();
		if (!empty($mail_config)) {
			foreach ($mail_config as $v){
				$arr[$v['code']] = $v['value'];
			}
		}
		return $arr;
	}
}

//end