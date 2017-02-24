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
 * 获取商品详情信息
 * @author will.chen
 */
class goods_goods_info_api extends Component_Event_Api {
    /**
     * @param  $options['keyword'] 关键字
     *         $options['cat_id'] 分类id
     *         $options['brand_id'] 品牌id
     * @return array
     */
	public function call(&$options) {	
	    if (!is_array($options)
	        && !isset($options['id'])) {
	        return new ecjia_error('invalid_parameter', '参数无效');
	    }
	   	$row = $this->get_goods_info($options['id']);
	    return $row;
	}
	
	/**
	 * 获得商品的详细信息
	 *
	 * @access public
	 * @param integer $goods_id        	
	 * @return void
	 */
	private function get_goods_info($goods_id) {
		$db_goods = RC_Model::model('goods/goods_viewmodel');
		RC_Loader::load_app_func('global', 'goods');
		$time = RC_Time::gmtime();
		$db_goods->view = array (
			'category' => array(
				'type'	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias'	=> 'c',
				'field'	=> "g.*, c.measure_unit, b.brand_id, b.brand_name AS goods_brand, m.type_money AS bonus_money,IFNULL(AVG(r.comment_rank), 0) AS comment_rank,IFNULL(mp.user_price, g.shop_price * '".$_SESSION['discount']."') AS rank_price",
				'on'	=> 'g.cat_id = c.cat_id' 
			),
			'brand' => array(
				'type'	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias'	=> 'b',
				'on'	=> 'g.brand_id = b.brand_id ' 
			),
			'comment' => array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'r',
				'on' 	=> 'r.id_value = g.goods_id AND comment_type = 0 AND r.parent_id = 0 AND r.status = 1' 
			),
			'bonus_type' => array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'm',
				'on' 	=> 'g.bonus_type_id = m.type_id AND m.send_start_date <= "' . $time . '" AND m.send_end_date >= "' . $time . '"' 
			),
			'member_price' => array(
				'type'	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias'	=> 'mp',
				'on'  	=> 'mp.goods_id = g.goods_id AND mp.user_rank = "' . $_SESSION['user_rank'] . '"' 
			) 
		);
		$row = $db_goods->group('g.goods_id')->find(array('g.goods_id' => $goods_id, 'g.is_delete' => 0));
		
		if ($row !== false) {
			/* 用户评论级别取整 */
			$row['comment_rank'] = ceil( $row['comment_rank'] ) == 0 ? 5 : ceil ( $row['comment_rank'] );
			/* 获得商品的销售价格 */
			$row['unformatted_market_price'] = $row['market_price'];
			$row['market_price'] = $row['market_price'] > 0 ? price_format ($row['market_price']) : 0;
			$row['shop_price_formated'] = price_format ($row['shop_price'] );
			
			/* 修正促销价格 */
			if ($row ['promote_price'] > 0) {
				$promote_price = bargain_price ( $row['promote_price'], $row['promote_start_date'], $row['promote_end_date'] );
			} else {
				$promote_price = 0;
			}
			
			/* 处理商品水印图片 */
			$watermark_img = '';
			if ($promote_price != 0) {
				$watermark_img = "watermark_promote";
			} elseif ($row['is_new'] != 0) {
				$watermark_img = "watermark_new";
			} elseif ($row['is_best'] != 0) {
				$watermark_img = "watermark_best";
			} elseif ($row['is_hot'] != 0) {
				$watermark_img = 'watermark_hot';
			}
			
			if ($watermark_img != '') {
				$row['watermark_img'] = $watermark_img;
			}
			
			$row['promote_price_org'] = $promote_price;
			$row['promote_price'] = price_format ( $promote_price );
			
			/* 修正重量显示 */
			$row['goods_weight'] = (intval ( $row['goods_weight'] ) > 0) ? $row['goods_weight'] . RC_Lang::get('system::system.kilogram') : ($row['goods_weight'] * 1000) . RC_Lang::get('system::system.gram');
			
			/* 修正上架时间显示 */
			$row['add_time'] = RC_Time::local_date(ecjia::config('date_format'), $row['add_time'] );
			
			/* 促销时间倒计时 */
			$time = RC_Time::gmtime ();
			if ($time >= $row ['promote_start_date'] && $time <= $row ['promote_end_date']) {
				$row['gmt_end_time'] = $row['promote_end_date'];
			} else {
				$row['gmt_end_time'] = 0;
				$row['promote_start_date'] = $row['promote_end_date'] = 0;
			}
			
			/* 是否显示商品库存数量 */
			$row['goods_number'] = (ecjia::config('use_storage') == 1) ? $row['goods_number'] : '';
			
			/* 修正积分：转换为可使用多少积分（原来是可以使用多少钱的积分） */
			$row['integral'] = ecjia::config('integral_scale') ? round ( $row['integral'] * 100 / ecjia::config('integral_scale')) : 0;
			
			/* 修正优惠券 */
			$row['bonus_money'] = ($row ['bonus_money'] == 0) ? 0 : price_format ( $row['bonus_money'], false );
			
			/* 修正商品图片 */
			$row['goods_img']	= empty($row ['goods_img']) ? RC_Uri::admin_url('statics/images/nopic.png') : RC_Upload::upload_url($row['goods_img']);
			$row['goods_thumb'] = empty($row ['goods_thumb']) ? RC_Uri::admin_url('statics/images/nopic.png') : RC_Upload::upload_url($row['goods_thumb']);
			$row['original_img'] = empty($row ['original_img']) ? RC_Uri::admin_url('statics/images/nopic.png') : RC_Upload::upload_url($row['original_img']);
			
			/* 获取商品属性和规格*/
			$row['properties']	= $this->get_goods_properties($row['goods_id']);
			$row['rank_prices'] = $this->get_user_rank_prices($row['goods_id'], $row['shop_price']);
			$row['pictures']	= $this->get_goods_gallery($row['goods_id']);
			
			return $row;
		} else {
			return false;
		}
	}
	
	/**
	 * 获得商品的属性和规格
	 *
	 * @access public
	 * @param integer $goods_id        	
	 * @return array
	 */
	private function get_goods_properties($goods_id) {
		$db_good_type = RC_Model::model ('goods/goods_type_viewmodel');
		$db_good_attr = RC_Model::model ('goods/goods_attr_viewmodel');
		/* 对属性进行重新排序和分组 */
	
		$db_good_type->view = array (
			'goods' => array (
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'g',
				'field' => 'attr_group',
				'on' 	=> 'gt.cat_id = g.goods_type' 
			) 
		);
		
		$grp = $db_good_type->find(array('g.goods_id' => $goods_id));
		$grp = $grp ['attr_group'];
		if (! empty ( $grp )) {
			$groups = explode ( "\n", strtr ( $grp, "\r", '' ) );
		}
		
		/* 获得商品的规格 */
		$db_good_attr->view = array (
			'attribute' => array (
				'type'     => Component_Model_View::TYPE_LEFT_JOIN,
				'alias'    => 'a',
				'field'    => 'a.attr_id, a.attr_name, a.attr_group, a.is_linked, a.attr_type, ga.goods_attr_id, ga.attr_value, ga.attr_price',
				'on'       => 'a.attr_id = ga.attr_id' 
			) 
		);
		
		$res = $db_good_attr->where(array('ga.goods_id' => $goods_id))->order(array('a.sort_order' => 'asc','ga.attr_price' => 'asc','ga.goods_attr_id' => 'asc'))->select();
		$arr ['pro'] = array (); // 属性
		$arr ['spe'] = array (); // 规格
		$arr ['lnk'] = array (); // 关联的属性
		
		if (! empty ( $res )) {
			foreach ( $res as $row ) {
				$row ['attr_value'] = str_replace ( "\n", '<br />', $row ['attr_value'] );
				
				if ($row ['attr_type'] == 0) {
					$group = (isset ( $groups [$row ['attr_group']] )) ? $groups [$row ['attr_group']] : RC_Lang::get('goods::goods.goods_attr');
					
					$arr ['pro'] [$group] [$row ['attr_id']] ['name'] = $row ['attr_name'];
					$arr ['pro'] [$group] [$row ['attr_id']] ['value'] = $row ['attr_value'];
				} else {
					$arr ['spe'] [$row ['attr_id']] ['attr_type'] = $row ['attr_type'];
					$arr ['spe'] [$row ['attr_id']] ['name'] = $row ['attr_name'];
					$arr ['spe'] [$row ['attr_id']] ['values'] [] = array (
						'label' => $row ['attr_value'],
						'price' => !empty($row ['attr_price']) ? $row ['attr_price'] : 0,
						'format_price' => price_format ( abs ( $row ['attr_price'] ), false ),
						'id' => $row ['goods_attr_id'] 
						);
				}
				
				if ($row ['is_linked'] == 1) {
					/* 如果该属性需要关联，先保存下来 */
					$arr ['lnk'] [$row ['attr_id']] ['name'] = $row ['attr_name'];
					$arr ['lnk'] [$row ['attr_id']] ['value'] = $row ['attr_value'];
				}
			}
		}
		return $arr;
	}
	
	/**
	 * 获得指定商品的各会员等级对应的价格
	 *
	 * @access public
	 * @param integer $goods_id            
	 * @return array
	 */
	private function get_user_rank_prices($goods_id, $shop_price) {
	    $dbview = RC_Model::model('user/user_rank_member_price_viewmodel');
	    $dbview->view =array(
    		'member_price' 	=> array(
 				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
    			'alias' => 'mp',
    			'on' 	=> "mp.goods_id = '$goods_id' and mp.user_rank = r.rank_id "
    		),
	    );
	    
	    $res = $dbview->join(array('member_price'))->field("rank_id, IFNULL(mp.user_price, r.discount * $shop_price / 100) AS price, r.rank_name, r.discount")->where("r.show_price = 1 OR r.rank_id = '$_SESSION[user_rank]'")->select();
	    $arr = array();
	    foreach ($res as $row) {
	        $arr[$row['rank_id']] = array(
	        	'id'		=> $row['rank_id'],
	            'rank_name' => htmlspecialchars($row['rank_name']),
	            'price'		=> price_format($row['price']),
	        	'unformatted_price' => number_format( $row['price'], 2, '.', '')
	        );
	    }
	    return $arr;
	}
	
	/**
	 * 获得指定商品的相册
	 *
	 * @access  public
	 * @param   integer     $goods_id
	 * @return  array
	 */
	private function get_goods_gallery($goods_id) {
	    $db_goods_gallery = RC_Model::model('goods/goods_gallery_model');
	    $row = $db_goods_gallery->field('img_id, img_url, thumb_url, img_desc, img_original')->where(array('goods_id' => $goods_id))->limit(ecjia::config('goods_gallery_number'))->select();
	    $img = array();
	    /* 格式化相册图片路径 */
	    if (!empty($row)) {
		    foreach ($row as $key => $gallery_img) {
		    	$img[$key]['img_original']	= empty($gallery_img['img_original']) ? RC_Uri::admin_url('statics/images/nopic.png') : RC_Upload::upload_url($gallery_img['img_original']);
		    	$img[$key]['img_url']		= empty($gallery_img['img_url']) ? RC_Uri::admin_url('statics/images/nopic.png') : RC_Upload::upload_url($gallery_img['img_url']);
		    	$img[$key]['thumb_url']		= empty($gallery_img['thumb_url']) ? RC_Uri::admin_url('statics/images/nopic.png') : RC_Upload::upload_url($gallery_img['thumb_url']);
		    }
	    }
	    return $img;
	}
}

// end