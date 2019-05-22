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
 * 商品模块控制器代码
 */
class goods_controller
{
    /*
     * 分类信息
     * 获取分类信息
     */
    public static function init()
    {
        $cache_id = sprintf('%X', crc32($_SERVER['QUERY_STRING']));

        if (!ecjia_front::$controller->is_cached('category_list.dwt', $cache_id)) {
            $cat_id = isset($_GET['cid']) && intval($_GET['cid']) > 0 ? intval($_GET['cid']) : 0;

            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::GOODS_CATEGORY)->run();
            if (!is_ecjia_error($data) && !empty($data)) {
                if (empty($cat_id)) {
                    $cat_id = $data[0]['id'];
                }
                foreach ($data as $key => $val) {
                    if (!empty($val['ad'])) {
                        foreach ($val['ad'] as $k => $v) {
                            if ($k == 0) {
                                $data[$key]['image'] = !empty($v['image']) ? $v['image'] : $val['image'];
                                $data[$key]['text']  = $v['text'];
                                if (!empty($v['url']) && strpos($v['url'], 'ecjiaopen://app?open_type=goods_seller_list') === 0) {
                                    $data[$key]['url'] = with(new ecjia_open($v['url']))->toHttpUrl();
                                }
                            }
                        }
                    }
                    unset($data[$key]['ad']);

                    if (!empty($val['children'])) {
                        foreach ($val['children'] as $k => $j) {
                            if (!empty($j['ad'])) {
                                foreach ($j['ad'] as $m => $n) {
                                    if ($m == 0) {
                                        $data[$key]['children'][$k]['image'] = !empty($n['image']) ? $n['image'] : $j['image'];
                                        $data[$key]['children'][$k]['text']  = $n['text'];
                                        if (!empty($n['url']) && strpos($n['url'], 'ecjiaopen://app?open_type=goods_seller_list') === 0) {
                                            $data[$key]['children'][$k]['url'] = with(new ecjia_open($n['url']))->toHttpUrl();
                                        }
                                    }
                                }
                            }
                            unset($data[$key]['children'][$k]['ad']);

                            if (!empty($j['children'])) {
                                foreach ($j['children'] as $q => $w) {
                                    if (!empty($w['ad'])) {
                                        foreach ($w['ad'] as $o => $p) {
                                            if ($o == 0) {
                                                $data[$key]['children'][$k]['children'][$q]['image'] = !empty($p['image']) ? $p['image'] : $w['image'];
                                                $data[$key]['children'][$k]['children'][$q]['text']  = $p['text'];
                                                if (!empty($p['url']) && strpos($p['url'], 'ecjiaopen://app?open_type=goods_seller_list') === 0) {
                                                    $data[$key]['children'][$k]['children'][$q]['url'] = with(new ecjia_open($p['url']))->toHttpUrl();
                                                }
                                            }
                                        }
                                    }
                                    unset($data[$key]['children'][$k]['children'][$q]['ad']);
                                }
                            }
                        }
                    }
                }
                ecjia_front::$controller->assign('cat_id', $cat_id);
                ecjia_front::$controller->assign('data', $data);
            }
            ecjia_front::$controller->assign_title(__('所有分类', 'h5'));
            ecjia_front::$controller->assign('active', 'category');
            ecjia_front::$controller->assign_lang();
        }
        ecjia_front::$controller->display('category_list.dwt', $cache_id);
    }

    /**
     * 商品详情
     */
    public static function show()
    {
        $goods_id = isset($_GET['goods_id']) ? intval($_GET['goods_id']) : 0;

        $url = RC_Uri::url('goods/index/show', array('goods_id' => $goods_id));
        touch_function::redirect_referer_url($url);

        $rec_type  = isset($_GET['rec_type']) ? $_GET['rec_type'] : 0;
        $object_id = isset($_GET['object_id']) ? $_GET['object_id'] : 0;
        $product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0; //货品id

        $ecjia_goods_specification = new ecjia_goods_specification($goods_id);

        $ecjia_goods_specification->deleteLocalStorage();

//        RC_Cache::app_cache_delete(sprintf('%X', crc32('goods_product_specification_' . $goods_id)), 'goods');

        $par = array(
            'goods_id'  => $goods_id,
            'rec_type'  => $rec_type,
            'object_id' => $object_id,
        );

        //货品id参数 1.30.1新增
        if (!empty($product_id)) {
            $par['product_id'] = $product_id;
        }

        $goods_activity_id = intval($_GET['act_id']);
        if (!empty($goods_activity_id)) {
            $par['goods_activity_id'] = $goods_activity_id;
        }

        /*商品基本信息*/
        $goods_info = ecjia_touch_manager::make()->api(ecjia_touch_api::GOODS_DETAIL)->data($par)->run();

        if (is_ecjia_error($goods_info)) {
            ecjia_front::$controller->assign('no_goods_info', 1);
            $goods_info = array();
        } else {
            if (!empty($goods_info['promote_end_date'])) {
                $goods_info['promote_end_time'] = RC_Time::local_strtotime($goods_info['promote_end_date']);
            }

            $token = ecjia_touch_user::singleton()->getToken();
            $user  = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->data(array('token' => $token))->run();
            if (!is_ecjia_error($user) && $goods_info['promote_price'] == 0) {
                if (!empty($goods_info['rank_prices'])) {
                    foreach ($goods_info['rank_prices'] as $k => $v) {
                        if ($v['id'] == $user['rank_id'] && $goods_info['promote_price'] > $v['unformatted_price']) {
                            $goods_info['promote_price']          = $v['unformatted_price'];
                            $goods_info['formated_promote_price'] = $v['price'];
                        }
                    }
                }
            }

//            dd($goods_info);
            $goods_info['id'] = $goods_info['goods_id'] . '_' . $goods_info['product_id'];

            //店铺信息
            $parameter_list = array(
                'seller_id' => $goods_info['seller_id'],
                'city_id'   => $_COOKIE['city_id'],
            );
            $store_info     = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_CONFIG)->data($parameter_list)->run();
            $store_info     = !is_ecjia_error($store_info) ? $store_info : array();

            $goods_info['shop_closed']      = $store_info['shop_closed'];
            $goods_info['label_trade_time'] = $store_info['label_trade_time'];
            if ($goods_info['promote_price'] != 0 && $goods_info['activity_type'] == 'PROMOTE_GOODS') {
            	$dwt = 'goods_promotion_detail.dwt';
            } else {
            	$dwt = 'goods_show.dwt';
            }
           
            if ($store_info['shop_closed'] != 1) {
                
                if (!empty($goods_info['product_specification'])) {

                    $ecjia_goods_specification->saveLocalStorage([
                        'specification' => $goods_info['specification'],
                        'product_specification' => $goods_info['product_specification'],
                    ]);

                    $product_info = $ecjia_goods_specification->findProductSpecificationByProductId($product_id, $goods_info['product_specification']);

//                    if (!empty($product_info)) {
//                        $dwt = 'goods_promotion_detail.dwt';
//                    }

//                    RC_Cache::app_cache_set(sprintf('%X', crc32('goods_product_specification_' . $goods_id)), $goods_info['product_specification'], 'goods');
    
//                    foreach ($goods_info['product_specification'] as $k => $v) {
//                        if (!empty($product_id) && $v['product_id'] == $product_id) {
//                            $product_info = $v;
//                            $product_info['product_goods_attr_arr'] = explode('|', $v['product_goods_attr']);
//                            $dwt = 'goods_promotion_detail.dwt';
//                            break;
//                        }
//                    }

                    $goods_info['last_spec'] = explode('|', $product_info['product_goods_attr']);
                    $goods_info['default_product_spec'] = $product_info;
                }

                /*商品所属店铺购物车列表*/
                $ecjia_cart = new ecjia_cart($goods_info['seller_id']);

                $ecjia_cart->deleteLocalStorage();

//                $token   = ecjia_touch_user::singleton()->getToken();
//                $options = array(
//                    'token'     => $token,
//                    'seller_id' => $goods_info['seller_id'],
//                    'location'  => array('longitude' => $_COOKIE['longitude'], 'latitude' => $_COOKIE['latitude']),
//                    'city_id'   => $_COOKIE['city_id'],
//                );

//                RC_Cache::app_cache_delete('cart_goods' . $token . $goods_info['seller_id'] . $_COOKIE['longitude'] . $_COOKIE['latitude'] . $_COOKIE['city_id'], 'cart');

                $cart_goods = array();
                //店铺购物车商品
                if (ecjia_touch_user::singleton()->isSignin() && empty($goods_activity_id)) {

                    $cart_list = $ecjia_cart->getCartList();
                    if (is_ecjia_error($cart_list)) {
                        $cart_list = array();
                    } else {
                        $ecjia_cart->saveLocalStorage($cart_list);
                    }

//                    $cart_goods = ecjia_touch_manager::make()->api(ecjia_touch_api::CART_LIST)->data($options)->run();
//                    if (!is_ecjia_error($cart_goods)) {
//                        RC_Cache::app_cache_set('cart_goods' . $token . $goods_info['seller_id'] . $_COOKIE['longitude'] . $_COOKIE['latitude'] . $_COOKIE['city_id'], $cart_goods, 'cart');
//                    } else {
//                        $cart_goods = array();
//                    }
                    $cart_goods = $cart_list;
                    $cart_goods['arr']                             = array();
                    $cart_goods['current_seller']                  = array(
                        'data_rec' => '',
                    );
                    $cart_goods['current_goods']                   = array(
                        'rec_id' => '',
                        'goods_number' => '',
                        'goods_attr_num' => 0,
                    );
                    $cart_goods['goods_info'] = & $goods_info;

                    $cart_goods = $ecjia_cart->formattedCartGoodsWithCurrentGoods($cart_goods, $goods_id, $product_id);
//
//                    dd($cart_goods);
//                    if (!empty($cart_goods['cart_list'][0]['goods_list'])) {
//                        $cart_goods['cart_list'][0]['total']['check_all'] = true;
//                        $cart_goods['cart_list'][0]['total']['check_one'] = false;
//
//                        foreach ($cart_goods['cart_list'][0]['goods_list'] as $key => $val) {
//                            $goods_attr_id = explode(',', $val['goods_attr_id']);
//                            asort($goods_attr_id);
//
//                            $cart_goods['arr'][$val['goods_id']][] = array('num' => $val['goods_number'], 'rec_id' => $val['rec_id'], 'goods_attr_id' => $goods_attr_id);
//
//                            if ($val['is_checked'] == 1 && $val['is_disabled'] == 0) {
//                                $cart_goods['cart_list'][0]['total']['check_one'] = true; //至少选择了一个
//                                if ($key == 0) {
//                                    $cart_goods['current_seller']['data_rec'] = $val['rec_id'];
//                                } else {
//                                    $cart_goods['current_seller']['data_rec'] .= ',' . $val['rec_id'];
//                                }
//                            } elseif ($val['is_checked'] == 0) {
//                                $cart_goods['cart_list'][0]['total']['check_all']    = false; //全部选择
//                                $cart_goods['cart_list'][0]['total']['goods_number'] -= $v['goods_number'];
//                            }
//                            $cart_goods['current_seller']['data_rec'] = trim($cart_goods['current_seller']['data_rec'], ',');
//                            if ($goods_id == $val['goods_id']) {
//                                $cart_goods['current_goods']['goods_attr_num'] += $val['goods_number'];
//                            }
//
//                            if ($val['goods_id'] == $goods_id && (!isset($goods_info['last_spec']) || $goods_info['last_spec'] == $goods_attr_id)) {
//                                $goods_info['last_spec']                     = explode(',', $val['goods_attr_id']);
//                                $cart_goods['current_goods']['rec_id']       = $val['rec_id'];
//                                $cart_goods['current_goods']['goods_number'] = $val['goods_number'];
//                                $cart_goods['current_spec']                  = $val;
//                            }
//                        }
//                    } else {
//                        $cart_goods['cart_list'][0]['total']['check_all'] = false;
//                        $cart_goods['cart_list'][0]['total']['check_one'] = false;
//                    }
                }
            }

//            dd($cart_goods);

            $product_goods_attr_html = '';
            $goods_info['has_spec'] = 0;
            if (!empty($goods_info['specification'])) {
                foreach ($goods_info['specification'] as $k => $v) {
                    if (!empty($v['value'])) {
                        foreach ($v['value'] as $key => $val) {

                            if (!empty($goods_info['last_spec'])) {
                                if (in_array($val['id'], $goods_info['last_spec'])) {
                                    $goods_info['has_spec']                                   = 1;
                                    $goods_info['specification'][$k]['value'][$key]['active'] = 1;
                                }
                            }

                            if (!empty($product_info['product_goods_attr_arr']) && in_array($val['id'], $product_info['product_goods_attr_arr'])) {
                                $product_goods_attr_html .= $val['label'] . '/';
                            }
                        }
                    }
                }
            }
            $product_info['product_goods_attr_html'] = !empty($product_goods_attr_html) ? rtrim($product_goods_attr_html, '/') : '';

            $goods_info['product_goods_attr_label'] = $ecjia_goods_specification->convertProductGoodsAttrLabel($goods_info['product_goods_attr']);
            ecjia_front::$controller->assign('product_info', $product_info);

            $spec_releated_goods = $related_goods_list = array();
            if (!empty($goods_info['related_goods'])) {
                foreach ($goods_info['related_goods'] as $k => & $v) {
                    $v['id'] = $v['goods_id'] . '_' . $v['product_id'];
                    $v['store_id'] = $goods_info['seller_id'];
                    $v['num'] = '';
                    $v['rec_id'] = '';
                    $v['default_spec'] = '';
                    
                    if (!empty($cart_goods['arr'])) {
                        $find_goods = $ecjia_cart->findGoodsWithProduct($v['goods_id'], $v['product_id'], $cart_goods['arr']);
                        if (!empty($find_goods)) {
                            $v['num'] = $find_goods['num'];
                            $v['rec_id'] = $find_goods['rec_id'];
                            
                            if (!empty($find_goods['goods_attr_id'])) {
                                $v['default_spec'] = implode(',', $find_goods['goods_attr_id']);
                            }
                        }
                    } else {
                    	if (!empty($v['specification'])) {
                    		$ecjia_goods_specification = new ecjia_goods_specification($v['goods_id']);
                    		$v['default_spec'] = $ecjia_goods_specification->findDefaultProductGoodsAttrId($v['specification']);
                    	}
                    }

                    if (!empty($v['specification'])) {
                        $spec_releated_goods[$v['id']]['goods_price'] = ltrim((!empty($v['promote_price']) ? $v['promote_price'] : ($v['shop_price'] == __('免费', 'h5') ? '0' : $v['shop_price'])), '￥');
                        $spec_releated_goods[$v['id']]['goods_info']['goods_id'] = $v['goods_id'];
                        $spec_releated_goods[$v['id']]['goods_info']  = $v;

//                        if (!empty($cart_goods['arr']) && array_key_exists($v['goods_id'], $cart_goods['arr'])) {
//                            foreach ($cart_goods['arr'][$v['goods_id']] as $j => $n) {
//                                $goods_info['related_goods'][$k]['num'] += $n['num'];
//
//                                if (!empty($n['goods_attr_id']) && !isset($goods_info['related_goods'][$k]['default_spec'])) {
//                                    $goods_info['related_goods'][$k]['default_spec'] = implode(',', $n['goods_attr_id']);
//                                }
//                            }
//                        }
                    }

                    if ($k < 6) {
                        /**
                         * @todo 相关商品处理
                         */
//                        $related_goods_list[] = $v['goods_id'];
                    }
                }
            }

            $goods_info['in_related_goods'] = 0;
            if (!empty($related_goods_list)) {
                if (in_array($goods_id, $related_goods_list)) {
                    $goods_info['in_related_goods'] = 1;
                }
            }

            ecjia_front::$controller->assign('releated_goods', json_encode($spec_releated_goods));

            if (!empty($goods_info['groupbuy_info']['price_ladder'])) {
                $goods_info['groupbuy_info']['price_ladder'] = json_encode($goods_info['groupbuy_info']['price_ladder']);
            }

//            dd($goods_info);
            ecjia_front::$controller->assign('goods_info', $goods_info);
        }

        /*商品描述*/
        $goods_desc = ecjia_touch_manager::make()->api(ecjia_touch_api::GOODS_DESC)->data(array('goods_id' => $goods_id, 'product_id' => $product_id))->run();
        if (!is_ecjia_error($goods_desc) && !empty($goods_desc)) {
            $res = array();
            preg_match('/<body>([\s\S]*?)<\/body>/', $goods_desc, $res);
            $bodystr = trim($res[0]);
            if ($bodystr != '<body></body>') {
                ecjia_front::$controller->assign('goods_desc', stripslashes($bodystr));
            }
        }

