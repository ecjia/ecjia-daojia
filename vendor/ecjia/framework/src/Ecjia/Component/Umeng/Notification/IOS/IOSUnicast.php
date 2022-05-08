<?php
namespace Ecjia\Component\Umeng\Notification\IOS;

use Ecjia\Component\Umeng\Notification\IOSNotification;

class IOSUnicast extends IOSNotification
{
	public function __construct()
    {
		parent::__construct();
		
		$this->data["type"] = "unicast";
		$this->data["device_tokens"] = NULL;
	}

}