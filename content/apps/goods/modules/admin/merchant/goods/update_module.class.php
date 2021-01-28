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
 * 编辑单个商品基本信息
 * @author zrl
 *
 */
class admin_merchant_goods_update_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

		$this->authadminSession();
		if ($_SESSION['staff_id'] <= 0) {
			return new ecjia_error(100, 'Invalid session');
		}
    	$result = $this->admin_priv('goods_manage');
        if (is_ecjia_error($result)) {
			return $result;
		}
    	
    	//请求参数：
    	$goods_id		= $this->requestData('goods_id', 0);
    	if (empty($goods_id)) {
    	    return new ecjia_error('invalid_parameter', sprintf(__('请求接口%s参数无效', 'goods'), __CLASS__));
    	}
    	$goods = Ecjia\App\Goods\Models\GoodsModel::where('goods_id', $goods_id)->where('store_id', $_SESSION['store_id'])->first();
    	if (empty($goods)) {
    		return new ecjia_error('not_exists_info', __('商品信息不存在！', 'goods'));
    	}
    	
    	$goods_name		= $this->requestData('goods_name');
    	if (empty($goods_name)) {
    	    return new ecjia_error('goods_name_empty', __('请输入商品名称', 'goods'));
    	}
    	$category_id			= $this->requestData('category_id', 0);
    	$merchant_category_id 	= $this->requestData('merchant_category', 0);
    	$goods_price			= $this->requestData('goods_price', 0.00);
    	$stock					= $this->requestData('stock', 0);
    	$cost_price				= $this->requestData('cost_price', 0);
    	$is_shipping			= $this->requestData('is_shipping', 'no'); 		 //yes是（1）no否（0）
    	$weight_unit			= $this->requestData('weight_unit', 'kilogram'); //gram克（1），kilogram千克（2）；默认千克
    	$bulk_goods_sn			= $this->requestData('goods_sn', '');
    	
    	if (empty($goods->extension_code)) {
    		if (empty($category_id)) {
    			return new ecjia_error('category_id_empty', __('请选择商品分类', 'goods'));
    		}
    	}
    	if (empty($merchant_category_id)) {
    	    return new ecjia_error('merchant_category_id_empty', __('请选择店铺分类', 'goods'));
    	}
    	
    	//审核状态
        if (empty($goods->extension_code)) {
            $review_status = Ecjia\App\Goods\GoodsFunction::get_review_status($_SESSION['store_id']);
        } else {
            $review_status = 3;
        }
    	//市场价处理market_price
    	if (ecjia::config('market_price_rate') > 0) {
    		$market_price = $goods_price*ecjia::config('market_price_rate');
    	} else {
    		$market_price = $goods_price;
    	}
    	
    	//是否包邮
    	if ($is_shipping == 'yes') {
    		$is_shipping = 1;
    	} else {
    		$is_shipping = 0;
    	}
    	
    	$update_data = array(
    		'goods_name' 		=> $goods_name,
    		'cat_id'			=> $category_id,
    		'merchant_cat_id'	=> $merchant_category_id,
    		'shop_price'		=> $goods_price,
    		'market_price'		=> $market_price,
    		'goods_number'		=> $stock,
    		'review_status'		=> $review_status,
    		'last_update'       => RC_Time::gmtime(),
    		'is_shipping'		=> $is_shipping,
    	);
    	
    	//散装商品部分字段判断
    	if ($goods->extension_code == 'bulk') {
    		$bulk_goods_sn_result = $this->check_bulk_goods_sn($bulk_goods_sn);
    		if (is_ecjia_error($bulk_goods_sn_result)) {
    			return $bulk_goods_sn_result;
    		}
    		$goods_sn = $bulk_goods_sn;
    		$update_data['goods_sn'] = $goods_sn;
    		
    		$weight_stock = is_numeric($stock) ? $stock : 0.000;
    		if (!in_array($weight_unit, ['gram', 'kilogram'])) {
    			return new ecjia_error('bulk_weight_unit_error', __('散装库存重量单位参数错误', 'goods'));
    		}
    		if ($weight_unit == 'gram') {
    			$weight_unit = 1;
    		} else {
    			$weight_unit = 2;
    		}
    		$update_data['weight_stock'] = $weight_stock;
    		$update_data['weight_unit'] = $weight_unit;
    	}
    	
    	$update_result = Ecjia\App\Goods\Models\GoodsModel::where('goods_id', $goods_id)->where('store_id', $_SESSION['store_id'])->update($update_data);

    	/*处理商品图片 */
    	if (empty($goods->extension_code)) {
    		$this->processGoodsImage($_FILES['goods_image'], $goods_id);
    	}
    	
    	//获取最新商品信息
    	$GoodsBasicInfo = new Ecjia\App\Goods\Goods\GoodsBasicInfo($goods_id, $_SESSION['store_id']);
    	$goods = $GoodsBasicInfo->goodsInfo();
    	
    	/* 记录日志 */
    	if ($_SESSION['store_id'] > 0) {
    	    RC_Api::api('merchant', 'admin_log', array('text' => $goods_name.__('【来源掌柜】', 'goods'), 'action' => 'edit', 'object' => 'goods'));
    	}
    	//为更新用户购物车数据加标记
    	RC_Api::api('cart', 'mark_cart_goods', array('goods_id' => $goods_id));
		
    	$today = RC_Time::gmtime();
    	$is_promote = 0;
    	$today = RC_Time::gmtime();
    	if ($goods->promote_price > 0 && $goods->promote_start_date <= $today && $goods->promote_end_date >= $today) {
    		$is_promote = 1;
    	}

    	//商品重量存在，重量单位是0的情况
    	$goods_weight_string = $this->get_goods_weight_string($goods->goods_weight, $goods->weight_unit);

        /* 分享链接*/
        $share_link = '';
        $mobile_touch_url = ecjia::config('mobile_touch_url');
        if (!empty($mobile_touch_url)) {
            /*商品分享链接*/
            $share_link = ecjia::config('mobile_touch_url').'index.php?m=goods&c=index&a=show&goods_id='.$goods_id.'&hidenav=1&hidetab=1';
        } else {
            $share_link = null;
        }
    	
    	$goods_detail = [
	    	'goods_id'					=> intval($goods->goods_id),
	    	'goods_name'				=> trim($goods->goods_name),
	    	'name'						=> trim($goods->goods_name),
	    	'goods_sn'					=> trim($goods->goods_sn),
	    	'brand_name'				=> !empty($goods->brand_model) ? $goods->brand_model->brand_name : '',
	    	'category_id'				=> intval($goods->cat_id),
	    	'category_name'				=> !empty($goods->category_model) ? $goods->category_model->cat_name : '',
	    	'category'					=> $goods->cat_id > 0 ? Ecjia\App\Goods\GoodsFunction::get_parent_cats($goods->cat_id, 1, $_SESSION['store_id']) : [],
	    	'merchant_category_id'		=> intval($goods->merchant_cat_id),
	    	'merchant_category_name'	=> !empty($goods->merchants_category_model) ? $goods->merchants_category_model->cat_name : '',
	    	'merchant_category'			=> $goods->merchant_cat_id > 0 ? Ecjia\App\Goods\GoodsFunction::get_parent_cats($goods->merchant_cat_id, 1, $_SESSION['store_id']) : [],
	    	'market_price'				=> ecjia_price_format($goods->market_price, false),
	    	'shop_price'				=> ecjia_price_format($goods->shop_price, false),
	    	'cost_price'				=> ecjia_price_format($goods->cost_price, false),
	    	'promote_price'				=> ecjia_price_format($goods->promote_price , false),
	    	'promote_start_date'		=> !empty($goods->promote_start_date) ? RC_Time::local_date('Y-m-d H:i:s', $goods->promote_start_date) : '',
	    	'promote_end_date'			=> !empty($goods->promote_end_date) ? RC_Time::local_date('Y-m-d H:i:s', $goods->promote_end_date) : '',
	    	'clicks'					=> intval($goods->click_count),
	    	'stock'						=> (ecjia::config('use_storage') == 1) ? $goods->goods_number : 0,
	    	'weight_unit'				=> $goods->weight == '1' ? 'gram' : 'kilogram',
	    	'weight_stock'				=> $goods->weight_stock,
	    	'sales_volume'				=> $goods->sales_volume,
	    	'goods_weight'				=> $goods_weight_string,
	    	'is_promote'				=> $is_promote,
	    	'is_best'					=> intval($goods->store_best),
	    	'is_new'					=> intval($goods->store_new),
	    	'is_hot'					=> intval($goods->store_hot),
	    	'is_shipping'				=> intval($goods->is_shipping),
	    	'is_on_sale'				=> intval($goods->is_on_sale),
	    	'is_alone_sale'				=> intval($goods->is_alone_sale),
	    	'last_updatetime'			=> !empty($goods->last_update) ? RC_Time::local_date('Y-m-d H:i:s', $goods->last_update) : '',
	    	'goods_desc' 				=> '',
	    	'img' 						=> array(
								    			'thumb'	=> !empty($goods->goods_img) ? RC_Upload::upload_url($goods->goods_img) : '',
								    			'url'	=> !empty($goods->original_img) ? RC_Upload::upload_url($goods->original_img) : '',
								    			'small'	=> !empty($goods->goods_thumb) ? RC_Upload::upload_url($goods->goods_thumb) : '',
								    		),
	    	'unformatted_shop_price'	=> $goods->shop_price,
	    	'unformatted_cost_price'	=> $goods->cost_price,
	    	'unformatted_market_price'	=> $goods->market_price,
	    	'unformatted_promote_price'	=> $goods->promote_price,
	    	'give_integral'				=> $goods->give_integral,
	    	'rank_integral'				=> $goods->rank_integral,
	    	'integral'					=> $goods->integral,
	    	'extension_code'			=> empty($goods->extension_code) ? 'common' : $goods->extension_code,
            'share_link'                => $share_link,
    	];
    
	    //会员等级价
	    $goods_detail['user_rank'] = $this->get_user_rank_price($goods);
	    
	    //优惠阶梯价
	    if ($goods->volume_price_collection) {
	    	$goods_detail['volume_number'] = $this->get_volume_number($goods->volume_price_collection);
	    } else {
	    	$goods_detail['volume_number'] = [];
	    }
	  
    	$goods_detail['pictures'] = array();
    	
    	return $goods_detail;
    }

    /**
     * 处理普通商品图片上传
     */
    private function processGoodsImage($file_goods_image, $goods_id)
    {
    	$proc_goods_img = false;
    	if ($file_goods_image) {
    		$proc_goods_img = true;
    	}
    	
    	$upload = RC_Upload::uploader('newimage', array('save_path' => 'images', 'auto_sub_dirs' => true));
    	$upload->add_saving_callback(function ($file, $filename) {
    		return true;
    	});
    	
    	if ($proc_goods_img) {
    		$image_info = $upload->upload('goods_image');
    		if (empty($image_info)) {
    			return new ecjia_error('upload_error', $upload->error());
    		}
    		if (!empty($image_info)) {
    			$goods_image = new \Ecjia\App\Goods\GoodsImage\Goods\GoodsImage($goods_id, 0, $image_info);
    			$goods_image->setAutoGenerateThumb(true);
    			$result = $goods_image->updateToDatabase($goods_id);
    			if (is_ecjia_error($result)) {
    				return new ecjia_error('upload_error', $result->get_error_message());
    			}
    		}
    	}
    	return true;
    }
    
    /**
     * 散装商品货号检查
     * @param string $bulk_goods_sn
     * @return ecjia_error|boolean
     */
    private function check_bulk_goods_sn($bulk_goods_sn)
    {
    	$goods_sn = $bulk_goods_sn;
    	if (empty($goods_sn)) {
    		return new ecjia_error('bulk_goods_sn_error', __('请填写散装商品货号！', 'goods'));
    	}
    	//商品货号
    	if (!empty($goods_sn)) {
    		//散装商品货号为7位
    		$goods_sn_length = strlen($goods_sn);
    		if ($goods_sn_length != 7) {
    			return new ecjia_error('bulk_goods_sn_error', __('散装商品货号必须为7位', 'goods'));
    		}
    		/* 检查货号是否重复 */
    		$count = RC_DB::table('goods')->where('goods_sn', $goods_sn)->where('store_id', $_SESSION['store_id'])->count();
    		if ($count > 0) {
    			return new ecjia_error('bulk_goods_sn_exist', __('您输入的货号已存在，请换一个', 'goods'));
    		}
    		$scales_sn = substr($goods_sn, 0, 2);
    		$cashdesk_scales_sn_arr = Ecjia\App\Cashier\BulkGoods::get_scales_sn_arr($_SESSION['store_id']);//商家所有条码秤编码
    		if (empty($cashdesk_scales_sn_arr)) {
    			return new ecjia_error('pls_add_scales', __('请先添加条码秤！', 'goods'));
    		}
    		if (!in_array($scales_sn, $cashdesk_scales_sn_arr)) {
    			return new ecjia_error('bulk_goods_sn_error', __('请检查商品货号，散装商品货号前2位必须为条码秤编码！', 'goods'));
    		}
    	}
    	
    	return true;
    }
    
    
    /**
     * 商品重量显示处理
     * @param int $goods_weight
     * @param int $weight_unit
     * @return string
     */
    private function get_goods_weight_string($goods_weight, $weight_unit)
    {
    	$goods_weight_string = '';
    	if ($goods_weight > 0) {
    		if (empty($weight_unit)) {
    			if ($goods_weight >= 1 ) {
    				$goods_weight_string = $goods_weight.'千克';
    			} else {
    				$goods_weight_string = ($goods_weight*1000).'克';
    			}
    		} else {
    			if ($weight_unit == 2 ) {
    				$goods_weight_string = $goods_weight.'千克';
    			} else {
    				if ($goods_weight < 1){
    					$str = '克';
    					$goods_weights = $goods_weight*1000;
    				} else {
    					$str = '克';
    					$goods_weights = $goods_weight;
    				}
    				$goods_weight_string =$goods_weights.$str;
    			}
    		}
    	}
    		
    	return $goods_weight_string;
    }
    
    
    /**
     * 获取商品会员等级价
     * @param object $goods
     * @return array
     */
    private function get_user_rank_price($goods)
    {
    	$user_rank_price = [];
    	if ($goods->member_price_collection) {
    		$data = $goods->member_price_collection->toArray();
    		$discount_price = array();
    		if (!empty($data)) {
    			foreach ($data as $row) {
    				$discount_price[$row ['user_rank']] = $row ['user_price'];
    			}
    		}
    			
    		$user_rank = RC_DB::table('user_rank')->orderBy('min_points', 'asc')->get();
    		if(!empty($user_rank)){
    			foreach ($user_rank as $key	=>	$value){
    				$user_rank_price[]=array(
    						'rank_id'	 => $value['rank_id'],
    						'rank_name'	 => $value['rank_name'],
    						'discount'	 => $value['discount'],
    						'price'		 => !empty($discount_price[$value['rank_id']])?$discount_price[$value['rank_id']]:'-1',
    				);
    			}
    		}
    	}
    	return $user_rank_price;
    }
    
    /**
	 * 商品优惠价格
	 * @param object  $volume_number
	 * @return array
	 */
	private function get_volume_number($volume_number)
	{
		$result = [];
		if(!empty($volume_number)) {
			$result = $volume_number->map(function ($item) {
				$arr = [
					'number' => $item->volume_number,
					'price'	 => $item->volume_price
				];
				return $arr;
			});
		}
		 
		return $result;
	}
}