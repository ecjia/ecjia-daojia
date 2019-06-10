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
 *  ECJIA 收银台商品管理程序
 */
class mh_cashier_goods extends ecjia_merchant {

	public function __construct() {
		parent::__construct();
		
		Ecjia\App\Cashier\Helper::assign_adminlog_content();
		
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Style::enqueue_style('uniform-aristo');
		
		RC_Script::enqueue_script('ecjia-mh-editable-js');
		RC_Style::enqueue_style('ecjia-mh-editable-css');
		
		//时间控件
		RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
		RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));
		
		RC_Script::enqueue_script('mh_cashier_goods_list', RC_App::apps_url('statics/js/mh_cashier_goods_list.js', __FILE__), array(), false, 1);
		RC_Script::enqueue_script('mh_cashier_goods_info', RC_App::apps_url('statics/js/mh_cashier_goods_info.js', __FILE__), array(), false, 1);
		RC_Script::localize_script('mh_cashier_goods_info', 'js_lang', config('app-cashier::jslang.cashier_goods_page'));
		
		$goods_list_jslang = array(
				'user_rank_list'	=> Ecjia\App\Cashier\BulkGoods::get_rank_list(),
				'marketPriceRate'	=> ecjia::config('market_price_rate'),
				'integralPercent'	=> ecjia::config('integral_percent'),
		);
		RC_Script::localize_script( 'mh_cashier_goods_info', 'admin_goodsList_lang', $goods_list_jslang );
		
		RC_Loader::load_app_func('merchant_goods', 'goods');
		
		ecjia_merchant_screen::get_current_screen()->set_parentage('cashier', 'cashier/mh_cashier_goods.php');
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('收银台商品', 'cashier'), RC_Uri::url('cashier/mh_cashier_goods/init')));
	}

	/**
	* 收银台商品列表
	*/
	public function init() {
	    $this->admin_priv('mh_cashier_goods_manage');

		$this->assign('ur_here', __('收银台商品', 'cashier'));
		$this->assign('action_link', array('href' => RC_Uri::url('cashier/mh_cashier_goods/add'), 'text' => __('添加收银台商品', 'cashier')));
		
		$cashier_goods_list = $this->cashier_goods_list();
		$this->assign('cashier_goods_list', $cashier_goods_list);
		$this->assign('filter', $cashier_goods_list['filter']);
		$this->assign('cat_list', merchant_cat_list(0, 0, false));
		
		$this->assign('form_action', RC_Uri::url('cashier/mh_cashier_goods/batch'));

        return $this->display('cashier_goods_list.dwt');
	}
	
	/**
	 * 批量操作
	 */
	public function batch() {
		/* 取得要操作的商品编号 */
		$goods_id = !empty($_POST['checkboxes']) ? remove_xss($_POST['checkboxes']) : 0;
		
		if (!isset($_GET['type']) || $_GET['type'] == '') {
			return $this->showmessage(__('请选择操作', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$goods_id = explode(',', $goods_id);
		$data = RC_DB::table('goods')->select('goods_name')->whereIn('goods_id', $goods_id)->get();
	
		if (isset($_GET['type'])) {
			/* 放入回收站 */
			if ($_GET['type'] == 'trash') {
				/* 检查权限 */
				$this->admin_priv('mh_cashier_goods_update', ecjia::MSGTYPE_JSON);
				Ecjia\App\Cashier\BulkGoods::update_goods($goods_id, 'is_delete', '1');
				$action = 'batch_trash';
			}
			/* 上架 */
			elseif ($_GET['type'] == 'on_sale') {
				/* 检查权限 */
				$this->admin_priv('mh_cashier_goods_update', ecjia::MSGTYPE_JSON);
				Ecjia\App\Cashier\BulkGoods::update_goods($goods_id, 'is_on_sale', '1');
				$action = 'batch_on';
			}
			/* 下架 */
			elseif ($_GET['type'] == 'not_on_sale') {
				/* 检查权限 */
				$this->admin_priv('mh_cashier_goods_update', ecjia::MSGTYPE_JSON);
				Ecjia\App\Cashier\BulkGoods::update_goods($goods_id, 'is_on_sale', '0');
				$action = 'batch_off';
			}
			/* 转移到分类 */
			elseif ($_GET['type'] == 'move_to') {
				/* 检查权限 */
				$this->admin_priv('mh_cashier_goods_update', ecjia::MSGTYPE_JSON);
				
				if (empty($_GET['target_cat'])) {
					return $this->showmessage(__('请先选择要转移的分类', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
				Ecjia\App\Cashier\BulkGoods::update_goods($goods_id, 'merchant_cat_id', remove_xss($_GET['target_cat']));
				$action = 'batch_move_cat';
			}
		}
	
		/* 记录日志 */
		if (!empty($data) && $action) {
			foreach ($data as $k => $v) {
				ecjia_merchant::admin_log($v['goods_name'], $action, 'cashier_goods');
			}
		}
	
		$page = empty($_GET['page']) ? '&page=1' : '&page='.intval($_GET['page']);
	
		$pjaxurl = RC_Uri::url('cashier/mh_cashier_goods/init' ,$page);
	
		return $this->showmessage(__('批量操作成功', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $pjaxurl));
	}
	
	/**
	 * 修改收银台商品名称
	 */
	public function edit_goods_name() {
		$this->admin_priv('mh_cashier_goods_update', ecjia::MSGTYPE_JSON);
	
		$goods_id = intval($_POST['pk']);
		$goods_name = remove_xss($_POST['value']);
		
		if (!empty($goods_name)) {
			RC_DB::table('goods')->where('goods_id', $goods_id)->where('store_id', $_SESSION['store_id'])->update(array('goods_name' => $goods_name, 'last_update' => RC_Time::gmtime()));
			return $this->showmessage(__('修改成功！', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => stripslashes($goods_name)));
		} else {
			return $this->showmessage(__('请输入商品名称！', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 修改商品货号
	 */
	public function edit_goods_sn() {
		$this->admin_priv('mh_cashier_goods_update', ecjia::MSGTYPE_JSON);
	
		$goods_id = intval($_POST['pk']);
		$goods_sn = remove_xss($_POST['value']);
	
		if (empty($goods_sn)) {
			return $this->showmessage(__('请输入商品货号', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	
		/* 检查是否重复 */
		if ($goods_sn) {
			$count = RC_DB::table('goods')->where('goods_sn', $goods_sn)->where('goods_id', '!=', $goods_id)->where('store_id', $_SESSION['store_id'])->count();
			if ($count > 0) {
				return $this->showmessage(__('您输入的货号已存在，请换一个', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		
		RC_DB::table('goods')->where('goods_id', $goods_id)->where('store_id', $_SESSION['store_id'])->update(array('goods_sn' => $goods_sn, 'last_update' => RC_Time::gmtime()));
	
		return $this->showmessage(__('修改成功', 'cashier'),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => stripslashes($goods_sn)));
	}
	
	/**
	 * 修改商品价格
	 */
	public function edit_goods_price() {
		$this->admin_priv('mh_cashier_goods_update', ecjia::MSGTYPE_JSON);
	
		$goods_id = intval($_POST['pk']);
		$goods_price = floatval($_POST['value']);
		$price_rate = floatval(ecjia::config('market_price_rate') * $goods_price);
		$data = array(
				'shop_price'	=> $goods_price,
				'market_price'  => $price_rate,
				'last_update'   => RC_Time::gmtime()
		);
		if ($goods_price < 0 || $goods_price == 0 && $_POST['val'] != "$goods_price") {
			return $this->showmessage(__('您输入了一个非法的市场价格。', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			RC_DB::table('goods')->where('goods_id', $goods_id)->where('store_id', $_SESSION['store_id'])->update($data);
			//为更新用户购物车数据加标记
			RC_Api::api('cart', 'mark_cart_goods', array('goods_id' => $goods_id));
			return $this->showmessage(__('修改成功', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => number_format($goods_price, 2, '.', '')));
		}
	}
	
	/**
	 * 修改商品库存
	 */
	public function edit_goods_number() {
		$this->admin_priv('mh_cashier_goods_update', ecjia::MSGTYPE_JSON);
	
		$goods_id = intval($_POST['pk']);
		$goods_number = !empty($_POST['value']) ? intval($_POST['value']) : 1000;
	
		$data = array(
				'goods_number' 	=> $goods_number,
				'last_update' 	=> RC_Time::gmtime()
		);
	
		
		RC_DB::table('goods')->where('goods_id', $goods_id)->where('store_id', $_SESSION['store_id'])->update($data);
		return $this->showmessage(__('修改成功', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $goods_number));
	}
	
	/**
	 * 修改上架状态
	 */
	public function toggle_on_sale() {
		$this->admin_priv('mh_cashier_goods_update', ecjia::MSGTYPE_JSON);
	
		$goods_id = intval($_POST['id']);
		$on_sale = intval($_POST['val']);
	
		$data = array(
				'is_on_sale' 	=> $on_sale,
				'last_update' 	=> RC_Time::gmtime()
		);
		RC_DB::table('goods')->where('goods_id', $goods_id)->where('store_id', $_SESSION['store_id'])->update($data);
		return $this->showmessage(__('已成功切换上架状态', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $on_sale));
	}
	
	/**
	 * 修改商品排序
	 */
	public function edit_sort_order() {
		$this->admin_priv('mh_cashier_goods_update', ecjia::MSGTYPE_JSON);
	
		$goods_id = intval($_POST['pk']);
		$sort_order = intval($_POST['value']);
		$data = array(
				'store_sort_order' 	=> $sort_order,
				'last_update' 		=> RC_Time::gmtime()
		);
		RC_DB::table('goods')->where('goods_id', $goods_id)->where('store_id', $_SESSION['store_id'])->update($data);
	
		return $this->showmessage(__('修改成功!', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $sort_order));
	}
	
	/**
	 * 添加收银台商品
	 */
	public function add() {
		// 检查权限
		$this->admin_priv('mh_cashier_goods_update');
	
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('收银台商品', 'cashier')));
		$this->assign('action_link', array('href' => RC_Uri::url('cashier/mh_cashier_goods/init'), 'text' => __('收银台商品', 'cashier')));
	
		
		$this->assign('ur_here', __('基本信息', 'cashier'));
		
		$goods = array(
				'goods_id'				=> 0,
				'goods_desc'			=> '',
				'cat_id'				=> 0,
				'brand_id'				=> 0,
				'is_on_sale'			=> '1',
				'is_alone_sale'			=> '1',
				'is_shipping'			=> '0',
				'other_cat'				=> array(), // 扩展分类
				'goods_type'			=> 0, 		// 商品类型
				'shop_price'			=> 0,
				'promote_price'			=> 0,
				'market_price'			=> 0,
				'integral'				=> 0,
				'goods_number'			=> 0,
				'weight_stock'			=> 1000.000,
				'warn_number'			=> 1,
				'promote_start_date'	=> RC_Time::local_date('Y-m-d'),
				'promote_end_date'		=> RC_Time::local_date('Y-m-d', RC_Time::local_strtotime('+1 month')),
				'goods_weight'			=> 0,
				'give_integral'			=> -1,
				'rank_integral'			=> -1
		);
	
	
		$this->assign('goods', $goods);
	
		$this->assign('unit_list', Ecjia\App\Cashier\BulkGoods::unit_list());
		$this->assign('user_rank_list', Ecjia\App\Cashier\BulkGoods::get_rank_list());
		$this->assign('limit_days_unit', Ecjia\App\Cashier\BulkGoods::limit_days_unit_list());
		
		$merchant_cat = merchant_cat_list(0, 0, true, 2, false);		//店铺分类
		$this->assign('merchant_cat', $merchant_cat);
		
		$volume_price_list = '';
		if (isset($_GET['goods_id'])) {
			$volume_price_list = Ecjia\App\Cashier\BulkGoods::get_volume_price_list(intval($_GET['goods_id']));
		}
		if (empty($volume_price_list)) {
			$volume_price_list = array('0' => array('number' => '', 'price' => ''));
		}
		$this->assign('volume_price_list', $volume_price_list);
		$this->assign('form_action', RC_Uri::url('cashier/mh_cashier_goods/insert'));

        return $this->display('cashier_goods_info.dwt');
	}
	
	/**
	 * 插入商品
	 */
	public function insert() {
		// 检查权限
		$this->admin_priv('mh_cashier_goods_update', ecjia::MSGTYPE_JSON);
	
		$goods_sn = remove_xss($_POST['goods_sn']);
		if (!empty($goods_sn)) {
			/* 检查货号是否重复 */
			$count = RC_DB::table('goods')->where('goods_sn', $goods_sn)->where('store_id', $_SESSION['store_id'])->count();
			if ($count > 0) {
				return $this->showmessage(__('您输入的货号已存在，请换一个', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		
		/* 如果没有输入商品货号则自动生成一个商品货号 */
		if (empty($goods_sn)) {
			//$max_id = $this->db_goods->goods_find('', 'MAX(goods_id) + 1|max');
			$max_id = RC_DB::table('goods')->max('goods_id');
			$max_id = $max_id + 1;
			if (empty($max_id)) {
				$goods_sn_bool = true;
				$goods_sn = '';
			} else {
				$goods_sn = Ecjia\App\Cashier\BulkGoods::generate_goods_sn($max_id);
			}
		} 
		
		/* 处理商品数据 */
		$shop_price 	= !empty($_POST['shop_price']) 		? floatval($_POST['shop_price']) 				: 0;
		$market_price 	= !empty($_POST['market_price']) && is_numeric($_POST['market_price']) ? floatval($_POST['market_price']) : 0;
		$promote_price 	= !empty($_POST['promote_price']) 	? floatval($_POST['promote_price']) : 0;
		$is_promote 	= empty($promote_price) 			? 0 								: 1;

		$promote_start_date = ($is_promote && !empty($_POST['promote_start_date'])) ? RC_Time::local_strtotime(remove_xss($_POST['promote_start_date'])) 	: 0;
		$promote_end_date 	= ($is_promote && !empty($_POST['promote_end_date'])) 	? RC_Time::local_strtotime(remove_xss($_POST['promote_end_date'])) 		: 0;
		$goods_number		= !empty($_POST['goods_number']) ? remove_xss($_POST['goods_number']) : 1000;
		
		$cost_price 	= !empty($_POST['cost_price']) && is_numeric($_POST['cost_price']) ? floatval($_POST['cost_price']) : 0.00;
		$generate_date 	= !empty($_POST['generate_date'])? remove_xss($_POST['generate_date']) : '';
		$limit_days 	= !empty($_POST['limit_days'])? remove_xss($_POST['limit_days']) : 0;
		$expiry_date 	= !empty($_POST['expiry_date'])? remove_xss($_POST['expiry_date']) : '';
		
		$is_on_sale 	= !empty($_POST['is_on_sale']) 		? 1 : 0;
		$warn_number 	= !empty($_POST['warn_number'])		? remove_xss($_POST['warn_number']) 	: 0;

		$goods_name 		= isset($_POST['goods_name']) 		? htmlspecialchars($_POST['goods_name']) 		: '';
		$merchant_cat_id 	= empty($_POST['merchant_cat_id']) 	? '' 	: intval($_POST['merchant_cat_id']);
		//保质期
		$limit_days_unit = intval($_POST['limit_days_unit']);
		if (!empty($limit_days)) {
			if ($limit_days_unit == '1') {
				$limit_days_final = $limit_days.' day';
			} elseif ($limit_days_unit == '2') {
				$limit_days_final = $limit_days.' month';
			} else {
				$limit_days_final =  $limit_days.' year';
			}
		} else {
			$limit_days_final = '';
		}
		//到期日期
		if (!empty($generate_date) && !empty($limit_days)) {
			$exppire_date = Ecjia\App\Cashier\BulkGoods::expiry_date($generate_date, $limit_days, $limit_days_unit);
		}
		if (empty($merchant_cat_id)) {
			return $this->showmessage(__('请选择店铺商品分类', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		if (empty($goods_name)) {
			return $this->showmessage(__('请输入商品名称', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	
		/* 入库 */
		$data = array(
				'goods_name'            => rc_stripslashes($goods_name),
				'goods_name_style'      => '',
				'goods_sn'              => $goods_sn,
				'cat_id'                => 0,				//平台分类id
				'merchant_cat_id'		=> $merchant_cat_id,	//店铺分类id
				'brand_id'              => 0,
				'shop_price'            => $shop_price,
				'market_price'          => $market_price,
				'is_promote'            => $is_promote,
				'promote_price'         => $promote_price,
				'promote_start_date'    => $promote_start_date,
				'promote_end_date'      => $promote_end_date,
// 				'keywords'              => $_POST['keywords'],
// 				'goods_brief'           => $_POST['goods_brief'],
				'seller_note'           => remove_xss($_POST['seller_note']),
				'goods_weight'          => 0.000,
				'goods_number'          =>	$goods_number,
				'warn_number'           => $warn_number,
				'integral'              => remove_xss($_POST['integral']),
				'store_best'            => 0,
				'store_new'             => 0,
				'store_hot'             => 0,
				'is_on_sale'            => $is_on_sale,
				'is_alone_sale'         => 1,
				'is_shipping'           => 0,
				'add_time'              => RC_Time::gmtime(),
				'last_update'           => RC_Time::gmtime(),
				'goods_type'            => 0,
				'suppliers_id'          => 0,
				'review_status'         => 3,
				'store_id'				=> $_SESSION['store_id'],
				'extension_code'		=> 'cashier',
				'cost_price'			=> $cost_price,
				'generate_date'			=> $generate_date,
				'limit_days'			=> $limit_days_final,
				'expiry_date'			=> $expiry_date
		);
		
		$goods_id = RC_DB::table('goods')->insertGetId($data);

		if (isset($goods_sn_bool) && $goods_sn_bool) {
			$goods_sn = Ecjia\App\Cashier\BulkGoods::generate_goods_sn($goods_id);
			$data = array('goods_sn' => $goods_sn);
			//$this->db_goods->goods_update(array('goods_id' => $goods_id), $data);
			RC_DB::table('goods')->where('goods_id', $goods_id)->update($data);
		}
		
		/* 记录日志 */
		ecjia_merchant::admin_log($goods_name, 'add', 'cashier_goods');
		/* 处理会员价格 */
		if (isset($_POST['user_rank']) && isset($_POST['user_price'])) {
			Ecjia\App\Cashier\BulkGoods::handle_member_price($goods_id, remove_xss($_POST['user_rank']), remove_xss($_POST['user_price']));
		}
	
		/* 处理优惠价格 */
		if (isset($_POST['volume_number']) && isset($_POST['volume_price'])) {
			$temp_num = array_count_values(remove_xss($_POST['volume_number']));
			foreach ($temp_num as $v) {
				if ($v > 1) {
					return $this->showmessage(__('优惠数量重复！', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			}
			Ecjia\App\Cashier\BulkGoods::handle_volume_price($goods_id, remove_xss($_POST['volume_number']), remove_xss($_POST['volume_price']));
		}
		return $this->showmessage(__('添加收银台商品成功！', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('cashier/mh_cashier_goods/edit', array('goods_id' => $goods_id))));
	}
	
	/**
	 * 编辑收银台商品
	 */
	public function edit() {
		$this->admin_priv('mh_cashier_goods_update');
	
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('收银台商品', 'cashier'), RC_Uri::url('cashier/mh_cashier_goods/init')));
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑收银台商品', 'cashier')));
	
		$this->assign('ur_here', __('编辑收银台商品', 'cashier'));
		$this->assign('action_link', array('href' => RC_Uri::url('cashier/mh_cashier_goods/init'), 'text' => __('收银台商品', 'cashier')));
	
		/* 商品信息 */
		$goods = RC_DB::table('goods')->where('goods_id', intval($_GET['goods_id']))->where('extension_code', 'cashier')->where('store_id', $_SESSION['store_id'])->first();
		
		if (empty($goods)) {
			return $this->showmessage(__('未检测到此商品', 'cashier'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => __('返回收银台商品', 'cashier'), 'href' => RC_Uri::url('cashier/mh_cashier_goods/init')))));
		}
	
		if (empty($goods)) {
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
					'shop_price'			=> 0,
					'promote_price'			=> 0,
					'market_price'			=> 0,
					'integral'				=> 0,
					'goods_number'			=> 1,
					'warn_number'			=> 1,
					'promote_start_date'	=> RC_Time::local_date('Y-m-d'),
					'promote_end_date'		=> RC_Time::local_date('Y-m-d', RC_Time::gmstr2time('+1 month')),
					'goods_weight'			=> '0.00',
					'give_integral'			=> -1,
					'rank_integral'			=> -1
			);
		}
	
		/* 如果不是促销，处理促销日期 */
		if (isset($goods['is_promote']) && $goods['is_promote'] == '0') {
			unset($goods['promote_start_date']);
			unset($goods['promote_end_date']);
		} else {
			$goods['promote_start_date'] = RC_Time::local_date('Y-m-d', $goods['promote_start_date']);
			$goods['promote_end_date'] = RC_Time::local_date('Y-m-d', $goods['promote_end_date']);
		}
		//保质期处理
		if (!empty($goods['limit_days'])) {
			$limit_days_str = explode(" ", $goods['limit_days']);
			$goods['limitdays'] = $limit_days_str['0'];
			if ($limit_days_str['1'] == 'day') {
				$goods['limitday_unit'] = 1;
			} elseif ($limit_days_str['1'] == 'month') {
				$goods['limitday_unit'] = 2;
			} elseif ($limit_days_str['1'] == 'year') {
				$goods['limitday_unit'] = 3;
			}
		} else {
			$goods['limitdays'] = 0;
			$goods['limitday_unit'] = 1;
		}
		//店铺分类
		$merchant_cat = merchant_cat_list(0, $goods['merchant_cat_id'], true, 2);	
	
		$this->assign('goods', 				$goods);
		$this->assign('merchant_cat',  		$merchant_cat);
		$this->assign('unit_list', 			Ecjia\App\Cashier\BulkGoods::unit_list());
		$this->assign('limit_days_unit', 	Ecjia\App\Cashier\BulkGoods::limit_days_unit_list());
		$this->assign('user_rank_list', 	Ecjia\App\Cashier\BulkGoods::get_rank_list());
	
		$this->assign('weight_unit', 		$goods['weight_unit']);
		$this->assign('member_price_list', 	Ecjia\App\Cashier\BulkGoods::get_member_price_list(intval($_GET['goods_id'])));
	
		$volume_price_list = '';
		if (isset($_GET['goods_id'])) {
			$volume_price_list = Ecjia\App\Cashier\BulkGoods::get_volume_price_list(intval($_GET['goods_id']));
		}
		if (empty($volume_price_list)) {
			$volume_price_list = array('0' => array('number' => '', 'price' => ''));
		}
		$this->assign('volume_price_list', $volume_price_list);
	
		/* 显示商品信息页面 */
		$this->assign('form_action', RC_Uri::url('cashier/mh_cashier_goods/update'));
        return $this->display('cashier_goods_info.dwt');
	}
	
	/**
	 * 编辑收银台商品数据处理
	 */
	public function update() {
		$this->admin_priv('mh_cashier_goods_update', ecjia::MSGTYPE_JSON);
	
		$goods_id = !empty($_POST['goods_id']) ? intval($_POST['goods_id']) : 0;
		$goods_sn = remove_xss($_POST['goods_sn']);
		if (!empty($goods_sn)) {
			//检查商品货号是否重复
			$count = RC_DB::table('goods')->where('goods_sn', $goods_sn)->where('goods_id', '!=', $goods_id)->where('store_id', $_SESSION['store_id'])->count();
			if ($count > 0) {
				return $this->showmessage(__('您输入的货号已存在，请换一个', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		} else {
			$goods_sn = Ecjia\App\Cashier\BulkGoods::generate_goods_sn($goods_id);
		}
		
		/* 处理商品数据 */
		$shop_price 	= !empty($_POST['shop_price']) 		? floatval($_POST['shop_price']) 				: 0;
		$market_price 	= !empty($_POST['market_price']) && is_numeric($_POST['market_price']) ? floatval($_POST['market_price']) : 0;
		$promote_price 	= !empty($_POST['promote_price']) 	? floatval($_POST['promote_price']) : 0;
		$is_promote 	= empty($_POST['is_promote']) 		? 0 								: 1;

		$promote_start_date = ($is_promote && !empty($_POST['promote_start_date'])) ? RC_Time::local_strtotime(remove_xss($_POST['promote_start_date'])) 	: 0;
		$promote_end_date 	= ($is_promote && !empty($_POST['promote_end_date'])) 	? RC_Time::local_strtotime(remove_xss($_POST['promote_end_date'])) 		: 0;
		$goods_number		= !empty($_POST['goods_number']) ? remove_xss($_POST['goods_number']) : 1000;
		
		$cost_price 	= !empty($_POST['cost_price']) && is_numeric($_POST['cost_price']) ? floatval($_POST['cost_price']) : 0.00;
		$generate_date 	= !empty($_POST['generate_date'])? remove_xss($_POST['generate_date']) : '';
		$limit_days 	= !empty($_POST['limit_days'])? remove_xss($_POST['limit_days']) : 0;
		$expiry_date 	= !empty($_POST['expiry_date'])? remove_xss($_POST['expiry_date']) : '';
		//保质期
		$limit_days_unit = intval($_POST['limit_days_unit']);
		if (!empty($limit_days)) {
			if ($limit_days_unit == '1') {
				$limit_days_final = $limit_days.' day';
			} elseif ($limit_days_unit == '2') {
				$limit_days_final = $limit_days.' month';
			} else {
				$limit_days_final =  $limit_days.' year';
			}
		} else {
			$limit_days_final = '';
		}
		//到期日期
		if (!empty($generate_date) && !empty($limit_days)) {
			$exppire_date = Ecjia\App\Cashier\BulkGoods::expiry_date($generate_date, $limit_days, $limit_days_unit);
		}
		$is_on_sale 	= isset($_POST['is_on_sale']) 		? 1 : 0;
		$warn_number 	= isset($_POST['warn_number']) 		? remove_xss($_POST['warn_number']) 	: 0;
		$goods_name 		= htmlspecialchars(remove_xss($_POST['goods_name']));
		$merchant_cat_id 	= empty($_POST['merchant_cat_id']) 	? '' 	: intval($_POST['merchant_cat_id']);

		if (empty($merchant_cat_id)) {
			return $this->showmessage(__('请选择店铺商品分类', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		if (empty($goods_name)) {
			return $this->showmessage(__('请输入商品名称', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		$data = array(
				'goods_name'				=> rc_stripslashes($goods_name),
				'goods_name_style'	  		=> '',
				'goods_sn'			  		=> $goods_sn,
				'merchant_cat_id'			=> $merchant_cat_id,	//店铺分类id
				'cat_id'					=> 0,
				'brand_id'			  		=> 0,
				'shop_price'				=> $shop_price,
				'market_price'		  		=> $market_price,
				'is_promote'				=> $is_promote,
				'promote_price'		 		=> $promote_price,
				'promote_start_date'		=> $promote_start_date,
				'suppliers_id'		  		=> 0,
				'promote_end_date'	  		=> $promote_end_date,
				'is_real'			   		=> 1,
				'extension_code'			=> 'cashier',
				'keywords'			  		=> '',
				'goods_brief'		   		=> '',
				'seller_note'		   		=> remove_xss($_POST['seller_note']),
				'goods_weight'		 		=> 0.000,
				'goods_number'		  		=> $goods_number,
				'warn_number'		   		=> $warn_number,
				'integral'			  		=> remove_xss($_POST['integral']),
				'store_best'			   	=> 0,
				'store_new'					=> 0,
				'store_hot'					=> 0,
				'is_on_sale'				=> $is_on_sale,
				'is_alone_sale'		 		=> 1,
				'is_shipping'		   		=> 0,
				'last_update'		   		=> RC_Time::gmtime(),
				'cost_price'				=> $cost_price,
				'generate_date'				=> $generate_date,
				'limit_days'				=> $limit_days_final,
				'expiry_date'				=> $expiry_date
		);
		RC_DB::table('goods')->where('goods_id', $goods_id)->update($data);

		/* 记录日志 */
		ecjia_merchant::admin_log(remove_xss($_POST['goods_name']), 'edit', 'cashier_goods');
		//为更新用户购物车数据加标记
		RC_Api::api('cart', 'mark_cart_goods', array('goods_id' => $goods_id));

		/* 处理会员价格 */
		if (isset($_POST['user_rank']) && isset($_POST['user_price'])) {
			Ecjia\App\Cashier\BulkGoods::handle_member_price($goods_id, remove_xss($_POST['user_rank']), remove_xss($_POST['user_price']));
		}

		/* 处理优惠价格 */
		if (isset($_POST['volume_number']) && isset($_POST['volume_price'])) {
			$temp_num = array_count_values(remove_xss($_POST['volume_number']));
			foreach ($temp_num as $v) {
				if ($v > 1) {
					return $this->showmessage(__('优惠数量重复！', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
					break;
				}
			}
			Ecjia\App\Cashier\BulkGoods::handle_volume_price($goods_id, remove_xss($_POST['volume_number']), remove_xss($_POST['volume_price']));
		}
		return $this->showmessage(__('编辑商品成功', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('cashier/mh_cashier_goods/edit', array('goods_id' => $goods_id))));
	}
	
	/**
	 * 收银台商品放入回收站
	 */
	public function remove() {
		$this->admin_priv('mh_bulk_goods_update', ecjia::MSGTYPE_JSON);
	
		$goods_id = intval($_GET['id']);
		$goods_name = RC_DB::table('goods')->where('goods_id', $goods_id)->pluck('goods_name');
	
		RC_DB::table('goods')->where('goods_id', $goods_id)->where('store_id', $_SESSION['store_id'])->update(array('is_delete' => 1));
	
		ecjia_merchant::admin_log(addslashes($goods_name), 'trash', 'cashier_goods');
		return $this->showmessage(__('放入回收站成功', 'cashier'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 获取商品到期日期
	 */
	public function get_expire_date() {
		$produce_date =  empty($_POST['produce_date']) ? '' : remove_xss($_POST['produce_date']);
		$limit_days =  empty($_POST['limit_days']) ? '' : remove_xss($_POST['limit_days']);
		$limit_unit =  empty($_POST['limit_unit']) ? '' : remove_xss($_POST['limit_unit']);
		
		if (!empty($produce_date) && !empty($limit_days) && !empty($limit_unit)) {
			$produce_date_str = RC_Time::local_strtotime($produce_date);
			
			$exppire_date = Ecjia\App\Cashier\BulkGoods::expiry_date($produce_date, $limit_days, $limit_unit);
			
			$result = array();
			$result = array('status' => 1, 'expiry_date' => $exppire_date);
			return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, $result);
		}
	}
	
	/**
	 * 获得商家收银台商品列表
	 * @return array
	 */
	private function cashier_goods_list() {
		/* 过滤条件 */
		$filter ['keywords'] 		= empty ($_GET['keywords']) 		? '' 	: remove_xss($_GET['keywords']);
		$filter ['type'] 			= !empty($_GET['type']) 			? remove_xss($_GET['type']) : '';
	
		$filter ['sort_by'] 		= empty($_GET['sort_by']) 	? 'store_sort_order' : remove_xss($_GET['sort_by']);
		$filter ['sort_order'] 		= empty($_GET['sort_order'])? 'asc' 			: remove_xss($_GET['sort_order']);
	
		$db_goods = RC_DB::table('goods');
		$db_goods->where('store_id', $_SESSION['store_id'])->where('is_delete', 0)->where('extension_code', 'cashier');
		
		/* 关键字 */
		if (!empty ($filter ['keywords'])) {
			$db_goods->whereRaw("(goods_name LIKE '%" . mysql_like_quote($filter ['keywords']) . "%' OR goods_sn LIKE '%" . mysql_like_quote($filter ['keywords']) . "%')");
		}
	
		//筛选全部 已上架 未上架 商家
		$filter_count = $db_goods
		->select(RC_DB::raw('count(goods_id) as count_goods_num, SUM(IF(is_on_sale = 1, 1, 0)) as count_on_sale, SUM(IF(is_on_sale = 0, 1, 0)) as count_not_sale'))->first();

        $filter_count['count_goods_num'] = isset($filter_count['count_goods_num']) ? $filter_count['count_goods_num'] : 0;
        $filter_count['count_on_sale'] = isset($filter_count['count_on_sale']) ? $filter_count['count_on_sale'] : 0;
        $filter_count['count_not_sale'] = isset($filter_count['count_not_sale']) ? $filter_count['count_not_sale'] : 0;
		$dbgoods = RC_DB::table('goods')
			->where('store_id', $_SESSION['store_id'])
			->where('is_delete', 0)
            ->where('extension_code', 'cashier');

		/* 关键字 */
		if (!empty ($filter ['keywords'])) {
            $dbgoods->whereRaw("(goods_name LIKE '%" . mysql_like_quote($filter ['keywords']) . "%' OR goods_sn LIKE '%" . mysql_like_quote($filter ['keywords']) . "%')");
        }
        if ($filter ['type'] == '1') {
            $dbgoods->where('is_on_sale', 1);
        } elseif ($filter ['type'] == '2') {
            $dbgoods->where('is_on_sale', 0);
        }

		/* 记录总数 */
		$count = $dbgoods->count('goods_id');
		$page = new ecjia_merchant_page ($count, 10, 3);
		$filter ['count'] 	= $filter_count;
	
		$row = $dbgoods
		->select('goods_id', 'goods_name', 'goods_type', 'goods_sn', 'shop_price', 'goods_thumb', 'is_on_sale', 'store_best', 'store_new', 'store_hot', 'store_sort_order', 'goods_number', 'sales_volume', 'integral', 'review_status')
		->orderBy($filter ['sort_by'], $filter['sort_order'])
		->orderBy('goods_id', 'desc')
		->take(10)
		->skip($page->start_id-1)
		->get();
		
		$filter ['keywords'] = stripslashes($filter ['keywords']);
		return array(
				'goods'		=> $row,
				'filter'	=> $filter,
				'page'		=> $page->show(2),
				'desc'		=> $page->page_desc()
		);
	}
}

// end