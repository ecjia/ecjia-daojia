<?php

namespace Ecjia\App\Goods;

use RC_DB;
use RC_Time;
use ecjia;
use RC_Lang;
use RC_Model;


class DeleteGoodsCacheManager
{


	/**
	 * 清除商品指定key的缓存
	 */
	public static function clear_goods_list_cache($cache_key) {
		$cache_key_id = sprintf('%X', crc32($cache_key));
		$orm_goods_db = \RC_Model::model('goods/orm_goods_model');
		$orm_goods_db->delete_cache_item($cache_key_id);
	}
    
	
}