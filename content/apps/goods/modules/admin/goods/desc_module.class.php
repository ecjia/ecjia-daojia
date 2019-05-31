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
 * 单个商品的详情描述
 * @author royalwang
 */
class admin_goods_desc_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

		$this->authadminSession();
		if ($_SESSION['staff_id'] <= 0) {
			return new ecjia_error(100, 'Invalid session');
		}
		
        /* 获得商品的信息 */
    	$goods_id = $this->requestData('goods_id', 0);

		//RC_Loader::load_app_func('admin_goods', 'goods');
        $goods = $this->get_goods_info($goods_id);
        if ($goods === false) {
            /* 如果没有找到任何记录则跳回到首页 */
           	return new ecjia_error('not_exists_info', __('不存在的信息', 'goods'));
        } else {
        	if ($_SESSION['store_id'] > 0 && $_SESSION['store_id'] != $goods['store_id']) {
        		return new ecjia_error('not_exists_info', __('不存在的信息', 'goods'));
        	}
        	$goods = str_replace('\\"', '"', $goods);
        	$data = $goods;
	        $base = sprintf('<base href="%s/" />', dirname(SITE_URL));
	        $style = RC_App::apps_url('goods/statics/styles/goodsapi.css');
// 	        $html = '<!DOCTYPE html><html><head><title>' . $data['goods_name'] . '</title><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta name="viewport" content="initial-scale=1.0"><meta name="viewport" content="initial-scale = 1.0 , minimum-scale = 1.0 , maximum-scale = 1.0" /><link href="'.$style.'" rel="stylesheet">' . $base . '</head><body>' . $data['goods_desc'] . '</body></html>';
	        $html = $data['goods_desc'];
	        return array('data' => $html);
        }
    }
    
    /**
     * 获得商品的详细信息
     *
     * @access public
     * @param integer $goods_id
     * @return void
     */
    private function get_goods_info($goods_id, $warehouse_id = 0, $area_id = 0) {
		RC_Loader::load_app_func('global', 'goods');
		$time = RC_Time::gmtime();
	
		$db_goods = RC_DB::table('goods')->where('goods_id', $goods_id);
		
		if (!empty($_SESSION['store_id'])) {
			$db_goods->where('store_id', $_SESSION['store_id']);
		}
		
		//商品信息
		$row = $db_goods->first();
		if (empty($row)) {
			return false;
		}
		//分类信息
		$cat_info = RC_DB::table('category')->where('cat_id', $row['cat_id'])->first();
		$row['measure_unit'] = $cat_info['measure_unit'];
	
		//品牌信息
		$brand_info = RC_DB::table('brand')->where('brand_id', $row['brand_id'])->first();
		$row['brand_logo'] = $brand_info['brand_logo'];
		$row['goods_brand'] = $brand_info['brand_name'];
	
		//评论信息
		$comment_info = RC_DB::table('comment')
		->select(RC_DB::raw('IFNULL(AVG(comment_rank), 0) AS comment_rank'))
		->where('id_value', $goods_id)
		->where('comment_type', 0)
		->where('parent_id', 0)
		->where('status', 1)
		->first();
		$row['comment_rank'] = $comment_info['comment_rank'];
	
		//红包类型信息
		$bonus_info = RC_DB::table('bonus_type')
		->where('type_id', $row['bonus_type_id'])
		->where('send_start_date', '<=', $time)
		->where('send_end_date', '>=', $time)
		->first();
		$row['bonus_money'] = $bonus_info['type_money'];
		 
		//会员价格信息
		$member_price_info = RC_DB::table('member_price')
		->select(RC_DB::raw("IFNULL(user_price, $row[shop_price] * '$_SESSION[discount]') AS rank_price"))
		->where('goods_id', $goods_id)
		->where('user_rank', $_SESSION['user_rank'])
		->first();
		$row['rank_price'] = $member_price_info['rank_price'];
	
		$count = RC_DB::table('store_franchisee')->where('shop_close', '0')->where('store_id', $row['store_id'])->count();
		if (empty($count)) {
			return false;
		}
		RC_Loader::load_app_func('admin_goods', 'goods');
		if (!empty($row)) {
			$row['goods_id'] = $goods_id;
			/* 用户评论级别取整 */
			$row ['comment_rank'] = ceil ( $row ['comment_rank'] ) == 0 ? 5 : ceil ( $row ['comment_rank'] );
			/* 获得商品的销售价格 */
			$row ['market_price'] = $row ['market_price'];
			$row ['shop_price_formated'] = ecjia_price_format ($row ['shop_price'], false);
	
			/* 修正促销价格 */
			if ($row ['promote_price'] > 0) {
				$promote_price = bargain_price ( $row ['promote_price'], $row ['promote_start_date'], $row ['promote_end_date'] );
			} else {
				$promote_price = 0;
			}
			/* 处理商品水印图片 */
			$watermark_img = '';
	
			if ($promote_price != 0) {
				$watermark_img = "watermark_promote";
			} elseif ($row ['is_new'] != 0) {
				$watermark_img = "watermark_new";
			} elseif ($row ['is_best'] != 0) {
				$watermark_img = "watermark_best";
			} elseif ($row ['is_hot'] != 0) {
				$watermark_img = 'watermark_hot';
			}
	
			if ($watermark_img != '') {
				$row ['watermark_img'] = $watermark_img;
			}
	
			$row ['promote_price_org'] = $promote_price;
			$row ['promote_price'] = price_format ( $promote_price );
	
			/* 修正重量显示 */
			$row ['goods_weight'] = (intval ( $row ['goods_weight'] ) > 0) ? $row ['goods_weight'] . __('千克', 'goods') : ($row ['goods_weight'] * 1000) . __('克', 'goods');
	
			/* 修正上架时间显示 */
			$row ['add_time'] = RC_Time::local_date ( ecjia::config ( 'date_format' ), $row ['add_time'] );
	
			/* 促销时间倒计时 */
			$time = RC_Time::gmtime ();
			if ($time >= $row ['promote_start_date'] && $time <= $row ['promote_end_date']) {
				$row ['gmt_end_time'] = $row ['promote_end_date'];
			} else {
				$row ['gmt_end_time'] = 0;
			}
	
			/* 是否显示商品库存数量 */
			$row ['goods_number'] = (ecjia::config ( 'use_storage' ) == 1) ? $row ['goods_number'] : '';
	
			/* 修正积分：转换为可使用多少积分（原来是可以使用多少钱的积分） */
			$row ['integral'] = ecjia::config ( 'integral_scale' ) ? round ( $row ['integral'] * 100 / ecjia::config ( 'integral_scale' ) ) : 0;
	
			/* 修正优惠券 */
			$row ['bonus_money'] = ($row ['bonus_money'] == 0) ? 0 : price_format ( $row ['bonus_money'], false );
	
			RC_Loader::load_app_class('goods_imageutils', 'goods', false);
			/* 修正商品图片 */
			$row ['goods_img'] = empty($row ['goods_img']) ? RC_Uri::admin_url('statics/images/nopic.png') : goods_imageutils::getAbsoluteUrl($row ['goods_img']);
			$row ['goods_thumb'] = empty($row ['goods_img']) ? RC_Uri::admin_url('statics/images/nopic.png') : goods_imageutils::getAbsoluteUrl($row ['goods_thumb']);
			$row ['original_img'] = empty($row ['goods_img']) ? RC_Uri::admin_url('statics/images/nopic.png') : goods_imageutils::getAbsoluteUrl($row ['original_img']);
	
			return $row;
		} else {
			return false;
		}
	}
}

// end
