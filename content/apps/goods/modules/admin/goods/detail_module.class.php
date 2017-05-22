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
 * 商品详情
 * @author luchongchong
 */
class detail_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

		$this->authadminSession();
		if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
			return new ecjia_error(100, 'Invalid session');
		}
		if (!$this->admin_priv('goods_manage')) {
			return new ecjia_error('privilege_error', '对不起，您没有执行此项操作的权限！');
		}

		$id = $this->requestData('goods_id',0);
    	if (empty($id)) {
			return new ecjia_error('invalid_parameter', RC_Lang::get('system::system.invalid_parameter'));
		}else {
			$where['goods_id'] = $id;
		}
// 		$where['is_delete'] = 0;
		$db_goods = RC_Model::model('goods/goods_model');

		if ($_SESSION['store_id'] > 0) {
			$where = array_merge($where, array('store_id' => $_SESSION['store_id']));
		}
		$row = $db_goods->find($where);
		if (empty($row)) {
			return new ecjia_error('not_exists_info', '不存在的信息');
		} else {
		    RC_Loader::load_app_func('admin_category', 'goods');
			$brand_db		= RC_Model::model('goods/brand_model');
			$category_db	= RC_Model::model('goods/category_model');

			$brand_name = $row['brand_id'] > 0 ? $brand_db->where(array('brand_id' => $row['brand_id']))->get_field('brand_name') : '';
			$category_name = $category_db->where(array('cat_id' => $row['cat_id']))->get_field('cat_name');
			$merchant_category = RC_Model::model('goods/merchants_category_model')->where(array('cat_id' => $row['merchant_cat_id']))->get_field('cat_name');
			$goods_desc_url = null;
			if ($row['goods_desc']) {
			    if (ecjia_config::has('mobile_touch_url')) {
			        $goods_desc_url = ecjia::config('mobile_touch_url').'index.php?m=goods&c=index&a=init&id='.$id.'&hidenav=1&hidetab=1';
			    } else {
			        $goods_desc_url = null;
			    }
			}
			
			if ($row['promote_price'] > 0) {
				$promote_price = $row['promote_price'];//bargain_price($row['promote_price'], $row['promote_start_date'], $row['promote_end_date']);
			} else {
				$promote_price = 0;
			}
			$goods_detail = array(
				'goods_id'				=> $row['goods_id'],
				'name'					=> $row['goods_name'],
				'goods_sn'				=> $row['goods_sn'],
				'brand_name' 			=> $brand_name,
			    'category_id'	        => $row['cat_id'],
				'category_name' 		=> $category_name,
			    'category'              => get_parent_cats($row['cat_id']),
			    'merchant_category_id'	=> empty($row['merchant_cat_id']) ? 0 : $row['merchant_cat_id'],
			    'merchant_category_name'=> empty($merchant_category) ? '' : $merchant_category,
			    'merchant_category'     => get_parent_cats($row['merchant_cat_id'], 1, $_SESSION['store_id']),
				'market_price'			=> price_format($row['market_price'] , false),
				'shop_price'			=> price_format($row['shop_price'] , false),
				'promote_price'			=> price_format($promote_price , false),
				'promote_start_date'	=> RC_Time::local_date('Y-m-d H:i:s', $row['promote_start_date']),
				'promote_end_date'		=> RC_Time::local_date('Y-m-d H:i:s', $row['promote_end_date']),
				'clicks'				=> intval($row['click_count']),
				'stock'					=> (ecjia::config('use_storage') == 1) ? $row['goods_number'] : '',
				'sales_volume'          => $row['sales_volume'],
			    'goods_weight'			=> $row['goods_weight']  = (intval($row['goods_weight']) > 0) ? $row['goods_weight'] . __('千克') : ($row['goods_weight'] * 1000) . __('克'),
				'is_promote'			=> $row['is_promote'] == 1 ? 1 : 0,
				'is_best'				=> $row['is_best'] == 1 ? 1 : 0,
				'is_new'				=> $row['is_new'] == 1 ? 1 : 0,
				'is_hot'				=> $row['is_hot'] == 1 ? 1 : 0,
				'is_shipping'			=> $row['is_shipping'] == 1 ? 1 : 0,
				'is_on_sale'			=> $row['is_on_sale'] == 1 ? 1 : 0,
				'is_alone_sale'	 		=> $row['is_alone_sale'] == 1 ? 1 : 0,
				'last_updatetime' 		=> RC_Time::local_date(ecjia::config('time_format'), $row['last_update']),
				'goods_desc' 			=> $goods_desc_url,
				'img' => array(
					'thumb'	=> !empty($row['goods_img']) ? RC_Upload::upload_url($row['goods_img']) : '',
					'url'	=> !empty($row['original_img']) ? RC_Upload::upload_url($row['original_img']) : '',
					'small'	=> !empty($row['goods_thumb']) ? RC_Upload::upload_url($row['goods_thumb']) : '',
				),
				'unformatted_shop_price'	=> $row['shop_price'],
				'unformatted_market_price'	=> $row['market_price'],
				'unformatted_promote_price'	=> $row['promote_price'],
				'give_integral'				=> $row['give_integral'],
				'rank_integral'				=> $row['rank_integral'],
				'integral'					=> $row['integral'],
			);

			RC_Loader::load_app_func('global', 'goods');
			RC_Loader::load_app_func('admin_user', 'user');

			$goods_detail['user_rank'] = array();

			$discount_price = get_member_price_list($id);
			$user_rank = get_rank_list();
		    if(!empty($user_rank)){
		    	foreach ($user_rank as $key=>$value){
		    		$goods_detail['user_rank'][]=array(
	    				'rank_id'	 => $value['rank_id'],
	    				'rank_name'	 => $value['rank_name'],
	    				'discount'	 => $value['discount'],
	    			    'price'		 => !empty($discount_price[$value['rank_id']])?$discount_price[$value['rank_id']]:'-1',
		    		);
		    	}
		    }
		    $goods_detail['volume_number'] = array();
		    $volume_number = '';
		    $volume_number = get_volume_price_list($id);

		    if(!empty($volume_number)) {
		    	foreach ($volume_number as $key=>$value) {
		    		$goods_detail['volume_number'][] =array(
		    			   'number'	=> $value['number'],
		    			   'price'	=> $value['price']
		    		);
		    	}
		    }
		    $pictures = get_goods_gallery($id);
		    $pictures_array = array();
		    if (!empty($pictures)) {
		        foreach ($pictures as $val) {
		            $pictures_array[] = array(
		                'img_id'	=> $val['img_id'],
		                'thumb'		=> $val['thumb'],
		                'url'		=> $val['url'],
		                'small'		=> $val['small'],
		            );
		        }
		    }
		    $goods_detail['pictures'] = $pictures_array;
			return $goods_detail;
		}
	}
}

