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
 * 商品信息
 * @author will.chen
 */
class goods_info {

	/**
	 * 取指定规格的货品信息
	 *
	 * @access public
	 * @param string $goods_id
	 * @param array $spec_goods_attr_id
	 * @return array
	 */
	public static function get_products_info($goods_id, $spec_goods_attr_id) {

		$return_array = array ();

		if (empty ( $spec_goods_attr_id ) || ! is_array ( $spec_goods_attr_id ) || empty ( $goods_id )) {
			return $return_array;
		}

		$goods_attr_array = self::sort_goods_attr_id_array ( $spec_goods_attr_id );

		if (isset ( $goods_attr_array ['sort'] )) {
			$db = RC_DB::table('products');
			$goods_attr = implode ( '|', $goods_attr_array ['sort'] );
			$return_array = $db->where('goods_id', $goods_id)->where('goods_attr', $goods_attr)->first();
		}
		return $return_array;
	}

	/**
	 * 获得指定的规格的价格
	 *
	 * @access public
	 * @param mix $spec
	 *        	规格ID的数组或者逗号分隔的字符串
	 * @return void
	 */
	public static function spec_price($spec) {
		if (! empty ( $spec )) {
			if (is_array ( $spec )) {
				foreach ( $spec as $key => $val ) {
					$spec [$key] = addslashes ( $val );
				}
			} else {
				$spec = addslashes ( $spec );
			}
			$db = RC_DB::table('goods_attr');
			$rs = $db->whereIn('goods_attr_id', $spec)->select(RC_DB::raw('sum(attr_price) as attr_price'))->first();
			$price = $rs['attr_price'];
		} else {
			$price = 0;
		}

		return $price;
	}

	/**
	 * 取得商品最终使用价格
	 *
	 * @param string $goods_id
	 *        	商品编号
	 * @param string $goods_num
	 *        	购买数量
	 * @param boolean $is_spec_price
	 *        	是否加入规格价格
	 * @param mix $spec
	 *        	规格ID的数组或者逗号分隔的字符串
	 *
	 * @return 商品最终购买价格
	 */
	public static function get_final_price($goods_id, $goods_num = '1', $is_spec_price = false, $spec = array())
	{
		$db_goodsview = RC_Model::model('goods/goods_viewmodel');
		RC_Loader::load_app_func ('goods', 'goods');
		$final_price	= 0; // 商品最终购买价格
		$volume_price	= 0; // 商品优惠价格
		$promote_price	= 0; // 商品促销价格
		$user_price		= 0; // 商品会员价格

		// 取得商品优惠价格列表
		$price_list = self::get_volume_price_list ($goods_id, '1');

		if (! empty ( $price_list )) {
			foreach ( $price_list as $value ) {
				if ($goods_num >= $value ['number']) {
					$volume_price = $value ['price'];
				}
			}
		}
		$field = "g.promote_price, g.promote_start_date, g.promote_end_date,IFNULL(mp.user_price, g.shop_price * '" . $_SESSION['discount'] . "') AS shop_price";
		// 取得商品促销价格列表
		$goods = $db_goodsview->join(array('member_price'))->field($field)->where(array('g.goods_id' => $goods_id, 'g.is_delete' => 0))->find();

		/* 计算商品的促销价格 */
		if ($goods ['promote_price'] > 0) {
			$promote_price = self::bargain_price ($goods['promote_price'], $goods ['promote_start_date'], $goods ['promote_end_date'] );
		} else {
			$promote_price = 0;
		}

		// 取得商品会员价格列表
		$user_price = $goods['shop_price'];

		// 比较商品的促销价格，会员价格，优惠价格
		if (empty ( $volume_price ) && empty ( $promote_price )) {
			// 如果优惠价格，促销价格都为空则取会员价格
			$final_price = $user_price;
		} elseif (! empty ( $volume_price ) && empty ( $promote_price )) {
			// 如果优惠价格为空时不参加这个比较。
			$final_price = min ( $volume_price, $user_price );
		} elseif (empty ( $volume_price ) && ! empty ( $promote_price )) {
			// 如果促销价格为空时不参加这个比较。
			$final_price = min ( $promote_price, $user_price );
		} elseif (! empty ( $volume_price ) && ! empty ( $promote_price )) {
			// 取促销价格，会员价格，优惠价格最小值
			$final_price = min ( $volume_price, $promote_price, $user_price );
		} else {
			$final_price = $user_price;
		}
		/* 手机专享*/
		$mobilebuy_db = RC_DB::table('goods_activity');
		$mobilebuy_ext_info = array('price' => 0);
		$mobilebuy = $mobilebuy_db
			->where('goods_id', $goods_id)
			->where('start_time', '<=', RC_Time::gmtime())
			->where('end_time', '>=', RC_Time::gmtime())
			->where('act_type', '=', GAT_MOBILE_BUY)
			->first();

		if (!empty($mobilebuy)) {
			$mobilebuy_ext_info = unserialize($mobilebuy['ext_info']);
		}
		$final_price =  ($final_price > $mobilebuy_ext_info['price'] && !empty($mobilebuy_ext_info['price'])) ? $mobilebuy_ext_info['price'] : $final_price;
	    
		// 如果需要加入规格价格
		if ($is_spec_price) {
			if (! empty ( $spec )) {
				$spec_price = self::spec_price ( $spec );
				$final_price += $spec_price;
			}
		}
		// 返回商品最终购买价格
		return $final_price;
	}

