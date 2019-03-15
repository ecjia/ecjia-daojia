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
 * 掌柜指派订单获取在线配送员列表
 * @author zrl
 */
class admin_shopkeeper_express_staff_online_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	$this->authadminSession();
    	if ($_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }
		//权限判断，查看配送员列表的权限
        $result = $this->admin_priv('mh_express_manage');
        if (is_ecjia_error($result)) {
        	return $result;
        }
        $express_id = $this->requestData('express_id', 0);
		$size     	= $this->requestData('pagination.count', 15);
		$page     	= $this->requestData('pagination.page', 1);
		$keywords = $this->requestData('keywords');
		
		if (empty($express_id)) {
			return new ecjia_error('invalid_parameter', __('参数无效', 'express'));
		}
		
		$db = RC_DB::table('staff_user')->leftJoin('express_user', 'staff_user.user_id', '=', 'express_user.user_id');
		
		$db->where('staff_user.store_id', $_SESSION['store_id']);
		$db->where('staff_user.group_id', '=', Ecjia\App\Staff\StaffGroupConstant::GROUP_EXPRESS);
		$db->where('staff_user.parent_id', '>', 0);
		$db->where('staff_user.online_status', '=', 1);
		
		if (!empty($keywords)) {
			$db ->whereRaw('(staff_user.mobile  like  "%'.mysql_like_quote($keywords).'%" or staff_user.name like "%'.mysql_like_quote($keywords).'%")');
		}
		
		$count = $db->select('staff_user.user_id')->count();
		
		//实例化分页
		$page_row = new ecjia_page($count, $size, 6, '', $page);
		
		$list = $db->take($size)->skip($page_row->start_id - 1)->select('staff_user.*', 'express_user.longitude', 'express_user.latitude')->orderBy('staff_user.add_time', 'desc')->get();
		
		$express_user_list = array();
		$distance = 0;
		$location		= RC_DB::table('express_order')->where('express_id', $express_id)->select('longitude', 'latitude')->first();
		if (!empty($list)) {
			foreach ($list as $row) {
				$wait_count 	= RC_DB::table('express_order')->where('staff_id', $row['user_id'])->where('status', 1)->count();
				$sending_count	= RC_DB::table('express_order')->where('staff_id', $row['user_id'])->where('status', 2)->count(); 
				if (!empty($location['longitude']) && !empty($location['latitude']) && !empty($row['latitude']) && !empty($row['longitude'])) {
					//腾讯地图api距离计算
					$keys = ecjia::config('map_qq_key');
					$url = "https://apis.map.qq.com/ws/distance/v1/?mode=driving&from=".$row['latitude'].",".$row['longitude']."&to=".$location['latitude'].",".$location['longitude']."&key=".$keys;
					$distance_json = file_get_contents($url);
					$distance_info = json_decode($distance_json, true);
					$row['distance'] = isset($distance_info['result']['elements'][0]['distance']) ? $distance_info['result']['elements'][0]['distance'] : 0;
				}
				$express_user_list[] = array(
						'staff_id' 					=> $row['user_id'],
						'staff_name' 				=> $row['name'],
						'avatar' 					=> empty($row['avatar']) ? '' : RC_Upload::upload_url($row['avatar']),
						'mobile'					=> $row['mobile'],
						'wait_count'				=> $wait_count,
						'sending_count'				=> $sending_count,
						'distance'					=> !empty($row['distance']) ? $row['distance'] : $distance
				);
			}
		}
		$pager = array(
			'total' => $page_row->total_records,
			'count' => $page_row->total_records,
			'more'	=> $page_row->total_pages <= $page ? 0 : 1,
		);
		return array('data' => $express_user_list, 'pager' => $pager);
	 }	
}

// end