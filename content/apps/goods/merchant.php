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

use Ecjia\App\Goods\Models\GoodsAttrModel;
use Ecjia\App\Goods\Category\CategoryLevel;
use Ecjia\App\Goods\Category\MerchantCategoryLevel;
/**
 *  ECJIA 商品管理程序
 */
class merchant extends ecjia_merchant {
	private $db_link_goods;
	private $db_group_goods;
	
	private $db_goods;
	private $db_goods_article;
	private $db_goods_attr;
	private $db_goods_attr_view;
	private $db_goods_cat;
	private $db_goods_gallery;
	
	private $db_attribute;
	private $db_products;
	private $db_brand;
	private $db_category;
	
	private $db_term_meta;
	//private $db_term_relationship;
	
	private $tags;

	public function __construct() {
		parent::__construct();

        Ecjia\App\Goods\Helper::assign_adminlog_content();
		
		$this->db_link_goods 		= RC_Model::model('goods/link_goods_model');
		$this->db_group_goods 		= RC_Model::model('goods/group_goods_model');
		
		$this->db_goods 			= RC_Model::model('goods/goods_model');
		$this->db_goods_article 	= RC_Model::model('goods/goods_article_model');
		$this->db_goods_attr 		= RC_Model::model('goods/goods_attr_model');
		$this->db_goods_attr_view 	= RC_Model::model('goods/goods_attr_viewmodel');
		$this->db_goods_cat 		= RC_Model::model('goods/goods_cat_model');
		$this->db_goods_gallery 	= RC_Model::model('goods/goods_gallery_model');
		
		$this->db_attribute 		= RC_Model::model('goods/attribute_model');
		$this->db_products 			= RC_Model::model('goods/products_model');
		$this->db_brand 			= RC_Model::model('goods/brand_model');
		$this->db_category 			= RC_Model::model('goods/category_model');
		
		$this->db_term_meta 		= RC_Loader::load_sys_model('term_meta_model');
		//$this->db_term_relationship = RC_Model::model('goods/term_relationship_model');
		
		RC_Style::enqueue_style('jquery-placeholder');
		RC_Script::enqueue_script('jquery-imagesloaded');
		RC_Script::enqueue_script('jquery-dropper', RC_Uri::admin_url('/statics/lib/dropper-upload/jquery.fs.dropper.js'), array(), false, 1);
		RC_Style::enqueue_style('goods-colorpicker-style', RC_Uri::admin_url() . '/statics/lib/colorpicker/css/colorpicker.css');
		RC_Script::enqueue_script('goods-colorpicker-script', RC_Uri::admin_url('/statics/lib/colorpicker/bootstrap-colorpicker.js'), array(), false, 1);
		
		RC_Script::enqueue_script('jq_quicksearch', RC_Uri::admin_url() . '/statics/lib/multi-select/js/jquery.quicksearch.js', array('jquery'), false, 1);
		RC_Script::enqueue_script('ecjia-region', RC_Uri::admin_url('statics/ecjia.js/ecjia.region.js'), array('jquery'), false, 1);
		
		
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
        RC_Style::enqueue_style('mh-product', RC_App::apps_url('statics/styles/mh-product.css', __FILE__), array());

		RC_Script::enqueue_script('clipboard.min', RC_App::apps_url('statics/js/clipboard.min.js', __FILE__), array(), false, 1);
		
		RC_Loader::load_app_class('goods', 'goods', false);
		RC_Loader::load_app_class('goods_image_data', 'goods', false);
		RC_Loader::load_app_class('goods_imageutils', 'goods', false);
        RC_Loader::load_app_class('product_image_data', 'goods', false);

		RC_Loader::load_app_func('merchant_goods');
		RC_Loader::load_app_func('global');
		RC_Loader::load_app_func('admin_category');
		
		RC_Loader::load_app_func('admin_user', 'user');
		
		
		RC_Script::enqueue_script('merchant_goods_list', RC_App::apps_url('statics/js/merchant_goods_list.js', __FILE__), array(), false, 1);
		RC_Script::enqueue_script('merchant_product', RC_App::apps_url('statics/js/merchant_product.js', __FILE__), array(), false, 1);
		
		$goods_list_jslang = array(
				'user_rank_list'	=> get_rank_list(),
				'marketPriceRate'	=> ecjia::config('market_price_rate'),
				'integralPercent'	=> ecjia::config('integral_percent'),
		);
		$js_lang_arr = array_merge($goods_list_jslang, config('app-goods::jslang.goods_list_page'), config('app-goods::jslang.spec_product_page'));
		RC_Script::localize_script('merchant_goods_list', 'js_lang', $js_lang_arr);

		$goods_id = isset($_REQUEST['goods_id']) ? $_REQUEST['goods_id'] : 0;
		$extension_code = isset($_GET['extension_code']) ? '&extension_code='.$_GET['extension_code'] : '';
		$action_type = trim($_GET['action_type']);
		
		$this->tags = get_merchant_goods_info_nav($goods_id, $action_type, $extension_code);
		$this->tags[ROUTE_A]['active'] = 1;

		ecjia_merchant_screen::get_current_screen()->set_parentage('goods', 'goods/merchant.php');
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品管理', 'goods'), RC_Uri::url('goods/merchant/init')));
	}

