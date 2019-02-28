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

class admin_home_module extends ecjia_admin {

	public function __construct() {
		parent::__construct();

		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');

        RC_Style::enqueue_style('dragslot', RC_App::apps_url('statics/css/dragslot.css', __FILE__), array());
        RC_Style::enqueue_style('style', RC_App::apps_url('statics/css/style.css', __FILE__), array());

		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-uniform');

		RC_Script::enqueue_script('dragslot', RC_App::apps_url('statics/js/dragslot.js', __FILE__), array(), false, 1);
		RC_Script::enqueue_script('admin_home_group', RC_App::apps_url('statics/js/admin_home_group.js', __FILE__), array('ecjia-admin'), false, 1);

	}

	/**
	 * 首页模块管理
	 */
	public function init() {
		$this->admin_priv('home_group_manage');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('首页模块管理', 'theme')));
		$this->assign('ur_here', __('首页模块管理', 'theme'));

		$platform = $this->request->input('platform', 'default');
		$client = $this->request->input('client', 'all');

		//在使用的模块
		$useing_group_code = \Ecjia\App\Theme\ComponentPlatform::getUseingHomeComponentByPlatform($platform, $client);
        $useing_group = [];

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
        $components = \Ecjia\App\Theme\ComponentPlatform::getAvaliableHomeComponentByPlatform($platform);

        $useing_group = array_sort($useing_group, function($item) {
            return $item->getSort();
        });

		$platform_groups = \Ecjia\App\Theme\ComponentPlatform::getPlatformGroups();

		$platform_clients = \Ecjia\App\Theme\ComponentPlatform::getPlatformClents($platform);
		if (count($platform_clients) > 1) {
		    array_unshift($platform_clients, [
		        'device_client' => 'all',
                'device_name' => __('统一设置', 'theme'),
            ]);
        }

        ecjia_screen::get_current_screen()->add_admin_notice(new admin_notice(__('<strong>温馨提示：</strong>首页模块化功能目前仅支持APP端和H5端、门店小程序的平台模板模式。', 'theme'), 'alert-info'));

		if (empty($useing_group)) {
		    if ($platform != 'default') {

		        if ($client != 'all') {
                    ecjia_screen::get_current_screen()->add_admin_notice(new admin_notice(__('当前产品平台客户端未自定义首页模块数据，将使用当前平台的统一设置。', 'theme'), 'alert-warning'));
                } else {
                    ecjia_screen::get_current_screen()->add_admin_notice(new admin_notice(__('当前产品平台未自定义首页模块数据，将使用【默认全局】的设置。', 'theme'), 'alert-warning'));
                }
            }

        }

		$this->assign('avaliable_group', $components);
		$this->assign('useing_group', $useing_group);
		$this->assign('platform_groups', $platform_groups);
		$this->assign('current_platform', $platform);
		$this->assign('platform_clients', $platform_clients);
		$this->assign('current_client', $client);

		$this->display('home_group_module.dwt');
	}
	
	
	/**
	 * 保存排序
	 */
	public function save_sort() {
		$this->admin_priv('home_group_manage', ecjia::MSGTYPE_JSON);

		$modules = $this->request->input('modules');
        $platform = $this->request->input('platform', 'default');
        $client = $this->request->input('client', 'all');

		$result = \Ecjia\App\Theme\ComponentPlatform::saveHomeComponentByPlatform($modules, $platform, $client);
		if (is_ecjia_error($result)) {
		    return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
		
		return $this->showmessage(__('保存排序成功！', 'theme'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,
            array('pjaxurl' => RC_Uri::url('theme/admin_home_module/init', ['platform' => $platform, 'client' => $client])));
	}
	
}

// end
