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

class admin_ecjia_express extends ecjia_admin
{
    public function __construct()
    {
        parent::__construct();

        Ecjia\App\Shipping\Helper::assign_adminlog_content();

        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');
        RC_Style::enqueue_style('chosen');
        RC_Style::enqueue_style('uniform-aristo');
        RC_Script::enqueue_script('jquery-uniform');
        RC_Script::enqueue_script('jquery-chosen');
        RC_Script::enqueue_script('admin_ship_ecjia_express', RC_App::apps_url('statics/js/admin_ship_ecjia_express.js', __FILE__), array(), false, true);
        RC_Script::localize_script('admin_ship_ecjia_express', 'js_lang', config('app-express::jslang.express_page'));

        RC_Script::enqueue_script('bootstrap-datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.js'));
        RC_Style::enqueue_style('datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.min.css'));
    }

    /**
     * 配置页面
     */
    public function init()
    {
        $this->admin_priv('shipping_config_update');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('众包配送设置', 'express')));
        
        $this->assign('ur_here', __('众包配送设置', 'express'));
        $this->assign('current_code', 'ecjia_express_set');
        $this->assign('form_action', RC_Uri::url('express/admin_ecjia_express/update'));
        
        if (!ecjia::config('plugin_ship_ecjia_express', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('hidden', 'plugin_ship_ecjia_express', '', array('type' => 'text'));
        }
        $config = ecjia::config('plugin_ship_ecjia_express');
        $config = $fields = ecjia_shipping::unserializeConfig($config);

        $shipping_handle = ecjia_shipping::channel('ship_ecjia_express');
        $fields = !is_ecjia_error($shipping_handle) ? $shipping_handle->makeFormData($fields) : array();
        $this->assign('fields', $fields);
        
        if (!empty($config)) {
        	foreach ($config as $key => $val) {
        		if ((in_array($key, array('ship_days', 'last_order_time', 'ship_time', 'express')))) {
        			if ($key == 'ship_days') {
        				$this->assign('ship_days', $val);
        			}
        			if ($key == 'last_order_time') {
        				$this->assign('last_order_time', $val);
        			}
        			if ($key == 'ship_time') {
        				$o2o_shipping_time = array();
        				foreach ($val as $v) {
        					$o2o_shipping_time[] = $v;
        				}
        				$this->assign('o2o_shipping_time', $o2o_shipping_time);
        			}
        			if ($key == 'express') {
        				$express = array();
        				foreach ($val as $v) {
        					$express[] = $v;
        				}
        				$this->assign('o2o_express', $express);
        			}
        		}
        		/*上门取货设置*/
        		if ($shipping_data['shipping_code'] == 'ship_cac') {
        			if ($key == 'pickup_days') {
        				$this->assign('pickup_days', $val);
        			}
        			if ($key == 'pickup_time') {
        				$cac_pickup_time = array();
        				foreach ($val as $v) {
        					$cac_pickup_time[] = $v;
        				}
        				$this->assign('cac_pickup_time', $cac_pickup_time);
        			}
        		}
        	}
        }
        
        $shipping_array = RC_DB::table('shipping')->where('enabled', 1)->lists('shipping_code');
        $in = false;
        if (in_array('ship_ecjia_express', $shipping_array)) {
        	$in = true;
        }
        $this->assign('in', $in);
        
        $shipping_data = RC_DB::table('shipping')
	        	->select('shipping_name', 'shipping_code', 'support_cod')
	        	->where('shipping_code', 'ship_ecjia_express')
	        	->first();
        $this->assign('shipping_data', $shipping_data);
        
        $this->display('shipping_ecjia_express.dwt');
    }
    
    public function update() {
    	$this->admin_priv('shipping_config_update', ecjia::MSGTYPE_JSON);
    	 
    	$shipping_data = RC_DB::table('shipping')
    		->where('shipping_code', 'ship_ecjia_express')
    		->select('shipping_name', 'shipping_code', 'support_cod', 'shipping_id')
    		->first();
    	
    	$config = array();
    	$shipping_handle = ecjia_shipping::channel($shipping_data['shipping_code']);
    	$config = !is_ecjia_error($shipping_handle) ? $shipping_handle->makeFormData($config) : array();

    	if (!empty($config)) {
    		foreach ($config as $key => $val) {
    			$config[$key]['name']  = $val['name'];
    			$config[$key]['value'] = $_POST[$val['name']];
    		}
    	}
    	
    	$count = count($config);
    	/*商家配送和众包配送的设置*/
    	if ($shipping_data['shipping_code'] == 'ship_o2o_express' || $shipping_data['shipping_code'] == 'ship_ecjia_express') {
    		$time = array();
    		foreach ($_POST['start_ship_time'] as $k => $v) {
    			$start_time = trim($v);
    			if (empty($start_time)) {
    				return $this->showmessage(__('配送开始时间不能为空', 'express'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    			}
    			$end_time = trim($_POST['end_ship_time'][$k]);
    			if (empty($end_time)) {
    				return $this->showmessage(__('配送结束时间不能为空', 'express'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    			}
    			$time[$k]['start']	= $v;
    			$time[$k]['end']	= $_POST['end_ship_time'][$k];
    		}
    		$express = array();
    		foreach ($_POST['express_distance'] as $k => $v) {
    			$express_distance = floatval($v);
    			if (empty($express_distance)) {
    				return $this->showmessage(__('配送距离只能为数值且不能为空', 'express'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    			}
    			$express_money = floatval($_POST['express_money'][$k]);
    			if (empty($express_money)) {
    				return $this->showmessage(__('配送费只能为数值且不能为空', 'express'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    			}
    			$express[$k]['express_distance'] = $v;
    			$express[$k]['express_money']	= $_POST['express_money'][$k];
    		}
    		$config[$count]['name']     = 'ship_days';
    		$config[$count]['value']    = empty($_POST['ship_days']) ? 7 : intval($_POST['ship_days']);
    		$count++;
    		$config[$count]['name']     = 'last_order_time';
    		$config[$count]['value']    = empty($_POST['last_order_time']) ? '' : trim($_POST['last_order_time']);
    		$count++;
    		$config[$count]['name']     = 'ship_time';
    		$config[$count]['value']    = empty($time) ? '' : $time;
    		$count++;
    		$config[$count]['name']     = 'express';
    		$config[$count]['value']    = empty($express) ? '' : $express;
    	}
    	ecjia_config::instance()->write_config('plugin_ship_ecjia_express', serialize($config));
		RC_DB::table('shipping_area')->where('shipping_id', $shipping_data['shipping_id'])->update(array('configure' => serialize($config)));
		
    	$url = RC_Uri::url('express/admin_ecjia_express/init');
    	return $this->showmessage(__('编辑成功', 'express'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $url));
    }

}

//end
