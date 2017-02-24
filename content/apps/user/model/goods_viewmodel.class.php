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

class goods_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'goods';
		$this->table_alias_name = 'g';
		$this->view = array(
				'auto_manage' => array(
						'type' 	   => Component_Model_View::TYPE_LEFT_JOIN,
						'alias'	   => 'a',
						'field'	   => 'g.*,a.starttime,a.endtime',
						'on'	   => "g.goods_id = a.item_id AND a.type='goods'"
				),
				'category' => array(
						'type'     => Component_Model_View::TYPE_LEFT_JOIN,
						'alias'    => 'c',
						'field'    => "g.*, c.measure_unit, b.brand_id, b.brand_name AS goods_brand, m.type_money AS bonus_money,IFNULL(AVG(r.comment_rank), 0) AS comment_rank,IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS rank_price",
						'on'       => 'g.cat_id = c.cat_id'
				),
				'brand' => array(
						'type'     => Component_Model_View::TYPE_LEFT_JOIN,
						'alias'    => 'b',
						'on'       => 'g.brand_id = b.brand_id '
				),
				'comment' => array(
						'type'     => Component_Model_View::TYPE_LEFT_JOIN,
						'alias'    => 'r',
						'on'       => 'r.id_value = g.goods_id AND comment_type = 0 AND r.parent_id = 0 AND r.status = 1'
				),
				'bonus_type' => array(
						'type'     => Component_Model_View::TYPE_LEFT_JOIN,
						'alias'    => 'm',
						'on'       => 'g.bonus_type_id = m.type_id AND m.send_start_date <= "' . RC_Time::gmtime () . '" AND m.send_end_date >= "' . RC_Time::gmtime () . '"'
				),
				'goods_attr' => array (
    					'type'     => Component_Model_View::TYPE_LEFT_JOIN,
    					'alias'    => 'a',
    					'field'    => "g.goods_id, g.goods_name, g.goods_thumb, g.goods_img, g.shop_price AS org_price,IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price,g.market_price, g.promote_price, g.promote_start_date, g.promote_end_date",
    					'on'       => 'g.goods_id = a.goods_id' 
				),
				'member_price'   => array(
						'type'     => Component_Model_View::TYPE_LEFT_JOIN,
						'alias'    => 'mp',
						'on'       => 'mp.goods_id = g.goods_id AND mp.user_rank = "' . $_SESSION ['user_rank'] . '"'
				),
				'link_goods'   => array(
						'type'     => Component_Model_View::TYPE_RIGHT_JOIN,
						'alias'    => 'lg',
						'on'       => 'g.goods_id = lg.link_goods_id'
				),
		 		'package_goods' => array(
		 				'type'     => Component_Model_View::TYPE_RIGHT_JOIN,
		 				'alias'    => 'pg',
		 				'field'    => 'pg.goods_id, g.goods_name, (CASE WHEN pg.product_id > 0 THEN p.product_number ELSE g.goods_number END) AS goods_number, p.goods_attr, p.product_id, pg.goods_number AS order_goods_number, g.goods_sn, g.is_real, p.product_sn',
		 				'on'       => 'pg.goods_id = g.goods_id ',
		 		),
	    		'products' => array(
	    				'type'     => Component_Model_View::TYPE_LEFT_JOIN,
	    				'alias'    => 'p',
	    				'on'       => 'pg.product_id = p.product_id',
	    		),
				'collect_goods' => array(
						'type' 	   => Component_Model_View::TYPE_LEFT_JOIN,  
						'alias'	   => 'cg',
						'on' 	   => 'g.goods_id = cg.goods_id', 
				),
				'cart' => array(
						'type'     => Component_Model_View::TYPE_LEFT_JOIN,
						'alias'    => 'c',
						'on'       => 'g.goods_id =c.goods_id'
				)
		);
		parent::__construct();
	}
}

// end