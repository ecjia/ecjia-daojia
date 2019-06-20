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
 * 商铺推荐商品列表
 * @author will.chen
 */
class merchant_goods_storebuy_suggestlist_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

    	$this->authSession();
    	$filter = $this->requestData('filter', array());
		$type = array('new', 'best', 'hot', 'promotion');//推荐类型
		$keyword = RC_String::unicode2string($filter['keywords']);
		$category = !empty($filter['category_id']) ? $filter['category_id'] : 0;  //商家商品分类
		$sort_type = $filter['sort_by'];
		$store_id = $this->requestData('store_id');
		$action_type = $this->requestData('action_type', '');

		if (!in_array($action_type, $type)) {
			return new ecjia_error( 'invalid_parameter', sprintf(__('请求接口%s参数无效', 'merchant'), __CLASS__));
		}

		$promotion_type = $this->requestData('promotion_type', '');
		$promotion_type_arr = array('today', 'tomorrow', 'aftertheday');//促销类型（实际为促销开始时间）
		
		if (!empty($promotion_type) && !in_array($promotion_type, $promotion_type_arr)) {
			return new ecjia_error('invalid_parameter', __('促销类型参数错误', 'goods'));
		}
		
		$size = $this->requestData('pagination.count', 15);
		$page = $this->requestData('pagination.page', 1);

		switch ($sort_type) {
			case 'new' :
				$order_by = array('goods.sort_order' => 'asc', 'goods.goods_id' => 'desc');
				break;
			case 'price_desc' :
				$order_by = array('goods.shop_price' => 'desc', 'goods.sort_order' => 'asc');
				break;
			case 'price_asc' :
				$order_by = array('goods.shop_price' => 'asc', 'goods.sort_order' => 'asc');
				break;
			case 'last_update' :
				$order_by = array('goods.last_update' => 'desc');
				break;
			case 'hot' :
				$order_by = array('goods.click_count' => 'desc', 'goods.sort_order' => 'asc');
				break;
			default :
				$order_by = array('goods.sort_order' => 'asc', 'goods.goods_id' => 'desc');
				break;
		}

		//用户端商品展示基础条件
		$filters = [
			'store_unclosed' 		=> 0,    //店铺未关闭的
			'is_delete'		 		=> 0,	 //未删除的
			'is_on_sale'	 		=> 1,    //已上架的
			'is_alone_sale'	 		=> 1,	 //单独销售的
			'review_status'  		=> 2,    //审核通过的
			'no_need_cashier_goods'	=> true, //不需要收银台商品和散装商品
		];
		//是否展示货品
		if (ecjia::config('show_product') == 1) {
			$filters['product'] = true;
		}
		//店铺id
		if (!empty($store_id)) {
			$filters['store_id'] = $store_id;
		}
    	//商家商品分类
		if ($category > 0 && !empty($store_id)) {
		    $children_cat = Ecjia\App\Goods\GoodsSearch\MerchantGoodsCategory::getChildrenCategoryId($category, $store_id);
		    $filters['store_id_and_merchant_cat_id'] = [$children_cat, $store_id];
		}
		//店铺推荐，新品，热销
		if (!empty($action_type)) {
			if ($action_type == 'best') {
				$filters['store_best'] = 1;
			} elseif ($action_type == 'new') {
				$filters['store_new'] = 1;
			} elseif ($action_type == 'hot') {
				$filters['store_hot'] = 1;
			} elseif ($action_type == 'promotion') {
				$filters['product'] = true;
				if (!empty($promotion_type)) {
					$filters['goods_and_product_promotion_type'] = $promotion_type;
				} else {
					$filters['goods_and_product_promotion'] = true;
				}
				//促销，排序默认结束时间升序
				$order_by = array('goods.promote_end_date' => 'asc', 'goods.sort_order' => 'asc', 'goods.goods_id' => 'desc');
			}
		}
		//关键字
		if (!empty($keyword)) {
			$filters['keywords'] = $keyword;
		}
		//排序
		if (!empty($order_by)) {
			$filters['sort_by'] = $order_by;
		}
		//会员等级价格
		$filters['user_rank'] = $_SESSION['user_rank'];
		$filters['user_rank_discount'] = $_SESSION['discount'];
		//分页信息
		$filters['size'] = $size;
		$filters['page'] = $page;
		
		$collection = (new \Ecjia\App\Goods\GoodsSearch\GoodsApiCollection($filters))->getData();
		
		//更新店铺搜索关键字
		if (!empty($keyword) && !empty($store_id)) {
			RC_Api::api('stats', 'update_store_keywords', array('store_id' => $store_id, 'keywords' => $keyword));
		}
		
		return array('data' => $collection['goods_list'], 'pager' => $collection['pager']);
		
		//1.30以前逻辑
