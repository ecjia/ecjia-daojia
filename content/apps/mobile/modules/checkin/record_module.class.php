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
 * 签到记录
 * @author will.chen
 */
class record_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	$this->authSession();
    	
		$filite_user        = $this->requestData('filite_user', 'current'); 
		$checkin_award_open = intval(ecjia::config('checkin_award_open'));
		$checkin_data       = array(
				'checkin_award_open'	    => $checkin_award_open,
				'lable_checkin_extra_award'	=> null,
				'checkin_award'			    => 0,
				'checkin_day'			    => 0,
				'checkin_extra_day'		    => 0,
				'checkin_extra_award'	    => 0,
				'checkin_record'		    => array(),
		);
		if ($checkin_award_open) {
			$checkin_data['checkin_award']       = intval(ecjia::config('checkin_award'));
			$checkin_extra_award_config          = ecjia::config('checkin_extra_award');
			$checkin_extra_award                 = unserialize($checkin_extra_award_config);
			$checkin_data['checkin_extra_day']   = $checkin_extra_award['day'];
			$checkin_data['checkin_extra_award'] = $checkin_extra_award['extra_award'];
		}
		
		if ($filite_user == 'current') {
			$this->authSession();
			
			$db = RC_Model::model('mobile/mobile_checkin_model');
			
			$month = RC_Time::local_getdate();
			// 创建本月开始时间
			$month_start = RC_Time::local_mktime(0, 0, 0, $month['mon'], 1, $month['year']);
			// 创建本月结束时间
			$month_end 	= RC_Time::local_mktime(23, 59, 59, $month['mon'], date('t'), $month['year']);
			
			$checkin_result = $db
                			->where(array('user_id' => $_SESSION['user_id'], 'checkin_time >= "'.$month_start.'" and checkin_time <= "'.$month_end.'"'))
                			->select();
			
			$checkin_list = array();
			if (!empty($checkin_result)) {
				$db_user     = RC_Model::model('user/users_model');
				$user_info   = $db_user->field(array('user_name'))->find(array('user_id' => $_SESSION['user_id']));
				$uid         = sprintf("%09d", $_SESSION['user_id']);//格式化uid字串， d 表示把uid格式为9位数的整数，位数不够的填0
				$dir1        = substr($uid, 0, 3);//把uid分段
				$dir2        = substr($uid, 3, 2);
				$dir3        = substr($uid, 5, 2);
				
				$filename    = md5($user_info['user_name']);
				$avatar_path = RC_Upload::upload_path().'/data/avatar/'.$dir1.'/'.$dir2.'/'.$dir3.'/'.substr($uid, -2)."_".$filename.'.jpg';
				$disk = RC_Filesystem::disk();
				if(!$disk->exists($avatar_path)) {
					$avatar_img = '';
				} else {
					$avatar_img = RC_Upload::upload_url().'/data/avatar/'.$dir1.'/'.$dir2.'/'.$dir3.'/'.substr($uid, -2)."_".$filename.'.jpg';
				}
				$continue_checkin_day = $last_day = 0;
				foreach ($checkin_result as $val) {
					/* 获取签到日期天*/
					$day = RC_Time::local_date('d', $val['checkin_time']);
					if ($val['integral'] == $checkin_data['checkin_award']) {
						if (intval($day) == ($last_day + 1)) {
							$continue_checkin_day++;
						}
					} else {
						$continue_checkin_day = 0;
					}
					$last_day = $day;
					$checkin_data['checkin_record'][] = array(
							'user_name'		    => $user_info['user_name'],
							'avatar_img'	    => $avatar_img,
							'integral'		    => intval($val['integral']),
							'label_integral'	=> $val['integral'].ecjia::config('integral_name'),
							'time'			    => RC_Time::local_time($val['checkin_time']),
							'formatted_time'    => RC_Time::local_date(ecjia::config('time_format'), $val['checkin_time']),
					);
				}
				if ($checkin_award_open && $checkin_data['checkin_extra_day'] > 0 && $checkin_data['checkin_extra_award'] > 0 && $continue_checkin_day > 0) {
					$now_day = RC_Time::local_date('d', RC_Time::gmtime());
					if ($last_day == $now_day) {
						$day                                       = $checkin_data['checkin_extra_day'] - $continue_checkin_day;
						$checkin_data['checkin_day']               = $continue_checkin_day;
						$checkin_data['lable_checkin_extra_award'] = '连续签到'.$continue_checkin_day.'天，再签到'.$day.'天可额外获得'.$checkin_data['checkin_extra_award'].'积分奖励';
					}
				}
			}
			
			
			
			$pager = array(
					"total" => 0,
					"count" => 0,
					"more"	=> 0
			);
		} else {
			$db_view = RC_Model::model('mobile/mobile_checkin_viewmodel');
			/* 获取数量 */
			$size    = $this->requestData('pagination.count', 15);
			$page    = $this->requestData('pagination.page', 1);
			
			$checkin_count = $db_view->join(null)->count();
			//实例化分页
			$page_row = new ecjia_page($checkin_count, $size, 6, '', $page);
			
			$checkin_result = $db_view
                    			->field(array('mc.*', 'user_name'))
                    			->join(array('users'))
                    			->order(array('checkin_time' => 'DESC'))
                    			->limit($page_row->limit())
                    			->select();
			
			$checkin_list = array();
			if (!empty($checkin_result)) {
				foreach ($checkin_result as $val) {
					$uid  = sprintf("%09d", $val['user_id']);//格式化uid字串， d 表示把uid格式为9位数的整数，位数不够的填0
					$dir1 = substr($uid, 0, 3);//把uid分段
					$dir2 = substr($uid, 3, 2);
					$dir3 = substr($uid, 5, 2);
					
					$filename    = md5($val['user_name']);
					$avatar_path = RC_Upload::upload_path().'/data/avatar/'.$dir1.'/'.$dir2.'/'.$dir3.'/'.substr($uid, -2)."_".$filename.'.jpg';
					
					$disk = RC_Filesystem::disk();
					if(!$disk->exists($avatar_path)) {
						$avatar_img = '';
					} else {
						$avatar_img = RC_Upload::upload_url().'/data/avatar/'.$dir1.'/'.$dir2.'/'.$dir3.'/'.substr($uid, -2)."_".$filename.'.jpg';
					}
					$checkin_data['checkin_record'][] = array(
							'user_name'		=> $val['user_name'],
							'avatar_img'	=> $avatar_img,
							'integral'		=> intval($val['integral']),
							'label_points'	=> $val['integral'].ecjia::config('integral_name'),
							'time'			=> RC_Time::local_time($val['checkin_time']),
							'formatted_time' => RC_Time::local_date(ecjia::config('time_format'), $val['checkin_time']),
					);
				}
			}
			
			$pager = array(
					"total" => $page_row->total_records,
					"count" => $page_row->total_records,
					"more"	=> $page_row->total_pages <= $page ? 0 : 1,
			);
		}
		
		return array('data' => $checkin_data, 'pager' => $pager);
	}
}

// end