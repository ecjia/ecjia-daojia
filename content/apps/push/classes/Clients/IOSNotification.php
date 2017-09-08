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
namespace Ecjia\App\Push\Clients;

use Ecjia\App\Push\NotificationAbstract;
use Ecjia\App\Push\Umeng\Notification\IOS\IOSBroadcast;
use Ecjia\App\Push\Umeng\Notification\IOS\IOSUnicast;
use Ecjia\App\Push\Umeng\Notification\IOS\IOSFilecast;
use Ecjia\App\Push\Umeng\Notification\IOS\IOSGroupcast;
use Ecjia\App\Push\Umeng\Notification\IOS\IOSCustomizedcast;
use Exception;
use ecjia_error;

/**
 * 消息推送通知管理类
 * @author royalwang
 */
class IOSNotification extends NotificationAbstract
{
    
    protected $code = 'iphone';
    
	/**
	 * 发送iOS广播消息
	 */
	public function sendBroadcast() {
		try {
			$brocast = new IOSBroadcast();
			$brocast->setAppMasterSecret($this->appMasterSecret);
			$brocast->setPredefinedKeyValue("appkey",           $this->appKey);
			$brocast->setPredefinedKeyValue("timestamp",        $this->timestamp);

			$brocast->setPredefinedKeyValue("description",      $this->push_description);
			$brocast->setPredefinedKeyValue("alert",            $this->push_content);
			$brocast->setPredefinedKeyValue("badge", 1);
			$brocast->setPredefinedKeyValue("sound", "chime");
			// Set 'production_mode' to 'true' if your app is under production mode
			if ($this->debug) {
			    $brocast->setPredefinedKeyValue("production_mode", "false");
			} else {
			    $brocast->setPredefinedKeyValue("production_mode", "true");
			}
			// Set customized fields
			if (is_array($this->custom_fields)) {
			    foreach ($this->custom_fields as $key => $value) {
			        $brocast->setCustomizedField($key, $value);
			    }
			}
			return $brocast->send();
		} catch (Exception $e) {
			return new ecjia_error('send_ios_broadcast_error', $e->getMessage());
		}
	}

	/**
	 * 发送iOS单播消息
	 */
	public function sendUnicast() {
		try {
			$unicast = new IOSUnicast();
			$unicast->setAppMasterSecret($this->appMasterSecret);
			$unicast->setPredefinedKeyValue("appkey",           $this->appKey);
			$unicast->setPredefinedKeyValue("timestamp",        $this->timestamp);
			// Set your device tokens here
			if ($this->device_tokens) {
			    // Set your device tokens here
			    $unicast->setPredefinedKeyValue("device_tokens", implode(',', $this->device_tokens));
			}

			$unicast->setPredefinedKeyValue("description",      $this->push_description);
			$unicast->setPredefinedKeyValue("alert",            $this->push_content);
			$unicast->setPredefinedKeyValue("badge", 1);
			$unicast->setPredefinedKeyValue("sound", "chime");
			// Set 'production_mode' to 'true' if your app is under production mode
		    if ($this->debug) {
			    $unicast->setPredefinedKeyValue("production_mode", "false");
			} else {
			    $unicast->setPredefinedKeyValue("production_mode", "true");
			}
			// Set customized fields
		    if (is_array($this->custom_fields)) {
			    foreach ($this->custom_fields as $key => $value) {
			        $unicast->setCustomizedField($key, $value);
			    }
			}
			return $unicast->send();
		} catch (Exception $e) {
			return new ecjia_error('send_ios_unicast_error', $e->getMessage());
		}
	}

	/**
	 * 发送iOS文件广播
	 */
	public function sendFilecast() {
		try {
			$filecast = new IOSFilecast();
			$filecast->setAppMasterSecret($this->appMasterSecret);
			$filecast->setPredefinedKeyValue("appkey",           $this->appKey);
			$filecast->setPredefinedKeyValue("timestamp",        $this->timestamp);

			$filecast->setPredefinedKeyValue("alert", "IOS 文件播测试");
			$filecast->setPredefinedKeyValue("badge", 0);
			$filecast->setPredefinedKeyValue("sound", "chime");
			// Set 'production_mode' to 'true' if your app is under production mode
			$filecast->setPredefinedKeyValue("production_mode", "false");
			print("Uploading file contents, please wait...\r\n");
			// Upload your device tokens, and use '\n' to split them if there are multiple tokens
			$filecast->uploadContents("aa"."\n"."bb");
			print("Sending filecast notification, please wait...\r\n");
			$filecast->send();
			print("Sent SUCCESS\r\n");
		} catch (Exception $e) {
			return new ecjia_error('send_ios_filecast_error', $e->getMessage());
		}
	}

	/**
	 * 发送iOS群组广播
	 */
	public function sendGroupcast() {
		try {
			/* 
		 	 *  Construct the filter condition:
		 	 *  "where": 
		 	 *	{
    	 	 *		"and": 
    	 	 *		[
      	 	 *			{"tag":"iostest"}
    	 	 *		]
		 	 *	}
		 	 */
			$filter = 	array(
				"where" => array(
		    		"and" => array(
	    				array(
     						"tag" => "iostest"
						)
		     		)
		   		)
		  	);
					  
			$groupcast = new IOSGroupcast();
			$groupcast->setAppMasterSecret($this->appMasterSecret);
			$groupcast->setPredefinedKeyValue("appkey",           $this->appKey);
			$groupcast->setPredefinedKeyValue("timestamp",        $this->timestamp);
			// Set the filter condition
			$groupcast->setPredefinedKeyValue("filter",           $filter);
			$groupcast->setPredefinedKeyValue("alert", "IOS 组播测试");
			$groupcast->setPredefinedKeyValue("badge", 0);
			$groupcast->setPredefinedKeyValue("sound", "chime");
			// Set 'production_mode' to 'true' if your app is under production mode
			$groupcast->setPredefinedKeyValue("production_mode", "false");
			print("Sending groupcast notification, please wait...\r\n");
			$groupcast->send();
			print("Sent SUCCESS\r\n");
		} catch (Exception $e) {
			return new ecjia_error('send_ios_groupcast_error', $e->getMessage());
		}
	}

	/**
	 * 发送iOS消息自定义接受范围
	 */
	public function sendCustomizedcast() {
		try {
			$customizedcast = new IOSCustomizedcast();
			$customizedcast->setAppMasterSecret($this->appMasterSecret);
			$customizedcast->setPredefinedKeyValue("appkey",           $this->appKey);
			$customizedcast->setPredefinedKeyValue("timestamp",        $this->timestamp);

			// Set your alias here, and use comma to split them if there are multiple alias.
			// And if you have many alias, you can also upload a file containing these alias, then 
			// use file_id to send customized notification.
			$customizedcast->setPredefinedKeyValue("alias", "xx");
			// Set your alias_type here
			$customizedcast->setPredefinedKeyValue("alias_type", "xx");
			$customizedcast->setPredefinedKeyValue("alert", "IOS 个性化测试");
			$customizedcast->setPredefinedKeyValue("badge", 0);
			$customizedcast->setPredefinedKeyValue("sound", "chime");
			// Set 'production_mode' to 'true' if your app is under production mode
			$customizedcast->setPredefinedKeyValue("production_mode", "false");
			print("Sending customizedcast notification, please wait...\r\n");
			$customizedcast->send();
			print("Sent SUCCESS\r\n");
		} catch (Exception $e) {
			return new ecjia_error('send_ios_customizedcast_error', $e->getMessage());
		}
	}

}

// end