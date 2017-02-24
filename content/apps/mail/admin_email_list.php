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
 * 邮件订阅---模块的逻辑处理
 * @author songqian
 */
class admin_email_list extends ecjia_admin {
	private $db_email_list;
	
	public function __construct() {
		parent::__construct();
		
		RC_Loader::load_app_func('global');
		assign_adminlog_content();

		$this->db_email_list = RC_Model::model('mail/email_list_model');
		
		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('email_list', RC_App::apps_url('statics/js/email_list.js', __FILE__), array(), false, true);
	}

	public function init() {
		$this->admin_priv('email_list_manage');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mail::email_list.email_list')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('mail::email_list.overview'),
			'content'	=> '<p>' . RC_Lang::get('mail::email_list.email_list_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('mail::email_list.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:邮件订阅管理" target="_blank">'. RC_Lang::get('mail::email_list.about_email_list') .'</a>') . '</p>'
		);
		$this->assign('ur_here', RC_Lang::get('mail::email_list.email_list'));

		$emaildb = $this->get_email_list();
		$this->assign('emaildb', $emaildb);
		$this->assign('stat', RC_Lang::get('mail::email_list.stat'));
		
		$this->assign('form_action', RC_Uri::url('mail/admin_email_list/batch'));
		
		$this->display('email_list.dwt');
	}
	
	public function export() {
		$this->admin_priv('email_list_manage', ecjia::MSGTYPE_JSON);
		
		$emails = $this->db_email_list->email_list_select(1, 'email');

		$out = '';
		if (!empty($emails)) {
			foreach ($emails as $key => $val) {
				$out .= $val['email']."\r\n";
			}
		}

		$contentType = 'text/plain';
		$len = strlen($out);
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s',time()+31536000) .' GMT');
		header('Pragma: no-cache');
		header('Content-Encoding: none');
		header('Content-type: ' . $contentType);
		header('Content-Length: ' . $len);
		header('Content-Disposition: attachment; filename="email_list.txt"');
		echo $out;
		exit;
	}
	
	public function query() {
		$this->admin_priv('email_list_manage', ecjia::MSGTYPE_JSON);
		
		$emaildb = $this->get_email_list();

		$this->assign('emaildb', $emaildb['emaildb']);
		$this->assign('filter', $emaildb['filter']);
		$this->assign('record_count', $emaildb['record_count']);
		$this->assign('page_count', $emaildb['page_count']);
		
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $this->fetch('email_list.dwt.php'), 'filter' => $emaildb['filter'], 'page_count' => $emaildb['page_count']));
	}
	
	/**
	 * 批量操作
	 */
	public function batch() {
		$action = isset($_GET['sel_action']) ? trim($_GET['sel_action']) : ''; 
		
		if (empty($action)) {
			return $this->showmessage(RC_Lang::get('mail::email_list.select_operate'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} elseif ($action == 'remove') {
			$this->admin_priv('email_list_delete', ecjia::MSGTYPE_JSON);
		} else {
			$this->admin_priv('email_list_update', ecjia::MSGTYPE_JSON);
		}
		$ids = !empty($_POST['checkboxes']) ? $_POST['checkboxes'] : '';
		$ids = explode(',', $ids);
		
		if (!empty($ids)){
			$info = $this->db_email_list->email_list_batch($ids, 'select');

			switch ($action) {
				case 'remove':
					$this->db_email_list->email_list_batch($ids, 'delete');

					foreach ($info as $key => $v) {
						ecjia_admin::admin_log(sprintf(RC_Lang::get('mail::email_list.email_address'), $v['email']).'，'.sprintf(RC_Lang::get('mail::email_list.email_id'), $v['id']), 'batch_remove', 'subscription_email');
					}
					
					return $this->showmessage(RC_Lang::get('mail::email_list.batch_remove_succeed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mail/admin_email_list/init')));
					break;
	
				case 'exit' :
					$data = array('stat' => 2);
					$update = $this->db_email_list->email_list_batch($ids, 'update', $data);

					foreach ($info as $key => $v) {
						ecjia_admin::admin_log(sprintf(RC_Lang::get('mail::email_list.email_address'), $v['email']).'，'.sprintf(RC_Lang::get('mail::email_list.email_id'), $v['id']), 'batch_exit', 'subscription_email');
					}
					
					return $this->showmessage(RC_Lang::get('mail::email_list.batch_exit_succeed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mail/admin_email_list/init')));
					break;
	
				case 'ok' :
					$data = array('stat' => 1);
					$update = $this->db_email_list->email_list_batch($ids, 'update', $data);

					foreach ($info as $key => $v) {
						ecjia_admin::admin_log(sprintf(RC_Lang::get('mail::email_list.email_address'), $v['email']).'，'.sprintf(RC_Lang::get('mail::email_list.email_id'), $v['id']), 'batch_ok', 'subscription_email');
					}
					
					return $this->showmessage(RC_Lang::get('mail::email_list.batch_unremove_succeed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mail/admin_email_list/init')));
					break;
						
				default :
					break;
			}
		}
	}
	
	/**
	 * 获取邮件列表
	 * @return array
	 */
	private function get_email_list() {
		$db_email = RC_DB::table('email_list');
		
		$filter['sort_by']    = empty($_GET['sort_by']) ? 'id' : trim($_GET['sort_by']);
		$filter['sort_order'] = empty($_GET['sort_order']) ? 'desc' : trim($_GET['sort_order']);
		
		$count        = $db_email->count();
		$page         = new ecjia_page($count, 15, 5);
		$email_list   = $db_email->orderby($filter['sort_by'], $filter['sort_order'])->take(15)->skip($page->start_id-1)->get();
		
		return array('item' => $email_list, 'filter' => $filter, 'page' => $page->show(5), 'desc' => $page->page_desc());
	}
}

//end