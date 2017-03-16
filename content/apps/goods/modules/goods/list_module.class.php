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
 * 商品分类列表及关键词搜索
 * @author royalwang
 */
class list_module extends api_front implements api_interface {

     public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
        $this->authSession();
        $location	= $this->requestData('location', array()) ;
		$city_id	= $this->requestData('city_id', 0) ;
        /* 筛选条件*/
        $filter = $this->requestData('filter', array());
        $keyword = isset($filter['keywords']) ? RC_String::unicode2string($filter['keywords']): '';
        $keyword = ! empty($keyword) ? htmlspecialchars(trim($keyword)) : '';

        $category = ! empty($filter['category_id']) ? intval($filter['category_id']) : 0;
        $brand = ! empty($filter['brand_id']) ? intval($filter['brand_id']) : 0;
        /* 价格*/
        $filter['min_price'] = ! empty($filter['price_range']['price_min']) ? intval($filter['price_range']['price_min']) : 0;
        $filter['max_price'] = ! empty($filter['price_range']['price_max']) ? intval($filter['price_range']['price_max']) : 0;
        $min_price = $filter['min_price'] != 0 ? $filter['min_price'] : '';
        $max_price = $filter['max_price'] != 0 || $filter['min_price'] < 0 ? $filter['max_price'] : '';
        /* 属性筛选*/
        $filter_attr = empty($filter['filter_attr']) ? '' : explode('.', $filter['filter_attr']);

        /* 排序*/
        $sort_by = !empty($filter['sort_by']) ? $filter['sort_by'] : '';
        if ($sort_by == 'is_hot') {
            $order_sort = array('is_hot' => 'DESC', 'g.sort_order' => 'ASC', 'goods_id' => 'DESC');
        } elseif ($sort_by == 'price_desc') {
            $order_sort = array('org_price' => 'DESC', 'g.sort_order' => 'ASC', 'goods_id' => 'DESC');
        } elseif ($sort_by == 'price_asc') {
            $order_sort = array('org_price' => 'ASC', 'g.sort_order' => 'ASC', 'goods_id' => 'DESC');
        } elseif ($sort_by == 'is_new') {
            $order_sort = array('is_new' => 'DESC', 'g.sort_order' => 'ASC', 'goods_id' => 'DESC');
        } else {
            $order_sort = array('goods_id' => 'DESC');
        }

        $size = $this->requestData('pagination.count', 20);
        $page = $this->requestData('pagination.page', 1);


        /*经纬度为空判断*/
        if ((is_array($location) || !empty($location['longitude']) || !empty($location['latitude']))) {
        	$geohash = RC_Loader::load_app_class('geohash', 'store');
        	$geohash_code = $geohash->encode($location['latitude'] , $location['longitude']);
			$geohash_code = substr($geohash_code, 0, 8);
        } else {
        	$data = array();
        	$data['list'] = array();
        	$data['pager'] = array(
        			"total" => '0',
        			"count" => '0',
        			"more"    => '0'
        	);
        	return array('data' => $data['list'], 'pager' => $data['pager']);
        }

        $options = array(
            'cat_id'		=> $category,
            'brand'			=> $brand,
            'keywords'		=> $keyword,
            'min'			=> $min_price,
            'max'			=> $max_price,
            'sort'			=> $order_sort,
            'page'			=> $page,
            'size'			=> $size,
            'filter_attr'	=> $filter_attr,
        );

        $filter = empty($filter['filter_attr']) ? '' : $filter['filter_attr'];
        $cache_id = sprintf('%X', crc32($category . '-' . $sort_by  .'-' . $page . '-' . $size . '-' . $_SESSION['user_rank']. '-' .
                   ecjia::config('lang') .'-'. $brand. '-'. $keyword. '-' . $max_price . '-' .$min_price . '-' . $filter . '-' . $geohash_code . '-' . $city_id ));

        $cache_key = 'goods_list_'.$cache_id;
        $data = RC_Cache::app_cache_get($cache_key, 'goods');

