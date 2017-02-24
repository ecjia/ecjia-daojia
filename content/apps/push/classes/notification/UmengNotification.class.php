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

abstract class UmengNotification {
	// The host
	protected $host = "http://msg.umeng.com";

	// The upload path
	protected $uploadPath = "/upload";

	// The post path
	protected $postPath = "/api/send";

	// The app master secret
	protected $appMasterSecret = NULL;

	/*
	 * $data is designed to construct the json string for POST request. Note:
	 * 1)The key/value pairs in comments are optional.  
	 * 2)The value for key 'payload' is set in the subclass(AndroidNotification or IOSNotification), as their payload structures are different.
	 */ 
	protected $data = array(
			"appkey"           => NULL,
			"timestamp"        => NULL,
			"type"             => NULL,
			//"device_tokens"  => "xx",
			//"alias"          => "xx",
			//"file_id"        => "xx",
			//"filter"         => "xx",
			//"policy"         => array("start_time" => "xx", "expire_time" => "xx", "max_send_num" => "xx"),
			"production_mode"  => "true",
			//"feedback"       => "xx",
			//"description"    => "xx",
			//"thirdparty_id"  => "xx"
	);

	protected $DATA_KEYS    = array(   "appkey", 
	                                   "timestamp", 
	                                   "type", 
	                                   "device_tokens", 
	                                   "alias", 
	                                   "alias_type", 
	                                   "file_id", 
	                                   "filter", 
	                                   "production_mode",
								       "feedback", 
	                                   "description", 
	                                   "thirdparty_id");
	protected $POLICY_KEYS  = array(   "start_time", 
	                                   "expire_time", 
	                                   "max_send_num");
	
	protected $ERROR_CODES = array(
	    '1000' => '请求参数没有appkey',
	    '1001' => '请求参数没有payload',
	    '1002' => '请求参数payload中没有body',
	    '1003' => 'display_type为message时，请求参数没有custom',
	    '1004' => '请求参数没有display_type',
	    '1005' => 'img url格式不对，请以https或者http开始',
	    '1006' => 'sound url格式不对，请以https或者http开始',
	    '1007' => 'url格式不对，请以https或者http开始',
	    '1008' => 'display_type为notification时，body中ticker不能为空',
	    '1009' => 'display_type为notification时，body中title不能为空',
	    '1010' => 'display_type为notification时，body中text不能为空',
	    '1011' => 'play_vibrate的值只能为true或者false',
	    '1012' => 'play_lights的值只能为true或者false',
	    '1013' => 'play_sound的值只能为true或者false',
	    '1014' => 'task-id没有找到',
	    '1015' => '请求参数中没有device_tokens',
	    '1016' => '请求参数没有type',
	    '1017' => 'production_mode只能为true或者false',
	    '1018' => 'appkey错误：指定的appkey尚未开通推送服务',
	    '1019' => 'display_type填写错误',
	    '1020' => '应用组中尚未添加应用',
	    '2000' => '该应用已被禁用',
	    '2001' => '过期时间必须大于当前时间',
	    '2002' => '定时发送时间必须大于当前时间',
	    '2003' => '过期时间必须大于定时发送时间',
	    '2004' => 'IP白名单尚未添加, 请到网站后台添加您的服务器IP白名单。',
	    '2005' => '该消息不存在',
	    '2006' => 'validation token错误',
	    '2007' => '未对请求进行签名',
	    '2008' => 'json解析错误',
	    '2009' => '请填写alias或者file_id',
	    '2010' => '与alias对应的device_tokens为空',
	    '2011' => 'alias个数已超过50',
	    '2012' => '此appkey今天的广播数已超过3次',
	    '2013' => '消息还在排队，请稍候再查询',
	    '2014' => '消息取消失败，请稍候再试',
	    '2015' => 'device_tokens个数已超过50',
	    '2016' => '请填写filter',
	    '2017' => '添加tag失败',
	    '2018' => '请填写file_id',
	    '2019' => '与此file_id对应的文件不存在',
	    '2020' => '服务正在升级中，请稍候再试',
	    '2021' => 'appkey不存在',
	    '2022' => 'payload长度过长',
	    '2023' => '文件上传失败，请重试',
	    '2024' => '限速值必须为正整数',
	    '2025' => 'aps字段不能为空',
	    '2026' => '1分钟内发送任务次数超出3次',
	    '2027' => '签名不正确',
	    '2028' => '时间戳已过期',
	    '2029' => 'content内容不能为空',
	    '2030' => 'launch_from/not_launch_from条件中的日期须小于发送日期',
	    '2031' => 'filter格式不正确',
	    '2032' => '未上传生产证书，请到Web后台上传',
	    '2033' => '未上传开发证书，请到Web后台上传',
	    '2034' => '证书已过期',
	    '2035' => '定时任务证书过期',
	    '2036' => '时间戳格式错误',
	    '3000' => '数据库错误',
	    '3001' => '数据库错误',
	    '3002' => '数据库错误',
	    '3003' => '数据库错误',
	    '3004' => '数据库错误',
	    '4000' => '系统错误',
	    '4001' => '系统忙',
	    '4002' => '操作失败',
	    '4003' => 'appkey格式错误',
	    '4004' => '消息类型格式错误',
	    '4005' => 'msg格式错误',
	    '4006' => 'body格式错误',
	    '4007' => 'deliverPolicy格式错误',
	    '4008' => '失效时间格式错误',
	    '4009' => '单个服务器队列已满',
	    '4010' => '设备号格式错误',
	    '4011' => '消息扩展字段无效',
	    '4012' => '没有权限访问',
	    '4013' => '异步发送消息失败',
	    '4014' => 'appkey和device_tokens不对应',
	    '4015' => '没有找到应用信息',
	    '4016' => '文件编码有误',
	    '4017' => '文件类型有误',
	    '4018' => '文件远程地址有误',
	    '4019' => '文件描述信息有误',
	    '4020' => 'device_token有误(注意，android的device_token是严格的44位字符串)',
	    '4021' => 'HSF异步服务超时',
	    '4022' => 'appkey已经注册',
	    '4023' => '服务器网络异常',
	    '4024' => '非法访问',
	    '4025' => 'device-token全部失败',
	    '4026' => 'device-token部分失败',
	    '4027' => '拉取文件失败',
	    '5000' => 'device_token错误',
	    '5001' => '证书不存在',
	    '5002' => 'p,d是umeng保留字段',
	    '5003' => 'alert字段不能为空',
	    '5004' => 'alert只能是String类型',
	    '5005' => 'device_token格式错误',
	    '5006' => '创建socket错误',
	    '5007' => 'certificate_revoked错误',
	    '5008' => 'certificate_unkown错误',
	    '5009' => 'handshake_failure错误'
	);