//        dd($cart_goods);

        if (ecjia_touch_user::singleton()->isSignin()) {
            ecjia_front::$controller->assign('rec_id', $cart_goods['current_goods']['rec_id']);
            ecjia_front::$controller->assign('num', $cart_goods['current_goods']['goods_number']); //该商品购物车数量
            ecjia_front::$controller->assign('goods_attr_num', $cart_goods['current_goods']['goods_attr_num']); //多规格商品数量
            ecjia_front::$controller->assign('data_rec', $cart_goods['current_seller']['data_rec']); //该店铺购物车商品rec_id

            ecjia_front::$controller->assign('cart_list', $cart_goods['cart_list']['goods_list']);
            ecjia_front::$controller->assign('count', $cart_goods['cart_list']['total']);

            ecjia_front::$controller->assign('real_count', $cart_goods['total']);
            ecjia_front::$controller->assign('current_spec', $cart_goods['current_spec']);
        }

        if (isset($_COOKIE['location_address_id']) && $_COOKIE['location_address_id'] > 0) {
            ecjia_front::$controller->assign('address_id', $_COOKIE['location_address_id']);
        }
        ecjia_front::$controller->assign('referer_url', urlencode(RC_Uri::url('goods/index/show', array('goods_id' => $goods_id))));

        //商品评论
        $limit = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $pages = intval($_GET['page']) ? intval($_GET['page']) : 1;

        $info     = array(
            'goods_id'     => $goods_id,
            'comment_type' => 'all',
            'pagination'   => array('count' => $limit, 'page' => $pages),
        );
        $comments = ecjia_touch_manager::make()->api(ecjia_touch_api::GOODS_COMMENTS)->data($info)->hasPage()->run();

        if (!is_ecjia_error($comments)) {
            list($data, $page) = $comments;
            if (isset($page['more']) && $page['more'] == 0) {
                $is_last = 1;
            }

            ecjia_front::$controller->assign('comment_list', $data);
            ecjia_front::$controller->assign('is_last', $is_last);
            ecjia_front::$controller->assign('comment_number', $data['comment_number']);
        }

        ecjia_front::$controller->assign('ajax_url', RC_Uri::url('goods/index/ajax_goods_comment', array('goods_id' => $goods_id)));
        ecjia_front::$controller->assign('store_id', $goods_info['seller_id']);

        ecjia_front::$controller->assign_title($goods_info['goods_name']);

        if (user_function::is_weixin()) {
            $protocol   = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $spread_url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $spread_url = strrpos($spread_url, "&_pjax") ? substr($spread_url, 0, strrpos($spread_url, "&_pjax")) : $spread_url;
            ecjia_front::$controller->assign('share_link', $spread_url);

            $config = user_function::get_wechat_config($spread_url);
            ecjia_front::$controller->assign('config', $config);
        }
        
        ecjia_front::$controller->display($dwt);
    }

    public static function ajax_goods_comment()
    {
        //商品评论
        $goods_id     = isset($_GET['goods_id']) ? $_GET['goods_id'] : 0;
        $limit        = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $pages        = intval($_GET['page']) ? intval($_GET['page']) : 1;
        $comment_type = isset($_GET['action_type']) ? trim($_GET['action_type']) : 'all';

        $info     = array(
            'goods_id'     => $goods_id,
            'comment_type' => $comment_type,
            'pagination'   => array('count' => $limit, 'page' => $pages),
        );
        $comments = ecjia_touch_manager::make()->api(ecjia_touch_api::GOODS_COMMENTS)->data($info)->hasPage()->run();

        if (!is_ecjia_error($comments)) {
            list($data, $page) = $comments;
            if (isset($page['more']) && $page['more'] == 0) {
                $is_last = 1;
            }

            $say_list = '';
            if (!empty($data['list'])) {
                ecjia_front::$controller->assign('comment', $data['list']);
                $say_list = ecjia_front::$controller->fetch('merchant_comment_ajax.dwt');
            }
            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('list' => $say_list, 'is_last' => $is_last));
        }
    }

    /**
     * 促销商品
     */
    public static function promotion()
    {
        $promotion_type = !empty($_GET['promotion_type']) ? trim($_GET['promotion_type']) : 'today';
        ecjia_front::$controller->assign('promotion_type', $promotion_type);

        ecjia_front::$controller->assign_title(__('限时促销', 'h5'));
        ecjia_front::$controller->display('goods_promotion.dwt');
    }

    /**
     * 团购商品
     */
    public static function groupbuy()
    {
        ecjia_front::$controller->assign_title(__('团购商品', 'h5'));
        ecjia_front::$controller->display('goods_groupbuy.dwt');
    }

    /**
     * ajax获取促销商品
     */
    public static function ajax_goods()
    {
        $type  = htmlspecialchars($_GET['type']);
        $limit = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $pages = intval($_GET['page']) ? intval($_GET['page']) : 1;

        $longitude = $_COOKIE['longitude'];
        $latitude  = $_COOKIE['latitude'];
        $paramater = array(
            'action_type' => $type,
            'pagination'  => array('count' => $limit, 'page' => $pages),
            'location'    => array('longitude' => $_COOKIE['longitude'], 'latitude' => $_COOKIE['latitude']),
            'city_id'     => $_COOKIE['city_id'],
        );

        $api = ecjia_touch_api::GOODS_SUGGESTLIST;
        if ($type == 'promotion') {
            $dwt = 'goods_promotion_ajax.dwt';
            //促销类型 today今日促销，tomorrow明日促销，aftertheday后日促销
            $promotion_type = !empty($_GET['promotion_type']) ? (trim($_GET['promotion_type']) == 'all' ? '' : trim($_GET['promotion_type'])) : 'today';
            $paramater['promotion_type'] = $promotion_type;

        } elseif ($type == 'new') {
            $dwt = 'goods_new_ajax.dwt';
        } elseif ($type == 'best') {
            $dwt = 'goods_best_ajax.dwt';
        } elseif ($type == 'groupbuy') {
            $dwt = 'goods_groupbuy_ajax.dwt';
            $api = ecjia_touch_api::GROUPBUY_GOODS_LIST;
        }

        $response = ecjia_touch_manager::make()->api($api)->data($paramater)->hasPage()->run();
        if (!is_ecjia_error($response)) {
            list($goods_list, $page) = $response;
			$now_time = RC_Time::gmtime();
            if (!empty($goods_list)) {
                foreach ($goods_list as $k => $v) {
                	if(RC_Time::local_strtotime($v['promote_start_date']) > $now_time) {
                		$goods_list[$k]['promote_end_date'] = RC_Time::local_strtotime($v['promote_start_date']);
                	} else {
                		$goods_list[$k]['promote_end_date'] = RC_Time::local_strtotime($v['promote_end_date']);
                	}
                }
            }
            ecjia_front::$controller->assign('goods_list', $goods_list);
            ecjia_front::$controller->assign_lang();

            $sayList = ecjia_front::$controller->fetch($dwt);

            if (isset($page['more']) && $page['more'] == 0) {
                $goods_list['is_last'] = 1;
            }

            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('list' => $sayList, 'is_last' => $goods_list['is_last']));
        }
    }

    /**
     * 新品首发
     */
    public static function goods_new()
    {
        ecjia_front::$controller->assign_title(__('新品首发', 'h5'));
        ecjia_front::$controller->display('goods_new.dwt');
    }

    /**
     * 店长推荐
     */
    public static function goods_best()
    {
        ecjia_front::$controller->assign_title(__('店长推荐', 'h5'));
        ecjia_front::$controller->display('goods_best.dwt');
    }

    /**
     * 店铺列表
     */
    public static function store_list()
    {
        $show_type = ecjia_theme_option::get_option('i_layout_goods_list_type');

        $cid      = intval($_GET['cid']);
        $store_id = intval($_GET['store_id']);
        $keywords = isset($_REQUEST['keywords']) ? trim($_REQUEST['keywords']) : '';

        $limit = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $pages = intval($_GET['page']) ? intval($_GET['page']) : 1;

        $type = isset($_GET['type']) ? $_GET['type'] : ''; //判断是否是下滑加载
        $arr  = array(
            'pagination' => array('count' => $limit, 'page' => $pages),
            'location'   => array('longitude' => $_COOKIE['longitude'], 'latitude' => $_COOKIE['latitude']),
            'city_id'    => $_COOKIE['city_id'],
        );

        if ($show_type == 'goods' && empty($store_id)) {
            $sort_by = trim($_GET['sort_by']);

            $sort_order = '';
            if ($sort_by == 'price') {
                $sort_order = !empty($_GET['sort_order']) ? trim($_GET['sort_order']) : 'asc';
            }

            ecjia_front::$controller->assign('sort_by', $sort_by);
            ecjia_front::$controller->assign('sort_order', $sort_order);

            ecjia_front::$controller->assign('cid', $cid);
            ecjia_front::$controller->assign('keywords', $keywords);

            ecjia_front::$controller->assign_title(__('商品列表', 'h5'));
            ecjia_front::$controller->display('store_goods_list.dwt');

            return false;
        }

        //店铺信息
        $parameter_list = array(
            'seller_id' => $store_id,
            'city_id'   => $_COOKIE['city_id'],
        );
        $store_info     = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_CONFIG)->data($parameter_list)->run();
        $store_info     = is_ecjia_error($store_info) ? array() : $store_info;
        ecjia_front::$controller->assign('store_info', $store_info);

        $cache_id = sprintf('%X', crc32($limit . '-' . $pages . '-' . $_COOKIE['longitude'] . '-' . $_COOKIE['latitude'] . '-' . $_COOKIE['city_id']));
        $arr_list = array();
        if ($keywords !== '') {
            if (!empty($store_id)) {
                $url = RC_Uri::url('goods/category/store_list', array('store_id' => $store_id, 'keywords' => $keywords));
                touch_function::redirect_referer_url($url);

                $arr['filter']['keywords'] = $keywords;
                $arr['seller_id']          = $store_id;

                $response = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_GOODS_LIST)->data($arr)->hasPage()->run();
                if (!is_ecjia_error($response)) {
                    list($arr_list, $page) = $response;
                }

                if ($store_info['shop_closed'] != 1) {
                    //购物车商品
                    $token     = ecjia_touch_user::singleton()->getToken();
                    $paramater = array(
                        'token'    => $token,
                        'location' => array('longitude' => $_COOKIE['longitude'], 'latitude' => $_COOKIE['latitude']),
                        'city_id'  => $_COOKIE['city_id'],
                    );
                    if (!empty($store_id)) {
                        $paramater['seller_id'] = $store_id;
                    }
                    //店铺购物车商品
                    $cart_list = RC_Cache::app_cache_get('cart_goods' . $token . $store_id . $_COOKIE['longitude'] . $_COOKIE['latitude'] . $_COOKIE['city_id'], 'cart');

                    if (empty($cart_list)) {
                        $cart_list = ecjia_touch_manager::make()->api(ecjia_touch_api::CART_LIST)->data($paramater)->run();
                        if (!is_ecjia_error($cart_list)) {
                            RC_Cache::app_cache_set('cart_goods' . $token . $store_id . $_COOKIE['longitude'] . $_COOKIE['latitude'] . $_COOKIE['city_id'], $cart_list, 'cart');
                        } else {
                            $cart_list = array();
                        }
                    }
                    $cart_list['arr'] = array();
                    if (!empty($cart_list)) {
                        $cart_list['cart_list'][0]['total']['check_all'] = true;
                        $cart_list['cart_list'][0]['total']['check_one'] = false;
                        $rec_id                                          = '';
                        if (!empty($cart_list['cart_list'][0]['goods_list'])) {
                            foreach ($cart_list['cart_list'][0]['goods_list'] as $k => $v) {
                                $goods_attr_id = array();
                                if (!empty($v['goods_attr_id'])) {
                                    $goods_attr_id = explode(',', $v['goods_attr_id']);
                                    asort($goods_attr_id);
                                }
                                $cart_list['arr'][$v['goods_id']][] = array('num' => $v['goods_number'], 'rec_id' => $v['rec_id'], 'goods_attr_id' => $goods_attr_id);
                                if ($v['is_checked'] == 1 && $v['is_disabled'] == 0) {
                                    $cart_list['cart_list'][0]['total']['check_one'] = true; //至少选择了一个
                                    if ($k == 0) {
                                        $rec_id = $v['rec_id'];
                                    } else {
                                        $rec_id .= ',' . $v['rec_id'];
                                    }
                                } elseif ($v['is_checked'] == 0) {
                                    $cart_list['cart_list'][0]['total']['check_all']    = false; //全部选择
                                    $cart_list['cart_list'][0]['total']['goods_number'] -= $v['goods_number'];
                                }
                                $rec_id = trim($rec_id, ',');
                            }
                        } else {
                            $cart_list['cart_list'][0]['total']['check_all'] = false;
                            $cart_list['cart_list'][0]['total']['check_one'] = false;
                        }

                        $spec_goods = array();
                        if (!empty($arr_list)) {
                            foreach ($arr_list as $k => $v) {
                                if (!empty($v['specification'])) {
                                    $spec_goods[$v['id']]['goods_price'] = ltrim((!empty($v['promote_price']) ? $v['promote_price'] : ($v['shop_price'] == '免费' ? '0' : $v['shop_price'])), '￥');
                                    $spec_goods[$v['id']]['goods_info']  = $v;
                                    unset($spec_goods[$v['id']]['goods_info']['img']);
                                    $spec_goods[$v['id']]['goods_info']['goods_id'] = $v['id'];

                                }
                                if (array_key_exists($v['id'], $cart_list['arr'])) {
                                    foreach ($cart_list['arr'][$v['id']] as $j => $n) {
                                        $arr_list[$k]['num'] += $n['num'];
                                        if (empty($n['goods_attr_id'])) {
                                            $arr_list[$k]['rec_id'] = $n['rec_id'];
                                        }

                                        if (!empty($n['goods_attr_id']) && !isset($arr_list[$k]['default_spec'])) {
                                            $arr_list[$k]['default_spec'] = implode(',', $n['goods_attr_id']);
                                        }
                                    }
                                }
                                $arr_list[$k]['store_id'] = $store_id;
                            }
                        }
                        ecjia_front::$controller->assign('releated_goods', json_encode($spec_goods));
                        ecjia_front::$controller->assign('cart_list', $cart_list['cart_list'][0]['goods_list']);
                        ecjia_front::$controller->assign('count', $cart_list['cart_list'][0]['total']);
                        ecjia_front::$controller->assign('real_count', $cart_list['total']);
                        ecjia_front::$controller->assign('rec_id', $rec_id);
                    }
                }

                if (isset($_COOKIE['location_address_id']) && $_COOKIE['location_address_id'] > 0) {
                    ecjia_front::$controller->assign('address_id', $_COOKIE['location_address_id']);
                }
                if ($type == 'ajax_get') {
                    ecjia_front::$controller->assign('goods_list', $arr_list);
                    $say_list = ecjia_front::$controller->fetch('store_list_ajax.dwt');
                } else {
                    user_function::insert_search($keywords, $store_id); //记录搜索
                }

            } else {
                $arr['keywords'] = $keywords;

                $response = ecjia_touch_manager::make()->api(ecjia_touch_api::SELLER_LIST)->data($arr)->hasPage()->run();
                if (!is_ecjia_error($response)) {
                    list($arr_list, $page) = $response;

                    if ($type == 'ajax_get') {
                        $arr_list = merchant_function::format_distance($arr_list);
                        ecjia_front::$controller->assign('data', $arr_list);
                        $say_list = ecjia_front::$controller->fetch('library/ajax/store_list_ajax.lbi', $cache_id);
                    } else {
                        user_function::insert_search($keywords, $store_id); //记录搜索
                    }
                }
            }
            ecjia_front::$controller->assign('store_id', $store_id);
            ecjia_front::$controller->assign('keywords', $keywords);
        } else {
            $arr['category_id'] = $cid;
            $response           = ecjia_touch_manager::make()->api(ecjia_touch_api::GOODS_SELLER_LIST)->data($arr)->hasPage()->run();

            if (!is_ecjia_error($response)) {
                list($arr_list, $page) = $response;

                if ($type == 'ajax_get') {
                    $arr_list = merchant_function::format_distance($arr_list);
                    ecjia_front::$controller->assign('data', $arr_list);
                    $say_list = ecjia_front::$controller->fetch('library/ajax/store_list_ajax.lbi', $cache_id);
                }
            }
        }

        if (isset($page['more']) && $page['more'] == 0) {
            $data['is_last'] = 1;
        }

        ecjia_front::$controller->assign('is_last', $data['is_last']);

        if (isset($page['total']) && $page['total'] == 0) {
            $arr_list = array();
        }

        $arr_list = merchant_function::format_distance($arr_list);

        ecjia_front::$controller->assign('data', $arr_list);
        ecjia_front::$controller->assign('count_search', count($arr_list));
        ecjia_front::$controller->assign('cid', $cid);

        if ($type == 'ajax_get') {
            $response = array('list' => $say_list, 'is_last' => $data['is_last'], 'spec_goods' => $spec_goods);
            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, $response);
        }

        ecjia_front::$controller->assign('referer_url', urlencode(RC_Uri::url('goods/category/store_list', array('store_id' => $store_id, 'keywords' => $keywords))));
        ecjia_front::$controller->assign_title(__('店铺列表', 'h5'));
        ecjia_front::$controller->display('store_list.dwt');
    }

    public static function ajax_store_goods()
    {
        $cid        = intval($_GET['cid']);
        $keywords   = isset($_REQUEST['keywords']) ? trim($_REQUEST['keywords']) : '';
        $sort_by    = trim($_GET['sort_by']);
        $sort_order = trim($_GET['sort_order']);

        $limit = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $pages = intval($_GET['page']) ? intval($_GET['page']) : 1;

        $arr = array(
            'pagination' => array('count' => $limit, 'page' => $pages),
            'location'   => array('longitude' => $_COOKIE['longitude'], 'latitude' => $_COOKIE['latitude']),
            'city_id'    => $_COOKIE['city_id'],
        );

        $arr['filter']['category_id'] = $cid;

        if (!empty($sort_by)) {
            if ($sort_by == 'price') {
                $sort_order               = $sort_order == 'asc' ? 'desc' : 'asc';
                $arr['filter']['sort_by'] = $sort_by . '_' . $sort_order;
            } else {
                $arr['filter']['sort_by'] = $sort_by;
            }
        }

        if (!empty($keywords)) {
            $arr['filter']['keywords'] = $keywords;
        }

        $response = ecjia_touch_manager::make()->api(ecjia_touch_api::GOODS_LIST)->data($arr)->hasPage()->run();
        if (!is_ecjia_error($response)) {
            list($goods_list, $page) = $response;

            ecjia_front::$controller->assign('goods_list', $goods_list);
            ecjia_front::$controller->assign_lang();

            $sayList = ecjia_front::$controller->fetch('store_goods_list_ajax.dwt');

            if (isset($page['more']) && $page['more'] == 0) {
                $goods_list['is_last'] = 1;
            }

            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('list' => $sayList, 'is_last' => $goods_list['is_last']));
        }
    }
}

// end
