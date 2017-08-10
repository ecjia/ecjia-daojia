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
 * 单个商品的信息
 * @author royalwang
 */
class detail_module extends api_front implements api_interface {

    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    	$this->authSession();
        //如果用户登录获取其session
		
        $goods_id = $this->requestData('goods_id', 0);
        $goods_id = intval($goods_id);
        
        if ($goods_id <= 0) {
        	return new ecjia_error('invalid_parameter', RC_Lang::get('system::system.invalid_parameter'));
        }

        $rec_type = $this->requestData('rec_type');
        $object_id = $this->requestData('object_id');

        /* 获得商品的信息 */
        RC_Loader::load_app_func('admin_goods', 'goods');
        RC_Loader::load_app_func('admin_category', 'goods');
		
        /*增加商品基本信息缓存*/
        $cache_goods_basic_info_key = 'goods_basic_info_'.$goods_id;
        $cache_basic_info_id = sprintf('%X', crc32($cache_goods_basic_info_key));
        $orm_goods_db = RC_Model::model('goods/orm_goods_model');
        $goods = $orm_goods_db->get_cache_item($cache_basic_info_id);

        if (empty($goods)) {
        	$goods = get_goods_info($goods_id);
        	$orm_goods_db->set_cache_item($cache_basic_info_id);
        }
      
        if ($goods === false) {
            /* 如果没有找到任何记录则跳回到首页 */
           return new ecjia_error('does not exist', '不存在的信息');
        } else {
            if ($goods['brand_id'] > 0) {
                $goods['goods_brand_url'] = build_uri('brand', array('bid' => $goods['brand_id']), $goods['goods_brand']);
            }
            /* 加入验证如果价格不存在，则为0 */
            $shop_price = $goods['shop_price'];
            $linked_goods = array();

            $goods['goods_style_name'] = add_style($goods['goods_name'], $goods['goods_name_style']);

            /* 购买该商品可以得到多少钱的红包 */
            if ($goods['bonus_type_id'] > 0) {
                $time = RC_Time::gmtime();
                $db_bonus_type = RC_Model::model('bonus/bonus_type_model');
                $goods['bonus_money'] = $db_bonus_type->where(array('type_id' => $goods['bonus_type_id'] , 'send_type' => SEND_BY_GOODS , 'send_start_date' => array('elt' => $time) , 'send_end_date' => array('egt' => $time)))-> get_field('type_money');

                if ($goods['bonus_money'] > 0) {
                    $goods['bonus_money'] = price_format($goods['bonus_money']);
                }
            }
			
            /*增加商品的规格和属性缓存*/
            $cache_goods_properties_key = 'goods_properties_'.$goods_id;
            $cache_goods_properties_id = sprintf('%X', crc32($cache_goods_properties_key));
            $goods_type_db = RC_Model::model('goods/orm_goods_type_model');
            $properties = $goods_type_db->get_cache_item($cache_goods_properties_id);
            if (empty($properties)) {
            	$properties = get_goods_properties($goods_id); // 获得商品的规格和属性
            	$goods_type_db->set_cache_item($cache_goods_properties_id);
            }
            
            // 获取关联礼包
//             $package_goods_list = get_package_goods_list($goods['goods_id']);
//             $volume_price_list = get_volume_price_list($goods['goods_id'], '1');// 商品优惠价格区间
        }

        /* 更新点击次数 */
        $db_goods = RC_Model::model('goods/goods_model');
        $db_goods->inc('click_count', 'goods_id='.$goods_id, 1);

        $data = $goods;
         
		/*给指定商品的各会员等级对应价格增加缓存*/
        $cache_goods_user_rank_prices_key = 'goods_user_rank_prices_'.$goods_id. '-' . $shop_price;
        $cache_user_rank_prices_id = sprintf('%X', crc32($cache_goods_user_rank_prices_key));
        $orm_member_price_db = RC_Model::model('goods/orm_member_price_model');
        $user_rank_prices = $orm_member_price_db->get_cache_item($cache_user_rank_prices_id);
        if (empty($user_rank_prices)) {
        	$user_rank_prices = get_user_rank_prices($goods_id, $shop_price);
        	$orm_member_price_db->set_cache_item($cache_goods_properties_id);      	
        }
        
