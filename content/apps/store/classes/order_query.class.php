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
 * ECJIA 订单查询条件类文件
 */
RC_Loader::load_app_class('order','store', false);

class order_query extends order {
	
	private $where = array();//where条件数组
	public function __construct() {
		parent::__construct();
	}
	
	/* 已完成订单 */
	public function order_finished($alias = '') {
    	$this->where[$alias.'order_status'] = array(OS_CONFIRMED, OS_SPLITED);
		$this->where[$alias.'shipping_status'] = array(SS_SHIPPED, SS_RECEIVED);
		$this->where[$alias.'pay_status'] = array(PS_PAYED, PS_PAYING);
		return $this->where;
	}
	
	/* 待付款订单 */
	public function order_await_pay($alias = '') {
		$payment_method = RC_Loader::load_app_class('payment_method','payment');
		$payment_id_row = $payment_method->payment_id_list(false);
		$payment_id     = "";
		foreach ($payment_id_row as $v) {
			$payment_id .= empty($payment_id) ? $v : ','.$v ;
		}
		$payment_id = empty($payment_id) ? "''" : $payment_id;
    	$this->where[$alias.'order_status'] = array(OS_CONFIRMED,OS_SPLITED);
        $this->where[$alias.'pay_status']   = PS_UNPAYED;
        $this->where[]= "( {$alias}shipping_status in (". SS_SHIPPED .",". SS_RECEIVED .") OR {$alias}pay_id in (" . $payment_id . ") )";
        return $this->where;
	}
	
	/* 待发货订单 */
	public function order_await_ship($alias = '') {
		$payment_method = RC_Loader::load_app_class('payment_method','payment');
		$payment_id_row = $payment_method->payment_id_list(true);
		$payment_id     = "";
		foreach ($payment_id_row as $v) {
			$payment_id .= empty($payment_id) ? $v : ','.$v ;
		}
		$payment_id = empty($payment_id) ? "''" : $payment_id;
    	$this->where[$alias.'order_status']    = array(OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART);
		$this->where[$alias.'shipping_status'] = array(SS_UNSHIPPED, SS_PREPARING, SS_SHIPPED_ING);
		$this->where[] = "( {$alias}pay_status in (" . PS_PAYED .",". PS_PAYING.") OR {$alias}pay_id in (" . $payment_id . "))";
		return $this->where;
	}
	
	/* 未确认订单 */
	public function order_unconfirmed($alias = '') {
		$this->where[$alias.'order_status'] = OS_UNCONFIRMED;
		return $this->where;
	}
	
	/* 未处理订单：用户可操作 */
	public function order_unprocessed($alias = '') {
    	$this->where[$alias.'order_status'] =  array(OS_UNCONFIRMED, OS_CONFIRMED);
        $this->where[$alias.'shipping_status'] = SS_UNSHIPPED;
        $this->where[$alias.'pay_status'] = PS_UNPAYED;
		return $this->where;
	}
	
	/* 未付款未发货订单：管理员可操作 */
	public function order_unpay_unship($alias = '') {
    	$this->where[$alias.'order_status'] = array(OS_UNCONFIRMED, OS_CONFIRMED);
        $this->where[$alias.'shipping_status'] = array(SS_UNSHIPPED, SS_PREPARING);
        $this->where[$alias.'pay_status'] = PS_UNPAYED;
        return $this->where;
	}
	
	/* 已发货订单：不论是否付款 */
	public function order_shipped($alias = '') {
        $this->where[$alias.'order_status'] = OS_CONFIRMED;
        $this->where[$alias.'shipping_status'] = array(SS_SHIPPED, SS_RECEIVED);
        return $this->where;
	}
	/* 退货*/
	public function order_refund($alias = '') {
		$this->where[$alias.'order_status'] = OS_RETURNED;
		return $this->where;
	}
	
