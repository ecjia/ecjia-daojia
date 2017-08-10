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
namespace Ecjia\App\Payment;

trait CompatibleTrait 
{
    
    protected $is_mobile = false;
    
    protected $order_info = array();

    /**
     * 设置是否是手机访问使用
     * @param boolean $bool
     */
    public function set_mobile($bool) {
        $this->is_mobile = $bool;
    }
    
    public function set_orderinfo($order_info) {
        $this->order_info = $order_info;
        return $this;
    }
    
    /**
     * 获取支付代码
     * @param int $type 支付代码类型  1 => 表单, 2 => 链接, 3 => 数组
     * @param string $args
     * @return string
     */
    public function get_code($type, $args = array()) {
        $prepare_data = $this->get_prepare_data();
        if (is_ecjia_error($prepare_data)) {
            return $prepare_data;
        }
         
        if ($type == PayConstant::PAYCODE_FORM) {
            return $this->build_request_form($prepare_data, $args);
        } elseif ($type == PayConstant::PAYCODE_STRING) {
            return $this->build_request_param_toString($prepare_data);
        } elseif ($type == PayConstant::PAYCODE_PARAM) {
            return $this->build_request_param($prepare_data);
        } else {
            return ;
        }
    }
    
    /**
     * PHP Crul库 模拟Post提交至支付宝网关
     * 如果使用Crul 你需要改一改你的php.ini文件的设置，找到php_curl.dll去掉前面的";"就行了
     * 返回 $data
     */
    public function post($url, $param) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); // 配置网关地址
        curl_setopt($ch, CURLOPT_HEADER, 0); // 过滤HTTP头
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1); // 设置post提交
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param); // post传输数据
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
    
    /**
     * 生成要请求给支付宝的参数数组
     * @param $prepare_data 请求前的参数数组
     * @return 要请求的参数数组字符串
     */
    public function build_request_param($prepare_data) {
        return $prepare_data;
    }
    
    /**
     * 生成要请求给支付宝的参数字符串连接
     * @param $prepare_data 请求前的参数数组
     * @return 要请求的参数数组字符串
     */
    public function build_request_param_toString($prepare_data) {
        return $prepare_data['pay_online'];
    }
    
    /**
     * 建立请求，以表单HTML形式构造（默认）
     * @param $prepare_data 请求参数数组
     * @param $button_args 确认按钮参数
     * @return 提交表单HTML文本
     */
    public function build_request_form($prepare_data, $button_args) {
        if (strtoupper($this->configure['gateway_method']) == 'POST') {
            $code = '<form action="' . $this->configure['gateway_url'] . '" method="POST" target="_blank">';
        } else {
            $code = '<form action="' . $this->configure['gateway_url'] . '" method="GET" target="_blank">';
        }
    
        unset($prepare_data['pay_online']);
    
        foreach ($prepare_data as $key => $value) {
            $code .= '<input type="hidden" name="' . $key . '" value="' . $value . '" />';
        }
    
        if (is_array($button_args) && !empty($button_args)) {
            $button_attr = '';
            foreach ($button_args as $key => $value) {
                $button_attr .=  ' ' . $key . '="' . $value . '"';
            }
        }
    
        $code .= '<input type="submit"' . $button_attr . ' />';
        $code .= '</form>';
        return $code;
    }
    
    /**
     * 返回通知url
     * @param string $url
     */
    public function return_url($url) {
        return \RC_Uri::site_url() . $url;
    }
    
    /**
     * 获取外部支付使用的订单号
     */
    public function get_out_trade_no() {
        $app = 'ecjia.payment';
        $group = 'paylog';
         
        $order_sn = $this->order_info['order_sn'];
        $log_id = $this->order_info['log_id'];
        $out_trade_no = $order_sn . $log_id;
         
        $relationship_db = \RC_Model::model('goods/term_relationship_model');
         
        $data = array(
            'object_type' 	=> $app,
            'object_group' 	=> $group,
            'object_id' 	=> $log_id,
            'item_key1' 	=> 'order_sn',
            'item_value1' 	=> $order_sn,
            'item_key2' 	=> 'out_trade_no',
            "item_value2 	= '$out_trade_no'" ,
        );
        $count = $relationship_db->where($data)->count();
        if (!$count) {
            $data = array(
                'object_type' 	=> $app,
                'object_group' 	=> $group,
                'object_id' 	=> $log_id,
                'item_key1' 	=> 'order_sn',
                'item_value1' 	=> $order_sn,
                'item_key2' 	=> 'out_trade_no',
                'item_value2' 	=> $out_trade_no,
            );
            $relationship_db->insert($data);
        }
        return $out_trade_no;
    }
    
    
    /**
     * 解析支付使用的外部订单号
     */
    public function parse_out_trade_no($out_trade_no) {
        $app = 'ecjia.payment';
        $group = 'paylog';
         
        if (empty($out_trade_no)) {
            return false;
        }
         
        $data = array(
            'object_type'	=> $app,
            'object_group'	=> $group,
            'item_key1'		=> 'order_sn',
            'item_key2'		=> 'out_trade_no',
            "item_value2 	= '$out_trade_no'" ,
        );
        $relationship_db = \RC_Model::model('goods/term_relationship_model');
        $item = $relationship_db->where($data)->find();
        \RC_Logger::getLogger('pay')->info($item);
        if ($item) {
            return array('order_sn' => $item['item_value1'], 'log_id' => $item['object_id']);
        }
        return false;
    }
    
    
    /**
     * 支付方式的预处理数据
     * @return array
     */
    abstract public function get_prepare_data();
    
}