        /*给商品的相册增加缓存*/
        $cache_goods_gallery_key = 'goods_gallery_'.$goods_id;
        $cache_goods_gallery_id = sprintf('%X', crc32($cache_goods_gallery_key));
        $orm_goods_gallery_db = RC_Model::model('goods/orm_goods_gallery_model');
        $goods_gallery = $orm_goods_gallery_db->get_cache_item($cache_goods_gallery_id);
        if (empty($goods_gallery)) {
        	$goods_gallery = EM_get_goods_gallery($goods_id);
        	$orm_goods_gallery_db->set_cache_item($cache_goods_gallery_id);
        }
        
        $data['rank_prices']     = !empty($shop_price) ? $user_rank_prices : 0;
        $data['pictures']        = $goods_gallery;
        $data['properties']      = $properties['pro'];
        $data['specification']   = $properties['spe'];
        $data['collected']       = 0;
		
        /*如果用户登录，获取该会员的等级对应的商品的shop_price*/
        if ($_SESSION['user_id'] > 0 && !empty($data['rank_prices'])) {
        	$user_rank = RC_DB::table('users')->where('user_id', $_SESSION['user_id'])->pluck('user_rank');
        	foreach ($data['rank_prices'] as $key => $val) {
        		if ($key == $user_rank) {
        			$data['shop_price'] = $val['unformatted_price'];
        		}
        	}
        }
        
        $db_favourable = RC_Model::model('favourable/favourable_activity_model');
       	/*增加优惠活动缓存*/
		$store_options = array(
				'store_id' => $goods['store_id']
		);
		$favourable_result = RC_Api::api('favourable', 'store_favourable_list', $store_options);
        $favourable_list = array();
        if (empty($rec_type)) {
        	if (!empty($favourable_result)) {
        		foreach ($favourable_result as $val) {
        			if ($val['act_range'] == '0') {
        				$favourable_list[] = array(
        						'name' => $val['act_name'],
        						'type' => $val['act_type'] == '1' ? 'price_reduction' : 'price_discount',
        						'type_label' => $val['act_type'] == '1' ? __('满减') : __('满折'),
        				);
        			} else {
        				$act_range_ext = explode(',', $val['act_range_ext']);
        				switch ($val['act_range']) {
        					case 1 :
        						if (in_array($goods['cat_id'], $act_range_ext)) {
        							$favourable_list[] = array(
        								'name' => $val['act_name'],
        								'type' => $val['act_type'] == '1' ? 'price_reduction' : 'price_discount',
        								'type_label' => $val['act_type'] == '1' ? __('满减') : __('满折'),
        							);
        						}
        						break;
        					case 2 :
        						if (in_array($goods['brand_id'], $act_range_ext)) {
        							$favourable_list[] = array(
        								'name' => $val['act_name'],
        								'type' => $val['act_type'] == '1' ? 'price_reduction' : 'price_discount',
        								'type_label' => $val['act_type'] == '1' ? __('满减') : __('满折'),
        							);
        						}
        						break;
        					case 3 :
        						if (in_array($goods['goods_id'], $act_range_ext)) {
        							$favourable_list[] = array(
        								'name' => $val['act_name'],
        								'type' => $val['act_type'] == '1' ? 'price_reduction' : 'price_discount',
        								'type_label' => $val['act_type'] == '1' ? __('满减') : __('满折'),
        							);
        						}
        						break;
        					default:
        						break;
        				}
        			}
        		}
        	}
        }

        if ($_SESSION['user_id']) {
            // 查询收藏夹状态
            $db_collect_goods = RC_Model::model('goods/collect_goods_model');
            $count = $db_collect_goods->where(array('user_id' => $_SESSION['user_id'] , 'goods_id' => $goods_id))->count();

            if ($count > 0) {
                $data['collected'] = 1;
            }
        }
		
