<?php

namespace Ecjia\App\Cashier;

use RC_DB;
use RC_Time;
use ecjia;
use RC_Lang;


class CashierDevice
{
	//收银产品代号
	
	const CASHIERCODE 	= 8031;  //收银通
	const CASHDESKCODE 	= 8001;  //收银台
	const CASHPOSCODE 	= 8011;  //收银POS

	/**
	 * 获取收银设备类型
	 *
	 * @param string $device_code
	 * @return string
	 */
	public static function get_device_type($device_code) {
		if ($device_code == self::CASHIERCODE) {
			$device_type = 'ecjia-cashier'; //收银通
		} else {
			$device_type = 'ecjia-cashdesk'; //收银台，POS机
		}
		
		return $device_type;
	}
}