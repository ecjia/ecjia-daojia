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
 * 支付方法
 * @author royalwang
 */
class payment_method {
	private $db;
	private $dblog;
	
	public function __construct() {
		$this->db = RC_Model::model('payment/payment_model');
		RC_Loader::load_app_class('payment_factory', 'payment', false);
	}
	
	
	/**
	 * 取得可用的支付方式列表
	 * @param   bool    $support_cod        配送方式是否支持货到付款
	 * @param   int     $cod_fee            货到付款手续费（当配送方式支持货到付款时才传此参数）
	 * @param   int     $is_online          是否支持在线支付
	 * @return  array   配送方式数组
	 */
	public function available_payment_list($support_cod = true, $cod_fee = 0, $is_online = false) {
		$db_payment = RC_DB::table('payment');
        $where = array();
        if (!$support_cod) {
            // $where['is_cod'] = 0;
            $db_payment->where('is_cod', 0);
        }
        if ($is_online) {
            // $where['is_online'] = 1;
            $db_payment->where('is_online', 1);
        }
        
        //$where['enabled'] = 1;
        $db_payment->where('enabled', 1);
        $plugins = $this->available_payment_plugins();

        // $data = $this->db->field('pay_id, pay_code, pay_name, pay_fee, pay_desc, pay_config, is_cod, is_online')->where($where)->order(array('pay_order' => 'asc'))->select();
        $data = $db_payment->select('pay_id', 'pay_code', 'pay_name', 'pay_fee', 'pay_desc', 'pay_config', 'is_cod', 'is_online')->orderby('pay_order', 'asc')->get();

        $pay_list = array();
         
        if (!empty($data)) {
            foreach ($data as $row) {
                if (isset($plugins[$row['pay_code']])) {
                    if ($row['is_cod'] == '1') {
                        $row['pay_fee'] = $cod_fee;
                    }
                    
                    $row['format_pay_fee'] = strpos($row['pay_fee'], '%') !== false ? $row['pay_fee'] : price_format($row['pay_fee'], false);
                    $pay_list[] = $row;
                }
            }
        }

        return $pay_list;
	}
	
	
	/**
	 * 激活的支付插件列表
	 */
	public function available_payment_plugins() {
	   return ecjia_config::instance()->get_addon_config('payment_plugins', true, true);
	}
	
	/**
	 * 获取指定支付方式的实例
	 * @param string $pay_code
	 * @param array $config
	 * @return payment_factory
	 */
	public function get_payment_instance($pay_code, $config = array()) {
	    $payment_info = $this->payment_info_by_code($pay_code);
	    if (empty($config)) {
	        $config = $this->unserialize_config($payment_info['pay_config']);
	    }
	    $config['pay_code'] = $pay_code;
	    $config['pay_name'] = $payment_info['pay_name'];
// 	    $handler = new payment_factory($pay_code, $config);
	    $handler = with(new Ecjia\App\Payment\PaymentPlugin)->channel($pay_code);
	    return $handler;
	}
	
	
	/**
	 * 取得支付方式信息
	 * @param   int|string     $pay_id/$pay_code     支付方式id 或 支付方式code
	 * @return  array   支付方式信息
	 */
	public function payment_info($pay_id) {
	    return $this->payment_info_by_id($pay_id);
	}
	public function payment_info_by_id($pay_id) {
	    return $this->db->find(array('pay_id' => $pay_id , 'enabled' => 1));
	}
	public function payment_info_by_code($pay_code) {
	    return $this->db->find(array('pay_code' => $pay_code , 'enabled' => 1));
	}
	public function payment_info_by_name($pay_name) {
		return $this->db->where(array('pay_name' => $pay_name , 'enabled' => 1))->select();
	}
	
