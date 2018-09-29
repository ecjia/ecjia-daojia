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
 * ECJIA 首页模块管理
 */

defined('IN_ECJIA') or exit('No permission resources.');

class admin_home_group_sort extends ecjia_admin {

	public function __construct() {
		parent::__construct();

		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-uniform');

		RC_Script::enqueue_script('dragslot', RC_App::apps_url('statics/js/dragslot.js', __FILE__));
		RC_Script::enqueue_script('admin_home_group', RC_App::apps_url('statics/js/admin_home_group.js', __FILE__));
		RC_Style::enqueue_style('dragslot', RC_App::apps_url('statics/css/dragslot.css', __FILE__), array());
		RC_Style::enqueue_style('style', RC_App::apps_url('statics/css/style.css', __FILE__), array());
		
	}

	/**
	 * 首页模块管理
	 */
	public function init() {
		$this->admin_priv('home_group_manage');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('首页模块管理')));
		$this->assign('ur_here', __('首页模块管理'));
		
		//在使用的模块
		$useing_group = [];
		$useing_group_code = ecjia::config('home_visual_page');
		$useing_group_code = unserialize($useing_group_code);
		
		RC_Hook::add_filter('ecjia_theme_component_filter', function ($components) use ($useing_group_code, &$useing_group) {
			foreach ($components as $key => $val) {
				if (in_array($key, $useing_group_code)) {
					$use_key = array_search($key, $useing_group_code);
					$useing_group[$key] = new $val;
					$useing_group[$key]->setSort($use_key);
					unset($components[$key]);
				}
			}
			return $components;
		});
		
	
		//首页所有模块
		$factory = new Ecjia\App\Theme\Factory();
		$components = $factory->getComponents();
		
		usort($useing_group, function($a, $b) {
			if($a->getSort() > $b->getSort()) {
				return 1;
			}
			elseif($a->getSort() < $b->getSort()) {
				return -1;
			}
			else {
				return 0;
			}
		});
		
		$this->assign('avaliable_group', $components);
		$this->assign('useing_group', $useing_group);
		
		$this->display('home_group_sort.dwt');
	}
	
	
	/**
	 * 保存排序
	 */
	public function save_sort() {
		$this->admin_priv('home_group_manage', ecjia::MSGTYPE_JSON);
	
		$sort = $_GET['info'];
		$sort_last = [];
	
		if (!empty($sort)) {
			foreach ($sort as $k => $v) {
					if (!empty($v)) {
						$sort_last[] = $v;
					}
			}
			$sort_last = serialize($sort_last);
		}
		if (!empty($sort_last)) {
			if (!ecjia::config('home_visual_page', ecjia::CONFIG_CHECK)) {
				ecjia_config::instance()->insert_config('text', 'home_visual_page', '', array('type' => 'text'));
			}
			ecjia_config::instance()->write_config('home_visual_page', $sort_last);
		} else {
			ecjia_config::instance()->write_config('home_visual_page', '');
		}
		
		return $this->showmessage('保存排序成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('theme/admin_home_group_sort/init')));
	}
	
}

// end
