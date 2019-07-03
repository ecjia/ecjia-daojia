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
 * @author zrl
 */
class admin_merchant_goods_list_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

		$this->authadminSession();
		if ($_SESSION['store_id'] <= 0 || $_SESSION['staff_id'] <= 0) {
			return new ecjia_error(100, 'Invalid session');
		}
		if (!$this->admin_priv('goods_manage')) {
			return new ecjia_error('privilege_error', __('对不起，您没有执行此项操作的权限！', 'goods'));
		}

		$on_sale		= $this->requestData('on_sale', 'true');//true已上架, false已下架（字符串，非bool值）
		$stock			= $this->requestData('stock');//是否售罄 :true有货 , false售罄
		$sort			= $this->requestData('sort_by', '');//默认: sort_order  其他: price_desc, price_asc, stock, click_asc, clcik_desc
		$keywords		= $this->requestData('keywords', '');
		$category_id 	= $this->requestData('category_id', 0);  //商家分类id
		$check_status	= $this->requestData('check_status', 'await_check'); //审核状态：await_check待审核，check_refused审核被拒
		$list_type		= $this->requestData('list_type', 'selling'); //列表类型（selling在售列表,soldout售罄列表，check审核商品，obtained已下架商品，bulk散装商品，cashier收银台商品）
		
		$size = $this->requestData('pagination.count', 15);
		$page = $this->requestData('pagination.page', 1);
		
		$store_id = $_SESSION['store_id'];

		$sort_by = '';
		/* 推荐类型 */
		switch ($sort) {
			case 'sort_order' :
				$sort_by = array('goods.sort_order' => 'asc', 'goods.goods_id' => 'desc');
				break;
			case 'price_desc' :
				$sort_by = array('goods.shop_price' => 'desc', 'goods.goods_id' => 'desc');
				break;
			case 'price_asc' :
				$sort_by = array('goods.shop_price' => 'asc', 'goods.goods_id' => 'desc');
				break;
			case 'stock' :
				$sort_by = array('goods.goods_number' => 'asc', 'goods.goods_id' => 'desc');
				break;
			case 'click_asc' :
				$sort_by = array('goods.click_count' => 'asc', 'goods.goods_id' => 'desc');
				break;
			case 'click_desc' :
				$sort_by = array('goods.click_count' => 'desc', 'goods.goods_id' => 'desc');
				break;
			default:
				$sort_by = array('goods.add_time' => 'desc');
				break;
		}
		
		if ($list_type == 'soldout') { //售罄列表
			$input = [
			'goods_number'			=> 0,
			'is_on_sale'			=> 0,
			'check_review_status'	=> array(3, 5),
			'is_real'				=> 1,
			'no_need_cashier_goods'	=> true
			];
		} elseif ($list_type == 'check') { //审核商品
			$input = [
			'is_real'	=> 1,
			'no_need_cashier_goods' => true,
			];
			if ($check_status == 'await_check') {
				$input['check_review_status'] = 1; //待审核
			} else {
				$input['check_review_status'] = 2; //审核未通过
			}
		} elseif ($list_type == 'obtained') { //已下架商品
			$input = [
			'goods_number' 			=> array('>', 0),
			'is_on_sale'			=> 0,
			'check_review_status'	=> array(3, 5),
			'is_real'				=> 1,
			'no_need_cashier_goods' => true,
			];
		} elseif ($list_type == 'bulk') { //散装商品
			$input = [
			'extension_code'	=> 'bulk',
			];
			if ($on_sale == 'true') {
				$input['is_on_sale'] = 1;
			} else {
				$input['is_on_sale'] = 0;
			}
		} elseif ($list_type == 'cashier') { //收银台商品
			$input = [
			'extension_code'	=> 'cashier',
			];
			if ($on_sale == 'true') {
				$input['is_on_sale'] = 1;
			} else {
				$input['is_on_sale'] = 0;
			}
		} else {//在售列表
			$input = [
			'is_real'				=> 1,
			'is_on_sale'			=> 1,
			'check_review_status'	=> array(3, 5),
			'no_need_cashier_goods'	=> true,
			];
		}
		
		//共有基础条件
		$input['store_id'] 	= $store_id;
		$input['is_delete'] = 0;
		
		//共有可能条件
		if (!empty($category_id)) {
			$input['store_id_and_merchant_cat_id'] = [$category_id, $store_id];
		}
		if (!empty($keywords)) {
			$input['keywords'] = $keywords;
		}
		
		//排序
		if (!empty($sort_by)) {
			$input['sort_by'] = $sort_by;
		}
		//分页信息
		$input['size'] = $size;
		$input['page'] = $page;
		
		$collection = (new \Ecjia\App\Goods\GoodsSearch\GoodsAdminApiCollection($input))->getData();
		
		return array('data' => $collection['goods_list'], 'pager' => $collection['pager']);
	}
}

// end