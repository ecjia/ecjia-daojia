<?php
defined('IN_ECJIA') or exit('No permission resources.');

return array(
    'apps' => array(
        /* 商户 */
        'merchant' => 'merchant',
        /* 员工 */
        'staff' => 'staff',
    	/*验证码  */
    	'captcha' => 'captcha',
        /* 商品 */
        'goods' => 'goods',
        /* 订单 */
        'orders' => 'orders',
        /* 促销 */
        'promotion' => 'promotion',
        /* 红包 */
        'bonus' => 'bonus',
        /* 优惠活动 */
        'favourable' => 'favourable',
        /* 团购活动 */
        'groupbuy' => 'groupbuy',
        /* 超值礼包活动 */
        'package' => 'package',
        /* 结算 */
        'commission' => 'commission',
        /* 报表统计*/
        'stats' => 'stats',
    	/*我的配送  */
    	'shipping' => 'shipping',
    	/*店铺向导  */
    	'shopguide' => 'shopguide',
    	'express'	=> 'express',
    ),
);