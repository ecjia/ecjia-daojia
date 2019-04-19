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
 *  ECJIA 商品管理程序
 */
class merchant extends ecjia_merchant {
    
    private $db_goods;

	public function __construct() {
		parent::__construct();
		
		$this->db_goods 			= RC_Model::model('goods/goods_model');
		
		RC_Style::enqueue_style('jquery-placeholder');
		RC_Script::enqueue_script('jquery-imagesloaded');
		RC_Script::enqueue_script('jquery-dropper', RC_Uri::admin_url('/statics/lib/dropper-upload/jquery.fs.dropper.js'), array(), false, 1);
		
		RC_Script::enqueue_script('jq_quicksearch', RC_Uri::admin_url() . '/statics/lib/multi-select/js/jquery.quicksearch.js', array('jquery'), false, 1);
// 		RC_Script::enqueue_script('ecjia-region', RC_Uri::admin_url('statics/ecjia.js/ecjia.region.js'), array('jquery'), false, true);
		
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-ui');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('jquery-colorbox');
		RC_Style::enqueue_style('jquery-colorbox');
		
		RC_Script::enqueue_script('ecjia-mh-editable-js');
		RC_Style::enqueue_style('ecjia-mh-editable-css');
		
		//时间控件
		RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'), array(), false, 1);
		RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));
		
		RC_Style::enqueue_style('goods', RC_App::apps_url('statics/styles/goods.css', __FILE__), array());
		RC_Script::enqueue_script('goods_list', RC_App::apps_url('statics/js/merchant_goods_list.js', __FILE__), array(), false, 1);

        RC_Script::localize_script('goods_list', 'js_lang', config('app-goodslib::jslang.merchant_goods_list_page'));
		
		RC_Loader::load_app_class('goods', 'goods', false);
		RC_Loader::load_app_class('goodslib', 'goodslib', false);
		RC_Loader::load_app_class('goods_image_data', 'goods', false);
		RC_Loader::load_app_class('goods_imageutils', 'goods', false);

		RC_Loader::load_app_func('merchant_goods', 'goods');
		RC_Loader::load_app_func('global', 'goods');
		RC_Loader::load_app_func('global', 'goodslib');
		RC_Loader::load_app_func('admin_category', 'goods');
		
		RC_Loader::load_app_func('admin_user', 'user');
		$goods_list_jslang = array(
			'user_rank_list'	=> get_rank_list(),
			'marketPriceRate'	=> ecjia::config('market_price_rate'),
			'integralPercent'	=> ecjia::config('integral_percent'),
		);
		RC_Script::localize_script( 'goods_list', 'admin_goodsList_lang', $goods_list_jslang );
		
		ecjia_merchant_screen::get_current_screen()->set_parentage('goods', 'goods/merchant.php');
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品管理', 'goodslib'), RC_Uri::url('goods/merchant/init')));
	}

	/**
	* 商品列表
	*/
	public function init() {
	    // 检查权限
	    $this->admin_priv('goodslib_manage');
	    
	    ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('一键导入', 'goodslib'), RC_Uri::url('goodslib/merchant/init')));
	    
	    $cat_id 	= !empty($_GET['cat_id']) 		? intval($_GET['cat_id']) 		: 0;
