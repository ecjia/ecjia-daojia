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

class admin_mail_settings extends ecjia_admin {
	private $db;
	
	public function __construct() {
		parent::__construct();
		$this->db = RC_Loader::load_model('shop_config_model');
		
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		
		RC_Script::enqueue_script('mail_settings', RC_App::apps_url('statics/js/mail_settings.js', __FILE__));
		
		$mail_settings_jslang = array(
			'pls_select_smtp'		=> __('请输入发送邮件服务器地址(SMTP)！'),
			'required_port'			=> __('请输入服务器端口！'),
			'required_account'		=> __('请输入邮件帐号！'),
			'check_account'			=> __('请输入正确格式的邮件帐号！'),
			'required_password'		=> __('请输入邮件密码！'),
			'required_reply_account'=> __('请输入回复邮件帐号！'),
			'check_reply_account'	=> __('请输入正确格式的回复邮件帐号！'),
			'required_send_account'	=> __('请输入发送邮件帐号！'),
			'check_send_account'	=> __('请输入正确格式的发送邮件帐号！')
		);
		RC_Script::localize_script('mail_settings', 'mail_settings', $mail_settings_jslang );
	
	}
	
	/**
	 * 邮件服务器设置
	 */
	public function init() {
		$this->admin_priv('mail_settings_manage');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('邮件服务器设置')));
		$this->assign('ur_here',      __('邮件服务器设置'));
		$this->assign('ur_heretest',      __('测试邮件'));
		
		ecjia_screen::get_current_screen()->add_help_tab( array(
		'id'        => 'overview',
		'title'     => __('概述'),
		'content'   =>
		'<p>' . __('欢迎访问ECJia智能后台邮件服务器设置页面，可通过以下两种方式进行配置。') . '</p>'
		) );
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
		'<p><strong>' . __('更多信息：') . '</strong></p>' .
		'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:系统设置#.E9.82.AE.E4.BB.B6.E6.9C.8D.E5.8A.A1.E5.99.A8.E8.AE.BE.E7.BD.AE" target="_blank">关于邮件服务器设置帮助文档</a>') . '</p>'
		);
	
		$arr = $this->get_settings(array(5));
		$this->assign('cfg', $arr[5]['vars']);
		
		$this->assign('form_action', RC_Uri::url('mail/admin_mail_settings/update'));
		$this->display('shop_config_mail_settings.dwt');
	}
	
	/**
	 * 商店设置表单提交处理
	 */
	public function update() {
		$this->admin_priv('mail_settings_manage', ecjia::MSGTYPE_JSON);
	
		$arr  = array();
		$data = $this->db->field('id, value')->select();
		foreach ($data as $row) {
			$arr[$row['id']] = $row['value'];
		}
		foreach ($_POST['value'] AS $key => $val) {
			if($arr[$key] != $val){
				$data = array(
					'value' => trim($val),
				);
				$this->db->where(array('id'=>$key))->update($data);
			}
		}
	
		/* 记录日志 */
		ecjia_admin::admin_log('', 'edit', 'shop_config');
	
		/* 清除缓存 */
		ecjia_config::instance()->clear_cache();
		ecjia_cloud::instance()->api('product/analysis/record')->data(ecjia_utility::get_site_info())->run();

		ecjia_admin_log::instance()->add_object('maill', '邮件服务器');
		ecjia_admin::admin_log(__('修改邮件服务器设置'), 'edit', 'maill');
		
		$this->showmessage('邮件服务器设置成功。' , ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array('pjaxurl' => RC_Uri::url('mail/admin_mail_settings/init')));
	}
	
	
	/**
	 * 发送测试邮件
	 */
	public function send_test_email() {
		$this->admin_priv('mail_settings_manage', ecjia::MSGTYPE_JSON);

		/* 取得参数 */
		RC_Hook::remove_action('reset_mail_config', 'ecjia_mail_config');
		RC_Hook::add_action('reset_mail_config', function($config){
			royalcms('config')->set('mail.host',        trim($_POST['smtp_host']));
			royalcms('config')->set('mail.port',        trim($_POST['smtp_port']));
			royalcms('config')->set('mail.from.address', trim($_POST['reply_email']));
			royalcms('config')->set('mail.from.name',   ecjia::config('shop_name'));
			royalcms('config')->set('mail.username',    trim($_POST['smtp_user']));
			royalcms('config')->set('mail.password',    trim($_POST['smtp_pass']));
			royalcms('config')->set('mail.charset',     trim($_POST['mail_charset']));
	
			if (intval($_POST['smtp_ssl']) === 1) {
			    royalcms('config')->set('mail.encryption', 'ssl');
			} else {
			    royalcms('config')->set('mail.encryption', 'tcp');
			}
	
			if (intval($_POST['mail_service']) === 1) {
			    royalcms('config')->set('mail.driver', 'smtp');
			} else {
			    royalcms('config')->set('mail.driver', 'mail');
			}
		});

		$test_mail_address = trim($_POST['test_mail_address']);

		$error = RC_Mail::send_mail('', $test_mail_address, __('测试邮件'), __('您好！这是一封检测邮件服务器设置的测试邮件。收到此邮件，意味着您的邮件服务器设置正确！您可以进行其它邮件发送的操作了！'), 0);
		if ( RC_Error::is_error($error) ) {
			$this->showmessage(sprintf(__('测试邮件发送失败！%s'), $error->get_error_message()) , ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$this->showmessage(sprintf(__('恭喜！测试邮件已成功发送到 %s。'), $test_mail_address), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		}
	}
	
	
	/**
	 * 获得设置信息
	 *
	 * @param   array   $groups     需要获得的设置组
	 * @param   array   $excludes   不需要获得的设置组
	 *
	 * @return  array
	 */
	private function get_settings($groups=array(), $excludes=array()) {
		$config_groups = '';
		$excludes_groups = '';
	
		if (!empty($groups)) {
			foreach ($groups AS $key=>$val) {
				$config_groups .= " AND (id='$val' OR parent_id='$val')";
			}
		}
	
		if (!empty($excludes)) {
			foreach ($excludes AS $key=>$val) {
				$excludes_groups .= " AND (parent_id<>'$val' AND id<>'$val')";
			}
		}
	
		$item_list = $this->db->where('type <>"hidden"'.$config_groups . $excludes_groups)->order(array('parent_id' => 'asc', 'sort_order' => 'asc', 'id' => 'asc'))->select();
	
		/* 整理数据 */
		$group_list     = array();
		$cfg_name_lang  = RC_Lang::get('system::shop_config.cfg_name');
		$cfg_desc_lang  = RC_Lang::get('system::shop_config.cfg_desc');
		$cfg_range_lang = RC_Lang::get('system::shop_config.cfg_range');
	
		/* 增加图标数组 */
		$icon_arr = array(
			'shop_info'		=> 'fontello-icon-wrench',
			'basic'			=> 'fontello-icon-info',
			'display'		=> 'fontello-icon-desktop',
			'shopping_flow'	=> 'fontello-icon-truck',
			'goods'			=> 'fontello-icon-gift',
			'sms'			=> 'fontello-icon-chat-empty',
			'wap'			=> 'fontello-icon-tablet'
		);
	
		foreach ($item_list AS $key => $item) {
			$pid          = $item['parent_id'];
			$item['name'] = isset($cfg_name_lang[$item['code']]) ? $cfg_name_lang[$item['code']] : $item['code'];
			$item['desc'] = isset($cfg_desc_lang[$item['code']]) ? $cfg_desc_lang[$item['code']] : '';
				
			if ($item['type']=='file' && !empty($item['value'])) {
				if($item['code']=='icp_file') {
					$item['file_name'] = array_pop(explode('/', $item['value']));
				}
				$item['value'] = RC_Upload::upload_url() .'/'. $item['value'];
			}
			if ($item['code'] == 'sms_shop_mobile') {
				$item['url'] = 1;
			}
			if ($pid == 0) {
				/* 分组 */
				$item['icon'] = isset($icon_arr[$item['code']]) ? $icon_arr[$item['code']] : '';
				if ($item['type'] == 'group') {
					$group_list[$item['id']] = $item;
				}
			} else {
				/* 变量 */
				if (isset($group_list[$pid])) {
					if ($item['store_range']) {
						$item['store_options'] = explode(',', $item['store_range']);
	
						foreach ($item['store_options'] AS $k => $v) {
							$item['display_options'][$k] = isset($cfg_range_lang[$item['code']][$v]) ?
							$cfg_range_lang[$item['code']][$v] : $v;
						}
					}
					$group_list[$pid]['vars'][] = $item;
				}
			}
		}
		return $group_list;
	}
}

// end