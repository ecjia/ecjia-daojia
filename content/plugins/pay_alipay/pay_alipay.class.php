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
/**
 * 支付宝插件
 */
defined('IN_ECJIA') or exit('No permission resources.');

RC_Loader::load_app_class('payment_abstract', 'payment', false);

class pay_alipay extends payment_abstract
{
    /**
     * 获取插件配置信息
     */
    public function configure_config() {
        $config = include(RC_Plugin::plugin_dir_path(__FILE__) . 'config.php');
        if (is_array($config)) {
            return $config;
        }
        return array();
    }
    
    
    public function get_prepare_data() {
        
        $charset = RC_CHARSET;
        $alipay_config = $this->configure;
        
        if ($this->is_mobile) {
            $req_id = date('Ymdhis');
            
            $pay_parameter['subject']       = ecjia::config('shop_name') . '的订单：' . $this->order_info['order_sn'];
            $pay_parameter['partner']       = $this->configure['alipay_partner'];
            $pay_parameter['order_sn']      = $this->order_info['order_sn'];
            $pay_parameter['order_logid']   = $this->order_info['log_id'];
            $pay_parameter['order_amount']  = $this->order_info['order_amount'];
            $pay_parameter['seller_id']     = $this->configure['alipay_account'];
            $pay_parameter['notify_url']    = $this->return_url('/notify/pay_alipay.php');
            $pay_parameter['callback_url']  = $this->return_url('/notify/pay_alipay.php');
            $pay_parameter['pay_order_sn']  = $this->get_out_trade_no();
            $pay_parameter['pay_code']      = $this->configure['pay_code'];
            $pay_parameter['pay_name']      = $this->configure['pay_name'];
            $pay_parameter['private_key']   = $this->configure['private_key_pkcs8'];
            
            $req_data  = '<direct_trade_create_req>';
            $req_data .= '<subject>' . $pay_parameter['subject'] . '</subject>';
            $req_data .= '<out_trade_no>' . $pay_parameter['pay_order_sn'] . '</out_trade_no>';
            $req_data .= '<total_fee>' . $pay_parameter['order_amount'] . '</total_fee>';
            $req_data .= '<seller_account_name>' . $pay_parameter['seller_id'] . '</seller_account_name>';
            $req_data .= '<notify_url>' . $pay_parameter['notify_url'] . '</notify_url>';
            $req_data .= '<out_user>' . $this->order_info['consignee'] . '</out_user>';
            $req_data .= '<merchant_url>' . $this->return_url('/notify/pay_alipay.php') . '</merchant_url>';
            $req_data .= '<call_back_url>' . $pay_parameter['callback_url'] . '</call_back_url>';
            $req_data .= '</direct_trade_create_req>';
            
            $parameter = array (
                'req_data' 			=> $req_data,
                'service' 			=> 'alipay.wap.trade.create.direct',
                'sec_id' 			=> 'MD5',
                'partner' 			=> $this->configure['alipay_partner'],
                'req_id' 			=> $req_id,
                'format' 			=>'xml',
                'v' 				=>'2.0',
                '_input_charset' 	=> trim(strtolower($charset)),
            );
            
            
            $alipay_config['sign_type'] = 'MD5';
            //建立请求
            $alipay_request = new alipay_request_wap($alipay_config);
            $html_text = $alipay_request->build_request_http($parameter);
            //urldecode返回的信息
            $html_text = urldecode($html_text);
            //解析远程模拟提交后返回的信息
            $para_html_text = $alipay_request->parse_response($html_text);
            //获取request_token
            $request_token = isset($para_html_text['request_token']) ? $para_html_text['request_token'] : '';

            $req_data  = '<auth_and_execute_req>';
            $req_data  .= '<request_token>' . $request_token . '</request_token>';
            $req_data  .= '</auth_and_execute_req>';
            
            $parameter = array (
                'service'           => 'alipay.wap.auth.authAndExecute',
                'partner'           => $this->configure['alipay_partner'],
                'sec_id'            => 'MD5',
                'format'            => 'xml',
                'v'                 => '2.0',
                'req_id'	        => $req_id,
                'req_data'          => $req_data,
                '_input_charset'	=> trim(strtolower($charset)),
            );

            $pay_parameter['pay_online'] = $alipay_request->build_request_param_toLink($parameter);
            
            return $pay_parameter;
        } else {
            $real_method = $this->configure['alipay_pay_method'];
            
            switch ($real_method){
            	case '0':
            	    $service = 'trade_create_by_buyer';
            	    break;
            	case '1':
            	    $service = 'create_partner_trade_by_buyer';
            	    break;
            	case '2':
            	    $service = 'create_direct_pay_by_user';
            	    break;
                default:
                    $service = 'trade_create_by_buyer';
            }
            
            $extend_param = 'isv^sh22';
            
            $parameter = array(
                'extend_param'      => $extend_param,
                'service'           => $service,
                'partner'           => $this->configure['alipay_partner'],
                '_input_charset'    => $charset,
                'notify_url'        => $this->return_url('/notify/pay_alipay.php'),
                'return_url'        => $this->return_url('/notify/pay_alipay.php'),
            
                /* 业务参数 */
                'subject'           => $this->order_info['order_sn'],
                'out_trade_no'      => $this->get_out_trade_no(),
                'price'             => $this->order_info['order_amount'],
                'quantity'          => 1,
                'payment_type'      => 1,
            
                /* 物流参数 */
                'logistics_type'    => 'EXPRESS',
                'logistics_fee'     => '0',
                'logistics_payment' => 'BUYER_PAY_AFTER_RECEIVE',
            
                /* 买卖双方信息 */
                'seller_email'      => $this->configure['alipay_account']
            );

            $alipay_config['sign_type'] = 'MD5';
            $alipay_request = new alipay_request_web($alipay_config);
            $button_attr = $alipay_request->build_request_param($parameter);;

            $button_attr['pay_online'] = $alipay_request->build_request_param_toLink($parameter);
            
            return $button_attr;
        }
    }
    
    
    public function notify() {
        $alipay_config = array(
            'alipay_partner'    => $this->configure['alipay_partner'],
            'alipay_key'        => $this->configure['alipay_key'],
            'input_charset'     => 'utf-8',
            'transport'         => 'http',
        );
        
        if ($_POST['service'] == 'alipay.wap.trade.create.direct') {
            $alipay_config['sign_type'] = 'MD5';
            $alipay_notify = new alipay_notify_wap($alipay_config);
        } else {
            //计算得出通知验证结果 //web mobile 区分
            if ($_POST['sign_type'] == 'RSA') {
                $alipay_config['sign_type'] = 'RSA';
                $alipay_config['private_key'] = $this->configure['private_key'];
                $alipay_notify = new alipay_notify_mobile($alipay_config);
            } else {
                $alipay_config['sign_type'] = 'MD5';
                $alipay_notify = new alipay_notify_web($alipay_config);
            }
        }

        $verify_result = $alipay_notify->verify_notify();
        //验证成功
        if ($verify_result) {
            if (isset($_POST['notify_data'])) {
                $notify_data = $alipay_notify->get_notify_data($_POST['notify_data']);
                if (!empty($notify_data)) {
                    //获取订单ID
                    $item = $this->parse_out_trade_no($notify_data['out_trade_no']);
                    $order_sn = $item['order_sn'];
                    $log_id = $item['log_id'];
                
                    $db = RC_DB::table('payment_record');
                    $db->where('order_sn', $order_sn)->where('trade_type', 'buy')->update(array('trade_no' => $notify_data['trade_no']));
                    
                    $pay_status = PS_UNPAYED;
                    if ($notify_data['trade_status'] == 'TRADE_FINISHED' || $notify_data['trade_status'] == 'TRADE_SUCCESS') {
                        $pay_status = PS_PAYED;
                    }
                
                    $result = RC_Api::api('orders', 'order_paid', array('log_id' => $log_id, 'money' => $notify_data['total_fee'], 'pay_status' => $pay_status));
                    if (is_ecjia_error($result)) {
                        return $result;
                    } else {
                        return $result;
                    }
                
                }
            } else {
                //获取订单ID
                $item = $this->parse_out_trade_no($_POST['out_trade_no']);
                $order_sn = $item['order_sn'];
                $log_id = $item['log_id'];
                
                $db = RC_DB::table('payment_record');
                $db->where('order_sn', $order_sn)->where('trade_type', 'buy')->update(array('trade_no' => $_POST['trade_no']));
                
                $pay_status = PS_UNPAYED;
                if ($_POST['trade_status'] == 'TRADE_FINISHED' || $_POST['trade_status'] == 'TRADE_SUCCESS') {
                    $pay_status = PS_PAYED;
                }
                
                $result = RC_Api::api('orders', 'order_paid', array('log_id' => $log_id, 'money' => $_POST['total_fee'], 'pay_status' => $pay_status));
                if (is_ecjia_error($result)) {
                    return $result;
                } else {
                    return $result;
                }
            } 
        } else {
            return new ecjia_error('sign_verify_data_fail', '签名验证失败');
        }
    }
    
    public function response() {
        $alipay_config = array(
            'alipay_partner'    => $this->configure['alipay_partner'],
            'alipay_key'        => $this->configure['alipay_key'],
            'sign_type'         => 'MD5',
            'input_charset'     => 'utf-8',
            'transport'         => 'http',
        );
        //计算得出通知验证结果
        if (!empty($_GET['result'])) {
            $alipay_notify = new alipay_notify_wap($alipay_config);
            $result_status = $_GET['result']; // success 是WAP支付时返回的GET参数
        } else {
            $alipay_notify = new alipay_notify_web($alipay_config);
            $result_status = $_GET['trade_status']; // TRADE_FINISHED, TRADE_SUCCESS 是WEB支付时返回的GET参数
        }
        
        $verify_result = $alipay_notify->verify_return();
        if ($verify_result) {
            if ($result_status == 'TRADE_FINISHED' || $result_status == 'TRADE_SUCCESS' || $result_status == 'success') {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}

// end