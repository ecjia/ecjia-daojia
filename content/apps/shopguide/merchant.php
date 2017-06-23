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
 * 商家开启向导
 * @author wutifang
 */
class merchant extends ecjia_merchant {
	private $db_region;
	
	public function __construct() {
		parent::__construct();
		
		$this->db_region = RC_Loader::load_model('region_model');
		
		RC_Script::enqueue_script('jquery-validate');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-stepy');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('ecjia-region');
		
        RC_Loader::load_app_func('global', 'goods');
		RC_Loader::load_app_func('merchant_shopguide');
		RC_Loader::load_app_func('global', 'shopguide');
		assign_adminlog_contents();
		
		RC_Script::enqueue_script('ecjia-mh-bootstrap-fileupload-js');
		RC_Style::enqueue_style('ecjia-mh-bootstrap-fileupload-css');
		
		// 时间区间
		RC_Style::enqueue_style('range', RC_App::apps_url('statics/css/range.css', __FILE__), array());
		RC_Script::enqueue_script('jquery-range', RC_App::apps_url('statics/mh-js/jquery.range.js', __FILE__), array(), false, true);
		RC_Script::enqueue_script('shopguide', RC_App::apps_url('statics/mh-js/shopguide.js', __FILE__), array(), false, false);
		RC_Script::enqueue_script('migrate', RC_App::apps_url('statics/mh-js/migrate.js', __FILE__) , array() , false, true);
		
		RC_Loader::load_app_class('goods', 'goods', false);
		RC_Loader::load_app_class('goods_image_data', 'goods', false);
		RC_Loader::load_app_class('goods_imageutils', 'goods', false);
	}
	
