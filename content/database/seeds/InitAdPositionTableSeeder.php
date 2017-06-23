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
/**
 * 插入数据 `ecjia_ad_position` 广告位
 */
use Royalcms\Component\Database\Seeder;

class InitAdPositionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
        	array(
        		'position_id'     => '97',
        	    'position_name'   => '美食节',
        	    'position_code'   => 'home_ad_5',
        	    'ad_width'        => '100',
        	    'ad_height'       => '50',
        	    'position_desc'   => '吃货复苏季',
        	    'max_number'      => '5',
        	    'city_id'         => '0',
        	    'city_name'       => '默认',
        	    'type'            => 'adsense',
        	    'group_id'        => '120',
        	    'sort_order'      => '1',
        	),
        	array(
        		'position_id'     => '98',
        	    'position_name'   => '满减满送',
        	    'position_code'   => 'home_ad_4',
        	    'ad_width'        => '100',
        	    'ad_height'       => '50',
        	    'position_desc'   => '狂欢大促',
        	    'max_number'      => '5',
        	    'city_id'         => '0',
        	    'city_name'       => '默认',
        	    'type'            => 'adsense',
        	    'group_id'        => '120',
        	    'sort_order'      => '0',
        	),
        	array(
        		'position_id'     => '102',
        	    'position_name'   => '应用启动广告位',
        	    'position_code'   => 'app_start_adsense',
        	    'ad_width'        => '100',
        	    'ad_height'       => '50',
        	    'position_desc'   => '开机广告位',
        	    'max_number'      => '5',
        	    'city_id'         => '0',
        	    'city_name'       => '默认',
        	    'type'            => 'adsense',
        	    'group_id'        => '0',
        	    'sort_order'      => '50',
        	),
        	array(
        		'position_id'     => '106',
        	    'position_name'   => '水果蔬菜分类广告位',
        	    'position_code'   => 'category_ad_1',
        	    'ad_width'        => '100',
        	    'ad_height'       => '100',
        	    'position_desc'   => '顶级分类广告1',
        	    'max_number'      => '5',
        	    'city_id'         => '0',
        	    'city_name'       => '默认',
        	    'type'            => 'adsense',
        	    'group_id'        => '0',
        	    'sort_order'      => '50',
        	),
        	array(
        		'position_id'     => '107',
        	    'position_name'   => '肉禽蛋奶分类广告位',
        	    'position_code'   => 'category_ad_2',
        	    'ad_width'        => '100',
        	    'ad_height'       => '100',
        	    'position_desc'   => '顶级分类广告2',
        	    'max_number'      => '5',
        	    'city_id'         => '0',
        	    'city_name'       => '默认',
        	    'type'            => 'adsense',
        	    'group_id'        => '0',
        	    'sort_order'      => '50',
        	),
        	array(
        		'position_id'     => '108',
        	    'position_name'   => '冷热速食分类广告位',
        	    'position_code'   => 'category_ad_3',
        	    'ad_width'        => '100',
        	    'ad_height'       => '100',
        	    'position_desc'   => '顶级分类广告3',
        	    'max_number'      => '5',
        	    'city_id'         => '0',
        	    'city_name'       => '默认',
        	    'type'            => 'adsense',
        	    'group_id'        => '0',
        	    'sort_order'      => '50',
        	),
        	array(
        		'position_id'     => '109',
        	    'position_name'   => '休闲食品分类广告位',
        	    'position_code'   => 'category_ad_4',
        	    'ad_width'        => '100',
        	    'ad_height'       => '100',
        	    'position_desc'   => '顶级分类广告4',
        	    'max_number'      => '5',
        	    'city_id'         => '0',
        	    'city_name'       => '默认',
        	    'type'            => 'adsense',
        	    'group_id'        => '0',
        	    'sort_order'      => '50',
        	),
        	array(
        		'position_id'     => '110',
        	    'position_name'   => '酒水饮料分类广告位',
        	    'position_code'   => 'category_ad_5',
        	    'ad_width'        => '100',
        	    'ad_height'       => '100',
        	    'position_desc'   => '顶级分类广告5',
        	    'max_number'      => '5',
        	    'city_id'         => '0',
        	    'city_name'       => '默认',
        	    'type'            => 'adsense',
        	    'group_id'        => '0',
        	    'sort_order'      => '50',
        	),
        	array(
        		'position_id'     => '111',
        	    'position_name'   => '粮油调味分类广告位',
        	    'position_code'   => 'category_ad_6',
        	    'ad_width'        => '100',
        	    'ad_height'       => '100',
        	    'position_desc'   => '顶级分类广告6',
        	    'max_number'      => '5',
        	    'city_id'         => '0',
        	    'city_name'       => '默认',
        	    'type'            => 'adsense',
        	    'group_id'        => '0',
        	    'sort_order'      => '50',
        	),
        	array(
        		'position_id'     => '112',
        	    'position_name'   => '清洁日化分类广告位',
        	    'position_code'   => 'category_ad_7',
        	    'ad_width'        => '100',
        	    'ad_height'       => '100',
        	    'position_desc'   => '顶级分类广告7',
        	    'max_number'      => '5',
        	    'city_id'         => '0',
        	    'city_name'       => '默认',
        	    'type'            => 'adsense',
        	    'group_id'        => '0',
        	    'sort_order'      => '50',
        	),
        	array(
        		'position_id'     => '113',
        	    'position_name'   => '家居用品分类广告位',
        	    'position_code'   => 'category_ad_8',
        	    'ad_width'        => '100',
        	    'ad_height'       => '100',
        	    'position_desc'   => '顶级分类广告8',
        	    'max_number'      => '5',
        	    'city_id'         => '0',
        	    'city_name'       => '默认',
        	    'type'            => 'adsense',
        	    'group_id'        => '0',
        	    'sort_order'      => '50',
        	),
        	array(
        		'position_id'     => '114',
        	    'position_name'   => '鲜花蛋糕分类广告位',
        	    'position_code'   => 'category_ad_9',
        	    'ad_width'        => '100',
        	    'ad_height'       => '100',
        	    'position_desc'   => '顶级分类广告9',
        	    'max_number'      => '5',
        	    'city_id'         => '0',
        	    'city_name'       => '默认',
        	    'type'            => 'adsense',
        	    'group_id'        => '0',
        	    'sort_order'      => '50',
        	),
        	array(
        		'position_id'     => '115',
        	    'position_name'   => '医药健康分类广告位',
        	    'position_code'   => 'category_ad_10',
        	    'ad_width'        => '100',
        	    'ad_height'       => '100',
        	    'position_desc'   => '顶级分类广告10',
        	    'max_number'      => '5',
        	    'city_id'         => '0',
        	    'city_name'       => '默认',
        	    'type'            => 'adsense',
        	    'group_id'        => '0',
        	    'sort_order'      => '50',
        	),
        	array(
        		'position_id'     => '116',
        	    'position_name'   => '首页轮播图',
        	    'position_code'   => 'home_cycleimage',
        	    'ad_width'        => '1000',
        	    'ad_height'       => '400',
        	    'position_desc'   => '',
        	    'max_number'      => '5',
        	    'city_id'         => '0',
        	    'city_name'       => '默认',
        	    'type'            => 'cycleimage',
        	    'group_id'        => '0',
        	    'sort_order'      => '1',
        	),
        	array(
        		'position_id'     => '118',
        	    'position_name'   => '商家轮播图',
        	    'position_code'   => 'merchant_cycleimage',
        	    'ad_width'        => '1920',
        	    'ad_height'       => '420',
        	    'position_desc'   => '',
        	    'max_number'      => '1',
        	    'city_id'         => '0',
        	    'city_name'       => '默认',
        	    'type'            => 'cycleimage',
        	    'group_id'        => '0',
        	    'sort_order'      => '50',
        	),
        	array(
        		'position_id'     => '120',
        	    'position_name'   => '首页多组广告位',
        	    'position_code'   => 'home_complex_adsense',
        	    'ad_width'        => '0',
        	    'ad_height'       => '0',
        	    'position_desc'   => 'App、H5首页上使用的多广告位合成效果。',
        	    'max_number'      => '5',
        	    'city_id'         => '0',
        	    'city_name'       => '默认',
        	    'type'            => 'group',
        	    'group_id'        => '0',
        	    'sort_order'      => '50',
        	),
        	array(
        		'position_id'     => '122',
        	    'position_name'   => '首页快捷菜单',
        	    'position_code'   => 'home_shortcut',
        	    'ad_width'        => '200',
        	    'ad_height'       => '200',
        	    'position_desc'   => '',
        	    'max_number'      => '10',
        	    'city_id'         => '0',
        	    'city_name'       => '默认',
        	    'type'            => 'shortcut',
        	    'group_id'        => '0',
        	    'sort_order'      => '1',
        	),
        	array(
        		'position_id'     => '123',
        	    'position_name'   => '百宝箱',
        	    'position_code'   => 'discover',
        	    'ad_width'        => '200',
        	    'ad_height'       => '200',
        	    'position_desc'   => '',
        	    'max_number'      => '20',
        	    'city_id'         => '0',
        	    'city_name'       => '默认',
        	    'type'            => 'shortcut',
        	    'group_id'        => '0',
        	    'sort_order'      => '50',
        	),
            array(
                'position_id'     => '124',
                'position_name'   => '发现轮播图',
                'position_code'   => 'article_cycleimage',
                'ad_width'        => '1000',
                'ad_height'       => '200',
                'position_desc'   => '发现页面的轮播图',
                'max_number'      => '5',
                'city_id'         => '0',
                'city_name'       => '默认',
                'type'            => 'cycleimage',
                'group_id'        => '0',
                'sort_order'      => '50',
            )
        );
        
        RC_DB::table('ad_position')->truncate();
        RC_DB::table('ad_position')->insert($data);
    }
}