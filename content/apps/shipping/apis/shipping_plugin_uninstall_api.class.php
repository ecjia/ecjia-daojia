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
 * 配送方式卸载API
 * @author royalwang
 */
class shipping_plugin_uninstall_api extends Component_Event_Api 
{
	
	public function call(&$options) 
	{
	    
	    $plugin_data = array();
	    if (isset($options['file'])) {
	        $plugin_file = $options['file'];
	        $plugin_data = RC_Plugin::get_plugin_data($plugin_file);
	         
	        $plugin_file = RC_Plugin::plugin_basename( $plugin_file );
	        $plugin_dir = dirname($plugin_file);
	         
	        $plugins = ecjia_config::instance()->get_addon_config('shipping_plugins', true);
	        unset($plugins[$plugin_dir]);
	         
	        ecjia_config::instance()->set_addon_config('shipping_plugins', $plugins, true);
	    }
		
	    if (isset($options['config']) && !empty($plugin_data['Name'])) {
	        $format_name = $plugin_data['Name'];
	        
	        /* 检查输入 */
	        if (empty($format_name) || empty($options['config']['shipping_code'])) {
	            return ecjia_plugin::add_error('plugin_install_error', RC_Lang::get('shipping::shipping.no_shipping_name'));
	        }
	        
	        RC_Loader::load_app_func('global', 'shipping');
	        
	        $db = RC_Model::model('shipping/shipping_model');
	        $db_area = RC_Model::model('shipping/shipping_area_model');
	        $db_region = RC_Model::model('shipping/shipping_area_region_model');
	        
	        /* 获得该配送方式的ID */
	        $row = $db->field('shipping_id, shipping_name, print_bg')->find("`shipping_code` = '" . $options['config']['shipping_code'] . "'");
	        $shipping_id = $row['shipping_id'];
	        $shipping_name = $row['shipping_name'];
	        
	        /* 删除 shipping_fee 以及 shipping 表中的数据 */
	        if ($row) {
	            $all_area_ids = $db_area->where("`shipping_id` = $shipping_id")->get_field('shipping_area_id', true);
	        
	            if (!empty($all_area_ids)) {
	                $db_region->in(array('shipping_area_id' => $all_area_ids))->delete();
	                $db_area->where("`shipping_id` = $shipping_id")->delete();
	            }
	            $db->where("`shipping_id` = $shipping_id")->delete();
	            	
	            //删除上传的非默认快递单
// 	            if (($row['print_bg'] != '') && (!is_print_bg_default($row['print_bg']))) {
	            if ($row['print_bg'] != '') {
		            	$uploads_dir_info    = RC_Upload::upload_dir();
		            	$data_file_to_delete = $uploads_dir_info[basedir] . $row['print_bg'];
		            	if( is_file($data_file_to_delete) == TRUE ) {
		            		chmod($data_file_to_delete, 0666);
		            		unlink($data_file_to_delete);
		            	}
// 	                unlink(ROOT_PATH . $row['print_bg']);
	            }

	            	
	            //记录管理员操作
	            ecjia_admin::admin_log(addslashes($shipping_name), 'uninstall', 'shipping');
	            
	            return true;
	        }
	    }
	}
}

// end