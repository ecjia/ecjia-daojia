<?php

namespace Ecjia\App\Goods;

use RC_DB;
use RC_Time;
use ecjia;
use RC_Lang;


class BargainPrice
{


	/**
	 * 判断某个商品是否正在特价促销期
	 *
	 * @access public
	 * @param float $price
	 *        	促销价格
	 * @param string $start
	 *        	促销开始日期
	 * @param string $end
	 *        	促销结束日期
	 * @return float 如果还在促销期则返回促销价，否则返回0
	 */
	public static function bargain_price($price, $start, $end) {
		if ($price == 0) {
			return 0;
		} else {
			$time = RC_Time::gmtime ();
			if ($time >= $start && $time <= $end) {
				return $price;
			} else {
				return 0;
			}
		}
	}
    
	
}