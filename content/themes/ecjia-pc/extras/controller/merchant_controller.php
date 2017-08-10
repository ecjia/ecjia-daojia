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
 * 店铺控制器
 */
class merchant_controller {
	/**
	 * 商家商品列表
	 */
	public static function init() {
		$general_info = pc_function::get_general_info();
		ecjia_front::$controller->assign('info', $general_info);
		
		$cache_id = sprintf('%X', crc32($_SERVER['QUERY_STRING'].'-'.$_COOKIE['city_id'].'-'.$_COOKIE['city_name']));
		
		if (!ecjia_front::$controller->is_cached('merchant_goods.dwt', $cache_id)) {
			$store_id = !empty($_GET['store_id'])	? intval($_GET['store_id']) : 0;
			$shop_info = merchant_function::get_merchant_info($store_id);

			if (!empty($shop_info)) {
				//店铺二维码
				$default_image = RC_Theme::get_template_directory_uri() . '/images/mobile_app_icon.png';
				$default_shop_logo = RC_Theme::get_template_directory_uri() . '/images/default_store.png';

				$disk = RC_Filesystem::disk();
				if (!empty($shop_info['shop_logo']) && $disk->exists(RC_Upload::upload_path($shop_info['shop_logo']))) {
					$store_logo = RC_Upload::upload_path($shop_info['shop_logo']);
					$shop_info['shop_logo'] = RC_Upload::upload_url($shop_info['shop_logo']);
				} else {
					$store_logo = $default_image;
					$shop_info['shop_logo'] = $default_shop_logo;
				}
				$shop_info['store_qrcode'] = with(new Ecjia\App\Mobile\Qrcode\GenerateMerchant($store_id,  $store_logo))->getQrcodeUrl();
			}
			
			ecjia_front::$controller->assign('shop_info', $shop_info);
			
			if (!empty($shop_info)) {
				$cat_id = !empty($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;
				ecjia_front::$controller->assign('cat_id', $cat_id);
				
				$category 	= !empty($_GET['cat_id']) 	? intval($_GET['cat_id']) 	: 0;
				$page	  	= !empty($_GET['page'])		? intval($_GET['page']) 	: 1;
				$order_by 	= array('g.sort_order' => 'asc', 'goods_id' => 'desc');
				
				$select_id = !empty($_GET['select_id']) ? intval($_GET['select_id']) : 0;
				if (!empty($select_id)) {
					$category = $select_id;
				}
				
				if (!empty($store_id)) {
					$goods_options = array(
						'merchant_cat_id'	=> $category,
						'store_id'			=> $store_id,
						'sort'				=> $order_by,
						'page'				=> $page,
						'size'				=> 12,
						'city_id'			=> $_COOKIE['city_id']
					);
					$goods_result = RC_Api::api('goods', 'goods_list', $goods_options);
					$pages = $goods_result['page']->show(2);
					
					if ($goods_result['list']) {
						foreach ($goods_result['list'] as $val) {
							/* 判断是否有促销价格*/
							$price = ($val['unformatted_shop_price'] > $val['unformatted_promote_price'] && $val['unformatted_promote_price'] > 0) ? $val['unformatted_promote_price'] : $val['unformatted_shop_price'];
							$data[] = array(
								'id' 			=> $val['goods_id'],
								'name' 			=> $val['name'],
								'shop_price' 	=> $price,
								'goods_img' 	=> $val['goods_img'],
							);
						}
					}
					
					ecjia_front::$controller->assign('goods_list', $data);
					ecjia_front::$controller->assign('page', $pages);
					ecjia_front::$controller->assign('goods_info_url', RC_Uri::url('goods/index/show'));
					
					$cat_list = RC_DB::table('merchants_category as m')
						->leftJoin('store_franchisee as s', RC_DB::raw('m.store_id'), '=', RC_DB::raw('s.store_id'))
						->where(RC_DB::raw('s.city'), $_COOKIE['city_id'])
						->where(RC_DB::raw('s.status'), 1)
						->selectRaw('m.cat_id, m.cat_name, m.parent_id')
						->where(RC_DB::raw('m.parent_id'), 0)
						->where(RC_DB::raw('m.store_id'), $store_id)
						->where(RC_DB::raw('m.is_show'), 1)
						->orderBy(RC_DB::raw('m.sort_order'), 'asc')
						->get();
					
					$cat_arr = array();
					if (!empty($cat_list)) {
						foreach($cat_list as $key => $val){
							$cat_arr[] = array(
								'cat_id'	=> $val['cat_id'],
								'cat_name'	=> $val['cat_name'],
								'children' => pc_function::get_child_tree($val['cat_id']),
							);
						}
					}
					ecjia_front::$controller->assign('select_id', $select_id);
					ecjia_front::$controller->assign('store_id', $store_id);
					ecjia_front::$controller->assign('cat_arr', $cat_arr);
					ecjia_front::$controller->assign('cat_url', RC_Uri::url('merchant/goods/init', array('store_id' => $store_id)));
					ecjia_front::$controller->assign_title($shop_info['merchants_name']);
					
					ecjia_front::$controller->assign('pc_keywords', $shop_info['shop_keyword']);
					ecjia_front::$controller->assign('pc_description', $shop_info['shop_description']);
				}
			}
		}
		ecjia_front::$controller->display('merchant_goods.dwt', $cache_id);
	}
	
    /*
     * 店铺评论
     */
	public static function comment() {
		$general_info = pc_function::get_general_info();
		ecjia_front::$controller->assign('info', $general_info);
		
	    $cache_id = sprintf('%X', crc32($_SERVER['QUERY_STRING'].'-'.$_COOKIE['city_id'].'-'.$_COOKIE['city_name']));
	    
	    $disk = RC_Filesystem::disk();
	    if (!ecjia_front::$controller->is_cached('merchant_comment.dwt', $cache_id)) {
            $store_id = !empty($_GET['store_id']) ? intval($_GET['store_id']) : 0;
            $shop_info = merchant_function::get_merchant_info($store_id);
            
			if (!empty($shop_info)) {
				//店铺二维码
				$default_image = RC_Theme::get_template_directory_uri() . '/images/mobile_app_icon.png';
				$default_shop_logo = RC_Theme::get_template_directory_uri() . '/images/default_store.png';
				
				if (!empty($shop_info['shop_logo']) && $disk->exists(RC_Upload::upload_path($shop_info['shop_logo']))) {
					$store_logo = RC_Upload::upload_path($shop_info['shop_logo']);
					$shop_info['shop_logo'] = RC_Upload::upload_url($shop_info['shop_logo']);
				} else {
					$store_logo = $default_image;
					$shop_info['shop_logo'] = $default_shop_logo;
				}
				$shop_info['store_qrcode'] = with(new Ecjia\App\Mobile\Qrcode\GenerateMerchant($store_id,  $store_logo))->getQrcodeUrl();
			}
			
            ecjia_front::$controller->assign('shop_info', $shop_info);
            
            if (!empty($shop_info)) {
	            $select = RC_DB::table('comment as c')->where(RC_DB::raw('c.status'), '<>', 3)->where('store_id', $store_id)->where('comment_type', 0)->where('status', 1);
	
	            $level_amount = $select->select(RC_DB::raw('count(*) as level_all'),
	            	RC_DB::raw('SUM(IF(comment_rank > 3, 1, 0)) as level_good'),
	             	RC_DB::raw('SUM(IF(comment_rank > 1 and comment_rank < 4, 1, 0)) as level_general'),
	                RC_DB::raw('SUM(IF(comment_rank = 1, 1, 0)) as level_low'),
	             	RC_DB::raw('SUM(IF(has_image = 1, 1, 0)) as level_print'))
	    			->first();
	
	            $level = !empty($_GET['level'])	? $_GET['level'] : 'all';
	
	            if ($level == 'all') {
	                $db_comment = $select;
	            } elseif ($level == 'good') {
	                $db_comment = $select->where(RC_DB::raw('c.comment_rank'), '>', 3);
	            } elseif ($level == 'general') {
	                $db_comment = $select->where(RC_DB::raw('c.comment_rank'), '>', 1)->where(RC_DB::raw('c.comment_rank'), '<', 4);
	            } elseif ($level == 'low') {
	                $db_comment = $select->where(RC_DB::raw('c.comment_rank'), '=', 1);
	            } elseif ($level == 'print') {
	                $db_comment = $select->where(RC_DB::raw('c.has_image'), '=', 1);
	            }
	            $count = $db_comment->count();
	
	            $page = new ecjia_page($count, 10, 5);
	            $data = $db_comment
	           		->leftJoin('users as u', RC_DB::raw('c.user_id'), '=', RC_DB::raw('u.user_id'))
	            	->selectRaw('c.*, u.avatar_img')
	            	->orderby(RC_DB::raw('c.add_time'), 'desc')
	            	->take(10)
	            	->skip($page->start_id-1)
	            	->get();
	            
	            $list = array();
	            if (!empty($data)) {
	                foreach ($data as $row) {
	                    $row['add_time']    = RC_Time::local_date(ecjia::config('time_format'), $row['add_time']);
	                    $row['content']  	= str_replace('\r\n', '<br />', htmlspecialchars($row['content']));
	                    $row['content']  	= nl2br(str_replace('\n', '<br />', $row['content']));
	                    $row['goods_attr']	= str_replace('\n', '&nbsp;&nbsp;', $row['goods_attr']);
	                    $row['goods_attr']	= str_replace('\r\n', '&nbsp;&nbsp;', $row['goods_attr']);
	                    $row['goods_attr']	= preg_replace("/\s/", "&nbsp;&nbsp;", $row['goods_attr']);
	                    $row['picture']     = array();
	                    	
	                    if ($row['has_image'] == 1) {
	                        $picture_list = RC_DB::table('term_attachment')
		                        ->where('object_group', 'comment')
		                        ->where('object_id', $row['comment_id'])
		                        ->where('object_app', 'ecjia.comment')
		                        ->lists('file_path');
	                        
	                        if (!empty($picture_list)) {
	                            foreach ($picture_list as $k => $v) {
	                                if (!empty($v) && $disk->exists(RC_Upload::upload_path($v))) {
	                                    $row['picture'][] = RC_Upload::upload_url($v);
	                                }
	                            }
	                        }
	                    }
	                    $reply = RC_DB::table('comment_reply')->where('comment_id', $row['comment_id'])->whereIn('user_type', array('admin', 'merchant'))->first();
	                    $row['reply_content']  = nl2br(str_replace('\n', '<br />', htmlspecialchars($reply['content'])));
	                    $row['reply_add_time'] = RC_Time::local_date(ecjia::config('time_format'), $reply['add_time']);
	                    if ($row['avatar_img']) {
	                        $row['avatar_img'] = RC_Upload::upload_url($row['avatar_img']);
	                    }
	                    if ($row['comment_rank'] > 3) {
	                        $row['level'] = '好评';
	                    } elseif ($row['comment_rank'] > 1 && $row['comment_rank'] < 4) {
	                        $row['level'] = '中评';
	                    } elseif ($row['comment_rank'] == 1) {
	                        $row['level'] = '差评';
	                    }
	                    $list[] = $row;
	                }
	            }
	            
	            $comment_list = array(
	                'item'      => $list, 
	                'page'      => $page->show(2), 
	                'desc'      => $page->page_desc(),
	                'level'     => $level,
	            	'count'		=> $count,
	            );
	            $comment_list['all']        = !empty($level_amount['level_all']) ? $level_amount['level_all'] : 0;
	            $comment_list['good']       = !empty($level_amount['level_good']) ? $level_amount['level_good'] : 0;
	            $comment_list['general']    = !empty($level_amount['level_general']) ? $level_amount['level_general'] :0;
	            $comment_list['low']        = !empty($level_amount['level_low']) ? $level_amount['level_low'] : 0;
	            $comment_list['print']      = !empty($level_amount['level_print']) ? $level_amount['level_print'] : 0;
	            ecjia_front::$controller->assign('data', $comment_list);
	            ecjia_front::$controller->assign('detail_url', RC_Uri::url('merchant/index/detail', array('store_id' => $store_id)));
	            ecjia_front::$controller->assign('goods_url', RC_Uri::url('merchant/goods/init', array('store_id' => $store_id)));
	            ecjia_front::$controller->assign('comment_url', RC_Uri::url('merchant/index/comment', array('store_id' => $store_id)));
	            ecjia_front::$controller->assign_title($shop_info['merchants_name']);
	            
	            ecjia_front::$controller->assign('pc_keywords', $shop_info['shop_keyword']);
	            ecjia_front::$controller->assign('pc_description', $shop_info['shop_description']);
            }
	    }
        ecjia_front::$controller->display('merchant_comment.dwt', $cache_id);
    }
    
    public static function detail() {
    	$general_info = pc_function::get_general_info();
    	ecjia_front::$controller->assign('info', $general_info);
    	
        $cache_id = sprintf('%X', crc32($_SERVER['QUERY_STRING'].'-'.$_COOKIE['city_id'].'-'.$_COOKIE['city_name']));
        	
        if (!ecjia_front::$controller->is_cached('merchant_detail.dwt', $cache_id)) {
            $store_id = !empty($_GET['store_id']) ? intval($_GET['store_id']) : 0;
            $shop_info = merchant_function::get_merchant_info($store_id);
            
            $disk = RC_Filesystem::disk();
        	if (!empty($shop_info)) {
				//店铺二维码
				$default_image = RC_Theme::get_template_directory_uri() . '/images/mobile_app_icon.png';
				$default_shop_logo = RC_Theme::get_template_directory_uri() . '/images/default_store.png';
				if (!empty($shop_info['shop_logo']) && $disk->exists(RC_Upload::upload_path($shop_info['shop_logo']))) {
					$store_logo = RC_Upload::upload_path($shop_info['shop_logo']);
					$shop_info['shop_logo'] = RC_Upload::upload_url($shop_info['shop_logo']);
				} else {
					$store_logo = $default_image;
					$shop_info['shop_logo'] = $default_shop_logo;
				}
				$shop_info['store_qrcode'] = with(new Ecjia\App\Mobile\Qrcode\GenerateMerchant($store_id,  $store_logo))->getQrcodeUrl();
			}
            
            ecjia_front::$controller->assign('shop_info', $shop_info);
            if (!empty($shop_info)) {
            	ecjia_front::$controller->assign('comment_url', RC_Uri::url('merchant/index/comment', array('store_id' => $store_id)));
            	ecjia_front::$controller->assign('goods_url', RC_Uri::url('merchant/goods/init', array('store_id' => $store_id)));
            }
            ecjia_front::$controller->assign_title($shop_info['merchants_name']);
            ecjia_front::$controller->assign('pc_keywords', $shop_info['shop_keyword']);
            ecjia_front::$controller->assign('pc_description', $shop_info['shop_description']);
        }
        ecjia_front::$controller->display('merchant_detail.dwt', $cache_id);
    }
    
    public static function category() {
    	$general_info = pc_function::get_general_info();
    	ecjia_front::$controller->assign('info', $general_info);
    	
        $cache_id = sprintf('%X', crc32($_SERVER['QUERY_STRING'].'-'.$_COOKIE['city_id'].'-'.$_COOKIE['city_name']));
        
        if (!ecjia_front::$controller->is_cached('category_list.dwt', $cache_id)) {
        	$store = RC_DB::table('store_franchisee')->where('city', $_COOKIE['city_id'])->where('shop_close', 0)->where('status', 1)->get();
            $has_store = !empty($store) ? true : false;
            ecjia_front::$controller->assign('has_store', $has_store);
        	
            $cat_id = !empty($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;
            $category_list = self::category_list();
            $store_list = self::store_lists($cat_id);
            
            $store_list['cat_name'] = '全部分类';
            if (!empty($cat_id)) {
            	$store_list['now_cat'] = array_get($category_list, $cat_id);
            	if (!empty($store_list['now_cat'])) {
            		$store_list['cat_name'] = $store_list['now_cat']['cat_name'];
            		$store_list['cat_img'] = $store_list['now_cat']['cat_image'];
            	}
            }
            ecjia_front::$controller->assign('store_list', $store_list);
            ecjia_front::$controller->assign('category_list', $category_list);
            ecjia_front::$controller->assign('active', 'category');
            ecjia_front::$controller->assign('cat_id', $cat_id);
            
            //商家列表轮播图
            $data = RC_Api::api('adsense', 'cycleimage', array(
            	'code' 		=> 'merchant_cycleimage',
            	'client' 	=> Ecjia\App\Adsense\Client::PC,
            	'city' 		=> $general_info['city_id']
            ));
            ecjia_front::$controller->assign('cycleimage', $data);
            $count = count($data);
            ecjia_front::$controller->assign('count', $count);
            ecjia_front::$controller->assign_title('商家列表');
            
            $cat_info = RC_DB::table('store_category')->where('cat_id', $cat_id)->first();
            if (!empty($cat_info)) {
            	ecjia_front::$controller->assign('pc_keywords', $cat_info['keywords']);
            	ecjia_front::$controller->assign('pc_description', $shop_info['cat_desc']);
            }
        }
        ecjia_front::$controller->display('category_list.dwt', $cache_id);
    }
    
    /*
     * 获取cat_id，生成分类
     */
    private static function category_list() {
        $data = RC_DB::table('store_category')
        	->select('cat_id', 'cat_name', 'cat_image')
			->orderBy('parent_id', 'asc')
			->orderBy('sort_order', 'asc')
			->where('is_show', 1)
			->where('parent_id', 0)
        	->get();
        $category_list = array();
        if (!empty($data)) {
            foreach ($data as $key => $val) {
            	$category_list[$val['cat_id']] = array(
            		'cat_name'	=> $val['cat_name'],
            		'cat_image' => !empty($val['cat_image']) ? RC_Upload::upload_url($val['cat_image']) : '',
            	);
            }
        }
        return $category_list;
    }
    
    /*
     * 获取商品分类中的商家
     */
    private static function store_lists($cat_id = 0) {
        $keywords = !empty($_GET['keywords']) ? trim($_GET['keywords']) : '';
        $db_store_franchisee = RC_DB::table('store_franchisee as sf')->where(RC_DB::raw('sf.status'), 1);
        if (!empty($cat_id)) {
        	$db_store_franchisee->whereRaw('sf.cat_id='.$cat_id);
        }
        $db_store = $db_store_franchisee->leftJoin('store_category as sc', RC_DB::raw('sf.cat_id'), '=', RC_DB::raw('sc.cat_id'));
       
        if (!empty($keywords)) {
            $where .= "merchants_name LIKE '%" . mysql_like_quote($keywords) . "%'";
            $db_store->whereRaw($where);
        }
        
        $count = $db_store
        	->where(RC_DB::raw('sf.city'), $_COOKIE['city_id'])
        	->where(RC_DB::raw('sf.status'), 1)
        	->where(RC_DB::raw('sf.shop_close'), 0)
        	->count();
        $page = new ecjia_page($count, 9, 5);
        
        $data = $db_store
	        ->selectRaw('sf.store_id, sf.merchants_name, sf.manage_mode, sf.contact_mobile, sf.responsible_person, sf.confirm_time, sf.company_name, sf.sort_order, sc.cat_name, sf.status')
	        ->where(RC_DB::raw('sf.city'), $_COOKIE['city_id'])
	        ->orderby('store_id', 'asc')
	        ->where(RC_DB::raw('sf.status'), 1)
	        ->where(RC_DB::raw('sf.shop_close'), 0)
	        ->take(9)
	        ->skip($page->start_id-1)
	        ->get();

        $store_list = array();
        if (!empty($data)) {
            foreach ($data as $key => $val) {
                $store_id = $val['store_id'];
                $store_list[$key] = merchant_function::get_merchant_info($store_id);
                if (!empty($store_list[$key])) {
                	$store_list[$key]['store_id'] = $store_id;
                }
            }
            if (!empty($store_list)) {
            	foreach ($store_list as $key => $val) {
            		$store_id = $val['store_id'];
            		$store_logo = $val['shop_logo'];
            		$config = RC_DB::table('merchants_config')->where('store_id', $store_id)->select('code', 'value')->get();
            		foreach ($config as $keys => $vals) {
            			if ($vals['code'] == 'shop_notice') {
            				if (!empty($vals['value'])) {
            					$store_list[$key]['shop_notice'] = $vals['value'];
            				}
            			}
            			if ($vals['code'] == 'shop_trade_time') {
            				if (!empty($vals['value'])) {
            					$shop_time = unserialize($vals['value']);
            					
            					//处理营业时间格式例：7:00--次日5:30
            					$start = $shop_time['start'];
            					$end = explode(':', $shop_time['end']);
            					if ($end[0] > 24) {
            						$end[0] = '次日'. ($end[0] - 24);
            					}
            					$store_list[$key]['shop_trade_time'] = $start . '--' . $end[0] . ':' . $end[1];
            				}
            			}
            		}
            	}
            }
        }
        $data = array(
            'item'      => $store_list,
            'page'      => $page->show(2),
            'desc'      => $page->page_desc()
        );
        return $data;
    }
}

// end