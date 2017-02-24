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
 * 满减满赠活动添加编辑处理
 * @author will
 */
class manage_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    		
		$this->authadminSession();
		if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
			return new ecjia_error(100, 'Invalid session');
		}
		
		$priv = $this->admin_priv('goods_manage');
		if (is_ecjia_error($priv)) {
			return $priv;
		}
		
		RC_Loader::load_app_class('favourable', 'favourable', false);
		
		$act_id       = $this->requestData('act_id', 0);
		$user_rank    = $this->requestData('user_rank');
		$gift         = $this->requestData('gift', array());
		
		$favourable = array(
			'act_name'      => $this->requestData('act_name'),
			'start_time'    => RC_Time::local_strtotime($this->requestData('start_time')),
			'end_time'      => RC_Time::local_strtotime($this->requestData('end_time')),
			'user_rank'     => $user_rank,
			'act_range'     => $this->requestData('act_range', 0),
			'act_range_ext' => $this->requestData('act_range_ext'),
			'min_amount'    => $this->requestData('min_amount'),
			'max_amount'    => $this->requestData('max_amount'),
			'act_type'      => $this->requestData('act_type'),
			'act_type_ext'  => $this->requestData('act_type_ext'),
			'gift'          => serialize($gift),
		);
		/* 检查优惠活动时间 */
		if ($favourable['start_time'] >= $favourable['end_time']) {
			return new ecjia_error('time_error', __('优惠开始时间不能大于或等于结束时间'));
		}
		
		/* 检查享受优惠的会员等级 */
		if (!isset($favourable['user_rank'])) {
			return new ecjia_error('user_rank_error', __('请设置享受优惠的会员等级'));
		}
	
		if (!in_array($favourable['act_range'], array(0, 1, 2, 3))) {
		    return new ecjia_error('act_range_error', __('请设置活动类型'));
		}
		/* 检查优惠范围扩展信息 */
		if ($favourable['act_range'] > 0 && !isset($favourable['act_range_ext'])) {
			return new ecjia_error('act_range_error', __('请设置优惠范围'));
		}
		/* 检查金额上下限 */
		$min_amount = floatval($favourable['min_amount']) >= 0 ? floatval($favourable['min_amount']) : 0;
		$max_amount = floatval($favourable['max_amount']) >= 0 ? floatval($favourable['max_amount']) : 0;
		if ($max_amount > 0 && $min_amount > $max_amount) {
			return new ecjia_error('amount_error', __('金额下限不能大于金额上限'));
		}
		
		if ($act_id > 0) {
			$favourable['act_id'] = $act_id;
		}
		if (isset($_SESSION['store_id']) && $_SESSION['store_id'] > 0) {
			$favourable['store_id'] = $_SESSION['store_id'];
		}
		
		if ($favourable['act_type'] == 0) {
			$act_type = '享受赠品（特惠品）';
		} elseif ($favourable['act_type'] == 1) {
			$act_type = '享受现金减免';
		} else {
			$act_type = '享受价格折扣';
		}
		RC_Model::model('favourable/favourable_activity_model')->favourable_manage($favourable);
		if ($act_id > 0 ) {
			$log_action = 'edit';
		} else {
			$log_action = 'add';
		}
		$log_text = $favourable['act_name'].'，'.'优惠活动方式是 '.$act_type;
		
		if ($_SESSION['store_id'] > 0) {
// 		    ecjia_merchant::admin_log($log_text, $log_text, 'favourable');
		    RC_Api::api('merchant', 'admin_log', array('text'=>$log_text, 'action'=>$log_text, 'object'=>'favourable'));
		} else {
		    ecjia_admin::admin_log($log_text, $log_action, 'favourable');
		}
		
		/* 释放缓存*/
		$favourable_activity_db   = RC_Model::model('favourable/orm_favourable_activity_model');
		$cache_favourable_key     = 'favourable_list_store_'.$favourable['store_id'];
		$cache_id                 = sprintf('%X', crc32($cache_favourable_key));
		
		$favourable_activity_db->delete_cache_item($cache_id);
		return array();
	}
}

// end