	/**
	 * 取得支付方式id列表
	 * @param   bool    $is_cod 是否货到付款
	 * @return  array
	 */
	public function payment_id_list($is_cod) {
		$db_payment = RC_DB::table('payment');
	    if ($is_cod) {
	        // $where = "is_cod = 1" ;
	        $db_payment->where('is_cod', 1);

	    } else {
	        // $where = "is_cod = 0" ;
	        $db_payment->where('is_cod', 0);
	    }
	    // $row = $this->db->field('pay_id')->where($where)->select();
	    $row = $db_payment->select('pay_id')->get();

	    $arr = array();
	    if(!empty($row) && is_array($row)) {
	    	foreach ($row as $val) {
	    		$arr[] = $val['pay_id'];
	    	}
	    }
	    
	    return $arr;
	}
	
	
	/**
	 * 将支付LOG插入数据表
	 *
	 * @access public
	 * @param integer $id
	 *        	订单编号
	 * @param float $amount
	 *        	订单金额
	 * @param integer $type
	 *        	支付类型
	 * @param integer $is_paid
	 *        	是否已支付
	 *
	 * @return int
	 */
	public function insert_pay_log($id, $amount, $type = PAY_SURPLUS, $is_paid = 0) {
	    // $db = RC_Loader::load_app_model('pay_log_model', 'orders');
	    $data = array (
	        'order_id'     => $id,
	        'order_amount' => $amount,
	        'order_type'   => $type,
	        'is_paid'      => $is_paid
	    );
		$insert_id = RC_DB::table('pay_log')->insertGetId($data);    	

	    return $insert_id;
	}
	
	
	/**
	 * 取得上次未支付的pay_lig_id
	 *
	 * @access public
	 * @param array $surplus_id
	 *        	余额记录的ID
	 * @param array $pay_type
	 *        	支付的类型：预付款/订单支付
	 *
	 * @return int
	 */
	public function get_paylog_id($surplus_id, $pay_type = PAY_SURPLUS) {
	    // $db = RC_Loader::load_app_model('pay_log_model', 'orders');
	    // $log_id = $db->where(array('order_id' => $surplus_id, 'order_type' => $pay_type, 'is_paid' => 0))->get_field('log_id');

	   	$log_id = RC_DB::table('pay_log')->where('order_id', $surplus_id)->where('order_type', $pay_type)->where('is_paid', 0)->pluck('log_id');
		return $log_id;
	}

	/**
	 * 更新支付LOG
	 *
	 * @access public
	 * @param integer $id
	 *        	订单编号
	 * @param float $amount
	 *        	订单金额
	 * @param integer $type
	 *        	支付类型
	 * @param integer $is_paid
	 *        	是否已支付
	 *
	 * @return int
	 */
	public function update_pay_log($id, $amount, $type = PAY_SURPLUS, $is_paid = 0) {
		// $db = RC_Loader::load_app_model('pay_log_model', 'orders');
		// $row = $db->where(array('order_id' => $id, 'order_type'=> $type, 'is_paid' => 0))->update(array('order_amount' => $amount));
		// return $row;
		RC_DB::table('pay_log')->where('order_id', $id)->where('order_type', $type)->where('is_paid', 0)->update(array('order_amount' => $amount));
		return true;
	}
	
	/**
	 * 处理序列化的支付、配送的配置参数
	 * 返回一个以name为索引的数组
	 *
	 * @access  public
	 * @param   string       $cfg
	 * @return  void
	 */
	public function unserialize_config($cfg) {
	    if (is_string($cfg) && ($arr = unserialize($cfg)) !== false) {
	        $config = array();
	        foreach ($arr AS $key => $val) {
	            $config[$val['name']] = $val['value'];
	        }
	        return $config;
	    } else {
	        return false;
	    }
	}
	
	/**
	 * 取得已安装的支付方式(其中不包括线下支付的)
	 * @param   bool    $include_balance    是否包含余额支付（冲值时不应包括）
	 * @return  array   已安装的配送方式列表
	 */
	public function get_online_payment_list($include_balance = true) {
		// $where = array();
		// $where['enabled'] = '1';
		// $where['is_cod'] = array('neq' => '1');

		$db_payment = RC_DB::table('payment')->where('enabled', 1)->where('is_cod', '!=', 1);

		if (!$include_balance) {
			// $where['pay_code'] = array('neq' => 'balance');
			$db_payment->where('pay_code', '!=', 'balance');
		}
		$plugins = $this->available_payment_plugins();
		
		// $data = $this->db->field('pay_id, pay_code, pay_name, pay_fee, pay_desc')->where($where)->select();
		$data = $db_payment->select('pay_id', 'pay_code', 'pay_name', 'pay_fee', 'pay_desc')->get();
		
		$pay_list = array();
		 
		if (!empty($data)) {
			foreach ($data as $row) {
				if (isset($plugins[$row['pay_code']])) {
					$row['format_pay_fee'] = strpos($row['pay_fee'], '%') !== false ? $row['pay_fee'] :
					$pay_list[] = $row;
				}
			}
		}
		
		return $pay_list;
		
// 		$modules = $GLOBALS['db']->getAll($sql);
	
// 		include_once(ROOT_PATH.'includes/lib_compositor.php');
	
// 		return $modules;
	}
}

// end