// 	    $brand_id  	= !empty($_POST['brand_id']) 	? intval($_POST['brand_id']) 	: 0;
	    
	    //所属平台分类
        $cat_list = cat_list(0, 0, false, 1, false);	//平台分类
        $ur_here = __('选择商品分类', 'goodslib');
        $this->assign('step', 1);
        $this->assign('cat_list', $cat_list);
	    
	    $this->assign('ur_here', $ur_here);
	    ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here($ur_here));
	    
	    $this->assign('cfg', ecjia::config());
	    
        $this->display('goods_cat_select.dwt');
	}
	
	
	public function add() {
	    // 检查权限
	    $this->admin_priv('goodslib_manage');
	    
	    ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('一键导入', 'goodslib'), RC_Uri::url('goodslib/merchant/init')));
	    
	    $cat_id 	= !empty($_GET['cat_id']) 		? intval($_GET['cat_id']) 		: 0;
	    
	    if(empty($cat_id)) {
	        return $this->showmessage(__('请先选择分类', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('goods/merchant/select_cat')));
	    }
	    
        $ur_here = __('选择商品', 'goodslib');
        $this->assign('step', 2);
        
        $goods_list = goodslib::goods_list(0, " AND is_display = 1 ");
        $this->assign('goods_list', $goods_list);
        $this->assign('filter', $goods_list['filter']);
        
        $merchant_cat = merchant_cat_list(0, 0, true, 2, false);		//店铺分类
        $this->assign('merchant_cat', $merchant_cat);
	    
	    $this->assign('ur_here', $ur_here);
	    ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here($ur_here));
	    
	    $this->assign('form_action', RC_Uri::url('goodslib/merchant/insert', array('cat_id' => $cat_id)));
	    
        $this->display('goods_list.dwt');
	}
	
	/**
	 * 导入
	 */
	public function insert() {
	    // 检查权限
	    $this->admin_priv('goodslib_manage');
	    $error_message = [];
	    
	    if(isset($_POST['goods_ids'])) {//批量导入
	        if (empty($_POST['goods_ids'])) {
	            return $this->showmessage(__('请选择导入的商品', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	        }
	        
	        foreach ($_POST['goods_ids'] as $goods_id) {
	            $rs = $this->insert_goods($goods_id);
	            if(is_ecjia_error($rs)) {
	                return $this->showmessage($rs->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	            }
	            if(is_array($rs) && $rs['state'] == 'error') {
	                $error_message[] = $rs['message'];
	            }
	        }
	        
	    } else {//单个导入
	        $id = isset($_POST['goods_id']) 		? intval($_POST['goods_id']) 		: 0;
	        $goods_name = isset($_POST['goods_name']) 		? $_POST['goods_name'] 		: '';
	        $goods_sn = isset($_POST['goods_sn']) 		? $_POST['goods_sn'] 		: '';
	        $shop_price = isset($_POST['shop_price']) 		? $_POST['shop_price'] 		: 0;
	        $market_price = isset($_POST['market_price']) 		? $_POST['market_price'] 		: 0;
	        $goods_number = isset($_POST['goods_number']) 		? intval($_POST['goods_number']) : ecjia::config('default_storage');
	        $merchant_cat_id = isset($_POST['merchant_cat_id']) 	? intval($_POST['merchant_cat_id']) : 0;
	        if(empty($id)) {
	            return $this->showmessage(__('请选择导入的商品', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	        }
	        if(empty($goods_name)) {
	            return $this->showmessage(__('请填写商品名称', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	        }
	        if(empty($shop_price)) {
	            return $this->showmessage(__('请填写商品价格', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	        }
	        if(empty($merchant_cat_id)) {
	            return $this->showmessage(__('请选择店铺商品分类', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	        }
	        /* 如果没有输入商品货号则自动生成一个商品货号 */
	        if (empty($goods_sn)) {
	            $max_id = $this->db_goods->goods_find('', 'MAX(goods_id) + 1|max');
	            if (empty($max_id['max'])) {
	                $goods_sn_bool = true;
	                $goods_sn = '';
	            } else {
	                $goods_sn = generate_goods_sn($max_id['max']);
	            }
	            $_POST['goods_sn'] = $goods_sn;
	        } else {
	            /* 检查货号是否重复 */
	            $count = $this->db_goods->is_only(array('goods_sn' => $goods_sn, 'is_delete' => 0, 'store_id' => $_SESSION['store_id']));
	            if ($count > 0) {
	                return $this->showmessage(__('您输入的货号已存在，请换一个', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	            }
	        }
	        
	        $rs = $this->insert_goods($id, $_POST);
	        if(is_ecjia_error($rs)) {
	            return $this->showmessage($rs->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	        }
	        if(is_array($rs) && $rs['state'] == 'error') {
	            $error_message[] = $rs['message'];
	        }
	    }
	    if($error_message) {
	        RC_Logger::getlogger('error')->info(__('商品导入错误信息：', 'goodslib'));
	        RC_Logger::getlogger('error')->info($error_message);
	    }
	    
	    
	    $url = RC_Uri::url('goodslib/merchant/success', array());
	    return $this->showmessage(__('导入成功', 'goodslib'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url, 'error_message' =>$error_message));
	    
	}
	
	private function insert_goods($id, $ext_info = array()) {
	    // 检查权限
	    $this->admin_priv('goodslib_manage');
	    /* 商品信息 */
	    $goods = RC_DB::table('goodslib')->where('goods_id', $id)->where('is_display', 1)->where('is_delete', 0)->first();
	    if (empty($goods)) {
	        return new ecjia_error('no_goods', __('未检测到此商品', 'goodslib'));
	    }
	    
	    $is_exist_goodslib = RC_DB::table('goods')->where('goodslib_id', $id)->where('store_id', $_SESSION['store_id'])->where('is_delete', 0)->first();
	    if($is_exist_goodslib) {
// 	        return array('state' => 'error', 'message' => '商品【'.$is_exist_goodslib['goods_name'].'】已导入，请勿重复导入。');
	        return new ecjia_error('goods_exists', sprintf(__('商品【%s】已导入，请勿重复导入', 'goodslib'), $is_exist_goodslib['goods_name']));
	    }
	    
	    $count_goods_sn = RC_DB::table('goods')->where('goods_sn', $goods['goods_sn'])->where('store_id', $_SESSION['store_id'])->where('is_delete', 0)->count();
	    if($count_goods_sn) {
// 	        return array('state' => 'error', 'message' => '商品【'.$is_exist_goodslib['goods_name'].'】货号【'.$is_exist_goodslib['goods_sn'].'】重复，此条信息未导入。');
	        $goods['goods_sn'] = '';
	        //return new ecjia_error('goods_sn_exists', __('您输入的货号已存在，请换一个', 'goodslib'));
	    }
	    unset($goods['goods_id']);unset($goods['is_display']);unset($goods['used_count']);unset($goods['is_delete']);unset($goods['goods_rank']);
	    $goods['store_id'] = $_SESSION['store_id'];
	    if(!empty($ext_info)) {
	        $goods_name = isset($ext_info['goods_name']) 		? $ext_info['goods_name'] 		: '';
	        $goods_sn = isset($ext_info['goods_sn']) 		? $ext_info['goods_sn'] 		: '';
	        $shop_price = isset($ext_info['shop_price']) 		? $ext_info['shop_price'] 		: 0;
	        $market_price = isset($ext_info['market_price']) 		? $ext_info['market_price'] 		: 0;
	        $goods_number = isset($ext_info['goods_number']) 		? intval($ext_info['goods_number']) : ecjia::config('default_storage');
	        $is_best = isset($ext_info['is_best']) 		? intval($ext_info['is_best']) 		: 0;
	        $is_new = isset($ext_info['is_new']) 		? intval($ext_info['is_new']) 		: 0;
	        $is_hot = isset($ext_info['is_hot']) 		? intval($ext_info['is_hot']) 		: 0;
	        $is_shipping = isset($ext_info['is_shipping']) 		? intval($ext_info['is_shipping']) 		: 0;
	        $is_on_sale = isset($ext_info['is_on_sale']) 		? intval($ext_info['is_on_sale']) 		: 0;
	        $merchant_cat_id = isset($ext_info['merchant_cat_id']) 	? intval($ext_info['merchant_cat_id']) 		: 0;
	        
	        $goods['goods_name'] = $goods_name;
	        $goods['goods_sn'] = $goods_sn;
	        $goods['shop_price'] = $shop_price;
	        $goods['market_price'] = $market_price;
	        $goods['goods_number'] = $goods_number;
	        $goods['store_best'] = $is_best;
	        $goods['store_new'] = $is_new;
	        $goods['store_hot'] = $is_hot;
	        $goods['is_shipping'] = $is_shipping;
	        $goods['is_on_sale'] = $is_on_sale;
	        $goods['merchant_cat_id'] = $merchant_cat_id;
	    }
	    if($goods['goods_sn']) {
	        $count = $this->db_goods->is_only(array('goods_sn' => $goods['goods_sn'], 'is_delete' => 0, 'store_id' => $_SESSION['store_id']));
	        if ($count > 0) {
	            $max_id = $this->db_goods->goods_find('', 'MAX(goods_id) + 1|max');
	            if (empty($max_id['max'])) {
	                $goods_sn_bool = true;
	                $goods['goods_sn'] = '';
	            } else {
	                $goods['goods_sn'] = generate_goods_sn($max_id['max']);
	            }
	        }
	    }
	    
	    $time = RC_Time::gmtime();
	    $goods['add_time'] = $time;
	    $goods['last_update'] = $time;
	    $goods['goodslib_id'] = $id;//关联id
	    $goods['goodslib_update_time'] = $time;//同步时间
	    
	    $new_id = RC_DB::table('goods')->insertGetId($goods);
	    RC_DB::table('goodslib')->where('goods_id', $id)->increment('used_count');
	    if(!empty($goods['goods_img'])) {
	        //复制图片-重命名
	        $img_data = array(
	            'goods_img' => $goods['goods_img'], 
	            'goods_thumb' => $goods['goods_thumb'], 
	            'original_img' => $goods['original_img']
	        );
	        copy_goodslib_images($id, $new_id, $img_data);
	    }
	    if(!empty($goods['goods_desc'])) {
	        //复制图片-重命名
	        copy_goodslib_desc($id, $new_id, $goods['goods_desc']);
	    }
	    $goods_gallery = RC_DB::table('goodslib_gallery')->where('goods_id', $id)->where('product_id', 0)->get();
	    if (!empty($goods_gallery)) {
	        //复制图片-重命名
	        copy_goodslib_gallery($id, $new_id, $goods_gallery);
	    }
	    
	    if ($goods['goods_type']) {
	        $cat_id = $goods['goods_type'];
	        $goods_attr = RC_DB::table('goodslib_attr')->where('goods_id', $id)->get();
	        if($goods_attr) {
	            $goods_type = RC_DB::table('goods_type')->where('cat_id', $cat_id)->first();
	            if($goods_type) {
	                //goods_attr attr_id
	                foreach ($goods_attr as $row) {
	                    unset($row['goods_attr_id']);
	                    $row['goods_id'] = $new_id;
	                    RC_DB::table('goods_attr')->insert($row);
	                }
	                
	                //product
	                $this->copy_goodslib_product($id, $goods_attr, array('goods_id' => $new_id, 'goods_sn' => $goods['goods_sn'], 'cat_id' => $cat_id));
	            }
	        }
	    }
	    
	    return true;
	}
	
	public function success() {
	    $ur_here = __('导入成功', 'goodslib');
	    $this->assign('step', 3);
	    
	    
	    $this->assign('ur_here', $ur_here);
	    ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('一键导入', 'goodslib'), RC_Uri::url('goodslib/merchant/init')));
	    ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here($ur_here));
	    
	    $this->display('success.dwt');
	}
	
	
	/**
	 * 预览
	 */
	public function preview() {
	    // 检查权限
	    $this->admin_priv('goodslib_manage');
	    
	    $goods_id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
	    if (empty($goods_id)) {
	        return $this->showmessage(__('未检测到此商品', 'goodslib'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('返回上一页', 'goodslib'), 'href' => 'javascript:history.go(-1)'))));
	    }
	    
	    //RC_Hook::do_action('goods_merchant_priview_handler', $goods_id);
	    
	    ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品预览', 'goodslib')));
	    
	    $this->assign('ur_here', __('商品预览', 'goodslib'));
	    $this->assign('action_link', array('text' => '返回', 'href' => RC_Uri::url('goodslib/merchant/add', array('cat_id' => $_GET['cat_id']))));
	    
	    $goods = RC_DB::table('goodslib')->where('goods_id', $goods_id)->where('is_display', 1)->where('is_delete', 0)->first();
	    
	    if (empty($goods)) {
	        return $this->showmessage(__('未检测到此商品', 'goodslib'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text'=> __('返回商品列表', 'goodslib'),'href'=>RC_Uri::url('goods/merchant/init')))));
	    }
	    
	    if (!empty($goods['goods_desc'])) {
	        $goods['goods_desc'] = stripslashes($goods['goods_desc']);
	    }
	    
	    $cat_name = RC_DB::table('category')->where('cat_id', $goods['cat_id'])->pluck('cat_name');
	    $brand_name = RC_DB::table('brand')->where('brand_id', $goods['brand_id'])->pluck('brand_name');
	    $disk = RC_Filesystem::disk();
	    if (!$disk->exists(RC_Upload::upload_path($goods['goods_thumb'])) || empty($goods['goods_thumb'])) {
	        $goods['goods_thumb'] = RC_Uri::admin_url('statics/images/nopic.png');
	        $goods['goods_img'] = RC_Uri::admin_url('statics/images/nopic.png');
	    } else {
	        $goods['goods_thumb'] = RC_Upload::upload_url($goods['goods_thumb']);
	        $goods['goods_img'] = RC_Upload::upload_url($goods['goods_img']);
	    }
	    if (!empty($goods['add_time'])) {
	        $goods['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $goods['add_time']);
	    }
	    if (!empty($goods['last_update'])) {
	        $goods['last_update'] = RC_Time::local_date(ecjia::config('time_format'), $goods['last_update']);
	    }
	    
	    $images_url = RC_App::apps_url('statics/images', __FILE__);
	    $this->assign('images_url', $images_url);
	    
	    /* 根据商品重量的单位重新计算 */
	    if ($goods['goods_weight'] > 0) {
	        $goods['goods_weight_by_unit'] = ($goods['goods_weight'] >= 1) ? $goods['goods_weight'] : ($goods['goods_weight'] / 0.001);
	    }
	    $unit = $goods['goods_weight'] >= 1 ? '1' : '0.001';
	    $unit_list = goods::unit_list();
	    $goods['goods_weight_unit'] = $unit_list[$unit];
	    
	    $merchant_cat = merchant_cat_list(0, 0, true, 2, false);		//店铺分类
	    $this->assign('merchant_cat', $merchant_cat);
	    
	    //商品相册
	    $goods_photo_list = RC_DB::table('goodslib_gallery')->where('goods_id', $goods['goods_id'])->where('product_id', 0)->get();
	    if (!empty($goods_photo_list)) {
	        $disk = RC_Filesystem::disk();
	        foreach ($goods_photo_list as $k => $v) {
	            if (!$disk->exists(RC_Upload::upload_path($v['img_url'])) || empty($v['img_url'])) {
	                $goods_photo_list[$k]['img_url'] = RC_Uri::admin_url('statics/images/nopic.png');
	            } else {
	                $goods_photo_list[$k]['img_url'] = RC_Upload::upload_url($v['img_url']);
	            }
	            
	            if (!$disk->exists(RC_Upload::upload_path($v['thumb_url'])) || empty($v['thumb_url'])) {
	                $goods_photo_list[$k]['thumb_url'] = RC_Uri::admin_url('statics/images/nopic.png');
	            } else {
	                $goods_photo_list[$k]['thumb_url'] = RC_Upload::upload_url($v['thumb_url']);
	            }
	        }
	    }
	    $this->assign('goods_photo_list', $goods_photo_list);
	    
	    // 获得商品的规格和属性
	    $properties = get_goodslib_properties($goods_id);
	    $this->assign('specification', $properties['spe']);
	    
	    //商品属性
	    $attr_list = get_goodslib_attr_list($goods_id);
	    $this->assign('attr_list', $attr_list);
	    
	    //货品
	    $product = goodslib_product_list($goods_id, '');
	    $this->assign('products', $product);
	    
	    $this->assign('no_picture', RC_Uri::admin_url('statics/images/nopic.png'));
	    /* 取得分类、品牌 */
	    $this->assign('goods', $goods);
	    $this->assign('cat_name', $cat_name);
	    $this->assign('brand_name', $brand_name);
	    $this->assign('form_action', RC_Uri::url('goodslib/merchant/insert'));
	    
	    $this->display('preview.dwt');
	}
	
	/**
	 * 复制货品
	 * @param int $goodslib_id
	 * @param array $goods_attribute_formate
	 * @param array $goodslib_attr
	 * @param array $goods [goods_id][goods_sn][cat_id]
	 */
	private function copy_goodslib_product($goodslib_id, $goodslib_attr, $goods = array()) {
	    $goodslib_products = RC_DB::table('goodslib_products')->where('goods_id', $goodslib_id)->get();
	    $goods_attr_formate = array_change_key($goodslib_attr, 'goods_attr_id');
	    $goods_attr_store = RC_DB::table('goods_attr')->where('goods_id', $goods['goods_id'])->get();
	    $goods_attr_store_formate = array_change_key($goods_attr_store, array('goods_id', 'attr_id', 'attr_value'));
	    
	    if($goodslib_products) {
	        foreach ($goodslib_products as $key => $product) {
	            unset($goodslib_products[$key]['product_id']);
	            $goodslib_products[$key]['goods_id'] = $goods['goods_id'];
	            $product_attr = explode('|', $product['goods_attr']);
	            $new_attr_id = [];
	            foreach ($product_attr as $goods_attr_id) {
	                //goods_attr_id goods_id attr_id attr_value
	                //组合唯一 attr_id*attr_value
	                $attr_id = $goods_attr_formate[$goods_attr_id]['attr_id'];
	                $attr_value = $goods_attr_formate[$goods_attr_id]['attr_value'];
	                $new_attr_id[] = $goods_attr_store_formate[$goods['goods_id'].'_'.$attr_id.'_'.$attr_value]['goods_attr_id'];
	            }
	            $goodslib_products[$key]['goods_attr'] = implode('|', $new_attr_id);
	            $goodslib_products[$key]['product_sn'] = '';
	            $goodslib_products[$key]['product_number'] = ecjia::config('default_storage');

                if($product['product_name']) {
                    $goodslib_products[$key]['product_name'] = $product['product_name'];
                }
                if($product['product_shop_price']) {
                    $goodslib_products[$key]['product_shop_price'] = $product['product_shop_price'];
                }
                if($product['product_bar_code']) {
                    $goodslib_products[$key]['product_bar_code'] = $product['product_bar_code'];
                }
                if($product['product_desc']) {
                    $goodslib_products[$key]['product_desc'] = $product['product_desc'];
                }

                $product_id_new = RC_DB::table('products')->insertGetId($goodslib_products[$key]);
	            RC_DB::table('products')->where('product_id', $product_id_new)->update(array('product_sn' => $goods['goods_sn'] . '_p' . $product_id_new));

                if(!empty($product['product_img'])) {
                    //复制图片-重命名
                    $img_data = array(
                        'product_img' => $product['product_img'],
                        'product_thumb' => $product['product_thumb'],
                        'product_original_img' => $product['product_original_img']
                    );
                    copy_goodslib_product_images($product['product_id'], $product_id_new, $img_data);
                }
                if(!empty($product['product_desc'])) {
                    //复制图片-重命名
                    copy_goodslib_product_desc($product['product_id'], $product_id_new, $product['product_desc']);
                }
                $product_gallery = RC_DB::table('goodslib_gallery')->where('goods_id', $goodslib_id)->where('product_id', $product['product_id'])->get();
                if (!empty($product_gallery)) {
                    //复制图片-重命名
                    copy_goodslib_product_gallery($product['product_id'], $product_id_new, $goods['goods_id'], $product_gallery);
                }
	        }
	        
	    }
	    
	    return true;
	}

}

// end