function get_goods_gallery($goods_id) {
    $db_goods_gallery = RC_Loader::load_app_model('goods_gallery_model', 'goods');
    $row = $db_goods_gallery->field('img_id, img_url, thumb_url, img_desc, img_original')->where(array('goods_id' => $goods_id))->select();
    $img_list_sort = $img_list_id = array();
    $img = array();
    /* 格式化相册图片路径 */
    if (!empty($row)) {
        foreach ($row as $key => $gallery_img) {
            $desc_index = intval(strrpos($gallery_img['img_original'], '?')) + 1;
            !empty($desc_index) && $row[$key]['desc'] = substr($gallery_img['img_original'], $desc_index);
            $row[$key]['small']	= substr($gallery_img['img_original'], 0, 4) == 'http' ? $gallery_img['img_original'] : RC_Upload::upload_url($gallery_img['img_original']);
            $row[$key]['url']		= substr($gallery_img['img_url'], 0, 4) == 'http' ? $gallery_img['img_url'] : RC_Upload::upload_url($gallery_img['img_url']);
            $row[$key]['thumb']		= substr($gallery_img['thumb_url'], 0, 4) == 'http' ? $gallery_img['thumb_url'] : RC_Upload::upload_url($gallery_img['thumb_url']);

            $img_list_sort[$key] = $row[$key]['desc'];
            $img_list_id[$key] = $gallery_img['img_id'];
        }
        //先使用sort排序，再使用id排序。
        array_multisort($img_list_sort, $img_list_id, $row);
    }
    return $row;
}

/**
 * 判断某个商品是否正在特价促销期
 *
 * @access public
 * @param float $price
 *        	促销价格
 * @param string $start
 *        	促销开始日期
 * @param string $end
 *        	促销结束日期
 * @return float 如果还在促销期则返回促销价，否则返回0
 */
function bargain_price($price, $start, $end) {
	if ($price == 0) {
		return 0;
	} else {
		$time = RC_Time::gmtime ();
		if ($time >= $start && $time <= $end) {
			return $price;
		} else {
			return 0;
		}
	}
}

// end