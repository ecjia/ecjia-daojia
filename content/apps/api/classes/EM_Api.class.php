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

abstract class EM_Api {
    public static $session = array();

    public static $pagination = array();

    public static $token = null;
    
    protected static $error = array(
        6 => '密码错误',
        8 => '处理失败',
        11 => '用户名或email已使用',
        13 => '不存在的信息',
        14 => '购买失败',
        100 => 'Invalid session',
        101 => '错误的参数提交',
        200 => '用户名不能为空',
        201 => '用户名含有敏感字符',
        202 => '用户名 已经存在',
        203 => 'email不能为空',
        204 => '不是合法的email地址',
        300 => '对不起，指定的商品不存在',
        301 => '对不起，您希望将该商品做为配件购买，可是购物车中还没有该商品的基本件。',
        302 => '对不起，该商品已经下架。',
        303 => '对不起，该商品不能单独销售。',
        501 => '没有pagination结构',
        502 => 'code错误',
        503 => '合同期终止',
        10001 => '您必须选定一个配送方式',
        10002 => '购物车中没有商品',
        10003 => '您的余额不足以支付整个订单，请选择其他支付方式。',
        10005 => '您选择的超值礼包数量已经超出库存。请您减少购买量或联系商家。',
        10006 => '如果是团购，且保证金大于0，不能使用货到付款',
        10007 => '您已收藏过此商品',
        10008 => '库存不足',
        10009 => '订单无发货信息',
        10010 => '该订单已经支付，请勿重复支付。',
        99999 => '该网店暂停注册'
    );

    public static function init() {
        if (! empty($_POST['json'])) {
            $_POST['json'] = stripslashes($_POST['json']);
            $_POST = json_decode($_POST['json'], true);
        }
        self::$session = _POST('session', array());
        
        self::$token = _POST('token');
        
        self::$pagination = _POST('pagination', array(
            'page' => 1,
            'count' => 10
        ));
    }

    /**
     * 登录授权验证
     */
    public static function authSession($validate = true) {
    	if (isset(self::$token) && !empty(self::$token)) {
    		if (RC_Session::session_id() != self::$token) {
    			RC_Session::destroy();
    			RC_Session::init(null, self::$token);
    		}
    		
    		define('SESS_ID', RC_Session::session()->get_session_id());
    		
    		if (empty($_SESSION['user_id']) && empty($_SESSION['admin_id']) && $validate) {
    			self::outPut(100);
//     			return new ecjia_error('invalid_session', 'Invalid session');
    		}
    	} else {
    		if ((!isset(self::$session['uid']) || !isset(self::$session['sid'])) && $validate) {
    			self::outPut(100);
//     			return new ecjia_error('invalid_session', 'Invalid session');
    		}
    		
    		if (isset(self::$session['sid']) && !empty(self::$session['sid']) && RC_Session::session_id() != self::$session['sid']) {
    			RC_Session::destroy();
    			RC_Session::init(null, self::$session['sid']);
    		}
    		
    		define('SESS_ID', RC_Session::session()->get_session_id());
    		
    		if (empty($_SESSION['user_id']) && empty($_SESSION['admin_id'])  && $validate) {
    			self::outPut(100);
//     			return new ecjia_error('invalid_session', 'Invalid session');
    		}
    	}
        
    }

//     public static function outPut($data, $pager = NULL, $privilege = NULL)
    public static function outPut($data) {
        if (is_ecjia_error($data)) {
            $status = array(
                'status' => array(
                    'succeed' => 0,
                    'error_code' => $data->get_error_code(),
                    'error_desc' => $data->get_error_message(),
                )
            );
            die(json_encode($status));
        } elseif (is_int($data)) {
            $status = array(
                'status' => array(
                    'succeed' => 0,
                    'error_code' => $data,
                    'error_desc' => self::$error[$data]
                )
            );
            die(json_encode($status));
        }
        
        $response = array('data' => array(), 'status' => array('succeed' => 1));
        
        if (isset($data['data'])) {
            $response['data'] = $data['data'];
        } else {
        	$response['data'] = $data;
        }
        
        if (isset($data['pager'])) {
        	$response['paginated'] = $data['pager'];
        }
        
//         /* 后台新增*/
//         if (!empty($privilege)) {
//         	$data = array_merge($data, array(
//         			'privilege' => $privilege
//         	));
//         }
        
        header("Content-type: application/json; charset=UTF-8");
        die(json_encode($response));
    }

    public static function device_record() {
    	$result = ecjia_app::validate_application('mobile');
    	if (!is_ecjia_error($result)) {
    		$device = _POST('device', array());
    		if (!empty($device['udid']) && !empty($device['client']) && !empty($device['code'])) {
    			$db_mobile_device = RC_Loader::load_app_model('mobile_device_model', 'mobile');
    			$device_data = array(
    					'device_udid'	=> $device['udid'],
    					'device_client'	=> $device['client'],
    					'device_code'	=> $device['code']
    			);
    			$row = $db_mobile_device->find($device_data);
    			if (empty($row)) {
    				$device_data['add_time'] = RC_Time::gmtime();
    				$db_mobile_device->insert($device_data);
    			}
    		}
    	}
    }
    
    public static function stats($api_name) {
    	self::authSession(false);
    	$db_stats = RC_Loader::load_app_model('stats_model', 'stats');
    	$time = RC_Time::gmtime();
    	/* 检查客户端是否存在访问统计的cookie */
    	$expire = $_SESSION['stats_expire'];
		if (empty($expire) || ($expire < $time) ) {
			$access_url	= $api_name;
			$ip_address	= RC_Ip::client_ip();
			$area		= RC_Ip::area($ip_address);
			$device		= _POST('device', array());
			$system		= isset($device['client']) ? $device['client'] : '';
			$browser	= isset($device['code']) ? $device['code'] : '';
			$stats_data = array(
				'visit_times'=> 1,
				'access_time'=> $time,
				'ip_address' => $ip_address,
				'system'     => $system,
				'browser'	 => $browser,
				'area'		 => $area,
				'access_url' => $access_url,
			); 
			$db_stats->insert($stats_data);
			$_SESSION['stats_expire'] = $time + 10800;
		}
    }
}

//end