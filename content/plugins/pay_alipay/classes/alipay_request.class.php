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
 * 类名：alipay_request
 * 功能：支付宝各接口请求提交类
 * 详细：构造支付宝各接口表单HTML文本，获取远程HTTP数据
 */
abstract class alipay_request {
    var $alipay_config;
    /**
     *支付宝网关地址
     */
    protected $alipay_gateway_new;
    
    protected $sign_md5;
    protected $sign_rsa;
    
    public function __construct($alipay_config){
        $this->alipay_config = $alipay_config;
        
        $this->sign_md5 = new alipay_sign_md5();
        $this->sign_rsa = new alipay_sign_rsa();
    }
    
    /**
     * 生成签名结果
     * @param $para_sort 已排序要签名的数组
     * return 签名结果字符串
     */
    public function create_request_sign($param_sort) {
        //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        $prestr = alipay_core::create_linkstring($param_sort);
    
        $mysign = '';
        switch (strtoupper(trim($this->alipay_config['sign_type']))) {
        	case "MD5" :
        	    $mysign = $this->sign_md5->sign($prestr, $this->alipay_config['alipay_key']);
        	    break;
        	case "RSA" :
        	    $mysign = $this->sign_rsa->sign($prestr, $this->alipay_config['private_key']);
        	    break;
        	case "0001" :
        	    $mysign = $this->sign_rsa->sign($prestr, $this->alipay_config['private_key']);
        	    break;
        	default :
        	    $mysign = '';
        }
    
        return $mysign;
    }
    
    /**
     * 生成要请求给支付宝的参数数组
     * @param $para_temp 请求前的参数数组
     * @return 要请求的参数数组
     */
    public function build_request_param($param_temp) {
        //除去待签名参数数组中的空值和签名参数
        $param_filter = alipay_core::param_filter($param_temp);
    
        //对待签名参数数组排序
        $param_sort = alipay_core::arg_sort($param_filter);
    
        //生成签名结果
        $mysign = $this->create_request_sign($param_sort);
    
        //签名结果与签名方式加入请求提交参数组中
        $param_sort['sign'] = $mysign;
        if ($param_sort['service'] != 'alipay.wap.trade.create.direct' && $param_sort['service'] != 'alipay.wap.auth.authAndExecute') {
            $param_sort['sign_type'] = strtoupper(trim($this->alipay_config['sign_type']));
        }
    
        return $param_sort;
    }
    
    /**
     * 生成要请求给支付宝的参数字符串
     * @param $para_temp 请求前的参数数组
     * @return 要请求的参数数组字符串
     */
    public function build_request_param_toString($param_temp) {
        //待请求参数数组
        $param = $this->build_request_param($param_temp);
    
        //把参数组中所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串，并对字符串做urlencode编码
        $request_data = alipay_core::create_linkstring_urlencode($param);
    
        return $request_data;
    }
    
    /**
     * 生成要请求给支付宝的参数带链接
     * @param $para_temp 请求前的参数数组
     * @return 要请求的参数数组字符串
     */
    public function build_request_param_toLink($param_temp) {
        //待请求参数数组
        $param = $this->build_request_param($param_temp);
    
        //把参数组中所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串，并对字符串做urlencode编码
        $request_data = alipay_core::create_linkstring_urlencode($param);
    
        return $this->alipay_gateway_new . $request_data;
    }
    
    /**
     * 建立请求，以表单HTML形式构造（默认）
     * @param $para_temp 请求参数数组
     * @param $method 提交方式。两个值可选：post、get
     * @param $button_name 确认按钮显示文字
     * @return 提交表单HTML文本
     */
    public function build_request_form($param_temp, $method, $button_name) {
        //待请求参数数组
        $param = $this->build_request_param($param_temp);
    
        $sHtml = "<form id='alipaysubmit' name='alipaysubmit' action='" . $this->alipay_gateway_new . "_input_charset=" . trim(strtolower($this->alipay_config['input_charset'])) . "' method='" . $method . "'>";
        while ((list($key, $val) = each($param)) != false) {
            $sHtml .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
        }
    
        //submit按钮控件请不要含有name属性
        $sHtml = $sHtml . "<input type='submit' value='" . $button_name . "'></form>";
    
        $sHtml = $sHtml."<script>document.forms['alipaysubmit'].submit();</script>";
    
        return $sHtml;
    }
    
    /**
     * 建立请求，以模拟远程HTTP的POST请求方式构造并获取支付宝的处理结果
     * @param $para_temp 请求参数数组
     * @return 支付宝处理结果
     */
    public function build_request_http($param_temp) {
        $sResult = '';
        
        //待请求参数数组字符串
        $request_data = $this->build_request_param($param_temp);
//		TODO:获取不到，暂给空值
        $this->alipay_config['cacert'] = '';
        //远程获取数据
        $sResult = alipay_core::getHttpResponsePOST($this->alipay_gateway_new, $this->alipay_config['cacert'], $request_data);
    
        return $sResult;
    }
    
    /**
     * 建立请求，以模拟远程HTTP的POST请求方式构造并获取支付宝的处理结果，带文件上传功能
     * @param $para_temp 请求参数数组
     * @param $file_para_name 文件类型的参数名
     * @param $file_name 文件完整绝对路径
     * @return 支付宝返回处理结果
     */
    public function build_request_http_inFile($param_temp, $file_param_name, $file_name) {
    
        //待请求参数数组
        $param = $this->build_request_param($param_temp);
        $param[$file_param_name] = '@' . $file_name;
    
        //远程获取数据
        $sResult = alipay_core::getHttpResponsePOST($this->alipay_gateway_new . '_input_charset=' . trim(strtolower($this->alipay_config['input_charset'])), $this->alipay_config['cacert'], $param);
    
        return $sResult;
    }
    
    
    
    /**
     * 用于防钓鱼，调用接口query_timestamp来获取时间戳的处理函数
     * 注意：该功能PHP5环境及以上支持，因此必须服务器、本地电脑中装有支持DOMDocument、SSL的PHP配置环境。建议本地调试时使用PHP开发软件
     * return 时间戳字符串
     */
    public function query_timestamp() {
        $url = $this->alipay_gateway_new . 'service=query_timestamp&partner=' . trim(strtolower($this->alipay_config['alipay_partner'])) . '&_input_charset=' . trim(strtolower($this->alipay_config['input_charset']));
        $encrypt_key = '';
    
        $doc = new DOMDocument();
        $doc->load($url);
        $itemEncrypt_key = $doc->getElementsByTagName('encrypt_key');
        $encrypt_key = $itemEncrypt_key->item(0)->nodeValue;
    
        return $encrypt_key;
    }
}

// end