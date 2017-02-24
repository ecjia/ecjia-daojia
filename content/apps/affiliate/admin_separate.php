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
 * 分成管理
 * @author wutifang
 */
class admin_separate extends ecjia_admin {
	private $db_order_info;
	private $db_affiliate_log;
	private $db_order_infoview;
	
	public function __construct() {
		parent::__construct();
		
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		$this->db_order_info 		= RC_Loader::load_app_model('affiliate_order_info_model');
		$this->db_affiliate_log 	= RC_Loader::load_app_model('affiliate_log_model');
		$this->db_order_infoview 	= RC_Loader::load_app_model('affiliate_order_info_viewmodel');
		
		/* 加载所有全局 js/css */
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('bootstrap-editable-script', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable-css', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		RC_Script::enqueue_script('affiliate', RC_App::apps_url('statics/js/affiliate.js', __FILE__));
		
		$js_lang = array(
			'ok'		=> RC_Lang::get('affiliate::affiliate.ok'),
			'cancel'	=> RC_Lang::get('affiliate::affiliate.cancel'),
		);
		RC_Script::localize_script('affiliate', 'js_lang', $js_lang);
	}
	
	/**
	 * 分成管理列表页
	 */
	public function init() {
		$this->admin_priv('affiliate_ck_manage');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('affiliate::affiliate.sharing_management')));
		$this->assign('ur_here', RC_Lang::get('affiliate::affiliate.sharing_management'));
		
		$affiliate = unserialize(ecjia::config('affiliate'));
		empty($affiliate) && $affiliate = array();
		$separate_on = $affiliate['on'];
		$this->assign('on', $separate_on);
		
		$logdb = $this->get_affiliate_ck();
		$this->assign('logdb', $logdb);
		
		$this->assign('order_stats', RC_Lang::get('affiliate::affiliate_ck.order_stats'));
		$this->assign('sch_stats', RC_Lang::get('affiliate::affiliate_ck.sch_stats'));
		$this->assign('separate_by', RC_Lang::get('affiliate::affiliate_ck.separate_by'));
		$this->assign('search_action', RC_Uri::url('affiliate/admin_separate/init'));
		
