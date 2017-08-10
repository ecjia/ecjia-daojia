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
 * ECJIA 配送方式管理程序
 */
class merchant extends ecjia_merchant {
	private $db_shipping;

	public function __construct() {
		parent::__construct();

		RC_Loader::load_app_func('global');
		assign_adminlog_content();

		$this->db_shipping 	= RC_Model::model('shipping/shipping_model');
		
		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		
		RC_Script::enqueue_script('merchant_shipping', RC_App::apps_url('statics/js/merchant_shipping.js', __FILE__));
		RC_Style::enqueue_style('merchant_shipping', RC_App::apps_url('statics/css/merchant_shipping.css', __FILE__), array(), false, false);
		RC_Script::enqueue_script('ecjia.utils');
		RC_Script::enqueue_script('ecjia.common');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Loader::load_app_class('shipping_factory', null, false);
		
      	//时间控件
        RC_Script::enqueue_script('bootstrap-datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.js'));
		RC_Style::enqueue_style('datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.min.css'));
		
		
		RC_Script::localize_script('merchant_shipping', 'js_lang', RC_Lang::get('shipping::shipping.js_lang'));
		RC_Script::localize_script('shopping_admin', 'js_lang', RC_Lang::get('shipping::shipping.js_lang'));
		
		ecjia_merchant_screen::get_current_screen()->set_parentage('shipping', 'shipping/merchant.php');
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here('配送管理', RC_Uri::url('shipping/merchant/init')));
	}

	/**
	 * 配送方式列表  get
	 */
	public function init() { 
		$this->admin_priv('ship_merchant_manage');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('我的配送'));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('shipping::shipping.overview'),
			'content'	=> '<p>' . RC_Lang::get('shipping::shipping.shipping_list_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('shipping::shipping.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:配送方式" target="_blank">'. RC_Lang::get('shipping::shipping.about_shipping_list') .'</a>') . '</p>'
		);
		$this->assign('ur_here', '我的配送');
		
		//已启用的配送方式
		$enabled_data = RC_DB::table('shipping as s')
			->leftJoin('shipping_area as a', function($join) {
				$join->on(RC_DB::raw('s.shipping_id'), '=', RC_DB::raw('a.shipping_id'))
					->where(RC_DB::raw('a.store_id'), '=', $_SESSION['store_id']);
			})
			->groupBy(RC_DB::raw('s.shipping_id'))
			->orderBy(RC_DB::raw('s.shipping_order'))
			->selectRaw('s.*, a.shipping_area_id')
			->where(RC_DB::raw('s.enabled'), 1)
			->whereNotNull(RC_DB::raw('a.shipping_area_id'))
			->get();
		
		//未启用的配送方式
		$disabled_data = RC_DB::table('shipping as s')
			->leftJoin('shipping_area as a', function($join) {
				$join->on(RC_DB::raw('s.shipping_id'), '=', RC_DB::raw('a.shipping_id'))
					->where(RC_DB::raw('a.store_id'), '=', $_SESSION['store_id']);
			})
			->groupBy(RC_DB::raw('s.shipping_id'))
			->orderBy(RC_DB::raw('s.shipping_order'))
			->selectRaw('s.*, a.shipping_area_id')
			->where(RC_DB::raw('s.enabled'), 1)
			->whereNull(RC_DB::raw('a.shipping_area_id'))
			->get();
		
		$plugins = ecjia_config::instance()->get_addon_config('shipping_plugins', true);
		
		/* 插件已经安装了，获得名称以及描述 */
		$enabled_modules = $disabled_modules = array();
		
		//已启用
		foreach ($enabled_data as $_key => $_value) {
			if (isset($plugins[$_value['shipping_code']])) {
				$enabled_modules[$_key]['id']      			= $_value['shipping_id'];
				$enabled_modules[$_key]['code']      		= $_value['shipping_code'];
				$enabled_modules[$_key]['name']    			= $_value['shipping_name'];
				$enabled_modules[$_key]['desc']    			= $_value['shipping_desc'];
				$enabled_modules[$_key]['cod']     			= $_value['support_cod'];
				$enabled_modules[$_key]['shipping_order'] 	= $_value['shipping_order'];
				$enabled_modules[$_key]['insure_fee']  		= $_value['insure'];
				$enabled_modules[$_key]['enabled'] 			= $_value['enabled'];
				 
				/* 判断该派送方式是否支持保价 支持报价的允许在页面修改保价费 */
				$shipping_handle = new shipping_factory($_value['shipping_code']);
				$config          = $shipping_handle->configure_config();
		
				/* 只能根据配置判断是否支持保价  只有配置项明确说明不支持保价，才是不支持*/
				if (isset($config['insure']) && ($config['insure'] === false)) {
					$enabled_modules[$_key]['is_insure'] = false;
				} else {
					$enabled_modules[$_key]['is_insure'] = true;
				}
			}
		}
		$this->assign('enabled', $enabled_modules);
		
		//未启用
		foreach ($disabled_data as $_key => $_value) {
			if (isset($plugins[$_value['shipping_code']])) {
				$disabled_modules[$_key]['id']      			= $_value['shipping_id'];
				$disabled_modules[$_key]['code']      			= $_value['shipping_code'];
				$disabled_modules[$_key]['name']    			= $_value['shipping_name'];
				$disabled_modules[$_key]['desc']    			= $_value['shipping_desc'];
				$disabled_modules[$_key]['cod']     			= $_value['support_cod'];
				$disabled_modules[$_key]['shipping_order'] 		= $_value['shipping_order'];
				$disabled_modules[$_key]['insure_fee']  		= $_value['insure'];
				$disabled_modules[$_key]['enabled'] 			= $_value['enabled'];
					
				/* 判断该派送方式是否支持保价 支持报价的允许在页面修改保价费 */
				$shipping_handle = new shipping_factory($_value['shipping_code']);
				$config          = $shipping_handle->configure_config();
		
				/* 只能根据配置判断是否支持保价  只有配置项明确说明不支持保价，才是不支持*/
				if (isset($config['insure']) && ($config['insure'] === false)) {
					$disabled_modules[$_key]['is_insure'] = false;
				} else {
					$disabled_modules[$_key]['is_insure'] = true;
				}
			}
		}
		$this->assign('disabled', $disabled_modules);
		
		$this->display('shipping_list.dwt');
	}
}	

// end