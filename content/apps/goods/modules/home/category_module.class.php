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
 * 首页分类数据
 * @author royalwang
 */
class category_module extends api_front implements api_interface {
	public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
		$this->authSession();

        RC_Loader::load_app_func('admin_goods', 'goods');
        RC_Loader::load_app_func('admin_category', 'goods');
        RC_Loader::load_app_func('global', 'api');

        $categoryGoods = array();
        $category = get_categories_tree();
        if (! empty($category)) {
            foreach ($category as $key => $val) {
                $goods = array();
                $children = get_children($val['id']);
                $goods = EM_get_category_recommend_goods('best', $children);
                if (empty($goods)) {
                	continue;
                }
                $ngoods = array();
                if (empty($val['img'])) {
                	if (count($goods) > 3) {
                		$goods = array_slice($goods, 0, 3);
                	}
                } else {
                	if (count($goods) > 2) {
                		$goods = array_slice($goods, 0, 2);
                	}
                	$ngoods[] = array(
                		'id' 			=> 0,
                		'name' 			=> '',
                		'market_price' 	=> 0,
                		'shop_price' 	=> 0,
                		'promote_price' => 0,
                		'brief' 		=> '',
                		'img' => array(
                			'thumb' => API_DATA('PHOTO', $val['img']),
                			'url' 	=> API_DATA('PHOTO', $val['img']),
                			'small' => API_DATA('PHOTO', $val['img'])
                		)
                	);
                }
                if (! empty($goods))
                    $mobilebuy_db = RC_Model::model('goods/goods_activity_model');
                    foreach ($goods as $k => $v) {
	                	$groupbuy = $mobilebuy_db->find(array(
                			'goods_id'	 => $v['id'],
                			'start_time' => array('elt' => RC_Time::gmtime()),
                			'end_time'	 => array('egt' => RC_Time::gmtime()),
                			'act_type'	 => GAT_GROUP_BUY,
	                	));
	                	$mobilebuy = $mobilebuy_db->find(array(
                			'goods_id'	 => $v['id'],
                			'start_time' => array('elt' => RC_Time::gmtime()),
                			'end_time'	 => array('egt' => RC_Time::gmtime()),
                			'act_type'	 => GAT_MOBILE_BUY,
	                	));
	                	/* 判断是否有促销价格*/
	                	$price = ($v['unformatted_shop_price'] > $v['unformatted_promote_price'] && $v['unformatted_promote_price'] > 0) ? $v['unformatted_promote_price'] : $v['unformatted_shop_price'];
	                	$activity_type = ($v['unformatted_shop_price'] > $v['unformatted_promote_price'] && $v['unformatted_promote_price'] > 0) ? 'PROMOTE_GOODS' : 'GENERAL_GOODS';

	                	$mobilebuy_price = $groupbuy_price = $object_id = 0;
	                	if (!empty($mobilebuy)) {
	                		$ext_info = unserialize($mobilebuy['ext_info']);
	                		$mobilebuy_price = $ext_info['price'];
	                		$price = $mobilebuy_price > $price ? $price : $mobilebuy_price;
	                		$activity_type = $mobilebuy_price > $price ? $activity_type : 'MOBILEBUY_GOODS';
	                		$object_id = $mobilebuy_price > $price ? $object_id : $mobilebuy['act_id'];
	                	}
// 						if (!empty($groupbuy)) {
// 							$ext_info = unserialize($groupbuy['ext_info']);
// 							$price_ladder = $ext_info['price_ladder'];
// 							$groupbuy_price  = $price_ladder[0]['price'];
// 							$price = $groupbuy_price > $price ? $price : $groupbuy_price;
// 							$activity_type = $groupbuy_price > $price ? $activity_type : 'GROUPBUY_GOODS';
// 						}
	                	/* 计算节约价格*/
	                	$saving_price = ($v['unformatted_shop_price'] - $price) > 0 ? $v['unformatted_shop_price'] - $price : 0;

                        $ngoods[] = array(
                            'id' 			=> $v['id'],
                            'name' 			=> $v['name'],
                            'market_price' 	=> $v['market_price'],
                            'shop_price' 	=> $v['shop_price'],
                            'promote_price' => ($price < $v['unformatted_shop_price'] && $price > 0) ? price_format($price) : '',
                            'brief' 		=> $v['brief'],
                            'img' => array(
                                'thumb' => API_DATA('PHOTO', $v['goods_img']),
                                'url' 	=> API_DATA('PHOTO', $v['original_img']),
                                'small' => API_DATA('PHOTO', $v['thumb'])
                            ),
                        	'activity_type' => $activity_type,
                        	'object_id'		=> $object_id,
                        	'saving_price'	=> $saving_price,
                        	'formatted_saving_price' => '已省'.$saving_price.'元'
                        );
                    }

                $categoryGoods[] = array(
                    'id' => $val['id'],
                    'name' => $val['name'],
                    'goods' => $ngoods
                );
            }
        }