		$this->display('affiliate_ck_list.dwt');
	}
	
	/**
	 * 分成
	 */
	public function admin_separate() {
		$this->admin_priv('affiliate_ck_update', ecjia::MSGTYPE_JSON);
	
		$affiliate = unserialize(ecjia::config('affiliate'));
		empty($affiliate) && $affiliate = array();
		$separate_by = $affiliate['config']['separate_by'];
		$oid = (int)$_GET['id'];
		$row = $this->db_order_infoview->order_info_find(array('o.order_id' => $oid), 'o.order_sn, o.is_separate, (o.goods_amount - o.discount) AS goods_amount, o.user_id');
		$order_sn = $row['order_sn'];
		
		if (empty($row['is_separate'])) {
			$affiliate['config']['level_point_all'] = (float)$affiliate['config']['level_point_all'];
			$affiliate['config']['level_money_all'] = (float)$affiliate['config']['level_money_all'];
			if ($affiliate['config']['level_point_all']) {
				$affiliate['config']['level_point_all'] /= 100;
			}
			if ($affiliate['config']['level_money_all']) {
				$affiliate['config']['level_money_all'] /= 100;
			}
			$money = round($affiliate['config']['level_money_all'] * $row['goods_amount'],2);
			$integral = RC_Api::api('orders', 'order_integral', array('order_id' => $oid, 'extension_code' => ''));
			
			$point = round($affiliate['config']['level_point_all'] * intval($integral['rank_points']), 0);
			if (empty($separate_by)) {
				//推荐注册分成
				$num = count($affiliate['item']);
				for ($i = 0; $i < $num; $i++) {
					$affiliate['item'][$i]['level_point'] = (float)$affiliate['item'][$i]['level_point'];
					$affiliate['item'][$i]['level_money'] = (float)$affiliate['item'][$i]['level_money'];
					if ($affiliate['item'][$i]['level_point']) {
						$affiliate['item'][$i]['level_point'] /= 100;
					}
					if ($affiliate['item'][$i]['level_money']) {
						$affiliate['item'][$i]['level_money'] /= 100;
					}
					$setmoney = round($money * $affiliate['item'][$i]['level_money'], 2);
					$setpoint = round($point * $affiliate['item'][$i]['level_point'], 0);
					
					$user_info = RC_Api::api('user', 'user_info', array('user_id' => $row['user_id']));
					$row = RC_Api::api('user', 'user_info', array('user_id' => $user_info['parent_id']));

					$up_uid = $row['user_id'];
					if (empty($up_uid) || empty($row['user_name'])) {
						break;
					} else {
						$info = sprintf(RC_Lang::get('affiliate::affiliate_ck.separate_info'), $order_sn, $setmoney, $setpoint);
						$arr = array(
							'user_id'		=> $up_uid,
							'user_money'	=> $setmoney,
							'frozen_money'	=> 0,
							'rank_points'	=> $setpoint,
							'pay_points'	=> 0,
							'change_desc'	=> $info
						);
						RC_Api::api('user', 'account_change_log', $arr);
						$this->db_affiliate_log->write_affiliate_log($oid, $up_uid, $row['user_name'], $setmoney, $setpoint, $separate_by);
					}
				}
			} else {
				//推荐订单分成
				$row = $this->db_order_infoview->join(array('users', 'affiliate_log'))->field('o.parent_id, u.user_name')->find(array('o.order_id' => $oid));
				$up_uid = $row['parent_id'];
				if (!empty($up_uid) && $up_uid > 0) {
					$info = sprintf(RC_Lang::get('affiliate::affiliate_ck.separate_info'), $order_sn, $money, $point);
					
					$arr = array(
						'user_id'		=> $up_uid,
						'user_money'	=> $money,
						'frozen_money'	=> 0,
						'rank_points'	=> $point,
						'pay_points'	=> 0,
						'change_desc'	=> $info
					);
					RC_Api::api('user', 'account_change_log', $arr);
					
					$this->db_affiliate_log->write_affiliate_log($oid, $up_uid, $row['user_name'], $money, $point, $separate_by);
				} else {
					return $this->showmessage(RC_Lang::get('affiliate::affiliate_ck.edit_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
				}
			}
			$data = array(
				'is_separate' => '1'
			);
			ecjia_admin::admin_log(RC_Lang::get('affiliate::affiliate_ck.order_sn_is').$order_sn, 'do', 'affiliate');
			$this->db_order_info->order_info_update(array('order_id' => $oid), $data);
		}
		return $this->showmessage(RC_Lang::get('affiliate::affiliate_ck.edit_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 取消分成，不再能对该订单进行分成
	 */
	public function cancel() {
		$this->admin_priv('affiliate_ck_update', ecjia::MSGTYPE_JSON);
		
		$oid = (int)$_GET['id'];
		$info = $this->db_order_info->order_info_find(array('order_id' => $oid));
		
		if (empty($info['is_separate'])) {
			$data = array(
				'is_separate' => '2'
			);
			ecjia_admin::admin_log(RC_Lang::get('affiliate::affiliate_ck.order_sn_is').$info['order_sn'], 'cancel', 'affiliate');
			$this->db_order_info->order_info_update(array('order_id' => $oid), $data);
		}
		return $this->showmessage(RC_Lang::get('affiliate::affiliate_ck.cancel_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 撤销某次分成，将已分成的收回来
	 */
	public function rollback() {
		$this->admin_priv('affiliate_ck_update', ecjia::MSGTYPE_JSON);
		
		$logid = (int)$_GET['id'];
		$stat = $this->db_affiliate_log->affiliate_log_find(array('log_id' => $logid));
		if (!empty($stat)) {
			if ($stat['separate_type'] == 1) {
				//推荐订单分成
				$flag = -2;
			} else {
				//推荐注册分成
				$flag = -1;
			}
			$arr = array(
				'user_id'		=> $stat['user_id'],
				'user_money'	=> -$stat['money'],
				'frozen_money'	=> 0,
				'rank_points'	=> -$stat['point'],
				'pay_points'	=> 0,
				'change_desc'	=> RC_Lang::get('affiliate::affiliate_ck.loginfo.cancel')
			);
			RC_Api::api('user', 'account_change_log', $arr);
			$data = array(
				'separate_type' => $flag
			);
			$order_info = RC_Api::api('orders', 'order_info', array('order_id' => $stat['order_id'], 'order_sn' => ''));
			ecjia_admin::admin_log(RC_Lang::get('affiliate::affiliate_ck.order_sn_is').$order_info['order_sn'], 'rollback', 'affiliate');
			
			$this->db_affiliate_log->affiliate_log_update(array('log_id' => $logid), $data);
		}
		return $this->showmessage(RC_Lang::get('affiliate::affiliate_ck.rollback_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 获取分成列表
	 *
	 * @return array
	 */
	private function get_affiliate_ck() {
		$db_order_infoview = RC_Loader::load_app_model('affiliate_order_info_viewmodel');
		$affiliate = unserialize(ecjia::config('affiliate'));
	
		empty($affiliate) && $affiliate = array();
		$separate_by = $affiliate['config']['separate_by'];
	
		$sqladd = '';
		if (isset($_GET['status'])) {
			$sqladd = ' AND o.is_separate = ' . (int)$_GET['status'];
			$filter['status'] = (int)$_GET['status'];
		}
	
		if (isset($_GET['order_sn'])) {
			$sqladd = ' AND o.order_sn LIKE \'%' . trim($_GET['order_sn']) . '%\'';
			$filter['order_sn'] = $_GET['order_sn'];
		}
	
		if (isset($_GET['auid'])) {
			$sqladd = ' AND a.user_id=' . $_GET['auid'];
		}
		
		$options['table'] = array('users', 'affiliate_log');
		if (!empty($affiliate['on'])) {
			if (empty($separate_by)) {
				$options['where'] = "o.user_id > 0 AND (u.parent_id > 0 AND o.is_separate = 0 OR o.is_separate > 0) $sqladd";
				$count = $db_order_infoview->order_info_count($options);
			} else {
				$options['where'] = "o.user_id > 0 AND (o.parent_id > 0 AND o.is_separate = 0 OR o.is_separate > 0) $sqladd";
				$count = $db_order_infoview->order_info_count($options);
			}
		} else {
			$options['where'] = "o.user_id > 0 AND o.is_separate > 0 $sqladd";
			$count = $db_order_infoview->order_info_count($options);
		}
		$page = new ecjia_page($count, 15, 5);
		$limit = $page->limit();
		$logdb = array();
	
		if (!empty($affiliate['on'])) {
			//开启
			if (empty($separate_by)) {
				//推荐注册分成
				$option = array(
					'table' => array('users', 'affiliate_log'),
					'field' => 'o.*, a.log_id, a.user_id as suid, a.user_name as auser, a.money, a.point, a.separate_type, u.parent_id as up',
					'where'	=> "o.user_id > 0 AND (u.parent_id > 0 AND o.is_separate = 0 OR o.is_separate > 0) $sqladd ",
					'order'	=> 'order_id desc',
					'limit'	=> $limit,
				);
			} else {
				//推荐订单分成
				$option = array(
					'table' => array('users', 'affiliate_log'),
					'field' => 'o.*, a.log_id, a.user_id as suid, a.user_name as auser, a.money, a.point, a.separate_type, u.parent_id as up',
					'where'	=> "o.user_id > 0 AND (o.parent_id > 0 AND o.is_separate = 0 OR o.is_separate > 0) $sqladd ",
					'order'	=> 'order_id desc',
					'limit'	=> $limit,
				);
			}
		} else {
			//关闭
			$option = array(
				'table' => array('users', 'affiliate_log'),
				'field' => 'o.*, a.log_id, a.user_id as suid, a.user_name as auser, a.money, a.point, a.separate_type, u.parent_id as up',
				'where'	=> "o.user_id > 0 AND o.is_separate > 0 $sqladd ",
				'order'	=> 'order_id desc',
				'limit'	=> $limit,
			);
		}
		$data = $db_order_infoview->order_info_select($option);

		if (!empty($data)) {
			foreach ($data as $rt) {
				if (empty($separate_by) && $rt['up'] > 0) {
					//按推荐注册分成
					$rt['separate_able'] = 1;
				} elseif (!empty($separate_by) && $rt['parent_id'] > 0) {
					//按推荐订单分成
					$rt['separate_able'] = 1;
				}
				if (!empty($rt['suid'])) {
					//在affiliate_log有记录
					$rt['info'] = sprintf(RC_Lang::get('affiliate::affiliate_ck.separate_info2'), $rt['suid'], $rt['auser'], $rt['money'], $rt['point']);
					if ($rt['separate_type'] == -1 || $rt['separate_type'] == -2) {
						//已被撤销
						$rt['is_separate'] = 3;
						$rt['info'] = "<s>" . $rt['info'] . "</s>";
					}
				}
				$logdb[] = $rt;
			}
		}
		return array('item' => $logdb, 'page' => $page->show(5), 'desc' => $page->page_desc(), 'current_page' => $page->current_page);
	}
}

//end