	/**
	* 商品列表
	*/
	public function init() {
	    $this->admin_priv('goods_manage');
	    
	    $this->assign('list_url', RC_Uri::url('goods/merchant/init'));
	    
	    $this->assign('ur_here', __('在售商品列表（SPU）', 'goods'));
	    $this->assign('action_link', array('href' => RC_Uri::url('goods/merchant/add'), 'text' => __('添加新商品', 'goods')));
	    
	    ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('在售商品列表（SPU）', 'goods')));
	    
	    $store_id 	= intval($_SESSION['store_id']);
	    $list_type  = intval($this->request->input('type', 0));
	    $page       = intval($this->request->input('page', 1));
	     
	    $cat_id     = intval($this->request->input('cat_id', 0));
	    $brand_id   = intval($this->request->input('brand_id', 0));
	    $intro_type = trim($this->request->input('intro_type'));
	    
	    $merchant_keywords = trim($this->request->input('merchant_keywords'));
	    $keywords          = trim($this->request->input('keywords'));
	     
	    $sort_by    = trim($this->request->input('sort_by', 'goods_id'));
	    $sort_order = trim($this->request->input('sort_order', 'DESC'));
	    
	    $use_storage = ecjia::config('use_storage');
	    $this->assign('use_storage', empty($use_storage) ? 0 : 1);
	    $merchant_cat_list_option = \Ecjia\App\Goods\Category\MerchantCategoryFormSelectOption::buildTopCategorySelectOption($store_id)->render($cat_id);
	    $this->assign('merchant_cat_list_option', $merchant_cat_list_option);
	    
	    $this->assign('intro_list', config('app-goods::goods_suggest_types'));
	    /* 类型筛选 */
	    $where = [];
	    switch ($intro_type) {
	    	case 'is_best' :
	    		$where['store_best'] = 1;
	    		break;
	    	case 'is_hot' :
	    		$where['store_hot'] = 1;
	    		break;
	    	case 'is_new' :
	    		$where['store_new'] = 1;
	    		break;
	    }

	    $input = [
		    'brand'             	=> $brand_id,
		    'merchant_keywords' 	=> $merchant_keywords,
		    'keywords'          	=> $keywords,
		    'store_id'          	=> $store_id,
		    'sort_by'           	=> [$sort_by => $sort_order],
		    'page'              	=> $page,
	    ];
	    $input = collect($input)->merge($where)->filter()->all();
	    if($cat_id) {
	    	$children_cat = Ecjia\App\Goods\GoodsSearch\MerchantGoodsCategory::getAdminChildrenCategoryId($cat_id, $store_id);
	    	$input['store_id_and_merchant_cat_id'] = array($children_cat, $store_id);
	    }
	    $input['is_real'] 	= 1;
	    $input['is_on_sale'] = 1;
	    $input['check_review_status'] = array(3, 5);
	    $input['is_delete'] = 0;
	    $input['no_need_cashier_goods'] = true;
	    
	    
	    $goods_count = (new \Ecjia\App\Goods\Collections\GoodsCountable($input))->getData(function($query) {
	    	/**
	    	 * @var \Royalcms\Component\Database\Query\Builder $query
	    	 */
	    	$query->select(
	    			RC_DB::raw('SUM(IF(`is_on_sale` = 1, 1, 0)) as `count_on_sale`')
	    	);
	    });

    	$goods_activity_count_func = function ($input) {
    		$input['has_activity'] 	= 1;
    		$goods_activity_count = (new \Ecjia\App\Goods\Collections\GoodsCountable($input))->getData(function($query) {
    			/**
    			 * @var \Royalcms\Component\Database\Query\Builder $query
    			 */
    			$query->select(
    					RC_DB::raw('count(`goods_id`) as `count_activity`')
    			);
    		});
    	
    		return $goods_activity_count;
    	};
	   
    	$goods_activity_count = $goods_activity_count_func($input);
    	
    	if ($list_type === 1) {
    		$input['has_activity'] 	= 1;
    		$goods_list = (new \Ecjia\App\Goods\GoodsSearch\MerchantGoodsCollection($input))->getData();
    	} else {
    		$goods_list = (new \Ecjia\App\Goods\GoodsSearch\MerchantGoodsCollection($input))->getData();
    	}
	    $count_link_func = function ($input, $where, $goods_count, $goods_activity_count) {
	    	$input = collect($input)->except(array_keys($where))->all();
	    	unset($input['is_delete']);
	    	unset($input['is_real']);
	    	unset($input['is_on_sale']);
	    	unset($input['check_review_status']);
	    	unset($input['has_activity']);
	    	unset($input['no_need_cashier_goods']);
	    
	    	$input['sort_order'] = array_values($input['sort_by'])[0];
	    	$input['sort_by']    = array_keys($input['sort_by'])[0];
	    	$links = [
		    	'count_on_sale' => [
			    	'label' => __('出售中', 'goods'),
			    	'link' => RC_Uri::url('goods/merchant/init', array_merge($input, ['type' => 0])),
			    	'type' => 0,
			    	'count'=> empty($goods_count['count_on_sale']) ? 0 : $goods_count['count_on_sale'],
	    		],
	    		'count_activity' => [
			    	'label' => __('参与活动', 'goods'),
			    	'link' => RC_Uri::url('goods/merchant/init', array_merge($input, ['type' => 1])),
			    	'type' => 1,
			    	'count'=> $goods_activity_count['count_activity']
		    	]
	    	];
	    	return $links;
	    };
	    
	    $goods_count = $count_link_func($input, $where, $goods_count, $goods_activity_count);
	    
	    $this->assign('list_type', $list_type);
	    $this->assign('goods_list', $goods_list);
	    $this->assign('goods_count', $goods_count);
	    
	    $this->assign('filter', $goods_list['filter']);
		
		//货品列表入口
		$specifications = get_goods_type_specifications();
		$this->assign('specifications', $specifications);
		
		$this->assign('form_action', RC_Uri::url('goods/merchant/batch'));
		
		$this->assign('action', 'sale');
		$this->assign('preview_type', 'selling');//预览跳转type
		
		return $this->display('goods_list.dwt');
	}
	
	/**
	 * 售罄商品
	 */
	public function finish() {

		$this->admin_priv('goods_manage');
		
		$this->assign('list_url', RC_Uri::url('goods/merchant/finish'));
		
		$this->assign('ur_here', __('售罄商品列表（SPU）', 'goods'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('售罄商品列表（SPU）', 'goods')));
		
		$store_id 	= intval($_SESSION['store_id']);
		$list_type  = intval($this->request->input('type', 0));
		$page       = intval($this->request->input('page', 1));
			
		$cat_id     = intval($this->request->input('cat_id', 0));
		$brand_id   = intval($this->request->input('brand_id', 0));
		$intro_type = trim($this->request->input('intro_type'));
		
		$merchant_keywords = trim($this->request->input('merchant_keywords'));
		$keywords          = trim($this->request->input('keywords'));
			
		$sort_by    = trim($this->request->input('sort_by', 'goods_id'));
		$sort_order = trim($this->request->input('sort_order', 'DESC'));
		
		$use_storage = ecjia::config('use_storage');
		$this->assign('use_storage', empty($use_storage) ? 0 : 1);
		
		$merchant_cat_list_option = \Ecjia\App\Goods\Category\MerchantCategoryFormSelectOption::buildTopCategorySelectOption($store_id)->render($cat_id);
	    $this->assign('merchant_cat_list_option', $merchant_cat_list_option);
		
		$this->assign('intro_list', config('app-goods::goods_suggest_types'));
		
		/* 类型筛选 */
		$where = [];
		switch ($intro_type) {
			case 'is_best' :
				$where['store_best'] = 1;
				break;
			case 'is_hot' :
				$where['store_hot'] = 1;
				break;
			case 'is_new' :
				$where['store_new'] = 1;
				break;
		}
		
		$input = [
			'cat_id'              => $cat_id,
			'brand'               => $brand_id,
			'intro_type'          => $intro_type,
			'merchant_keywords'   => $merchant_keywords,
			'keywords'            => $keywords,
			'store_id'            => $store_id,
			'sort_by'             => [$sort_by => $sort_order],
			'page'                => $page,
		];
		$input = collect($input)->merge($where)->filter()->all();
		
		$input['goods_number'] = 0;
		$input['is_on_sale']   = 0;
		$input['check_review_status'] = array(3, 5);
		$input['is_delete'] = 0;
		$input['is_real'] 	= 1;
		$input['no_need_cashier_goods'] = true;
		
		$goods_list = (new \Ecjia\App\Goods\GoodsSearch\MerchantGoodsCollection($input))->getData();
		$this->assign('goods_list', $goods_list);
		
		$this->assign('filter', $goods_list['filter']);
		
		
		$this->assign('form_action', RC_Uri::url('goods/merchant/batch'));
		
		$this->assign('form_action_insert', RC_Uri::url('goods/merchant/insert_goodslib'));
		
		$this->assign('action', 'finish');
		$this->assign('preview_type', 'finished');//预览跳转type
		
		return $this->display('goods_list.dwt');
	}
	
	/**
	 * 下架列表
	 */
	public function obtained() {
		$this->admin_priv('goods_manage');
	
		$this->assign('list_url', RC_Uri::url('goods/merchant/obtained'));
	
		$this->assign('ur_here', __('下架商品列表（SPU）', 'goods'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('下架商品列表（SPU）', 'goods')));
	
		$store_id 	= intval($_SESSION['store_id']);
		$list_type  = intval($this->request->input('type', 0));
		$page       = intval($this->request->input('page', 1));
		 
		$cat_id     = intval($this->request->input('cat_id', 0));
		$brand_id   = intval($this->request->input('brand_id', 0));
		$intro_type = trim($this->request->input('intro_type'));
	
		$merchant_keywords = trim($this->request->input('merchant_keywords'));
		$keywords          = trim($this->request->input('keywords'));
		 
		$sort_by    = trim($this->request->input('sort_by', 'goods_id'));
		$sort_order = trim($this->request->input('sort_order', 'DESC'));
	
		$use_storage = ecjia::config('use_storage');
		$this->assign('use_storage', empty($use_storage) ? 0 : 1);
	
		$merchant_cat_list_option = \Ecjia\App\Goods\Category\MerchantCategoryFormSelectOption::buildTopCategorySelectOption($store_id)->render($cat_id);
	    $this->assign('merchant_cat_list_option', $merchant_cat_list_option);
	
		$this->assign('intro_list', config('app-goods::goods_suggest_types'));
	
		/* 类型筛选 */
		$where = [];
		switch ($intro_type) {
			case 'is_best' :
				$where['store_best'] = 1;
				break;
			case 'is_hot' :
				$where['store_hot'] = 1;
				break;
			case 'is_new' :
				$where['store_new'] = 1;
				break;
		}
	
		$input = [
			'cat_id'            	=> $cat_id,
			'brand'             	=> $brand_id,
			'intro_type'        	=> $intro_type,
			'merchant_keywords' 	=> $merchant_keywords,
			'keywords'          	=> $keywords,
			'store_id'          	=> $store_id,
			'sort_by'           	=> [$sort_by => $sort_order],
			'page'              	=> $page,
		];
		$input = collect($input)->merge($where)->filter()->all();
	
		$input['goods_number']  = array('>', 0);
		$input['is_on_sale'] 	= 0;
		$input['check_review_status'] = array(3, 5);
		$input['is_delete'] = 0;
		$input['is_real'] = 1;
		$input['no_need_cashier_goods'] = true;
	
		$goods_list = (new \Ecjia\App\Goods\GoodsSearch\MerchantGoodsCollection($input))->getData();
		$this->assign('goods_list', $goods_list);
		$this->assign('filter', $goods_list['filter']);
		
		$this->assign('form_action', RC_Uri::url('goods/merchant/batch'));
		
		$this->assign('form_action_insert', RC_Uri::url('goods/merchant/insert_goodslib'));
		
		$this->assign('action', 'obtained');
		$this->assign('preview_type', 'obtained');//预览跳转type
		
		return $this->display('goods_list.dwt');
	}
	
	/**
	 * 审核列表
	 */
	public function check() {
		$this->admin_priv('goods_manage');
	
		$this->assign('list_url', RC_Uri::url('goods/merchant/check'));
	
		$this->assign('ur_here', __('审核商品列表（SPU）', 'goods'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('审核商品列表（SPU）', 'goods')));
	
		$store_id 	= intval($_SESSION['store_id']);
		$list_type  = intval($this->request->input('type', 0));
		$page       = intval($this->request->input('page', 1));
		 
		$cat_id     = intval($this->request->input('cat_id', 0));
		$brand_id   = intval($this->request->input('brand_id', 0));
		$intro_type = trim($this->request->input('intro_type'));
	
		$merchant_keywords = trim($this->request->input('merchant_keywords'));
		$keywords          = trim($this->request->input('keywords'));
		 
		$sort_by    = trim($this->request->input('sort_by', 'goods_id'));
		$sort_order = trim($this->request->input('sort_order', 'DESC'));
	
		$use_storage = ecjia::config('use_storage');
		$this->assign('use_storage', empty($use_storage) ? 0 : 1);
	
		$merchant_cat_list_option = \Ecjia\App\Goods\Category\MerchantCategoryFormSelectOption::buildTopCategorySelectOption($store_id)->render($cat_id);
	    $this->assign('merchant_cat_list_option', $merchant_cat_list_option);
	
		$this->assign('intro_list', config('app-goods::goods_suggest_types'));
	
		/* 类型筛选 */
		$where = [];
		switch ($intro_type) {
			case 'is_best' :
				$where['store_best'] = 1;
				break;
			case 'is_hot' :
				$where['store_hot'] = 1;
				break;
			case 'is_new' :
				$where['store_new'] = 1;
				break;
		}
	
		$input = [
			'cat_id'            => $cat_id,
			'brand'             => $brand_id,
			'intro_type'        => $intro_type,
			'merchant_keywords' => $merchant_keywords,
			'keywords'          => $keywords,
			'store_id'          => $store_id,
			'sort_by'           => [$sort_by => $sort_order],
			'page'              => $page,
		];
	
		$input = collect($input)->merge($where)->filter()->all();
	
		$input['is_delete'] = 0;
		$input['is_real']   = 1;
		$input['no_need_cashier_goods'] = true;
	
		$goods_count = (new \Ecjia\App\Goods\Collections\GoodsCountable($input))->getData(function($query) {
			/**
			 * @var \Royalcms\Component\Database\Query\Builder $query
			 */
			$query->select(
					RC_DB::raw('SUM(IF(`review_status` = 1, 1, 0)) as `check_pending`'),
					RC_DB::raw('SUM(IF(`review_status` = 2, 1, 0)) as `check_no_pass`')
			);
		});
	
		if ($list_type === 1) {
			$input['check_review_status'] = 2; //未通过
			$this->assign('preview_type', 'refused_check');//预览跳转type
		} else {
			$input['check_review_status'] = 1;//待审核
			$this->assign('preview_type', 'await_check');//预览跳转type
		}
		$goods_list = (new \Ecjia\App\Goods\GoodsSearch\MerchantGoodsCollection($input))->getData();

		$count_link_func = function ($input, $where, $goods_count) {
			$input = collect($input)->except(array_keys($where))->all();
			unset($input['check_review_status']);
			unset($input['is_delete']);
			unset($input['is_real']);

			$input['sort_order'] = array_values($input['sort_by'])[0];
			$input['sort_by'] = array_keys($input['sort_by'])[0];
			$links = [
				'check_pending' => [
					'label' => __('待审核', 'goods'),
					'link' => RC_Uri::url('goods/merchant/check', array_merge($input, ['type' => 0])),
					'type' => 0,
					'count'=> $goods_count['check_pending']
				],
					'check_no_pass' => [
					'label' => __('审核未通过', 'goods'),
					'link' => RC_Uri::url('goods/merchant/check', array_merge($input, ['type' => 1])),
					'type' => 1,
					'count'=> $goods_count['check_no_pass']
				]
			];

			return $links;
		};

		$goods_count = $count_link_func($input, $where, $goods_count);

		$this->assign('list_type', $list_type);
		$this->assign('goods_list', $goods_list);
		$this->assign('goods_count', $goods_count);

		$this->assign('filter', $goods_list['filter']);

		$this->assign('form_action', RC_Uri::url('goods/merchant/batch'));
		$this->assign('form_action_insert', RC_Uri::url('goods/merchant/insert_goodslib'));

		$this->assign('action', 'check');
		
		return $this->display('goods_list.dwt');
	}

	/**
	 * 预览
	 */
	public function preview() {
		$this->admin_priv('goods_manage');
		
		
		$has_attr_group_pralist = Ecjia\App\Goods\Models\GoodsTypeModel::where('cat_type', 'parameter')->where('cat_id', 155)->whereNotNull('attr_group')->get();
		if (!empty($has_attr_group_pralist)) {
			foreach ($has_attr_group_pralist as $row) {
				$arr = explode(',', str_replace("\n", ",", $row['attr_group']));
				if (!empty($row->attribute_collection)) {
					$row->attribute_collection->map(function ($item) use ($arr) {
						$attr_group_str = $arr[$item->attr_group];
						if (!empty($attr_group_str)) {
							$item->update(array('attr_group' => $attr_group_str));
						}
					});
				}
			}
		}
		
		$goods_id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
		$preview_type = $_GET['preview_type'];
		
		if (empty($goods_id)) {
		    return $this->showmessage(__('未检测到此商品', 'goods'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('返回上一页', 'goods'), 'href' => 'javascript:history.go(-1)'))));
		}
		
		//返回商品列表
		if ($preview_type == 'selling') {
			$action_link = array('text' => __('商品列表', 'goods'), 'href' => RC_Uri::url('goods/merchant/init'));
		} elseif ($preview_type == 'finished') {
			$action_link = array('text' => __('商品列表', 'goods'), 'href' => RC_Uri::url('goods/merchant/finish'));
		} elseif ($preview_type == 'obtained') {
			$action_link = array('text' => __('商品列表', 'goods'), 'href' => RC_Uri::url('goods/merchant/obtained'));
		} elseif ($preview_type == 'refused_check' || $preview_type == 'await_check') {
			$action_link = array('text' => __('商品列表', 'goods'), 'href' => RC_Uri::url('goods/merchant/check'));
		} else {
			$action_link = array('text' => __('商品列表', 'goods'), 'href' => RC_Uri::url('goods/merchant/init'));
		}
		
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品列表', 'goods'), $action_link['href']));
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品预览', 'goods')));
		$this->assign('ur_here', __('商品预览', 'goods'));
		
		
		$this->assign('action_link', $action_link);

		$GoodsBasicInfo = new Ecjia\App\Goods\Goods\GoodsBasicInfo($goods_id, $_SESSION['store_id']);
		
		$goods = $GoodsBasicInfo->goodsInfo();
		
		if (empty($goods)) {
			return $this->showmessage(__('未检测到此商品', 'goods'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text'=> __('返回商品列表', 'goods'),'href'=>RC_Uri::url('goods/merchant/init')))));
		}
		
		if (!empty($goods['goods_desc'])) {
			$goods['goods_desc'] = stripslashes($goods['goods_desc']);
		}
		
		//商品是否在促销
		$time = RC_Time::gmtime();
		$goods['is_promote_now'] = 0;
		if (($goods->promote_start_date <= $time && $goods->promote_end_date >= $time) && $goods->is_promote == '1' && $goods->promote_price > 0) {
			$goods['is_promote_now'] = 1;
			$goods['formated_promote_start_date'] = RC_Time::local_date('Y-m-d H:i:s', $goods['promote_start_date']);
			$goods['formated_promote_end_date'] = RC_Time::local_date('Y-m-d H:i:s', $goods['promote_end_date']);
		}
		$goods['format_cost_price'] = ecjia_price_format($goods['cost_price'], false);
		
		if (!empty($goods['add_time'])) {
			$goods['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $goods['add_time']);
		}
		//商品重量存在，重量单位是0的情况
		if ($goods['goods_weight'] > 0) {
			if (empty($goods['weight_unit'])) {
				if ($goods['goods_weight'] >= 1 ) {
					$goods['goods_weight_string'] = $goods['goods_weight'].'千克';
				} else {
					$goods['goods_weight_string'] = ($goods['goods_weight']*1000).'克';
				}
			} else {
				if ($goods['weight_unit'] == 2 ) {
					$goods['goods_weight_string'] = $goods['goods_weight'].'千克';
				} else {
					if ($goods['goods_weight'] < 1){
						$str = '克';
						$goods_weight = $goods['goods_weight']*1000;
					} else {
						$str = '克';
						$goods_weight = $goods['goods_weight'];
					}
					$goods['goods_weight_string'] =$goods_weight.$str;
				}
			}
		}
		
		$images_url = RC_App::apps_url('statics/images', __FILE__);
		$this->assign('images_url', $images_url);
		
		//商品相册
		$goods_photo_list = $GoodsBasicInfo->getGoodsGallery();
		$this->assign('goods_photo_list', $goods_photo_list);
		
		$this->assign('preview_type', $preview_type);
		
		//商品属性（既商品货品）
		$product_list = $GoodsBasicInfo->goodsProducts();
		$this->assign('product_list', $product_list);
		
		//商品参数
		$attr_group = $GoodsBasicInfo->attrGroup();
		if (count($attr_group) > 0) {
			$group_parameter_list = $GoodsBasicInfo->getGoodsGroupParameter();
			$this->assign('group_parameter_list', $group_parameter_list);
		} else {
			$common_parameter_list = $GoodsBasicInfo->getGoodsCommonParameter();
			$this->assign('common_parameter_list', $common_parameter_list);
		}
		$this->assign('no_picture', RC_Uri::admin_url('statics/images/nopic.png'));

		$this->assign('goods', $goods);
		
		return $this->display('preview.dwt');
	}
	
	/**
	 * 货品预览
	 */
	public function product_preview()
	{
		$product_id = !empty($_GET['product_id']) ? intval($_GET['product_id']) : 0;
		$goods_id   = !empty($_GET['goods_id']) ? intval($_GET['goods_id']) : 0;
		$preview_type = $_GET['preview_type'];
		
		if (empty($product_id)) {
			return $this->showmessage(__('未检测到此货品', 'goods'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('返回上一页', 'goods'), 'href' => 'javascript:history.go(-1)'))));
		}
		
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('货品预览', 'goods')));
		
		$this->assign('ur_here', __('货品预览', 'goods'));
		$this->assign('action_link', array('text' => __('商品预览', 'goods'), 'href' => RC_Uri::url('goods/merchant/preview', array('id' => $goods_id, 'preview_type' => $preview_type))));
		
		$ProductBasicInfo = new Ecjia\App\Goods\Goods\ProductBasicInfo($product_id);
		
		$product = $ProductBasicInfo->productInfo();
		
		if (empty($product)) {
			return $this->showmessage(__('未检测到此货品', 'goods'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text'=> __('返回商品列表', 'goods'),'href'=>RC_Uri::url('goods/merchant/preview', array('id' => $goods_id, 'preview_type' => $preview_type))))));
		}
		$goods_id = $product->goods_id;
		$GoodsBasicInfo = new Ecjia\App\Goods\Goods\GoodsBasicInfo($goods_id, $_SESSION['store_id']);
		$goods = $GoodsBasicInfo->goodsInfo();
		
		//名称处理
		$product['product_attr_value'] = '';
		if (empty($product->product_name)) {
			$product['product_name'] = $goods->goods_name;
			if ($product->goods_attr) {
				$goods_attr = explode('|', $product->goods_attr);
				if ($goods->goods_attr_collection) {
					$product_attr_value = $goods->goods_attr_collection->whereIn('goods_attr_id', $goods_attr)->sortBy('goods_attr_id')->lists('attr_value');
					$product_attr_value = $product_attr_value->implode('/');
					$product['product_attr_value'] = $product_attr_value;
				}
			}
		}
		//货品是否在促销
		$time = RC_Time::gmtime();
		$product['is_promote_now'] = 0;
		if (($goods->promote_start_date <= $time && $goods->promote_end_date >= $time) && $product->is_promote == '1' && $product->promote_price > 0) {
			$product['is_promote_now'] = 1;
			$product['formated_promote_start_date'] = RC_Time::local_date('Y-m-d H:i:s', $goods['promote_start_date']);
			$product['formated_promote_end_date'] = RC_Time::local_date('Y-m-d H:i:s', $goods['promote_end_date']);
		}
		
		//本店价格处理
		if ($product->product_shop_price <= 0){
			$product['product_shop_price'] = ecjia_price_format($goods->shop_price, false);
		} else {
			$product['product_shop_price'] = ecjia_price_format($product->product_shop_price, false);
		}
		//添加时间
		if (!empty($goods->add_time)) {
			$goods['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $goods->add_time);
		}
		
		//图文详情
		if (!empty($product['product_desc'])) {
			$product['product_desc'] = stripslashes($product->product_desc);
		} else{
			if (!empty($goods['goods_desc'])){
				$product['product_desc'] = stripslashes($goods->goods_desc);
			}
		}
		//货品相册
		$product_photo_list = $ProductBasicInfo->getProductGallery();
		if (empty($product_photo_list)) {
			$product_photo_list = $GoodsBasicInfo->getGoodsGallery();
		}
		$this->assign('product_photo_list', $product_photo_list);
		
		//商品参数
		$attr_group = $GoodsBasicInfo->attrGroup();
		if (count($attr_group) > 0) {
			$group_parameter_list = $GoodsBasicInfo->getGoodsGroupParameter();
			$this->assign('group_parameter_list', $group_parameter_list);
		} else {
			$common_parameter_list = $GoodsBasicInfo->getGoodsCommonParameter();
			$this->assign('common_parameter_list', $common_parameter_list);
		}
		
		$images_url = RC_App::apps_url('statics/images', __FILE__);
		$this->assign('images_url', $images_url);
		$this->assign('no_picture', RC_Uri::admin_url('statics/images/nopic.png'));
		$this->assign('product', $product);
		$this->assign('goods', $goods);
		
		return $this->display('product_preview.dwt');
	}
	
	/**
	 * 手机端预览
	 */
	public function h5_preview()
	{
		$goods_id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
		RC_Hook::do_action('goods_merchant_h5_priview_handler', $goods_id);
	}
	
	/**
	 * PC预览
	 */
	public function pc_preview()
	{
		$goods_id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
		RC_Hook::do_action('goods_merchant_pc_priview_handler', $goods_id);
	}
	
	/**
	* 商品回收站
	*/
	public function trash()	{
        $this->admin_priv('goods_update');

	    ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品回收站', 'goods')));
	    
	    $cat_id = empty($_GET['cat_id']) ? 0 : intval($_GET['cat_id']);
	    
	    $this->assign('cat_list', merchant_cat_list(0, $cat_id, false));
		$this->assign('ur_here', __('商品回收站', 'goods'));
		
		$action_link = array('href' => RC_Uri::url('goods/merchant/init'), 'text' => __('商品列表', 'goods'));
        $this->assign('action_link', $action_link);

		$goods_list = goods::merchant_goods_list(1, -1);
		$this->assign('goods_list', $goods_list);
		$this->assign('form_action', RC_Uri::url('goods/merchant/batch'));
		$this->assign('filter', $goods_list['filter']);
		$this->assign('count', $goods_list['count']);

		return $this->display('goods_trash.dwt');
	}
	
	/**
	 * 添加新商品
	 */
	public function add() {
		$this->admin_priv('goods_update');
		
		$href = strpos($_SERVER['HTTP_REFERER'], 'm=goods&c=admin&a=init') ? $_SERVER['HTTP_REFERER'] : RC_Uri::url('goods/merchant/init');
			
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品列表', 'goods'), RC_Uri::url('goods/merchant/init')));
		$this->assign('action_link', array('href' => $href, 'text' => __('商品列表', 'goods')));

		$cat_id 	= !empty($_GET['cat_id']) 		? intval($_GET['cat_id']) 		: 0;
		$brand_id  	= !empty($_POST['brand_id']) 	? intval($_POST['brand_id']) 	: 0;
		
		//所属平台分类
		if (!empty($cat_id)) {
			$cat_str = get_cat_str($cat_id);
			$cat_html = get_cat_html($cat_str);
			$this->assign('cat_html', $cat_html);
		}
		if (!empty($cat_id)) {
			$merchant_cat = merchant_cat_list(0, 0, true, 2, false);		//店铺分类
			$ur_here = __('基本信息', 'goods');
			$this->assign('step', 2);
			$this->assign('merchant_cat', $merchant_cat);
		} else {
			$cat_list = cat_list(0, 0, false, 1, false);	//平台分类
			$ur_here = __('选择平台商品分类', 'goods');
			$this->assign('step', 1);
			$this->assign('cat_list', $cat_list);
		}
		
		$this->assign('ur_here', $ur_here);
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here($ur_here));
		
		$goods = array(
			'goods_id'				=> 0,
			'goods_desc'			=> '',
			'cat_id'				=> $cat_id,
			'brand_id'				=> $brand_id,
			'is_on_sale'			=> '1',
			'is_alone_sale'			=> '1',
			'is_shipping'			=> '0',
			'other_cat'				=> array(), // 扩展分类
			'goods_type'			=> 0, 		// 商品类型
			'shop_price'			=> 0,
			'promote_price'			=> 0,
			'market_price'			=> 0,
			'cost_price'			=> 0,
			'integral'				=> 0,
			'goods_number'			=> ecjia::config('default_storage'),
			'warn_number'			=> 1,
			'promote_start_date'	=> RC_Time::local_date('Y-m-d'),
			'promote_end_date'		=> RC_Time::local_date('Y-m-d', RC_Time::local_strtotime('+1 month')),
			'goods_weight'			=> 0,
			'give_integral'			=> -1,
			'rank_integral'			=> -1
		);
	
		/* 商品名称样式 */
		$goods_name_style = isset($goods['goods_name_style']) ? $goods['goods_name_style'] : '';
		/* 模板赋值 */
		$this->assign('tags', array('edit' => array('name' => __('通用信息', 'goods'), 'active' => 1, 'pjax' => 1, 'href' => RC_Uri::url('goods/merchant/add'))));
	
		$this->assign('goods', $goods);
		$this->assign('goods_name_color', $goods_name_style);
	
		$this->assign('brand_list', get_brand_list());
		//$this->assign('unit_list', goods::unit_list());
		$this->assign('unit_list', Ecjia\App\Cashier\BulkGoods::unit_list());
		$this->assign('user_rank_list', get_rank_list());
	
		$this->assign('cfg', ecjia::config());
		$this->assign('goods_attr_html', build_merchant_attr_html($goods['goods_type'], $goods['goods_id']));
	
		$volume_price_list = '';
		if (isset($_GET['goods_id'])) {
			$volume_price_list = get_volume_price_list($_GET['goods_id']);
		}
		if (empty($volume_price_list)) {
			$volume_price_list = array('0' => array('number' => '', 'price' => ''));
		}
		$this->assign('volume_price_list', $volume_price_list);
		$this->assign('form_action', RC_Uri::url('goods/merchant/insert', array('cat_id' => $cat_id)));
	
		if (!empty($cat_id)) {
			return $this->display('goods_info.dwt');
		} else {
			return $this->display('goods_cat_select.dwt');
		}
	}
	
	/**
	 * 插入商品
	 */
	public function insert() {
		$this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);
		$store_id = intval($_SESSION['store_id']);
		$cat_id = empty($_GET['cat_id']) ? '' : intval($_GET['cat_id']);
		/* 检查货号是否重复 */
		if ($_POST['goods_sn']) {
			$count = $this->db_goods->is_only(array('goods_sn' => $_POST['goods_sn'], 'is_delete' => 0, 'store_id' => $_SESSION['store_id'], 'goods_id' => array('neq' => $_POST['goods_id'])));
			if ($count > 0) {
				return $this->showmessage(__('您输入的货号已存在，请换一个', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		$code = '';
		
//		/* 处理商品图片 */
//		$goods_img = ''; 	// 初始化商品图片
//		$goods_thumb = ''; 	// 初始化商品缩略图
//		$img_original = ''; // 初始化原始图片

		$upload = RC_Upload::uploader('newimage', array('save_path' => 'images', 'auto_sub_dirs' => true));
		$upload->add_saving_callback(function ($file, $filename) {
		    return true;
		});

        /* 是否处理商品图 */
        $proc_goods_img = $this->request->hasFile('goods_img');
        $proc_thumb_img = $this->request->hasFile('thumb_img');
		
//		/* 是否处理商品图 */
//		$proc_goods_img = true;
//		if (isset($_FILES['goods_img']) && !$upload->check_upload_file($_FILES['goods_img'])) {
//            $proc_goods_img = false;
//		}
//		/* 是否处理缩略图 */
//		$proc_thumb_img = isset($_FILES['thumb_img']) ? true : false;
//		if (isset($_FILES['thumb_img']) && !$upload->check_upload_file($_FILES['thumb_img'])) {
//            $proc_thumb_img = false;
//		}

		if ($proc_goods_img) {
            $image_info = $upload->upload('goods_img');
            if (empty($image_info)) {
                return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
		}
		 
		if ($proc_thumb_img) {
            $thumb_info = $upload->upload('thumb_img');
            if (empty($thumb_info)) {
                return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
		}

		/* 如果没有输入商品货号则自动生成一个商品货号 */
		if (empty($_POST['goods_sn'])) {
			$max_id = $this->db_goods->goods_find('', 'MAX(goods_id) + 1|max');
			if (empty($max_id['max'])) {
				$goods_sn_bool = true;
				$goods_sn = '';
			} else {
				$goods_sn = generate_goods_sn($max_id['max']);
			}
		} else {
			$goods_sn = $_POST['goods_sn'];
		}

		/* 处理商品数据 */
		$shop_price 	= !empty($_POST['shop_price']) 		? $_POST['shop_price'] 				: 0;
		$market_price 	= !empty($_POST['market_price']) && is_numeric($_POST['market_price']) ? $_POST['market_price'] : 0;
		$cost_price 	= !empty($_POST['cost_price'])      ? $_POST['cost_price']              : 0;
		$goods_weight 	= !empty($_POST['goods_weight']) && is_numeric($_POST['goods_weight']) ? $_POST['goods_weight'] : 0.000;
		$weight_unit	= !empty($_POST['weight_unit']) && is_numeric($_POST['weight_unit']) ? $_POST['weight_unit'] : 1; 
		
		$is_best 		= !empty($_POST['is_best']) 		? 1 : 0;
		$is_new 		= !empty($_POST['is_new']) 			? 1 : 0;
		$is_hot 		= !empty($_POST['is_hot']) 			? 1 : 0;
		$is_on_sale 	= !empty($_POST['is_on_sale']) 		? 1 : 0;
		$is_alone_sale 	= !empty($_POST['is_alone_sale']) 	? 1 : 0;
		$is_shipping 	= !empty($_POST['is_shipping']) 	? 1 : 0;

		$warn_number 	= !empty($_POST['warn_number'])		? $_POST['warn_number'] 	: 0;
		$goods_type 	= !empty($_POST['goods_type']) 		? $_POST['goods_type'] 		: 0;

		$suppliers_id 	= !empty($_POST['suppliers_id']) 	? intval($_POST['suppliers_id']) 	: '0';

		$goods_name 		= isset($_POST['goods_name']) 		? htmlspecialchars($_POST['goods_name']) 		: '';
		$goods_name_style 	= isset($_POST['goods_name_color']) ? htmlspecialchars($_POST['goods_name_color']) 	: '';

		$brand_id 			= empty($_POST['brand_id']) 		? 0 	: intval($_POST['brand_id']);
		$merchant_cat_id 	= empty($_POST['merchant_cat_id']) 	? '' 	: intval($_POST['merchant_cat_id']);

		if (empty($cat_id)) {
			return $this->showmessage(__('所属平台商品分类不能为空', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if (empty($merchant_cat_id)) {
			return $this->showmessage(__('请选择店铺商品分类', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if (empty($goods_name)) {
			return $this->showmessage(__('请输入商品名称', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		//平台分类父级处理
		$cats= new CategoryLevel();
		$cat_ids = $cats->getParentCategoryIds($cat_id);
		list($level1, $level2, $level3) = $cat_ids;
		
		//商家分类父级处理
		$mer_cat = new MerchantCategoryLevel($store_id);
		$mer_cat_ids = $mer_cat->getParentCategoryIds($merchant_cat_id);
		list($mer_level1, $mer_level2, $mer_level3) = $mer_cat_ids;
		
		$goods_number     = !empty($_POST['goods_number'])   ? intval($_POST['goods_number'])  : ecjia::config('default_storage');
		$goods_barcode    = !empty($_POST['goods_barcode'])  ? trim($_POST['goods_barcode'])   : '';
		
		/* 入库 */
		$data = array(
			'goods_name'            => rc_stripslashes($goods_name),
			'goods_name_style'      => $goods_name_style,
			'goods_sn'              => $goods_sn,
        	'cat_level1_id'         => empty($level1) ? 0 : $level1,
        	'cat_level2_id'         => empty($level2) ? 0 : $level2,
			'cat_id'                => $cat_id,				//平台分类id
			
			'merchat_cat_level1_id'	=> empty($mer_level1) ? 0 : $mer_level1,
		    'merchat_cat_level2_id'	=> empty($mer_level2) ? 0 : $mer_level2,
			'merchant_cat_id'		=> $merchant_cat_id,	//店铺分类id
			
			'brand_id'              => $brand_id,
			'shop_price'            => $shop_price,
			'market_price'          => $market_price,
			'cost_price'            => $cost_price,
			'keywords'              => $_POST['keywords'],
			'goods_brief'           => $_POST['goods_brief'],
			'seller_note'           => $_POST['seller_note'],
			'goods_weight'          => $goods_weight,
			'weight_unit'			=> $weight_unit,
			'goods_barcode'         => $goods_barcode,
			'goods_number'          => $goods_number,
			'warn_number'           => $warn_number,
			'integral'              => $_POST['integral'],
			'store_best'            => $is_best,
			'store_new'             => $is_new,
			'store_hot'             => $is_hot,
			'is_on_sale'            => $is_on_sale,
			'is_alone_sale'         => $is_alone_sale,
			'is_shipping'           => $is_shipping,
			'add_time'              => RC_Time::gmtime(),
			'last_update'           => RC_Time::gmtime(),
			'goods_type'            => $goods_type,
			'suppliers_id'          => $suppliers_id,
		    'review_status'         => get_merchant_review_status(),
			'store_id'				=> $_SESSION['store_id'],
		);
		$goods_id = $this->db_goods->insert($data);
		
		if (isset($goods_sn_bool) && $goods_sn_bool) {
			$goods_sn = generate_goods_sn($goods_id);
			$data = array('goods_sn' => $goods_sn);
			$this->db_goods->goods_update(array('goods_id' => $goods_id), $data);
		}

		/* 记录日志 */
		ecjia_merchant::admin_log($goods_name, 'add', 'goods');
		/* 处理会员价格 */
		if (isset($_POST['user_rank']) && isset($_POST['user_price'])) {
			handle_member_price($goods_id, $_POST['user_rank'], $_POST['user_price']);
			/*释放指定商品不同会员等级价格缓存*/
			$cache_goods_user_rank_prices_key = 'goods_user_rank_prices_'.$goods_id. '-' . $shop_price;
			$cache_user_rank_prices_id = sprintf('%X', crc32($cache_goods_user_rank_prices_key));
			$orm_member_price_db = RC_Model::model('goods/orm_member_price_model');
			$orm_member_price_db->delete_cache_item($cache_user_rank_prices_id);
		}

		/* 处理优惠价格 */
		if (isset($_POST['volume_number']) && isset($_POST['volume_price'])) {
			$temp_num = array_count_values($_POST['volume_number']);
			foreach ($temp_num as $v) {
				if ($v > 1) {
					return $this->showmessage(__('优惠数量重复！', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			}
			handle_volume_price($goods_id, $_POST['volume_number'], $_POST['volume_price']);
		}

		/* 更新上传后的商品图片 */
		if ($proc_goods_img) {
			if (!empty($image_info)) {
//				$goods_image = new goods_image_data($image_info['name'], $image_info['tmpname'], $image_info['ext'], $goods_id);
//				if ($proc_thumb_img) {
//					$goods_image->set_auto_thumb(false);
//				}
//
//				$result = $goods_image->update_goods();

                $goods_image = new \Ecjia\App\Goods\GoodsImage\Goods\GoodsImage($goods_id, 0, $image_info);
                if ($proc_thumb_img) {
                    $goods_image->setAutoGenerateThumb(false);
                } else {
                    $goods_image->setAutoGenerateThumb(true);
                }

                $result = $goods_image->updateToDatabase($goods_id);

				if (is_ecjia_error($result)) {
					return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			}
		}

		/* 更新上传后的缩略图片 */
		if ($proc_thumb_img) {
			if (!empty($thumb_info)) {
//				$thumb_image = new goods_image_data($thumb_info['name'], $thumb_info['tmpname'], $thumb_info['ext'], $goods_id);
//				$result = $thumb_image->update_thumb();

                $thumb_image = new \Ecjia\App\Goods\GoodsImage\Goods\GoodsThumb($goods_id, 0, $thumb_info);
                $result = $thumb_image->updateToDatabase();

				if (is_ecjia_error($result)) {
					return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			}
		}
		

		/* 提示页面 */
		$link = array();
		if ($code == 'virtual_card') {
			$link[1] = array('href' => RC_Uri::url('goods/admin_virtual_card/replenish', array('goods_id' => $goods_id)), 'text' => __('添加虚拟卡卡密', 'goods'));
		}
		$link[2] = add_merchant_link($code);
		$link[3] = list_merchant_link($code);

		for ($i = 0; $i < count($link); $i++) {
			$key_array[] = $i;
		}
		krsort($link);
		$link = array_combine($key_array, $link);
		/* 释放app缓存*/
		$orm_goods_db = RC_Model::model('goods/orm_goods_model');
		$goods_cache_array = $orm_goods_db->get_cache_item('goods_list_cache_key_array');
		if (!empty($goods_cache_array)) {
			foreach ($goods_cache_array as $val) {
				$orm_goods_db->delete_cache_item($val);
			}
			$orm_goods_db->delete_cache_item('goods_list_cache_key_array');
		}
		/*释放商品基本信息缓存*/
		$cache_goods_basic_info_key = 'goods_basic_info_'.$goods_id;
		$cache_basic_info_id = sprintf('%X', crc32($cache_goods_basic_info_key));
		$orm_goods_db->delete_cache_item($cache_basic_info_id);
		
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => RC_Uri::url('goods/merchant/edit_goods_desc', array('goods_id' => $goods_id, 'step' => 'detail')), 'goods_id' => $goods_id));
	}

	/**
	 * 编辑商品
	 */
	public function edit() {
		$this->admin_priv('goods_update');

		$action_type = trim($_GET['action_type']);
		$href_url = Ecjia\App\Goods\MerchantGoodsAttr::goods_back_goods_url($action_type);
		
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品列表', 'goods'), $href_url));
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑商品', 'goods')));
		
		$this->assign('ur_here', __('编辑商品', 'goods'));
		$this->assign('action_link', array('href' => $href_url, 'text' => __('商品列表', 'goods')));

		/* 商品信息 */
		$goods = RC_DB::table('goods')->where('goods_id', $_GET['goods_id'])->where('store_id', $_SESSION['store_id'])->first();

		if (empty($goods)) {
			return $this->showmessage(__('未检测到此商品', 'goods'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('返回商品列表', 'goods'), 'href' => RC_Uri::url('goods/merchant/init')))));
		}
		
		/* 获取商品类型存在规格的类型 */
		$specifications = get_goods_type_specifications();
		if (isset($specifications[$goods['goods_type']])) {
			$goods['specifications_id'] = $specifications[$goods['goods_type']];
		}
		$_attribute = get_goods_specifications_list($goods['goods_id']);
		$goods['_attribute'] = empty($_attribute) ? '' : 1;
		
		if (empty($goods) === true) {
			/* 默认值 */
			$goods = array(
				'goods_id'				=> 0,
				'goods_desc'			=> '',
				'cat_id'				=> 0,
				'merchant_cat_id'		=> 0,
				'is_on_sale'			=> '1',
				'is_alone_sale'			=> '1',
				'is_shipping'			=> '0',
				'other_cat'				=> array(), // 扩展分类
//				'goods_type'			=> 0,	   	// 商品类型
				'shop_price'			=> 0,
				'cost_price'			=> 0,
				'promote_price'			=> 0,
				'market_price'			=> 0,
				'integral'				=> 0,
				'goods_number'			=> 1,
				'warn_number'			=> 1,
				'promote_start_date'	=> RC_Time::local_date('Y-m-d'),
				'promote_end_date'		=> RC_Time::local_date('Y-m-d', RC_Time::gmstr2time('+1 month')),
				'goods_weight'			=> 0,
				'give_integral'			=> -1,
				'rank_integral'			=> -1
			);
		}
		
		/* 根据商品重量的单位重新计算 */
		if ($goods['goods_weight'] > 0) {
			$goods['goods_weight_by_unit'] = ($goods['goods_weight'] >= 1) ? $goods['goods_weight'] : ($goods['goods_weight']*1000);
		}

		if (!empty($goods['goods_brief'])) {
			$goods['goods_brief'] = $goods['goods_brief'];
		}
		if (!empty($goods['keywords'])) {
			$goods['keywords'] = $goods['keywords'];
		}

		/* 如果不是促销，处理促销日期 */
		if (isset($goods['is_promote']) && $goods['is_promote'] == '0') {
			unset($goods['promote_start_date']);
			unset($goods['promote_end_date']);
		} else {
            $time = RC_Time::gmtime();
            if ($goods['promote_start_date'] < $time && $goods['promote_end_date'] > $time) {
                $goods['promote_status']       = 'on_sale';
                $goods['promote_status_label'] = __('进行中', 'goods');
            } elseif ($goods['promote_start_date'] > $time) {
                $goods['promote_status']       = 'coming';
                $goods['promote_status_label'] = __('即将开始', 'goods');
            } elseif ($goods['promote_end_date'] < $time) {
                $goods['promote_status']       = 'finished';
                $goods['promote_status_label'] = __('已结束', 'goods');
            }

			$goods['promote_start_date'] = RC_Time::local_date('Y-m-d H:i', $goods['promote_start_date']);
			$goods['promote_end_date'] = RC_Time::local_date('Y-m-d H:i', $goods['promote_end_date']);
		}
		/* 扩展分类 */
		$getCol = $this->db_goods_cat->field('cat_id')->where(array('goods_id' => $_REQUEST['goods_id']))->select();
		if (!empty($getCol) && is_array($getCol)) {
			foreach ($getCol as $value) {
				$goods['other_cat'][] = $value['cat_id'];
			}
		}

		/* 商品图片路径 */
		if (!empty($goods['goods_img'])) {
			$goods['goods_img'] 	= goods_imageutils::getAbsoluteUrl($goods['goods_img']);
			$goods['goods_thumb'] 	= goods_imageutils::getAbsoluteUrl($goods['goods_thumb']);
			$goods['original_img'] 	= goods_imageutils::getAbsoluteUrl($goods['original_img']);
		}

		/* 拆分商品名称样式 */
		$goods_name_style = explode('+', empty($goods['goods_name_style']) ? '+' : $goods['goods_name_style']);

		$merchant_cat = merchant_cat_list(0, $goods['merchant_cat_id'], true, 2);	//店铺分类
		
		//所属平台分类
		if (!empty($goods['cat_id'])) {
			$cat_str = get_cat_str($goods['cat_id']);
			$cat_html = get_cat_html($cat_str);
			$this->assign('cat_html', $cat_html);
		}
		
		//商品重量存在，重量单位是0的情况
		if ($goods['goods_weight'] > 0) {
			if (empty($goods['weight_unit'])) {
				if ($goods['goods_weight'] >= 1 ) {
					$goods['weight_unit'] = 2; //千克
				} else {
					$goods['weight_unit'] = 1; //克
				}
			} 
		}
		
		//设置选中状态,并分配标签导航
		$this->assign('action', 			ROUTE_A);
		$this->assign('tags', 				$this->tags);
		
		$this->assign('goods', 				$goods);
		$this->assign('goods_name_color', 	$goods_name_style[0]);
		$this->assign('merchant_cat',  		$merchant_cat);
		
		$this->assign('brand_list', 		get_brand_list());
// 		$this->assign('unit_list', 			goods::unit_list());
		$this->assign('weight_unit', 		$goods['weight_unit']);
		$this->assign('unit_list', Ecjia\App\Cashier\BulkGoods::unit_list());
		$this->assign('user_rank_list', 	get_rank_list());
		
		$this->assign('cfg', 				ecjia::config());
		
		$this->assign('form_act', 			RC_Uri::url('goods/merchant/edit'));
		$this->assign('member_price_list', 	get_member_price_list($_REQUEST['goods_id']));
		$this->assign('form_tab', 			'edit');
		$this->assign('gd', 				RC_ENV::gd_version());
		$this->assign('thumb_width', 		ecjia::config('thumb_width'));
		$this->assign('thumb_height', 		ecjia::config('thumb_height'));
		$this->assign('select_cat', 		RC_Uri::url('goods/merchant/select_cat'));

		$volume_price_list = '';
		if (isset($_REQUEST['goods_id'])) {
			$volume_price_list = get_volume_price_list($_REQUEST['goods_id']);
		}
		if (empty($volume_price_list)) {
			$volume_price_list = array('0' => array('number' => '', 'price' => ''));
		}
		$this->assign('volume_price_list', $volume_price_list);
		
		/* 显示商品信息页面 */
		$this->assign('form_action', RC_Uri::url('goods/merchant/update'));
		$this->assign('admin_url', RC_Uri::admin_url());
		
		return $this->display('goods_info.dwt');
	}

	/**
	* 编辑商品
	*/
	public function update() {
		$this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);
		
		$goods_id = !empty($_POST['goods_id']) ? intval($_POST['goods_id']) : 0;

		$upload = RC_Upload::uploader('newimage', array('save_path' => 'images', 'auto_sub_dirs' => true));
		$upload->add_saving_callback(function ($file, $filename) {
			return true;
		});

        /* 是否处理商品图 */
        $proc_goods_img = $this->request->hasFile('goods_img');
        $proc_thumb_img = $this->request->hasFile('thumb_img');
		
//		/* 是否处理商品图 */
//		$proc_goods_img = true;
//		if (isset($_FILES['goods_img']) && !$upload->check_upload_file($_FILES['goods_img'])) {
//		    $proc_goods_img = false;
//		}
//
//		/* 是否处理缩略图 */
//		$proc_thumb_img = isset($_FILES['thumb_img']) ? true : false;
//		if (isset($_FILES['thumb_img']) && !$upload->check_upload_file($_FILES['thumb_img'])) {
//		    $proc_thumb_img = false;
//		}

		if ($proc_goods_img) {
            $image_info = $upload->upload('goods_img');
            if (empty($image_info)) {
                return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
		}
		if ($proc_thumb_img) {
            $thumb_info = $upload->upload('thumb_img');
            if (empty($thumb_info)) {
                return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
		}

//		/* 处理商品图片 */
//		$goods_img	 	= ''; // 初始化商品图片
//		$goods_thumb 	= ''; // 初始化商品缩略图
//		$img_original	= ''; // 初始化原始图片


		/* 处理商品数据 */
		$shop_price 	= !empty($_POST['shop_price']) 		? $_POST['shop_price'] 				: 0;
		$market_price 	= !empty($_POST['market_price']) && is_numeric($_POST['market_price']) ? $_POST['market_price'] : 0;
		$cost_price 	= !empty($_POST['cost_price'])      ? $_POST['cost_price'] 				: 0;
		$goods_weight 	= !empty($_POST['goods_weight']) && is_numeric($_POST['goods_weight']) ? $_POST['goods_weight'] : 0.000;
		$weight_unit	= !empty($_POST['weight_unit']) ? $_POST['weight_unit'] : 1;

		$is_best 		= isset($_POST['is_best']) 			? 1 : 0;
		$is_new 		= isset($_POST['is_new']) 			? 1 : 0;
		$is_hot 		= isset($_POST['is_hot']) 			? 1 : 0;
		$is_on_sale 	= isset($_POST['is_on_sale']) 		? 1 : 0;
		$is_alone_sale 	= isset($_POST['is_alone_sale']) 	? 1 : 0;
		$is_shipping 	= isset($_POST['is_shipping']) 		? 1 : 0;
		
		$goods_number     = !empty($_POST['goods_number'])   ? intval($_POST['goods_number'])  : ecjia::config('default_storage');
		$goods_barcode    = !empty($_POST['goods_barcode'])  ? trim($_POST['goods_barcode'])   : '';
		$warn_number 	= isset($_POST['warn_number']) 		? $_POST['warn_number'] 	: 0;
		
		$suppliers_id 	= isset($_POST['suppliers_id']) 	? intval($_POST['suppliers_id']) 	: '0';

		$goods_name 		= htmlspecialchars($_POST['goods_name']);
		$goods_name_style 	= htmlspecialchars($_POST['goods_name_color']);
		
		$brand_id 			= empty($_POST['brand_id']) 		? 0 	: intval($_POST['brand_id']);
		$merchant_cat_id 	= empty($_POST['merchant_cat_id']) 	? '' 	: intval($_POST['merchant_cat_id']);
		$store_category 	= empty($_POST['store_category']) 	? 0 	: intval($_POST['store_category']);
		
		if ($store_category > 0){
			$catgory_id = $store_category;
		}
		
		if (empty($merchant_cat_id)) {
			return $this->showmessage(__('请选择店铺商品分类', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if (empty($goods_name)) {
			return $this->showmessage(__('请输入商品名称', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		$review_status = RC_DB::table('goods')->where('goods_id', $goods_id)->pluck('review_status');
		if($review_status === 2) {
			$review_status = 1;
		} 
		
		//商家分类父级处理
		$mer_cat = new MerchantCategoryLevel($_SESSION['store_id']);
		$mer_cat_ids = $mer_cat->getParentCategoryIds($merchant_cat_id);
		list($mer_level1, $mer_level2, $mer_level3) = $mer_cat_ids;
		
		$data = array(
		  	'goods_name'				=> rc_stripslashes($goods_name),
		  	'goods_name_style'	  		=> $goods_name_style,
			'merchat_cat_level1_id'	=> empty($mer_level1) ? 0 : $mer_level1,
			'merchat_cat_level2_id'	=> empty($mer_level2) ? 0 : $mer_level2,
			'merchant_cat_id'			=> $merchant_cat_id,	//店铺分类id
		  	'brand_id'			  		=> $brand_id,
		  	'shop_price'				=> $shop_price,
		  	'market_price'		  		=> $market_price,
			'cost_price'				=> $cost_price,	
		  	'suppliers_id'		  		=> $suppliers_id,
		  	'is_real'			   		=> empty($code) ? '1' : '0',
		  	'extension_code'			=> $code,
		  	'keywords'			  		=> $_POST['keywords'],
		  	'goods_brief'		   		=> $_POST['goods_brief'],
		  	'seller_note'		   		=> $_POST['seller_note'],
		  	'goods_weight'		 		=> $goods_weight,
			'weight_unit'				=> $weight_unit,
			'goods_barcode'		  		=> $goods_barcode,
		  	'goods_number'		  		=> $goods_number,
		  	'warn_number'		   		=> $warn_number,
		  	'integral'			  		=> $_POST['integral'],
		  	'store_best'			   	=> $is_best,
		  	'store_new'					=> $is_new,
		  	'store_hot'					=> $is_hot,
		  	'is_on_sale'				=> $is_on_sale,
		  	'is_alone_sale'		 		=> $is_alone_sale,
		  	'is_shipping'		   		=> $is_shipping,
		  	'last_update'		   		=> RC_Time::gmtime(),
			'review_status'				=> $review_status,	
		);
		RC_DB::table('goods')->where('goods_id', $goods_id)->update($data);
		
		/* 记录日志 */
		ecjia_merchant::admin_log($_POST['goods_name'], 'edit', 'goods');
		//为更新用户购物车数据加标记
		RC_Api::api('cart', 'mark_cart_goods', array('goods_id' => $goods_id));

		/* 处理会员价格 */
		if (isset($_POST['user_rank']) && isset($_POST['user_price'])) {
		  	handle_member_price($goods_id, $_POST['user_rank'], $_POST['user_price']);
		  	/*释放指定商品不同会员等级价格缓存*/
		  	$cache_goods_user_rank_prices_key = 'goods_user_rank_prices_'.$goods_id. '-' . $shop_price;
		  	$cache_user_rank_prices_id = sprintf('%X', crc32($cache_goods_user_rank_prices_key));
		  	$orm_member_price_db = RC_Model::model('goods/orm_member_price_model');
		  	$orm_member_price_db->delete_cache_item($cache_user_rank_prices_id);
		}

		/* 处理优惠价格 */
		if (isset($_POST['volume_number']) && isset($_POST['volume_price'])) {
		  	$temp_num = array_count_values($_POST['volume_number']);
		  	foreach ($temp_num as $v) {
		     	if ($v > 1) {
		        	return $this->showmessage(__('优惠数量重复！', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		        	break;
		    	}
			}
			handle_volume_price($goods_id, $_POST['volume_number'], $_POST['volume_price']);
		}

		/* 更新上传后的商品图片 */
		if ($proc_goods_img) {
			if (!empty($image_info)) {
//				$goods_image = new goods_image_data($image_info['name'], $image_info['tmpname'], $image_info['ext'], $goods_id);
//				if ($proc_thumb_img) {
//					$goods_image->set_auto_thumb(false);
//				}
//
//				$result = $goods_image->update_goods();

                $goods_image = new \Ecjia\App\Goods\GoodsImage\Goods\GoodsImage($goods_id, 0, $image_info);
                if ($proc_thumb_img) {
                    $goods_image->setAutoGenerateThumb(false);
                } else {
                    $goods_image->setAutoGenerateThumb(true);
                }

                $result = $goods_image->updateToDatabase();

				if (is_ecjia_error($result)) {
					return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
				//删除生成的商品二维码
				$disk = RC_Filesystem::disk();
				$goods_qrcode = 'data/qrcodes/goods/goods_'.$goods_id.'.png';
				if ($disk->exists(RC_Upload::upload_path($goods_qrcode))) {
					$disk->delete(RC_Upload::upload_path().$goods_qrcode);
				}
			}
		}

		/* 更新上传后的缩略图片 */
		if ($proc_thumb_img) {
			if (!empty($thumb_info)) {
//				$thumb_image = new goods_image_data($thumb_info['name'], $thumb_info['tmpname'], $thumb_info['ext'], $goods_id);
//				$result = $thumb_image->update_thumb();

                $thumb_image = new \Ecjia\App\Goods\GoodsImage\Goods\GoodsThumb($goods_id, 0, $thumb_info);
                $result = $thumb_image->updateToDatabase();

				if (is_ecjia_error($result)) {
					return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
				//删除生成的商品二维码
				$disk = RC_Filesystem::disk();
				$goods_qrcode = 'data/qrcodes/goods/goods_'.$goods_id.'.png';
				if ($disk->exists(RC_Upload::upload_path($goods_qrcode))) {
					$disk->delete(RC_Upload::upload_path().$goods_qrcode);
				}
			}
		}
		
		$code = '';
		$link = array();
		$link[1] = list_merchant_link($code);

		for ($i = 0; $i < count($link); $i++) {
		  	$key_array[] = $i;
		}
		krsort($link);
		$link = array_combine($key_array, $link);
		
		/* 释放app缓存*/
		$orm_goods_db = RC_Model::model('goods/orm_goods_model');
		$goods_cache_array = $orm_goods_db->get_cache_item('goods_list_cache_key_array');
		if (!empty($goods_cache_array)) {
			foreach ($goods_cache_array as $val) {
				$orm_goods_db->delete_cache_item($val);
			}
			$orm_goods_db->delete_cache_item('goods_list_cache_key_array');
		}
		/*释放商品基本信息缓存*/
		$cache_goods_basic_info_key = 'goods_basic_info_'.$goods_id;
		$cache_basic_info_id = sprintf('%X', crc32($cache_goods_basic_info_key));
		$orm_goods_db->delete_cache_item($cache_basic_info_id);

		return $this->showmessage(__('编辑商品成功', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $link, 'max_id' => $goods_id));
	}

	/**
	 * 审核商品
	 */
	public function review() {
		// 检查权限
		$this->admin_priv('goods_manage', ecjia::MSGTYPE_JSON);
		
		$code = empty($_REQUEST['extension_code']) ? '' : trim($_REQUEST['extension_code']);
		if ($code == 'virtual_card') {
			$this->admin_priv('virualcard', ecjia::MSGTYPE_JSON); 
		} else {
			$this->admin_priv('goods_manage', ecjia::MSGTYPE_JSON);
		}
		if (empty($_SESSION['store_id'])) {
			$arr['review_status'] = $_POST['value'];
			$id = intval($_POST['pk']);
			RC_DB::table('goods')->where('goods_id', $id)->update($arr);
			
			return $this->showmessage(__('成功切换审核状态', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
			return $this->showmessage(__('请进入入驻商后台进行操作', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	//修改商品所属平台分类
	public function select_cat() {
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品列表', 'goods'), RC_Uri::url('goods/merchant/init')));
		
		$goods_id = !empty($_GET['goods_id']) ? intval($_GET['goods_id']) : 0;
		if (empty($goods_id)) {
			return $this->showmessage(__('未检测到此商品', 'goods'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('返回商品列表', 'goods'), 'href' => RC_Uri::url('goods/merchant/init')))));
		}
		
		/* 商品信息 */
		$goods = RC_DB::table('goods')->where('goods_id', $goods_id)->where('store_id', $_SESSION['store_id'])->first();
		if (empty($goods)) {
			return $this->showmessage(__('未检测到此商品', 'goods'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('返回商品列表', 'goods'), 'href' => RC_Uri::url('goods/merchant/init')))));
		}
		
		$ur_here = __('选择平台分类', 'goods');
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑商品', 'goods'), RC_Uri::url('goods/merchant/edit', array('goods_id' => $goods_id))));
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here($ur_here));
		
		$this->assign('action_link', array('href' => RC_Uri::url('goods/merchant/edit', array('goods_id' => $goods_id)), 'text' => __('编辑商品', 'goods')));
		
		$cat_list = cat_list(0, 0, false, 1);	//平台分类
		$this->assign('cat_list', $cat_list);
		
		$cat_str = get_cat_str($goods['cat_id']);
		$cat_html = get_cat_html($cat_str);
		
		$this->assign('cat_html', '（'.$cat_html.'）');
		$this->assign('ur_here', $ur_here);
		$this->assign('goods_id', $goods_id);
		$this->assign('form_url', RC_Uri::url('goods/merchant/update_cat', array('goods_id' => $goods_id)));
		
		return $this->display('goods_cat_select.dwt');
	}
	
	//更新商品平台分类
	public function update_cat() {
		$cat_id	= !empty($_POST['cat_id'])	? intval($_POST['cat_id'])	: 0;
		$goods_id = !empty($_POST['goods_id']) ? intval($_POST['goods_id']) : 0;
		
		if (empty($goods_id)) {
			return $this->showmessage(__('未检测到此商品', 'goods'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('返回商品列表', 'goods'), 'href' => RC_Uri::url('goods/merchant/init')))));
		}
		
		/* 商品信息 */
		$goods = RC_DB::table('goods')->where('goods_id', $goods_id)->where('store_id', $_SESSION['store_id'])->first();
		if (empty($goods)) {
			return $this->showmessage(__('未检测到此商品', 'goods'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('返回商品列表', 'goods'), 'href' => RC_Uri::url('goods/merchant/init')))));
		}
		
		if (empty($cat_id)) {
			return $this->showmessage(__('请选择平台分类', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		//平台分类父级处理
		$cats= new CategoryLevel();
		$cat_ids = $cats->getParentCategoryIds($cat_id);
		list($level1, $level2, $level3) = $cat_ids;
		
		$data =array(
			'cat_level1_id'   => empty($level1) ? 0 : $level1,
			'cat_level2_id'   => empty($level2) ? 0 : $level2,
			'cat_id'          => $cat_id
				
		);
		RC_DB::table('goods')->where('goods_id', $goods_id)->where('store_id', $_SESSION['store_id'])->update($data);
		
		return $this->showmessage(__('编辑商品成功', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('goods/merchant/select_cat', array('goods_id' => $goods_id))));
	}

	/**
	* 批量操作
	*/
	public function batch() {
		/* 取得要操作的商品编号 */
		$goods_id = !empty($_POST['checkboxes']) ? $_POST['checkboxes'] : 0;
		
		if (!isset($_GET['type']) || $_GET['type'] == '') {
			return $this->showmessage(__('请选择操作', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$goods_id = explode(',', $goods_id);
		$data = RC_DB::table('goods')->select('goods_name')->whereIn('goods_id', $goods_id)->get();
		
		if (isset($_GET['type'])) {
			/* 放入回收站 */
			if ($_GET['type'] == 'trash') {
				/* 检查权限 */
				$this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);
				update_goods($goods_id, 'is_delete', '1');
				$action = 'batch_trash';
			} 
			/* 上架 */
			elseif ($_GET['type'] == 'on_sale') {
				/* 检查权限 */
				$this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);
				update_goods($goods_id, 'is_on_sale', '1');
			} 
			/* 下架 */
			elseif ($_GET['type'] == 'not_on_sale') {
				/* 检查权限 */
				$this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);
				update_goods($goods_id, 'is_on_sale', '0');
			} 
			/* 设为精品 */
			elseif ($_GET['type'] == 'best') {
				/* 检查权限 */
				$this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);
				update_goods($goods_id, 'store_best', '1');
			} 
			/* 取消精品 */
			elseif ($_GET['type'] == 'not_best') {
				/* 检查权限 */
				$this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);
				update_goods($goods_id, 'store_best', '0');
			} 
			/* 设为新品 */
			elseif ($_GET['type'] == 'new') {
				/* 检查权限 */
				$this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);
				update_goods($goods_id, 'store_new', '1');
			} 
			/* 取消新品 */
			elseif ($_GET['type'] == 'not_new') {
				/* 检查权限 */
				$this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);
				update_goods($goods_id, 'store_new', '0');
			} 
			/* 设为热销 */
			elseif ($_GET['type'] == 'hot') {
				/* 检查权限 */
				$this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);
				update_goods($goods_id, 'store_hot', '1');
			} 
			/* 取消热销 */
			elseif ($_GET['type'] == 'not_hot') {
				/* 检查权限 */
				$this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);
				update_goods($goods_id, 'store_hot', '0');
			} 
			/* 转移到分类 */
			elseif ($_GET['type'] == 'move_to') {
				/* 检查权限 */
				$this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);
				if (empty($_GET['target_cat'])) {
					return $this->showmessage(__('请先选择要转移的分类', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
				update_goods($goods_id, 'merchant_cat_id', $_GET['target_cat']);
			} 
			/* 还原 */
			elseif ($_GET['type'] == 'restore') {
				/* 检查权限 */
				$this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);
				update_goods($goods_id, 'is_delete', '0');
				$action = 'batch_restore';
			} 
			/* 删除 */
			elseif ($_GET['type'] == 'drop') {
				/* 检查权限 */
				$this->admin_priv('goods_delete', ecjia::MSGTYPE_JSON);
				delete_goods($goods_id);
				$action = 'batch_remove';
			}
		}
		
		/* 记录日志 */
		if (!empty($data) && $action) {
			foreach ($data as $k => $v) {
				ecjia_merchant::admin_log($v['goods_name'], $action, 'goods');
			}
		}

		$page = empty($_GET['page']) ? '&page=1' : '&page='.$_GET['page'];
		$is_on_sale = isset($_GET['is_on_sale']) ? $_GET['is_on_sale'] : '';
		
		if ($_GET['type'] == 'drop' || $_GET['type'] == 'restore') {
			$pjaxurl = RC_Uri::url('goods/merchant/trash' ,$page);
		} else {
			$action_url = $_GET['action_url'];
			if($action_url == 'finish') {
				$pjaxurl = RC_Uri::url('goods/merchant/finish', 'is_on_sale='.$is_on_sale.$page);
			} elseif($action_url == 'obtained') {
				$pjaxurl = RC_Uri::url('goods/merchant/obtained', 'is_on_sale='.$is_on_sale.$page);
			} elseif($action_url == 'check') {
				$pjaxurl = RC_Uri::url('goods/merchant/check', 'is_on_sale='.$is_on_sale.$page);
			} else {
				$pjaxurl = RC_Uri::url('goods/merchant/init', 'is_on_sale='.$is_on_sale.$page);
			}
		}
		
		/* 释放app缓存*/
		$orm_goods_db = RC_Model::model('goods/orm_goods_model');
		$goods_cache_array = $orm_goods_db->get_cache_item('goods_list_cache_key_array');
		if (!empty($goods_cache_array)) {
			foreach ($goods_cache_array as $val) {
				$orm_goods_db->delete_cache_item($val);
			}
			$orm_goods_db->delete_cache_item('goods_list_cache_key_array');
		}
		/*释放商品基本信息缓存*/
		if (!empty($goods_id)) {
			foreach ($goods_id as $v) {
				$cache_goods_basic_info_key = 'goods_basic_info_'.$v;
				$cache_basic_info_id = sprintf('%X', crc32($cache_goods_basic_info_key));
				$orm_goods_db->delete_cache_item($cache_basic_info_id);
			}
		}
		
		return $this->showmessage(__('批量操作成功', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $pjaxurl));
	}

	/**
	* 修改商品名称
	*/
	public function edit_goods_name() {
		$this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);

		$goods_id = intval($_POST['pk']);
		$goods_name = trim($_POST['value']);
        if (!empty($goods_name)) {
        	RC_DB::table('goods')->where('goods_id', $goods_id)->where('store_id', $_SESSION['store_id'])->update(array('goods_name' => $goods_name, 'last_update' => RC_Time::gmtime()));        	
        	/* 释放app缓存*/
        	$orm_goods_db = RC_Model::model('goods/orm_goods_model');
        	$goods_cache_array = $orm_goods_db->get_cache_item('goods_list_cache_key_array');
        	if (!empty($goods_cache_array)) {
        		foreach ($goods_cache_array as $val) {
        			$orm_goods_db->delete_cache_item($val);
        		}
        		$orm_goods_db->delete_cache_item('goods_list_cache_key_array');
        	}
        	/*释放商品基本信息缓存*/
        	$cache_goods_basic_info_key = 'goods_basic_info_'.$goods_id;
        	$cache_basic_info_id = sprintf('%X', crc32($cache_goods_basic_info_key));
        	$orm_goods_db->delete_cache_item($cache_basic_info_id);
        	
        	return $this->showmessage(__('修改成功', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => stripslashes($goods_name)));
        } else {
        	return $this->showmessage(__('请输入商品名称', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
	}

	/**
	* 修改商品货号
	*/
	public function edit_goods_sn() {
		$this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);

		$goods_id = intval($_POST['pk']);
		$goods_sn = trim($_POST['value']);

		if (empty($goods_sn)) {
			return $this->showmessage(__('请输入商品货号', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		/* 检查是否重复 */
		if ($goods_sn) {
			$count = RC_DB::table('goods')->where('goods_sn', $goods_sn)->where('goods_id', '!=', $goods_id)->where('store_id', $_SESSION['store_id'])->count();
			if ($count > 0) {
				return $this->showmessage(__('您输入的货号已存在，请换一个', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		$query = RC_DB::table('products')->where('product_sn', $goods_sn)->pluck('goods_id');

		if ($query > 0) {
			return $this->showmessage(__('您输入的货号已存在，请换一个', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		RC_DB::table('goods')->where('goods_id', $goods_id)->where('store_id', $_SESSION['store_id'])->update(array('goods_sn' => $goods_sn, 'last_update' => RC_Time::gmtime()));		
		
		/* 释放app缓存*/
		$orm_goods_db = RC_Model::model('goods/orm_goods_model');
		$goods_cache_array = $orm_goods_db->get_cache_item('goods_list_cache_key_array');
		if (!empty($goods_cache_array)) {
			foreach ($goods_cache_array as $val) {
				$orm_goods_db->delete_cache_item($val);
			}
			$orm_goods_db->delete_cache_item('goods_list_cache_key_array');
		}
		/*释放商品基本信息缓存*/
		$cache_goods_basic_info_key = 'goods_basic_info_'.$goods_id;
		$cache_basic_info_id = sprintf('%X', crc32($cache_goods_basic_info_key));
		$orm_goods_db->delete_cache_item($cache_basic_info_id);
		
		return $this->showmessage(__('修改成功', 'goods'),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => stripslashes($goods_sn)));
	}

	/**
	 * 检查商品货号
	 */
	public function check_goods_sn() {
		$this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);
		
		$goods_id = intval($_REQUEST['goods_id']);
		$goods_sn = htmlspecialchars(trim($_REQUEST['goods_sn']));

		$query_goods_sn = RC_DB::table('goods')->where('goods_sn', $goods_sn)->where('goods_id', '!=', $goods_id)->pluck('goods_id');
		
		if ($query_goods_sn) {
			return $this->showmessage(__('您输入的货号已存在，请换一个', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		/* 检查是否重复 */
		if (!empty($goods_sn)) {
			$query = RC_DB::table('products')->where('product_sn', $goods_sn)->pluck('goods_id');
			if ($query) {
				return $this->showmessage(__('您输入的货号已存在，请换一个', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => ''));
	}

	/**
	* 修改商品价格
	*/
	public function edit_goods_price() {
		$this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);

		$goods_id = intval($_POST['pk']);
		$goods_price = floatval($_POST['value']);
		$price_rate = floatval(ecjia::config('market_price_rate') * $goods_price);
		$data = array(
			'shop_price'	=> $goods_price,
			'market_price'  => $price_rate,
			'last_update'   => RC_Time::gmtime()
		);
		if ($goods_price < 0 || $goods_price == 0 && $_POST['val'] != "$goods_price") {
			return $this->showmessage(__('您输入了一个非法的市场价格。', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			RC_DB::table('goods')->where('goods_id', $goods_id)->where('store_id', $_SESSION['store_id'])->update($data);
			//为更新用户购物车数据加标记
			RC_Api::api('cart', 'mark_cart_goods', array('goods_id' => $goods_id));
			/* 释放app缓存*/
			$orm_goods_db = RC_Model::model('goods/orm_goods_model');
			$goods_cache_array = $orm_goods_db->get_cache_item('goods_list_cache_key_array');
			if (!empty($goods_cache_array)) {
				foreach ($goods_cache_array as $val) {
					$orm_goods_db->delete_cache_item($val);
				}
				$orm_goods_db->delete_cache_item('goods_list_cache_key_array');
			}
			/*释放商品基本信息缓存*/
			$cache_goods_basic_info_key = 'goods_basic_info_'.$goods_id;
			$cache_basic_info_id = sprintf('%X', crc32($cache_goods_basic_info_key));
			$orm_goods_db->delete_cache_item($cache_basic_info_id);
			
			return $this->showmessage(__('修改成功', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => number_format($goods_price, 2, '.', '')));
		}
	}

	/**
	 * 修改商品排序
	 */
	public function edit_sort_order() {
		$this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);

		$goods_id = intval($_POST['pk']);
		$sort_order = intval($_POST['value']);
		$data = array(
			'store_sort_order' 	=> $sort_order,
			'last_update' 		=> RC_Time::gmtime()
		);
		RC_DB::table('goods')->where('goods_id', $goods_id)->where('store_id', $_SESSION['store_id'])->update($data);
		
		return $this->showmessage(__('修改成功', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $sort_order));
	}

	/**
	* 修改商品库存数量
	*/
	public function edit_goods_number() {
		$this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);

		$goods_id = intval($_POST['pk']);
		$goods_num = !empty($_POST['value']) ? intval($_POST['value']) : 0;
		
		$data = array(
			'goods_number' 	=> $goods_num,
			'last_update' 	=> RC_Time::gmtime()
		);

		if ($goods_num < 0) {
			return $this->showmessage(__('商品库存数量错误', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		RC_DB::table('goods')->where('goods_id', $goods_id)->where('store_id', $_SESSION['store_id'])->update($data);
		
		/* 释放app缓存*/
		$orm_goods_db = RC_Model::model('goods/orm_goods_model');
		$goods_cache_array = $orm_goods_db->get_cache_item('goods_list_cache_key_array');
		if (!empty($goods_cache_array)) {
			foreach ($goods_cache_array as $val) {
				$orm_goods_db->delete_cache_item($val);
			}
			$orm_goods_db->delete_cache_item('goods_list_cache_key_array');
		}
		/*释放商品基本信息缓存*/
		$cache_goods_basic_info_key = 'goods_basic_info_'.$goods_id;
		$cache_basic_info_id = sprintf('%X', crc32($cache_goods_basic_info_key));
		$orm_goods_db->delete_cache_item($cache_basic_info_id);
		
		return $this->showmessage(__('修改成功', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $goods_num));
	}

	/**
	* 修改上架状态
	*/
	public function toggle_on_sale() {
		$this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);
		
		$goods_id = intval($_POST['id']);
		$on_sale = intval($_POST['val']);

		$data = array(
			'is_on_sale' 	=> $on_sale,
			'last_update' 	=> RC_Time::gmtime()
		);
		RC_DB::table('goods')->where('goods_id', $goods_id)->where('store_id', $_SESSION['store_id'])->update($data);
		
		/* 释放app缓存*/
		$orm_goods_db = RC_Model::model('goods/orm_goods_model');
		$goods_cache_array = $orm_goods_db->get_cache_item('goods_list_cache_key_array');
		if (!empty($goods_cache_array)) {
			foreach ($goods_cache_array as $val) {
				$orm_goods_db->delete_cache_item($val);
			}
			$orm_goods_db->delete_cache_item('goods_list_cache_key_array');
		}
		/*释放商品基本信息缓存*/
		$cache_goods_basic_info_key = 'goods_basic_info_'.$goods_id;
		$cache_basic_info_id = sprintf('%X', crc32($cache_goods_basic_info_key));
		$orm_goods_db->delete_cache_item($cache_basic_info_id);
		
		return $this->showmessage(__('已成功切换上架状态', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $on_sale));
	}

	/**
	* 修改精品推荐状态
	*/
	public function toggle_best() {
		$this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);
		
		$goods_id = intval($_POST['id']);
		$is_best = intval($_POST['val']);
		$data = array(
			'store_best' 	=> $is_best,
			'last_update' 	=> RC_Time::gmtime()
		);
		RC_DB::table('goods')->where('goods_id', $goods_id)->where('store_id', $_SESSION['store_id'])->update($data);
		
		return $this->showmessage(__('已成功切换精品推荐状态', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $is_best));
	}

	/**
	* 修改新品推荐状态
	*/
	public function toggle_new() {
		$this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);
		
		$goods_id = intval($_POST['id']);
		$is_new = intval($_POST['val']);
		$data = array(
			'store_new'		=>	$is_new,
			'last_update'	=>	RC_Time::gmtime()
		);
			
		RC_DB::table('goods')->where('goods_id', $goods_id)->where('store_id', $_SESSION['store_id'])->update($data);
		return $this->showmessage(__('已成功切换新品推荐状态', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $is_new));
	}

	/**
	* 修改热销推荐状态
	*/
	public function toggle_hot() {
		$this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);

		$goods_id = intval($_POST['id']);
		$is_hot = intval($_POST['val']);
		$data = array(
			'store_hot'	 	=> $is_hot,
			'last_update' 	=> RC_Time::gmtime()
		);
			
		RC_DB::table('goods')->where('goods_id', $goods_id)->where('store_id', $_SESSION['store_id'])->update($data);
		return $this->showmessage(__('已成功切换热销推荐状态', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $is_hot));
	}

	/**
	* 放入回收站
	*/
	public function remove() {
        $this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);

    	$goods_id = intval($_GET['id']);
    	$goods_name = RC_DB::table('goods')->where('goods_id', $goods_id)->pluck('goods_name');

    	RC_DB::table('goods')->where('goods_id', $goods_id)->where('store_id', $_SESSION['store_id'])->update(array('is_delete' => 1));
    	
    	/* 释放app缓存*/
    	$orm_goods_db = RC_Model::model('goods/orm_goods_model');
    	$goods_cache_array = $orm_goods_db->get_cache_item('goods_list_cache_key_array');
    	if (!empty($goods_cache_array)) {
    		foreach ($goods_cache_array as $val) {
    			$orm_goods_db->delete_cache_item($val);
    		}
    		$orm_goods_db->delete_cache_item('goods_list_cache_key_array');
    	}
    	/*释放商品基本信息缓存*/
    	$cache_goods_basic_info_key = 'goods_basic_info_'.$goods_id;
    	$cache_basic_info_id = sprintf('%X', crc32($cache_goods_basic_info_key));
    	$orm_goods_db->delete_cache_item($cache_basic_info_id);
    		
    	ecjia_merchant::admin_log(addslashes($goods_name), 'trash', 'goods');
    	return $this->showmessage(__('放入回收站成功', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}

	/**
	* 还原回收站中的商品
	*/
	public function restore_goods() {
	    $this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);
	    
		$goods_id = intval($_GET['id']);
		$data = array(
			'is_delete' => 0,
			'add_time'	=> RC_Time::gmtime()
		);
		$goods_name = RC_DB::table('goods')->where('goods_id', $goods_id)->pluck('goods_name');
		RC_DB::table('goods')->where('goods_id', $goods_id)->where('store_id', $_SESSION['store_id'])->update($data);
		
		/* 释放app缓存*/
		$orm_goods_db = RC_Model::model('goods/orm_goods_model');
		$goods_cache_array = $orm_goods_db->get_cache_item('goods_list_cache_key_array');
		if (!empty($goods_cache_array)) {
			foreach ($goods_cache_array as $val) {
				$orm_goods_db->delete_cache_item($val);
			}
			$orm_goods_db->delete_cache_item('goods_list_cache_key_array');
		}
		/*释放商品基本信息缓存*/
		$cache_goods_basic_info_key = 'goods_basic_info_'.$goods_id;
		$cache_basic_info_id = sprintf('%X', crc32($cache_goods_basic_info_key));
		$orm_goods_db->delete_cache_item($cache_basic_info_id);
		
		ecjia_merchant::admin_log(addslashes($goods_name), 'restore', 'goods');
		return $this->showmessage(__('还原商品成功', 'goods'),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}

	/**
	 * 彻底删除商品
	 */
	public function drop_goods() {
		$this->admin_priv('goods_delete', ecjia::MSGTYPE_JSON);

		/* 取得要操作的商品编号 */
		$goods_id = !empty($_GET['id']) ? $_GET['id'] : 0;
		/* 取得商品信息 */
		$goods_name = RC_DB::table('goods')->where('goods_id', $goods_id)->pluck('goods_name');
		
		$goods_id = explode(',', $goods_id);
		delete_goods($goods_id);
		
		/* 记录日志 */
		ecjia_merchant::admin_log(addslashes($goods_name), 'remove', 'goods');
		return $this->showmessage(__('删除商品成功', 'goods'),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('goods/merchant/trash')));
	}

	/**
	* 货品列表
	*/
	public function product_list() {
		$this->admin_priv('goods_manage');
		
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品列表', 'goods'), RC_Uri::url('goods/merchant/init')));
		$ur_here = __('货品管理（SKU）', 'goods');
		$this->assign('ur_here', $ur_here);
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($ur_here));
		
		$goods_id = intval($_GET['goods_id']);
        $db_goods = RC_DB::table('goods')->where('goods_id', $goods_id)->where('store_id', $_SESSION['store_id']);
        
        //获取商品的信息
        $goods = $db_goods->select('goods_sn', 'goods_name', 'goods_type', 'shop_price')->first();
        if (empty($goods)) {
        	return $this->showmessage(__('未检测到此商品', 'goods'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('返回商品列表', 'goods'), 'href' => RC_Uri::url('goods/merchant/init')))));
        }
        
        //商品当前有没选择规格；
        if ($goods['goods_type'] > 0) {
        	$this->assign('has_goods_type', 1);
        } else {
        	$this->assign('has_goods_type', 0);
        }
        
		//获得商品已经添加的规格列表
		$attribute = get_goods_specifications_list($goods_id);
		$_attribute = array();
		if (!empty($attribute)) {
			foreach ($attribute as $attribute_value) {
				$_attribute[$attribute_value['attr_id']]['attr_values'][] = $attribute_value['attr_value'];
				$_attribute[$attribute_value['attr_id']]['attr_id'] = $attribute_value['attr_id'];
				$_attribute[$attribute_value['attr_id']]['attr_name'] = $attribute_value['attr_name'];
			}
		}
		$attribute_count = count($_attribute);
		//商品规格对应的属性数量
		if (empty($attribute_count)) {
			$this->assign('goods_attribute', 'no');
		} else {
			$this->assign('goods_attribute', 'yes');
		}
		
		
//         if (empty($attribute_count)) {
//         	$links[] = array('text' => __('商品属性', 'goods'), 'href' => RC_Uri::url('goods/merchant/edit_goods_attr', array('goods_id' => $goods_id)));
//         	$links[] = array('text' => __('返回商品列表', 'goods'), 'href' => RC_Uri::url('goods/merchant/init'));
//             return $this->showmessage(__('请先添加库存属性，再到货品管理中设置货品库存', 'goods'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => $links));
//         }

		/* 取商品的货品 */
		$product = product_list($goods_id, '');
		
		/*获得商品的规格和属性*/
		$properties = Ecjia\App\Goods\GoodsFunction::get_goods_properties($goods_id);
		$properties = Ecjia\App\Goods\GoodsFunction::handle_spec($properties);
		
		//商品规格
		$product_goods_attrs = [];
		$specification = $properties['spe'];
		if (!empty($specification)) {
			//商品规格分组
			foreach ($specification as $key => $val)  {
				if ($val['value']) {
					foreach ($val['value'] as $spec) {
						$arr[$key][] = $spec['id'];
					}
				}
			}
			//商品规格属性id重组处理
			$spec_combine_arr = $this->_combination($arr);
			foreach ($spec_combine_arr as $goods_attr) {
				$goods_attr_string = implode('|', $goods_attr);
				$product_goods_attrs[] = $goods_attr_string;
			}
		}
		//货品是否有效
		if (!empty($product['product'])) {
			foreach ($product['product'] as $key => $val) {
				if (empty($product_goods_attrs)) {
					$val['product_is_avaliable'] = 'no';
				} else {
					$goods_attr_str_arr = explode('|', $val['goods_attr_str']);
					if (in_array($val['goods_attr_str'], $product_goods_attrs)) {
						$val['product_is_avaliable'] = 'yes';
					} else {
						$val['product_is_avaliable'] = 'no';
					}
				}
				$product_arr[] = $val;
			}
		}
		
		$product['product'] = $product_arr;
		
		$this->assign('tags',              	$this->tags);
		$this->assign('goods_name', 		sprintf(__('商品名称：%s', 'goods'), $goods['goods_name']));
		$this->assign('goods_sn', 			sprintf(__('货号：%s', 'goods'), $goods['goods_sn']));
		$this->assign('attribute', 			$_attribute);
		$this->assign('product_sn', 		$goods['goods_sn'] . '_');
		$this->assign('product_number', 	ecjia::config('default_storage'));

		$this->assign('action_link', 		array('href' => RC_Uri::url('goods/merchant/init'), 'text' => __('商品列表', 'goods')));
		$this->assign('product_list', 		$product['product']);
		$this->assign('goods_id', 			$goods_id);
		$this->assign('form_action', 		RC_Uri::url('goods/merchant/product_add_execute'));
		$this->assign('action_link', array('href' => RC_Uri::url('goods/merchant/init'), 'text' => __('商品列表', 'goods')));
		
		return $this->display('product_info.dwt');
	}

    /**
     * 货品编辑
     */
    public function product_edit()
    {
        $this->admin_priv('goods_manage');

        $goods_id = intval($_GET['goods_id']);
        $product_id = intval($_GET['id']);
        ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品列表', 'goods'), RC_Uri::url('goods/merchant/init')));
        ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品编辑', 'goods'), RC_Uri::url('goods/merchant/edit', ['goods_id' => $goods_id])));
        $ur_here = __('编辑货品（SKU）', 'goods');
        $this->assign('ur_here', $ur_here);

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($ur_here));


        $db_goods = RC_DB::table('goods')->where('goods_id', $goods_id)->where('store_id', $_SESSION['store_id']);

        //获取商品的信息
        $goods = $db_goods->select('goods_sn', 'goods_name', 'goods_type', 'shop_price')->first();
        if (empty($goods)) {
            return $this->showmessage(__('未检测到此商品', 'goods'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('返回商品列表', 'goods'), 'href' => RC_Uri::url('goods/merchant/init')))));
        }

        $info = RC_DB::table('products')->where('product_id', $product_id)->where('goods_id', $goods_id)->first();
        /* 商品图片路径 */
        if (!empty($info['product_img'])) {
            $info['product_img'] 	= goods_imageutils::getAbsoluteUrl($info['product_img']);
            $info['product_thumb'] 	= goods_imageutils::getAbsoluteUrl($info['product_thumb']);
            $info['product_original_img'] 	= goods_imageutils::getAbsoluteUrl($info['product_original_img']);
        }

        $this->assign('action_link', array('href' => RC_Uri::url('goods/merchant/edit_goods_specification', ['goods_id' => $goods_id]), 'text' => __('商品编辑', 'goods')));


        $this->assign('goods_name', 		sprintf(__('商品名称：%s', 'goods'), $goods['goods_name']));
        $this->assign('goods', $goods);
        $this->assign('info', $info);
        $this->assign('form_action', 		RC_Uri::url('goods/merchant/product_update'));

        $product = product_list($goods_id, '');
        $this->assign('product_list', $product['product']);

        return $this->display('product_edit.dwt');
    }

    public function product_update()
    {
        $this->admin_priv('goods_manage');

        $product_id = !empty($_POST['product_id']) ? intval($_POST['product_id']) : 0;
        $info = RC_DB::table('products')->where('product_id', $product_id)->first();
        $goods = RC_DB::table('goods')->where('goods_id', $info['goods_id'])->first();

        /* 检查货号是否重复 */
        if (trim($_POST['product_sn'])) {
            $count = RC_DB::table('products')->where('product_sn', trim($_POST['product_sn']))->where('product_id', '!=', $product_id)->count();
            if ($count > 0) {
                return $this->showmessage(__('您输入的货号已存在，请换一个', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }

        $upload = RC_Upload::uploader('image', array('save_path' => 'images', 'auto_sub_dirs' => true));
        $upload->add_saving_callback(function ($file, $filename) {
            return true;
        });

        /* 是否处理商品图 */
        $proc_goods_img = true;
        if (isset($_FILES['goods_img']) && !$upload->check_upload_file($_FILES['goods_img'])) {
            $proc_goods_img = false;
        }
//
        /* 是否处理缩略图 */
        $proc_thumb_img = isset($_FILES['thumb_img']) ? true : false;
        if (isset($_FILES['thumb_img']) && !$upload->check_upload_file($_FILES['thumb_img'])) {
            $proc_thumb_img = false;
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

        /* 处理商品图片 */
        $goods_img	 	= ''; // 初始化商品图片
        $goods_thumb 	= ''; // 初始化商品缩略图
        $img_original	= ''; // 初始化原始图片

        /* 处理商品数据 */
        $product_name 	= !empty($_POST['product_name']) 		? trim($_POST['product_name']) 				: '';
        $shop_price 	= $_POST['product_shop_price'] != '' 	? $_POST['product_shop_price'] 				: NULL;
        $product_sn     = !empty($_POST['product_sn'])          ? trim($_POST['product_sn'])                : '';

        $use_storage = ecjia::config('use_storage');
        $product_number = $_POST['product_number'] == ''  ? (empty($use_storage) ? 0 : ecjia::config('default_storage')) : intval($_POST['product_number']); //库存
        $product_bar_code = isset($_POST['product_bar_code']) 	? trim($_POST['product_bar_code']) 	: '';
        //货品号不为空
        if (!empty($product_sn)) {
            /* 检测：货品货号是否在商品表和货品表中重复 */
            if (check_goods_sn_exist($product_sn, $info['goods_id'])) {
                return $this->showmessage(__('货品号已存在，请修改', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if (check_product_sn_exist($product_sn, $product_id)) {
                return $this->showmessage(__('货品号已存在，请修改', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        } else {
            //货品号为空 自动补货品号
            $product_sn = $goods['goods_sn'] . "g_p" . $product_id;
        }

        /* 更新货品表 */
        $data = array(
            'product_name'				=> rc_stripslashes($product_name),
            'product_sn'			  	=> $product_sn,
            'product_shop_price'		=> $shop_price,
            'product_bar_code'		  	=> $product_bar_code,
            'product_number'		  	=> $product_number,
        );
        RC_DB::table('products')->where('product_id', $product_id)->update($data);

        /* 记录日志 */
        $log_object = $product_name;
        if(empty($log_object)) {
            $log_object = $goods['goods_name'];
        }
        ecjia_merchant::admin_log($log_object, 'edit', 'product');
        //为更新用户购物车数据加标记
        RC_Api::api('cart', 'mark_cart_goods', array('product_id' => $product_id));


        /* 更新上传后的商品图片 */
        if ($proc_goods_img) {
            if (isset($image_info)) {
                $goods_image = new product_image_data($image_info['name'], $image_info['tmpname'], $image_info['ext'], $info['goods_id'], $product_id);
                if ($proc_thumb_img) {
                    $goods_image->set_auto_thumb(false);
                }

                $result = $goods_image->update_goods();
                if (is_ecjia_error($result)) {
                    return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            }
        }

        /* 更新上传后的缩略图片 */
        if ($proc_thumb_img) {
            if (isset($thumb_info)) {
                $thumb_image = new product_image_data($thumb_info['name'], $thumb_info['tmpname'], $thumb_info['ext'], $info['goods_id'], $product_id);
                $result = $thumb_image->update_thumb();
                if (is_ecjia_error($result)) {
                    return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            }
        }

        $pjaxurl = RC_Uri::url('goods/merchant/product_edit', "id=$product_id&goods_id=".$info['goods_id']);
        return $this->showmessage(__('编辑货品成功', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $pjaxurl));

    }
    /**
     * 货品编辑
     */
    public function product_desc_edit()
    {
        $this->admin_priv('goods_manage');

        $goods_id = intval($_GET['goods_id']);
        $product_id = intval($_GET['id']);
        ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品列表', 'goods'), RC_Uri::url('goods/merchant/init')));
        ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品编辑', 'goods'), RC_Uri::url('goods/merchant/edit', ['goods_id' => $goods_id])));
        $ur_here = __('编辑货品（SKU）', 'goods');
        $this->assign('ur_here', $ur_here);

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($ur_here));


        $db_goods = RC_DB::table('goods')->where('goods_id', $goods_id)->where('store_id', $_SESSION['store_id']);

        //获取商品的信息
        $goods = $db_goods->select('goods_sn', 'goods_name', 'goods_type', 'shop_price')->first();
        if (empty($goods)) {
            return $this->showmessage(__('未检测到此商品', 'goods'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('返回商品列表', 'goods'), 'href' => RC_Uri::url('goods/merchant/init')))));
        }

        $info = RC_DB::table('products')->where('product_id', $product_id)->where('goods_id', $goods_id)->first();
        if (empty($info)) {
            return $this->showmessage(__('未检测到此货品', 'goods'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('返回商品列表', 'goods'), 'href' => RC_Uri::url('goods/merchant/init')))));
        }

        $this->assign('action_link', array('href' => RC_Uri::url('goods/merchant/product_list', ['goods_id' => $goods_id]), 'text' => __('商品编辑', 'goods')));


        $this->assign('goods_name', 		sprintf(__('商品名称：%s', 'goods'), $goods['goods_name']));
        $this->assign('goods', $goods);
        $this->assign('nav_tag', 'desc');


        if (!empty($info['product_desc'])) {
            $info['product_desc'] = stripslashes($info['product_desc']);
        }
        $this->assign('info', $info);
        $this->assign('goods_id', $goods_id);
        $this->assign('form_action', RC_Uri::url('goods/merchant/product_desc_update', 'goods_id='.$goods_id.'&id='.$product_id));

        $product = product_list($goods_id, '');
        $this->assign('product_list', $product['product']);

        return $this->display('product_desc.dwt');
    }
    /**
     * 货品描述更新
     */
    public function product_desc_update() {
        $this->admin_priv('goods_update', ecjia::MSGTYPE_JSON); // 检查权限


        $goods_id 	= !empty($_GET['goods_id'])		? intval($_GET['goods_id']) : 0;
        $product_id 	= !empty($_GET['id'])		? intval($_GET['id']) : 0;

        $db_goods = RC_DB::table('goods')->where('goods_id', $goods_id)->where('store_id', $_SESSION['store_id']);

        //获取商品的信息
        $goods = $db_goods->select('goods_sn', 'goods_name', 'goods_type', 'shop_price')->first();
        if (empty($goods)) {
            return $this->showmessage(__('未检测到此商品', 'goods'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('返回商品列表', 'goods'), 'href' => RC_Uri::url('goods/merchant/init')))));
        }

        $info = RC_DB::table('products')->where('product_id', $product_id)->where('goods_id', $goods_id)->first();
        if (empty($info)) {
            return $this->showmessage(__('未检测到此货品', 'goods'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('返回商品列表', 'goods'), 'href' => RC_Uri::url('goods/merchant/init')))));
        }

        $data = array(
            'product_desc'  => !empty($_POST['product_desc']) ? $_POST['product_desc'] : '',
        );
        RC_DB::table('products')->where('product_id', $product_id)->where('goods_id', $goods_id)->update($data);

        /* 记录日志 */
        $log_object = $info['product_name'];
        if(empty($log_object)) {
            $log_object = $goods['goods_name'];
        }
        ecjia_merchant::admin_log($log_object, 'edit', 'product');

        /* 提示页面 */

        $arr['goods_id'] = $goods_id;
        $arr['id'] = $product_id;
        $message = __('编辑成功', 'goods');
        $url = RC_Uri::url('goods/merchant/product_desc_edit', $arr);
        return $this->showmessage($message, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url, 'goods_id' => $goods_id,'id' => $product_id));
    }

	/**
	* 编辑货品
	*/
	public function product_add_execute() {
		$this->admin_priv('goods_manage', ecjia::MSGTYPE_JSON);

		$product['goods_id'] 		= $_POST['goods_id'];
		$product['attr'] 		    = !empty($_POST['attr'])           	? $_POST['attr']          	: '';
		$product['product_sn'] 		= !empty($_POST['product_sn'])    	? $_POST['product_sn']    	: '';
		$product['product_number'] 	= !empty($_POST['product_number'])	? $_POST['product_number']	: '';
		$code 						= !empty($_GET['extension_code'])	? 'virtual_card'           	: '';
		$step 						= isset($_POST['step'])  			? trim($_POST['step']) 		: '';
		
		/* 是否存在商品id */
		if (empty($product['goods_id'])) {
		    return $this->showmessage(__('找不到指定的商品', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		/* 判断是否为初次添加 */
		$insert = true;
		if (product_number_count($product['goods_id']) > 0) {
		    $insert = false;
		}
		/* 取出商品信息 */
		$goods = RC_DB::table('goods')->where('goods_id', $product['goods_id'])->select('goods_sn', 'goods_name', 'goods_type', 'shop_price')->first();
		
		if (empty($goods)) {
		    return $this->showmessage(__('找不到指定的商品', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		if (!empty($product['product_sn'])) {
    		foreach($product['product_sn'] as $key => $value) {
    		    //过滤
    		    $use_storage = ecjia::config('use_storage');
    		    $product['product_number'][$key] = empty($product['product_number'][$key]) ? (empty($use_storage) ? 0 : ecjia::config('default_storage')) : trim($product['product_number'][$key]); //库存
    		    
    		    //获取规格在商品属性表中的id
    		    foreach($product['attr'] as $attr_key => $attr_value) {
    		        /* 检测：如果当前所添加的货品规格存在空值或0 */
    		        if (empty($attr_value[$key])) {
    		            continue 2;
    		        }
    		        $is_spec_list[$attr_key] = 'true';
    		        $value_price_list[$attr_key] = $attr_value[$key] . chr(9) . ''; //$key，当前
    		        $id_list[$attr_key] = $attr_key;
    		    }
    		    $goods_attr_id = handle_goods_attr($product['goods_id'], $id_list, $is_spec_list, $value_price_list);
    			
    		    //排序
    		    sort($goods_attr_id);
    		    /* 是否为重复规格的货品 */
    		    $goods_attr = sort_goods_attr_id_array($goods_attr_id);
    		    $goods_attr = implode('|', $goods_attr['sort']);
    		    if (check_goods_attr_exist($goods_attr, $product['goods_id'])) {
    		        continue;
    		    }
    		    //货品号不为空
    		    if (!empty($value)) {
    		        /* 检测：货品货号是否在商品表和货品表中重复 */
    		        if (check_goods_sn_exist($value)) {
    		            continue;
    		        }
    		        if (check_product_sn_exist($value)) {
    		            continue;
    		        }
    		    }
    		    
    		    /* 插入货品表 */
    		    $data = array(
    		        'goods_id' 			=> $product['goods_id'],
    		        'goods_attr'		=> $goods_attr,
    		        'product_sn' 		=> $value,
    		        'product_number' 	=> $product['product_number'][$key]
    		    );
    		    $product_id = RC_DB::table('products')->insertGetId($data);
    		
    		    //货品号为空 自动补货品号
    		    if (empty($value)) {
    		        $data = array('product_sn' => $goods['goods_sn'] . "g_p" . $product_id);
    		        RC_DB::table('products')->where('product_id', $product_id)->update($data);
    		    }
    		
    		    /* 修改商品表库存 */
    		    $product_count = product_number_count($product['goods_id']);
    		    $goods_id = explode(',', $product['goods_id']);
    		    if (update_goods($goods_id, 'goods_number', $product_count)) {
    		        //记录日志
    		        ecjia_merchant::admin_log($product['goods_id'], 'update', 'goods');
    		    }
    		}
		}
		
		if ($step) {
			$message = __('添加商品成功', 'goods');
			if ($code) {
				$arr['pjaxurl'] = RC_Uri::url('goods/merchant/edit', array('goods_id' => $product['goods_id'], 'extension_code' => $code));
			} else {
				$arr['pjaxurl'] = RC_Uri::url('goods/merchant/edit', array('goods_id' => $product['goods_id']));
			}
		} else {
			if ($code) {
				$arr['pjaxurl'] = RC_Uri::url('goods/merchant/product_list', array('goods_id' => $product['goods_id'], 'extension_code' => $code));
			} else {
				$arr['pjaxurl'] = RC_Uri::url('goods/merchant/product_list', array('goods_id' => $product['goods_id']));
			}
			$message = __('保存货品成功', 'goods');
		}
		return $this->showmessage($message, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, $arr);
    }

	/**
	 * 货品排序、分页、查询
	 */
	public function product_query() {
		$this->admin_priv('goods_manage', ecjia::MSGTYPE_JSON);
		
		/* 是否存在商品id */
		if (empty($_REQUEST['goods_id'])) {
			return $this->showmessage(__('货品id为空', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$goods_id = intval($_REQUEST['goods_id']);
		}

		/* 取出商品信息 */
		$goods = RC_DB::table('goods')->select(RC_DB::raw('goods_sn, goods_name, goods_type, shop_price'))->where('goods_id', $goods_id)->first();
		
		if (empty($goods)) {
			return $this->showmessage(__('错误', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$this->assign('sn', sprintf(__('（商品货号：%s）', 'goods'), $goods['goods_sn']));
		$this->assign('price', sprintf(__('（商品价格：%d）', 'goods'), $goods['shop_price']));
		$this->assign('goods_name', sprintf(__('商品名称：%s', 'goods'), $goods['goods_name']));
		$this->assign('goods_sn', sprintf(__('货号：%s', 'goods'), $goods['goods_sn']));

		/* 获取商品规格列表 */
		$attribute = get_goods_specifications_list($goods_id);
		if (empty($attribute)) {
			return $this->showmessage(__('错误', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		foreach ($attribute as $attribute_value) {
			//转换成数组
			$_attribute[$attribute_value['attr_id']]['attr_values'][] = $attribute_value['attr_value'];
			$_attribute[$attribute_value['attr_id']]['attr_id'] = $attribute_value['attr_id'];
			$_attribute[$attribute_value['attr_id']]['attr_name'] = $attribute_value['attr_name'];
		}
		$attribute_count = count($_attribute);

		$this->assign('attribute_count', $attribute_count);
		$this->assign('attribute', $_attribute);
		$this->assign('attribute_count_3', ($attribute_count + 3));
		$this->assign('product_sn', $goods['goods_sn'] . '_');
		$this->assign('product_number', ecjia::config('default_storage'));

		/* 取商品的货品 */
		$product = product_list($goods_id, '');

		$this->assign('ur_here', __('货品列表', 'goods'));
		$this->assign('action_link', array('href' => RC_Uri::url('goods/merchant/init'), 'text' => __('商品列表', 'goods')));
		$this->assign('product_list', $product['product']);
		$use_storage = ecjia::config('use_storage');
		$this->assign('use_storage', empty($use_storage) ? 0 : 1);
		$this->assign('goods_id', $goods_id);
		$this->assign('filter', $product['filter']);

		/* 排序标记 */
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $this->fetch('product_info')));
	}
	
	/**
	 * 货品删除
	 */
	public function product_remove() {
		$this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);
	
		$product_id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
		$product = get_product_info($product_id, 'product_number, goods_id');

        $image_data = new product_image_data('', '', '', 0, $product_id);
        $image_data->delete_images();
		$result = RC_DB::table('products')->where('product_id', $product_id)->delete();
		if ($result) {
            $image_data->delete_gallery();
            RC_DB::table('goods_gallery')->where('product_id', $product_id)->delete();
			/* 修改商品库存 */
			if (update_goods_stock($product['goods_id'], -$product['product_number'])) {
				//记录日志
				ecjia_merchant::admin_log('', 'edit', 'goods');
			}
			//记录日志
			ecjia_merchant::admin_log('', 'trash', 'products');
		}
		return $this->showmessage(__('删除成功！', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}

	/**
	 * 修改货品价格
	 */
	public function edit_product_sn() {
		$this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);
		
		$product_id = intval($_POST['pk']);
		$product_sn = trim($_POST['value']);
		$product_sn = ('N/A' == $product_sn) ? '' : $product_sn;
		
		if (check_product_sn_exist($product_sn, $product_id)) {
			return $this->showmessage(__('货品货号重复', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		/* 修改 */
		$data = array(
			'product_sn' => $product_sn,
		);
		$result = $this->db_products->where(array('product_id' => $product_id))->update($data);
		if ($result) {
			return $this->showmessage(__('货品价格修改成功！', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $product_sn));
		}
	}

	/**
	 * 修改货品库存
	 */
	public function edit_product_number() {
		$this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);

		$product_id = intval($_POST['pk']);
		$product_number = trim($_POST['value']);
		/* 货品库存 */
		$product = get_product_info($product_id, 'product_number, goods_id');

		/* 修改货品库存 */
		$data = array(
			'product_number' => $product_number
		);
		$result = $this->db_products->where(array('product_id' => $product_id))->update($data);
		if ($result) {
			/* 修改商品库存 */
			if (update_goods_stock($product['goods_id'], $product_number - $product['product_number'])) {
				return $this->showmessage(__('修改成功', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $product_number));
			}
		}
	}

	/**
	* 货品批量操作
	*/
	public function batch_product() {
       $this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);
       
		/* 定义返回 */
		$link[] = array('href' => RC_Uri::url('goods/merchant/product_list', 'goods_id=' . $_POST['goods_id']), 'text' => __('货品列表', 'goods'));
		/* 批量操作 - 批量删除 */
		if ($_POST['type'] == 'drop') {
	       //取得要操作的商品编号
			$product_id = !empty($_POST['checkboxes']) ? join(',', $_POST['checkboxes']) : 0;
	       //取出货品库存总数
			$sum = 0;
			$goods_id = 0;
			$product_array = $this->db_products->field('product_id, goods_id, product_number')->in(array('product_id' => $product_id))->select();

			if (!empty($product_array)) {
				foreach ($product_array as $value) {
					$sum += $value['product_number'];
				}
				$goods_id = $product_array[0]['goods_id'];

				/* 删除货品 */
				$query = $this->db_products->in(array('product_id ' => $product_id))->delete();
				if ($query) {
	               //记录日志
					ecjia_merchant::admin_log('', 'delete', 'products');
				}

				/* 修改商品库存 */
				if (update_goods_stock($goods_id, -$sum)) {
	               //记录日志
					ecjia_merchant::admin_log('', 'update', 'goods');
				}
				/* 返回 */
				return $this->showmessage(__('货品批量删除成功', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $link));
			} else {
				return $this->showmessage(__('未找到指定货品', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('links' => $link));
			}
		}
		return $this->showmessage(__('无此操作', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('links' => $link));
	}

	/**
	 * 商品描述编辑页面
	 */
	public function edit_goods_desc() {
	    $this->admin_priv('goods_update');
	    
	    $action_type = trim($_GET['action_type']);
	    $href_url = Ecjia\App\Goods\MerchantGoodsAttr::goods_back_goods_url($action_type);
	    
	    ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品列表', 'goods'), $href_url));
	    $this->assign('action_link', array('href' => $href_url, 'text' => __('商品列表', 'goods')));
	    $this->assign('ur_here',__('编辑商品描述', 'goods'));
	    
		$goods_id = intval($_REQUEST['goods_id']);
		$goods = RC_DB::table('goods')->where('goods_id', $goods_id)->where('store_id', $_SESSION['store_id'])->first();
		
		if (empty($goods) === true) {
			return $this->showmessage(sprintf(__('找不到ID为 %s 的商品！', 'goods'), $goods_id), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('返回商品列表', 'goods'), 'href' => RC_Uri::url('goods/merchant/init')))));
		}
		if (!empty($goods['goods_desc'])) {
			$goods['goods_desc'] = stripslashes($goods['goods_desc']);
		}

		//设置选中状态,并分配标签导航
		$this->tags['edit_goods_desc']['active'] = 1;
		$this->assign('tags', $this->tags);

		$this->assign('goods', $goods);
		$this->assign('goods_id', $goods_id);
		$this->assign('form_action', RC_Uri::url('goods/merchant/update_goods_desc', 'goods_id='.$goods_id));
		
		if (isset($_GET['step'])) {
			$this->assign('step', 3);
			$ur_here = __('添加商品描述', 'goods');
		} else {
			$ur_here = __('编辑商品描述', 'goods');
		}
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($ur_here));
		$this->assign('ur_here', $ur_here);
		
		return $this->display('goods_desc.dwt');
	}

	/**
	 * 商品描述更新
	 */
	public function update_goods_desc() {
		$this->admin_priv('goods_update', ecjia::MSGTYPE_JSON); // 检查权限
		
	    $step = !empty($_POST['step']) ? trim($_POST['step']) : '';

		$goods_type = isset($_POST['goods_type']) 	? $_POST['goods_type'] 		: 0;
		$goods_id 	= !empty($_GET['goods_id'])		? intval($_GET['goods_id']) : 0;
        $code = '';

		$goods = $this->db_goods->goods_find(array('goods_id' => $goods_id));

		if (empty($goods) === true) {
			return $this->showmessage(sprintf(__('找不到ID为 %s 的商品！', 'goods'), $goods_id), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		$data = array(
			'goods_desc'  => !empty($_POST['goods_desc']) ? $_POST['goods_desc'] : '',
		  	'last_update' => RC_Time::gmtime(),
		);
		$this->db_goods->goods_update(array('goods_id' => $goods_id), $data);

		/* 记录日志 */
		ecjia_merchant::admin_log($goods['goods_name'], 'edit', 'goods');

		/* 提示页面 */
		$link = array();
//		if ($code == 'virtual_card') {
//		  	$link[1] = array('href' => RC_Uri::url('goods/admin_virtual_card/replenish', 'goods_id=' . $goods_id), 'text' => __('添加虚拟卡卡密', 'goods'));
//		}
		$link[3] = list_link($code);
		for ($i = 0; $i < count($link); $i++) {
		  	$key_array[] = $i;
		}
		krsort($link);
		$link = array_combine($key_array, $link);
		
		$arr['goods_id'] = $goods_id;
		if ($step) {
			$arr['step'] = 'photo';
			$message = '';
			$url = RC_Uri::url('goods/mh_gallery/init', $arr);
		} else {
			$message = __('编辑属性成功', 'goods');
			$url = RC_Uri::url('goods/merchant/edit_goods_desc', $arr);
		}
		return $this->showmessage($message, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url, 'goods_id' => $goods_id));
	}
	
	/**
	 * 商品参数页面
	 */
	public function edit_goods_parameter() {
		$this->admin_priv('goods_update');
		
		$this->assign('tags', $this->tags);
		
		$action_type = trim($_GET['action_type']);
		$href_url = Ecjia\App\Goods\MerchantGoodsAttr::goods_back_goods_url($action_type);
		
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品列表', 'goods'), $href_url));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('设置商品参数', 'goods')));
		
		$this->assign('ur_here', __('设置商品参数', 'goods'));
		$this->assign('action_link', array('href' => $href_url, 'text' => __('商品列表', 'goods')));
		
		$goods_id = intval($_GET['goods_id']);
		$this->assign('goods_id', $goods_id);
		
		$goods_info = RC_DB::table('goods')->where('goods_id', $goods_id)->where('store_id', $_SESSION['store_id'])->first();
		if (empty($goods_info)) {
			return $this->showmessage(__('未检测到此商品', 'goods'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('返回商品列表', 'goods'), 'href' => RC_Uri::url('goods/merchant/init')))));
		}
		$this->assign('goods_info', $goods_info);
		
		if(!empty($goods_info['parameter_id'])) {
			$template_id = $goods_info['parameter_id'];
		} else {
			$template_id = Ecjia\App\Goods\MerchantGoodsAttr::get_cat_template('parameter', $goods_info['merchant_cat_id']);
			if(empty($template_id)) {
				$template_id = Ecjia\App\Goods\GoodsAttr::get_cat_template('parameter', $goods_info['cat_id']);
			}
		}
		$this->assign('template_id', $template_id);
		
		if ($template_id) {
			$this->assign('has_template', 'has_template');
			
			$template_info = Ecjia\App\Goods\MerchantGoodsAttr::get_template_info($template_id);
			$this->assign('template_info', $template_info);
			
			$this->assign('goods_attr_html', Ecjia\App\Goods\MerchantGoodsAttr::build_parameter_html($template_id, $goods_id));
		}

		$this->assign('form_action', RC_Uri::url('goods/merchant/update_goods_parameter', array('goods_id' => $goods_id)));
	
		return $this->display('goods_parameter.dwt');
	}
	
	/**
	 * 更新商品参数逻辑处理
	 */
	public function update_goods_parameter() {
		$this->admin_priv('goods_update');
		 
		$goods_type = !empty($_POST['template_id'])	 ? intval($_POST['template_id'])  : 0;
		$goods_id 	= !empty($_POST['goods_id'])     ? intval($_POST['goods_id'])     : 0;
	
		$attr_id_list = $this->request->input('attr_id_list');
		$input_all = $this->request->input();
		
		if (!empty($attr_id_list)) {
			$attr_id_list = collect($attr_id_list)->mapWithKeys(function ($attr_id) use ($input_all) {
				$vkey = $attr_id . '_attr_value_list';
				$vvalue = array_get($input_all, $vkey);
				return [$attr_id => $vvalue];
			});
			
			$updateGoodsAttr = function ($goods_id, $attr_id_list) {
				$collection = GoodsAttrModel::where('cat_type', 'parameter')->where('goods_id', $goods_id)->get();
				$collection = $collection->groupBy('attr_id');
				$attr_id_list->map(function($id_values, $key) use ($collection, $goods_id) {
					$new_collection = $collection->get($key);
					
					if (is_null($id_values)) {
						if (!empty($new_collection)) {
							$new_collection->map(function($model){
								$model->delete();
							});
						}
					} elseif (is_array($id_values)) {
						if (!empty($new_collection)) {
							$new_collection->map(function($model) use ($id_values) {
								if (!in_array($model->attr_value, $id_values) ) {
									$model->delete();
								}
									
							});
							$old_values = $new_collection->pluck('attr_value')->all();
							$new_values = collect($id_values)->diff($old_values);
						} else {
							$new_values = $id_values;
						}
						foreach ($new_values as $v) {
							GoodsAttrModel::insert([
								'cat_type' => 'parameter',
								'goods_id' => $goods_id,
								'attr_id' => $key,
								'attr_value' => $v,
							]);
						}
					} else {
						if (!empty($new_collection)) {
							$new_collection->map(function($model) use ($id_values) {
								$model->attr_value = $id_values;
								$model->save();
							});
						} else {
							GoodsAttrModel::insert([
								'cat_type' => 'parameter',
								'goods_id' => $goods_id,
								'attr_id' => $key,
								'attr_value' => $id_values,
							]);
						}
					}
				});
			};
			
			$updateGoodsAttr($goods_id, $attr_id_list);
			
			$data = array(
				 'parameter_id' => $goods_type,
			);
			RC_DB::table('goods')->where('goods_id', $goods_id)->update($data);
						
			$pjaxurl = RC_Uri::url('goods/merchant/edit_goods_parameter', array('goods_id' => $goods_id));
			return $this->showmessage(__('编辑商品参数成功', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $pjaxurl));
		}
	}

	/**
	 * 更换参数模板需要清除数据
	 */
	public function clear_parameter_data() {
		$this->admin_priv('goods_update');
	
		$goods_id = intval($_POST['goods_id']);
		
		//清除商品关联的模板id为0
		RC_DB::table('goods')->where('goods_id', $goods_id)->update(array('parameter_id' => 0));
			
		//删除关联的规格属性
		RC_DB::table('goods_attr')->where(array('goods_id' => $goods_id))->where(array('cat_type' => 'parameter'))->delete();
		
		return $this->showmessage(__('清除相关数据成功，您可以重新进行更换参数模板', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('goods/merchant/edit_goods_parameter', array('goods_id' => $goods_id))));
		
	}
	
   /**
     * 设置规格页面
     */
	public function edit_goods_specification() {
		$this->admin_priv('goods_update');
		
		$this->assign('tags', $this->tags);
		
		$action_type = trim($_GET['action_type']);
		$href_url = Ecjia\App\Goods\MerchantGoodsAttr::goods_back_goods_url($action_type);
		
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品列表', 'goods'), $href_url));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('设置商品规格', 'goods')));
		
		$this->assign('ur_here', __('设置商品属性', 'goods'));
		$this->assign('action_link', array('href' => $href_url, 'text' => __('商品列表', 'goods')));
		
		$goods_id = intval($_GET['goods_id']);
		$this->assign('goods_id', $goods_id);
		
		$goods_info = RC_DB::table('goods')->where('goods_id', $goods_id)->where('store_id', $_SESSION['store_id'])->first();
		if (empty($goods_info)) {
			return $this->showmessage(__('未检测到此商品', 'goods'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('返回商品列表', 'goods'), 'href' => RC_Uri::url('goods/merchant/init')))));
		}
		$this->assign('goods_info', $goods_info);
		
		if(!empty($goods_info['specification_id'])) {
			$template_id = $goods_info['specification_id'];
		} else {
			$template_id = Ecjia\App\Goods\MerchantGoodsAttr::get_cat_template('specification', $goods_info['merchant_cat_id']);
			if(empty($template_id)) {
				$template_id = Ecjia\App\Goods\GoodsAttr::get_cat_template('specification', $goods_info['cat_id']);
			}
		}
		$this->assign('template_id', $template_id);
		
		if ($template_id) {
			$this->assign('has_template', 'has_template');
				
			$template_info = Ecjia\App\Goods\MerchantGoodsAttr::get_template_info($template_id);
			$this->assign('template_info', $template_info);
			
			$this->assign('goods_attr_html', Ecjia\App\Goods\MerchantGoodsAttr::build_specification_html($template_id, $goods_id));
		}
		
		$count = RC_DB::table('goods_attr')->where('goods_id', $goods_id)->where('cat_type', 'specification')->count();
		if ($count > 0) {
			$this->assign('has_spec', 'has_spec');
		}
		
		$product = Ecjia\App\Goods\MerchantGoodsAttr::product_list($goods_id, '');
		$this->assign('product_list', $product['product']);
		
		$this->assign('form_action', RC_Uri::url('goods/merchant/update_goods_specification', array('goods_id' => $goods_id)));
		
		return $this->display('goods_specification.dwt');
		
	}
	
	/**
     * 更新商品规格逻辑处理
     */
	public function update_goods_specification() {
		$this->admin_priv('goods_update');
			
		$goods_type     = !empty($_POST['template_id'])	   ? intval($_POST['template_id'])   : 0;
		$goods_id 	    = !empty($_POST['goods_id'])       ? intval($_POST['goods_id'])      : 0;
		
		$data = array(
			 'specification_id'  => $goods_type,
		);
		RC_DB::table('goods')->where('goods_id', $goods_id)->update($data);
		$product['product_id']         = $_POST['product_id'];
		$product['product_bar_code']   = $_POST['product_bar_code'];
		$product['product_shop_price'] = $_POST['product_shop_price'];
		$product['product_number']     = $_POST['product_number'];

		if (!empty($product['product_id'])) {
			$use_storage = ecjia::config('use_storage');
			foreach($product['product_id'] as $key => $value) {
				$product['product_bar_code'][$key]   = empty($product['product_bar_code'][$key]) ? ''   : trim($product['product_bar_code'][$key]); 
				$product['product_shop_price'][$key] = empty($product['product_shop_price'][$key]) ?  : trim($product['product_shop_price'][$key]); 
				$product['product_number'][$key]     = empty($product['product_number'][$key]) ? (empty($use_storage) ? 0 : ecjia::config('default_storage')) : trim($product['product_number'][$key]); 
				
				$data = array(
					'product_bar_code' 	=> $product['product_bar_code'][$key],
					'product_shop_price'=> $product['product_shop_price'][$key],
					'product_number' 	=> $product['product_number'][$key]
				);
				RC_DB::table('products')->where('product_id', $value)->update($data);
			}
		}

		$pjaxurl = RC_Uri::url('goods/merchant/edit_goods_specification', array('goods_id' => $goods_id));
		return $this->showmessage(__('设置商品规格成功', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $pjaxurl));
	}
	
	
	/**
	 * 商品规格属性返回值-多选
	 */
	public function select_spec_values() {
		$this->admin_priv('goods_update');
		
		$goods_id = intval($_POST['goods_id']);
		$this->assign('goods_id', $goods_id);
				
		$goods_info = RC_DB::TABLE('goods')->where('goods_id', $goods_id)->select('specification_id', 'merchant_cat_id')->first();		
		if(!empty($goods_info['specification_id'])) {
			$template_id = $goods_info['specification_id'];
		} else {
			$template_id = Ecjia\App\Goods\MerchantGoodsAttr::get_cat_template('specification', $goods_info['merchant_cat_id']);
		}
		if ($template_id) {
			$this->assign('template_id', $template_id);
			$this->assign('goods_attr_html', Ecjia\App\Goods\MerchantGoodsAttr::build_specification_html($template_id, $goods_id));
		}
		$count = RC_DB::table('products')->where('goods_id', $goods_id)->count();
		if ($count > 0) {
			$this->assign('has_product', 'has_product');
		}
		$data = $this->fetch('select_spec_values.dwt');
		
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('data' => $data));
	}
	
	/**
	 * 设置属性值处理
	 */
	public function select_spec_values_insert() {
		$this->admin_priv('goods_update');
		
		$goods_id 	= !empty($_POST['goods_id'])     ? intval($_POST['goods_id'])     : 0;
		
		$template_id = intval($_POST['template_id']);
		RC_DB::table('goods')->where('goods_id', $goods_id)->update(array('specification_id'  => $template_id));
		
		$attr_id_list = $this->request->input('attr_id_list');
		$input_all    = $this->request->input();
		
		if (!empty($attr_id_list)) {
			$attr_id_list = collect($attr_id_list)->mapWithKeys(function ($attr_id) use ($input_all) {
				$vkey = $attr_id . '_attr_value_list';
				$vvalue = array_get($input_all, $vkey);
				return [$attr_id => $vvalue];
			});
			
			$updateGoodsAttr = function ($goods_id, $attr_id_list) {
				$collection = GoodsAttrModel::where('cat_type', 'specification')->where('goods_id', $goods_id)->get();
				$collection = $collection->groupBy('attr_id');
				$attr_id_list->map(function($id_values, $key) use ($collection, $goods_id) {
					$new_collection = $collection->get($key);
					if (!empty($new_collection)) {
						$new_collection->map(function($model) use ($id_values) {
							if (!in_array($model->attr_value, $id_values) ) {
								$model->delete();
							}
								
						});
						$old_values = $new_collection->pluck('attr_value')->all();
						$new_values = collect($id_values)->diff($old_values);
					}
					else {
						$new_values = $id_values;
					}
				
					//添加新增的
					foreach ($new_values as $v) {
						GoodsAttrModel::insert([
							'cat_type'   => 'specification',
							'goods_id'   => $goods_id,
							'attr_id'    => $key,
							'attr_value' => $v,
						]);
					}
					
				});
			};
			
			$updateGoodsAttr($goods_id, $attr_id_list);
			
		    return $this->showmessage(__('选择规格属性成功', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('goods/merchant/edit_goods_specification', array('goods_id' => $goods_id))));
		}
	}
	
	
	/**
	 * 添加货品-规格属性 单选
	 */
	public function spec_add_product() {
		$this->admin_priv('goods_update');
	
		$goods_id = intval($_POST['goods_id']);
		$this->assign('goods_id', $goods_id);

		$attribute = Ecjia\App\Goods\MerchantGoodsAttr::get_goods_spec_list($goods_id);
		$spec_attribute_list = array();
		if (!empty($attribute)) {
			foreach ($attribute as $attribute_value) {
				$spec_attribute_list[$attribute_value['attr_id']]['attr_id'] = $attribute_value['attr_id'];
				$spec_attribute_list[$attribute_value['attr_id']]['attr_name'] = $attribute_value['attr_name'];
				$spec_attribute_list[$attribute_value['attr_id']]['attr_values'][$attribute_value['goods_attr_id']] = $attribute_value['attr_value'];
			}
		}
		$this->assign('spec_attribute_list', $spec_attribute_list);
		
		$product_value = array();
		foreach ($spec_attribute_list as $value) {
			$attr_values = key($value['attr_values']);
			array_push($product_value, $attr_values);
		}
		
		$goods_attr = implode('|', $product_value);
		$product_sn = RC_DB::TABLE('products')->where('goods_attr', $goods_attr)->pluck('product_sn');
		$data = $this->fetch('spec_add_product.dwt');
		
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('data' => $data, 'product_sn' => $product_sn));
	}
	
	/**
	 * 添加货品处理
	 */
	public function spec_add_product_insert() {
		$this->admin_priv('goods_update');
		
		$goods_id = intval($_POST['goods_id']);
		$product_value = $_POST['radio_value_arr'];
	
		if (empty($goods_id)) {
			return $this->showmessage(__('找不到指定的商品', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} 
		
		$goods = RC_DB::table('goods')->where('goods_id', $goods_id)->select('goods_sn', 'goods_number', 'goods_name', 'goods_type', 'shop_price')->first();
		$goods_attr = implode('|', $product_value);
		if (Ecjia\App\Goods\MerchantGoodsAttr::check_goods_attr_exist($goods_attr, $goods_id)) {
			return $this->showmessage(__('所匹配的属性已存在相应的货品,请更换组合', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$data = array(
				'goods_id' 		=> $goods_id,
				'goods_attr'	=> $goods_attr,
				'product_number'=> $goods['goods_number'],
			);
			$product_id = RC_DB::table('products')->insertGetId($data);
			RC_DB::table('products')->where('product_id', $product_id)->update(array('product_sn' => $goods['goods_sn'] . "g_p" . $product_id));
			$product_sn = RC_DB::TABLE('products')->where('product_id', $product_id)->pluck('product_sn');
			if($product_sn) {
				return $this->showmessage(__('添加货品成功', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('product_sn' => $product_sn));
			} else {
				return $this->showmessage(__('添加货品失败', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('product_sn' => $product_sn));
			}
			
		}
	}

	/**
	 * 移除货品处理
	 */
	public function spec_del_product() {
		$this->admin_priv('goods_update');
	
		$goods_id = intval($_POST['goods_id']);
		$product_value = $_POST['radio_value_arr'];
	
		if (empty($goods_id)) {
			return $this->showmessage(__('找不到指定的商品', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$goods_attr = implode('|', $product_value);
		
		if(RC_DB::table('products')->where('goods_id', $goods_id)->where('goods_attr', $goods_attr)->delete()) {
			return $this->showmessage(__('移除货品成功', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else{
			return $this->showmessage(__('移除货品失败', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} 
	}

	/**
	 * 切换radio获取货号
	 */
	public function ajax_select_radio() {
		$this->admin_priv('goods_update');
	
		$goods_id 		= intval($_POST['goods_id']);
		$product_value  = !empty($_POST['radio_value_arr']) ? $_POST['radio_value_arr']   : '';
	
		if (empty($goods_id)) {
			return $this->showmessage(__('找不到指定的商品', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$goods_attr = implode('|', $product_value);
		$product_sn = RC_DB::TABLE('products')->where('goods_attr', $goods_attr)->pluck('product_sn');
		
		if(!empty($product_sn)) {
			return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('product_sn' => $product_sn));
		}
	}
	
	
	/**
	 * 更换模板需要清除数据（规格、货品、商品关联模板id）
	 */
	public function clear_spec_data() {
		$this->admin_priv('goods_update');
		
		$goods_id = intval($_POST['goods_id']);
		$product_list = RC_DB::TABLE('products')->where('goods_id', $goods_id)->lists('product_id');
		
		$count = 0;
		if(count($product_list) > 0) {
			$count = RC_DB::TABLE('order_goods')->whereIn('product_id', $product_list)->count();
		}
	
		if($count > 0) {
			return $this->showmessage(__('该规格模板下的货品以及产品了订单交易，不可以更改规格模板', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('goods/merchant/edit_goods_specification', array('goods_id' => $goods_id))));
		} else {
 			//清除商品关联的模板id为0
			RC_DB::table('goods')->where('goods_id', $goods_id)->update(array('specification_id' => 0));
			
 			//删除关联的规格属性
			RC_DB::table('goods_attr')->where(array('goods_id' => $goods_id))->where(array('cat_type' => 'specification'))->delete();
			
			//删除货品相关
			foreach($product_list as $value) {
				$product = get_product_info($value, 'product_number, goods_id');
				$image_data = new product_image_data('', '', '', 0, $value);
				$image_data->delete_images();
				$result = RC_DB::table('products')->where('product_id', $value)->delete();
				if ($result) {
					$image_data->delete_gallery();
					RC_DB::table('goods_gallery')->where('product_id', $value)->delete();
					if (update_goods_stock($product['goods_id'], -$product['product_number'])) {
						ecjia_merchant::admin_log('', 'edit', 'goods');
					}
					ecjia_merchant::admin_log('', 'trash', 'products');
				}
			}
		    return $this->showmessage(__('清除相关数据成功，您可以重新进行更换规格模板', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('goods/merchant/edit_goods_specification', array('goods_id' => $goods_id))));
		    
		}
	}

	/**
	* 商品属性
	*/
	public function edit_goods_attr() {
	    $this->admin_priv('goods_update');
	     
	    ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品列表', 'goods'), RC_Uri::url('goods/merchant/init')));
	
		$goods_id = $_REQUEST['goods_id'];
		$goods = RC_DB::table('goods')->where('goods_id', $goods_id)->where('store_id', $_SESSION['store_id'])->first();
		if (empty($goods)) {
			return $this->showmessage(__('未检测到此商品', 'goods'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('返回商品列表', 'goods'), 'href' => RC_Uri::url('goods/merchant/init')))));
		}
		
		//查询商品规格对应属性；只按商品id查
		$goods_attr_list = RC_DB::table('goods_attr')->where('goods_id', $goods_id)->get();
		if (!empty($goods_attr_list)) {
			foreach ($goods_attr_list as $val) {
				$goods_attr_all_ids[] =  $val['goods_attr_id'];
			}
			//当前商品有属性数据且有规格，判断商品全部的属性除去当前规格对应的属性外的视为无效属性
			if ($goods['goods_type'] > 0) {
				//当前规格对应的属性id
				$attr_ids = RC_DB::table('attribute')->where('cat_id', $goods['goods_type'])->lists('attr_id');
				if (!empty($attr_ids)) {
					$carrent_goods_type_attr_list = RC_DB::table('goods_attr')->where('goods_id', $goods_id)->whereIn('attr_id', $attr_ids)->get();
					if ($carrent_goods_type_attr_list) {
						foreach ($carrent_goods_type_attr_list as $v) {
							$carrent_goods_type_attr_ids[] = $v['goods_attr_id'];
						}
						//全部和当前的差集
						$diff = array_diff($goods_attr_all_ids, $carrent_goods_type_attr_ids);
		
						if (!empty($diff)) {
							foreach ($goods_attr_list as $attr) {
								if (in_array($attr['goods_attr_id'], $diff)) {
									$invaliable_goods_attr_list[] = $attr;
								}
							}
							$this->assign('goods_attr_list', $invaliable_goods_attr_list);
							$this->assign('invaliable_goods_attr_list', true);
						}
		
					}
				}
			} else {
				//当前商品有属性数据且没有规格；这些商品属性均为无效属性
				if (!empty($goods_attr_list)) {
					$this->assign('goods_attr_list', $goods_attr_list);
					$this->assign('invaliable_goods_attr_list', true);
				}
			}
		} else {
			$this->assign('invaliable_goods_attr_list', false);
		}
		
		if (empty($goods) === true) {
			$goods = array('goods_type' => 0); 	// 商品类型
		}
		/* 获取所有属性列表 */
		$attr_list = get_cat_attr_list($goods['goods_type'], $goods_id);
		$specifications = get_goods_type_specifications();

		if (isset($specifications[$goods['goods_type']])) {
			$goods['specifications_id'] = $specifications[$goods['goods_type']];
		}
		$_attribute = get_goods_specifications_list($goods['goods_id']);
		$goods['_attribute'] = empty($_attribute) ? '' : 1;

		//商品当前有没选择规格；如果已经选择设置过规格，不允许再切换规格
		if ($goods['goods_type'] > 0) {
			$this->assign('has_goods_type', 1);
			$this->assign('goods_type', $goods['goods_type']);
			$goods_type_name = RC_DB::table('goods_type')->where('cat_id', $goods['goods_type'])->pluck('cat_name');
			$this->assign('goods_type_name', $goods_type_name);
		}
		
		//设置选中状态,并分配标签导航
		$this->tags['edit_goods_attr']['active'] = 1;
		$this->assign('tags', $this->tags);
		$href = RC_Uri::url('goods/merchant/init');
		
		$this->assign('action_link', array('href' => $href, 'text' => __('商品列表', 'goods')));
		$this->assign('goods_type_list', goods_enable_type_list($goods['goods_type'], true, true));
		$this->assign('goods_attr_html', build_merchant_attr_html($goods['goods_type'], $goods_id));
		
		$this->assign('ur_here', __('编辑商品属性', 'goods'));
		$this->assign('goods_id', $goods_id);
		
		if (isset($_GET['step'])) {
			$this->assign('step', 4);
			$ur_here = __('添加商品属性', 'goods');
		} else {
			$ur_here = __('编辑商品属性', 'goods');
		}
		$this->assign('ur_here', $ur_here);
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($ur_here));
		
		$this->assign('form_action', RC_Uri::url('goods/merchant/update_goods_attr', 'goods_id='.$goods_id));

		return $this->display('goods_attr.dwt');
	}

	/**
	* 商品属性页面 - 切换商品类型时，返回所需的属性菜单
	*/
	public function get_attr() {
		$this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);
		
		$goods_id = empty($_GET['goods_id']) ? 0 : intval($_GET['goods_id']);
		$goods_type = empty($_GET['goods_type']) ? 0 : intval($_GET['goods_type']);

		$content = build_merchant_attr_html($goods_type, $goods_id);
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $content));
	}

	/**
	* 更新商品属性
	*/
	public function update_goods_attr() {
	    $this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);
	    
		$goods_type = isset($_POST['goods_type'])	? $_POST['goods_type'] 		: 0;
		$goods_id 	= isset($_GET['goods_id']) 		? intval($_GET['goods_id']) : 0;
		$step		= !empty($_POST['step']) 		? trim($_POST['step']) 		: '';

		if ((isset($_POST['attr_id_list']) && isset($_POST['attr_value_list'])) || (empty($_POST['attr_id_list']) && empty($_POST['attr_value_list']))) {
	       // 取得原有的属性值
			$goods_attr_list = array();
			$data = $this->db_attribute->field('attr_id, attr_index')->where(array('cat_id' => $goods_type))->select();
			$attr_list = array();
			if (is_array($data)) {
				foreach ($data as $key => $row) {
					$attr_list[$row['attr_id']] = $row['attr_index'];
				}
			}
			$query = $this->db_goods_attr_view->where(array('ga.goods_id' => $goods_id))->select();
			if (is_array($query)) {
				foreach ($query as $key => $row) {
					$goods_attr_list[$row['attr_id']][$row['attr_value']] = array('sign' => 'delete', 'goods_attr_id' => $row['goods_attr_id']);
				}
			}
			// 循环现有的，根据原有的做相应处理
			if (isset($_POST['attr_id_list'])) {
				foreach ($_POST['attr_id_list'] AS $key => $attr_id) {
					$attr_value = $_POST['attr_value_list'][$key];
					$attr_price = $_POST['attr_price_list'][$key];
					if (!empty($attr_value)) {
						if (isset($goods_attr_list[$attr_id][$attr_value])) {
							// 如果原来有，标记为更新
							$goods_attr_list[$attr_id][$attr_value]['sign'] = 'update';
							$goods_attr_list[$attr_id][$attr_value]['attr_price'] = $attr_price;
						} else {
							// 如果原来没有，标记为新增
							$goods_attr_list[$attr_id][$attr_value]['sign'] = 'insert';
							$goods_attr_list[$attr_id][$attr_value]['attr_price'] = $attr_price;
						}
					}
				}
			}
			$data = array(
				'goods_type' => $goods_type
			);
			$this->db_goods->join(null)->where(array('goods_id' => $goods_id))->update($data);

			$data_insert = array();
			/* 插入、更新、删除数据 */
			$goods_type = isset($_POST['goods_type']) ? $_POST['goods_type'] : 0;
			foreach ($goods_attr_list as $attr_id => $attr_value_list) {
				foreach ($attr_value_list as $attr_value => $info) {
					if ($info['sign'] == 'insert') {
						$data_insert[] = array(
							'attr_id'		=> $attr_id,
							'goods_id'		=> $goods_id,
							'attr_value'	=> $attr_value,
							'attr_price'	=> $info['attr_price']
						);
					} elseif ($info['sign'] == 'update') {
						$data = array(
							'attr_price' => $info['attr_price']
						);
						if (isset($info['goods_attr_id'])) {
							$this->db_goods_attr->where(array('goods_attr_id' => $info['goods_attr_id']))->update($data);
						}
					} else {
					    //查询要删除的属性是否存在对应货品
                        $count = RC_DB::table('products')->where('goods_id', $goods_id)->whereRaw(RC_DB::raw(" CONCAT('|', goods_attr, '|') like '%|".$info['goods_attr_id']."|%' "))->count();
						if($count) {
                            return $this->showmessage(__('请先删除关联的货品再修改规格属性', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                        }
                        $this->db_goods_attr->goods_attr_delete(array('goods_attr_id' => $info['goods_attr_id']));
					}
				}
			}
			$this->db_goods_attr->batch_insert($data_insert);
			//为更新用户购物车数据加标记
			RC_Api::api('cart', 'mark_cart_goods', array('goods_id' => $goods_id));
			
			/*释放商品的规格和属性缓存*/
			$cache_goods_properties_key = 'goods_properties_'.$goods_id;
			$cache_goods_properties_id = sprintf('%X', crc32($cache_goods_properties_key));
			$goods_type_db = RC_Model::model('goods/orm_goods_type_model');
			$properties = $goods_type_db->get_cache_item($cache_goods_properties_id);
			$goods_type_db->delete_cache_item($cache_goods_properties_id);
			
			$arr['goods_id'] = $goods_id;
			if ($step) {
				$arr['step'] = 'add_goods_gallery';
				$message = '';
				$url = RC_Uri::url('goods/mh_gallery/init', $arr);
			} else {
				$message = __('编辑属性成功', 'goods');
				$url = RC_Uri::url('goods/merchant/edit_goods_attr', $arr);
			}
			return $this->showmessage($message, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url, 'pjaxurl' => RC_Uri::url('goods/merchant/edit_goods_attr', array('goods_id' => $goods_id))));
		}
	}

	
	/**
	 * 删除无效属性
	 */
	public function remove_goods_attr()
	{
		$goods_attr_id = intval($_GET['goods_attr_id']);
	
		RC_DB::table('goods_attr')->where('goods_attr_id', $goods_attr_id)->delete();
	
		return $this->showmessage(__('成功移除无效属性', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	
	/**
	 * 关联商品
	 */
	public function edit_link_goods() {
		$this->admin_priv('goods_update');
		
		$action_type = trim($_GET['action_type']);
		$href_url = Ecjia\App\Goods\MerchantGoodsAttr::goods_back_goods_url($action_type);
		
		$ur_here = __('编辑关联商品', 'goods');
		$this->assign('ur_here', $ur_here);
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品列表', 'goods'), $href_url));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($ur_here));
		$this->assign('action_link', array('href' => $href_url, 'text' => __('商品列表', 'goods')));
		
		$goods_id = intval($_GET['goods_id']);
		$goods = RC_DB::table('goods')->where('goods_id', $goods_id)->where('store_id', $_SESSION['store_id'])->first();
		if (empty($goods)) {
			return $this->showmessage(__('未检测到此商品', 'goods'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('返回商品列表', 'goods'), 'href' => RC_Uri::url('goods/merchant/init')))));
		}
		
		$linked_goods = get_linked_goods($goods_id);

		//设置选中状态,并分配标签导航
		$this->assign('tags', $this->tags);
		$this->assign('link_goods_list', $linked_goods);
		$this->assign('cat_list', merchant_cat_list(0, 0, false));
		$this->assign('brand_list', get_brand_list());
	
		


		return $this->display('link_goods.dwt');
	}

	/**
	* 关联配件
	*/
// 	public function edit_link_parts() {
// 		$this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);
		
// 		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品列表', 'goods'), RC_Uri::url('goods/merchant/init')));
// 		ecjia_merchant_screen::get_current_screen()->add_help_tab(array(
// 			'id'		=> 'overview',
// 			'title'		=> __('概述', 'goods'),
// 			'content'	=> '<p>' . RC_Lang::get('goods::goods.edit_link_parts_help') . '</p>'
// 		));
		
// 		ecjia_merchant_screen::get_current_screen()->set_help_sidebar(
// 			'<p><strong>' . __('更多信息：', 'goods') . '</strong></p>' .
// 			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:商品列表#.E5.85.B3.E8.81.94.E9.85.8D.E4.BB.B6" target="_blank">'. RC_Lang::get('goods::goods.about_edit_link_parts') .'</a>') . '</p>'
// 		);
		
// 		$goods_id = intval($_GET['goods_id']);
// 		$goods = RC_DB::table('goods')->where('goods_id', $goods_id)->where('store_id', $_SESSION['store_id'])->first();
// 		if (empty($goods)) {
// 			return $this->showmessage(__('未检测到此商品', 'goods'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('返回商品列表', 'goods'), 'href' => RC_Uri::url('goods/merchant/init')))));
// 		}
		
// 		$group_goods_list = get_group_goods($goods_id);
// 		$this->db_goods_attr->join(null)->where(array('goods_id' => 0))->delete();

// 		//设置选中状态,并分配标签导航
// 		$this->assign('tags', $this->tags);
// 		$this->assign('cat_list', cat_list());
// 		$this->assign('brand_list', get_brand_list());
// 		$this->assign('group_goods_list', $group_goods_list);
// 		$this->assign('action_link', array('href' => RC_Uri::url('goods/merchant/init'), 'text' => __('商品列表', 'goods')));
// 		$this->assign('goods_id', $goods_id);
		
// 		$ur_here = RC_Lang::get('goods::goods.edit_link_parts');
// 		$this->assign('ur_here', $ur_here);
// 		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($ur_here));
		
// 		return $this->display('link_parts.dwt');
// 	}

	/**
	* 关联文章
	*/
	public function edit_link_article() {
		$this->admin_priv('goods_update');
		
		$action_type = trim($_GET['action_type']);
		$href_url = Ecjia\App\Goods\MerchantGoodsAttr::goods_back_goods_url($action_type);
		
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商品列表', 'goods'), $href_url));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑关联文章', 'goods')));
		
		$this->assign('action_link', array('href' => $href_url, 'text' => __('商品列表', 'goods')));
		$this->assign('ur_here', __('关联文章', 'goods'));

		$goods_id = intval($_GET['goods_id']);
		$goods = RC_DB::table('goods')->where('goods_id', $goods_id)->where('store_id', $_SESSION['store_id'])->first();
		if (empty($goods)) {
			return $this->showmessage(__('未检测到此商品', 'goods'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('返回商品列表', 'goods'), 'href' => RC_Uri::url('goods/merchant/init')))));
		}
		
		$goods_article_list = get_goods_articles($goods_id);
		
		//设置选中状态,并分配标签导航
		$this->assign('tags', $this->tags);
		$this->assign('goods_article_list',	$goods_article_list);

		
		return $this->display('link_article.dwt');
	}

	/**
	 * 搜索商品，仅返回名称及ID
	 */
	public function get_goods_list() {
	    $this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);
	   
		$filter = $_GET['JSON'];
		/*商家条件*/
		if (!empty($_SESSION['store_id']) && $_SESSION['store_id'] > 0) {
			$filter['store_id'] = $_SESSION['store_id'];
		}
		$filter['is_on_sale'] = 1;
		$filter['is_delete'] = 0;
		$arr = get_merchant_goods_list($filter);
		$opt = array();
		if (!empty($arr)) {
			foreach ($arr AS $key => $val) {
				$opt[] = array(
					'value' => $val['goods_id'],
					'text'  => $val['goods_name'],
					'data'  => $val['shop_price']
				);
			}
		}
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $opt));
	}
	
	/**
	 * 根据分类id获取下级分类id数组
	 */
	public function get_cat_list() {
		$cat_id = !empty($_POST['cat_id']) ? intval($_POST['cat_id']) : 0;
		
		$cat_list = RC_DB::table('category')->where('parent_id', $cat_id)->where('is_show', 1)->get();
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $cat_list));
	}

	/**
	* 搜索文章
	*/
	public function get_article_list() {
		$this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);
		$title = !empty($_POST['article_title']) ? $_POST['article_title'] : '';
		
		$where = "cat_id > 0 AND article_type = 'article'";
		if (!empty($title)) {
			$where .= " AND title LIKE '%" . mysql_like_quote($title) . "%' ";
		}
		
		$db_article = RC_Model::model('goods/goods_article_model');
		$data = $db_article->field('article_id, title')->where($where)->order('article_id DESC')->limit(50)->select();
		$arr = array();
		if (!empty($data)) {
			foreach ($data as $key => $row) {
				$arr[] = array('value' => $row['article_id'], 'text' => $row['title']);
			}
		}
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $arr));
	}

	/**
	 * 添加商品关联
	 */
	public function add_link_goods() {
		$this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);

		$goods_id		= !empty($_GET['goods_id']) 		? intval($_GET['goods_id']) : 0;
		$linked_array 	= !empty($_POST['linked_array']) 	? $_POST['linked_array'] 	: '';
		$step 			= !empty($_POST['step'])	 		? trim($_POST['step']) 		: '';
		
		$this->db_link_goods->where(array('link_goods_id' => $goods_id))->update(array('is_double' => 0));
		$this->db_link_goods->where(array('goods_id' => $goods_id))->delete();

		$data = array();
		if (!empty($linked_array)) {
			foreach ($linked_array AS $val) {
				$is_double = $val['is_double'] ? 1 : 0;
				if (!empty($is_double)) {
					/* 双向关联,先干掉与本商品关联的商品，再添加关联给与本商品关联的商品 */
					$this->db_link_goods->where(array('goods_id' => $val, 'link_goods_id' => $goods_id))->delete();
					$data[] = array(
						'goods_id'		=> $val['id'],
						'link_goods_id'	=> $goods_id,
						'is_double'		=> $is_double,
						'admin_id'		=> $_SESSION['admin_id'],
					);
				}
				$data[] = array(
					'goods_id'		=> $goods_id,
					'link_goods_id'	=> $val['id'],
					'is_double'		=> $is_double,
					'admin_id'		=> $_SESSION['admin_id'],
				);
			}
		}
		if (!empty($data)) {
			$this->db_link_goods->batch_insert($data);
		}
		
		/* 释放app缓存*/
		$orm_goods_db = RC_Model::model('goods/orm_goods_model');
		$goods_cache_array = $orm_goods_db->get_cache_item('goods_list_cache_key_array');
		if (!empty($goods_cache_array)) {
			foreach ($goods_cache_array as $val) {
				$orm_goods_db->delete_cache_item($val);
			}
			$orm_goods_db->delete_cache_item('goods_list_cache_key_array');
		}
		/*释放商品基本信息缓存*/
		$cache_goods_basic_info_key = 'goods_basic_info_'.$goods_id;
		$cache_basic_info_id = sprintf('%X', crc32($cache_goods_basic_info_key));
		$orm_goods_db->delete_cache_item('goods_list_cache_key_array');
		
		$goods_name = $this->db_goods->where(array('goods_id'=>$goods_id))->get_field('goods_name');
		ecjia_merchant::admin_log(sprintf(__('增加关联商品，被设置的商品名称是%s', 'goods'), $goods_name), 'setup', 'goods');
		
		$arr['goods_id'] = $goods_id;
		if ($step) {
			$arr['step'] = 'add_link_parts';
			$message = '';
			$url = RC_Uri::url('goods/merchant/edit_link_parts', $arr);
		} else {
			$message = __('编辑成功', 'goods');
			$url = RC_Uri::url('goods/merchant/edit_link_goods', $arr);
		}
		
		return $this->showmessage($message, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url));
	}

	/**
	* 增加一个配件
	*/
// 	public function add_link_parts() {
// 	    $this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);

// 		$goods_id 		= intval($_GET['goods_id']);
// 		$linked_array 	= !empty($_POST['linked_array']) 	? $_POST['linked_array'] 	: '';
// 		$step 			= !empty($_POST['step']) 			? trim($_POST['step']) 		: '';
		
// 		$this->db_group_goods->where(array('parent_id' => $goods_id))->delete();
// 		$this->db_term_relationship->where(array('object_type'=>'ecjia.goods', 'object_group' => 'group_goods', 'object_id' => $goods_id))->delete();

// 		$data = array();
// 		if (!empty($linked_array)) {
// 			foreach ($linked_array AS $key=>$val) {
// 				$data[] = array(
// 					'parent_id'		=> $goods_id,
// 					'goods_id'		=> $val['id'],
// 					'goods_price'	=> $val['price'],
// 					'admin_id'		=> $_SESSION['admin_id'],
// 				);
// 				$sort_data[] = array(
// 					'object_type'		=> 'ecjia.goods',
// 					'object_group'		=> 'group_goods',
// 					'object_id'			=> $goods_id,
// 					'item_key1'			=> 'goods_id',
// 					'item_value1'		=> $val['id'],
// 					'item_key2'			=> 'goods_sort',
// 					'item_value2'		=> $key,
// 				);
// 			}
// 		}
		
// 		if (!empty($data)) {
// 			$this->db_group_goods->batch_insert($data);
// 			$this->db_term_relationship->batch_insert($sort_data);
// 		}

// 		$arr['goods_id'] = $goods_id;
// 		if ($step) {
// 			$arr['step'] = 'add_link_article';
// 			$message = '';
// 			$url = RC_Uri::url('goods/merchant/edit_link_article', $arr);
// 		} else {
// 			$message = __('编辑成功', 'goods');
// 			$url = RC_Uri::url('goods/merchant/edit_link_parts', $arr);
// 		}
// 		return $this->showmessage($message, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url));
// 	}

	/**
	* 添加关联文章
	*/
	public function add_link_article() {
		$this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);

		$goods_id 		= isset($_GET['goods_id']) 			? intval($_GET['goods_id']) : 0;
		$linked_array 	= !empty($_POST['linked_array']) 	? $_POST['linked_array'] 	: '';
		$step 			= !empty($_POST['step']) 			? trim($_POST['step']) 		: '';
		
		RC_DB::table('goods_article')->where('goods_id', $goods_id)->delete();
		$data = array();
		if (!empty($linked_array)) {
			foreach ($linked_array AS $val) {
				$data[] = array(
					'goods_id' 		=> $goods_id,
					'article_id' 	=> $val['article_id'],
					'admin_id'		=> 0
				);
			}
		}
		if (!empty($data)) {
			RC_DB::table('goods_article')->insert($data);
		}
		$arr['goods_id'] = $goods_id;
		if ($step) {
			$arr['step'] = 'add_product';
			$message = '';
			$url = RC_Uri::url('goods/merchant/product_list', $arr);
		} else {
			$message = __('编辑成功', 'goods');
			$url = RC_Uri::url('goods/merchant/edit_link_article', $arr);
		}
		return $this->showmessage($message, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url));
	}
	
	/**
	 * 商品添加/编辑页 添加商品品牌
	 */
	public function add_brand() {
	    $this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);
	    
		$brand_name = !empty($_POST['brand_name']) ? trim($_POST['brand_name']) : '';
		$is_only = $this->db_brand->brand_count(array('brand_name' => $brand_name));
		if ($is_only != 0) {
			return $this->showmessage(sprintf(__('品牌 %s 已经存在！', 'goods'), stripslashes($brand_name)), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	
		$data = array(
			'brand_name'	=> $brand_name,
			'is_show'		=> 0,
			'sort_order'	=> 1,
		);
		$brand_id = $this->db_brand->brand_manage($data);
		ecjia_merchant::admin_log($brand_name, 'add', 'brand');
	
		$arr = array('id' => $brand_id, 'name' => $brand_name);
		return $this->showmessage(__('新品牌添加成功！', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $arr));
	}
	
	/**
	 * 商品添加/编辑页 添加商品分类
	 */
	public function add_category() {
	    $this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);
	    
		$cat['parent_id']	= !empty($_POST['cat_id'])		? intval($_POST['cat_id'])	: 0;
		$cat['cat_name']	= !empty($_POST['cat_name'])	? trim($_POST['cat_name'])	: '';
		$cat['sort_order']  = 1;
	
		if (merchant_cat_exists($cat['cat_name'], $cat['parent_id'])) {
			return $this->showmessage(__('已存在相同的分类名称！', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$cat_id = $this->db_category->category_manage($cat);
		ecjia_merchant::admin_log($cat['cat_name'], 'add', 'category');
	
		$cat_select = merchant_cat_list(0, $cat_id, true);
		$cat_list = merchant_cat_list(0, $cat_id, false);
	
		$arr = array();
		if (!empty($cat_list)) {
			foreach ($cat_list as $k => $v) {
				if ($cat_id == $v['cat_id']) {
					$arr = $v;
				}
			}
		}
		return $this->showmessage(__('新商品分类添加成功！', 'goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $cat_select, 'opt' => $arr));
	}

	/**
	 * 查看审核日志
	 */
	public function review_log() {
		$this->admin_priv('goods_manage');
		
		$goods_id = intval($_POST['goods_id']);
		$goods_info = RC_DB::TABLE('goods')->where('goods_id', $goods_id)->select('review_status', 'review_content')->first();
		$this->assign('goods_info', $goods_info);

		$list_log = RC_DB::TABLE('goods_review_log')->where('goods_id', $goods_id)->select('status', 'action_user_name', 'action_note' ,'add_time')
		->orderby('add_time', 'desc')
		->get();

		foreach ($list_log as $key => $rows) {
			$list_log[$key]['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $rows['add_time']);
		}
		$this->assign('list_log', $list_log);

	
		$data = $this->fetch('review_log.dwt');
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('data' => $data));
	}
	
	private function generate_url($url_list) {
		if (empty($url_list)) {
			return false;
		}
		
		unset($url_list['pjax']);
		unset($url_list['_pjax']);
		unset($url_list['_']);
		
		$url = '';
		foreach ($url_list as $k => $v) {
			$url .= '&'.$k.'='.$v;
		}
		return $url;
	}
	
	/**
	 * 商品规格重组集合
	 * @param array $options
	 * @return array
	 */
	private function _combination(array $options)
	{
		$rows = [];
	
		foreach ($options as $option => $items) {
			if (count($rows) > 0) {
				// 2、将第一列作为模板
				$clone = $rows;
	
				// 3、置空当前列表，因为只有第一列的数据，组合是不完整的
				$rows = [];
	
				// 4、遍历当前列，追加到模板中，使模板中的组合变得完整
				foreach ($items as $item) {
					$tmp = $clone;
					foreach ($tmp as $index => $value) {
						$value[$option] = $item;
						$tmp[$index] = $value;
					}
	
					// 5、将完整的组合拼回原列表中
					$rows = array_merge($rows, $tmp);
				}
			} else {
				// 1、先计算出第一列
				foreach ($items as $item) {
					$rows[][$option] = $item;
				}
			}
		}
	
		return $rows;
	}
}

// end