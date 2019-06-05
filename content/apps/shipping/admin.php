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
class admin extends ecjia_admin
{
    public function __construct()
    {
        parent::__construct();

        Ecjia\App\Shipping\Helper::assign_adminlog_content();

        /* 加载全局 js/css */
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');

        RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
        RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));

        RC_Script::enqueue_script('ecjia.utils');
        RC_Script::enqueue_script('ecjia.common');
        RC_Style::enqueue_style('chosen');
        RC_Style::enqueue_style('uniform-aristo');
        RC_Script::enqueue_script('jquery-uniform');
        RC_Script::enqueue_script('jquery-chosen');
        RC_Loader::load_app_class('shipping_factory', null, false);

        //时间控件
        RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.min.css'));
        RC_Script::enqueue_script('bootstrap-timepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.js'));

        RC_Script::enqueue_script('shipping_admin', RC_App::apps_url('statics/js/shipping_admin.js', __FILE__), array(), false, 1);
      
        RC_Script::enqueue_script('acejs', RC_Uri::admin_url('statics/lib/acejs/ace.js'), array(), false, true);
        RC_Script::enqueue_script('acejs-emmet', RC_Uri::admin_url('statics/lib/acejs/ext-emmet.js'), array(), false, true);
        RC_Script::enqueue_script('template', RC_App::apps_url('statics/js/template.js', __FILE__), array(), false, 1);
        
        //js语言包
        RC_Script::localize_script('shipping_admin', 'js_lang', config('app-shipping::jslang.shipping_template_page'));
        RC_Script::localize_script('template', 'admin_template_lang', config('app-shipping::jslang.shipping_template_page'));

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('配送方式', 'shipping'), RC_Uri::url('shipping/admin_plugin/init')));
    }
    
    /**
     * 上传模板图片
     */
    public function print_upload()
    {
        $this->admin_priv('ship_update');

        $allow_suffix = array('jpg', 'png', 'jpeg');
        $shipping_id  = !empty($_POST['shipping_id']) ? intval($_POST['shipping_id']) : 0;

        if (!empty($_FILES['bg']['name'])) {
            /*在前端已做对文件上传类型的限制*/
            if (!RC_File::file_suffix($_FILES['bg']['name'], $allow_suffix)) {
            	$allow_suffix_string = implode(',', $allow_suffix);
                return $this->showmessage(sprintf(__('错误：文件类型不正确。请上传%s类型的文件！', 'shipping'), $allow_suffix_string), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            } else {
                $upload = RC_Upload::uploader('image', array('save_path' => 'data/receipt', 'auto_sub_dirs' => false));
                $info   = $upload->upload($_FILES['bg']);
                if (!empty($info)) {
                    $print_bg = $upload->get_position($info);
                } else {
                    return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }

                $res = RC_DB::table('shipping')->where('shipping_id', $shipping_id)->update(array('print_bg' => $print_bg));
                if ($res) {
                	$url = RC_Uri::url('shipping/admin/edit_print_template', array('shipping_id' => $shipping_id));
                    return $this->showmessage(__('上传打印单图片成功', 'shipping'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url));
                } else {
                    return $this->showmessage(__('上传打印单图片操作失败', 'shipping'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            }
        } else {
            return $this->showmessage(__('您还没有选择打印单图片。请使用“选择图片”按钮进行选择！', 'shipping'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 删除模板图片
     */
    public function print_del()
    {
        $this->admin_priv('ship_update');

        $shipping_id = !empty($_POST['shipping_id']) ? intval($_POST['shipping_id']) : 0;

        $shipping_data = RC_DB::table('shipping')->select('shipping_code', 'print_bg')->where('shipping_id', $shipping_id)->first();
        if (!empty($shipping_data['print_bg'])) {
            $plugin_handle   = ecjia_shipping::channel($shipping_data['shipping_code']);
            $config_print_bg = $plugin_handle->defaultPrintBackgroundImage();
            $url = RC_Uri::url('shipping/admin/edit_print_template', array('shipping_id' => $shipping_id));
            if ($shipping_data['print_bg'] == $config_print_bg) {
                RC_DB::table('shipping')->where('shipping_id', $shipping_id)->update(array('print_bg' => ''));
                return $this->showmessage(__('要删除的图片是默认图片，恢复模板可再次使用', 'shipping'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url));
            } else {
                $disk = RC_Filesystem::disk();
                $disk->delete(RC_Upload::upload_path() . $shipping_data['print_bg']);
                RC_DB::table('shipping')->where('shipping_id', $shipping_id)->update(array('print_bg' => ''));
                return $this->showmessage(__('打印单图片删除成功', 'shipping'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url));
            }
        } else {
            return $this->showmessage(__('暂无打印单图片可删除', 'shipping'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 编辑快递模板参数
     */
    public function edit_print_template($shipid = 0)
    {
        $this->admin_priv('ship_update');

        $full = isset($_GET['full']) && !empty($_GET['full']) ? 1 : 0;
        $this->assign('full', $full);

        ecjia_screen::get_current_screen()->add_help_tab(array(
            'id'      => 'overview',
            'title'   => __('概述', 'shipping'),
            'content' => '<p>' . __('欢迎访问ECJia智能后台快递单模板编辑页面，可以在此编辑相应的快递单模板信息。', 'shipping') . '</p>',
        ));

        ecjia_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . __('更多信息：', 'shipping') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:配送方式" target="_blank">关于快递单模板编辑帮助文档</a>', 'shipping') . '</p>'
        );

        $shipping_id   = !empty($_GET['shipping_id']) ? intval($_GET['shipping_id']) : ($shipid > 0 ? $shipid : 0);
        $shipping_data = RC_DB::table('shipping')->where('shipping_id', $shipping_id)->first();
        if($shipping_data['print_model'] == 1) {
        	$print_model_msg = __('代码模式', 'shipping');
        } else {
        	$print_model_msg = __('所见即所得模式', 'shipping');
        }
        $upgrade_url = RC_Uri::url('shipping/admin/print_template_preview', array('shipping_id' => $shipping_id));
        $this->assign('upgrade_url', $upgrade_url);
        $warning = sprintf(__('当前属于%s，保存设置即可<a href="%s" target="_blank">点击预览</a>快递单模板。', 'shipping'), $print_model_msg, $upgrade_url);
        ecjia_screen::get_current_screen()->add_admin_notice(new admin_notice($warning, 'alert'));

        if ($shipping_data) {
            /*代码模式逻辑开始*/
            $shipping_data['shipping_print'] = !empty($shipping_data['shipping_print']) ? stripslashes($shipping_data['shipping_print']) : '';
            $shipping_data['print_model']    = !empty($shipping_data['print_model']) ? $shipping_data['print_model'] : 1; //兼容以前版本

            ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('快递单模板编辑', 'shipping')));

            $this->assign('ur_here', __('快递单模板编辑', 'shipping'));
            $this->assign('action_link', array('text' => __('配送方式', 'shipping'), 'href' => RC_Uri::url('shipping/admin_plugin/init')));

            $shipping_template_info = (new Ecjia\App\Shipping\ShippingTemplate())->getDefaultsWithFormatted();
            $this->assign('shipping_template_info', $shipping_template_info);
            if (!empty($shipping_data['print_bg'])) {
            	if (strpos($shipping_data['print_bg'], 'http://') === false && strpos($shipping_data['print_bg'], 'https://') === false) {
            		$shipping_data['print_bg'] = RC_Upload::upload_url($shipping_data['print_bg']);
            	} else {
            		$shipping_data['print_bg'] = $shipping_data['print_bg'];
            	}
            }

            $links = array(
                'recovery'         => RC_Uri::url('shipping/admin/recovery_default_template'),
                'print_img_upload' => RC_Uri::url('shipping/admin/print_upload'),
                'print_img_del'    => RC_Uri::url('shipping/admin/print_del'),
                'do_edit'          => RC_Uri::url('shipping/admin/do_edit_print_template'),
            );

            $config_lable      = explode("||,||", $shipping_data['config_lable']);
            $config_lable_list = array();
            foreach ($config_lable as $key => $val) {
                $config_lable[$key] = explode(",", $val);
            }

            foreach ($config_lable as $val) {
                $config_lable_list[] = $val[1];
            }
            $config_lable_list = array_filter($config_lable_list);

            $this->assign('post_links', $links);
            $this->assign('shipping', $shipping_data);
            $this->assign('shipping_id', $shipping_id);
           
            $this->assign('config_lable_list', $config_lable_list);
            $this->assign('lang_js_languages', RC_Lang::get('shipping::shipping.js_languages')); //TODO 语言包处理方法待确认

            //获取插件打印选项数据
            $plugin_handle   = ecjia_shipping::channel($shipping_data['shipping_code']);
            $lable_list_box = $plugin_handle->loadPrintOption('lable_box');
            $this->assign('lang_lable_box', $lable_list_box);

            return $this->display('shipping_template.dwt');
        } else {
            return $this->showmessage(__('您的配送方式尚未安装，暂不能编辑模板', 'shipping'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 编辑打印模板处理逻辑
     */
    public function do_edit_print_template()
    {
        $this->admin_priv('ship_update');

        $print_model = !empty($_POST['print_model']) ? intval($_POST['print_model']) : 0;
        $shipping_id = !empty($_POST['shipping_id']) ? intval($_POST['shipping_id']) : 0;
        
        /* 处理不同模式编辑的表单 */
        if ($print_model == 2) {
            $data = array(
                'config_lable' => trim($_POST['config_lable']),
                'print_model'  => $print_model,
            );
        } elseif ($print_model == 1) {
            //代码模式
            $template = !empty($_POST['shipping_print']) ? trim($_POST['shipping_print']) : '';
            $data     = array(
                'shipping_print' => $template,
                'print_model'    => $print_model,
            );
        }
        RC_DB::table('shipping')->where('shipping_id', $shipping_id)->update($data);
        ecjia_admin::admin_log(addslashes($_POST['shipping_name']), 'edit', 'shipping_print_template');
        
        $url = RC_Uri::url('shipping/admin/edit_print_template', array('shipping_id' => $shipping_id));
        return $this->showmessage(__('快递单模板编辑成功', 'shipping'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url));
    }
    
    /**
     * 恢复默认设置
     */
    public function recovery_default_template()
    {
    	$this->admin_priv('ship_update');
    
    	$shipping_id   = !empty($_POST['shipping_id']) ? intval($_POST['shipping_id']) : 0;
    	$shipping_data = RC_DB::table('shipping')->select('shipping_code', 'print_bg')->where('shipping_id', $shipping_id)->first();
    
    	if (isset($shipping_data['shipping_code'])) {
    		$plugin_handle = ecjia_shipping::channel($shipping_data['shipping_code']);
    		$data          = array(
    				'print_model'  		=> 	2,
    				'shipping_print'	=>	'',
    				'print_bg'     		=> 	$plugin_handle->defaultPrintBackgroundImage(),
    				'config_lable' 		=> 	$plugin_handle->getConfigLabel(),
    		);
    		RC_DB::table('shipping')->where('shipping_code', $shipping_data['shipping_code'])->update($data);
    
    		/* 如果存在之前的上传的图片，删除图片 */
    		if (!empty($shipping_data['print_bg']) && $shipping_data['print_bg'] != $plugin_handle->defaultPrintBackgroundImage()) {
    			$disk = RC_Filesystem::disk();
    			$disk->delete(RC_Upload::upload_path() . $shipping_data['print_bg']);
    		}
    		
    		$url = RC_Uri::url('shipping/admin/edit_print_template', array('shipping_id' => $shipping_id));
    		return $this->showmessage(__('恢复默认设置成功', 'shipping'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url));
    	} else {
    		return $this->showmessage(__('恢复默认设置失败', 'shipping'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    }
    
    /**
     * 模板预览
     */
    public function print_template_preview()
    {
    	$shipping_id = intval($_GET['shipping_id']);
    	$shipping_data = RC_DB::table('shipping')->where('shipping_id', $shipping_id)->first();
    	
    	//获取默认数据
    	$test_info = new Ecjia\App\Shipping\ShippingTemplateTest();
    	$template_data = $test_info->getTemplateData();
    	
		if ($shipping_data['print_model']==2) {
    		/* 判断模板图片位置 */
    		if (!empty($shipping_data['print_bg']) && trim($shipping_data['print_bg']) != '') {
    			$uploads_dir_info = RC_Upload::upload_dir();
    			if (mb_strstr($shipping_data['print_bg'], 'data/receipt')) {
    				$shipping_data['print_bg'] = $uploads_dir_info[baseurl] . '/' . $shipping_data['print_bg'];
    			} else {
    				$shipping_data['print_bg'] = $shipping_data['print_bg'];
    			}
    		} else {
    			/* 使用插件默认快递单图片 */
    			$plugin_handle        = ecjia_shipping::channel($shipping_data['shipping_code']);
    			$shipping_data['print_bg'] = $plugin_handle->printBcakgroundImage();
    		}
    		/* 取快递单背景宽高 */
    		if (!empty($shipping_data['print_bg'])) {
    			$_size = @getimagesize($shipping_data['print_bg']);
    			if ($_size != false) {
    				$shipping_data['print_bg_size'] = array('width' => $_size[0], 'height' => $_size[1]);
    			}
    		}
    		 
    		if (empty($shipping_data['print_bg_size'])) {
    			$shipping_data['print_bg_size'] = array('width' => '1024', 'height' => '600');
    		}
    		
    		//标签替换
            $temp_config_lable = explode('||,||', $shipping_data['config_lable']);
            if (!is_array($temp_config_lable)) {
                $temp_config_lable[] = $shipping_data['config_lable'];
            }
            foreach ($temp_config_lable as $temp_key => $temp_lable) {
                $temp_info = explode(',', $temp_lable);
                if (is_array($temp_info)) {
                	$key = str_replace('t_', '', $temp_info[0]);
                    $temp_info[1] = $template_data[$key];
                }
                $temp_config_lable[$temp_key] = implode(',', $temp_info);
            }
            $shipping_data['config_lable'] = implode('||,||', $temp_config_lable);
            $this->assign('shipping', $shipping_data);

            return $this->display('print.dwt');
            
    	} else { //代码模式
    		foreach ($template_data as $key => $val) {
    			$this->assign($key, $val);
    		}
    		
    		if (!empty($shipping_data['shipping_print'])) {
    			//自定义模板设置
    			echo $this->fetch_string(stripslashes($shipping_data['shipping_print']));
    		} else {
    			//获取当前配送方式插件的快递单默认模板文件
    			$plugin_handle   = ecjia_shipping::channel($shipping_data['shipping_code']);
    			$shipping_print  = $plugin_handle->loadPrintOption('shipping_print');
    		
    			return $this->display($shipping_print);
    		}
    	}
    }
}
// end
