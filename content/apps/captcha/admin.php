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
 * 验证码管理
 */

class admin extends ecjia_admin {
	private $captcha;

	public function __construct() {
		parent::__construct();

		RC_Loader::load_app_config('constant', null, false);
		$this->captcha = RC_Loader::load_app_class('captcha_method');

		if (!ecjia::config('captcha_style', ecjia::CONFIG_CHECK)) {
			ecjia_config::instance()->insert_config('hidden', 'captcha_style', '', array('type' => 'hidden'));
		}

		RC_Style::enqueue_style('fontello');
		RC_Script::enqueue_script('smoke');
		// 单选复选框css
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
	}

	public function init () {
		$this->admin_priv('shop_config');
		
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('captcha', RC_App::apps_url('statics/js/captcha.js', __FILE__), array());
		
		ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(RC_Lang::get('captcha::captcha_manage.captcha_setting')));
		$this->assign('ur_here', RC_Lang::get('captcha::captcha_manage.captcha_setting'));

		$admin_captcha_lang = RC_Lang::get('captcha::captcha_manage.admin_captcha_lang');
		RC_Script::localize_script( 'captcha', 'admin_captcha_lang', $admin_captcha_lang );

		$captcha = intval(ecjia::config('captcha'));
		$captcha_check = array();
		if ($captcha & CAPTCHA_REGISTER) {
			$captcha_check['register'] = 'checked="checked"';
		}
		if ($captcha & CAPTCHA_LOGIN) {
			$captcha_check['login'] = 'checked="checked"';
		}
		if ($captcha & CAPTCHA_COMMENT) {
			$captcha_check['comment'] = 'checked="checked"';
		}
		if ($captcha & CAPTCHA_ADMIN) {
			$captcha_check['admin'] = 'checked="checked"';
		}
		if ($captcha & CAPTCHA_MESSAGE) {
			$captcha_check['message'] = 'checked="checked"';
		}

		if ($captcha & CAPTCHA_LOGIN_FAIL) {
			$captcha_check['login_fail_yes'] = 'checked="checked"';
		} else {
			$captcha_check['login_fail_no'] = 'checked="checked"';
		}

		$captcha_check['captcha_width'] = ecjia::config('captcha_width');
		$captcha_check['captcha_height'] = ecjia::config('captcha_height');
		$this->assign('captcha',          $captcha_check);

		$captchas = $this->captcha->captcha_list();
		$this->assign('captchas', $captchas);
		
		$this->assign('current_captcha', ecjia::config('captcha_style'));
		
		$this->assign('form_action',RC_Uri::url('captcha/admin/save_config'));

		$this->assign_lang();
		$this->display('captcha_list.dwt');
	}


	/**
	 * 保存设置
	 */
	public function save_config() {
		if (RC_ENV::gd_version() == 0) {
			return $this->showmessage(RC_Lang::get('captcha::captcha_manage.captcha_note'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		$captcha = 0;
		$captcha = empty($_POST['captcha_register'])    ? $captcha : $captcha | CAPTCHA_REGISTER;
		$captcha = empty($_POST['captcha_login'])       ? $captcha : $captcha | CAPTCHA_LOGIN;
		$captcha = empty($_POST['captcha_comment'])     ? $captcha : $captcha | CAPTCHA_COMMENT;
		$captcha = empty($_POST['captcha_tag'])         ? $captcha : $captcha | CAPTCHA_TAG;
		$captcha = empty($_POST['captcha_admin'])       ? $captcha : $captcha | CAPTCHA_ADMIN;
		$captcha = empty($_POST['captcha_login_fail'])  ? $captcha : $captcha | CAPTCHA_LOGIN_FAIL;
		$captcha = empty($_POST['captcha_message'])     ? $captcha : $captcha | CAPTCHA_MESSAGE;

		$captcha_width = empty($_POST['captcha_width'])     ? 145 : intval($_POST['captcha_width']);
		$captcha_height = empty($_POST['captcha_height'])   ? 20 : intval($_POST['captcha_height']);

		ecjia_config::instance()->write_config('captcha', $captcha);
		ecjia_config::instance()->write_config('captcha_width', $captcha_width);
		ecjia_config::instance()->write_config('captcha_height', $captcha_height);

        /* 记录日志 */
        ecjia_admin_log::instance()->add_object('captcha', RC_Lang::get('captcha::captcha_manage.captcha'));
        ecjia_admin::admin_log(RC_Lang::get('captcha::captcha_manage.modify_code_parameter'), 'edit', 'captcha');

		return $this->showmessage(RC_Lang::get('captcha::captcha_manage.save_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}

	/**
	 * 切换验证码展示样式
	 */
	public function apply() {
		$this->admin_priv('captcha_manage', ecjia::MSGTYPE_JSON);

		$captcha_code = trim($_GET['code']);
		if (ecjia::config('current_captcha') != $captcha_code) {
			$result = ecjia_config::instance()->write_config('captcha_style', $captcha_code);
			if ($result) {
                /* 记录日志 */
                ecjia_admin_log::instance()->add_object('captcha', RC_Lang::get('captcha::captcha_manage.captcha'));
                ecjia_admin::admin_log($captcha_code, 'use', 'captcha');

				return $this->showmessage(RC_Lang::get('captcha::captcha_manage.install_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('captcha/admin/init')));
			} else {
				return $this->showmessage(RC_Lang::get('captcha::captcha_manage.install_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
	}
}

// end