        if (empty($data)) {
        	$options['store_id'] = RC_Api::api('store', 'neighbors_store_id', array('geohash' => $geohash_code, 'city_id' => $city_id));
        	if (empty($options['store_id'])) {
        		$options['store_id'] = array(0);
        	}
            
            $result = RC_Api::api('goods', 'goods_list', $options);
            $data = array();
            $data['pager'] = array(
                "total"    => $result['page']->total_records,
                "count"    => $result['page']->total_records,
                "more"    => $result['page']->total_pages <= $page ? 0 : 1,
            );
            $data['list'] = array();

            if (!empty($result['list'])) {
                $mobilebuy_db = RC_Model::model('goods/goods_activity_model');
                /* 手机专享*/
//                 $result_mobilebuy = ecjia_app::validate_application('mobilebuy');
//                 $is_active = ecjia_app::is_active('ecjia.mobilebuy');
                foreach ($result['list'] as $val) {
                    /* 判断是否有促销价格*/
                    $price = ($val['unformatted_shop_price'] > $val['unformatted_promote_price'] && $val['unformatted_promote_price'] > 0) ? $val['unformatted_promote_price'] : $val['unformatted_shop_price'];
                    $activity_type = ($val['unformatted_shop_price'] > $val['unformatted_promote_price'] && $val['unformatted_promote_price'] > 0) ? 'PROMOTE_GOODS' : 'GENERAL_GOODS';
                    /* 计算节约价格*/
                    $saving_price = ($val['unformatted_shop_price'] > $val['unformatted_promote_price'] && $val['unformatted_promote_price'] > 0) ? $val['unformatted_shop_price'] - $val['unformatted_promote_price'] : (($val['unformatted_market_price'] > 0 && $val['unformatted_market_price'] > $val['unformatted_shop_price']) ? $val['unformatted_market_price'] - $val['unformatted_shop_price'] : 0);

                    /* $mobilebuy_price = $object_id = 0;
                    if (!is_ecjia_error($result_mobilebuy) && $is_active) {
                        $mobilebuy = $mobilebuy_db->find(array(
                            'goods_id'     => $val['goods_id'],
                            'start_time' => array('elt' => RC_Time::gmtime()),
                            'end_time'     => array('egt' => RC_Time::gmtime()),
                            'act_type'     => GAT_MOBILE_BUY,
                        ));
                        if (!empty($mobilebuy)) {
                            $ext_info = unserialize($mobilebuy['ext_info']);
                            $mobilebuy_price = $ext_info['price'];
                            if ($mobilebuy_price < $price) {
                                $val['promote_price'] = price_format($mobilebuy_price);
                                $object_id        = $mobilebuy['act_id'];
                                $activity_type    = 'MOBILEBUY_GOODS';
                                $saving_price = ($val['unformatted_shop_price'] - $mobilebuy_price) > 0 ? $val['unformatted_shop_price'] - $mobilebuy_price : 0;
                            }
                        }
                    } */

                    $data['list'][] = array(
                        'goods_id'                  => $val['goods_id'],
                        'name'                      => $val['name'],
                        'market_price'              => $val['market_price'],
                        'shop_price'                => $val['shop_price'],
                        'promote_price'             => $val['promote_price'],
                        'img' => array(
                            'thumb'   => $val['goods_img'],
                            'url'     => $val['original_img'],
                            'small'   => $val['goods_thumb']
                        ),
                        'activity_type'             => $activity_type,
                        'object_id'                 => 0,//$object_id,
                        'saving_price'              => $saving_price,
                        'formatted_saving_price'    => $saving_price > 0 ? '已省'.$saving_price.'元' : '',
                        'seller_id'                  => $val['store_id'],
                        'seller_name'                => $val['store_name'],
                    );
                }
            }
            RC_Cache::app_cache_set($cache_key, $data, 'goods');
           } else {
               if (!empty($options['keywords'])) {
                   RC_Loader::load_app_class('goods_list', 'goods', false);
                   goods_list::get_keywords_where($options['keywords']);
               }
           }

        return array('data' => $data['list'], 'pager' => $data['pager']);
    }
}

// end
