<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 更新商品销量
 * @author huangyuyuan@ecmoban.com
 *
 */
class goods_update_goods_sales_api extends Component_Event_Api {
	
    //确认收货后更新销量
	public function call(&$options) {
	    
	    if (empty($options['order_id'])) {
	        return new ecjia_error('invalid_parameter', '参数无效');
	    }
	    
	    $goods_list = RC_DB::table('order_goods')->where('order_id', $options['order_id'])->get();
	    
	    foreach ($goods_list as $goods) {
	        update_sales($goods['goods_id'], $goods['goods_number']);
	    }
	    return true;
	}
	
}

function update_sales($goods_id, $goods_number) {
    if (RC_DB::table('goods')->where('goods_id', $goods_id)->increment('sales_volume', $goods_number)){
        return true;
    } else {
        RC_Logger::getLogger('error')->info('销量更新失败，goods_id:'.$goods_id.',goods_number:'.$goods_number);
    }
}

// end