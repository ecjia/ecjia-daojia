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
 * @author luchongchong
 */
class updateprice_module extends api_admin implements api_interface {
	public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

    	$this->authadminSession();
        
        if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
			return new ecjia_error(100, 'Invalid session');
		}
		//请求参数：
       	$goods_id				= $this->requestData('goods_id', 0);
    	if (empty($goods_id)) {
    		return new ecjia_error('invalid_parameter', '参数错误');
    	}
    	//市场价格
    	$shop_price				= $this->requestData('shop_price', 0);
    	$market_price			= $this->requestData('market_price', 0);

    	//积分
    	$give_integral			= $this->requestData('give_integral', 0);
    	$rank_integral			= $this->requestData('rank_integral', 0);
    	$integral				= $this->requestData('integral', 0);

    	//促销信息
//     	$promote_price			= $this->requestData('promote_price');
//     	$is_promote 			= empty($promote_price) ? 0 : 1;
//     	$promote_price      	= !empty($promote_price) ?  $promote_price : 0;
//     	$promote_start_date		= $this->requestData('promote_start_date');

//     	$promote_end_date  		= $this->requestData('promote_end_date');
//     	if (($promote_start_date == $promote_end_date) && !empty($promote_start_date) && !empty($promote_end_date)) {
//     		$promote_start_date .= ' 00:00:00';
//     		$promote_end_date 	.= ' 23:59:59';
//     	}
//     	$promote_start_date     = ($is_promote && !empty($promote_start_date)) ? RC_Time::local_strtotime($promote_start_date) : '';
//     	$promote_end_date      	= ($is_promote && !empty($promote_end_date)) ? RC_Time::local_strtotime($promote_end_date) : '';

	 	//优惠价格、等级价格
    	$volume_number_list 	= $this->requestData('volume_number');
    	$user_rank_list			= $this->requestData('user_rank');

    	$db_goods = RC_Model::model('goods/goods_model');

    	RC_Loader::load_app_func('global', 'goods');

    	$volume_number = array();
    	$volume_price  = array();
    	foreach ($volume_number_list as $key => $value) {
    		$volume_number[] = $value['number'];
    		$volume_price[] = $value['price'];
    	}

		$user_rank  = array();
		$userprice  = array();
		foreach ($user_rank_list as $key=>$value){
			$user_rank[] = $value['rank_id'];
			$userprice[] = $value['price'];
		}
    	/* 处理会员价格 */
		if (!empty($user_rank) && !empty($userprice)) {
			handle_member_price($goods_id, $user_rank, $userprice);
		}

		if (!empty($volume_number) && !empty($volume_price)) {
			handle_volume_price($goods_id, $volume_number, $volume_price);
		}

    	$data = array(
    		'shop_price'			=> $shop_price,
    		'market_price'			=> $market_price,
//     		'promote_price'			=> $promote_price,
//     		'promote_start_date' 	=> $promote_start_date,
//     		'promote_end_date'		=> $promote_end_date,
    		'give_integral'			=> $give_integral,
    		'rank_integral'			=> $rank_integral,
    		'integral'				=> $integral,
//     		'is_promote'			=> $is_promote,
    		'last_update'			=> RC_Time::gmtime()
    	);
    	$count = $db_goods->where(array('goods_id' => $goods_id))->update($data);
    	if ($count>0) {
    		$orm_goods_db = RC_Model::model('goods/orm_goods_model');
    		/* 释放app缓存*/
    		$goods_cache_array = $orm_goods_db->get_cache_item('goods_list_cache_key_array');
    		if (!empty($goods_cache_array)) {
    			foreach ($goods_cache_array as $val) {
    				$orm_goods_db->delete_cache_item($val);
    			}
    			$orm_goods_db->delete_cache_item('goods_list_cache_key_array');
    		}
    		/*释放商品基本信息缓存*/
    		$cache_goods_basic_info_key = 'goods_basic_info_'.$goods_id;
    		$cache_basic_info_id = sprintf('%X', crc32($cache_goods_basic_info_key));
    		$orm_goods_db->delete_cache_item($cache_basic_info_id);
    		
    		$goods_name = $db_goods->where(array('goods_id' => $goods_id))->get_field('goods_name');
    		if ($_SESSION['store_id'] > 0) {
//     		    ecjia_merchant::admin_log($goods_name.'【来源掌柜】', 'edit', 'goods');
    		    RC_Api::api('merchant', 'admin_log', array('text'=>$goods_name.'【来源掌柜】', 'action'=>'edit', 'object'=>'goods'));
    		} else {
    		    ecjia_admin::admin_log($goods_name.'【来源掌柜】', 'edit', 'goods');
    		}
    		
    		return array();
    	}
    }
}

//end