	/* 无效*/
	public function order_invalid($alias = '') {
		$this->where[$alias.'order_status'] = OS_INVALID;
		return $this->where;
	}
	
	
	public function order_where($filter) {
		if ($filter['keywords']) {
			$this->where[] = "o.order_sn like '%".mysql_like_quote($filter['keywords'])."%' or o.consignee like '%".mysql_like_quote($filter['keywords'])."%'";
		} else {
			if ($filter['order_sn']) {
	        	$this->where['o.order_sn'] = array('like' => '%'.mysql_like_quote($filter['order_sn']).'%');
	        }
	        if ($filter['consignee']) {
	        	$this->where['o.consignee'] = array('like' => '%'.mysql_like_quote($filter['consignee']).'%');
	        }
		}
		
        if ($filter['email']) {
        	$this->where['o.email'] = array('like' => '%'.mysql_like_quote($filter['email']).'%');
        }
        if ($filter['address']) {
        	$this->where['o.address'] = array('like' => '%'.mysql_like_quote($filter['address']).'%');
        }
        if ($filter['zipcode']) {
        	$this->where['o.zipcode'] = array('like' => '%'.mysql_like_quote($filter['zipcode']).'%');
        }
        if ($filter['tel']) {
        	$this->where['o.tel'] = array('like' => '%'.mysql_like_quote($filter['tel']).'%');
        }
        if ($filter['mobile']) {
        	$this->where['o.mobile'] = array('like' => '%'.mysql_like_quote($filter['mobile']).'%');
        }
        if ($filter['country']) {
        	$this->where['o.country'] = $filter['country'];
        }
        if ($filter['province']) {
        	$this->where['o.province'] = $filter['province'];
        }
        if ($filter['city']) {
        	$this->where['o.city'] = $filter['city'];
        }
        if ($filter['district']) {
        	$this->where['o.district'] = $filter['district'];
        }
        if ($filter['shipping_id']) {
        	$this->where['o.shipping_id'] = $filter['shipping_id'];
        }
        if ($filter['pay_id']) {
        	$this->where['o.pay_id'] = $filter['pay_id'];
        }
        if ($filter['status'] != -1) {
        	$this->where[] = " (o.order_status  = '$filter[status]' or o.shipping_status  = '$filter[status]' or o.pay_status  = '$filter[status]')";
        }
        if ($filter['order_status'] != -1) {
        	$this->where['o.order_status'] = $filter['order_status'];
        }
        if ($filter['shipping_status'] != -1) {
        	$this->where['o.shipping_status'] = $filter['shipping_status'];
        }
        if ($filter['pay_status'] != -1) {
        	$this->where['o.pay_status'] = $filter['pay_status'];
        }
        if ($filter['user_id']) {
        	$this->where['o.user_id'] = $filter['user_id'];
        }
        if ($filter['user_name']) {
        	$this->where['u.user_name'] = array('like'=> '%'.mysql_like_quote($filter['user_name']).'%');
        }
        if ($filter['start_time']) {
        	$this->where[] = "o.add_time >= '$filter[start_time]'";
        }
        if ($filter['end_time']) {
        	$this->where[] = "o.add_time <= '$filter[end_time]'";
        }
		/* 团购订单 */
        if ($filter['group_buy_id']) {
        	$this->where['o.extension_code'] = 'group_buy';
        	$this->where['o.extension_id'] = $filter['group_buy_id'];
        }
		return $this->where;
	}
	
