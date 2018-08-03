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
defined('IN_ROYALCMS') or exit('No permission resources.');

RC_Loader::load_sys_class('ecjia_front', false);
class index extends ecjia_front {
	private $db_goods;
	private $dbview;
	private $db_cart;
	public function __construct() {
		parent::__construct();
		
  		RC_Loader::load_app_func('global');
  		RC_Loader::load_app_func('goods','goods');
  		$this->db_goods = RC_Loader::load_app_model('goods_model','goods');
  		$this->dbview = RC_Loader::load_app_model('goods_attr_viewmodel','goods');
  		$this->db_cart = RC_Loader::load_app_model('cart_model','flow');
  		$this->assign_lang();
  		
	}
	
	/**
	 * 首页
	 */
	public function init() {

// 		define('IN_ECS', true);
		
// 		require(SITE_PATH . '/includes/init.php');

		global $ecs, $db, $_CFG, $sess, $_LANG, $smarty;
		
		if ((DEBUG_MODE & 2) != 2)
		{
			$this->caching = true;
		}
		
		/*------------------------------------------------------ */
		//-- act 操作项的初始化
		/*------------------------------------------------------ */
// 		if (empty($_REQUEST['act']))
// 		{
// 			$_REQUEST['act'] = 'list';
// 		}
		
	}
	
	
	/*------------------------------------------------------ */
	//-- 团购商品 --> 团购活动商品列表
	/*------------------------------------------------------ */
	public function lists(){
		
// 		define('IN_ECS', true);
// 		require(SITE_PATH . '/includes/init.php');
		global $ecs, $db, $_CFG, $sess, $_LANG, $smarty;
		
		if ((DEBUG_MODE & 2) != 2)$this->caching = true;
		
		/* 取得团购活动总数 */
		$count = group_buy_count();
		if ($count > 0)
		{
			/* 取得每页记录数 */
			$size = isset($_CFG['page_size']) && intval($_CFG['page_size']) > 0 ? intval($_CFG['page_size']) : 10;
	
			/* 计算总页数 */
			$page_count = ceil($count / $size);
	
			/* 取得当前页 */
			$page = isset($_REQUEST['page']) && intval($_REQUEST['page']) > 0 ? intval($_REQUEST['page']) : 1;
			$page = $page > $page_count ? $page_count : $page;
	
			/* 缓存id：语言 - 每页记录数 - 当前页 */
			$cache_id = $_CFG['lang'] . '-' . $size . '-' . $page;
			$cache_id = sprintf('%X', crc32($cache_id));
		}
		else
		{
			/* 缓存id：语言 */
			$cache_id = $_CFG['lang'];
			$cache_id = sprintf('%X', crc32($cache_id));
		}
	
		/* 如果没有缓存，生成缓存 */
		if (!$this->is_cached('group_buy_list.dwt', $cache_id))
		{
			if ($count > 0)
			{
				/* 取得当前页的团购活动 */
				$gb_list = group_buy_list($size, $page);
				$this->assign('gb_list',  $gb_list);
	
				/* 设置分页链接 */
				$pager = get_pager('group_buy.php', array('act' => 'list'), $count, $page, $size);
				$this->assign('pager', $pager);
			}
	
			/* 模板赋值 */
			$this->assign('cfg', $_CFG);
			$this->assign_template();
			$position = assign_ur_here();
			$this->assign('page_title', $position['title']);    // 页面标题
			$this->assign('ur_here',    $position['ur_here']);  // 当前位置
			$this->assign('categories', get_categories_tree()); // 分类树
			$this->assign('helps',      get_shop_help());       // 网店帮助
			$this->assign('top_goods',  get_top10());           // 销售排行
			$this->assign('promotion_info', get_promotion_info());
			$this->assign('feed_url',         ($_CFG['rewrite'] == 1) ? "feed-typegroup_buy.xml" : 'feed.php?type=group_buy'); // RSS URL
	
			assign_dynamic('group_buy_list');
		}
	
		/* 显示模板 */
		$this->display('group_buy_list.dwt', $cache_id);
	}
	

