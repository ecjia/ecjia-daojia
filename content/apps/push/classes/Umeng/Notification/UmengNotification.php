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
namespace Ecjia\App\Push\Umeng\Notification;

use Exception;

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

	protected $DATA_KEYS    = array("appkey", "timestamp", "type", "device_tokens", "alias", "alias_type", "file_id", "filter", "production_mode",
								    "feedback", "description", "thirdparty_id");
	protected $POLICY_KEYS  = array("start_time", "expire_time", "max_send_num");

	function __construct() {

	}

	function setAppMasterSecret($secret) {
		$this->appMasterSecret = $secret;
	}
	
	//return TRUE if it's complete, otherwise throw exception with details
	function isComplete() {
		if (is_null($this->appMasterSecret))
			throw new Exception("Please set your app master secret for generating the signature!");
		$this->checkArrayValues($this->data);
		return TRUE;
	}

	private function checkArrayValues($arr) {
		foreach ($arr as $key => $value) {
			if (is_null($value))
				throw new Exception($key . " is NULL!");
			else if (is_array($value)) {
				$this->checkArrayValues($value);
			}
		}
	}

	// Set key/value for $data array, for the keys which can be set please see $DATA_KEYS, $PAYLOAD_KEYS, $BODY_KEYS, $POLICY_KEYS
	abstract function setPredefinedKeyValue($key, $value);

	//send the notification to umeng, return response data if SUCCESS , otherwise throw Exception with details.
	function send() {
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
           	throw new Exception("Http code:" . $httpCode .  " details:" . $result . "\r\n");
        } else {
           	return $result;
        }
    }
	
}