        $data = API_DATA('GOODS', $data);
        $data['unformatted_shop_price'] = $goods['shop_price'];
        if ($rec_type == 'GROUPBUY_GOODS') {
        	/* 取得团购活动信息 */
        	$group_buy = group_buy_info($object_id);
        	$data['promote_price'] = $group_buy['cur_price'];
        	$data['formated_promote_price'] = $group_buy['formated_cur_price'];
        	$data['promote_start_date'] = $group_buy['formated_start_date'];
        	$data['promote_end_date'] = $group_buy['formated_end_date'];
        	$activity_type = 'GROUPBUY_GOODS';
        } else {
        	$mobilebuy_db = RC_Model::model('goods/goods_activity_model');
        	$groupbuy = $mobilebuy_db->find(array(
        		'goods_id'	 => $data['id'],
        		'start_time' => array('elt' => RC_Time::gmtime()),
        		'end_time'	 => array('egt' => RC_Time::gmtime()),
        		'act_type'	 => GAT_GROUP_BUY,
        	));
        	$mobilebuy = $mobilebuy_db->find(array(
        		'goods_id'	 => $data['id'],
        		'start_time' => array('elt' => RC_Time::gmtime()),
        		'end_time'	 => array('egt' => RC_Time::gmtime()),
        		'act_type'	 => GAT_MOBILE_BUY,
        	));
        	/* 判断是否有促销价格*/
        	$price = ($data['unformatted_shop_price'] > $goods['promote_price_org'] && $goods['promote_price_org'] > 0) ? $goods['promote_price_org'] : $data['unformatted_shop_price'];
        	$activity_type = ($data['unformatted_shop_price'] > $goods['promote_price_org'] && $goods['promote_price_org'] > 0) ? 'PROMOTE_GOODS' : 'GENERAL_GOODS';


        	$mobilebuy_price = $groupbuy_price = 0;
        	if (!empty($mobilebuy)) {
       			$ext_info = unserialize($mobilebuy['ext_info']);
       			$mobilebuy_price = $ext_info['price'];
       			if ($mobilebuy_price < $price) {
       				$goods['promote_start_date'] = $mobilebuy['start_time'];
       				$goods['promote_end_date'] = $mobilebuy['end_time'];
       			}
       			$price = $mobilebuy_price > $price ? $price : $mobilebuy_price;
       			$activity_type = $mobilebuy_price > $price ? $activity_type : 'MOBILEBUY_GOODS';
			}

        }

        /* 计算节约价格*/
        $saving_price = ($data['unformatted_shop_price'] - $price) > 0 ? $data['unformatted_shop_price'] - $price : 0;
        $data['activity_type']	= $activity_type;
        $data['saving_price']	= $saving_price;
        $data['formatted_saving_price'] = '已省'.$saving_price.'元';
        if ($price < $data['unformatted_shop_price'] && isset($price)) {
        	$data['promote_price'] = $price;
        	$data['formated_promote_price'] = price_format($price);
        	$data['promote_start_date'] = RC_Time::local_date('Y/m/d H:i:s O', $goods['promote_start_date']);
        	$data['promote_end_date']	= RC_Time::local_date('Y/m/d H:i:s O', $goods['promote_end_date']);
        }


        $data['rec_type'] = empty($rec_type) ? $activity_type : 'GROUPBUY_GOODS';
        $data['object_id'] = $object_id;

        if (ecjia_config::has('mobile_touch_url')) {
        	$data['goods_url'] = ecjia::config('mobile_touch_url').'?goods&c=index&a=show&id='.$goods_id.'&hidenav=1&hidetab=1';
        } else {
        	$data['goods_url'] = null;
        }


        $data['favourable_list'] = $favourable_list;

        $location = $this->requestData('location', array());
        $options = array(
       		'cat_id'	=> $data['cat_id'],
        	'intro'		=> 'hot',
       		'page'		=> 1,
       		'size'		=> 8,
        	'store_id'	=> $goods['store_id'],
       		'location'	=> $location,
       	);

