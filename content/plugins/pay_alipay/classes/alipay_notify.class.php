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
 * 类名：alipay_notify
 * 功能：支付宝通知处理类
 * 详细：处理支付宝各接口通知返回
 */
abstract class alipay_notify {
    /**
     * HTTPS形式消息验证地址
     */
    protected $https_verify_url = 'https://mapi.alipay.com/gateway.do?service=notify_verify&';
    /**
     * HTTP形式消息验证地址
     */
    protected $http_verify_url = 'http://notify.alipay.com/trade/notify_query.do?';
    protected $alipay_config = array();
    
    protected $sign_md5;
    protected $sign_rsa;
    
    public function __construct($alipay_config) {
        $this->alipay_config = array_merge($this->alipay_config, $alipay_config);
        $this->sign_md5 = new alipay_sign_md5();
        $this->sign_rsa = new alipay_sign_rsa();
    }

    /**
     * 针对notify_url验证消息是否是支付宝发出的合法消息
     * @return 验证结果
     */
    abstract public function verify_notify();
    
    /**
     * 针对return_url验证消息是否是支付宝发出的合法消息
     * @return 验证结果
     */
    abstract public function verify_return();

    
    /**
     * 获取返回时notify_data数据
     * @param $notify_data  xml string
     * @return array
     */
    public function get_notify_data($notify_data) {
        $sign_type = strtoupper(trim($this->alipay_config['sign_type']));
        //解密（如果是RSA签名需要解密）
        if ($sign_type == 'RSA' || $sign_type == '0001') {
            $notify_data = $this->decrypt($notify_data);
        }

        $arr = RC_Xml::to_array($notify_data);
        foreach ($arr as $key => $value) {
            $arr[$key] = $value[0];
        }        
        return $arr;
    }
    
    /**
     * 获取返回时的签名验证结果
     * @param $para_temp 通知返回来的参数数组
     * @param $sign 返回的签名结果
     * @param $isSort 是否对待签名数组排序
     * @return 签名验证结果
     */
    protected function get_sign_veryfy($param_temp, $sign, $isSort) {
        //除去待签名参数数组中的空值和签名参数
        $param = alipay_core::param_filter($param_temp);
        
        //对待签名参数数组排序
        if ($isSort) {
            $param = alipay_core::arg_sort($param);
        } else {
            $param = alipay_core::notify_param_sort($param);
        }

        //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        $prestr = alipay_core::create_linkstring($param);
    
        $isSgin = false;
        switch (strtoupper(trim($this->alipay_config['sign_type']))) {
        	case "MD5" :
        	    $isSgin = $this->sign_md5->verify($prestr, $sign, $this->alipay_config['alipay_key']);
        	    break;
        	case "RSA" :
        	    $isSgin = $this->sign_rsa->verify($prestr, $sign, trim($this->alipay_config['alipay_publickey']));
        	    break;
        	case "0001" :
        	    $isSgin = $this->sign_rsa->verify($prestr, $sign, trim($this->alipay_config['alipay_publickey']));
        	    break;
        	default :
        	    $isSgin = false;
        }
    
        return $isSgin;
    }
    
    /**
     * 获取远程服务器ATN结果,验证返回URL
     * @param $notify_id 通知校验ID
     * @return 服务器ATN结果
     * 验证结果集：
     * invalid命令参数不对 出现这个错误，请检测返回处理中partner和key是否为空
     * true 返回正确信息
     * false 请检查防火墙或者是服务器阻止端口问题以及验证时间是否超过一分钟
     */
    protected function get_response($notify_id) {
        $transport = strtolower(trim($this->alipay_config['transport']));
        $partner = trim($this->alipay_config['alipay_partner']);
        $veryfy_url = '';
        if ($transport == 'https') {
            $veryfy_url = $this->https_verify_url;
        } else {
            $veryfy_url = $this->http_verify_url;
        }
        $veryfy_url = $veryfy_url . 'partner=' . $partner . '&notify_id=' . $notify_id;
        $responseTxt = alipay_core::getHttpResponseGET($veryfy_url, $this->alipay_config['cacert']);
    
        return $responseTxt;
    }
    
    
    /**
     * 解密
     * @param $input_para 要解密数据
     * @return 解密后结果
     */
    protected function decrypt($prestr) {
        return $this->sign_rsa->decrypt($prestr, trim($this->alipay_config['private_key']));
    }

}

// end