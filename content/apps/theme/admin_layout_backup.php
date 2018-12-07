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
 * ECJIA 管理中心模板管理程序
 */
defined('IN_ECJIA') or exit('No permission resources.');

class admin_layout_backup extends ecjia_admin {
    
	private $db_template;

	/**
	 * 当前主题对象
	 *
	 * @var \Ecjia\System\Theme\Theme;
	 */
	private $theme;

	public function __construct() {
		parent::__construct();

		$this->db_template    = RC_Loader::load_model('template_widget_model');

		$this->theme          = Ecjia_ThemeManager::driver();

		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-uniform');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('外观'), RC_Uri::url('theme/admin_template/init')));
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('布局设置备份'), RC_Uri::url('theme/admin_layout_backup/init')));
	}

	/**
	 * 布局备份
	 */
	public function init() {
		$this->admin_priv('backup_setting');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('备份')));
		$this->assign('ur_here',      __('模板布局备份'));

		$template_files = $this->theme->getAllowSettingTemplates();

		
		$settingFiles = $this->db_template->getTemplateFiles($this->theme->getThemeCode());

        $files = array();
        foreach ($settingFiles as $file) {
            if (isset($template_files[$file]))
                $files[$file] = $template_files[$file]['Name'];
        }
		
		$this->assign('files', $files);
		$this->assign('action', 'backup');
		
		$this->assign('form_action', RC_Uri::url('theme/admin_layout_backup/backup_setting'));

		$this->display('template_backup.dwt');
	}


	/**
	 * 模板备份
	 */
	public function backup_setting() {
	    $this->admin_priv('backup_setting');
	    
	    $links = array(array('text'=>__('备份布局设置'), 'href' => RC_Uri::url('theme/admin_layout_backup/init')));
	    
		$remarks = empty($_POST['remarks']) ? RC_Time::local_date(ecjia::config('time_format')) : trim($_POST['remarks']);
		
		$files = array_get($_POST, 'files', array());
		
		if (empty($files)) {
		    return $this->showmessage(__('没有选择任何模板文件'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => $links));
		}
		
		if ($this->db_template->hasTemplateSettingBackup()) {
		    return $this->showmessage(sprintf(__('备份注释 %s 已经用过，请换个注释名称'), $remarks), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => $links));
		}
		
		$this->db_template->backupTemplateFiles($this->theme->getThemeCode(), $files, $remarks);

		return $this->showmessage(__('备份设置成功'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_SUCCESS, array('links' => $links));
	}

    /**
     * 删除备份
     */
	public function delete() {
	    $this->admin_priv('backup_setting');
	    
		$remarks = empty($_GET['remarks']) ? '' : trim($_GET['remarks']);
		if ($remarks) {
            $this->db_template->where('theme', $this->theme->getThemeCode())->where('remarks', $remarks)->delete();
		}
		
		$links = array(array('text' => __('备份模板设置'), 'href' => RC_Uri::url('theme/admin_layout_backup/restore')));
		
		return $this->showmessage(__('备份删除成功'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_SUCCESS, array('links' => $links));
    }

    
    /**
     * 还原备份
     */
    public function restore() {
        $this->admin_priv('backup_setting');
        
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('还原')));
        $this->assign('ur_here',      __('模板布局还原'));
        
        
        $rows = $this->db_template->getBackupRemarks($this->theme->getThemeCode());
        
        $remarks = array();
        foreach ($rows as $val) {
            $remarks[] = array('content' => $val['remarks'], 'url' => urlencode($val['remarks']));
        }
        
        $this->assign('list',  $remarks);
        $this->assign('screenshot',  $this->theme->getDefaultStyle()->getScreenshot());
        
        $this->display('template_backup.dwt');
    }

	public function restore_backup() {
	    $this->admin_priv('backup_setting');
	    
		$remarks = empty($_GET['remarks']) ? '' : trim($_GET['remarks']);
		$remarks = urldecode($remarks);
		
		if ($remarks) {
		    $result = $this->db_template->restoreTemplateFiles($this->theme->getThemeCode(), $remarks);

		    $links = array(array('text'=>__('备份布局设置'), 'href' => RC_Uri::url('theme/admin_layout_backup/restore')));
		    
			if (is_ecjia_error($result)) {
			    return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => $links));
			} else {
			    $links = array(array('text'=>__('还原布局设置'), 'href' => RC_Uri::url('theme/admin_layout_backup/restore')));
			     
			    return $this->showmessage(__('恢复备份成功'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_SUCCESS, array('links' => $links));
			}
			
		}
		
		return $this->showmessage(__('备份数据不存在或参数有误'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => $links));
		
	}

}

// end