        //商品详情页猜你喜欢  api2.4功能
    	$result = RC_Api::api('goods', 'goods_list', $options);

        $data['related_goods'] = array();
		if (!empty($result['list'])) {
			foreach ($result['list'] as $val) {
				/* 判断是否有促销价格*/
				$price = ($val['unformatted_shop_price'] > $val['unformatted_promote_price'] && $val['unformatted_promote_price'] > 0) ? $val['unformatted_promote_price'] : $val['unformatted_shop_price'];
				$activity_type = ($val['unformatted_shop_price'] > $val['unformatted_promote_price'] && $val['unformatted_promote_price'] > 0) ? 'PROMOTE_GOODS' : 'GENERAL_GOODS';
				 /* 计算节约价格*/
				$saving_price = ($val['unformatted_shop_price'] > $val['unformatted_promote_price'] && $val['unformatted_promote_price'] > 0) ? $val['unformatted_shop_price'] - $val['unformatted_promote_price'] : (($val['unformatted_market_price'] > 0 && $val['unformatted_market_price'] > $val['unformatted_shop_price']) ? $val['unformatted_market_price'] - $val['unformatted_shop_price'] : 0);

				
				/*增加商品的规格和属性缓存*/
				$cache_goods_properties_key = 'goods_properties_'.$val['goods_id'];
				$cache_goods_properties_id = sprintf('%X', crc32($cache_goods_properties_key));
				$goods_type_db = RC_Model::model('goods/orm_goods_type_model');
				$properties = $goods_type_db->get_cache_item($cache_goods_properties_id);
				if (empty($properties)) {
				    $properties = get_goods_properties($val['goods_id']); // 获得商品的规格和属性
				    $goods_type_db->set_cache_item($cache_goods_properties_id);
				}
				
				$data['related_goods'][] = array(
					'goods_id'		=> $val['goods_id'],
					'name'			=> $val['name'],
					'market_price'	=> $val['market_price'],
					'shop_price'	=> $val['shop_price'],
					'promote_price'	=> $val['promote_price'],
					'img' => array(
						'thumb'	=> $val['goods_img'],
						'url'	=> $val['original_img'],
						'small'	=> $val['goods_thumb'],
					),
				    'specification'     => array_values($properties['spe']),
					'activity_type' 	=> $activity_type,
					'object_id'			=> 0,
					'saving_price'		=>	$saving_price,
					'formatted_saving_price' => $saving_price > 0 ? '已省'.$saving_price.'元' : '',
				);
			}
		}

