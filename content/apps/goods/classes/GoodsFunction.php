<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-05
 * Time: 17:03
 */

namespace Ecjia\App\Goods;

use RC_Model;
use RC_Loader;
use RC_Time;
use RC_DB;
use ecjia;

class GoodsFunction
{

    /**
     * 取得商品最终使用价格
     *
     * @param string $goods_id 商品编号
     * @param string $goods_num 购买数量
     * @param boolean $is_spec_price 是否加入规格价格
     * @param mix $spec 规格ID的数组或者逗号分隔的字符串
     *
     * @return 商品最终购买价格
     */
    public static function get_final_price($goods_id, $goods_num = '1', $is_spec_price = false, $spec = array(), $product_id = 0)
    {
        $dbview = RC_Model::model('goods/sys_goods_member_viewmodel');
        RC_Loader::load_app_func('admin_goods', 'goods');

        $final_price = '0'; // 商品最终购买价格
        $volume_price = '0'; // 商品优惠价格
        $promote_price = '0'; // 商品促销价格
        $user_price = '0'; // 商品会员价格

        // 取得商品优惠价格列表
        $price_list = self::get_volume_price_list ( $goods_id, '1' );

        if (! empty ( $price_list )) {
            foreach ( $price_list as $value ) {
                if ($goods_num >= $value ['number']) {
                    $volume_price = $value ['price'];
                }
            }
        }
        // 取得商品促销价格列表
        //$goods = $dbview->join ('member_price')->find (array('g.goods_id' => $goods_id, 'g.is_delete' => 0));
        $field = "g.promote_price, g.is_promote, g.promote_start_date, g.promote_end_date,IFNULL(mp.user_price, g.shop_price * '" . $_SESSION['discount'] . "') AS shop_price";
        // 取得商品促销价格列表
        $goods = $dbview->join(array('member_price'))->field($field)->where(array('g.goods_id' => $goods_id, 'g.is_delete' => 0))->find();

        /* 计算商品的促销价格 */
        if ($goods ['promote_price'] > 0 && $goods['is_promote'] == '1') {
            $promote_price = self::bargain_price( $goods ['promote_price'], $goods ['promote_start_date'], $goods ['promote_end_date'] );
        } else {
            $promote_price = 0;
        }

        // 取得商品会员价格列表
        $user_price = $goods ['shop_price'];
        
        //是货品情况
        if (!empty($product_id)) {
        	$product_info = RC_DB::table('products')->where('product_id', $product_id)->first();
        	//货品促销价存在，替换商品促销价
        	if ($product_info ['promote_price'] > 0 && $product_info['is_promote'] == '1' && $product_info['promote_limited'] > 0) {
        		$promote_price = self::bargain_price ($product_info['promote_price'], $goods['promote_start_date'], $goods['promote_end_date'], $product_info['promote_limited']);
        	}else {
        		$promote_price = 0;
        	}
        		
        	$product_shop_price = $product_info['product_shop_price'] > 0 ? $product_info['product_shop_price']*$_SESSION['discount'] : 0;
        	//货品会员价格存在替换商品会员等级价
        	$product_user_price = $product_shop_price > 0 ? $product_shop_price : $user_price;
        	$user_price = $product_user_price;
        }

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
        $mobilebuy_db = RC_Model::model('goods/goods_activity_model');
        $mobilebuy_ext_info = array('price' => 0);
        $mobilebuy = $mobilebuy_db->find(array(
            'goods_id'	 => $goods_id,
            'start_time' => array('elt' => RC_Time::gmtime()),
            'end_time'	 => array('egt' => RC_Time::gmtime()),
            'act_type'	 => GAT_MOBILE_BUY,
        ));
        if (!empty($mobilebuy)) {
            $mobilebuy_ext_info = unserialize($mobilebuy['ext_info']);
        }
        $final_price =  ($final_price > $mobilebuy_ext_info['price'] && !empty($mobilebuy_ext_info['price'])) ? $mobilebuy_ext_info['price'] : $final_price;
        // 如果需要加入规格价格
        if ($is_spec_price) {
            if (! empty ( $spec )) {
                if ($product_id > 0) {
                	//货品未设置自定义价格的话，按商品价格加上属性价格;商品价格 + 属性货品价格
                	if ($product_shop_price <= 0) {
                		$spec_price = self::spec_price ( $spec );
                		$final_price += $spec_price;
                	}
                }
            }
        }
        // 返回商品最终购买价格
        return $final_price;
    }


    /**
     * 取得商品优惠价格列表
     *
     * @param string $goods_id 商品编号
     * @param string $price_type 价格类别(0为全店优惠比率，1为商品优惠价格，2为分类优惠比率)
     *
     * @return array 优惠价格列表
     */
    public static function get_volume_price_list($goods_id, $price_type = '1')
    {
        $res = RC_DB::table('volume_price')
            ->select('volume_number', 'volume_price')
            ->where('goods_id', $goods_id)
            ->where('price_type', $price_type)
            ->orderBy('volume_number', 'asc')
            ->get();

        $volume_price = array();
        $temp_index = '0';
        if (!empty($res)) {
            foreach ($res as $k => $v) {
                $volume_price[$temp_index] 					= array();
                $volume_price[$temp_index]['number'] 		= $v['volume_number'];
                $volume_price[$temp_index]['price'] 		= $v['volume_price'];
                $volume_price[$temp_index]['format_price'] 	= ecjia_price_format($v['volume_price'], false);
                $temp_index ++;
            }
        }
        return $volume_price;
    }

