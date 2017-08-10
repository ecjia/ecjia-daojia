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
 * ECJIA移动应用配置模块
 */
class admin_config extends ecjia_admin {
	private $db_region;
	public function __construct() {
		parent::__construct();

		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		$this->db_region = RC_Loader::load_app_model('region_model', 'shipping');
		
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');

		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('bootstrap-placeholder');
		
		RC_Style::enqueue_style('mobile_config', RC_App::apps_url('statics/css/mobile_config.css', __FILE__), array(), false, false);
		RC_Style::enqueue_style('goods-colorpicker-style', RC_Uri::admin_url('/statics/lib/colorpicker/css/colorpicker.css'));
		RC_Script::enqueue_script('goods-colorpicker-script', RC_Uri::admin_url('/statics/lib/colorpicker/bootstrap-colorpicker.js'), array());

		RC_Script::enqueue_script('jquery.toggle.buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/jquery.toggle.buttons.js'));
		RC_Style::enqueue_style('bootstrap-toggle-buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/bootstrap-toggle-buttons.css'));

		RC_Script::enqueue_script('mobile_config', RC_App::apps_url('statics/js/mobile_config.js', __FILE__), array(), false, false);
		RC_Script::localize_script('mobile_config', 'js_lang', RC_Lang::get('mobile::mobile.js_lang'));

        RC_Script::enqueue_script('jquery-dropper', RC_Uri::admin_url() . '/statics/lib/dropper-upload/jquery.fs.dropper.js', array(), false, true);
        RC_Style::enqueue_style('dropper', RC_Uri::admin_url('/statics/lib/dropper-upload/jquery.fs.dropper.css'));
        RC_Style::enqueue_style('mobile_config', RC_App::apps_url('statics/css/mobile_config.css', __FILE__));
	}	
	
	/**
	 * 移动应用基本信息
	 */
	public function basic_info_init () {
		$this->admin_priv('mobile_config_manage');	
		
		$this->assign('ur_here', RC_Lang::get('mobile::mobile.mobile_config'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.mobile_config')));
		//加载应用配置中的code
		$group_code = RC_Loader::load_app_config('group_code', 'mobile');
		$this->assign('group_code',$group_code);
		$code = empty($_GET['code']) ? 'basic_info' : trim($_GET['code']);
		$this->assign('code', $code);
		
		$mobile_app_icon = ecjia_config::has('mobile_app_icon') ? RC_Upload::upload_url() . '/' . ecjia::config('mobile_app_icon').'?t='.SYS_TIME : '';
		$this->assign('mobile_app_icon', $mobile_app_icon);
		$this->assign('mobile_app_name',      	ecjia::config('mobile_app_name'));
		$this->assign('mobile_app_version',   	ecjia::config('mobile_app_version'));
		$this->assign('mobile_app_description', ecjia::config('mobile_app_description'));
		$this->assign('mobile_app_video',   	ecjia::config('mobile_app_video'));
		$this->assign('mobile_feedback_autoreply', ecjia::config('mobile_feedback_autoreply'));
		$this->assign('shop_pc_url', ecjia::config('mobile_pc_url'));
		$this->assign('mobile_touch_url', ecjia::config('mobile_touch_url'));
		$this->assign('mobile_share_link', ecjia::config('mobile_share_link'));
		/*红包使用说明*/
		$bonus_readme_url = ecjia::config('bonus_readme_url');
		$bonus_readme     = array();
		if (!empty($bonus_readme_url)) {
			$bonus_readme_url = explode('?', $bonus_readme_url);
			$parameter        = explode('&', end($bonus_readme_url));
			foreach($parameter as $val){
				$tmp            = explode('=',$val);
				$data[$tmp[0]]  = $tmp[1];
			}
			$article_info = RC_Api::api('article', 'article_info', array('id' => $data['id']));
			if (!is_ecjia_error($article_info)) {
				if (!empty($article_info)) {
					$bonus_readme = array('id' => $data['id'], 'title' => $article_info['title']);
				}
			}
		}
		$this->assign('bonus_readme', $bonus_readme);
		/*登录页设置*/
		$this->assign('mobile_phone_login_fgcolor', ecjia::config('mobile_phone_login_fgcolor'));
		$this->assign('mobile_phone_login_bgcolor', ecjia::config('mobile_phone_login_bgcolor'));
		$mobile_phone_login_bgimage = ecjia::config('mobile_phone_login_bgimage');
		/*热门城市*/
		$regions = array ();
		$mobile_recommend_city = explode(',', ecjia::config('mobile_recommend_city'));
		$region_data           = RC_DB::table('region')->whereIn('region_id', $mobile_recommend_city)->get();		
		if (!empty($region_data)) {
			foreach ( $region_data as $key => $val ) {
				if ( empty($val['region_name']) ) {
					$regions[$val['region_id']] = '<lable  style="color:red">' .RC_Lang::get('mobile::mobile.region_removed'). '</lable>';
				} else {
					$regions[$val['region_id']] = $val['region_name'];
				}
			}
		}
		
		$this->assign('mobile_recommend_city', $regions);	
		$this->assign('countries', $this->db_region->get_regions());
		/*短信提醒*/
		$order_reminder_type = ecjia::config('order_reminder_type', ecjia::CONFIG_CHECK) ? ecjia::config('order_reminder_type') : 0;
		$this->assign('order_reminder_type', $order_reminder_type);
		/* 管理员信息*/
		$admin_user_list = RC_DB::table('admin_user')->select('user_id', 'user_name')->get();
		$this->assign('admin_user_list', $admin_user_list);
		$this->assign('order_reminder_value', ecjia::config('order_reminder_value'));
		
		$this->assign('shop_touch_url', ecjia::config('mobile_touch_url'));	
		
		$this->assign('mobile_signup_reward', ecjia::config('mobile_signup_reward'));
		//新人有礼红包，有效期内+按用户发放类型+平台红包
		$bonus_type_list = RC_Api::api('bonus', 'bonus_type_list', array('store_id' => 0, 'type' => 'allow_use', 'send_type' => 'user'));
	    if (empty($bonus_type_list)) {
		    $bonus_type_list = array( array('type_name' => '暂无有效红包'));
		}
		
		$this->assign('bonus_type_list', $bonus_type_list);
		$this->assign('mobile_signup_reward_notice', ecjia::config('mobile_signup_reward_notice'));
		
		
		$this->assign('form_action', RC_Uri::url('mobile/admin_config/update_basic_info'));
		$this->assign('current_code', trim($_GET['code']));
		$this->display('mobile_config.dwt');
	}
	
	
	
	/**
	 * app下载地址页面
	 */
	public function app_download_url () {
		$this->admin_priv('mobile_config_manage');
		
		$this->assign('ur_here', RC_Lang::get('mobile::mobile.mobile_config'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.mobile_config')));
		$this->assign('form_action', RC_Uri::url('mobile/admin_config/update_app_download_url'));
		//加载应用配置中的code
		$group_code = RC_Loader::load_app_config('group_code', 'mobile');
		$this->assign('group_code',$group_code);
		$code = empty($_GET['code']) ? 'basic_info' : trim($_GET['code']);
		$this->assign('code', $code);
	
		$mobile_iphone_qrcode  = ecjia::config('mobile_iphone_qrcode');
		$mobile_iphone_qrcode  = empty($mobile_iphone_qrcode) ? '' : RC_Upload::upload_url() .'/'.$mobile_iphone_qrcode;
		$mobile_android_qrcode = ecjia::config('mobile_android_qrcode');
		$mobile_android_qrcode = empty($mobile_android_qrcode) ? '' : RC_Upload::upload_url() .'/'.$mobile_android_qrcode;
		$mobile_touch_qrcode = ecjia::config('mobile_touch_qrcode');
		$mobile_touch_qrcode = empty($mobile_touch_qrcode) ? '' : RC_Upload::upload_url($mobile_touch_qrcode);
		
		$this->assign('mobile_iphone_qrcode', $mobile_iphone_qrcode);
		$this->assign('mobile_android_qrcode', $mobile_android_qrcode);
		$this->assign('mobile_touch_qrcode', $mobile_touch_qrcode);
		$this->assign('mobile_iphone_download', ecjia::config('mobile_iphone_download'));
		$this->assign('mobile_android_download', ecjia::config('mobile_android_download'));
		$this->assign('mobile_shopkeeper_urlscheme', ecjia::config('mobile_shopkeeper_urlscheme'));
		$this->assign('mobile_shop_urlscheme', ecjia::config('mobile_shop_urlscheme'));
		$this->assign('current_code', trim($_GET['code']));

		$this->display('mobile_config.dwt');
	}
	
	
	/**
	 * app应用截图
	 */
	public function app_screenshots () {
		$this->admin_priv('mobile_config_manage');
		
		$this->assign('ur_here', RC_Lang::get('mobile::mobile.mobile_config'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.mobile_config')));
		$this->assign('form_action', RC_Uri::url('mobile/admin_config/update_app_screenshots'));
		//加载应用配置中的code
		$group_code = RC_Loader::load_app_config('group_code', 'mobile');
		$this->assign('group_code',$group_code);
		$code = empty($_GET['code']) ? 'basic_info' : trim($_GET['code']);
		$this->assign('code', $code);
		$this->assign('mobile_app_name', ecjia::config('mobile_app_name'));
		// 应用截图
		$mobile_app_preview_temp = ecjia::config('mobile_app_preview');
		$mobile_app_preview = unserialize($mobile_app_preview_temp);
		if(!empty($mobile_app_preview[0])){
			$mobile_app_preview1 = RC_Upload::upload_url().'/'.$mobile_app_preview[0];
		}
		if(!empty($mobile_app_preview[1])){
			$mobile_app_preview2 = RC_Upload::upload_url().'/'.$mobile_app_preview[1];
		}
		$this->assign('mobile_app_preview1', $mobile_app_preview1);
		$this->assign('mobile_app_preview2', $mobile_app_preview2);
		
		$img_list = RC_DB::table('mobile_screenshots')
            		->orderBy('sort','asc')
            		->get();
		foreach($img_list as $key => $val){
			$img_list[$key]['img_url'] = !empty($val['img_url'])? RC_Upload::upload_url().'/'.$val['img_url'] : '';
		}
		$this->assign('img_list', $img_list);
		$this->assign('current_code', trim($_GET['code']));
		$this->display('mobile_config.dwt');
	}
	
	
	/**
	 * 广告位页面
	 */
	public function mobile_adsense_set () {
		$this->admin_priv('mobile_config_manage');	
		
		$this->assign('ur_here', RC_Lang::get('mobile::mobile.mobile_config'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.mobile_config')));
		$this->assign('form_action', RC_Uri::url('mobile/admin_config/update_mobile_adsense_set'));
		//加载应用配置中的code
		$group_code = RC_Loader::load_app_config('group_code', 'mobile');
		$this->assign('group_code',$group_code);
		$code = empty($_GET['code']) ? 'basic_info' : trim($_GET['code']);
		$this->assign('code', $code);
		$this->assign('mobile_launch_adsense', ecjia::config('mobile_launch_adsense'));
		
		$ad_position_list = RC_Api::api('adsense', 'adsense_position_list', array('page_size' => 1000));
		$this->assign('ad_position_list', $ad_position_list['arr']);
		
		$mobile_home_adsense_group = $adsense_group = array();
		if (ecjia_config::has('mobile_home_adsense_group')) {
			$adsense_group = explode(',', ecjia::config('mobile_home_adsense_group'));
		}
	
		if (!empty($adsense_group)) {
			foreach ($adsense_group as $val) {
				$adsense = RC_Api::api('adsense', 'adsense_position_list', array('position_id' => $val));
				if (!empty($adsense['arr'])) {
					$mobile_home_adsense_group[] = $adsense['arr'][0];
				}
			}
		}
		$this->assign('mobile_home_adsense_group', $mobile_home_adsense_group);
		$this->assign('current_code', trim($_GET['code']));
		$this->display('mobile_config.dwt');
	}
	
    /**
     * 上传应用图片的方法
     */
    public function insert() {
        $this->admin_priv('mobile_config_manage', ecjia::MSGTYPE_JSON);
        
        $upload = RC_Upload::uploader('image', array('save_path' => 'data/screenshots', 'auto_sub_dirs' => true));
        $code = !empty($_POST['code']) ? $_POST['code'] : $_GET['code'];
        if (!$upload->check_upload_file($_FILES['img_url'])) {
            return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $count = RC_DB::table('mobile_screenshots')->where('app_code', '=', 'cityo2o')->count();
        if($count < 10){
            $image_info = $upload->upload($_FILES['img_url']);
            if (empty($image_info)) {
                return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }else{
                $img = $upload->get_position($image_info);
            }
            $data = array(
                'img_desc'  => $image_info['name'],
                'img_url'   => $img,
                'app_code'  =>'cityo2o',
            );
            RC_DB::table('mobile_screenshots')->insert($data);
            $url = RC_Uri::url('mobile/admin_config/app_screenshots', array('code' => $code));
            return $this->showmessage('添加成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $url));
        }else{
            return $this->showmessage('应用截图最多只能添加10张', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
	* 相册图片排序
	*/
	public function sort_image() {
        $this->admin_priv('mobile_config_manage', ecjia::MSGTYPE_JSON);
        
		$sort = $_GET['info'];
		foreach ($sort as $k => $v) {
            $data['sort'] = $k + 1;
			RC_DB::table('mobile_screenshots')->where('id', $v['img_id'])->where('app_code', '=', 'cityo2o')->update($data);
		}
		return $this->showmessage(RC_Lang::get('goods::goods.save_sort_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}

    /**
	* 修改相册图片描述
	*/
	public function update_image_desc() {
        $this->admin_priv('mobile_config_manage', ecjia::MSGTYPE_JSON);
        
		$id = $_GET['id'];
		$val = $_GET['val'];
		RC_DB::table('mobile_screenshots')->where('id', $id)->where('app_code', '=', 'cityo2o')->update(array('img_desc' => $val));
		return $this->showmessage(RC_Lang::get('goods::goods.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}

    /**
	* 删除图片
	*/
	public function drop_image() {
		$this->admin_priv('mobile_config_manage', ecjia::MSGTYPE_JSON);
		
		$id = empty($_GET['id']) ? 0 : intval($_GET['id']);

		/* 删除图片文件 */
		$row = RC_DB::table('mobile_screenshots')->select('img_url')->where('id', $id)->first();

		if (!empty($row['img_url'])) {
			RC_Filesystem::disk()->delete(RC_Upload::upload_path() . $row['img_url']);
		}
		/* 删除数据 */
		RC_DB::table('mobile_screenshots')->where('id', $id)->where('app_code', '=', 'cityo2o')->delete();
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}

	/**
	 * 处理移动应用基本信息
	 */
	public function update_basic_info() {
		$this->admin_priv('mobile_config_update', ecjia::MSGTYPE_JSON);
		
		$code = $_POST['code'];
		
		/*基本信息处理*/
		$mobile_app_name 				= !empty($_POST['mobile_app_name']) 		? trim($_POST['mobile_app_name']) 		: '';
		$mobile_app_version 			= !empty($_POST['mobile_app_version']) 		? trim($_POST['mobile_app_version']) 	: '';
		$mobile_app_description 		= !empty($_POST['mobile_app_description']) 	? trim($_POST['mobile_app_description']) 	: '';
		$mobile_app_video 				= !empty($_POST['mobile_app_video']) 		? trim($_POST['mobile_app_video']) 		: '';
		$bonus_readme 					= !empty($_POST['bonus_readme']) 				? $_POST['bonus_readme'] 						: '';
		$mobile_feedback_autoreply 		= !empty($_POST['mobile_feedback_autoreply']) 	? trim($_POST['mobile_feedback_autoreply']) 	: '';
		$shop_pc_url 					= !empty($_POST['shop_pc_url']) 			? trim($_POST['shop_pc_url']) 			: '';
		$mobile_touch_url 				= !empty($_POST['mobile_touch_url']) 		? trim($_POST['mobile_touch_url']) 		: '';
		$mobile_share_link				= trim($_POST['mobile_share_link']);
		$mobile_signup_reward			= isset($_POST['mobile_signup_reward']) ? intval($_POST['mobile_signup_reward']) : 0;
		$mobile_signup_reward_notice	= isset($_POST['mobile_signup_reward_notice']) ? trim($_POST['mobile_signup_reward_notice']) : '';
		
		/* 上传app logo图标*/
		if (isset($_FILES['mobile_app_icon'])) {
			$upload = RC_Upload::uploader('image', array('save_path' => 'data/assets', 'replace' => true, 'auto_sub_dirs' => false));
			$upload->add_filename_callback(function () { return 'mobile_app_icon';});
		
			$mobile_app_icon_info = $upload->upload($_FILES['mobile_app_icon']);
			if (!empty($mobile_app_icon_info)) {
				$mobile_app_icon = $upload->get_position($mobile_app_icon_info);
				ecjia_config::instance()->write_config('mobile_app_icon', $mobile_app_icon);
			}
		}
		ecjia_config::instance()->write_config('mobile_app_name', 		$mobile_app_name);
		ecjia_config::instance()->write_config('mobile_app_version', 	$mobile_app_version);
		ecjia_config::instance()->write_config('mobile_app_description', $mobile_app_description);
		ecjia_config::instance()->write_config('mobile_app_video', 		$mobile_app_video);
		$bonus_readme_url = RC_Uri::url('article/mobile/info', 'id='.$bonus_readme);
		$bonus_readme_url = str_replace(RC_Uri::site_url(), '', $bonus_readme_url);
		ecjia_config::instance()->write_config('bonus_readme_url', $bonus_readme_url);
		ecjia_config::instance()->write_config('mobile_feedback_autoreply', $mobile_feedback_autoreply);
		ecjia_config::instance()->write_config('mobile_pc_url', $shop_pc_url);
		ecjia_config::instance()->write_config('mobile_touch_url', $mobile_touch_url);
		ecjia_config::instance()->write_config('mobile_share_link', $mobile_share_link);//分享链接
		
		/*手机端登录页设置处理*/
		$mobile_phone_login_fgcolor 	= !empty($_POST['mobile_phone_login_fgcolor']) 	? trim($_POST['mobile_phone_login_fgcolor']) 	: '';
		$mobile_phone_login_bgcolor 	= !empty($_POST['mobile_phone_login_bgcolor']) 	? trim($_POST['mobile_phone_login_bgcolor']) 	: '';
		ecjia_config::instance()->write_config('mobile_phone_login_fgcolor', $mobile_phone_login_fgcolor);
		ecjia_config::instance()->write_config('mobile_phone_login_bgcolor', $mobile_phone_login_bgcolor);
		/*手机端登录页背景图片处理*/
		if (isset($_FILES['mobile_phone_login_bgimage'])) {
			$upload = RC_Upload::uploader('image', array('save_path' => 'data/assets', 'replace' => true, 'auto_sub_dirs' => false));
			$upload->add_filename_callback(function () { return 'mobile_phone_login_bgimage';});
		
			$mobile_phone_login_bgimage_info = $upload->upload($_FILES['mobile_phone_login_bgimage']);
			/* 判断是否上传成功 */
			if (!empty($mobile_phone_login_bgimage_info)) {
				$mobile_phone_login_bgimage = $upload->get_position($mobile_phone_login_bgimage_info);
				ecjia_config::instance()->write_config('mobile_phone_login_bgimage', $mobile_phone_login_bgimage);
			}
		}
		/*热门城市处理*/
		$regions 						= isset($_POST['regions']) 						? $_POST['regions'] 							: '';
		$mobile_recommend_city = '';
		if (!empty($regions)) {
			foreach ($regions as $val) {
				$mobile_recommend_city .= $val.',';
			}
			$mobile_recommend_city = substr($mobile_recommend_city, 0, -1);
		}
		ecjia_config::instance()->write_config('mobile_recommend_city', $mobile_recommend_city);
		/*短信提醒处理*/
		$order_reminder_type = intval($_POST['order_reminder_type']);
		
		ecjia_config::instance()->write_config('order_reminder_type', $order_reminder_type);
		if ($order_reminder_type == 1) {
			$order_reminder_value = intval($_POST['order_reminder_push']);
		} elseif($order_reminder_type == 2) {
			$order_reminder_value = trim($_POST['order_reminder_mobile']);
		} else {
			$order_reminder_value = '';
		}
		ecjia_config::instance()->write_config('mobile_signup_reward', $mobile_signup_reward);
		ecjia_config::instance()->write_config('mobile_signup_reward_notice', $mobile_signup_reward_notice);
		
		ecjia_config::instance()->write_config('order_reminder_value', $order_reminder_value);
		ecjia_admin::admin_log(RC_Lang::get('mobile::mobile.mobile_config_set'), 'setup', 'mobile_config');
		return $this->showmessage(RC_Lang::get('mobile::mobile.update_config_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_config/basic_info_init',array('code'=>$code))));
	}
	
	
	/**
	 * 处理app下载地址
	 */
	public function update_app_download_url() {
		$this->admin_priv('mobile_config_update', ecjia::MSGTYPE_JSON);
		
		$code = $_POST['code'];
		
		/* iphone二维码上传*/
		if (isset($_FILES['mobile_iphone_qrcode'])) {
			$upload = RC_Upload::uploader('image', array('save_path' => 'data/assets', 'replace' => true, 'auto_sub_dirs' => false));
			$upload->add_filename_callback(function () { return 'mobile_iphone_qrcode';});
		
			$image_info = $upload->upload($_FILES['mobile_iphone_qrcode']);
			/* 判断是否上传成功 */
			if (!empty($image_info)) {
				$mobile_iphone_qrcode = $upload->get_position($image_info);
				$data =  array(
						'value'  => $mobile_iphone_qrcode
				);
				ecjia_config::instance()->write_config('mobile_iphone_qrcode', $mobile_iphone_qrcode);
			}
		}
		
		$mobile_iphone_download 		= !empty($_POST['mobile_iphone_download']) 	? trim($_POST['mobile_iphone_download']): '';
		ecjia_config::instance()->write_config('mobile_iphone_download', $mobile_iphone_download);
		
		/* android二维码上传*/
		if (isset($_FILES['mobile_android_qrcode'])) {
			$upload = RC_Upload::uploader('image', array('save_path' => 'data/assets', 'replace' => true, 'auto_sub_dirs' => false));
			$upload->add_filename_callback(function () { return 'mobile_android_qrcode';});
		
			$image_info = $upload->upload($_FILES['mobile_android_qrcode']);
			/* 判断是否上传成功 */
			if (!empty($image_info)) {
				$mobile_android_qrcode = $upload->get_position($image_info);
				$data =  array(
						'value'  => $mobile_android_qrcode
				);
				ecjia_config::instance()->write_config('mobile_android_qrcode', $mobile_android_qrcode);
			}
		}
		$mobile_android_download 		= !empty($_POST['mobile_android_download']) ? trim($_POST['mobile_android_download']) : '';
		
		/* touch二维码上传*/
		if (isset($_FILES['mobile_touch_qrcode'])) {
		    $upload = RC_Upload::uploader('image', array('save_path' => 'data/assets', 'replace' => true, 'auto_sub_dirs' => false));
		    $upload->add_filename_callback(function () { return 'mobile_touch_qrcode';});
		
		    $image_info = $upload->upload($_FILES['mobile_touch_qrcode']);
		    /* 判断是否上传成功 */
		    if (!empty($image_info)) {
		        $mobile_touch_qrcode = $upload->get_position($image_info);
		        $data =  array(
		            'value'  => $mobile_touch_qrcode
		        );
		        ecjia_config::instance()->write_config('mobile_touch_qrcode', $mobile_touch_qrcode);
		    }
		}
		
		$mobile_shopkeeper_urlscheme 	= !empty($_POST['mobile_shopkeeper_urlscheme']) ? trim($_POST['mobile_shopkeeper_urlscheme']) 	: '';
		$mobile_shop_urlscheme 			= !empty($_POST['mobile_shop_urlscheme']) 		? trim($_POST['mobile_shop_urlscheme']) 		: '';
		
		ecjia_config::instance()->write_config('mobile_android_download', $mobile_android_download);
		ecjia_config::instance()->write_config('mobile_shopkeeper_urlscheme', $mobile_shopkeeper_urlscheme);
		ecjia_config::instance()->write_config('mobile_shop_urlscheme', $mobile_shop_urlscheme);

		ecjia_admin::admin_log(RC_Lang::get('mobile::mobile.mobile_config_set'), 'setup', 'mobile_config');
		return $this->showmessage(RC_Lang::get('mobile::mobile.update_config_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_config/app_download_url',array('code'=>$code))));
	
	}
	
	
	/**
	 * 处理移动应用广告位设置
	 */
	public function update_mobile_adsense_set() {
		$this->admin_priv('mobile_config_update', ecjia::MSGTYPE_JSON);
		
		$code = $_POST['code'];
		
		$mobile_launch_adsense 			= !empty($_POST['mobile_launch_adsense']) 		? $_POST['mobile_launch_adsense'] 				: '';
		$adsense_group 					= !empty($_POST['mobile_home_adsense_group']) 	? $_POST['mobile_home_adsense_group'] 			: '';
		
		$mobile_home_adsense_group = '';
		if (!empty($adsense_group)) {
			$mobile_home_adsense_group = '';
			foreach ($adsense_group as $val) {
				$mobile_home_adsense_group .= $val.',';
			}
			$mobile_home_adsense_group = substr($mobile_home_adsense_group, 0, -1);
		}
		ecjia_config::instance()->write_config('mobile_launch_adsense', $mobile_launch_adsense);
		ecjia_config::instance()->write_config('mobile_home_adsense_group', $mobile_home_adsense_group);
		ecjia_admin::admin_log(RC_Lang::get('mobile::mobile.mobile_config_set'), 'setup', 'mobile_config');
		return $this->showmessage(RC_Lang::get('mobile::mobile.update_config_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_config/mobile_adsense_set',array('code'=>$code))));
	
	}

	
	/**
	 * 处理应用截图
	 */
	public function update_app_screenshots() {
		$this->admin_priv('mobile_config_update', ecjia::MSGTYPE_JSON);
		
		$code = $_POST['code'];
		
		// 应用截图
		$mobile_app_preview_temp = ecjia::config('mobile_app_preview');
		$mobile_app_preview      = unserialize($mobile_app_preview_temp);
		if (!empty($mobile_app_preview[0])) {
			$mobile_app_preview1 = RC_Upload::upload_url().'/'.$mobile_app_preview[0];
		}
		if (!empty($mobile_app_preview[1])) {
			$mobile_app_preview2 = RC_Upload::upload_url().'/'.$mobile_app_preview[1];
		}
		
		/* 应用截图1 */
		if (!empty($_FILES['mobile_app_preview1'])) {
			$upload = RC_Upload::uploader('image', array('save_path' => 'data/assets', 'replace' => true, 'auto_sub_dirs' => false));
			$upload->add_filename_callback(function () { return 'mobile_app_preview1';});
			$mobile_app_preview1 = $upload->upload($_FILES['mobile_app_preview1']);
			
			if (!empty($mobile_app_preview1)) {
				$mobile_app_preview1 = $upload->get_position($mobile_app_preview1);
			}
		}
		
		/* 应用截图2 */
		if (!empty($_FILES['mobile_app_preview2'])) {
			$upload = RC_Upload::uploader('image', array('save_path' => 'data/assets', 'replace' => true, 'auto_sub_dirs' => false));
			$upload->add_filename_callback(function () { return 'mobile_app_preview2';});
			$mobile_app_preview2 = $upload->upload($_FILES['mobile_app_preview2']);
			
			if (!empty($mobile_app_preview2)) {
				$mobile_app_preview2 = $upload->get_position($mobile_app_preview2);
			}
		}
		
		if (!empty($mobile_app_preview1) || !empty($mobile_app_preview2)) {
			$mobile_app_preview_temp = array($mobile_app_preview1, $mobile_app_preview2);
			$mobile_app_preview      = serialize($mobile_app_preview_temp);
			ecjia_config::instance()->write_config('mobile_app_preview', $mobile_app_preview);
		}
		
		ecjia_admin::admin_log(RC_Lang::get('mobile::mobile.mobile_config_set'), 'setup', 'mobile_config');
		return $this->showmessage(RC_Lang::get('mobile::mobile.update_config_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_config/app_screenshots', array('code' => $code))));
	}
	
	
	
	/**
	 * 删除上传文件
	 */
	public function del() {
		$this->admin_priv('mobile_config_delete', ecjia::MSGTYPE_JSON);
		
		$disk = RC_Filesystem::disk();
		$code = trim($_GET['code']);
		
		if ($code == 'mobile_app_preview1' || $code == 'mobile_app_preview2') {
			// 应用截图
			$mobile_app_preview_temp = ecjia::config('mobile_app_preview');
			$mobile_app_preview = unserialize($mobile_app_preview_temp);

			if (!empty($mobile_app_preview[0])) {
				$mobile_app_preview1 = $mobile_app_preview[0];
			}
			if (!empty($mobile_app_preview[1])) {
				$mobile_app_preview2 = $mobile_app_preview[1];
			}
			
			if ($code == 'mobile_app_preview1') {
				$disk->delete(RC_Upload::upload_path() . $mobile_app_preview1);
				$mobile_app_preview1 = '';
			} elseif ($code == 'mobile_app_preview2') {
				$disk->delete(RC_Upload::upload_path() . $mobile_app_preview2);
				$mobile_app_preview2 = '';
			}
			$mobile_app_preview_temp = array($mobile_app_preview1, $mobile_app_preview2);
			$mobile_app_preview      = serialize($mobile_app_preview_temp);
			
			ecjia_config::instance()->write_config('mobile_app_preview', $mobile_app_preview);
		} else {
			$img_name = RC_DB::table('shop_config')->where('code', $code)->pluck('value');
			$disk->delete(RC_Upload::upload_path() . $img_name);
			ecjia_admin::admin_log('', 'edit', 'mobile_config');
			ecjia_config::instance()->write_config($code, '');
		}
		return $this->showmessage(RC_Lang::get('mobile::mobile.del_ok') , ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}

	public function search_article() {
		$result = RC_Api::api('article', 'article_list', array('keywords' => $_POST['artile'], 'article_type' => 'system', 'article_approved' => 1));
		$list = array();
		if (!empty($result['arr'])) {
			foreach ($result['arr'] as $val) {
				$list[] = array(
					'id' 	=> $val['article_id'],
					'name' 	=> $val['title']
				);
			}
		}
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $list));
	}

	private function get_regions($type = 0, $parent = 0) {
		return RC_DB::table('region')->where('region_type', $type)->where('parent_id', $parent)->select('region_id', 'region_name')->get();
	}
}

//end
