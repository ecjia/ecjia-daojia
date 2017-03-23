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
use Royalcms\Component\Database\Migrations\Migration;

class InsertConfigStructureToShopConfigTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    $data = array(
	        array(
	            'id'            => '1',
	            'parent_id'     => '0',
	            'code'          => 'shop_info',
	            'type'          => 'group',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '2',
	            'parent_id'     => '0',
	            'code'          => 'basic',
	            'type'          => 'group',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '3',
	            'parent_id'     => '0',
	            'code'          => 'display',
	            'type'          => 'group',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '4',
	            'parent_id'     => '0',
	            'code'          => 'shopping_flow',
	            'type'          => 'group',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '5',
	            'parent_id'     => '0',
	            'code'          => 'smtp',
	            'type'          => 'group',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '6',
	            'parent_id'     => '0',
	            'code'          => 'hidden',
	            'type'          => 'hidden',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '7',
	            'parent_id'     => '0',
	            'code'          => 'goods',
	            'type'          => 'group',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '8',
	            'parent_id'     => '0',
	            'code'          => 'sms',
	            'type'          => 'group',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '9',
	            'parent_id'     => '0',
	            'code'          => 'wap',
	            'type'          => 'group',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '10',
	            'parent_id'     => '0',
	            'code'          => 'mobile',
	            'type'          => 'group',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '101',
	            'parent_id'     => '1',
	            'code'          => 'shop_name',
	            'type'          => 'text',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '102',
	            'parent_id'     => '1',
	            'code'          => 'shop_title',
	            'type'          => 'text',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '103',
	            'parent_id'     => '1',
	            'code'          => 'shop_desc',
	            'type'          => 'text',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '104',
	            'parent_id'     => '1',
	            'code'          => 'shop_keywords',
	            'type'          => 'text',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '105',
	            'parent_id'     => '1',
	            'code'          => 'shop_country',
	            'type'          => 'manual',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '106',
	            'parent_id'     => '1',
	            'code'          => 'shop_province',
	            'type'          => 'manual',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '107',
	            'parent_id'     => '1',
	            'code'          => 'shop_city',
	            'type'          => 'manual',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '108',
	            'parent_id'     => '1',
	            'code'          => 'shop_address',
	            'type'          => 'text',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '109',
	            'parent_id'     => '1',
	            'code'          => 'qq',
	            'type'          => 'text',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '110',
	            'parent_id'     => '1',
	            'code'          => 'ww',
	            'type'          => 'text',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '111',
	            'parent_id'     => '1',
	            'code'          => 'skype',
	            'type'          => 'text',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '112',
	            'parent_id'     => '1',
	            'code'          => 'ym',
	            'type'          => 'text',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '113',
	            'parent_id'     => '1',
	            'code'          => 'msn',
	            'type'          => 'text',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '114',
	            'parent_id'     => '1',
	            'code'          => 'service_email',
	            'type'          => 'text',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '115',
	            'parent_id'     => '1',
	            'code'          => 'service_phone',
	            'type'          => 'text',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '116',
	            'parent_id'     => '1',
	            'code'          => 'shop_closed',
	            'type'          => 'select',
	            'store_range'   => '0,1',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '117',
	            'parent_id'     => '1',
	            'code'          => 'close_comment',
	            'type'          => 'textarea',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '118',
	            'parent_id'     => '1',
	            'code'          => 'shop_logo',
	            'type'          => 'file',
	            'store_range'   => '',
	            'store_dir'     => 'content/themes/{$template}/images/',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '119',
	            'parent_id'     => '1',
	            'code'          => 'licensed',
	            'type'          => 'select',
	            'store_range'   => '0,1',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '120',
	            'parent_id'     => '1',
	            'code'          => 'user_notice',
	            'type'          => 'textarea',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '121',
	            'parent_id'     => '1',
	            'code'          => 'shop_notice',
	            'type'          => 'textarea',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '122',
	            'parent_id'     => '1',
	            'code'          => 'shop_reg_closed',
	            'type'          => 'select',
	            'store_range'   => '1,0',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '123',
	            'parent_id'     => '1',
	            'code'          => 'company_name',
	            'type'          => 'text',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '124',
	            'parent_id'     => '1',
	            'code'          => 'shop_weibo_url',
	            'type'          => 'text',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '125',
	            'parent_id'     => '1',
	            'code'          => 'shop_wechat_qrcode',
	            'type'          => 'file',
	            'store_range'   => '',
	            'store_dir'     => 'data/assets/',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '201',
	            'parent_id'     => '2',
	            'code'          => 'lang',
	            'type'          => 'manual',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '202',
	            'parent_id'     => '2',
	            'code'          => 'icp_number',
	            'type'          => 'text',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '203',
	            'parent_id'     => '2',
	            'code'          => 'icp_file',
	            'type'          => 'file',
	            'store_range'   => '',
	            'store_dir'     => 'data/cert/',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '204',
	            'parent_id'     => '2',
	            'code'          => 'watermark',
	            'type'          => 'file',
	            'store_range'   => '',
	            'store_dir'     => 'data/assets/',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '205',
	            'parent_id'     => '2',
	            'code'          => 'watermark_place',
	            'type'          => 'select',
	            'store_range'   => '0,1,2,3,4,5',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '206',
	            'parent_id'     => '2',
	            'code'          => 'watermark_alpha',
	            'type'          => 'text',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '207',
	            'parent_id'     => '2',
	            'code'          => 'use_storage',
	            'type'          => 'select',
	            'store_range'   => '1,0',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '208',
	            'parent_id'     => '2',
	            'code'          => 'market_price_rate',
	            'type'          => 'text',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '209',
	            'parent_id'     => '2',
	            'code'          => 'rewrite',
	            'type'          => 'select',
	            'store_range'   => '0,1,2',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '210',
	            'parent_id'     => '2',
	            'code'          => 'integral_name',
	            'type'          => 'text',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '211',
	            'parent_id'     => '2',
	            'code'          => 'integral_scale',
	            'type'          => 'text',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '212',
	            'parent_id'     => '2',
	            'code'          => 'integral_percent',
	            'type'          => 'text',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '213',
	            'parent_id'     => '2',
	            'code'          => 'sn_prefix',
	            'type'          => 'text',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '214',
	            'parent_id'     => '2',
	            'code'          => 'comment_check',
	            'type'          => 'select',
	            'store_range'   => '0,1',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '215',
	            'parent_id'     => '2',
	            'code'          => 'no_picture',
	            'type'          => 'file',
	            'store_range'   => '',
	            'store_dir'     => 'data/assets/',
	            'sort_order'    => '1'
	        ),array(
	            'id' =>          '218',
	            'parent_id'     => '2',
	            'code'          => 'stats_code',
	            'type'          => 'textarea',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '219',
	            'parent_id'     => '2',
	            'code'          => 'cache_time',
	            'type'          => 'text',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '220',
	            'parent_id'     => '2',
	            'code'          => 'register_points',
	            'type'          => 'text',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '221',
	            'parent_id'     => '2',
	            'code'          => 'enable_gzip',
	            'type'          => 'select',
	            'store_range'   => '0,1',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '222',
	            'parent_id'     => '2',
	            'code'          => 'top10_time',
	            'type'          => 'select',
	            'store_range'   => '0,1,2,3,4',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '223',
	            'parent_id'     => '2',
	            'code'          => 'timezone',
	            'type'          => 'options',
	            'store_range'   => '-12,-11,-10,-9,-8,-7,-6,-5,-4,-3.5,-3,-2,-1,0,1,2,3,3.5,4,4.5,5,5.5,5.75,6,6.5,7,8,9,9.5,10,11,12',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '224',
	            'parent_id'     => '2',
	            'code'          => 'upload_size_limit',
	            'type'          => 'options',
	            'store_range'   => '-1,0,64,128,256,512,1024,2048,4096',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '226',
	            'parent_id'     => '2',
	            'code'          => 'cron_method',
	            'type'          => 'select',
	            'store_range'   => '0,1',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '227',
	            'parent_id'     => '2',
	            'code'          => 'comment_factor',
	            'type'          => 'select',
	            'store_range'   => '0,1,2,3',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '228',
	            'parent_id'     => '2',
	            'code'          => 'enable_order_check',
	            'type'          => 'select',
	            'store_range'   => '0,1',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '229',
	            'parent_id'     => '2',
	            'code'          => 'default_storage',
	            'type'          => 'text',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '230',
	            'parent_id'     => '2',
	            'code'          => 'bgcolor',
	            'type'          => 'text',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '231',
	            'parent_id'     => '2',
	            'code'          => 'visit_stats',
	            'type'          => 'select',
	            'store_range'   => 'on,off',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '232',
	            'parent_id'     => '2',
	            'code'          => 'send_mail_on',
	            'type'          => 'select',
	            'store_range'   => 'on,off',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '233',
	            'parent_id'     => '2',
	            'code'          => 'auto_generate_gallery',
	            'type'          => 'select',
	            'store_range'   => '1,0',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '234',
	            'parent_id'     => '2',
	            'code'          => 'retain_original_img',
	            'type'          => 'select',
	            'store_range'   => '1,0',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '235',
	            'parent_id'     => '2',
	            'code'          => 'member_email_validate',
	            'type'          => 'select',
	            'store_range'   => '1,0',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '236',
	            'parent_id'     => '2',
	            'code'          => 'message_board',
	            'type'          => 'select',
	            'store_range'   => '1,0',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '239',
	            'parent_id'     => '2',
	            'code'          => 'certificate_id',
	            'type'          => 'hidden',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '240',
	            'parent_id'     => '2',
	            'code'          => 'token',
	            'type'          => 'hidden',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '241',
	            'parent_id'     => '2',
	            'code'          => 'certi',
	            'type'          => 'hidden',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '242',
	            'parent_id'     => '2',
	            'code'          => 'send_verify_email',
	            'type'          => 'select',
	            'store_range'   => '1,0',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '243',
	            'parent_id'     => '2',
	            'code'          => 'ent_id',
	            'type'          => 'hidden',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '244',
	            'parent_id'     => '2',
	            'code'          => 'ent_ac',
	            'type'          => 'hidden',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '245',
	            'parent_id'     => '2',
	            'code'          => 'ent_sign',
	            'type'          => 'hidden',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '246',
	            'parent_id'     => '2',
	            'code'          => 'ent_email',
	            'type'          => 'hidden',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '301',
	            'parent_id'     => '3',
	            'code'          => 'date_format',
	            'type'          => 'hidden',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1'
	        ),
	        array(
	            'id'            => '302',
	            'parent_id'     => '3',
	            'code'          => 'time_format',
	            'type'          => 'text',
	            'store_range'   => '',
	            'store_dir'     => '',
	            'sort_order'    => '1',
            ),
            array(
                'id'            => '303',
                'parent_id'     => '3',
                'code'          => 'currency_format',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '304',
                'parent_id'     => '3',
                'code'          => 'thumb_width',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '305',
                'parent_id'     => '3',
                'code'          => 'thumb_height',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '306',
                'parent_id'     => '3',
                'code'          => 'image_width',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '307',
                'parent_id'     => '3',
                'code'          => 'image_height',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '312',
                'parent_id'     => '3',
                'code'          => 'top_number',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '313',
                'parent_id'     => '3',
                'code'          => 'history_number',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '314',
                'parent_id'     => '3',
                'code'          => 'comments_number',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '315',
                'parent_id'     => '3',
                'code'          => 'bought_goods',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '316',
                'parent_id'     => '3',
                'code'          => 'article_number',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '317',
                'parent_id'     => '3',
                'code'          => 'goods_name_length',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '318',
                'parent_id'     => '3',
                'code'          => 'price_format',
                'type'          => 'select',
                'store_range'   => '0,1,2,3,4,5',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '319',
                'parent_id'     => '3',
                'code'          => 'page_size',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '320',
                'parent_id'     => '3',
                'code'          => 'sort_order_type',
                'type'          => 'select',
                'store_range'   => '0,1,2',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '321',
                'parent_id'     => '3',
                'code'          => 'sort_order_method',
                'type'          => 'select',
                'store_range'   => '0,1',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '322',
                'parent_id'     => '3',
                'code'          => 'show_order_type',
                'type'          => 'select',
                'store_range'   => '0,1,2',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '323',
                'parent_id'     => '3',
                'code'          => 'attr_related_number',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '324',
                'parent_id'     => '3',
                'code'          => 'goods_gallery_number',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '325',
                'parent_id'     => '3',
                'code'          => 'article_title_length',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '326',
                'parent_id'     => '3',
                'code'          => 'name_of_region_1',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '327',
                'parent_id'     => '3',
                'code'          => 'name_of_region_2',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '328',
                'parent_id'     => '3',
                'code'          => 'name_of_region_3',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '329',
                'parent_id'     => '3',
                'code'          => 'name_of_region_4',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '330',
                'parent_id'     => '3',
                'code'          => 'search_keywords',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '0'
            ),
            array(
                'id'            => '332',
                'parent_id'     => '3',
                'code'          => 'related_goods_number',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '333',
                'parent_id'     => '3',
                'code'          => 'help_open',
                'type'          => 'select',
                'store_range'   => '0,1',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '334',
                'parent_id'     => '3',
                'code'          => 'article_page_size',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '335',
                'parent_id'     => '3',
                'code'          => 'page_style',
                'type'          => 'select',
                'store_range'   => '0,1',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '336',
                'parent_id'     => '3',
                'code'          => 'recommend_order',
                'type'          => 'select',
                'store_range'   => '0,1',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '337',
                'parent_id'     => '3',
                'code'          => 'index_ad',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '401',
                'parent_id'     => '4',
                'code'          => 'can_invoice',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '402',
                'parent_id'     => '4',
                'code'          => 'use_integral',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '403',
                'parent_id'     => '4',
                'code'          => 'use_bonus',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '404',
                'parent_id'     => '4',
                'code'          => 'use_surplus',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '405',
                'parent_id'     => '4',
                'code'          => 'use_how_oos',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '406',
                'parent_id'     => '4',
                'code'          => 'send_confirm_email',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '407',
                'parent_id'     => '4',
                'code'          => 'send_ship_email',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '408',
                'parent_id'     => '4',
                'code'          => 'send_cancel_email',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '409',
                'parent_id'     => '4',
                'code'          => 'send_invalid_email',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '410',
                'parent_id'     => '4',
                'code'          => 'order_pay_note',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '411',
                'parent_id'     => '4',
                'code'          => 'order_unpay_note',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '412',
                'parent_id'     => '4',
                'code'          => 'order_ship_note',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '413',
                'parent_id'     => '4',
                'code'          => 'order_receive_note',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '414',
                'parent_id'     => '4',
                'code'          => 'order_unship_note',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '415',
                'parent_id'     => '4',
                'code'          => 'order_return_note',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '416',
                'parent_id'     => '4',
                'code'          => 'order_invalid_note',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '417',
                'parent_id'     => '4',
                'code'          => 'order_cancel_note',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '418',
                'parent_id'     => '4',
                'code'          => 'invoice_content',
                'type'          => 'textarea',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '419',
                'parent_id'     => '4',
                'code'          => 'anonymous_buy',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '420',
                'parent_id'     => '4',
                'code'          => 'min_goods_amount',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '421',
                'parent_id'     => '4',
                'code'          => 'one_step_buy',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '422',
                'parent_id'     => '4',
                'code'          => 'invoice_type',
                'type'          => 'manual',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '423',
                'parent_id'     => '4',
                'code'          => 'stock_dec_time',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '424',
                'parent_id'     => '4',
                'code'          => 'cart_confirm',
                'type'          => 'options',
                'store_range'   => '1,2,3,4',
                'store_dir'     => '',
                'sort_order'    => '0'
            ),
            array(
                'id'            => '425',
                'parent_id'     => '4',
                'code'          => 'send_service_email',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '426',
                'parent_id'     => '4',
                'code'          => 'show_goods_in_cart',
                'type'          => 'select',
                'store_range'   => '1,2,3',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '427',
                'parent_id'     => '4',
                'code'          => 'show_attr_in_cart',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '501',
                'parent_id'     => '5',
                'code'          => 'smtp_host',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '502',
                'parent_id'     => '5',
                'code'          => 'smtp_port',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '503',
                'parent_id'     => '5',
                'code'          => 'smtp_user',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '504',
                'parent_id'     => '5',
                'code'          => 'smtp_pass',
                'type'          => 'password',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '505',
                'parent_id'     => '5',
                'code'          => 'smtp_mail',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '506',
                'parent_id'     => '5',
                'code'          => 'mail_charset',
                'type'          => 'select',
                'store_range'   => 'UTF8,GB2312,BIG5',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '507',
                'parent_id'     => '5',
                'code'          => 'mail_service',
                'type'          => 'select',
                'store_range'   => '0,1',
                'store_dir'     => '',
                'sort_order'    => '0'
            ),
            array(
                'id'            => '508',
                'parent_id'     => '5',
                'code'          => 'smtp_ssl',
                'type'          => 'select',
                'store_range'   => '0,1',
                'store_dir'     => '',
                'sort_order'    => '0'
            ),
            array(
                'id'            => '601',
                'parent_id'     => '6',
                'code'          => 'integrate_code',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '602',
                'parent_id'     => '6',
                'code'          => 'integrate_config',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '603',
                'parent_id'     => '6',
                'code'          => 'hash_code',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '604',
                'parent_id'     => '6',
                'code'          => 'template',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '605',
                'parent_id'     => '6',
                'code'          => 'install_date',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '606',
                'parent_id'     => '6',
                'code'          => 'ecjia_version',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '607',
                'parent_id'     => '6',
                'code'          => 'sms_user_name',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '608',
                'parent_id'     => '6',
                'code'          => 'sms_password',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '609',
                'parent_id'     => '6',
                'code'          => 'sms_auth_str',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '610',
                'parent_id'     => '6',
                'code'          => 'sms_domain',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '611',
                'parent_id'     => '6',
                'code'          => 'sms_count',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '612',
                'parent_id'     => '6',
                'code'          => 'sms_total_money',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '613',
                'parent_id'     => '6',
                'code'          => 'sms_balance',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '614',
                'parent_id'     => '6',
                'code'          => 'sms_last_request',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '616',
                'parent_id'     => '6',
                'code'          => 'affiliate',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '617',
                'parent_id'     => '6',
                'code'          => 'captcha',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '618',
                'parent_id'     => '6',
                'code'          => 'captcha_width',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '619',
                'parent_id'     => '6',
                'code'          => 'captcha_height',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '620',
                'parent_id'     => '6',
                'code'          => 'sitemap',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '0'
            ),
            array(
                'id'            => '621',
                'parent_id'     => '6',
                'code'          => 'points_rule',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '0'
            ),
            array(
                'id'            => '622',
                'parent_id'     => '6',
                'code'          => 'flash_theme',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '623',
                'parent_id'     => '6',
                'code'          => 'stylename',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '701',
                'parent_id'     => '7',
                'code'          => 'show_goodssn',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '702',
                'parent_id'     => '7',
                'code'          => 'show_brand',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '703',
                'parent_id'     => '7',
                'code'          => 'show_goodsweight',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '704',
                'parent_id'     => '7',
                'code'          => 'show_goodsnumber',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '705',
                'parent_id'     => '7',
                'code'          => 'show_addtime',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '706',
                'parent_id'     => '7',
                'code'          => 'goodsattr_style',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '707',
                'parent_id'     => '7',
                'code'          => 'show_marketprice',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '801',
                'parent_id'     => '8',
                'code'          => 'sms_shop_mobile',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '802',
                'parent_id'     => '8',
                'code'          => 'sms_order_placed',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '803',
                'parent_id'     => '8',
                'code'          => 'sms_order_payed',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '804',
                'parent_id'     => '8',
                'code'          => 'sms_order_shipped',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '901',
                'parent_id'     => '9',
                'code'          => 'wap_config',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '902',
                'parent_id'     => '9',
                'code'          => 'wap_logo',
                'type'          => 'file',
                'store_range'   => '',
                'store_dir'     => 'data/assets/',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '903',
                'parent_id'     => '2',
                'code'          => 'message_check',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '917',
                'parent_id'     => '2',
                'code'          => 'review_goods',
                'type'          => 'select',
                'store_range'   => '0,1',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '918',
                'parent_id'     => '2',
                'code'          => 'store_identity_certification',
                'type'          => 'select',
                'store_range'   => '0,1',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '920',
                'parent_id'     => '8',
                'code'          => 'sms_signin',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '927',
                'parent_id'     => '8',
                'code'          => 'sms_send',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '934',
                'parent_id'     => '6',
                'code'          => 'addon_widget_nav_menu',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '935',
                'parent_id'     => '6',
                'code'          => 'addon_widget_cat_articles',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '936',
                'parent_id'     => '6',
                'code'          => 'addon_widget_cat_goods',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '937',
                'parent_id'     => '6',
                'code'          => 'addon_widget_brand_goods',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '938',
                'parent_id'     => '6',
                'code'          => 'addon_widget_ad_position',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '939',
                'parent_id'     => '6',
                'code'          => 'addon_active_applications',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '940',
                'parent_id'     => '6',
                'code'          => 'addon_system_plugins',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '941',
                'parent_id'     => '6',
                'code'          => 'certificate_sn',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '942',
                'parent_id'     => '6',
                'code'          => 'certificate_file',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '945',
                'parent_id'     => '6',
                'code'          => 'addon_user_integrate_plugins',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '946',
                'parent_id'     => '6',
                'code'          => 'addon_active_plugins',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '947',
                'parent_id'     => '6',
                'code'          => 'ecjia_db_version',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '948',
                'parent_id'     => '6',
                'code'          => 'addon_mobile_payment_plugins',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '949',
                'parent_id'     => '6',
                'code'          => 'auth_key',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '950',
                'parent_id'     => '6',
                'code'          => 'addon_shipping_plugins',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '951',
                'parent_id'     => '6',
                'code'          => 'cycleimage_data',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '952',
                'parent_id'     => '6',
                'code'          => 'cycleimage_style',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '953',
                'parent_id'     => '6',
                'code'          => 'addon_cycleimage_plugins',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '954',
                'parent_id'     => '8',
                'code'          => 'sms_user_signin',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '955',
                'parent_id'     => '6',
                'code'          => 'captcha_style',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '956',
                'parent_id'     => '6',
                'code'          => 'addon_captcha_plugins',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '959',
                'parent_id'     => '10',
                'code'          => 'mobile_discover_data',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '960',
                'parent_id'     => '10',
                'code'          => 'mobile_shortcut_data',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '961',
                'parent_id'     => '10',
                'code'          => 'mobile_launch_adsense',
                'type'          => 'manual',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '962',
                'parent_id'     => '6',
                'code'          => 'mobile_home_adsense1',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '963',
                'parent_id'     => '6',
                'code'          => 'mobile_home_adsense2',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '973',
                'parent_id'     => '6',
                'code'          => 'navigator_data',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '974',
                'parent_id'     => '10',
                'code'          => 'mobile_recommend_city',
                'type'          => 'manual',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '975',
                'parent_id'     => '10',
                'code'          => 'mobile_cycleimage_data',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '976',
                'parent_id'     => '6',
                'code'          => 'sms_receipt_verification',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '977',
                'parent_id'     => '6',
                'code'          => 'last_check_upgrade_time',
                'type'          => '',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '980',
                'parent_id'     => '6',
                'code'          => 'app_key_android',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '981',
                'parent_id'     => '6',
                'code'          => 'app_secret_android',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '982',
                'parent_id'     => '6',
                'code'          => 'app_key_iphone',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '983',
                'parent_id'     => '6',
                'code'          => 'app_secret_iphone',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '984',
                'parent_id'     => '6',
                'code'          => 'app_key_ipad',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '985',
                'parent_id'     => '6',
                'code'          => 'app_secret_ipad',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '990',
                'parent_id'     => '6',
                'code'          => 'touch_template',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '991',
                'parent_id'     => '6',
                'code'          => 'touch_stylename',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '992',
                'parent_id'     => '10',
                'code'          => 'mobile_pc_url',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '993',
                'parent_id'     => '10',
                'code'          => 'mobile_touch_url',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '2'
            ),
            array(
                'id'            => '994',
                'parent_id'     => '10',
                'code'          => 'mobile_iphone_download',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '3'
            ),
            array(
                'id'            => '995',
                'parent_id'     => '10',
                'code'          => 'mobile_android_download',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '4'
            ),
            array(
                'id'            => '996',
                'parent_id'     => '10',
                'code'          => 'mobile_ipad_download',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '5'
            ),
            array(
                'id'            => '997',
                'parent_id'     => '10',
                'code'          => 'mobile_app_icon',
                'type'          => 'file',
                'store_range'   => '',
                'store_dir'     => 'data/assets/',
                'sort_order'    => '6'
            ),
            array(
                'id'            => '998',
                'parent_id'     => '10',
                'code'          => 'mobile_app_description',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '7'
            ),
            array(
                'id'            => '999',
                'parent_id'     => '10',
                'code'          => 'mobile_pad_login_fgcolor',
                'type'          => 'color',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1000',
                'parent_id'     => '10',
                'code'          => 'mobile_pad_login_bgcolor',
                'type'          => 'color',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1001',
                'parent_id'     => '10',
                'code'          => 'mobile_pad_login_bgimage',
                'type'          => 'file',
                'store_range'   => '',
                'store_dir'     => 'data/assets/',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1002',
                'parent_id'     => '10',
                'code'          => 'mobile_phone_login_fgcolor',
                'type'          => 'color',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1003',
                'parent_id'     => '10',
                'code'          => 'mobile_phone_login_bgcolor',
                'type'          => 'color',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1004',
                'parent_id'     => '10',
                'code'          => 'mobile_phone_login_bgimage',
                'type'          => 'file',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1005',
                'parent_id'     => '6',
                'code'          => 'merchant_admin_cpname',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1006',
                'parent_id'     => '6',
                'code'          => 'merchant_admin_login_logo',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1007',
                'parent_id'     => '6',
                'code'          => 'mobile_seller_home_adsense',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1008',
                'parent_id'     => '6',
                'code'          => 'addon_platform_plugins',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1009',
                'parent_id'     => '10',
                'code'          => 'mobile_topic_adsense',
                'type'          => 'manual',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1010',
                'parent_id'     => '6',
                'code'          => 'mobile_shopkeeper_urlscheme',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1011',
                'parent_id'     => '6',
                'code'          => 'mobile_cycleimage_phone_data',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1012',
                'parent_id'     => '6',
                'code'          => 'app_name',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1013',
                'parent_id'     => '6',
                'code'          => 'app_push_development',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1014',
                'parent_id'     => '6',
                'code'          => 'push_order_placed_apps',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1015',
                'parent_id'     => '6',
                'code'          => 'push_user_signin',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1016',
                'parent_id'     => '6',
                'code'          => 'push_order_shipped',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1017',
                'parent_id'     => '6',
                'code'          => 'push_order_payed',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1018',
                'parent_id'     => '6',
                'code'          => 'push_order_placed',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1019',
                'parent_id'     => '10',
                'code'          => 'mobile_home_adsense_group',
                'type'          => 'manual',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1021',
                'parent_id'     => '10',
                'code'          => 'mobile_iphone_qrcode',
                'type'          => 'file',
                'store_range'   => '',
                'store_dir'     => 'data/assets/',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1022',
                'parent_id'     => '10',
                'code'          => 'mobile_ipad_qrcode',
                'type'          => 'file',
                'store_range'   => '',
                'store_dir'     => 'data/assets/',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1023',
                'parent_id'     => '10',
                'code'          => 'mobile_android_qrcode',
                'type'          => 'file',
                'store_range'   => '',
                'store_dir'     => 'data/assets/',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1024',
                'parent_id'     => '2',
                'code'          => 'addon_merchant_plugins',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1032',
                'parent_id'     => '2',
                'code'          => 'invite_template',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1033',
                'parent_id'     => '2',
                'code'          => 'invite_explain',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1034',
                'parent_id'     => '10',
                'code'          => 'bonus_readme_url',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1035',
                'parent_id'     => '10',
                'code'          => 'mobile_app_name',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1036',
                'parent_id'     => '10',
                'code'          => 'mobile_app_version',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1037',
                'parent_id'     => '10',
                'code'          => 'mobile_app_preview',
                'type'          => 'manual',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1038',
                'parent_id'     => '10',
                'code'          => 'mobile_app_video',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1039',
                'parent_id'     => '6',
                'code'          => 'push_order_payed_apps',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1040',
                'parent_id'     => '6',
                'code'          => 'push_order_shipped_apps',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1043',
                'parent_id'     => '10',
                'code'          => 'mobile_shop_urlscheme',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1044',
                'parent_id'     => '2',
                'code'          => 'addon_cron_plugins',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1045',
                'parent_id'     => '10',
                'code'          => 'mobile_share_link',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1047',
                'parent_id'     => '6',
                'code'          => 'mobile_feedback_autoreply',
                'type'          => 'textarea',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1048',
                'parent_id'     => '6',
                'code'          => 'addon_connect_plugins',
                'type'          => 'hidden',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1049',
                'parent_id'     => '10',
                'code'          => 'mobile_touch_qrcode',
                'type'          => 'file',
                'store_range'   => '',
                'store_dir'     => 'data/assets/',
                'sort_order'    => '1'
            ),
            array(
                'id'            => '1051',
                'parent_id'     => '9',
                'code'          => 'map_qq_key',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '2'
            ),
            array(
                'id'            => '1053',
                'parent_id'     => '9',
                'code'          => 'map_qq_referer',
                'type'          => 'text',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '2'
            ),
            array(
                'id'            => '1054',
                'parent_id'     => '9',
                'code'          => 'wap_app_download_show',
                'type'          => 'select',
                'store_range'   => '1,0',
                'store_dir'     => '',
                'sort_order'    => '3'
            ),
            array(
                'id'            => '1055',
                'parent_id'     => '9',
                'code'          => 'wap_app_download_img',
                'type'          => 'file',
                'store_range'   => 'data/assets/',
                'store_dir'     => '',
                'sort_order'    => '4'
            ),
            array(
                'id'            => '1056',
                'parent_id'     => '10',
                'code'          => 'mobile_location_range',
                'type'          => 'select',
                'store_range'   => '',
                'store_dir'     => '',
                'sort_order'    => '1'
            )
	    );
	    
	    RC_DB::table('shop_config')->insert($data);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	    RC_DB::table('shop_config')->where('code', 'shop_info')->delete();
		RC_DB::table('shop_config')->where('code', 'basic')->delete();
		RC_DB::table('shop_config')->where('code', 'display')->delete();
		RC_DB::table('shop_config')->where('code', 'shopping_flow')->delete();
		RC_DB::table('shop_config')->where('code', 'smtp')->delete();
		RC_DB::table('shop_config')->where('code', 'hidden')->delete();
		RC_DB::table('shop_config')->where('code', 'goods')->delete();
		RC_DB::table('shop_config')->where('code', 'sms')->delete();
		RC_DB::table('shop_config')->where('code', 'wap')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile')->delete();
		RC_DB::table('shop_config')->where('code', 'shop_name')->delete();
		RC_DB::table('shop_config')->where('code', 'shop_title')->delete();
		RC_DB::table('shop_config')->where('code', 'shop_desc')->delete();
		RC_DB::table('shop_config')->where('code', 'shop_keywords')->delete();
		RC_DB::table('shop_config')->where('code', 'shop_country')->delete();
		RC_DB::table('shop_config')->where('code', 'shop_province')->delete();
		RC_DB::table('shop_config')->where('code', 'shop_city')->delete();
		RC_DB::table('shop_config')->where('code', 'shop_address')->delete();
		RC_DB::table('shop_config')->where('code', 'qq')->delete();
		RC_DB::table('shop_config')->where('code', 'ww')->delete();
		RC_DB::table('shop_config')->where('code', 'skype')->delete();
		RC_DB::table('shop_config')->where('code', 'ym')->delete();
		RC_DB::table('shop_config')->where('code', 'msn')->delete();
		RC_DB::table('shop_config')->where('code', 'service_email')->delete();
		RC_DB::table('shop_config')->where('code', 'service_phone')->delete();
		RC_DB::table('shop_config')->where('code', 'shop_closed')->delete();
		RC_DB::table('shop_config')->where('code', 'close_comment')->delete();
		RC_DB::table('shop_config')->where('code', 'shop_logo')->delete();
		RC_DB::table('shop_config')->where('code', 'licensed')->delete();
		RC_DB::table('shop_config')->where('code', 'user_notice')->delete();
		RC_DB::table('shop_config')->where('code', 'shop_notice')->delete();
		RC_DB::table('shop_config')->where('code', 'shop_reg_closed')->delete();
		RC_DB::table('shop_config')->where('code', 'company_name')->delete();
		RC_DB::table('shop_config')->where('code', 'shop_weibo_url')->delete();
		RC_DB::table('shop_config')->where('code', 'shop_wechat_qrcode')->delete();
		RC_DB::table('shop_config')->where('code', 'lang')->delete();
		RC_DB::table('shop_config')->where('code', 'icp_number')->delete();
		RC_DB::table('shop_config')->where('code', 'icp_file')->delete();
		RC_DB::table('shop_config')->where('code', 'watermark')->delete();
		RC_DB::table('shop_config')->where('code', 'watermark_place')->delete();
		RC_DB::table('shop_config')->where('code', 'watermark_alpha')->delete();
		RC_DB::table('shop_config')->where('code', 'use_storage')->delete();
		RC_DB::table('shop_config')->where('code', 'market_price_rate')->delete();
		RC_DB::table('shop_config')->where('code', 'rewrite')->delete();
		RC_DB::table('shop_config')->where('code', 'integral_name')->delete();
		RC_DB::table('shop_config')->where('code', 'integral_scale')->delete();
		RC_DB::table('shop_config')->where('code', 'integral_percent')->delete();
		RC_DB::table('shop_config')->where('code', 'sn_prefix')->delete();
		RC_DB::table('shop_config')->where('code', 'comment_check')->delete();
		RC_DB::table('shop_config')->where('code', 'no_picture')->delete();
		RC_DB::table('shop_config')->where('code', 'stats_code')->delete();
		RC_DB::table('shop_config')->where('code', 'cache_time')->delete();
		RC_DB::table('shop_config')->where('code', 'register_points')->delete();
		RC_DB::table('shop_config')->where('code', 'enable_gzip')->delete();
		RC_DB::table('shop_config')->where('code', 'top10_time')->delete();
		RC_DB::table('shop_config')->where('code', 'timezone')->delete();
		RC_DB::table('shop_config')->where('code', 'upload_size_limit')->delete();
		RC_DB::table('shop_config')->where('code', 'cron_method')->delete();
		RC_DB::table('shop_config')->where('code', 'comment_factor')->delete();
		RC_DB::table('shop_config')->where('code', 'enable_order_check')->delete();
		RC_DB::table('shop_config')->where('code', 'default_storage')->delete();
		RC_DB::table('shop_config')->where('code', 'bgcolor')->delete();
		RC_DB::table('shop_config')->where('code', 'visit_stats')->delete();
		RC_DB::table('shop_config')->where('code', 'send_mail_on')->delete();
		RC_DB::table('shop_config')->where('code', 'auto_generate_gallery')->delete();
		RC_DB::table('shop_config')->where('code', 'retain_original_img')->delete();
		RC_DB::table('shop_config')->where('code', 'member_email_validate')->delete();
		RC_DB::table('shop_config')->where('code', 'message_board')->delete();
		RC_DB::table('shop_config')->where('code', 'certificate_id')->delete();
		RC_DB::table('shop_config')->where('code', 'token')->delete();
		RC_DB::table('shop_config')->where('code', 'certi')->delete();
		RC_DB::table('shop_config')->where('code', 'send_verify_email')->delete();
		RC_DB::table('shop_config')->where('code', 'ent_id')->delete();
		RC_DB::table('shop_config')->where('code', 'ent_ac')->delete();
		RC_DB::table('shop_config')->where('code', 'ent_sign')->delete();
		RC_DB::table('shop_config')->where('code', 'ent_email')->delete();
		RC_DB::table('shop_config')->where('code', 'date_format')->delete();
		RC_DB::table('shop_config')->where('code', 'time_format')->delete();
		RC_DB::table('shop_config')->where('code', 'currency_format')->delete();
		RC_DB::table('shop_config')->where('code', 'thumb_width')->delete();
		RC_DB::table('shop_config')->where('code', 'thumb_height')->delete();
		RC_DB::table('shop_config')->where('code', 'image_width')->delete();
		RC_DB::table('shop_config')->where('code', 'image_height')->delete();
		RC_DB::table('shop_config')->where('code', 'top_number')->delete();
		RC_DB::table('shop_config')->where('code', 'history_number')->delete();
		RC_DB::table('shop_config')->where('code', 'comments_number')->delete();
		RC_DB::table('shop_config')->where('code', 'bought_goods')->delete();
		RC_DB::table('shop_config')->where('code', 'article_number')->delete();
		RC_DB::table('shop_config')->where('code', 'goods_name_length')->delete();
		RC_DB::table('shop_config')->where('code', 'price_format')->delete();
		RC_DB::table('shop_config')->where('code', 'page_size')->delete();
		RC_DB::table('shop_config')->where('code', 'sort_order_type')->delete();
		RC_DB::table('shop_config')->where('code', 'sort_order_method')->delete();
		RC_DB::table('shop_config')->where('code', 'show_order_type')->delete();
		RC_DB::table('shop_config')->where('code', 'attr_related_number')->delete();
		RC_DB::table('shop_config')->where('code', 'goods_gallery_number')->delete();
		RC_DB::table('shop_config')->where('code', 'article_title_length')->delete();
		RC_DB::table('shop_config')->where('code', 'name_of_region_1')->delete();
		RC_DB::table('shop_config')->where('code', 'name_of_region_2')->delete();
		RC_DB::table('shop_config')->where('code', 'name_of_region_3')->delete();
		RC_DB::table('shop_config')->where('code', 'name_of_region_4')->delete();
		RC_DB::table('shop_config')->where('code', 'search_keywords')->delete();
		RC_DB::table('shop_config')->where('code', 'related_goods_number')->delete();
		RC_DB::table('shop_config')->where('code', 'help_open')->delete();
		RC_DB::table('shop_config')->where('code', 'article_page_size')->delete();
		RC_DB::table('shop_config')->where('code', 'page_style')->delete();
		RC_DB::table('shop_config')->where('code', 'recommend_order')->delete();
		RC_DB::table('shop_config')->where('code', 'index_ad')->delete();
		RC_DB::table('shop_config')->where('code', 'can_invoice')->delete();
		RC_DB::table('shop_config')->where('code', 'use_integral')->delete();
		RC_DB::table('shop_config')->where('code', 'use_bonus')->delete();
		RC_DB::table('shop_config')->where('code', 'use_surplus')->delete();
		RC_DB::table('shop_config')->where('code', 'use_how_oos')->delete();
		RC_DB::table('shop_config')->where('code', 'send_confirm_email')->delete();
		RC_DB::table('shop_config')->where('code', 'send_ship_email')->delete();
		RC_DB::table('shop_config')->where('code', 'send_cancel_email')->delete();
		RC_DB::table('shop_config')->where('code', 'send_invalid_email')->delete();
		RC_DB::table('shop_config')->where('code', 'order_pay_note')->delete();
		RC_DB::table('shop_config')->where('code', 'order_unpay_note')->delete();
		RC_DB::table('shop_config')->where('code', 'order_ship_note')->delete();
		RC_DB::table('shop_config')->where('code', 'order_receive_note')->delete();
		RC_DB::table('shop_config')->where('code', 'order_unship_note')->delete();
		RC_DB::table('shop_config')->where('code', 'order_return_note')->delete();
		RC_DB::table('shop_config')->where('code', 'order_invalid_note')->delete();
		RC_DB::table('shop_config')->where('code', 'order_cancel_note')->delete();
		RC_DB::table('shop_config')->where('code', 'invoice_content')->delete();
		RC_DB::table('shop_config')->where('code', 'anonymous_buy')->delete();
		RC_DB::table('shop_config')->where('code', 'min_goods_amount')->delete();
		RC_DB::table('shop_config')->where('code', 'one_step_buy')->delete();
		RC_DB::table('shop_config')->where('code', 'invoice_type')->delete();
		RC_DB::table('shop_config')->where('code', 'stock_dec_time')->delete();
		RC_DB::table('shop_config')->where('code', 'cart_confirm')->delete();
		RC_DB::table('shop_config')->where('code', 'send_service_email')->delete();
		RC_DB::table('shop_config')->where('code', 'show_goods_in_cart')->delete();
		RC_DB::table('shop_config')->where('code', 'show_attr_in_cart')->delete();
		RC_DB::table('shop_config')->where('code', 'smtp_host')->delete();
		RC_DB::table('shop_config')->where('code', 'smtp_port')->delete();
		RC_DB::table('shop_config')->where('code', 'smtp_user')->delete();
		RC_DB::table('shop_config')->where('code', 'smtp_pass')->delete();
		RC_DB::table('shop_config')->where('code', 'smtp_mail')->delete();
		RC_DB::table('shop_config')->where('code', 'mail_charset')->delete();
		RC_DB::table('shop_config')->where('code', 'mail_service')->delete();
		RC_DB::table('shop_config')->where('code', 'smtp_ssl')->delete();
		RC_DB::table('shop_config')->where('code', 'integrate_code')->delete();
		RC_DB::table('shop_config')->where('code', 'integrate_config')->delete();
		RC_DB::table('shop_config')->where('code', 'hash_code')->delete();
		RC_DB::table('shop_config')->where('code', 'template')->delete();
		RC_DB::table('shop_config')->where('code', 'install_date')->delete();
		RC_DB::table('shop_config')->where('code', 'ecjia_version')->delete();
		RC_DB::table('shop_config')->where('code', 'sms_user_name')->delete();
		RC_DB::table('shop_config')->where('code', 'sms_password')->delete();
		RC_DB::table('shop_config')->where('code', 'sms_auth_str')->delete();
		RC_DB::table('shop_config')->where('code', 'sms_domain')->delete();
		RC_DB::table('shop_config')->where('code', 'sms_count')->delete();
		RC_DB::table('shop_config')->where('code', 'sms_total_money')->delete();
		RC_DB::table('shop_config')->where('code', 'sms_balance')->delete();
		RC_DB::table('shop_config')->where('code', 'sms_last_request')->delete();
		RC_DB::table('shop_config')->where('code', 'affiliate')->delete();
		RC_DB::table('shop_config')->where('code', 'captcha')->delete();
		RC_DB::table('shop_config')->where('code', 'captcha_width')->delete();
		RC_DB::table('shop_config')->where('code', 'captcha_height')->delete();
		RC_DB::table('shop_config')->where('code', 'sitemap')->delete();
		RC_DB::table('shop_config')->where('code', 'points_rule')->delete();
		RC_DB::table('shop_config')->where('code', 'flash_theme')->delete();
		RC_DB::table('shop_config')->where('code', 'stylename')->delete();
		RC_DB::table('shop_config')->where('code', 'show_goodssn')->delete();
		RC_DB::table('shop_config')->where('code', 'show_brand')->delete();
		RC_DB::table('shop_config')->where('code', 'show_goodsweight')->delete();
		RC_DB::table('shop_config')->where('code', 'show_goodsnumber')->delete();
		RC_DB::table('shop_config')->where('code', 'show_addtime')->delete();
		RC_DB::table('shop_config')->where('code', 'goodsattr_style')->delete();
		RC_DB::table('shop_config')->where('code', 'show_marketprice')->delete();
		RC_DB::table('shop_config')->where('code', 'sms_shop_mobile')->delete();
		RC_DB::table('shop_config')->where('code', 'sms_order_placed')->delete();
		RC_DB::table('shop_config')->where('code', 'sms_order_payed')->delete();
		RC_DB::table('shop_config')->where('code', 'sms_order_shipped')->delete();
		RC_DB::table('shop_config')->where('code', 'wap_config')->delete();
		RC_DB::table('shop_config')->where('code', 'wap_logo')->delete();
		RC_DB::table('shop_config')->where('code', 'message_check')->delete();
		RC_DB::table('shop_config')->where('code', 'review_goods')->delete();
		RC_DB::table('shop_config')->where('code', 'store_identity_certification')->delete();
		RC_DB::table('shop_config')->where('code', 'sms_signin')->delete();
		RC_DB::table('shop_config')->where('code', 'sms_send')->delete();
		RC_DB::table('shop_config')->where('code', 'addon_widget_nav_menu')->delete();
		RC_DB::table('shop_config')->where('code', 'addon_widget_cat_articles')->delete();
		RC_DB::table('shop_config')->where('code', 'addon_widget_cat_goods')->delete();
		RC_DB::table('shop_config')->where('code', 'addon_widget_brand_goods')->delete();
		RC_DB::table('shop_config')->where('code', 'addon_widget_ad_position')->delete();
		RC_DB::table('shop_config')->where('code', 'addon_active_applications')->delete();
		RC_DB::table('shop_config')->where('code', 'addon_system_plugins')->delete();
		RC_DB::table('shop_config')->where('code', 'certificate_sn')->delete();
		RC_DB::table('shop_config')->where('code', 'certificate_file')->delete();
		RC_DB::table('shop_config')->where('code', 'addon_user_integrate_plugins')->delete();
		RC_DB::table('shop_config')->where('code', 'addon_active_plugins')->delete();
		RC_DB::table('shop_config')->where('code', 'ecjia_db_version')->delete();
		RC_DB::table('shop_config')->where('code', 'addon_mobile_payment_plugins')->delete();
		RC_DB::table('shop_config')->where('code', 'auth_key')->delete();
		RC_DB::table('shop_config')->where('code', 'addon_shipping_plugins')->delete();
		RC_DB::table('shop_config')->where('code', 'cycleimage_data')->delete();
		RC_DB::table('shop_config')->where('code', 'cycleimage_style')->delete();
		RC_DB::table('shop_config')->where('code', 'addon_cycleimage_plugins')->delete();
		RC_DB::table('shop_config')->where('code', 'sms_user_signin')->delete();
		RC_DB::table('shop_config')->where('code', 'captcha_style')->delete();
		RC_DB::table('shop_config')->where('code', 'addon_captcha_plugins')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_discover_data')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_shortcut_data')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_launch_adsense')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_home_adsense1')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_home_adsense2')->delete();
		RC_DB::table('shop_config')->where('code', 'navigator_data')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_recommend_city')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_cycleimage_data')->delete();
		RC_DB::table('shop_config')->where('code', 'sms_receipt_verification')->delete();
		RC_DB::table('shop_config')->where('code', 'last_check_upgrade_time')->delete();
		RC_DB::table('shop_config')->where('code', 'app_key_android')->delete();
		RC_DB::table('shop_config')->where('code', 'app_secret_android')->delete();
		RC_DB::table('shop_config')->where('code', 'app_key_iphone')->delete();
		RC_DB::table('shop_config')->where('code', 'app_secret_iphone')->delete();
		RC_DB::table('shop_config')->where('code', 'app_key_ipad')->delete();
		RC_DB::table('shop_config')->where('code', 'app_secret_ipad')->delete();
		RC_DB::table('shop_config')->where('code', 'touch_template')->delete();
		RC_DB::table('shop_config')->where('code', 'touch_stylename')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_pc_url')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_touch_url')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_iphone_download')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_android_download')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_ipad_download')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_app_icon')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_app_description')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_pad_login_fgcolor')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_pad_login_bgcolor')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_pad_login_bgimage')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_phone_login_fgcolor')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_phone_login_bgcolor')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_phone_login_bgimage')->delete();
		RC_DB::table('shop_config')->where('code', 'merchant_admin_cpname')->delete();
		RC_DB::table('shop_config')->where('code', 'merchant_admin_login_logo')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_seller_home_adsense')->delete();
		RC_DB::table('shop_config')->where('code', 'addon_platform_plugins')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_topic_adsense')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_shopkeeper_urlscheme')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_cycleimage_phone_data')->delete();
		RC_DB::table('shop_config')->where('code', 'app_name')->delete();
		RC_DB::table('shop_config')->where('code', 'app_push_development')->delete();
		RC_DB::table('shop_config')->where('code', 'push_order_placed_apps')->delete();
		RC_DB::table('shop_config')->where('code', 'push_user_signin')->delete();
		RC_DB::table('shop_config')->where('code', 'push_order_shipped')->delete();
		RC_DB::table('shop_config')->where('code', 'push_order_payed')->delete();
		RC_DB::table('shop_config')->where('code', 'push_order_placed')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_home_adsense_group')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_iphone_qrcode')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_ipad_qrcode')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_android_qrcode')->delete();
		RC_DB::table('shop_config')->where('code', 'addon_merchant_plugins')->delete();
		RC_DB::table('shop_config')->where('code', 'invite_template')->delete();
		RC_DB::table('shop_config')->where('code', 'invite_explain')->delete();
		RC_DB::table('shop_config')->where('code', 'bonus_readme_url')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_app_name')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_app_version')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_app_preview')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_app_video')->delete();
		RC_DB::table('shop_config')->where('code', 'push_order_payed_apps')->delete();
		RC_DB::table('shop_config')->where('code', 'push_order_shipped_apps')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_shop_urlscheme')->delete();
		RC_DB::table('shop_config')->where('code', 'addon_cron_plugins')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_share_link')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_feedback_autoreply')->delete();
		RC_DB::table('shop_config')->where('code', 'addon_connect_plugins')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_touch_qrcode')->delete();
		RC_DB::table('shop_config')->where('code', 'map_qq_key')->delete();
		RC_DB::table('shop_config')->where('code', 'map_qq_referer')->delete();
		RC_DB::table('shop_config')->where('code', 'wap_app_download_show')->delete();
		RC_DB::table('shop_config')->where('code', 'wap_app_download_img')->delete();
		RC_DB::table('shop_config')->where('code', 'mobile_location_range')->delete();
	}

}