	/*------------------------------------------------------ */
	//-- 团购商品 --> 商品详情
	/*------------------------------------------------------ */
	public function view(){
		
// 		define('IN_ECS', true);
// 		require(SITE_PATH . '/includes/init.php');

		global $ecs, $db, $_CFG, $sess, $_LANG, $smarty;
		
		if ((DEBUG_MODE & 2) != 2)$this->caching = true;
		
		/* 取得参数：团购活动id */
		$group_buy_id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
		if ($group_buy_id <= 0)
		{
			$this->header("Location: ./\n");
			exit;
		}
	
		/* 取得团购活动信息 */
		$group_buy = group_buy_info($group_buy_id);
	
		if (empty($group_buy))
		{
			$this->header("Location: ./\n");
			exit;
		}
		//    elseif ($group_buy['is_on_sale'] == 0 || $group_buy['is_alone_sale'] == 0)
		//    {
		//        header("Location: ./\n");
		//        exit;
		//    }
	
		/* 缓存id：语言，团购活动id，状态，（如果是进行中）当前数量和是否登录 */
		$cache_id = $_CFG['lang'] . '-' . $group_buy_id . '-' . $group_buy['status'];
		if ($group_buy['status'] == GBS_UNDER_WAY)
		{
			$cache_id = $cache_id . '-' . $group_buy['valid_goods'] . '-' . intval($_SESSION['user_id'] > 0);
		}
		$cache_id = sprintf('%X', crc32($cache_id));
	
		/* 如果没有缓存，生成缓存 */
		if (!$this->is_cached('group_buy_goods.dwt', $cache_id))
		{
			$group_buy['gmt_end_date'] = $group_buy['end_date'];
			$this->assign('group_buy', $group_buy);
	
			/* 取得团购商品信息 */
			$goods_id = $group_buy['goods_id'];
			$goods = goods_info($goods_id);
			if (empty($goods))
			{
				$this->header("Location: ./\n");
				exit;
			}
			$goods['url'] = build_uri('goods', array('gid' => $goods_id), $goods['goods_name']);
			$this->assign('gb_goods', $goods);
	
			/* 取得商品的规格 */
			$properties = get_goods_properties($goods_id);
			$this->assign('specification', $properties['spe']); // 商品规格
	
			//模板赋值
			$this->assign('cfg', $_CFG);
			$this->assign_template();
	
			$position = assign_ur_here(0, $goods['goods_name']);
			$this->assign('page_title', $position['title']);    // 页面标题
			$this->assign('ur_here',    $position['ur_here']);  // 当前位置
	
			$this->assign('categories', get_categories_tree()); // 分类树
			$this->assign('helps',      get_shop_help());       // 网店帮助
			$this->assign('top_goods',  get_top10());           // 销售排行
			$this->assign('promotion_info', get_promotion_info());
			assign_dynamic('group_buy_goods');
		}
	
		//更新商品点击次数
// 		$sql = 'UPDATE ' . $db_goods->table() . ' SET click_count = click_count + 1 '.
// 				"WHERE goods_id = '" . $group_buy['goods_id'] . "'";
// 		$db_goods->query($sql);
	
		$data = array(
				'click_count' => click_count +1
		);
		$this->db_goods->where('goods_id = ' . $group_buy['goods_id'] . '')->update($data);
		
		$this->assign('now_time',  RC_Time::gmtime());           // 当前系统时间
		$this->display('group_buy_goods.dwt', $cache_id);
	}
	

