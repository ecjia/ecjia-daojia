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
 * 商品控制器
 */
class goods_controller {
    /**
     * 商品列表
     */
    public static function init() {
        $cache_id = sprintf('%X', crc32($_SERVER['QUERY_STRING'] . '-' . $_COOKIE['city_id'] . '-' . $_COOKIE['city_name']));
        
        $general_info = pc_function::get_general_info();
        ecjia_front::$controller->assign('info', $general_info);
        
        if (!ecjia_front::$controller->is_cached('goods_list.dwt', $cache_id)) {
            $store = RC_DB::table('store_franchisee')->where('city', $_COOKIE['city_id'])->where('shop_close', 0)->where('status', 1)->get();
            $has_store = !empty($store) ? true : false;
            ecjia_front::$controller->assign('has_store', $has_store);

            if ($has_store) {
	            $keywords = !empty($_GET['keywords']) ? trim($_GET['keywords']) : '';
	            if (empty($keywords)) {
	                $cat_id = !empty($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;
	                ecjia_front::$controller->assign('cat_id', $cat_id);
	                
	                $select_id = !empty($_GET['select_id']) ? intval($_GET['select_id']) : 0;
	                if (!empty($select_id)) {
	                    $cat_id = $select_id;
	                }
	                $cat_info = pc_function::get_cat_info($cat_id, $select_id);
	
	                ecjia_front::$controller->assign('select_id', $select_id);
	                ecjia_front::$controller->assign('cat_info', $cat_info);
	                ecjia_front::$controller->assign('pc_keywords', $cat_info['keywords']);
	                ecjia_front::$controller->assign('pc_description', $cat_info['cat_desc']);
	                
	                $goods_options['cat_id'] = $cat_id;
	            } else {
	                $goods_options['keywords'] = $keywords;
	            }
	            
	            $page = !empty($_GET['page']) ? intval($_GET['page']) : 1;
	            $type = !empty($_GET['type']) ? trim($_GET['type']) : '';
	            
	            $goods_options['page'] = $page;
	            $goods_options['size'] = 9;
	            $sort_by = !empty($_GET['sort_by']) ? trim($_GET['sort_by']) : '';
	            $sort_order = !empty($_GET['sort_order']) ? trim($_GET['sort_order']) : 'desc';
	            
	            if (!empty($sort_by)) {
	                $goods_options['sort'] = array($sort_by => $sort_order);
	                ecjia_front::$controller->assign('sort_by', $sort_by);
	                ecjia_front::$controller->assign('sort_order', $sort_order);
	            } else {
	            	$goods_options['sort'] = array('g.sort_order' => 'asc');
	            }

	            if ($type == 'hot') {
	                $goods_options['intro'] = 'hot';
	            }
	            if (!empty($_COOKIE['city_id'])) {
	                $goods_options['city_id'] = $_COOKIE['city_id'];
	            } else {
	                $goods_options['city_id'] = 0;
	            }
	            $goods_result = RC_Api::api('goods', 'goods_list', $goods_options);
	            $pages = $goods_result['page']->show(2);
	            
	            ecjia_front::$controller->assign('type', $type);
	            ecjia_front::$controller->assign('keywords', $keywords);
	            ecjia_front::$controller->assign('page', $pages);
	            ecjia_front::$controller->assign('goods_list', $goods_result['list']);
	            ecjia_front::$controller->assign('page', $pages);
	            ecjia_front::$controller->assign('goods_info_url', RC_Uri::url('goods/index/show'));
	            
	            RC_Loader::load_app_class('goods_category', 'goods', false);
	            $children = goods_category::get_children($cat_id);
	            $seller_group_where = array("(" . $children . " OR " . goods_category::get_extension_goods($children, 'goods_id') . ")", 'is_on_sale' => 1, 'is_alone_sale' => 1, 'is_delete' => 0, 'review_status' => array('gt' => 2));
	            $seller_group = RC_Model::model('goods/goods_viewmodel')->join(null)->where($seller_group_where)->get_field('store_id', true);
	            
	            $db_goods_data = RC_DB::table('goods_data');
	            if (!empty($seller_group)) {
	                $seller_group = array_merge($seller_group);
	                $seller_group = array_unique($seller_group);
	                $db_goods_data->whereIn('store_id', $seller_group);
	            }
	            $disk = RC_Filesystem::disk();
	            $store_list = $db_goods_data->select('store_id', RC_DB::raw('AVG(goods_rank) as "goods_rank"'))->groupBy('store_id')->orderBy('goods_rank', 'desc')->take(3)->get();
	            if (!empty($store_list)) {
	                foreach ($store_list as $k => $v) {
	                    if (empty($v['goods_rank'])) {
	                        $v['goods_rank'] = 10000;
	                    }
	                    
	                    $store_list[$k]['store_id'] = $v['store_id'];
	                    $store_list[$k]['comment_percent'] = round($v['goods_rank'] / 100);
	                    $store_list[$k]['comment_rank'] = $v['goods_rank'] / 100 / 20;
	                    $config = RC_DB::table('merchants_config')->where('store_id', $v['store_id'])->select('code', 'value')->get();
	                    
	                    $db_store = RC_DB::table('store_franchisee')->where('status', 1);
	                    if (!empty($_COOKIE['city_id'])) {
	                        $db_store->where('city', $_COOKIE['city_id']);
	                    } else {
	                        $db_store->where('city', 0);
	                    }
	                    $info = $db_store->where('store_id', $v['store_id'])->where('shop_close', 0)->select('merchants_name')->first();
	                    
	                    $store_config = array();
	                    foreach ($config as $key => $value) {
	                        $store_config[$value['code']] = $value['value'];
	                    }
	                    
	                    if (!empty($info)) {
	                        $info = array_merge($info, $store_config);
	                        $info['seller_logo'] = empty($info['shop_logo']) || !$disk->exists($info['shop_logo']) ? '' : RC_Upload::upload_url($info['shop_logo']);
	                        $store_list[$k]['order_amount'] = RC_DB::table('order_info')->where('store_id', $v['store_id'])->where('order_status', 5)->where('shipping_status', 2)->where('pay_status', 2)->count();
	                        $store_list[$k]['store_info'] = $info;
	                    } else {
	                        $store_list = array();
	                    }
	                }
	            }
	            ecjia_front::$controller->assign('goods_url', RC_Uri::url('goods/index/init'));
	            ecjia_front::$controller->assign('store_list', $store_list);
	            ecjia_front::$controller->assign_title('商品列表');
            }
        }
        ecjia_front::$controller->display('goods_list.dwt', $cache_id);
    }
    
    public static function show() {
        $cache_id = sprintf('%X', crc32($_SERVER['QUERY_STRING'] . '-' . $_COOKIE['city_id'] . '-' . $_COOKIE['city_name']));
        
        $general_info = pc_function::get_general_info();
        ecjia_front::$controller->assign('info', $general_info);
        
        if (!ecjia_front::$controller->is_cached('goods_show.dwt', $cache_id)) {
            $goods_id = !empty($_GET['goods_id']) ? intval($_GET['goods_id']) : 0;
            $goods_info = RC_DB::table('goods')->where('goods_id', $goods_id)->select('goods_id', 'store_id', 'goods_name', 'market_price', 'shop_price', 'promote_price', 'goods_thumb', 'goods_desc', 'cat_id', 'keywords', 'goods_brief')->first();
            
            $store = RC_DB::table('store_franchisee')->where('city', $_COOKIE['city_id'])->where('shop_close', 0)->where('store_id', $goods_info['store_id'])->first();
            $has_store = !empty($store) ? true : false;
            ecjia_front::$controller->assign('has_store', $has_store);
            
            if ($has_store) {
	            RC_Loader::load_app_func('admin_goods');
	            $properties = get_goods_properties($goods_id);
	            // 获得商品的规格和属性
	            $goods_info['specification'] = $properties['spe'];
	            $f_price = $goods_info['promote_price'] == 0 | $goods_info['promote_price'] == '' ? $goods_info['shop_price'] : $goods_info['promote_price'];
	            foreach ($properties['spe'] as $key => $val) {
	                if (!empty($val['value']) && is_array($val['value'])) {
	                    $price = isset($val['value'][0]['price']) ? $val['value'][0]['price'] : 0;
	                    $f_price += $price;
	                }
	            }
	            
	            $num = 1;
	            if (!empty($properties['pro'])) {
	                foreach ($properties['pro'] as $key => $val) {
	                    foreach ($val as $v => $k) {
	                        if ($num % 2 != 0) {
	                            $goods_info['properties'][$num - 1]['name1'] = $k['name'];
	                            $goods_info['properties'][$num - 1]['value1'] = $k['value'];
	                        } else {
	                            $goods_info['properties'][$num - 2]['name2'] = $k['name'];
	                            $goods_info['properties'][$num - 2]['value2'] = $k['value'];
	                        }
	                        $num += 1;
	                    }
	                }
	            }
	            
	            $goods_info['f_price'] = $f_price;
	            $store_id = $goods_info['store_id'];
	            
	            $favourable_result = RC_Api::api('favourable', 'store_favourable_list', array('store_id' => $store_id));
	            if (!empty($favourable_result)) {
	                $favourable_list = array();
	                foreach ($favourable_result as $val) {
	                    if ($val['act_range'] == '0') {
	                        $favourable_list[] = array('name' => $val['act_name'], 'type' => $val['act_type'] == '1' ? 'price_reduction' : 'price_discount', 'type_label' => $val['act_type'] == '1' ? __('满减') : __('满折'));
	                    } else {
	                        $act_range_ext = explode(',', $val['act_range_ext']);
	                        switch ($val['act_range']) {
	                            case 1:
	                                $favourable_list[] = array('name' => $val['act_name'], 'type' => $val['act_type'] == '1' ? 'price_reduction' : 'price_discount', 'type_label' => $val['act_type'] == '1' ? __('满减') : __('满折'));
	                                break;
	                            case 2:
	                                $favourable_list[] = array('name' => $val['act_name'], 'type' => $val['act_type'] == '1' ? 'price_reduction' : 'price_discount', 'type_label' => $val['act_type'] == '1' ? __('满减') : __('满折'));
	                                break;
	                            case 3:
	                                $favourable_list[] = array('name' => $val['act_name'], 'type' => $val['act_type'] == '1' ? 'price_reduction' : 'price_discount', 'type_label' => $val['act_type'] == '1' ? __('满减') : __('满折'));
	                                break;
	                            default:
	                                break;
	                        }
	                    }
	                }
	                $goods_info['favourable_list'] = $favourable_list;
	            }
	            
	            $disk = RC_Filesystem::disk();
	            $default_image = RC_Theme::get_template_directory_uri() . '/images/mobile_app_icon.png';
	            $goods_logo = !empty($goods_info['goods_thumb']) && $disk->exists(RC_Upload::upload_path($goods_info['goods_thumb'])) ? RC_Upload::upload_path($goods_info['goods_thumb']) : $default_image;
	            $goods_info['url'] = with(new Ecjia\App\Mobile\Qrcode\GenerateGoods($goods_id,  $goods_logo))->getQrcodeUrl();
	            
	            $shop_info = merchant_function::get_merchant_info($store_id);
	            $goods_info['goods_thumb'] = !empty($goods_info['goods_thumb']) ? RC_Upload::upload_url($goods_info['goods_thumb']) : '';
	            
	            $mobile_iphone_qrcode = ecjia::config('mobile_iphone_qrcode');
	            $goods_info['mobile_iphone_qrcode'] = !empty($mobile_iphone_qrcode) ? RC_Upload::upload_url() . '/' . $mobile_iphone_qrcode : '';
	            
	            if (!empty($goods_info['goods_desc'])) {
	                $goods_info['goods_desc'] = stripslashes($goods_info['goods_desc']);
	            }
	            
	            $cat_str = pc_function::get_cat_str($goods_info['cat_id']);
	            $goods_info['cat_html'] = pc_function::get_cat_html($cat_str);

	            $goods_info['order_amount'] = RC_DB::table('order_info')->where('store_id', $store_id)->where('order_status', 5)->where('shipping_status', 2)->where('pay_status', 2)->count();
	            ecjia_front::$controller->assign('shop_info', $shop_info);
	            ecjia_front::$controller->assign('goods_info', $goods_info);
	            ecjia_front::$controller->assign('pc_keywords', $goods_info['keywords']);
	            ecjia_front::$controller->assign('pc_description', $goods_info['goods_brief']);
	            ecjia_front::$controller->assign_title('商品详情');
            }
        }
        ecjia_front::$controller->display('goods_show.dwt', $cache_id);
    }
}
// end