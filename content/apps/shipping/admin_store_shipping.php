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
 * 店铺配送方式
 */
class admin_store_shipping extends ecjia_admin
{
    public function __construct()
    {
        parent::__construct();

        RC_Loader::load_app_func('global', 'store');
        RC_Loader::load_app_func('merchant_store', 'store');
        Ecjia\App\Shipping\Helper::assign_adminlog_content();

        //全局JS和CSS
        RC_Script::enqueue_script('smoke');
        RC_Script::enqueue_script('bootstrap-placeholder');
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
        RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
        RC_Script::enqueue_script('jquery-uniform');
        RC_Style::enqueue_style('uniform-aristo');
        RC_Script::enqueue_script('jquery-chosen');
        RC_Style::enqueue_style('chosen');

        RC_Style::enqueue_style('splashy');

        //时间控件
        RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
        RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));
        
        RC_Style::enqueue_style('shipping', RC_App::apps_url('statics/css/merchant_express.css', __FILE__), array());

        $store_id   = intval($_GET['store_id']);
        $store_info = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();
        $nav_here   = __('入驻商家', 'shipping');
        $url        = RC_Uri::url('store/admin/join');
        if ($store_info['manage_mode'] == 'self') {
            $nav_here = __('自营店铺', 'shipping');
            $url      = RC_Uri::url('store/admin/init');
        }
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($nav_here, $url));
    }

    //查看配送方式
    public function init()
    {
        $this->admin_priv('store_shipping_manage');
        
        $store_id = intval($_GET['store_id']);
        if (empty($store_id)) {
            return $this->showmessage(__('请选择您要操作的店铺', 'shipping'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $store = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();
        if ($store['manage_mode'] == 'self') {
            $this->assign('action_link', array('href' => RC_Uri::url('store/admin/init'), 'text' => __('自营店铺列表', 'shipping')));
        } else {
            $this->assign('action_link', array('href' => RC_Uri::url('store/admin/join'), 'text' => __('入驻商家列表', 'shipping')));
        }
        $this->assign('ur_here', $store['merchants_name'] . __(' - 运费模板', 'shipping'));
        
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($store['merchants_name'], RC_Uri::url('store/admin/preview', array('store_id' => $store_id))));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('运费模板', 'shipping')));

        ecjia_screen::get_current_screen()->set_sidebar_display(false);
        ecjia_screen::get_current_screen()->add_option('store_name', $store['merchants_name']);
        ecjia_screen::get_current_screen()->add_option('current_code', 'store_shipping');
        
        $data = $this->get_template_list($store_id);
        $this->assign('data', $data);
        $this->assign('store_id', $store_id);

        return $this->display('store_shipping.dwt');
    }
    
    public function view()
    {
    	$this->admin_priv('store_shipping_manage');
    	 
    	$store_id = intval($_GET['store_id']);
    	if (empty($store_id)) {
    		return $this->showmessage(__('请选择您要操作的店铺', 'shipping'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	
    	$template_name = !empty($_GET['template_name']) ? trim($_GET['template_name']) : '';
    	
    	$store = RC_DB::table('store_franchisee')->where('store_id', $store_id)->first();
        $this->assign('ur_here', $store['merchants_name'] . __(' - 运费模板', 'shipping'));
        
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($store['merchants_name'], RC_Uri::url('store/admin/preview', array('store_id' => $store_id))));
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('运费模板', 'shipping')));

        ecjia_screen::get_current_screen()->set_sidebar_display(false);
        ecjia_screen::get_current_screen()->add_option('store_name', $store['merchants_name']);
        ecjia_screen::get_current_screen()->add_option('current_code', 'store_shipping');
        
    	$this->assign('action_link', array('href' => RC_Uri::url('shipping/admin_store_shipping/init', array('store_id' => $store_id)), 'text' => __('运费模板', 'shipping')));
    	
    	$provinces = ecjia_region::getSubarea(ecjia::config('shop_country')); //获取当前国家的所有省份
    	$this->assign('provinces', $provinces);
    	
    	$data = RC_DB::table('shipping_area')
	    	->where('store_id', $store_id)
	    	->where('shipping_area_name', $template_name)
	    	->get();
    	
    	$regions = array();
    	if (!empty($data)) {
    		foreach ($data as $k => $v) {
    			$shipping_data = RC_DB::table('shipping as s')
	    			->leftJoin('shipping_area as a', RC_DB::raw('a.shipping_id'), '=', RC_DB::raw('s.shipping_id'))
	    			->select(RC_DB::raw('s.shipping_name, s.shipping_code, s.support_cod, a.*'))
	    			->where(RC_DB::raw('a.shipping_area_id'), $v['shipping_area_id'])
	    			->where(RC_DB::raw('a.store_id'), $store_id)
	    			->first();
    			$fields = ecjia_shipping::unserializeConfig($shipping_data['configure']);
    	
    			$data[$k]['fee_compute_mode'] = $fields['fee_compute_mode'];
				$shipping_handle = ecjia_shipping::areaChannel($shipping_data['shipping_area_id']);
				$fields = !is_ecjia_error($shipping_handle) ? $shipping_handle->makeFormData($fields) : array();
				
    			if (!empty($fields)) {
    				foreach ($fields as $key => $val) {
    					if ($shipping_data['shipping_code'] == 'ship_o2o_express' && (in_array($val['name'], array('ship_days', 'last_order_time', 'ship_time', 'express_money')))) {
    						if ($val['name'] == 'ship_time') {
    							$o2o_shipping_time = array();
    							foreach ($val['value'] as $v) {
    								$o2o_shipping_time[] = $v;
    							}
    							$data[$k]['o2o_shipping_time'] = $o2o_shipping_time;
    						}
    						if ($val['name'] == 'ship_days') {
    							$data[$k]['ship_days'] = $o2o_shipping_time;
    						}
    						if ($val['name'] == 'last_order_time') {
    							$data[$k]['last_order_time'] = $o2o_shipping_time;
    						}
    						if ($val['name'] == 'express_money') {
    							$data[$k]['express_money'] = $o2o_shipping_time;
    						}
    						unset($fields[$key]);
    					}
    				}
    			}
    			$data[$k]['fields']        = $fields;
    			$data[$k]['shipping_code'] = $shipping_data['shipping_code'];
    			$data[$k]['shipping_name'] = $shipping_data['shipping_name'];
    	
    			if ($k == 0) {
    				$regions = RC_DB::table('area_region as a')
	    				->leftJoin('regions as r', RC_DB::raw('a.region_id'), '=', RC_DB::raw('r.region_id'))
	    				->where(RC_DB::raw('a.shipping_area_id'), $shipping_data['shipping_area_id'])
	    				->select(RC_DB::raw('r.region_name, r.region_id'))
	    				->get();
    			}
    		}
    	}
    	$this->assign('regions', $regions);
    	
    	$shipping = $this->get_shipping_list($store_id);
    	$this->assign('shipping', $shipping);
    	
    	$this->assign('data', $data);
    	$this->assign('template_name', $template_name);

        return $this->display('store_shipping_info.dwt');
    }
    
    private function get_template_list($store_id = 0)
    {
    	if (empty($store_id)) {
    		return array();
    	}
    	
    	$count = RC_DB::table('shipping_area')
	    	->where('store_id', $store_id)
	    	->groupBy('shipping_area_name')
	    	->get();
    	$count = count($count);
    	$page  = new ecjia_page($count, 10, 5);
    
    	$data = RC_DB::table('shipping_area')
	    	->where('store_id', $store_id)
	    	->take(10)
	    	->select('shipping_area_name')
	    	->skip($page->start_id - 1)
	    	->groupBy('shipping_area_name')
	    	->orderBy('shipping_area_id', 'desc')
	    	->get();
    
    	if (!empty($data)) {
    		foreach ($data as $k => $v) {
    			$shipping_area_list    = RC_DB::table('shipping_area')->where('shipping_area_name', $v['shipping_area_name'])->where('store_id', $store_id)->get();
    			$data[$k]['area_list'] = $shipping_area_list;
    			if (!empty($shipping_area_list)) {
    				$shipping_name = '';
    				$count = count($shipping_area_list);
    				foreach ($shipping_area_list as $key => $val) {
    					if ($key == 0) {
    						$region_name = RC_DB::table('area_region as a')
	    						->leftJoin('regions as r', RC_DB::raw('a.region_id'), '=', RC_DB::raw('r.region_id'))
	    						->where(RC_DB::raw('a.shipping_area_id'), $val['shipping_area_id'])
	    						->lists(RC_DB::raw('r.region_name'));
    						if (!empty($region_name)) {
    							$data[$k]['shipping_area'] = implode(' | ', $region_name);
    						}
    					}
    					$name = RC_DB::table('shipping')->where('shipping_id', $val['shipping_id'])->value('shipping_name');
    					if ($key != $count- 1) {
    						$shipping_name .= $name.'、';
    					} else {
    						$shipping_name .= $name;
    					}
    				}
    				$data[$k]['shipping_name'] = $shipping_name;
    			}
    		}
    	}
    	return array('item' => $data, 'page' => $page->show(5), 'desc' => $page->page_desc());
    }
    
    private function get_shipping_list($store_id = 0)
    {
    	if (empty($store_id)) {
    		return array();
    	}
    	
    	$db = RC_DB::table('shipping as s')
    		->leftJoin('shipping_area as a', function ($join) {
    		$join->on(RC_DB::raw('s.shipping_id'), '=', RC_DB::raw('a.shipping_id'))
    		->where(RC_DB::raw('a.store_id'), '=', $store_id);
    	});
    		
    	$shipping_data = $db
	    	->groupBy(RC_DB::raw('s.shipping_id'))
	    	->orderBy(RC_DB::raw('s.shipping_order'))
	    	->select(RC_DB::raw('s.*, a.shipping_area_id'))
	    	->where(RC_DB::raw('s.enabled'), 1)
	    	->get();
    
    	$plugins = ecjia_config::instance()->get_addon_config('shipping_plugins', true);
    
    	$data = array();
    	foreach ($shipping_data as $_key => $_value) {
    		if (isset($plugins[$_value['shipping_code']])) {
    			$data[$_key]['id']             = $_value['shipping_id'];
    			$data[$_key]['code']           = $_value['shipping_code'];
    			$data[$_key]['name']           = $_value['shipping_name'];
    			$data[$_key]['desc']           = $_value['shipping_desc'];
    			$data[$_key]['cod']            = $_value['support_cod'];
    			$data[$_key]['shipping_order'] = $_value['shipping_order'];
    			$data[$_key]['insure_fee']     = $_value['insure'];
    			$data[$_key]['enabled']        = $_value['enabled'];
    		}
    	}
    
    	return $data;
    }
}

//end