    /**
     * 判断某个商品是否正在特价促销期
     *
     * @access public
     * @param float $price 促销价格
     * @param string $start 促销开始日期
     * @param string $end 促销结束日期
     * @return float 如果还在促销期则返回促销价，否则返回0
     */
    public static function bargain_price($price, $start, $end, $promote_limited = 0)
    {
        if ($price == 0) {
            return 0;
        } else {
            $time = RC_Time::gmtime();
            if ($time >= $start && $time <= $end && $promote_limited > 0) {
                return $price;
            } else {
                return 0;
            }
        }
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
     * 获得商品的属性和规格
     *
     * @access public
     * @param integer $goods_id
     * @return array
     */
    public static function get_goods_properties($goods_id) {
    	/* 对属性进行重新排序和分组 */
    	$db_good_type = RC_DB::table('goods_type as gt')->leftJoin('goods as g', RC_DB::raw('gt.cat_id'), '=', RC_DB::raw('g.goods_type'));
    	$grp = $db_good_type->select(RC_DB::raw('gt.attr_group'))->where(RC_DB::raw('g.goods_id'), $goods_id)->first();
    	
    	$grp = $grp['attr_group'];
    	if (! empty ( $grp )) {
    		$groups = explode ( "\n", strtr ( $grp, "\r", '' ) );
    	}
    
    	$field = 'a.attr_id, a.attr_name, a.attr_group, a.is_linked, a.attr_type, ga.goods_attr_id, ga.attr_value, ga.attr_price';
    	/* 获得商品的规格 */
    	$db_good_attr = RC_DB::table('goods_attr as ga')->leftJoin('attribute as a', RC_DB::raw('ga.attr_id'), '=', RC_DB::raw('a.attr_id'));
    	
    	$res = $db_good_attr->select(RC_DB::raw($field))->where(RC_DB::raw('ga.goods_id'), $goods_id)->orderBy(RC_DB::raw('a.sort_order'), 'ASC')->orderBy(RC_DB::raw('ga.attr_price'), 'ASC')->orderBy(RC_DB::raw('ga.goods_attr_id'), 'ASC')->get();
    	
    	$arr ['pro'] = array (); // 属性
    	$arr ['spe'] = array (); // 规格
    	$arr ['lnk'] = array (); // 关联的属性
    
    	if (! empty ( $res )) {
    		foreach ( $res as $row ) {
    			$row ['attr_value'] = str_replace ( "\n", '<br />', $row ['attr_value'] );
    
    			if ($row ['attr_type'] == 0) {
    				$group = (isset ( $groups [$row ['attr_group']] )) ? $groups [$row ['attr_group']] : __('商品属性', 'goods');
    
    				$arr ['pro'] [$group] [$row ['attr_id']] ['name'] = $row ['attr_name'];
    				$arr ['pro'] [$group] [$row ['attr_id']] ['value'] = $row ['attr_value'];
    			} else {
    				$attr_price = $row['attr_price'];
    
    				$arr ['spe'] [$row ['attr_id']] ['attr_type'] = $row ['attr_type'];
    				$arr ['spe'] [$row ['attr_id']] ['name'] = $row ['attr_name'];
    				$arr ['spe'] [$row ['attr_id']] ['value'] [] = array (
    						'label' => $row ['attr_value'],
    						'price' => $row ['attr_price'],
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
     * 商品的规格和属性数据处理
     * @param array $properties
     * @return array
     */
    public static function handle_spec($properties)
    {
    	if (!empty($properties['pro'])) {
    		foreach ($properties['pro'] as $key => $value) {
    			// 处理分组
    			foreach ($value as $k => $v) {
    				$v['value']                 = strip_tags($v['value']);
    				$outData['pro'][]    = $v;
    			}
    		}
    	}
    
    	foreach ($properties['spe'] as $key => $value) {
    		if (!empty($value['values'])) {
    			$value['value'] = $value['values'];
    			unset($value['values']);
    		}
    		$outData['spe'][] = $value;
    	}
    	return $outData;
    }
    
    /**
     * 获取某个分类的上级分类信息
     * @param int $cat_id 分类id
     * @param int $is_merchant_category 是否是商家分类
     * @param int $store_id 店铺id
     * @return array
     */
    public static function get_parent_cats($cat_id, $is_merchant_category = 0, $store_id = 0)
    {
    	if ($cat_id == 0) {
    		return array(
    				'cat_id'   => 0,
    				'cat_name' => '',
    				'parent_id' => 0,
    				'level' => 0
    		);
    	}
    
    	$where = array();
    	if ($is_merchant_category) {
    		$db_category = RC_DB::table('merchants_category')->where('store_id', $store_id);
    	} else {
    		$db_category = RC_DB::table('category');
    	}
    
    	$arr = $db_category->select('cat_id', 'cat_name', 'parent_id')->get();
    	
    	if (empty($arr)) {
    		return array(
    				'cat_id'   => 0,
    				'cat_name' => '',
    				'parent_id' => 0,
    				'level' => 0
    		);
    	}
    
    	$index = 0;
    	$cats  = array();
    	while (1) {
    		foreach ($arr as $row) {
    			if ($cat_id == $row['cat_id']) {
    				$cat_id = $row['parent_id'];
    
    				$cats[$index]['cat_id']   = $row['cat_id'];
    				$cats[$index]['cat_name'] = $row['cat_name'];
    				$cats[$index]['parent_id'] = $row['parent_id'];
    				$cats[$index]['level'] = 0;
    
    				$index++;
    				break;
    			}
    		}
    		if ($index == 0 || $cat_id == 0) {
    			break;
    		}
    	}
    
    	return self::change_cats_level($cats);
    }
    
    
    public static function change_cats_level($cats = array()) {
    	if (empty($cats)) return $cats;
    	$levels = count($cats);
    	$new_cats = array();
    
    	krsort($cats);
    	foreach ($cats as $key => $val) {
    		$val['level'] = $levels - $key - 1;
    		$new_cats[] = $val;
    	}
    
    	return $new_cats;
    }
    
    
    /**
     * 获取审核状态 1未审核 2审核未通过 3审核已通过 5无需审核
     */
    public static function get_review_status($store_id) {
    	$review_status = 1; //默认未审核
    
    	//商店设置->基本设置中 商家审核关闭 则所有商家商品无需审核
    	if (ecjia::config('review_goods') == 0) {
    		$review_status = 5;
    	} else {
    		if (isset($store_id) && $store_id > 0) {
    			$manage_mode = RC_DB::table('store_franchisee')->where('store_id', $store_id)->value('manage_mode');
    			if ($manage_mode == 'self') {
    				$review_status = 5;
    			}
    			$shop_review_goods = RC_DB::table('merchants_config')->where('store_id', $store_id)->where('code', 'shop_review_goods')->value('value');
    			//单个商店开启了审核商品 则默认为未审核
    			if ($shop_review_goods == 1) {
    				$review_status = 1;
    			}
    		}
    	}
    	return $review_status;
    }
    
    /**
     * 为某商品生成唯一的货号
     *
     * @param int $goods_id
     *            商品编号
     * @return string 唯一的货号
     */
    public static function generate_goods_sn($goods_id) {
    	$goods_sn = ecjia::config('sn_prefix') . str_repeat('0', 6 - strlen($goods_id)) . $goods_id;
    	$sn_list = RC_DB::table('goods')
    	->where('goods_sn', 'like', '%' . mysql_like_quote($goods_sn) . '%')
    	->where('goods_id', '!=', $goods_id)->orderBy(RC_DB::raw('LENGTH(goods_sn)'), 'desc')
    	->get();
    
    	/* 判断数组为空就创建数组类型否则类型为null 报错 */
    	$sn_list = empty($sn_list) ? array() : $sn_list;
    	if (in_array($goods_sn, $sn_list)) {
    		$max = pow(10, strlen($sn_list[0]) - strlen($goods_sn) + 1) - 1;
    		$new_sn = $goods_sn . mt_rand(0, $max);
    		while (in_array($new_sn, $sn_list)) {
    			$new_sn = $goods_sn . mt_rand(0, $max);
    		}
    		$goods_sn = $new_sn;
    	}
    	return $goods_sn;
    }
    
    
    /**
     * 商家商品根据分类获取[规格/参数]模板
     */
    public static function get_merchant_cat_template($type, $cat_id, $store_id) {
    	$template_id = 0;
    	if ($type === 'parameter') {
    		$template_id = RC_DB::table('merchants_category')->where('store_id', $store_id)->where('cat_id', $cat_id)->value('parameter_id');
    	} else {
    		$template_id = RC_DB::table('merchants_category')->where('store_id', $store_id)->where('cat_id', $cat_id)->value('specification_id');
    	}
    	if (empty($template_id)) {
    		$category_info = RC_DB::table('merchants_category')->where('cat_id', $cat_id)->first();
    		if ($category_info['parent_id'] > 0) {
    			$template_id = self::get_merchant_cat_template($type, $category_info['parent_id'], $store_id);
    		}
    	}
    	return $template_id;
    }
    
    /**
     * 商品库商品根据分类获取[规格/参数]模板
     */
    public static function get_admin_cat_template($type, $cat_id) {
    	$template_id = 0;
    	if ($type === 'parameter') {
    		$template_id = RC_DB::table('category')->where('cat_id', $cat_id)->value('parameter_id');
    	} else {
    		$template_id = RC_DB::table('category')->where('cat_id', $cat_id)->value('specification_id');
    	}
    	if (empty($template_id)) {
    		$category_info = RC_DB::table('category')->where('cat_id', $cat_id)->first();
    		if ($category_info['parent_id'] > 0) {
    			$template_id = self::get_admin_cat_template($type, $category_info['parent_id']);
    		}
    	}
    	return $template_id;
    }
    
    
}