    public function init() {
    	$this->admin_priv('shopguide_setup');
    	
    	$this->assign('ur_here', RC_Lang::get('shopguide::shopguide.shopguide'));
    	
		if (isset($_GET['step']) && $_GET['step'] > 1) {
			ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('shopguide::shopguide.shopguide'), RC_Uri::url('shopguide/merchant/init')));
		} else {
			ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('shopguide::shopguide.shopguide')));
		}
		
		$merchant_info['merchants_name'] = RC_DB::table('store_franchisee')->where('store_id', $_SESSION['store_id'])->pluck('merchants_name');
		$s_time = 480;
		$e_time = 1260;
		$merchant_info['shop_time_value'] = $s_time.",".$e_time;
		
		$this->assign('data', $merchant_info);
		$this->display('shop_guide.dwt');
    }
    
    public function step_post() {
    	$this->admin_priv('shopguide_setup', ecjia::MSGTYPE_JSON);

    	$step = !empty($_GET['step']) ? intval($_GET['step']) : 1;
    	
    	if ($step == 1) {
    		$store_id               = $_SESSION['store_id'];
    		$shop_description       = ($_POST['shop_description'] == get_merchant_config('shop_description'))   ? '' : htmlspecialchars($_POST['shop_description']);
    		$shop_trade_time        = empty($_POST['shop_trade_time'])                                          ? '' : htmlspecialchars($_POST['shop_trade_time']);
    		$shop_notice            = ($_POST['shop_notice'] == get_merchant_config('shop_notice'))             ? '' : htmlspecialchars($_POST['shop_notice']);
    		
    		$merchant_config = array();
    		
    		// 店铺导航背景图
    		if (!empty($_FILES['shop_nav_background']) && empty($_FILES['error']) && !empty($_FILES['shop_nav_background']['name'])) {
    			$merchants_config['shop_nav_background'] = shopguide_file_upload_info('shop_nav_background', '', $shop_nav_background);
    		}
    		// 默认店铺页头部LOGO
    		if (!empty($_FILES['shop_logo']) && empty($_FILES['error']) && !empty($_FILES['shop_logo']['name'])) {
    			$merchants_config['shop_logo'] = shopguide_file_upload_info('shop_logo', '', $shop_logo);
    		}
    		
    		// APPbanner图
    		if (!empty($_FILES['shop_banner_pic']) && empty($_FILES['error']) && !empty($_FILES['shop_banner_pic']['name'])) {
    			$merchants_config['shop_banner_pic'] = shopguide_file_upload_info('shop_banner', 'shop_banner_pic', $shop_banner_pic);
    		}
    		// 如果没有上传店铺LOGO 提示上传店铺LOGO
    		$shop_logo = get_merchant_config('shop_logo');
    		if (empty($shop_logo) && empty($merchants_config['shop_logo'])) {
    			return $this->showmessage('请上传店铺LOGO', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}
    		
    		if (!empty($shop_description)) {
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
    		if (!empty($shop_notice)) {
    			$merchants_config['shop_notice'] = $shop_notice;// 店铺公告
    		}
    		if (!empty($merchants_config)) {
    			$merchant = set_merchant_config('', '', $merchants_config);
    		}
    		
    		ecjia_merchant::admin_log('修改店铺基本信息', 'edit', 'merchant');
    		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => RC_Uri::url('shopguide/merchant/init', array('step' => 2))));
    		
    	} elseif ($step == 2) {
    		$cat_name 		= empty($_POST['cat_name']) 		? '' 	: trim($_POST['cat_name']);
    		$goods_name 	= empty($_POST['goods_name']) 		? '' 	: trim($_POST['goods_name']);
    		$goods_type 	= empty($_POST['goods_type'])		? ''	: trim($_POST['goods_type']);

    		$goods_number 	= empty($_POST['goods_num']) 		? 0 	: intval($_POST['goods_num']);
    		$goods_price 	= empty($_POST['goods_price']) || !is_numeric($_POST['goods_price']) ? 0 : $_POST['goods_price'];
    		
    		$is_best 		= empty($_POST['is_best']) 			? 0 	: 1;
    		$is_new 		= empty($_POST['is_new']) 			? 0 	: 1;
    		$is_hot 		= empty($_POST['is_hot']) 			? 0 	: 1;
    		$goods_desc 	= empty($_POST['goods_desc']) 		? '' 	: $_POST['goods_desc'];

    		if (empty($cat_name)) {
    			return $this->showmessage(RC_Lang::get('shopguide::shopguide.goods_cat_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}
    		
    		if (empty($goods_name)) {
    			return $this->showmessage(RC_Lang::get('shopguide::shopguide.goods_name_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}

    		$count = RC_DB::table('merchants_category')->where('cat_name', $cat_name)->where('store_id', $_SESSION['store_id'])->count();
    		if ($count > 0) {
    			return $this->showmessage(RC_Lang::get('shopguide::shopguide.cat_name_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}
    		$merchant_cat_id = RC_DB::table('merchants_category')->insertGetId(array('cat_name' => $cat_name, 'is_show' => 1, 'store_id' => $_SESSION['store_id']));

    		$goods_type_id = 0;
    		if (!empty($goods_type)) {
    			$count = RC_DB::table('goods_type')->where('cat_name', $goods_type)->where('store_id', $_SESSION['store_id'])->count();
    			if ($count > 0) {
    				return $this->showmessage('该商品类型已存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    			}
    			$goods_type_id = RC_DB::table('goods_type')->insertGetId(array('cat_name' => $goods_type, 'enabled' => 1, 'store_id' => $_SESSION['store_id']));
    		}
    		
    		//生成商品货号
    		$max_id = RC_DB::table('goods')->selectRaw('(MAX(goods_id) + 1) as max')->first();
    		if (empty($max_id['max'])) {
    			$goods_sn_bool = true;
    			$goods_sn = '';
    		} else {
    			$goods_sn = generate_goods_sn($max_id['max']);
    		}
    		
    		/* 处理商品图片 */
    		$goods_img    = ''; 	// 初始化商品图片
    		$goods_thumb  = ''; 	// 初始化商品缩略图
    		$img_original = ''; // 初始化原始图片
    		
    		$upload = RC_Upload::uploader('image', array('save_path' => 'images', 'auto_sub_dirs' => true));
    		$upload->add_saving_callback(function ($file, $filename) {
    			return true;
    		});
    		
    		/* 是否处理商品图 */
    		$proc_goods_img = true;
    		if (isset($_FILES['goods_img'])) {
    			if (!$upload->check_upload_file($_FILES['goods_img'])) {
    				$proc_goods_img = false;
    			}
    		}
    			
    		if ($proc_goods_img) {
    			if (isset($_FILES['goods_img'])) {
    				$image_info = $upload->upload($_FILES['goods_img']);
    				if (empty($image_info)) {
    					return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    				}
    			}
    		}
    			
    		if ($proc_thumb_img) {
    			if (isset($_FILES['thumb_img'])) {
    				$thumb_info = $upload->upload($_FILES['thumb_img']);
    				if (empty($thumb_info)) {
    					return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    				}
    			}
    		}
    			
    		$data = array(
    			'goods_name'            => $goods_name,
    			'goods_sn'              => $goods_sn,
    			'merchant_cat_id'		=> $merchant_cat_id,	//店铺分类id
    			'goods_type'			=> $goods_type_id,
    			'shop_price'            => $goods_price,
    			'goods_brief'           => $goods_desc,
    			'goods_number'          => $goods_number,
    			'store_best'            => $is_best,
    			'store_new'             => $is_new,
    			'store_hot'             => $is_hot,
    			'add_time'              => RC_Time::gmtime(),
    			'review_status'         => 5,
    			'store_id'				=> $_SESSION['store_id']
    		);
    		$goods_id = RC_DB::table('goods')->insertGetId($data);
    			
    		/* 更新上传后的商品图片 */
    		if ($proc_goods_img) {
    			if (isset($image_info)) {
    				$goods_image = new goods_image_data($image_info['name'], $image_info['tmpname'], $image_info['ext'], $goods_id);
    				if ($proc_thumb_img) {
    					$goods_image->set_auto_thumb(false);
    				}
    			
    				$result = $goods_image->update_goods();
    				if (is_ecjia_error($result)) {
    					return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    				}
    			}
    		}

    		/* 记录日志 */
    		ecjia_merchant::admin_log($goods_name, 'add', 'goods');
    		$links = array(array('text' => '仪表盘', 'href' => RC_Uri::url('merchant/dashboard/init')));
    		return $this->showmessage(RC_Lang::get('shopguide::shopguide.complete'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('shopguide/merchant/init', array('step' => 3))));
    	}
    }
    
    //获取支付方式信息
    public function get_pay() {
    	$code = !empty($_POST['code']) ? trim($_POST['code']) : '';
    	$pay  = RC_Api::api('payment', 'pay_info', array('code' => $code));
    	
    	return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $pay));
    }
}

// end