        return $categoryGoods;
    }
}

function EM_get_category_recommend_goods($type = '', $cats = '', $brand = 0, $min = 0, $max = 0, $ext = '') {
	$where = array();
    $brand > 0 ? $where['g.brand_id'] = $brand : ''; // " AND g.brand_id = '$brand'" : '';

    $min > 0 ? $where[] = "g.shop_price >= $min " : '';
    $max > 0 ? $where[] = "g.shop_price <= $max " : '';

    $num = 0;
    $type2lib = array(
        'best' => 'recommend_best',
        'new' => 'recommend_new',
        'hot' => 'recommend_hot',
        'promote' => 'recommend_promotion'
    );
    // 该分类下面取几个产品
    $num = 3; // get_library_number ( $type2lib [$type] );
    switch ($type) {
        case 'best':
            $where['is_best'] = 1;
            break;
        case 'new':
            $where['is_new'] = 1;
            break;
        case 'hot':
            $where['is_hot'] = 1;
            break;
        case 'promote':
            $time = RC_Time::gmtime();
            $where['is_promote'] = 1;
            $where['promote_start_date'] = array('elt' => $time);
            $where['promote_end_date'] = array('egt' => $time);
            break;
    }

    if (!empty($cats)) {
        $where[] = "(" . $cats . " OR " . get_extension_goods($cats) . ")";
    }

    $order_type = ecjia::config('recommend_order');
    $order = ($order_type == 0) ? array(
        'g.sort_order' => 'desc',
        'g.last_update' => 'desc'
    ) : 'RAND()';

    $where['g.is_on_sale'] = 1;
    $where['g.is_alone_sale'] = 1;
    $where['g.is_delete'] = 0;
    $where['g.review_status'] = array('gt' => 2);

    if (ecjia::config('review_goods')) {
    	$where['g.review_status'] = array('gt' => 2);
    }


    $dbview = RC_Model::model('goods/goods_brand_member_viewmodel');
    $res = $dbview
    	->join(array('brand', 'member_price'))
		->where($where)
		->order($order)
		->limit($num)
		->select();

    $idx = 0;
    $goods = array();

    if (! empty($res) && is_array($res)) {
        foreach ($res as $key => $row) {

            if ($row['promote_price'] > 0) {
                $promote_price = bargain_price($row['promote_price'], $row['promote_start_date'], $row['promote_end_date']);
                $goods[$idx]['promote_price'] = $promote_price > 0 ? price_format($promote_price) : '';
            } else {
            	$promote_price = 0;
                $goods[$idx]['promote_price'] = '';
            }

            $goods[$idx]['id'] = $row['goods_id'];
            $goods[$idx]['name'] = $row['goods_name'];
            $goods[$idx]['brief'] = $row['goods_brief'];
            $goods[$idx]['brand_name'] = $row['brand_name'];
            $goods[$idx]['short_name'] = ecjia::config('goods_name_length') > 0 ? RC_String::sub_str($row['goods_name'], ecjia::config('goods_name_length')) : $row['goods_name'];
            $goods[$idx]['market_price'] = price_format($row['market_price']);
            $goods[$idx]['shop_price'] = price_format($row['org_price']);
            $goods[$idx]['thumb'] = get_image_path($row['goods_id'], $row['goods_thumb'], true);
            $goods[$idx]['goods_img'] = get_image_path($row['goods_id'], $row['goods_img']);
            $goods[$idx]['original_img'] = get_image_path($row['goods_id'], $row['original_img']);
            $goods[$idx]['url'] = build_uri('goods', array(
                'gid' => $row['goods_id']
            ), $row['goods_name']);
            $goods[$idx]['short_style_name'] = add_style($goods[$idx]['short_name'], $row['goods_name_style']);


            $goods[$idx]['unformatted_shop_price'] = $row['org_price'];
            $goods[$idx]['unformatted_promote_price'] = $promote_price;

            $idx ++;
        }
    }
    return $goods;
}

// end