	/*------------------------------------------------------ */
	//-- 团购商品 --> 购买
	/*------------------------------------------------------ */
	public function buy(){
		
// 		define('IN_ECS', true);
// 		require(SITE_PATH . '/includes/init.php');
		global $ecs, $db, $_CFG, $sess, $_LANG, $smarty;
		
		if ((DEBUG_MODE & 2) != 2)$this->caching = true;
// 		$_LANG = array_merge(RC_Loader::load_sys_lang('common'), RC_Loader::load_app_lang('user', 'user'));
		
		$this->addLang('system/common');
		$this->addLang('user/user');
		
		/* 查询：判断是否登录 */
		if ($_SESSION['user_id'] <= 0)
		{
			show_message(RC_Lang::lang('gb_error_login'), '', '', 'error');
		}
	
		/* 查询：取得参数：团购活动id */
		$group_buy_id = isset($_POST['group_buy_id']) ? intval($_POST['group_buy_id']) : 0;
		if ($group_buy_id <= 0)
		{
			$this->header("Location: ./\n");
			exit;
		}
	
		/* 查询：取得数量 */
		$number = isset($_POST['number']) ? intval($_POST['number']) : 1;
		$number = $number < 1 ? 1 : $number;
	
		/* 查询：取得团购活动信息 */
		$group_buy = group_buy_info($group_buy_id, $number);
		if (empty($group_buy))
		{
			$this->header("Location: ./\n");
			exit;
		}
	
		/* 查询：检查团购活动是否是进行中 */
		if ($group_buy['status'] != GBS_UNDER_WAY)
		{
			show_message(RC_Lang::lang('gb_error_status'), '', '', 'error');
		}
	
		/* 查询：取得团购商品信息 */
		$goods = goods_info($group_buy['goods_id']);
		if (empty($goods))
		{
			$this->header("Location: ./\n");
			exit;
		}
	
		/* 查询：判断数量是否足够 */
		if (($group_buy['restrict_amount'] > 0 && $number > ($group_buy['restrict_amount'] - $group_buy['valid_goods'])) || $number > $goods['goods_number'])
		{
			show_message(RC_Lang::lang('gb_error_goods_lacking'), '', '', 'error');
		}
	
		/* 查询：取得规格 */
		$specs = '';
		foreach ($_POST as $key => $value)
		{
			if (strpos($key, 'spec_') !== false)
			{
				$specs .= ',' . intval($value);
			}
		}
		$specs = trim($specs, ',');
	
		/* 查询：如果商品有规格则取规格商品信息 配件除外 */
		if ($specs)
		{
			$_specs = explode(',', $specs);
			$product_info = get_products_info($goods['goods_id'], $_specs);
		}
	
		empty($product_info) ? $product_info = array('product_number' => 0, 'product_id' => 0) : '';
	
		/* 查询：判断指定规格的货品数量是否足够 */
		if ($specs && $number > $product_info['product_number'])
		{
			show_message(RC_Lang::lang('gb_error_goods_lacking'), '', '', 'error');
		}
	
		/* 查询：查询规格名称和值，不考虑价格 */
		$attr_list = array();
// 		$sql = "SELECT a.attr_name, g.attr_value " .
// 				"FROM " . $db_goods_attr->table() . " AS g, " .
// 				$db_attribute->table() . " AS a " .
// 				"WHERE g.attr_id = a.attr_id " .
// 				"AND g.goods_attr_id " . db_create_in($specs);
// 		$res = $db_goods_attr->query($sql);

		$this->dbview->view =array(
				'attribute' => array(
						'type' =>Component_Model_View::TYPE_LEFT_JOIN,
						'on' => 'ecs_goods_attr.attr_id = ecs_attribute.attr_id'
				)
		);
		
		$res =  $this->dbview->field('ecs_attribute.attr_name, ecs_goods_attr.attr_value')->in(array('ecs_goods_attr.goods_attr_id' => $specs))->select();
		
		if(!empty($res))
		{
		foreach ($res as $row)
		{
			$attr_list[] = $row['attr_name'] . ': ' . $row['attr_value'];
		}
		}
		$goods_attr = join(chr(13) . chr(10), $attr_list);
	
		/* 更新：清空购物车中所有团购商品 */
// 		include_once(SITE_PATH . 'includes/lib_order.php');
		//RC_Loader::load_sys_func('order');
		RC_Loader::load_app_func('order','orders');
		clear_cart(CART_GROUP_BUY_GOODS);
	
		/* 更新：加入购物车 */
		$goods_price = $group_buy['deposit'] > 0 ? $group_buy['deposit'] : $group_buy['cur_price'];
		$cart = array(
				'user_id'        => $_SESSION['user_id'],
				'session_id'     => SESS_ID,
				'goods_id'       => $group_buy['goods_id'],
				'product_id'     => $product_info['product_id'],
				'goods_sn'       => addslashes($goods['goods_sn']),
				'goods_name'     => addslashes($goods['goods_name']),
				'market_price'   => $goods['market_price'],
				'goods_price'    => $goods_price,
				'goods_number'   => $number,
				'goods_attr'     => addslashes($goods_attr),
				'goods_attr_id'  => $specs,
				'is_real'        => $goods['is_real'],
				'extension_code' => addslashes($goods['extension_code']),
				'parent_id'      => 0,
				'rec_type'       => CART_GROUP_BUY_GOODS,
				'is_gift'        => 0
		);
// 		$db_cart->insert($cart);
	
		$this->db_cart->insert($cart);
		
		/* 更新：记录购物流程类型：团购 */
		$_SESSION['flow_type'] = CART_GROUP_BUY_GOODS;
		$_SESSION['extension_code'] = 'group_buy';
		$_SESSION['extension_id'] = $group_buy_id;
	
		/* 进入收货人页面 */
		$this->header("Location: ./flow.php?step=consignee\n");
		exit;
	}

	

}
?>