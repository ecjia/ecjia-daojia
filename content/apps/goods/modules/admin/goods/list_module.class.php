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
 * 商品列表
 * @author will
 */
class list_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

		$this->authadminSession();
		if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
			return new ecjia_error(100, 'Invalid session');
		}
		if (!$this->admin_priv('goods_manage')) {
			return new ecjia_error('privilege_error', '对不起，您没有执行此项操作的权限！');
		}

		$on_sale	= $this->requestData('on_sale');//true.在售, false.下架
		$stock		= $this->requestData('stock');//是否售罄 。true.有货 , false.售罄
		$sort		= $this->requestData('sort_by', 'sort_order');//默认: sort_order  其他: price_desc, price_asc, stock, click_asc, clcik_desc
		$keywords	= $this->requestData('keywords', '');
		$category_id = $this->requestData('category_id', 0);

		$size = $this->requestData('pagination.count', 15);
		$page = $this->requestData('pagination.page', 1);

		$sort_by = '';
		/* 推荐类型 */
		switch ($sort) {
			case 'sort_order' :
				$sort_by = array('sort_order' => 'asc', 'goods_id' => 'desc');
				break;
			case 'price_desc' :
				$sort_by = array('shop_price' => 'desc', 'goods_id' => 'desc');
				break;
			case 'price_asc' :
				$sort_by = array('shop_price' => 'asc', 'goods_id' => 'desc');
				break;
			case 'stock' :
				$sort_by = array('goods_number' => 'asc', 'goods_id' => 'desc');
				break;
			case 'click_asc' :
				$sort_by = array('click_count' => 'asc', 'goods_id' => 'desc');
				break;
			case 'click_desc' :
				$sort_by = array('click_count' => 'desc', 'goods_id' => 'desc');
				break;
		}
		$where = array();
		$where = array(
			'is_delete' => 0,
		);

		if ($_SESSION['store_id'] > 0) {
			$where = array_merge($where, array('store_id' => $_SESSION['store_id']));
		}
		if (!empty($on_sale)) {
			$where['is_on_sale'] = $on_sale == 'true' ? 1 : 0 ;
		}

		if ($stock == 'false') {
			$where['goods_number'] = 0;
		}
		if (!empty($category_id)) {
// 			RC_Loader::load_app_func('admin_category', 'goods');
// 			RC_Loader::load_app_func('admin_goods', 'goods');
// 			RC_Loader::load_app_func('global', 'goods');
// 			$children = get_children($category_id);
//             $merchant_cat_id = 'merchant_cat_id ' . db_create_in (array_unique(array_merge(array($category_id), array_keys(cat_list($category_id, 0, false )))));
// 			$where[] = "(".$children ." OR ".get_extension_goods($children) ." OR ". $merchant_cat_id .")";
		    $where['merchant_cat_id'] = $category_id;
		}
		if ( !empty($keywords)) {
			$where[] = "( goods_name like '%".$keywords."%' or goods_sn like '%".$keywords."%' )";
		}
		$db = RC_Model::model('goods/goods_viewmodel');

		/* 获取记录条数 */
		$record_count = $db->join(null)->where($where)->count();

		//实例化分页
		$page_row = new ecjia_page($record_count, $size, 6, '', $page);

		$today = RC_Time::gmtime();
		$field = "goods_id, goods_sn, goods_name, goods_number, shop_price, sales_volume, market_price, promote_price, promote_start_date, promote_end_date, click_count, goods_thumb, is_best, is_new, is_hot, is_shipping, goods_img, original_img, last_update, 
		    (promote_price > 0 AND promote_start_date <= ' . $today . ' AND promote_end_date >= ' . $today . ')|is_promote";
		$data = $db->join(null)->field($field)->where($where)->order($sort_by)->limit($page_row->limit())->select();

		$goods_list = array();
		if (!empty($data)) {
			RC_Loader::load_app_func('admin_goods', 'goods');
			RC_Loader::load_sys_func('global');
			foreach ($data as $key => $val) {
				if ($val['promote_price'] > 0) {
					$promote_price = $val['promote_price'];//bargain_price($val['promote_price'], $val['promote_start_date'], $val['promote_end_date']);
				} else {
					$promote_price = 0;
				}
				$goods_list[] = array(
					'goods_id'			=> $val['goods_id'],
					'name'				=> $val['goods_name'],
					'goods_sn'			=> $val['goods_sn'],
					'market_price'		=> price_format($val['market_price'] , false),
					'shop_price'		=> price_format($val['shop_price'] , false),
				    'is_promote'	=> $val['is_promote'],
				    'promote_price'	=> price_format($promote_price , false),
				    'promote_start_date'	=> intval($val['promote_start_date']),
				    'promote_end_date'		=> intval($val['promote_end_date']),
				    'formatted_promote_start_date'	=> !empty($val['promote_start_date']) ? RC_Time::local_date('Y-m-d H:i:s', $val['promote_start_date']) : '',
				    'formatted_promote_end_date'	=> !empty($val['promote_end_date']) ? RC_Time::local_date('Y-m-d H:i:s', $val['promote_end_date']) : '',
				    'clicks'		=> intval($val['click_count']),
					'stock'				=> (ecjia::config('use_storage') == 1) ? $val['goods_number'] : '',
					'goods_weight'		=> $val['goods_weight']  = (intval($val['goods_weight']) > 0) ? $val['goods_weight'] . __('千克') : ($val['goods_weight'] * 1000) . __('克'),
					'is_best'			=> $val['is_best'] == 1 ? 1 : 0,
					'is_new'			=> $val['is_new'] == 1 ? 1 : 0,
					'is_hot'			=> $val['is_hot'] == 1 ? 1 : 0,
					'is_shipping'		=> $val['is_shipping'] == 1 ? 1 : 0,
					'last_updatetime' 	=> RC_Time::local_date(ecjia::config('time_format'), $val['last_update']),
				    'sales_volume'	=> $val['sales_volume'],
				    'img' => array(
						'thumb'	=> !empty($val['goods_img']) ? RC_Upload::upload_url($val['goods_img']) : '',
						'url'	=> !empty($val['original_img']) ? RC_Upload::upload_url($val['original_img']) : '',
						'small'	=> !empty($val['goods_thumb']) ? RC_Upload::upload_url($val['goods_thumb']) : '',
					)
				);
			}
		}

		$pager = array(
			'total' => $page_row->total_records,
			'count' => $page_row->total_records,
			'more'	=> $page_row->total_pages <= $page ? 0 : 1,
		);
		return array('data' => $goods_list, 'pager' => $pager);
	}
}

// end