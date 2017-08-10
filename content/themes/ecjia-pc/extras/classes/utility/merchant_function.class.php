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
class merchant_function {
    /*
     * 店铺信息
     */
    public static function get_merchant_info($store_id) {
        //店铺基本信息
        $shop_info = RC_DB::table('store_franchisee as sf')
        	->leftJoin('merchants_config as mc', RC_DB::raw('sf.store_id'), '=', RC_DB::raw('mc.store_id'))
        	->where(RC_DB::raw('mc.code'), 'shop_notice')
        	->where(RC_DB::raw('sf.store_id'), $store_id)
        	->where(RC_DB::raw('sf.status'), 1)
        	->selectRaw('sf.manage_mode, sf.address, sf.merchants_name, sf.store_id, sf.shop_close, mc.value, sf.province, sf.city, sf.shop_keyword')
        	->where(RC_DB::raw('sf.city'), $_COOKIE['city_id'])
        	->first();
        if (empty($shop_info)) {
        	return array();
        }
        $db_region          = RC_Model::model('shipping/region_model');
        $info               = RC_DB::table('store_franchisee')->where('store_id', $store_id)->select('province', 'city', 'address')->first();
        $province_name      = $db_region->where(array('region_id' => $info['province']))->get_field('region_name');
        $city_name          = $db_region->where(array('region_id' => $info['city']))->get_field('region_name');
        $shop_address		= $province_name.' '.$city_name.' '.$info['address'];
        $outward_info = RC_DB::table('merchants_config')->where('store_id', $store_id)->where(function ($query) {
            	$query->where('code', 'shop_trade_time')
            		->orwhere('code', 'shop_kf_mobile')
            		->orwhere('code', 'shop_banner_pic')
            		->orwhere('code', 'shop_logo')
            		->orwhere('code', 'shop_description');
        	})->get();

        //优惠活动
        $time = RC_Time::gmtime();
        $db_favourable = RC_DB::table('favourable_activity')
        	->select('act_name', 'act_id', 'act_type', 'act_type_ext', 'gift', 'start_time', 'end_time')
        	->where('store_id', $store_id)
        	->where('start_time', '<=', $time)
        	->where('end_time', '>=', $time)
        	->get();
   
        $list = array();
        if (!empty($db_favourable)) {
            foreach ($db_favourable as $row) {
                $row['gift'] = unserialize($row['gift']);
                if ($row['act_type'] == 1) {
                    $row['act_mode'] = '现金减免';
                } elseif ($row['act_type'] == 2) {
                    $row['act_mode'] = '价格折扣';
                    $row['discount'] = round($row['act_type_ext'] / 10, 2);
                }
                $list[] = $row;
            }
        }
        //好评率
        $store_rank = RC_DB::table('goods_data')->select('store_id', RC_DB::raw('AVG(goods_rank) as "goods_rank"'))->where('store_id', $store_id)->first();
        if (empty($store_rank['goods_rank'])) {
            $store_rank['goods_rank'] = 10000;
        }
        $store_rank['comment_percent'] = round($store_rank['goods_rank'] / 100);
        $store_rank['comment_rank'] = $store_rank['goods_rank'] / 100 / 20;
        //接单数、接单率
        $amount_info['list_amount'] = RC_DB::table('order_info')->where('store_id', $store_id)->count();
        $amount_info['order_amount'] = RC_DB::table('order_info')->where('store_id', $store_id)->where('order_status', 5)->where('shipping_status', 2)->where('pay_status', 2)->count();
        $amount_info['order_precent'] = round($amount_info['order_amount'] / $amount_info['list_amount'] * 100, 2);

        foreach ($outward_info as $key => $val) {
            if ($val['code'] == 'shop_trade_time') {
                //判断营业时间
                $outward['trade_time'] = $val['value'];
                $shop_hours = unserialize($outward['trade_time']);
                $now_time = RC_Time::gmtime();
                if (!empty($shop_hours)) {
                    $start_time = RC_Time::local_strtotime($shop_hours['start']);
                    $end_time = RC_Time::local_strtotime($shop_hours['end']);
                    //0为不营业，1为营业
                    if ($start_time < $now_time && $now_time < $end_time) {
                        $business_status = 1;
                    } else {
                        $business_status = 0;
                    }
                    //处理营业时间格式例：7:00--次日5:30
                    $start = $shop_hours['start'];
                    $end = explode(':', $shop_hours['end']);
                    if ($end[0] > 24) {
                    	$end[0] = '次日'. ($end[0] - 24);
                    }
                    $shop_hours = $start . '--' . $end[0] . ':' . $end[1];
                } else {
                	$shop_hours = '暂未设置';
                }
            }
            if ($val['code'] == 'shop_kf_mobile') {
                $outward['kf_mobile'] = $val['value'];
            }
            if ($val['code'] == 'shop_logo') {
                $outward['shop_logo'] = !empty($val['value']) ? $val['value'] : '';
            }
            if ($val['code'] == 'shop_banner_pic') {
                $outward['shop_banner_pic'] = !empty($val['value']) ? RC_Upload::upload_url($val['value']) : '';
            }
            if ($val['code'] == 'shop_description') {
            	$outward['shop_description'] = $val['value'];
            }
        }

       	$data = array(
        	'merchants_name' 	=> $shop_info['merchants_name'], 
        	'manage_mode'	 	=> $shop_info['manage_mode'], 
        	'shop_close' 		=> $shop_info['shop_close'], 
        	'value' 			=> !empty($shop_info['value']) ? $shop_info['value'] : '暂无公告', 
        	'address' 			=> $shop_address, 
        	'comment_rank' 		=> $store_rank['comment_rank'], 
        	'comment_percent' 	=> $store_rank['comment_percent'], 
        	'shop_logo' 		=> $outward['shop_logo'], 
        	'trade_time' 		=> $shop_hours, 
        	'kf_mobile' 		=> !empty($outward['kf_mobile']) ? $outward['kf_mobile'] : '暂未填写', 
        	'banner_pic' 		=> $outward['shop_banner_pic'], 'order_amount' => $amount_info['order_amount'],
        	'order_precent' 	=> $amount_info['order_precent'], 
        	'activity' 			=> $list, 
       	    'business_status'   => $business_status,
       		'shop_keyword'		=> $shop_info['shop_keyword'],
       		'shop_description'  => $outward['shop_description'],
        );
        return $data;
    }
}
//end