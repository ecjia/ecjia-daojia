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
/**
 * ECJIA 支付方式管理
 */
defined('IN_ECJIA') or exit('No permission resources.');

use Ecjia\System\Admins\Plugin\ConfigMenu;

class admin_plugin extends ecjia_admin {
	private $addon_model;	
	
	public function __construct() {
		parent::__construct();
		
		RC_Style::enqueue_style('jquery-stepy');

		RC_Script::enqueue_script('ecjia-admin');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-stepy');
		RC_Script::enqueue_script('jquery-dataTables-bootstrap');
		RC_Script::enqueue_script('jquery-dataTables-sorting');
	}

	/**
	 * 插件列表
	 */
	public function init () {
		$this->admin_priv('plugin_manage', ecjia::MSGTYPE_JSON);
		
		RC_Script::enqueue_script('ecjia-admin_plugin');
		
		$admin_plugin_jslang = array(
				'error_intasll'		=> __('参数错误，无法安装！'),
				'error_unintasll'	=> __('参数错误，无法卸载！'),
				'confirm_unintall'	=> __('您确定要卸载这个插件吗？'),
				'ok'				=> __('确定'),
				'cancel'			=> __('取消'),
				'delete_unintall'	=> __('您确定要删除这个插件吗？'),
				'no_delete'			=> __('此插件暂时不能删除。'),	
				'home'				=> __('首页'),
				'last_page'			=> __('尾页'),
				'previous'			=> __('上一页'),
				'next_page'			=> __('下一页'),
				'no_record'			=> __('没有找到任何记录'),	
				'count_num'			=> __('共_TOTAL_条记录 第_START_ 到 第_END_条'),
				'total'				=> __('共0条记录'),
				'retrieval'			=> __('（从_MAX_条数据中检索）')
		);
		RC_Script::localize_script('ecjia-admin_plugin', 'admin_plugin_lang', $admin_plugin_jslang );
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('插件管理')));
		$this->assign('ur_here', __('插件管理'));
		
		ecjia_screen::get_current_screen()->add_help_tab( array(
		'id'        => 'overview',
		'title'     => __('概述'),
		'content'   =>
		'<p>' . __('欢迎访问ECJia智能后台插件管理页面，系统中所有的插件都会显示在此列表中。') . '</p>'
		) );
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
		'<p><strong>' . __('更多信息：') . '</strong></p>' .
		'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:插件管理" target="_blank">关于插件管理帮助文档</a>') . '</p>'
		);

		// 弹窗UI
		RC_Script::enqueue_script('smoke');
		// 下拉框css
		RC_Style::enqueue_style('chosen');
		// 下拉框插件
		RC_Script::enqueue_script('jquery-chosen');
		
		if (!empty($_GET['reload'])) {
			RC_Plugin::clean_plugins_cache();
		}
		
		$active_plugins = ecjia_config::instance()->get_addon_config('active_plugins', true);
		
		/* 取得所有插件列表 */
		$plugins = RC_Plugin::get_plugins();
		
		$use_plugins_num = 0;
		$unuse_plugins_num = 0;
		$this->assign('plugins_num', count($plugins));
		
		foreach ($plugins as $_key => $_value) {
			$true = in_array($_key, $active_plugins);
			$true ? $use_plugins_num++ : $unuse_plugins_num++;
			
			//如果是已安装或未安装，卸载当前项
			if(!empty($_GET['usepluginsnum'])) {
				if (($_GET['usepluginsnum'] == 1 && !$true) || ($_GET['usepluginsnum'] == 2 && $true)) {
					unset($plugins[$_key]);
					continue;
				}
			}
			$plugins[$_key]['install'] = $true ? 1 : 0;
		}

		$this->assign('use_plugins_num', $use_plugins_num);
		$this->assign('unuse_plugins_num', $unuse_plugins_num);
		$this->assign('plugins', $plugins);
		
		$this->display('plugin_list.dwt');
	}

	/**
	* 安装插件
	*/
	public function install() {
		$this->admin_priv('plugin_install', ecjia::MSGTYPE_JSON);
		
		$id = trim($_GET['id']);
		$result = ecjia_plugin::activate_plugin($id);
		if ( is_ecjia_error( $result ) ) {
			if ( 'unexpected_output' == $result->get_error_code() ) {
				return $this->showmessage($result->get_error_data(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} elseif ('plugin_install_error' == $result->get_error_code()) {
				return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} else {
				return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}

		$plugins = RC_Plugin::get_plugins();
		$data = $plugins[$id];
		
		ecjia_admin::admin_log($data['Name'], 'install', 'plugin');
		return $this->showmessage(sprintf(__('%s 插件安装成功！'), $data['Name']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl'=>RC_Uri::url('@admin_plugin/init')));
	}

	/**
	 * 卸载插件
	 */
	public function uninstall() {
		$this->admin_priv('plugin_uninstall', ecjia::MSGTYPE_JSON);
		
		$id = trim($_GET['id']);

		$result = ecjia_plugin::deactivate_plugins(array($id));

		if ( is_ecjia_error( $result ) ) {
			if ( 'unexpected_output' == $result->get_error_code() ) {
				return $this->showmessage($result->get_error_data(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
			} elseif ('plugin_uninstall_error' == $result->get_error_code()) {
				return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} else {
				return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
			}
		}

		$plugins = RC_Plugin::get_plugins();
		$data = $plugins[$id];
		
		ecjia_admin::admin_log($data['Name'], 'uninstall', 'plugin');
		return $this->showmessage(sprintf(__('%s 插件卸载成功！'), $data['Name']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl'=>RC_Uri::url('@admin_plugin/init')));
	}
	
	/**
	 * 插件配置
	 */
	public function config() {
		 
		$this->assign('ur_here', '插件配置');
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('插件配置'));
		
		$menus = ConfigMenu::singleton()->authMenus();

		if (!empty($menus)) {
		    $menu = array_shift($menus);
		    if ($menu->action != 'divider' && $menu->action != 'nav-header') {
		        $this->redirect($menu->link);
		    }
		}

		$this->display('plugin_config.dwt');
	}
	
}

// end