        //多店铺的内容
        $data['seller_id'] = $goods['store_id'];
        if ($goods['store_id'] > 0) {
        	$seller_where = array();
        	$seller_where['ssi.status'] = 1; // 店铺开启状态
        	$seller_where['ssi.store_id'] = $goods['store_id'];
            $db_view = RC_Model::model('goods/store_franchisee_viewmodel');
            $field = 'sf.*, sc.cat_name';
            $info = $db_view->field($field)->where(array('sf.status' => 1, 'sf.store_id' => $goods['store_id']))->find();
            $store_config = array(
                'shop_kf_mobile'            => '', // 客服手机号码
//                 'shop_kf_email'             => '', // 客服邮件地址
//                 'shop_kf_qq'                => '', // 客服QQ号码
//                 'shop_kf_ww'                => '', // 客服淘宝旺旺
//                 'shop_kf_type'              => '', // 客服样式
                'shop_logo'                 => '', // 默认店铺页头部LOGO
                'shop_banner_pic'           => '', // banner图
                'shop_trade_time'           => '', // 营业时间
                'shop_description'          => '', // 店铺描述
                'shop_notice'               => '', // 店铺公告
            );
            $config = RC_DB::table('merchants_config')->where('store_id', $goods['store_id'])->select('code','value')->get();
            foreach ($config as $key => $value) {
                $store_config[$value['code']] = $value['value'];
            }
            $info = array_merge($info, $store_config);

        	if(substr($info['shop_logo'], 0, 1) == '.') {
        		$info['shop_logo'] = str_replace('../', '/', $info['shop_logo']);
        	}
        	$db_goods = RC_Model::model('goods/goods_model');
        	$goods_count = $db_goods->where(array('store_id' => $data['seller_id'], 'is_on_sale' => 1, 'is_alone_sale' => 1, 'is_delete' => 0))->count();

        	$cs_db = RC_Model::model('store/collect_store_model');
        	$follower_count = $cs_db->where(array('store_id' => $data['seller_id']))->count();



        	$data['merchant_info'] = array(
        		'seller_id'			=> $info['store_id'],
        		'seller_name'		=> $info['merchants_name'],
        		'shop_logo'		    => !empty($info['shop_logo']) ? RC_Upload::upload_url().'/'.$info['shop_logo'] : '',
        		'goods_count'		=> $goods_count,
        	   	'manage_mode'       => $info['manage_mode'],
 				'follower'			=> $follower_count,
        		'comment' 			=> array(
        			'comment_goods' 	=> '100%',
        			'comment_server'	=> '100%',
        			'comment_delivery'	=> '100%',
// 					'comment_goods'		=> $comment['count'] > 0 && $comment['comment_rank'] > 0 ? round($comment['comment_rank']/$comment['count']*100).'%' : '100%',
//         			'comment_server'	=> $comment['count'] > 0 && $comment['comment_server'] > 0  ? round($comment['comment_server']/$comment['count']*100).'%' : '100%',
//         			'comment_delivery'	=> $comment['count'] > 0 && $comment['comment_delivery'] > 0  ? round($comment['comment_delivery']/$comment['count']*100).'%' : '100%',
        		)
        	);
        }
        // $data['is_warehouse'] = null;
        $data['seller_name'] = $info['merchants_name'];
        $shop_name = empty($info['store_name']) ? ecjia::config('shop_name') : $info['store_name'];
        $data['server_desc'] = '由'.$shop_name.'发货并提供售后服务';

        /* 分享链接*/
        $data['share_link'] = '';
        if (ecjia_config::has('mobile_share_link')) {
        	ecjia_api::$controller->assign('goods_id', $goods['goods_id']);
        	if ($_SESSION['user_id'] > 0) {
        		$user_invite_code = RC_Api::api('affiliate', 'user_invite_code');
        		ecjia_api::$controller->assign('invite_code', $user_invite_code);
        	}
        	$share_link = ecjia_api::$controller->fetch_string(ecjia::config('mobile_share_link'));
        	$data['share_link']	= $share_link;
        }

        return $data;
    }
}

function EM_get_goods_gallery($goods_id) {
    $db_goods_gallery = RC_Model::model('goods/goods_gallery_model');
    $row = $db_goods_gallery->field('img_id, img_url, thumb_url, img_desc, img_original')->where(array('goods_id' => $goods_id))->limit(ecjia::config('goods_gallery_number'))->select();
    /* 格式化相册图片路径 */
    RC_Loader::load_app_class('goods_imageutils', 'goods', false);
    $img_list_sort = $img_list_id = array();
    foreach ($row as $key => $gallery_img) {
    	$desc_index = intval(strrpos($gallery_img['img_original'], '?')) + 1;
    	!empty($desc_index) && $row[$key]['desc'] = substr($gallery_img['img_original'], $desc_index);
    	$row[$key]['img_url'] = empty($gallery_img ['img_original']) ? RC_Uri::admin_url('statics/images/nopic.png') : goods_imageutils::getAbsoluteUrl($gallery_img ['img_original']);
    	$row[$key]['thumb_url'] = empty($gallery_img ['img_url']) ? RC_Uri::admin_url('statics/images/nopic.png') : goods_imageutils::getAbsoluteUrl($gallery_img ['img_url']);
    	$img_list_sort[$key] = $row[$key]['desc'];
    	$img_list_id[$key] = $gallery_img['img_id'];
    }
    //先使用sort排序，再使用id排序。
    array_multisort($img_list_sort, $img_list_id, $row);
    return $row;
}