	/**
	 * 取得商品优惠价格列表
	 *
	 * @param string $goods_id
	 *        	商品编号
	 * @param string $price_type
	 *        	价格类别(0为全店优惠比率，1为商品优惠价格，2为分类优惠比率)
	 *
	 * @return 优惠价格列表
	 */
	public static function get_volume_price_list($goods_id, $price_type = '1') {
		$db = RC_DB::table('volume_price');
		$volume_price = array ();
		$temp_index = '0';

		$res = $db
			->select(RC_DB::raw('volume_number, volume_price'))
			->where('goods_id', $goods_id)
			->where('price_type', $price_type)
			->orderBy('volume_number', 'asc')
			->get();
		if (! empty ( $res )) {
			foreach ( $res as $k => $v ) {
				$volume_price [$temp_index] = array ();
				$volume_price [$temp_index] ['number'] = $v ['volume_number'];
				$volume_price [$temp_index] ['price'] = $v ['volume_price'];
				$volume_price [$temp_index] ['format_price'] = price_format ( $v ['volume_price'] );
				$temp_index ++;
			}
		}
		return $volume_price;
	}

	/**
	 * 获得指定的商品属性
	 * @access	  public
	 * @param	   array	   $arr		规格、属性ID数组
	 * @param	   type		$type	   设置返回结果类型：pice，显示价格，默认；no，不显示价格
	 * @return	  string
	 */
	public static function get_goods_attr_info($arr, $type = 'pice') {
		$attr   = '';
		if (!empty($arr)) {
		    if ($type == 'no') {
		        $fmt = "%s:%s ";
		    } else {
		        $fmt = "%s:%s[%s] ";
		    }
			
			$dbview = RC_DB::table('goods_attr as ga')
					->leftjoin('attribute as a', RC_DB::raw('a.attr_id'), '=', RC_DB::raw('ga.attr_id'));

			$data = $dbview->whereIn(RC_DB::raw('ga.goods_attr_id'), $arr)->get();
			if(!empty($data)) {
				foreach ($data as $row) {
					$attr_price = round(floatval($row['attr_price']), 2);
					if ($type == 'no') {
					    $attr .= sprintf($fmt, $row['attr_name'], $row['attr_value']);
					} else {
					    $attr .= sprintf($fmt, $row['attr_name'], $row['attr_value'], $attr_price);
					}
					
				}
			}
			$attr = str_replace('[0]', '', $attr);
		}
		return $attr;
	}

	/**
	 *
	 * 是否存在规格
	 *
	 * @access public
	 * @param array $goods_attr_id_array
	 *        	一维数组
	 *
	 * @return string
	 */
	public static function is_spec($goods_attr_id_array, $sort = 'asc') {
		$dbview = RC_DB::table('attribute as a')
					->leftJoin('goods_attr as v', RC_DB::raw('v.attr_id'), '=', RC_DB::raw('a.attr_id'));
		$dbview->where(RC_DB::raw('a.attr_type'), '=', 1);
		if (empty ( $goods_attr_id_array )) {
			return $goods_attr_id_array;
		}

		// 重新排序
		$row = $dbview
				->whereIn(RC_DB::raw('v.goods_attr_id'), $goods_attr_id_array)
				->orderBy(RC_DB::raw('a.attr_id'), $sort)
				->get();
		$return_arr = array ();
		if (!empty($row)) {
			foreach ( $row as $value ) {
				$return_arr ['sort'] [] = $value ['goods_attr_id'];
				$return_arr ['row'] [$value ['goods_attr_id']] = $value;
			}
		}

		if (! empty ( $return_arr )) {
			return true;
		} else {
			return false;
		}
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
	private static function bargain_price($price, $start, $end) {
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

	/**
	 * 将 goods_attr_id 的序列按照 attr_id 重新排序
	 *
	 * 注意：非规格属性的id会被排除
	 *
	 * @access public
	 * @param array $goods_attr_id_array
	 *        	一维数组
	 * @param string $sort
	 *        	序号：asc|desc，默认为：asc
	 *
	 * @return string
	 */
	private static function sort_goods_attr_id_array($goods_attr_id_array, $sort = 'asc') {
		$dbview = RC_DB::table('attribute as a')
		->leftJoin('goods_attr as v', RC_DB::raw('v.attr_id'), '=', RC_DB::raw('a.attr_id'));
		$dbview->where(RC_DB::raw('a.attr_type'), '=', 1);
		if (empty($goods_attr_id_array)) {
			return $goods_attr_id_array;
		}

		// 重新排序
		$row = $dbview
				->whereIn(RC_DB::raw('v.goods_attr_id'), $goods_attr_id_array)
				->orderBy(RC_DB::raw('a.attr_id'), $sort)
				->get();
		$return_arr = array();
		if (! empty($row)) {
			foreach ($row as $value) {
				$return_arr['sort'][] = $value['goods_attr_id'];

				$return_arr['row'][$value['goods_attr_id']] = $value;
			}
		}
		return $return_arr;
	}
}

// end