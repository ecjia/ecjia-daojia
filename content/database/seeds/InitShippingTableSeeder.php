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
 * 插入数据 `ecjia_shipping` 配送方式
 */
use Royalcms\Component\Database\Seeder;

class InitShippingTableSeeder extends Seeder
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
                'shipping_id'       => '15',
                'shipping_code'     => 'ship_ems',
                'shipping_name'     => 'EMS 国内邮政特快专递',
                'shipping_desc'     => 'EMS 国内邮政特快专递描述内容 <cite>By ECJIA TEAM.</cite>',
                'insure'            => '0',
                'support_cod'       => '1',
                'enabled'           => '1',
                'shipping_print'    => '',
                'print_bg'          => '',
                'config_lable'      => 't_shop_name,网店-名称,236,32,182,161,b_shop_name||,||t_shop_tel,网店-联系电话,127,21,295,135,b_shop_tel||,||t_shop_address,网店-地址,296,68,124,190,b_shop_address||,||t_pigeon,√-对号,21,21,192,278,b_pigeon||,||t_customer_name,收件人-姓名,107,23,494,136,b_customer_name||,||t_customer_tel,收件人-电话,155,21,639,124,b_customer_tel||,||t_customer_mobel,收件人-手机,159,21,639,147,b_customer_mobel||,||t_customer_post,收件人-邮编,88,21,680,258,b_customer_post||,||t_year,年-当日日期,37,21,534,379,b_year||,||t_months,月-当日日期,29,21,592,379,b_months||,||t_day,日-当日日期,27,21,642,380,b_day||,||t_order_best_time,送货时间-订单,104,39,688,359,b_order_best_time||,||t_order_postscript,备注-订单,305,34,485,402,b_order_postscript||,||t_customer_address,收件人-详细地址,289,48,503,190,b_customer_address||,||',
                'print_model'       => '2',
                'shipping_order'    => '2'
            ),
            array(
                'shipping_id'       => '16',
                'shipping_code'     => 'ship_yto',
                'shipping_name'     => '圆通速递',
                'shipping_desc'     => '上海圆通物流（速递）有限公司经过多年的网络快速发展，在中国速递行业中一直处于领先地位。为了能更好的发展国际快件市场，加快与国际市场的接轨，强化圆通的整体实力，圆通已在东南亚、欧美、中东、北美洲、非洲等许多城市运作国际快件业务 <cite>By ECJIA TEAM.</cite>',
                'insure'            => '0',
                'support_cod'       => '1',
                'enabled'           => '1',
                'shipping_print'    => '',
                'print_bg'          => '',
                'config_lable'      => 't_shop_province,网店-省份,132,24,279.6,105.7,b_shop_province||,||t_shop_name,网店-名称,268,29,142.95,133.85,b_shop_name||,||t_shop_address,网店-地址,346,40,67.3,199.95,b_shop_address||,||t_shop_city,网店-城市,64,35,223.8,163.95,b_shop_city||,||t_shop_district,网店-区/县,56,35,314.9,164.25,b_shop_district||,||t_pigeon,√-对号,21,21,143.1,263.2,b_pigeon||,||t_customer_name,收件人-姓名,89,25,488.65,121.05,b_customer_name||,||t_customer_tel,收件人-电话,136,21,656,110.6,b_customer_tel||,||t_customer_mobel,收件人-手机,137,21,655.6,132.8,b_customer_mobel||,||t_customer_province,收件人-省份,115,24,480.2,173.5,b_customer_province||,||t_customer_city,收件人-城市,60,27,609.3,172.5,b_customer_city||,||t_customer_district,收件人-区/县,58,28,696.8,173.25,b_customer_district||,||t_customer_post,收件人-邮编,93,21,701.1,240.25,b_customer_post||,||',
                'print_model'       => '2',
                'shipping_order'    => '0'
            ),
            array(
                'shipping_id'       => '17',
                'shipping_code'     => 'ship_cac',
                'shipping_name'     => '上门取货',
                'shipping_desc'     => '买家自己到商家指定地点取货 <cite>By ECJIA TEAM.</cite>',
                'insure'            => '0',
                'support_cod'       => '1',
                'enabled'           => '1',
                'shipping_print'    => '',
                'print_bg'          => '',
                'config_lable'      => '',
                'print_model'       => '2',
                'shipping_order'    => '0'
            ),
            array(
                'shipping_id'       => '18',
                'shipping_code'     => 'ship_flat',
                'shipping_name'     => '市内快递',
                'shipping_desc'     => '固定运费的配送方式内容 <cite>By ECJIA TEAM.</cite>',
                'insure'            => '0',
                'support_cod'       => '1',
                'enabled'           => '1',
                'shipping_print'    => '',
                'print_bg'          => '',
                'config_lable'      => '',
                'print_model'       => '2',
                'shipping_order'    => '0'
            ),
            array(
                'shipping_id'       => '19',
                'shipping_code'     => 'ship_zto',
                'shipping_name'     => '中通速递',
                'shipping_desc'     => '中通快递的相关说明。保价费按照申报价值的2％交纳，但是，保价费不低于100元，保价金额不得高于10000元，保价金额超过10000元的，超过的部分无效 <cite>By ECJIA TEAM.</cite>',
                'insure'            => '2%',
                'support_cod'       => '1',
                'enabled'           => '1',
                'shipping_print'    => '',
                'print_bg'          => '',
                'config_lable'      => 't_shop_province,网店-省份,116,30,296.55,117.2,b_shop_province||,||t_customer_province,收件人-省份,114,32,649.95,114.3,b_customer_province||,||t_shop_address,网店-地址,260,57,151.75,152.05,b_shop_address||,||t_shop_name,网店-名称,259,28,152.65,212.4,b_shop_name||,||t_shop_tel,网店-联系电话,131,37,138.65,246.5,b_shop_tel||,||t_customer_post,收件人-邮编,104,39,659.2,242.2,b_customer_post||,||t_customer_tel,收件人-电话,158,22,461.9,241.9,b_customer_tel||,||t_customer_mobel,收件人-手机,159,21,463.25,265.4,b_customer_mobel||,||t_customer_name,收件人-姓名,109,32,498.9,115.8,b_customer_name||,||t_customer_address,收件人-详细地址,264,58,499.6,150.1,b_customer_address||,||t_months,月-当日日期,35,23,135.85,392.8,b_months||,||t_day,日-当日日期,24,23,180.1,392.8,b_day||,||',
                'print_model'       => '2',
                'shipping_order'    => '0'
            ),
            array(
                'shipping_id'       => '20',
                'shipping_code'     => 'ship_fpd',
                'shipping_name'     => '运费到付',
                'shipping_desc'     => '所购商品到达即付运费 <cite>By ECJIA TEAM.</cite>',
                'insure'            => '0',
                'support_cod'       => '1',
                'enabled'           => '1',
                'shipping_print'    => '',
                'print_bg'          => '',
                'config_lable'      => '',
                'print_model'       => '2',
                'shipping_order'    => '0'
            ),
            array(
                'shipping_id'       => '21',
                'shipping_code'     => 'ship_o2o_express',
                'shipping_name'     => 'o2o速递',
                'shipping_desc'     => 'o2o速递 <cite>By ECJIA TEAM.</cite>',
                'insure'            => '0',
                'support_cod'       => '1',
                'enabled'           => '1',
                'shipping_print'    => '',
                'print_bg'          => '',
                'config_lable'      => '',
                'print_model'       => '2',
                'shipping_order'    => '0'
            ),
            array(
                'shipping_id'       => '22',
                'shipping_code'     => 'ship_sf_express',
                'shipping_name'     => '顺丰速运',
                'shipping_desc'     => '江、浙、沪地区首重15元/KG，续重2元/KG，其余城市首重20元/KG <cite>By ECJIA TEAM.</cite>',
                'insure'            => '0',
                'support_cod'       => '1',
                'enabled'           => '1',
                'shipping_print'    => '',
                'print_bg'          => '',
                'config_lable'      => 't_shop_name,网店-名称,150,29,112,137,b_shop_name||,||t_shop_address,网店-地址,268,55,105,168,b_shop_address||,||t_shop_tel,网店-联系电话,55,25,177,224,b_shop_tel||,||t_customer_name,收件人-姓名,78,23,299,265,b_customer_name||,||t_customer_address,收件人-详细地址,271,94,104,293,b_customer_address||,||',
                'print_model'       => '2',
                'shipping_order'    => '0'
            ),
            array(
                'shipping_id'       => '23',
                'shipping_code'     => 'ship_sto_express',
                'shipping_name'     => '申通快递',
                'shipping_desc'     => '江、浙、沪地区首重为15元/KG，其他地区18元/KG， 续重均为5-6元/KG， 云南地区为8元 <cite>By ECJIA TEAM.</cite>',
                'insure'            => '0',
                'support_cod'       => '0',
                'enabled'           => '1',
                'shipping_print'    => '',
                'print_bg'          => '',
                'config_lable'      => 't_shop_address,网店-地址,235,48,131,152,b_shop_address||,||t_shop_name,网店-名称,237,26,131,200,b_shop_name||,||t_shop_tel,网店-联系电话,96,36,144,257,b_shop_tel||,||t_customer_post,收件人-邮编,86,23,578,268,b_customer_post||,||t_customer_address,收件人-详细地址,232,49,434,149,b_customer_address||,||t_customer_name,收件人-姓名,151,27,449,231,b_customer_name||,||t_customer_tel,收件人-电话,90,32,452,261,b_customer_tel||,||',
                'print_model'       => '2',
                'shipping_order'    => '0'
            )
        );

        RC_DB::table('shipping')->truncate();
        RC_DB::table('shipping')->insert($data);
    }
}