/**
 * 获得指定商品的各会员等级对应的价格
 *
 * @access public
 * @param integer $goods_id
 * @return array
 */
function get_user_rank_prices($goods_id, $shop_price) {
    $dbview = RC_Model::model('user/user_rank_member_price_viewmodel');
    $dbview->view =array(
    	'member_price' 	=> array(
    		'type' 		=> Component_Model_View::TYPE_LEFT_JOIN,
    		'alias' 	=> 'mp',
    		'on' 		=> "mp.goods_id = '$goods_id' and mp.user_rank = r.rank_id "
    	),
    );

    $res = $dbview->join(array('member_price'))->field("rank_id, IFNULL(mp.user_price, r.discount * $shop_price / 100) AS price, r.rank_name, r.discount")->where("r.show_price = 1 OR r.rank_id = '$_SESSION[user_rank]'")->select();

    $arr = array();
    foreach ($res as $row) {
        $arr[$row['rank_id']] = array(
            'rank_name' => htmlspecialchars($row['rank_name']),
            'price' => price_format($row['price']),
        	'unformatted_price' => number_format( $row['price'], 2, '.', '')
        );
    }
    return $arr;
}

/**
 * 取得跟商品关联的礼包列表
 *
 * @param string $goods_id
 *            商品编号
 *
 * @return 礼包列表
 */
function get_package_goods_list($goods_id) {
    $dbview = RC_Model::model('goods/goods_activity_package_goods_viewmodel');
    $db_view = RC_Model::model('goods/goods_attr_attribute_viewmodel');
    $now = RC_Time::gmtime();
    $where = array(
		'ga.start_time' => array('elt' => $now) ,
		'ga.end_time' => array('egt' => $now) ,
    	'pg.goods_id' => $goods_id
    );
    $res = $dbview
    	->join('package_goods')
    	->where($where)
    	->group('ga.act_id')
    	->order(array('ga.act_id' => 'asc'))
    	->select();

    foreach ($res as $tempkey => $value) {
        $subtotal = 0;
        $row = unserialize($value['ext_info']);
        unset($value['ext_info']);
        if ($row) {
            foreach ($row as $key => $val) {
                $res[$tempkey][$key] = $val;
            }
        }

        $goods_res = $dbview
        	->join(array('goods','products','member_price'))
			->where(array('pg.package_id' => $value['act_id']))
			->order(array('pg.package_id' => 'asc', 'pg.goods_id' => 'asc'))
			->select();

        foreach ($goods_res as $key => $val) {
            $goods_id_array[] = $val['goods_id'];
            $goods_res[$key]['goods_thumb'] = get_image_path($val['goods_id'], $val['goods_thumb'], true);
            $goods_res[$key]['market_price'] = price_format($val['market_price']);
            $goods_res[$key]['rank_price'] = price_format($val['rank_price']);
            $subtotal += $val['rank_price'] * $val['goods_number'];
        }

        /* 取商品属性 */
        $result_goods_attr = $db_view->where(array('a.attr_type' => 1))->in(array('goods_id' => $goods_id_array))->select();

        $_goods_attr = array();
        foreach ($result_goods_attr as $value) {
            $_goods_attr[$value['goods_attr_id']] = $value['attr_value'];
        }

        /* 处理货品 */
        $format = '[%s]';
        foreach ($goods_res as $key => $val) {
            if ($val['goods_attr'] != '') {
                $goods_attr_array = explode('|', $val['goods_attr']);
                $goods_attr = array();
                foreach ($goods_attr_array as $_attr) {
                    $goods_attr[] = $_goods_attr[$_attr];
                }
                $goods_res[$key]['goods_attr_str'] = sprintf($format, implode(',', $goods_attr));
            }
        }
        $res[$tempkey]['goods_list'] = $goods_res;
        $res[$tempkey]['subtotal'] = price_format($subtotal);
        $res[$tempkey]['saving'] = price_format(($subtotal - $res[$tempkey]['package_price']));
        $res[$tempkey]['package_price'] = price_format($res[$tempkey]['package_price']);
    }

    return $res;
}

// end