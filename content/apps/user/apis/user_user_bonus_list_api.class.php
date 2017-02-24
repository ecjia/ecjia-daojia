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
 * 获取会员红包列表
 * @author will.chen
 */
class user_user_bonus_list_api extends Component_Event_Api {
    
    public function call(&$options) {
    	
    	$db = RC_Model::model('user/user_bonus_type_viewmodel');
    	
    	$cur_date = RC_Time::gmtime();
    	
    	$where = array();
    	$where['ub.user_id'] = $_SESSION['user_id'];
    	if ($options['bonus_type'] == 'allow_use') {
    		$where['bt.use_end_date']	= array('gt' => $cur_date);
    		$where['ub.order_id'] = 0;
    	} elseif ($options['bonus_type'] == 'expired') {
    		$where['bt.use_end_date'] = array('lt' => $cur_date);
    	} elseif ($options['bonus_type'] == 'is_used') {
    		$where['ub.order_id'] = array('gt' => 0);
    	}
    	
    	
    	$count = $db->join(array('bonus_type', 'store_franchisee'))->where($where)->count();
    	$page_row = new ecjia_page($count, $options['size'], 6, '', $options['page']);
    	
    	$rows = $db->join(array('bonus_type', 'store_franchisee'))
                	->field('ub.bonus_id, ub.order_id, bt.type_name, bt.type_money, bt.min_goods_amount, bt.use_start_date, bt.use_end_date, s.store_id, s.manage_mode, s.merchants_name')
                	->where($where)
                	->limit($page_row->limit())
                	->select();
    
    	$bonus_list = array();
    	
    	if (!empty($rows)) {
    		foreach ($rows as $key => $row) {
    			$bonus_list[$key] = array(
    					'seller_id'		               => $row['store_id'],
    					'seller_name'	               => $row['merchants_name'],
    					'manage_mode'	               => $row['manage_mode'],
    					'bonus_id'		               => $row['bonus_id'],
    					'bonus_name'	               => $row['type_name'],
    					'bonus_amount'	               => $row['type_money'],
    					'formatted_bonus_amount'       => price_format($row['type_money']),
    					'request_amount'	           => $row['min_goods_amount'],
    					'formatted_request_amount'	   => price_format($row['min_goods_amount']),
    					'start_date'	               => $row['use_start_date'],
    					'end_date'		               => $row['use_end_date'],
    					'formatted_start_date'	       => RC_Time::local_date(ecjia::config('date_format'), $row['use_start_date']),
    					'formatted_end_date'	       => RC_Time::local_date(ecjia::config('date_format'), $row['use_end_date']),
    			);
    			
    			/* 先判断是否被使用，然后判断是否开始或过期 */
    			if (empty($row['order_id'])) {
    				/* 没有被使用 */
    				if ($row['use_start_date'] > $cur_date) {
    					$bonus_list[$key]['status']       = 'unstarted';
    					$bonus_list[$key]['label_status'] = '未开始';
    					
    				} else if ($row['use_end_date'] < $cur_date) {
    					$bonus_list[$key]['status']       = 'expired';
    					$bonus_list[$key]['label_status'] = '已过期';
    				} else {
    					$bonus_list[$key]['status']       = 'allow_use';
    					$bonus_list[$key]['label_status'] = '可使用';
    				}
    			} else {
    				$bonus_list[$key]['status']       = 'is_used';
    				$bonus_list[$key]['label_status'] = '已使用';
    			}
    		}
    	}
    	
    	return array('bonus_list'=> $bonus_list, 'filter' => $options, 'page' => $page_row);
    }
}

// end