    public function get_order_list($pagesize = '15') {
    	$db_order 	= RC_Loader::load_app_model('order_info_model','orders');
	    $dbview 	= RC_Loader::load_app_model('order_order_info_viewmodel','orders');
	    //$db_admin 	= RC_Loader::load_model('admin_user_model');
		$db_admin 	= RC_Model::model('admin_user_model');
	    $args = $_GET;

        /* 过滤信息 */
        $filter['order_sn'] 			= empty($args['order_sn']) 			? '' : trim($args['order_sn']);
        $filter['consignee'] 			= empty($args['consignee']) 		? '' : trim($args['consignee']);
        $filter['keywords']				= empty($args['keywords'])			? '' : trim($args['keywords']);
        $filter['email'] 				= empty($args['email']) 			? '' : trim($args['email']);
        $filter['address'] 				= empty($args['address']) 			? '' : trim($args['address']);
        $filter['zipcode'] 				= empty($args['zipcode']) 			? '' : trim($args['zipcode']);
        $filter['tel'] 					= empty($args['tel']) 				? '' : trim($args['tel']);
        $filter['mobile'] 				= empty($args['mobile']) 			? 0 : intval($args['mobile']);
        $filter['country'] 				= empty($args['country']) 			? 0 : intval($args['country']);
        $filter['province'] 			= empty($args['province']) 			? 0 : intval($args['province']);
        $filter['city'] 				= empty($args['city']) 				? 0 : intval($args['city']);
        $filter['district'] 			= empty($args['district']) 			? 0 : intval($args['district']);
        $filter['shipping_id'] 			= empty($args['shipping_id']) 		? 0 : intval($args['shipping_id']);
        $filter['pay_id'] 				= empty($args['pay_id']) 			? 0 : intval($args['pay_id']);
        $filter['order_status'] 		= isset($args['order_status']) 		? intval($args['order_status']) : -1;
        $filter['status'] 		        = isset($args['status']) 		    ? intval($args['status']) : -1;
        $filter['shipping_status'] 		= isset($args['shipping_status']) 	? intval($args['shipping_status']) : -1;
        $filter['pay_status'] 			= isset($args['pay_status']) 		? intval($args['pay_status']) : -1;
        $filter['user_id'] 				= empty($args['user_id']) 			? 0 : intval($args['user_id']);
        $filter['user_name'] 			= empty($args['user_name']) 		? '' : trim($args['user_name']);
        $filter['composite_status'] 	= isset($args['composite_status']) 	? intval($args['composite_status']) : -1;
        $filter['group_buy_id'] 		= isset($args['group_buy_id']) 		? intval($args['group_buy_id']) : 0;
        $filter['sort_by'] 				= empty($args['sort_by']) 			? 'add_time' : trim($args['sort_by']);
        $filter['sort_order'] 			= empty($args['sort_order']) 		? 'DESC' : trim($args['sort_order']);
        $filter['start_time'] 			= empty($args['start_time']) 		? '' : (strpos($args['start_time'], '-') > 0 ?  RC_Time::local_strtotime($_REQUEST['start_time']) : $_REQUEST['start_time']);
        $filter['end_time'] 			= empty($args['end_time']) 			? '' : (strpos($args['end_time'], '-') > 0 ?  RC_Time::local_strtotime($_REQUEST['end_time']) : $_REQUEST['end_time']);
		
		$this->where = array('extension_code' => '', 'extension_id' => 0);
		$this->where = array_merge($this->where, $this->order_where($filter));
		
        //综合状态
        switch($filter['composite_status']) {
            case CS_AWAIT_PAY :
				$this->where = array_merge($this->where,$this->order_await_pay());
                break;

            case CS_AWAIT_SHIP :
				$this->where = array_merge($this->where,$this->order_await_ship());
                break;

            case CS_FINISHED :
				$this->where = array_merge($this->where,$this->order_finished());
                break;

            case PS_PAYING :
                if ($filter['composite_status'] != -1) {
                    $this->where['o.pay_status'] = $filter['composite_status'];
                }
                break;
            case OS_SHIPPED_PART :
                if ($filter['composite_status'] != -1) {
                	$this->where['o.shipping_status'] = $filter[composite_status]-2;
                }
                break;
            default:
                if ($filter['composite_status'] != -1) {
                	$this->where['o.order_status'] = $filter['composite_status'];
                }
        };

		
//		setcookie('ECJIA[composite_status]', urlencode(serialize($filter['composite_status'])), RC_Time::gmtime()+ 36000);
		RC_Cookie::set('composite_status', $filter['composite_status']);
        
        /* 如果管理员属于某个办事处，只列出这个办事处管辖的订单 */
		//注释by  will.chen  关于办事处的先注释
//        $agency_id = $db_admin->where(array('user_id' => $_SESSION['admin_id']))->get_field('agency_id');
//         if ($agency_id > 0) {
//             $this->where['o.agency_id'] = $agency_id;
//         }
        /* 记录总数 */
//         if ($filter['user_name']) {
            
//         } else {
//             $count = $dbview->join(null)->where($this->where)->count();
//         }
        $count = $dbview->join('users')->where($this->where)->count();
        //加载分页类
        RC_Loader::load_sys_class('ecjia_page', false);
        //实例化分页
        $page = new ecjia_page($count, $pagesize, 6);

        $filter['record_count']   = $count;
//        $filter['page_count']     = $filter['record_count'] > 0 ? ceil($filter['record_count'] / $filter['page_size']) : 1;

        /* 查询 */
        $dbview->view 	= array(
            'users' => array(
                'type'  	=> Component_Model_View::TYPE_LEFT_JOIN,
                'alias'		=> 'u',
                'field' 	=> "o.order_id, o.user_id, o.order_sn, o.add_time, o.order_status, o.shipping_status, o.order_amount, o.money_paid,o.pay_status, o.consignee, o.address, o.email, o.tel, o.extension_code, o.extension_id ,(" . $this->order_amount_field('o.') . ") AS total_fee,IFNULL(u.user_name, '" .RC_Lang::get('store::store.anonymous'). "') AS buyer,u.email as user_mail,u.mobile_phone as user_phone",
                'on'    	=> 'u.user_id = o.user_id ',
            )
        );
        $fields = "o.order_id,o.order_sn, o.add_time, o.order_status, o.shipping_status, o.order_amount, o.money_paid,o.pay_status, o.consignee, o.address, o.email, o.tel,o.mobile,o.extension_code, o.extension_id ,(" . $this->order_amount_field('o.') . ") AS total_fee";
        $row    = $dbview->join('users')->where($this->where)->order(array($filter[sort_by] => $filter[sort_order]))->limit($page->limit())->select();
        foreach (array('order_sn', 'consignee', 'email', 'address', 'zipcode', 'tel', 'user_name') AS $val) {
            $filter[$val] = stripslashes($filter[$val]);
        }
		RC_Loader::load_app_func('global', 'goods');
	    /* 格式话数据 */
	    if(!empty($row)) {
	        foreach ($row AS $key => $value) {
	
				$row[$key]['formated_order_amount'] = price_format($value['order_amount']);
				$row[$key]['formated_money_paid'] = price_format($value['money_paid']);
				$row[$key]['formated_total_fee'] = price_format($value['total_fee']);
	            $row[$key]['short_order_time'] 			= RC_Time::local_date('Y-m-d H:i', $value['add_time']);
	            if ($value['order_status'] == OS_INVALID || $value['order_status'] == OS_CANCELED) {
	                /* 如果该订单为无效或取消则显示删除链接 */
	                $row[$key]['can_remove'] = 1;
	            } else {
	                $row[$key]['can_remove'] = 0;
	            }
	        }
	    }
	
	   	return array('orders' => $row, 'filter' => $filter, 'page' => $page->show($pagesize), 'desc' => $page->page_desc());
    }
	
	/**
	 * 生成查询订单总金额的字段
	 * @param   string  $alias  order表的别名（包括.例如 o.）
	 * @return  string
	 */
	function order_amount_field($alias = '') {
	    return "   {$alias}goods_amount + {$alias}tax + {$alias}shipping_fee" .
	           " + {$alias}insure_fee + {$alias}pay_fee + {$alias}pack_fee" .
	           " + {$alias}card_fee ";
	}
}

// end