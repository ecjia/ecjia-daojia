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
 * ECJia百宝箱管理控制器
 */
class admin_discover extends ecjia_admin {
	private $mobile;

	public function __construct() {
		parent::__construct();

		$this->mobile = RC_Loader::load_app_class('mobile_method');

		if (!ecjia::config(mobile_method::STORAGEKEY_discover_data, ecjia::CONFIG_CHECK)) {
			ecjia_config::instance()->insert_config('hidden', mobile_method::STORAGEKEY_discover_data, serialize(array()), array('type' => 'hidden'));
		}
		RC_Loader::load_app_func('global');
		assign_adminlog_content();

		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Style::enqueue_style('chosen');

		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery.toggle.buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/jquery.toggle.buttons.js'));
		RC_Style::enqueue_style('bootstrap-toggle-buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/bootstrap-toggle-buttons.css'));
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		RC_Script::enqueue_script('bootstrap-placeholder');
		
		RC_Script::enqueue_script('discover', RC_App::apps_url('statics/js/discover.js', __FILE__), array(), false, false);
		RC_Script::localize_script('discover', 'js_lang', RC_Lang::get('mobile::mobile.js_lang'));

		ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.discover'), RC_Uri::url('mobile/admin_discover/init')));
	}

	/**
	 * 百宝箱列表页面加载
	 */
	public function init () {
		$this->admin_priv('discover_manage');

		ecjia_screen::$current_screen->remove_last_nav_here();
		ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.discover')));
		$this->assign('ur_here', RC_Lang::get('mobile::mobile.discover_list'));
		$this->assign('action_link_special', array('text' => RC_Lang::get('mobile::mobile.add_discover'), 'href' => RC_Uri::url('mobile/admin_discover/add')));

		$this->assign('uri', RC_Uri::site_url());

		$playerdb = $this->mobile->discover_data(true);
		$this->assign('playerdb', $playerdb);

		$this->display('discover_list.dwt');
	}

	/**
	 * 添加及提交处理
	 */
	public function add() {
		$this->admin_priv('discover_update', ecjia::MSGTYPE_JSON);

		if (empty($_POST['step'])) {
			$url = isset($_GET['url']) ? trim($_GET['url']) : 'http://';
			$src = isset($_GET['src']) ? trim($_GET['src']) : '';
			$sort = 0;
			$display = 1;
			$rt = array(
				'img_src'	     => $src,
				'img_url'	     => $url,
				'img_sort'	     => $sort,
		        'img_display'    => $display,
			);

			$this->assign('rt', $rt);
			ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.add_discover')));
			$this->assign('ur_here', RC_Lang::get('mobile::mobile.add_discover'));
			$this->assign('form_action', RC_Uri::url('mobile/admin_discover/add'));
			$this->assign('action_link', array('text' => RC_Lang::get('mobile::mobile.discover_list'), 'href' => RC_Uri::url('mobile/admin_discover/init')));

			$this->display('discover_edit.dwt');
		}
		// 提交表单处理
		elseif ($_POST['step'] == 2) {

			if (!empty($_FILES['img_file_src']['name'])) {
				$upload = RC_Upload::uploader('image', array('save_path' => 'data/discover', 'auto_sub_dirs' => false));
				$info   = $upload->upload($_FILES['img_file_src']);
				if (!empty($info)) {
					$src = $upload->get_position($info);
				} else {
					return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			} else {
			    return $this->showmessage(RC_Lang::get('mobile::mobile.upload_discover_icon'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}

			if (empty($_POST['img_url'])) {
				return $this->showmessage(RC_Lang::get('mobile::mobile.link_url_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			if (!isset($_POST['img_display'])) {
				$insert_arr = $this->mobile->shortcut_struct(array('src' => $src, 'url' => $_POST['img_url'], 'text' => $_POST['img_text'] ,'display' => 0,'sort' => $_POST['img_sort']));
			} else {
				$insert_arr = $this->mobile->shortcut_struct(array('src' => $src, 'url' => $_POST['img_url'], 'text' => $_POST['img_text'] ,'display' => $_POST['img_display'],'sort' => $_POST['img_sort']));
			}
			$flashdb = $this->mobile->discover_data();
			array_push($flashdb, $insert_arr);

			$id      = count($flashdb);
			$flashdb = $this->mobile->shortcut_sort($flashdb);

			ecjia_config::instance()->write_config(mobile_method::STORAGEKEY_discover_data, serialize($flashdb));

			$links[] = array('text' => RC_Lang::get('mobile::mobile.return_discover_list'), 'href' => RC_Uri::url('mobile/admin_discover/init'));

			ecjia_admin::admin_log($_POST['img_text'], 'add', 'mobile_discover');
			return $this->showmessage(RC_Lang::get('mobile::mobile.add_discover_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links , 'pjaxurl' => RC_Uri::url('mobile/admin_discover/add')));
		}
	}

	/**
	 * 编辑及提交处理
	 */
	public function edit() {
		$this->admin_priv('discover_update', ecjia::MSGTYPE_JSON);

		$id = intval($_REQUEST['id']); //取得id
		$flashdb = $this->mobile->discover_data();
		if (isset($flashdb[$id])) {
			$rt = $flashdb[$id];
		} else {
			$links[] = array('text' => RC_Lang::get('mobile::mobile.discover_list'), 'href' => RC_Uri::url('mobile/admin_discover/init'));
		}

		if (empty($_POST['step'])) {
			$rt['img_url']       = $rt['url'];
			$rt['img_display']   = $rt['display'];
			$rt['img_src']       = $rt['src'];
			$rt['img_txt']       = $rt['text'];
			$rt['img_sort']      = empty($rt['sort']) ? 0 : intval($rt['sort']);
			$rt['id']            = $id;

			ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.edit_discover')));

			$this->assign('ur_here', RC_Lang::get('mobile::mobile.edit_discover'));
			$this->assign('form_action', RC_Uri::url('mobile/admin_discover/edit'));
			$this->assign('action_link', array('text' => RC_Lang::get('mobile::mobile.discover_list'), 'href' => RC_Uri::url('mobile/admin_discover/init')));
			$this->assign('rt', $rt);

			$this->display('discover_edit.dwt');
		}

		// 提交处理
		elseif ($_POST['step'] == 2) {
			// 有上传图片
			if (!empty($_FILES['img_file_src']['name'])) {
				$upload = RC_Upload::uploader('image', array('save_path' => 'data/discover', 'auto_sub_dirs' => false));
				$info = $upload->upload($_FILES['img_file_src']);
				if (!empty($info)) {
					$src = $upload->get_position($info);
					$upload->remove($rt['src']);
				} else {
					return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			}
			// 图片上传不能为空
			elseif (empty($rt['src'])) {
				return $this->showmessage(RC_Lang::get('mobile::mobile.upload_discover_icon'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} else {
			    $src = $rt['src'];
			}

			$display = isset($_POST['img_display']) ? 1 : 0;
			
       		$flashdb[$id] = array(
       			'src'	    => $src,
       			'url'	    => $_POST['img_url'],
       			'display'	=> $display,
       			'text'	    => $_POST['img_text'],
       			'sort'	    => $_POST['img_sort']
       		);

       		$flashdb[$id] = $this->mobile->shortcut_struct($flashdb[$id]);
			$flashdb = $this->mobile->shortcut_sort($flashdb);

			ecjia_config::instance()->write_config(mobile_method::STORAGEKEY_discover_data, serialize($flashdb));

			ecjia_admin::admin_log($_POST['img_text'], 'edit', 'mobile_discover');
		    return $this->showmessage(RC_Lang::get('mobile::mobile.edit_discover_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_discover/init')));
		}
	}

	/**
	 * 删除百宝箱
	 */
	public function remove() {
		$this->admin_priv('discover_delete', ecjia::MSGTYPE_JSON);

		$id = intval($_GET['id']);
		$flashdb = $this->mobile->discover_data();
		if (isset($flashdb[$id])) {
			$rt = $flashdb[$id];
		} else {
			$links[] = array('text' => RC_Lang::get('mobile::mobile.discover_list'), 'href' => RC_Uri::url());
			return $this->showmessage(RC_Lang::get('mobile::mobile.no_appointed_discover'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => $links));
		}

		if (strpos($rt['src'], 'http') === false) {
			$disk = RC_Filesystem::disk();
			$disk->delete(RC_Upload::upload_path() . $rt['src']);
		}

		unset($flashdb[$id]);

		ecjia_config::instance()->write_config(mobile_method::STORAGEKEY_discover_data, serialize($flashdb));

		ecjia_admin::admin_log($rt['text'], 'remove', 'mobile_discover');
		return $this->showmessage(RC_Lang::get('mobile::mobile.drop_discover_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}

	/**
	 * 编辑百宝箱的排序
	 */
	public function edit_sort() {
		$this->admin_priv('discover_update', ecjia::MSGTYPE_JSON);

		$id    = intval($_POST['pk']);
		$order = intval(trim($_POST['value']));

		if (!is_numeric($order)) {
			return $this->showmessage(RC_Lang::get('mobile::mobile.format_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$flashdb              = $this->mobile->discover_data();
			$flashdb[$id]['sort'] = $order;
			$flashdb              = $this->mobile->shortcut_sort($flashdb);

			ecjia_config::instance()->write_config(mobile_method::STORAGEKEY_discover_data, serialize($flashdb));

			return $this->showmessage(RC_Lang::get('mobile::mobile.order_sort_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_uri::url('mobile/admin_discover/init')) );
		}
	}

	/**
	 * 切换是否显示
	 */
	public function toggle_show() {
		$this->admin_priv('discover_update', ecjia::MSGTYPE_JSON);

		$id      = intval($_POST['id']);
		$val	 = intval($_POST['val']);

		$flashdb = $this->mobile->discover_data();
		
		$flashdb[$id]['display']  = $val;
		$text                     = $flashdb[$id]['text'];

		ecjia_config::instance()->write_config(mobile_method::STORAGEKEY_discover_data, serialize($flashdb));
		if ($val == 1) {
			ecjia_admin::admin_log(sprintf(RC_Lang::get('mobile::mobile.display_discover'), $text), 'setup', 'mobile_discover');
		} else {
			ecjia_admin::admin_log(sprintf(RC_Lang::get('mobile::mobile.hide_discover'), $text), 'setup', 'mobile_discover');
		}
		return $this->showmessage(RC_Lang::get('mobile::mobile.edit_discover_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content'=> $val, 'pjaxurl' => RC_uri::url('mobile/admin_discover/init')));
	}
}

// end