// 		$options = array(
// 			'store_intro'		=> $action_type,
// 			'merchant_cat_id'	=> $category,
// 			'store_id'  		=> $store_id,
// 			'keywords'			=> $keyword,
// 			'sort'				=> $order_by,
// 			'page'				=> $page,
// 			'size'				=> $size,
// 		    'product'   => 1,
// 		);

// 		$result = RC_Api::api('goods', 'goods_list', $options);
		
// 		//更新店铺搜索关键字
// 		if (!empty($keyword) && !empty($store_id)) {
// 			RC_Api::api('stats', 'update_store_keywords', array('store_id' => $store_id, 'keywords' => $keyword));
// 		}
// 		if ($result) {
// 		    RC_Loader::load_app_func('admin_goods', 'goods');
// 			foreach ($result['list'] as $val) {
// 				/* 判断是否有促销价格*/
// 				$price = ($val['unformatted_shop_price'] > $val['unformatted_promote_price'] && $val['unformatted_promote_price'] > 0) ? $val['unformatted_promote_price'] : $val['unformatted_shop_price'];
// 				$activity_type = ($val['unformatted_shop_price'] > $val['unformatted_promote_price'] && $val['unformatted_promote_price'] > 0) ? 'PROMOTE_GOODS' : 'GENERAL_GOODS';
// 				/* 计算节约价格*/
// 				$saving_price = ($val['unformatted_shop_price'] > $val['unformatted_promote_price'] && $val['unformatted_promote_price'] > 0) ? $val['unformatted_shop_price'] - $val['unformatted_promote_price'] : (($val['unformatted_market_price'] > 0 && $val['unformatted_market_price'] > $val['unformatted_shop_price']) ? $val['unformatted_market_price'] - $val['unformatted_shop_price'] : 0);

// // 				$properties = get_goods_properties($val['goods_id']); // 获得商品的规格和属性
// 				$data['list'][] = array(
// 						'id' => $val['goods_id'],
// 						'name' => $val['name'].$val['goods_attr_name'],
// 		        	    'goods_sn' => empty($val['product_sn']) ? $val['goods_sn'] : $val['product_sn'],
// 						'market_price' => $val['market_price'],
// 				        'unformatted_market_price' => $val['unformatted_market_price'],
// 						'shop_price' => $val['shop_price'],
// 				        'unformatted_shop_price' => $val['unformatted_shop_price'],
// 						'promote_price' => $val['promote_price'],
// 				        'unformatted_promote_price' => $val['unformatted_promote_price'],
// 						'img' => array(
// 								'thumb' => $val['goods_thumb'],
// 								'url' => $val['original_img'],
// 								'small' => $val['goods_img']
// 						),
//     				    'properties' => array(),//$properties['pro'],
// 		            'specification' => array(),//array_values($properties['spe']),
// 						'activity_type' => $activity_type,
// 						'object_id' => 0,
// 						'saving_price' => $saving_price,
// 						'formatted_saving_price' => $saving_price > 0 ? __('已省', 'merchant') . $saving_price . __('元', 'merchant') : ''
// 				);
// 			}
// 			$data['pager'] = array(
// 					'total' => $result['page']->total_records,
// 					'count' => $result['page']->total_records,
// 					'more' => $result['page']->total_pages <= $page ? 0 : 1,
// 			);

// 		}

// 		return array('data' => $data['list'], 'pager' => $data['pager']);
	}
}

// end