	public function __construct() {

	}

	public function setAppMasterSecret($secret) {
		$this->appMasterSecret = $secret;
	}
	
	//return TRUE if it's complete, otherwise throw exception with details
	public function isComplete() {
		if (is_null($this->appMasterSecret)) {
			throw new Exception("Please set your app master secret for generating the signature!");
		}
		$this->checkArrayValues($this->data);
		return TRUE;
	}

	private function checkArrayValues($arr) {
		foreach ($arr as $key => $value) {
			if (is_null($value)) {
				throw new Exception($key . " is NULL!");
			} else if (is_array($value)) {
				$this->checkArrayValues($value);
			}
		}
	}

	// Set key/value for $data array, for the keys which can be set please see $DATA_KEYS, $PAYLOAD_KEYS, $BODY_KEYS, $POLICY_KEYS
	abstract function setPredefinedKeyValue($key, $value);

	//send the notification to umeng, return response data if SUCCESS , otherwise throw Exception with details.
	public function send() {
		//check the fields to make sure that they are not NULL
    	$this->isComplete();

        $url = $this->host . $this->postPath;
        $postBody = json_encode($this->data);
        $sign = md5("POST" . $url . $postBody . $this->appMasterSecret);
        $url = $url . "?sign=" . $sign;
  		$ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postBody );
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlErrNo = curl_errno($ch);
        $curlErr = curl_error($ch);
        curl_close($ch);
        // print($result . "\r\n");
        if ($httpCode == "0") {
          	 // Time out
           	throw new Exception("Curl error number:" . $curlErrNo . " , Curl error details:" . $curlErr . "\r\n");
        } else if ($httpCode != "200") {
           	// We did send the notifition out and got a non-200 response
           	$result_data = json_decode($result, true);
           	if ($result_data['ret'] == 'FAIL') {
           	    $error_code = $result_data['data']['error_code'];
           	    $error_message = isset($this->ERROR_CODES[$error_code]) ? $this->ERROR_CODES[$error_code] : '未知错误';
           	    throw new Exception($error_message, $error_code);
           	} else {
           	    throw new Exception("Http code:" . $httpCode .  " details:" . $result . "\r\n");
           	}
        } else {
           	return $result;
        }
    }
}

// end