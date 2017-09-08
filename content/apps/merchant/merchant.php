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
 * 店铺基本信息
 */
class merchant extends ecjia_merchant {
	public function __construct() {
		parent::__construct();
        RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
        RC_Style::enqueue_style('uniform-aristo');
        // 自定义JS
        RC_Script::enqueue_script('merchant_info', RC_App::apps_url('statics/js/merchant_info.js', __FILE__) , array() , false, true);
        // 页面css样式
        RC_Style::enqueue_style('merchant', RC_App::apps_url('statics/css/merchant.css', __FILE__), array());
        // input file 长传
        RC_Style::enqueue_style('bootstrap-fileupload', RC_App::apps_url('statics/assets/bootstrap-fileupload/bootstrap-fileupload.css', __FILE__), array());
        RC_Script::enqueue_script('bootstrap-fileupload', RC_App::apps_url('statics/assets/bootstrap-fileupload/bootstrap-fileupload.js', __FILE__), array(), false, true);

        // 时间区间
        RC_Style::enqueue_style('range', RC_App::apps_url('statics/css/range.css', __FILE__), array());
        RC_Script::enqueue_script('jquery-range', RC_App::apps_url('statics/js/jquery.range.js', __FILE__), array(), false, true);

        RC_Script::enqueue_script('jquery.toggle.buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/jquery.toggle.buttons.js'));
        RC_Style::enqueue_style('bootstrap-toggle-buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/bootstrap-toggle-buttons.css'));
        RC_Script::enqueue_script('migrate', RC_App::apps_url('statics/js/migrate.js', __FILE__) , array() , false, true);

        RC_Loader::load_app_func('merchant');
        merchant_assign_adminlog_content();

        ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here('我的店铺', RC_Uri::url('merchant/merchant/init')));
        ecjia_merchant_screen::get_current_screen()->set_parentage('store', 'store/merchant.php');
	}

	/**
	 * 店铺基本信息
	 */
	public function init() {
		$this->admin_priv('merchant_manage');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('店铺设置', RC_Uri::url('merchant/mh_franchisee/init')));
		$this->assign('app_url', RC_App::apps_url('statics', __FILE__));

		$this->assign('ur_here', '设置店铺信息');
        $merchant_info = get_merchant_info();
        $merchant_info['merchants_name'] = RC_DB::table('store_franchisee')->where('store_id', $_SESSION['store_id'])->pluck('merchants_name');
        
        $disk = RC_Filesystem::disk();
        $store_qrcode = 'data/qrcodes/merchants/merchant_'.$_SESSION['store_id'].'.png';
        if ($disk->exists(RC_Upload::upload_path($store_qrcode))) {
			$merchant_info['store_qrcode'] = RC_Upload::upload_url($store_qrcode).'?'.time();
		} 
		$this->assign('data', $merchant_info);
        $this->assign('form_action', RC_Uri::url('merchant/merchant/update'));

		$this->display('merchant_basic_info.dwt');
	}

    /**
	 * 店铺基本信息
	 */
	public function update() {
		$this->admin_priv('merchant_manage', ecjia::MSGTYPE_JSON);

        $store_id               = $_SESSION['store_id'];
        $shop_kf_mobile         = ($_POST['shop_kf_mobile'] == get_merchant_config('shop_kf_mobile'))       ? '' : htmlspecialchars($_POST['shop_kf_mobile']);
        $shop_description       = ($_POST['shop_description'] == get_merchant_config('shop_description'))   ? '' : htmlspecialchars($_POST['shop_description']);
        $shop_trade_time        = empty($_POST['shop_trade_time'])                                          ? '' : htmlspecialchars($_POST['shop_trade_time']);
        $shop_notice            = ($_POST['shop_notice'] == get_merchant_config('shop_notice'))             ? '' : htmlspecialchars($_POST['shop_notice']);
		$express_assign_auto	= isset($_POST['express_assign_auto']) ? intval($_POST['express_assign_auto']) : 0;
        
        $merchants_config = array();
		$merchants_config['express_assign_auto'] = $express_assign_auto;
        
		$shop_nav_background = get_merchant_config('shop_nav_background');
        $shop_logo           = get_merchant_config('shop_logo');
        $shop_thumb_logo     = get_merchant_config('shop_thumb_logo');
        $shop_banner_pic     = get_merchant_config('shop_banner_pic');
        $shop_front_logo     = get_merchant_config('shop_front_logo');

        // 店铺导航背景图
        if(!empty($_FILES['shop_nav_background']) && empty($_FILES['error']) && !empty($_FILES['shop_nav_background']['name'])){
        	$merchants_config['shop_nav_background'] = merchant_file_upload_info('shop_nav_background', '', $shop_nav_background);
        }
        // 默认店铺页头部LOGO
        if(!empty($_FILES['shop_logo']) && empty($_FILES['error']) && !empty($_FILES['shop_logo']['name'])){
            $merchants_config['shop_logo'] = merchant_file_upload_info('shop_logo', '', $shop_logo);
        }

        // APPbanner图
        if(!empty($_FILES['shop_banner_pic']) && empty($_FILES['error']) && !empty($_FILES['shop_banner_pic']['name'])){
            $merchants_config['shop_banner_pic'] = merchant_file_upload_info('shop_banner', 'shop_banner_pic', $shop_banner_pic);
        }
        // 如果没有上传店铺LOGO 提示上传店铺LOGO
        $shop_logo = get_merchant_config('shop_logo');
        if(empty($shop_logo) && empty($merchants_config['shop_logo'])){
            return $this->showmessage('请上传店铺LOGO', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if(!empty($shop_description)){
            $merchants_config['shop_description'] = $shop_description;// 店铺描述
        }
        $time = array();
        if (!empty($shop_trade_time)) {
            $shop_time       = explode(',',$shop_trade_time);
            //营业时间验证
            if($shop_time[0] >= 1440) {
                return $this->showmessage('营业开始时间不能为次日', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if($shop_time[1] - $shop_time[0] > 1440) {
                return $this->showmessage('营业时间最多为24小时', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if(($shop_time[1] - $shop_time[0] == 1440) && ($shop_time[0] != 0)) {
                return $this->showmessage('24小时营业请选择0-24', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            
            $s_h             = ($shop_time[0] / 60);
            $s_i             = ($shop_time[0] % 60);
            $e_h             = ($shop_time[1] / 60);
            $e_i             = ($shop_time[1] % 60);
            $start_h         = empty($s_h)? '00' : intval($s_h);
            $start_i         = empty($s_i)? '00' : intval($s_i);
            $end_h           = empty($e_h)? '00' : intval($e_h);
            $end_i           = empty($e_i)? '00' : intval($e_i);
            $start_time      = $shop_time[0] == 0 ? '00:00' : $start_h.":".$start_i;
            $end_time        = $end_h.":".$end_i;
            $time['start']   = $start_time;
            $time['end']     = $end_time;
            $shop_trade_time = serialize($time);
            if ($shop_trade_time != get_merchant_config('shop_trade_time')) {
                $merchants_config['shop_trade_time'] = $shop_trade_time;// 营业时间
            }
        }
        if(!empty($shop_notice)){
            $merchants_config['shop_notice'] = $shop_notice;// 店铺公告
        }
        if(!empty($shop_kf_mobile)){
            $merchants_config['shop_kf_mobile'] = $shop_kf_mobile;// 客服电话
        }
        if(!empty($merchants_config)){
            $merchant = set_merchant_config('', '', $merchants_config);
        }else{
            return $this->showmessage('请编辑要修改的内容', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if(!empty($merchant)){
            // 记录日志
            ecjia_merchant::admin_log('修改店铺基本信息', 'edit', 'merchant');
            return $this->showmessage('编辑成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('merchant/merchant/init')));
        }
	}

    /**
	 * 店铺基本信息
	 */
    public function drop_file(){
        $code = $_GET['code'];
        $img = get_merchant_config($code);
        $merchant = set_merchant_config($code, '');
        $file = !empty($img)? RC_Upload::upload_path($img) : '';
        $disk = RC_Filesystem::disk();
        $disk->delete($file);
        if($code == 'shop_nav_background'){
            $msg = '店铺导航背景图';
        }elseif($code == 'shop_logo'){
            $msg = '店铺LOGO';
        }elseif($code == 'shop_banner_pic'){
            $msg = 'APP Banner图';
        }
        // 记录日志
        ecjia_merchant::admin_log('删除'.$msg, 'edit', 'merchant');
        return $this->showmessage('成功删除', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('merchant/merchant/init')));
    }

    /**
     * 底部链接详情页
     */
    public function shopinfo() {
    	ecjia_screen::get_current_screen()->remove_last_nav_here();
    	ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('网店信息')));

    	$this->assign('ur_here', '网店信息');
    	$this->assign('shop_title', '网店信息');

    	$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
    	$shop_info = RC_DB::table('article')->where('cat_id', 0)->where('article_id', $id)->first();

    	if (empty($shop_info)) {
    		return $this->showmessage('该网店信息不存在', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_HTML);
    	}
    	$shopinfo_list = RC_DB::table('article')
	    	->select('article_id', 'title', 'content', 'file_url')
	    	->where('cat_id', 0)
	    	->where('article_type', 'shop_info')
	    	->orderby('article_id', 'asc')
	    	->get();

		if (!empty($shopinfo_list)) {
			$disk = RC_Filesystem::disk();
			foreach ($shopinfo_list as $k => $v) {
				if (!empty($v['file_url']) && $disk->exists(RC_Upload::upload_path($v['file_url']))) {
					$file_url = RC_Upload::upload_url($v['file_url']);
					$shopinfo_list[$k]['file_url'] = '<img src='.$file_url.' / style="width:12px;height:14px;">';
				} else {
					$shopinfo_list[$k]['file_url'] = '<i class="fa fa-info-circle"></i>';
				}
			}
		}
		$shop_info['content'] = stripslashes($shop_info['content']);
		$this->assign('id', $id);
    	$this->assign('shop_info', $shop_info);
    	$this->assign('info_list', $shopinfo_list);
    	$this->display('merchant_shopinfo.dwt');
    }

    /**
     * 商店公告
     */
    public function shop_notice() {
    	ecjia_screen::get_current_screen()->remove_last_nav_here();
    	ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('公告通知')));

    	$this->assign('ur_here', '公告通知');

    	$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
    	$shop_notice = RC_DB::table('article')->where('article_id', $id)->first();

    	$shop_notice_list = RC_DB::table('article as a')
 			->orderBy(RC_DB::raw('a.add_time'), 'desc')
 			->take(5)
 			->where(RC_DB::raw('a.article_type'), 'merchant_notice')
 			->get();
    	if (!empty($shop_notice_list)) {
    		$disk = RC_Filesystem::disk();
    		foreach ($shop_notice_list as $k => $v) {
    			if (!empty($v['file_url']) && $disk->exists(RC_Upload::upload_path($v['file_url']))) {
    				$file_url = RC_Upload::upload_url($v['file_url']);
    				$shop_notice_list[$k]['file_url'] = '<img src='.$file_url.' / style="width:12px;height:14px;">';
    			} else {
    				$shop_notice_list[$k]['file_url'] = '<i class="fa fa-info-circle"></i>';
    			}
    		}
    	}

    	$this->assign('id', $id);
    	$this->assign('shop_notice', $shop_notice);
    	$this->assign('list', $shop_notice_list);
    	$this->display('merchant_shop_notice.dwt');
    }

    /**
     * 店铺开关
     */
    public function mh_switch() {
        $this->admin_priv('merchant_switch');

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('店铺开关'));
        $this->assign('app_url', RC_App::apps_url('statics', __FILE__));

        $this->assign('ur_here', '店铺上下线');
        $merchant_info = RC_DB::table('store_franchisee')->where('store_id', $_SESSION['store_id'])->first();
        $merchant_info['mobile'] = RC_DB::table('staff_user')->where('store_id', $_SESSION['store_id'])->where('parent_id', 0)->pluck('mobile');

        $this->assign('merchant_info', $merchant_info);
        $this->assign('form_action', RC_Uri::url('merchant/merchant/mh_switch_update'));

        if ($merchant_info['shop_close'] == 1 && $merchant_info['identity_status'] != 2 && ecjia::config('store_identity_certification') == 1) {
            $this->assign('tips', '您还未完成信息认证，暂无法上线店铺。您可以先完善资质信息，等待审核，等待的同时可以更新您的商品和其他信息。<a href="'.RC_Uri::url('merchant/mh_franchisee/request_edit').'">完善资质信息</a>');
        }

        $this->display('mh_switch.dwt');

    }
    /**
     * 店铺开关
     */
    public function mh_switch_update() {
        $this->admin_priv('merchant_switch', ecjia::MSGTYPE_JSON);

        $shop_close = isset($_POST['shop_close']) ? $_POST['shop_close'] : null;
        $code = !empty($_POST['code'])   ? $_POST['code'] 		: '';
        $mobile = !empty($_POST['mobile']) ? trim($_POST['mobile']) : '';
        if (is_null($shop_close)) {
            return $this->showmessage('错误的提交', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $past_time = RC_Time::gmtime()-1800;
        $staff_mobile = RC_DB::table('staff_user')->where('store_id', $_SESSION['store_id'])->where('parent_id', 0)->pluck('mobile');
        if (empty($code) || $code != $_SESSION['temp_code'] || $past_time >= $_SESSION['temp_code_time'] || $mobile != $_SESSION['temp_mobile'] || $staff_mobile != $_SESSION['temp_mobile']) {
            return $this->showmessage('请输入正确的手机验证码', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $switch_update = RC_DB::table('store_franchisee')->where('store_id', $_SESSION['store_id'])->update(array('shop_close' => $shop_close));
        
        /* 释放app缓存*/
        $store_franchisee_db = RC_Model::model('merchant/orm_store_franchisee_model');
        $store_cache_array = $store_franchisee_db->get_cache_item('store_list_cache_key_array');
        if (!empty($store_cache_array)) {
        	foreach ($store_cache_array as $val) {
        		$store_franchisee_db->delete_cache_item($val);
        	}
        	$store_franchisee_db->delete_cache_item('store_list_cache_key_array');
        }
        
		if($shop_close == '1'){
			clear_cart_list($_SESSION['store_id']);
		}
        if($switch_update) {
            $_SESSION['temp_mobile']	= '';
            $_SESSION['temp_code'] 		= '';
            $_SESSION['temp_code_time'] = '';
            // 记录日志
            if ($shop_close == 0) {
                ecjia_merchant::admin_log('店铺上线', 'edit', 'merchant');
            } else if ($shop_close == 1) {
                ecjia_merchant::admin_log('店铺下线', 'edit', 'merchant');
            }
            return $this->showmessage('编辑成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('merchant/merchant/mh_switch')));
        } else if ($switch_update == 0) {
            return $this->showmessage('您未做任何修改', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } else {
            return $this->showmessage('修改失败，请重试！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

    }

    public function get_code_value() {
        $mobile = isset($_GET['mobile']) ? $_GET['mobile'] : '';
        if (empty($mobile)){
            return $this->showmessage('请输入手机号码', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $code = rand(100000, 999999);
        $options = array(
        	'mobile' => $mobile,
        	'event'	 => 'sms_get_validate',
        	'value'  =>array(
        		'code' 			=> $code,
        		'service_phone' => ecjia::config('service_phone'),
        	),
        );
        $response = RC_Api::api('sms', 'send_event_sms', $options);
        
        $_SESSION['temp_mobile']	= $mobile;
        $_SESSION['temp_code'] 		= $code;
        $_SESSION['temp_code_time'] = RC_Time::gmtime();
        
        if (is_ecjia_error($response)) {
        	return $this->showmessage($response->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } else {
            return $this->showmessage('手机验证码发送成功，请注意查收', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
        }
    }
    
    /**
     * 刷新店铺二维码
     */
    public function refresh_qrcode() {
    	$store_id = $_SESSION['store_id'];
    	//删除生成的店铺二维码
    	$disk = RC_Filesystem::disk();
    	$store_qrcode = 'data/qrcodes/merchants/merchant_'.$store_id.'.png';
    	if ($disk->exists(RC_Upload::upload_path($store_qrcode))) {
    		$disk->delete(RC_Upload::upload_path().$store_qrcode);
    	}
    	ecjia_merchant::admin_log('刷新店铺二维码', 'edit', 'merchant');
    	
    	$merchant_info = get_merchant_info();
    	if (!empty($merchant_info['shop_logo'])) {
    		$merchant_info['store_qrcode'] = with(new Ecjia\App\Mobile\Qrcode\GenerateMerchant($_SESSION['store_id'],  $merchant_info['shop_logo']))->getQrcodeUrl();
    	}
    	return $this->showmessage('刷新成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('merchant/merchant/init')));
    }
}

//end